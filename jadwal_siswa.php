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

// 3. Filter Hari
$hariFilter = $_GET['hari'] ?? 'semua';
$hariIndonesia = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$hariIni = $hariIndonesia[date('N')];

// 4. Data Jadwal Lengkap (dari PDF)
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

// Jadwal XI PPLG 1 (contoh lengkap)
$jadwalPerKelas = [
    'XI PPLG 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'guru' => '-', 'ruang' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.', 'ruang' => 'B.2'],
            ['jam' => '10:45 - 15:15', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'ACHRIYATUL SETYORINI, S.ST.', 'ruang' => 'B.2'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'ACHRIYATUL SETYORINI, S.ST.', 'ruang' => 'B.2'],
            ['jam' => '09:15 - 13:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.', 'ruang' => 'B.2'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'MELANOKE PRAMANIK, S.Kom.', 'ruang' => 'B.2'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.', 'ruang' => 'B.2'],
            ['jam' => '09:15 - 13:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.', 'ruang' => 'B.2'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pengembangan Gim', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom', 'ruang' => 'B.2'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 10:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'MELANOKE PRAMANIK, S.Kom.', 'ruang' => 'B.2'],
            ['jam' => '10:00 - 13:45', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'ACHRIYATUL SETYORINI, S.ST.', 'ruang' => 'B.2'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Rekayasa Perangkat Lunak', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.', 'ruang' => 'B.2'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'guru' => '-', 'ruang' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Pengembangan Gim', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom', 'ruang' => 'B.2'],
        ],
    ],
    'X PPLG 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'guru' => '-', 'ruang' => '-'],
            ['jam' => '07:30 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.', 'ruang' => 'B.10'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.', 'ruang' => 'B.10'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.', 'ruang' => 'B.10'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom', 'ruang' => 'B.10'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'guru' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.', 'ruang' => 'B.10'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.', 'ruang' => 'B.10'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom', 'ruang' => 'B.10'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'guru' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.', 'ruang' => 'B.10'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'guru' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.', 'ruang' => 'B.10'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.', 'ruang' => 'B.10'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'MELANOKE PRAMANIK, S.Kom.', 'ruang' => 'B.10'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'guru' => '-', 'ruang' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.', 'ruang' => 'B.10'],
        ],
    ],
];

// Default jadwal jika kelas tidak ditemukan
$jadwalKelas = $jadwalPerKelas[$kelas] ?? null;
$waliKelasSaya = $waliKelas[$kelas] ?? 'Belum Ditentukan';

// Hitung total jam per minggu
$totalJam = 0;
if ($jadwalKelas) {
    foreach ($jadwalKelas as $hari => $sessions) {
        $totalJam += count($sessions);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Saya - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hari-aktif { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
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
                        <a href="jadwal_siswa.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-gray-800">Jadwal Pelajaran</h2>
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
                <!-- INFO KELAS -->
                <div class="mb-6 gradient-primary rounded-2xl p-6 text-white shadow-lg shadow-purple-500/20 relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="relative flex flex-wrap justify-between items-start gap-4">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Kelas Saya</p>
                            <h1 class="text-3xl font-bold mt-1"><?= htmlspecialchars($kelas) ?></h1>
                            <p class="text-purple-100 mt-2">Wali Kelas: <span class="font-semibold text-white"><?= htmlspecialchars($waliKelasSaya) ?></span></p>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl border border-white/30 text-center">
                                <p class="text-[10px] text-purple-100 uppercase tracking-wider">Total Jam</p>
                                <p class="text-2xl font-bold"><?= $totalJam ?></p>
                                <p class="text-[10px] text-purple-100">per minggu</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl border border-white/30 text-center">
                                <p class="text-[10px] text-purple-100 uppercase tracking-wider">Hari Ini</p>
                                <p class="text-2xl font-bold"><?= $hariIni ?></p>
                                <p class="text-[10px] text-purple-100"><?= date('d M Y') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FILTER HARI -->
                <div class="mb-6 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex flex-wrap gap-2">
                        <a href="?hari=semua" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all <?= $hariFilter === 'semua' ? 'hari-aktif' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                            Semua Hari
                        </a>
                        <?php foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari): ?>
                        <a href="?hari=<?= $hari ?>" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all <?= $hariFilter === $hari ? 'hari-aktif' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?> <?= $hari === $hariIni ? 'ring-2 ring-purple-400 ring-offset-2' : '' ?>">
                            <?= $hari ?>
                            <?php if ($hari === $hariIni): ?>
                                <span class="ml-1 text-[10px] bg-white/30 px-1.5 py-0.5 rounded-full">Hari Ini</span>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- JADWAL -->
                <?php if (!$jadwalKelas): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-700 mb-2">Jadwal Belum Tersedia</h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto">
                        Jadwal untuk kelas <b><?= htmlspecialchars($kelas) ?></b> belum tersedia di sistem. Silakan hubungi administrator atau wali kelas Anda.
                    </p>
                </div>
                <?php else: ?>
                    <div class="space-y-6">
                        <?php 
                        $hariList = ($hariFilter === 'semua') ? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] : [$hariFilter];
                        foreach ($hariList as $hari): 
                            if (!isset($jadwalKelas[$hari])) continue;
                            $sessions = $jadwalKelas[$hari];
                        ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden <?= $hari === $hariIni && $hariFilter === 'semua' ? 'ring-2 ring-purple-500' : '' ?>">
                            <!-- Header Hari -->
                            <div class="px-6 py-4 flex justify-between items-center <?= $hari === $hariIni ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white' : 'bg-gray-50 border-b border-gray-100' ?>">
                                <div class="flex items-center gap-3">
                                    <div class="<?= $hari === $hariIni ? 'bg-white/20' : 'bg-purple-100' ?> p-2 rounded-lg">
                                        <svg class="w-5 h-5 <?= $hari === $hariIni ? 'text-white' : 'text-purple-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg"><?= $hari ?></h3>
                                        <?php if ($hari === $hariIni): ?>
                                        <p class="text-xs text-purple-100">Hari Ini • <?= count($sessions) ?> pelajaran</p>
                                        <?php else: ?>
                                        <p class="text-xs text-gray-500"><?= count($sessions) ?> pelajaran</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($hari === $hariIni): ?>
                                <span class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold border border-white/30">
                                    📍 Hari Ini
                                </span>
                                <?php endif; ?>
                            </div>

                            <!-- Daftar Pelajaran -->
                            <div class="divide-y divide-gray-100">
                                <?php foreach ($sessions as $i => $pelajaran): ?>
                                <div class="px-6 py-4 flex items-center gap-4 hover:bg-purple-50/30 transition-colors">
                                    <!-- Nomor -->
                                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 text-purple-700 rounded-full flex items-center justify-center font-bold text-sm">
                                        <?= $i + 1 ?>
                                    </div>

                                    <!-- Jam -->
                                    <div class="flex-shrink-0 min-w-[130px] text-center bg-gray-50 rounded-lg py-2 px-3 border border-gray-100">
                                        <p class="text-[10px] font-bold text-gray-500 uppercase">Jam Pelajaran</p>
                                        <p class="text-sm font-bold text-purple-700"><?= $pelajaran['jam'] ?></p>
                                    </div>

                                    <!-- Info Pelajaran -->
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 truncate"><?= htmlspecialchars($pelajaran['mapel']) ?></p>
                                        <p class="text-xs text-gray-500 mt-0.5 truncate">
                                            👨‍🏫 <?= htmlspecialchars($pelajaran['guru']) ?>
                                        </p>
                                    </div>

                                    <!-- Ruang -->
                                    <?php if ($pelajaran['ruang'] !== '-'): ?>
                                    <div class="flex-shrink-0">
                                        <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold border border-blue-100">
                                            📍 <?= htmlspecialchars($pelajaran['ruang']) ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- INFO TAMBAHAN -->
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border border-purple-100">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1">Informasi Penting</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Jadwal dapat berubah sewaktu-waktu sesuai kebijakan sekolah</li>
                                <li>• Harap datang 10 menit sebelum pelajaran dimulai</li>
                                <li>• Jika ada perubahan jadwal, akan diinformasikan oleh wali kelas</li>
                                <li>• Tahun Ajaran 2026/2027 - Semester Ganjil</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>