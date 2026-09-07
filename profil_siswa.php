<?php
session_start();

// 1. Proteksi Halaman: Hanya Siswa yang boleh akses
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// 2. Data Siswa dari Session
$namaSiswa = $_SESSION['nama'] ?? 'Siswa';
$nis = $_SESSION['nis'] ?? '-';
$kelas = $_SESSION['kelas'] ?? '-';

// 3. Baca Data Lengkap Siswa dari JSON
$data_siswa_file = __DIR__ . '/data_siswa.json';
$data_siswa = [];
if (file_exists($data_siswa_file)) {
    $semuaSiswa = json_decode(file_get_contents($data_siswa_file), true) ?: [];
    foreach ($semuaSiswa as $s) {
        if ($s['nis'] === $nis) {
            $data_siswa = $s;
            break;
        }
    }
}

// 4. Baca Data Absensi untuk Statistik
$data_absensi_file = __DIR__ . '/data_absensi.json';
$absensiSaya = [];
if (file_exists($data_absensi_file)) {
    $semuaAbsensi = json_decode(file_get_contents($data_absensi_file), true) ?: [];
    $absensiSaya = array_values(array_filter($semuaAbsensi, fn($r) => $r['nis'] === $nis));
}

// Hitung statistik
$totalPertemuan = count($absensiSaya);
$totalHadir = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Hadir'));
$totalIzin = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Izin'));
$totalSakit = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Sakit'));
$totalAlpa = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Alpa'));
$persentaseHadir = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 1) : 0;

// Urutkan absensi terbaru
usort($absensiSaya, function($a, $b) {
    return strtotime($b['tanggal'] . ' ' . $b['waktu']) - strtotime($a['tanggal'] . ' ' . $a['waktu']);
});

// 5. Data Wali Kelas
$waliKelas = [
    'X PPLG 1' => 'SITI HALUMA SADA, S.Pd.',
    'X PPLG 2' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.',
    'X TJKT 1' => 'NOVIM CICI HERBAVIANA, S.Kom, Gr.',
    'X TJKT 2' => 'ADE SHILVI VERAWATI, S.T.',
    'X PM 1' => 'MAX ARENS WALALAYO, S.Pd',
    'X PM 2' => 'CITRA KUMALASARI, M.Pd',
    'X MPLB 1' => 'PUTY CHANDRA DARMAJANTI, M.Pd',
    'X MPLB 2' => 'KATMIRAH, S.Pd',
    'X AKL 1' => 'DIAN NOVIA PURWANDARI, S.Pd',
    'X AKL 2' => 'RIZKY KUSUMA DEWI, S.Pd',
    'X AKL 3' => 'ERWYN FRIANDRIAS, S.Pd.',
    'X PH 1' => 'TAMIM ZUHRI, S.Pd',
    'X PH 2' => 'REYNI DESITA, S.IP.',
    'X PH 3' => 'TUTIK HARIYANI, S.Pd',
    'X KL 1' => 'DINI ANGGA MAHARANI, S.Pd',
    'X DKV 1' => 'ENI KHOIRIYAH, S.Pd',
    'X DKV 2' => 'WIDYAWATI, S.E',
    'X SP 1' => 'ANY EKA NUR HIDAYATI, S.Pd.',
    'X SP 2' => 'TITIS VIDYA NURINA, S.PD',
    'X BDP 1' => 'LILIK ERNAWATI, S.S.',
    'X BDP 2' => 'AGUS SUPRANTIYONO, S.Pd',
    'X ULP 1' => 'MOH. YUSRON, S.Pd.',
    'X ULP 2' => 'YUDI WAHYU PRABASANGKA., S.E',
    'XI PPLG 1' => 'DWI ANGGRIAWAN, S.Pd',
    'XI PPLG 2' => 'TRI SUKESI SULISTYOWATI, M.Pd.',
    'XI TJKT 1' => 'SAHLAN, S.Kom.',
    'XI TJKT 2' => 'HEPI SETIAWAN, S.Pd.',
    'XI PM 1' => 'ANGGUN SETYANINGTYAS, S.Pd',
    'XI PM 2' => 'LUDFY YANA, S.Pd',
    'XI MPLB 1' => 'ELIA ROSA, S.Pd.',
    'XI MPLB 2' => 'M. YUSUF, M.Pd',
    'XI AKL 1' => 'YUSTA RIANDA, S.Pd.',
    'XI AKL 2' => 'MOHAMAD NOR SHODIQ, S.Pd',
    'XI AKL 3' => 'M. DIGDAYA KHARISMA W., S.Pd.',
    'XI PH 1' => 'HASBY MAULIDZANA AL-AMIN, M.Pd.',
    'XI PH 2' => 'SUHARTATIK, S.Pd',
    'XI PH 3' => 'KHOIRUN NISA MAULIDYAH. S.Pd, Gr',
    'XI KL 1' => 'ANUNGGILING TYAS ADI R., S.Pd',
    'XI DKV 1' => 'SHEILA NURVATISNA, S.Pd.',
    'XI DKV 2' => 'SHIELDA SELINA, S.Pd.',
    'XI SP 1' => 'SITI ISTIQOMAH, S.Pd.I.',
    'XI BDP 1' => 'MUNTAMAH KHOIR, S.Pd',
    'XI BDP 2' => 'ENDANG WIJIATI, S.Pd., M.Pd',
    'XI ULP 1' => 'TIURMA SRIULINA BR. SILAEN',
    'XI ULP 2' => 'RETNO DAMAYANTI, S.PdI',
];
$waliKelasSaya = $waliKelas[$kelas] ?? 'Belum Ditentukan';

// 6. Proses Ubah Password
$pesanPassword = '';
$tipePesanPassword = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah_password'])) {
    $passwordLama = $_POST['password_lama'] ?? '';
    $passwordBaru = $_POST['password_baru'] ?? '';
    $konfirmasi = $_POST['konfirmasi_password'] ?? '';
    
    if (empty($passwordLama) || empty($passwordBaru) || empty($konfirmasi)) {
        $pesanPassword = 'Semua field wajib diisi!';
        $tipePesanPassword = 'error';
    } elseif ($passwordLama !== $nis) {
        $pesanPassword = 'Password lama salah! (Password default = NIS Anda)';
        $tipePesanPassword = 'error';
    } elseif (strlen($passwordBaru) < 6) {
        $pesanPassword = 'Password baru minimal 6 karakter!';
        $tipePesanPassword = 'error';
    } elseif ($passwordBaru !== $konfirmasi) {
        $pesanPassword = 'Konfirmasi password tidak cocok!';
        $tipePesanPassword = 'error';
    } else {
        // Update password di data_siswa.json
        if (!empty($data_siswa) && file_exists($data_siswa_file)) {
            foreach ($semuaSiswa as &$s) {
                if ($s['nis'] === $nis) {
                    $s['password'] = $passwordBaru;
                    break;
                }
            }
            if (file_put_contents($data_siswa_file, json_encode($semuaSiswa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                $pesanPassword = 'Password berhasil diubah!';
                $tipePesanPassword = 'success';
            } else {
                $pesanPassword = 'Gagal mengubah password.';
                $tipePesanPassword = 'error';
            }
        }
    }
}

// Helper untuk menentukan level kehadiran
function getLevelKehadiran($persen) {
    if ($persen >= 90) return ['label' => 'Sangat Baik', 'color' => 'text-green-600', 'bg' => 'bg-green-100', 'emoji' => '🌟'];
    if ($persen >= 75) return ['label' => 'Bagus', 'color' => 'text-blue-600', 'bg' => 'bg-blue-100', 'emoji' => '✓'];
    if ($persen >= 50) return ['label' => 'Cukup', 'color' => 'text-yellow-600', 'bg' => 'bg-yellow-100', 'emoji' => '⚠'];
    return ['label' => 'Perlu Perhatian', 'color' => 'text-red-600', 'bg' => 'bg-red-100', 'emoji' => '✗'];
}
$level = getLevelKehadiran($persentaseHadir);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-[260px] bg-gradient-to-b from-[#0B1121] to-[#161d31] text-gray-300 flex flex-col flex-shrink-0 h-full shadow-2xl hidden md:flex">
            <div class="h-20 flex items-center px-6 border-b border-white/5">
                <div class="bg-blue-600 shadow-lg shadow-blue-600/30 text-white p-2 rounded-xl mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-[16px] tracking-tight">SmartPresence</h1>
                    <p class="text-[10px] text-blue-400 font-medium uppercase tracking-widest">Portal Siswa</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="dashboard_siswa.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="jadwal_siswa.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Jadwal Saya
                        </a>
                        <a href="riwayat_kehadiran.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Riwayat Kehadiran
                        </a>
                    </nav>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Akun</p>
                    <nav class="space-y-1">
                        <a href="profil_siswa.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>
                        <a href="?action=logout" class="flex items-center px-4 py-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl text-sm font-medium transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </a>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col h-screen overflow-y-auto">
            <!-- HEADER -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-gray-800">Profil Saya</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($namaSiswa) ?></p>
                        <p class="text-xs text-gray-500"><?= htmlspecialchars($kelas) ?></p>
                    </div>
                    <div class="w-10 h-10 gradient-primary text-white rounded-full flex items-center justify-center font-bold shadow-md">
                        <?= strtoupper(substr($namaSiswa, 0, 1)) ?>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 flex-1">
                <!-- NOTIFIKASI PASSWORD -->
                <?php if ($pesanPassword): ?>
                <div id="notif" class="mb-6 p-4 rounded-xl flex items-center justify-between <?= $tipePesanPassword === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'; ?>">
                    <p class="font-semibold text-sm"><?= $pesanPassword ?></p>
                    <button onclick="document.getElementById('notif').remove()" class="text-lg font-bold hover:opacity-70">×</button>
                </div>
                <?php endif; ?>

                <!-- PROFILE CARD -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <!-- Banner -->
                    <div class="gradient-primary h-40 relative">
                        <div class="absolute inset-0 opacity-10">
                            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <path d="M0,0 L100,0 L100,100 L0,100 Z M20,20 Q50,50 80,20 T80,80 Q50,50 20,80 Z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="px-8 pb-8 -mt-16 relative">
                        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                            <div class="flex items-end gap-5">
                                <div class="w-32 h-32 gradient-primary text-white rounded-2xl flex items-center justify-center font-bold text-5xl shadow-xl border-4 border-white">
                                    <?= strtoupper(substr($namaSiswa, 0, 1)) ?>
                                </div>
                                <div class="pb-2">
                                    <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($namaSiswa) ?></h1>
                                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                        <span class="bg-purple-100 text-purple-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                                            <?= htmlspecialchars($kelas) ?>
                                        </span>
                                        <span class="text-gray-400">•</span>
                                        <span class="font-mono text-xs">NIS: <?= htmlspecialchars($nis) ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="riwayat_kehadiran.php" class="bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    Riwayat Kehadiran
                                </a>
                                <a href="?action=logout" class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRID INFO -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- INFO PRIBADI -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-blue-50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Pribadi
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NIS</p>
                                    <p class="font-semibold text-gray-900 font-mono"><?= htmlspecialchars($data_siswa['nis'] ?? $nis) ?></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</p>
                                    <p class="font-semibold text-gray-900"><?= htmlspecialchars($data_siswa['nama'] ?? $namaSiswa) ?></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kelas</p>
                                    <p class="font-semibold text-gray-900"><?= htmlspecialchars($data_siswa['kelas'] ?? $kelas) ?></p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                                    <p class="font-semibold text-gray-900">
                                        <span class="<?= ($data_siswa['jk'] ?? '') === 'Laki-laki' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' ?> px-2.5 py-0.5 rounded-full text-xs">
                                            <?= htmlspecialchars($data_siswa['jk'] ?? '-') ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 md:col-span-2">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Wali Kelas</p>
                                    <p class="font-semibold text-gray-900">👨‍🏫 <?= htmlspecialchars($waliKelasSaya) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STATISTIK KEHADIRAN -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Kehadiran Saya
                            </h3>
                        </div>
                        <div class="p-6">
                            <!-- Persentase -->
                            <div class="text-center mb-5">
                                <div class="relative w-32 h-32 mx-auto">
                                    <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="42" stroke="#e5e7eb" stroke-width="8" fill="none"/>
                                        <circle cx="50" cy="50" r="42" 
                                            stroke="<?= $persentaseHadir >= 75 ? '#10b981' : ($persentaseHadir >= 50 ? '#f59e0b' : '#ef4444') ?>" 
                                            stroke-width="8" fill="none" 
                                            stroke-dasharray="<?= $persentaseHadir * 2.64 ?> 264"
                                            stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <p class="text-3xl font-bold text-gray-900"><?= $persentaseHadir ?>%</p>
                                        <p class="text-xs text-gray-500">Hadir</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="<?= $level['bg'] ?> <?= $level['color'] ?> px-3 py-1 rounded-full text-xs font-bold">
                                        <?= $level['emoji'] ?> <?= $level['label'] ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Detail -->
                            <div class="space-y-2">
                                <div class="flex justify-between items-center p-2.5 bg-green-50 rounded-lg">
                                    <span class="text-sm text-gray-700">✓ Hadir</span>
                                    <span class="font-bold text-green-600"><?= $totalHadir ?></span>
                                </div>
                                <div class="flex justify-between items-center p-2.5 bg-blue-50 rounded-lg">
                                    <span class="text-sm text-gray-700">I Izin</span>
                                    <span class="font-bold text-blue-600"><?= $totalIzin ?></span>
                                </div>
                                <div class="flex justify-between items-center p-2.5 bg-yellow-50 rounded-lg">
                                    <span class="text-sm text-gray-700">S Sakit</span>
                                    <span class="font-bold text-yellow-600"><?= $totalSakit ?></span>
                                </div>
                                <div class="flex justify-between items-center p-2.5 bg-red-50 rounded-lg">
                                    <span class="text-sm text-gray-700">A Alpa</span>
                                    <span class="font-bold text-red-600"><?= $totalAlpa ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRID BAWAH -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- ABSENSI TERBARU -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-800">📋 Absensi Terbaru</h3>
                            <a href="riwayat_kehadiran.php" class="text-sm text-purple-600 font-medium hover:text-purple-800">Lihat Semua →</a>
                        </div>
                        <div class="overflow-x-auto">
                            <?php if (empty($absensiSaya)): ?>
                            <div class="p-10 text-center">
                                <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Belum ada riwayat absensi</p>
                            </div>
                            <?php else: ?>
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                                        <th class="px-6 py-3 font-semibold">Mapel</th>
                                        <th class="px-6 py-3 font-semibold text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach (array_slice($absensiSaya, 0, 5) as $absen): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-3">
                                            <div class="font-medium text-gray-900 text-sm"><?= date('d M Y', strtotime($absen['tanggal'])) ?></div>
                                            <div class="text-xs text-gray-400"><?= $absen['waktu'] ?> WIB</div>
                                        </td>
                                        <td class="px-6 py-3 font-medium text-gray-900 text-sm"><?= htmlspecialchars($absen['mapel']) ?></td>
                                        <td class="px-6 py-3 text-center">
                                            <?php
                                            $statusColors = [
                                                'Hadir' => 'bg-green-100 text-green-700',
                                                'Izin' => 'bg-blue-100 text-blue-700',
                                                'Sakit' => 'bg-yellow-100 text-yellow-700',
                                                'Alpa' => 'bg-red-100 text-red-700'
                                            ];
                                            $status = $absen['status'];
                                            $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
                                            ?>
                                            <span class="<?= $color ?> px-3 py-1 rounded-full text-xs font-bold">
                                                <?= $status ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- UBAH PASSWORD -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-red-50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Ubah Password
                            </h3>
                        </div>
                        <form method="POST" class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Lama</label>
                                <input type="password" name="password_lama" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru</label>
                                <input type="password" name="password_baru" required minlength="6" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" required minlength="6" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                            </div>
                            <button type="submit" name="ubah_password" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 rounded-xl transition-all text-sm shadow-lg shadow-purple-500/30">
                                Simpan Password
                            </button>
                            <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl">
                                <p class="text-[11px] text-blue-800">
                                    💡 <b>Info:</b> Password default Anda adalah <b>NIS</b>. Segera ubah untuk keamanan.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="mt-6 text-center text-xs text-gray-400">
                    <p>© 2026 SmartPresence - SMKN 1 Banyuwangi</p>
                    <p class="mt-1">Jika ada kesalahan data, silakan hubungi wali kelas atau administrator.</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Auto hide notifikasi
        setTimeout(() => {
            const notif = document.getElementById('notif');
            if (notif) {
                notif.style.transition = 'opacity 0.5s';
                notif.style.opacity = '0';
                setTimeout(() => notif.remove(), 500);
            }
        }, 4000);
    </script>
</body>
</html>