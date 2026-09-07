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

// 3. Baca Data Absensi
$data_absensi_file = __DIR__ . '/data_absensi.json';
$semuaAbsensi = [];
if (file_exists($data_absensi_file)) {
    $semuaAbsensi = json_decode(file_get_contents($data_absensi_file), true) ?: [];
}

// Filter absensi milik siswa ini
$absensiSaya = array_values(array_filter($semuaAbsensi, fn($r) => $r['nis'] === $nis));

// 4. Filter dari URL
$filterBulan = $_GET['bulan'] ?? '';
$filterMapel = $_GET['mapel'] ?? '';
$filterStatus = $_GET['status'] ?? '';

// Terapkan filter
$dataFiltered = $absensiSaya;

if ($filterBulan) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => date('Y-m', strtotime($r['tanggal'])) === $filterBulan);
}
if ($filterMapel) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => $r['mapel'] === $filterMapel);
}
if ($filterStatus) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => $r['status'] === $filterStatus);
}

// Urutkan dari terbaru
usort($dataFiltered, function($a, $b) {
    return strtotime($b['tanggal'] . ' ' . $b['waktu']) - strtotime($a['tanggal'] . ' ' . $a['waktu']);
});

// 5. Hitung Statistik (berdasarkan data terfilter)
$totalData = count($dataFiltered);
$totalHadir = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Hadir'));
$totalIzin = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Izin'));
$totalSakit = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Sakit'));
$totalAlpa = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Alpa'));
$persentaseHadir = $totalData > 0 ? round(($totalHadir / $totalData) * 100, 1) : 0;

// Ambil daftar mapel unik untuk filter
$daftarMapel = array_unique(array_column($absensiSaya, 'mapel'));
sort($daftarMapel);

// Ambil daftar bulan unik untuk filter
$daftarBulan = [];
foreach ($absensiSaya as $absen) {
    $bulan = date('Y-m', strtotime($absen['tanggal']));
    $daftarBulan[$bulan] = date('F Y', strtotime($absen['tanggal']));
}
krsort($daftarBulan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kehadiran - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        @media print {
            .no-print { display: none !important; }
            aside { display: none !important; }
            main { width: 100% !important; }
            body { background: white; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-[260px] bg-gradient-to-b from-[#0B1121] to-[#161d31] text-gray-300 flex flex-col flex-shrink-0 h-full shadow-2xl hidden md:flex no-print">
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
                        <a href="riwayat_kehadiran.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Riwayat Kehadiran
                        </a>
                    </nav>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Akun</p>
                    <nav class="space-y-1">
                        <a href="profil_siswa.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300">
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
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0 no-print">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-gray-800">Riwayat Kehadiran</h2>
                </div>
                <div class="flex items-center gap-4">
                    <button onclick="window.print()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak
                    </button>
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
                <!-- HEADER LAPORAN (untuk print) -->
                <div class="hidden print:block mb-6 text-center">
                    <h1 class="text-2xl font-bold">LAPORAN RIWAYAT KEHADIRAN SISWA</h1>
                    <p class="text-sm">SMKN 1 BANYUWANGI - Tahun Ajaran 2026/2027</p>
                    <div class="mt-4 text-left max-w-md mx-auto">
                        <table class="w-full text-sm">
                            <tr><td class="py-1 font-semibold">Nama</td><td class="py-1">: <?= htmlspecialchars($namaSiswa) ?></td></tr>
                            <tr><td class="py-1 font-semibold">NIS</td><td class="py-1">: <?= htmlspecialchars($nis) ?></td></tr>
                            <tr><td class="py-1 font-semibold">Kelas</td><td class="py-1">: <?= htmlspecialchars($kelas) ?></td></tr>
                        </table>
                    </div>
                    <p class="text-sm mt-3">Dicetak pada: <?= date('d F Y, H:i') ?> WIB</p>
                    <hr class="mt-4 border-t-2 border-black">
                </div>

                <!-- INFO SISWA -->
                <div class="mb-6 gradient-primary rounded-2xl p-6 text-white shadow-lg shadow-purple-500/20 relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="relative flex flex-wrap justify-between items-center gap-4">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Riwayat Kehadiran</p>
                            <h1 class="text-2xl font-bold mt-1"><?= htmlspecialchars($namaSiswa) ?></h1>
                            <p class="text-purple-100 mt-1 text-sm">NIS: <span class="font-mono font-semibold"><?= htmlspecialchars($nis) ?></span> • Kelas: <span class="font-semibold"><?= htmlspecialchars($kelas) ?></span></p>
                        </div>
                        <div class="bg-white/20 backdrop-blur px-5 py-3 rounded-xl border border-white/30 text-center">
                            <p class="text-[10px] text-purple-100 uppercase tracking-wider">Total Pertemuan</p>
                            <p class="text-3xl font-bold"><?= $totalData ?></p>
                        </div>
                    </div>
                </div>

                <!-- STATISTIK CARDS -->
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-gray-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-500 uppercase">Total</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900"><?= $totalData ?></p>
                        <p class="text-xs text-gray-400 mt-1">Pertemuan</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 uppercase">Hadir</span>
                        </div>
                        <p class="text-2xl font-bold text-green-600"><?= $totalHadir ?></p>
                        <p class="text-xs text-gray-400 mt-1">Kehadiran</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 uppercase">Izin</span>
                        </div>
                        <p class="text-2xl font-bold text-blue-600"><?= $totalIzin ?></p>
                        <p class="text-xs text-gray-400 mt-1">Izin resmi</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-yellow-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-yellow-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-yellow-600 uppercase">Sakit</span>
                        </div>
                        <p class="text-2xl font-bold text-yellow-600"><?= $totalSakit ?></p>
                        <p class="text-xs text-gray-400 mt-1">Sakit</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-red-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-red-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-red-600 uppercase">Alpa</span>
                        </div>
                        <p class="text-2xl font-bold text-red-600"><?= $totalAlpa ?></p>
                        <p class="text-xs text-gray-400 mt-1">Tanpa keterangan</p>
                    </div>
                </div>

                <!-- PERSENTASE KEHADIRAN -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <h3 class="font-bold text-gray-800">Persentase Kehadiran</h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                <?php if ($persentaseHadir >= 90): ?>
                                    <span class="text-green-600 font-semibold">🌟 Sangat Baik!</span> Pertahankan kehadiranmu!
                                <?php elseif ($persentaseHadir >= 75): ?>
                                    <span class="text-blue-600 font-semibold">✓ Bagus!</span> Terus tingkatkan ya!
                                <?php elseif ($persentaseHadir >= 50): ?>
                                    <span class="text-yellow-600 font-semibold">⚠ Cukup</span> Ayo tingkatkan kehadiranmu!
                                <?php else: ?>
                                    <span class="text-red-600 font-semibold">✗ Perlu Perhatian</span> Segera perbaiki kehadiranmu!
                                <?php endif; ?>
                            </p>
                        </div>
                        <p class="text-3xl font-bold <?= $persentaseHadir >= 75 ? 'text-green-600' : ($persentaseHadir >= 50 ? 'text-yellow-600' : 'text-red-600') ?>">
                            <?= $persentaseHadir ?>%
                        </p>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-1000 <?= $persentaseHadir >= 75 ? 'bg-gradient-to-r from-green-400 to-green-600' : ($persentaseHadir >= 50 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : 'bg-gradient-to-r from-red-400 to-red-600') ?>" style="width: <?= $persentaseHadir ?>%"></div>
                    </div>
                </div>

                <!-- FILTER -->
                <form method="GET" class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6 no-print">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Bulan</label>
                            <select name="bulan" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                                <option value="">Semua Bulan</option>
                                <?php foreach ($daftarBulan as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= $filterBulan === $val ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Mata Pelajaran</label>
                            <select name="mapel" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                                <option value="">Semua Mapel</option>
                                <?php foreach ($daftarMapel as $m): ?>
                                    <option value="<?= htmlspecialchars($m) ?>" <?= $filterMapel === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status</label>
                            <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                                <option value="">Semua Status</option>
                                <option value="Hadir" <?= $filterStatus === 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                                <option value="Izin" <?= $filterStatus === 'Izin' ? 'selected' : '' ?>>Izin</option>
                                <option value="Sakit" <?= $filterStatus === 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                                <option value="Alpa" <?= $filterStatus === 'Alpa' ? 'selected' : '' ?>>Alpa</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 rounded-xl text-sm transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Filter
                            </button>
                            <a href="riwayat_kehadiran.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-3 rounded-xl text-sm transition-all" title="Reset">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </a>
                        </div>
                    </div>
                </form>

                <!-- TABEL RIWAYAT -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <p class="text-sm text-gray-600">
                            Menampilkan <span class="font-bold text-gray-900"><?= $totalData ?></span> data kehadiran
                            <?php if ($filterBulan || $filterMapel || $filterStatus): ?>
                                <span class="text-purple-600">(difilter)</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <?php if (empty($dataFiltered)): ?>
                    <div class="p-12 text-center">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-700 mb-1">Belum Ada Data Kehadiran</h4>
                        <p class="text-sm text-gray-500 max-w-md mx-auto">
                            <?php if (empty($absensiSaya)): ?>
                                Data kehadiranmu akan muncul di sini setelah guru melakukan absensi.
                            <?php else: ?>
                                Tidak ada data yang cocok dengan filter yang dipilih. Coba ubah filter Anda.
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">No</th>
                                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th class="px-6 py-4 font-semibold">Jam</th>
                                    <th class="px-6 py-4 font-semibold">Mata Pelajaran</th>
                                    <th class="px-6 py-4 font-semibold">Guru Pengajar</th>
                                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                                    <th class="px-6 py-4 font-semibold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($dataFiltered as $i => $absen): ?>
                                <tr class="hover:bg-purple-50/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-500"><?= $i + 1 ?></td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900"><?= date('d M Y', strtotime($absen['tanggal'])) ?></div>
                                        <div class="text-xs text-gray-400"><?= date('l', strtotime($absen['tanggal'])) ?></div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-600"><?= $absen['waktu'] ?> WIB</td>
                                    <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($absen['mapel']) ?></td>
                                    <td class="px-6 py-4 text-xs text-gray-600"><?= htmlspecialchars($absen['guru'] ?? '-') ?></td>
                                    <td class="px-6 py-4 text-center">
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
                                    <td class="px-6 py-4 text-xs text-gray-600 max-w-[200px] truncate" title="<?= htmlspecialchars($absen['keterangan'] ?? '-') ?>">
                                        <?= htmlspecialchars($absen['keterangan'] ?? '-') ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- FOOTER LAPORAN (untuk print) -->
                <div class="hidden print:block mt-12 text-sm">
                    <div class="flex justify-end">
                        <div class="text-center">
                            <p>Banyuwangi, <?= date('d F Y') ?></p>
                            <p class="font-semibold">Orang Tua / Wali Siswa</p>
                            <br><br><br>
                            <p class="font-semibold underline">(.....................................)</p>
                        </div>
                    </div>
                </div>

                <!-- INFO -->
                <div class="mt-6 bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl p-5 border border-purple-100 no-print">
                    <div class="flex items-start gap-3">
                        <div class="bg-purple-100 p-2 rounded-lg flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p class="font-semibold text-gray-900 mb-1">Informasi Kehadiran</p>
                            <ul class="space-y-0.5 text-xs">
                                <li>• Data kehadiran diperbarui secara real-time oleh guru pengajar</li>
                                <li>• Jika ada kesalahan data, segera hubungi wali kelas atau guru pengajar</li>
                                <li>• Persentase kehadiran minimal 75% untuk mengikuti ujian</li>
                                <li>• Gunakan tombol <b>Cetak</b> untuk mencetak laporan kehadiran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>