<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

$namaSiswa = $_SESSION['nama'] ?? 'Siswa';
$nis = $_SESSION['nis'] ?? '-';
$kelas = $_SESSION['kelas'] ?? '-';

$data_absensi_file = __DIR__ . '/data_absensi.json';
$semuaAbsensi = [];
if (file_exists($data_absensi_file)) {
    $semuaAbsensi = json_decode(file_get_contents($data_absensi_file), true) ?: [];
}

$absensiSaya = array_filter($semuaAbsensi, fn($r) => $r['nis'] === $nis);

usort($absensiSaya, function($a, $b) {
    return strtotime($b['tanggal'] . ' ' . $b['waktu']) - strtotime($a['tanggal'] . ' ' . $a['waktu']);
});

$totalPertemuan = count($absensiSaya);
$totalHadir = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Hadir'));
$totalIzin = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Izin'));
$totalSakit = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Sakit'));
$totalAlpa = count(array_filter($absensiSaya, fn($r) => $r['status'] === 'Alpa'));
$persentaseHadir = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 1) : 0;

$jadwalPerKelas = [
    'X PPLG 1' => [
        'Senin' => [
            ['jam' => '07:30 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.', 'ruang' => 'B.10'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom', 'ruang' => 'B.10'],
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
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.', 'ruang' => 'B.10'],
        ],
    ],
    'XI PPLG 1' => [
        'Senin' => [
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
            ['jam' => '07:45 - 11:00', 'mapel' => 'Pengembangan Gim', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom', 'ruang' => 'B.2'],
        ],
    ],
];

$jadwalHariIni = $jadwalPerKelas[$kelas] ?? [];

$hariIndonesia = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$hariIni = $hariIndonesia[date('N')];
$tanggalHariIni = date('d F Y');

$jadwalHariIniKhusus = $jadwalHariIni[$hariIni] ?? [];

$waliKelas = [
    'X PPLG 1' => 'SITI HALUMA SADA, S.Pd.',
    'XI PPLG 1' => 'DWI ANGGRIAWAN, S.Pd',
];
$waliKelasSaya = $waliKelas[$kelas] ?? 'Belum Ditentukan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
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
                        <a href="dashboard_siswa.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <main class="flex-1 flex flex-col h-screen overflow-y-auto">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0">
                <div class="flex items-center gap-3">
                    <button class="md:hidden p-2 text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
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
                <div class="mb-8 gradient-primary rounded-2xl p-6 text-white shadow-lg shadow-purple-500/20 relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <p class="text-purple-100 text-sm font-medium"><?= $hariIni ?>, <?= $tanggalHariIni ?></p>
                        <h1 class="text-2xl font-bold mt-1">Halo, <?= htmlspecialchars(explode(',', $namaSiswa)[0]) ?>! 👋</h1>
                        <p class="text-purple-100 mt-2 max-w-xl">Selamat datang di portal kehadiranmu. Pantau terus kehadiran dan jadwalmu di sini ya!</p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl border border-white/30">
                                <p class="text-[10px] text-purple-100 uppercase tracking-wider">Kelas</p>
                                <p class="font-bold"><?= htmlspecialchars($kelas) ?></p>
                            </div>
                            <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl border border-white/30">
                                <p class="text-[10px] text-purple-100 uppercase tracking-wider">NIS</p>
                                <p class="font-bold font-mono"><?= htmlspecialchars($nis) ?></p>
                            </div>
                            <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl border border-white/30">
                                <p class="text-[10px] text-purple-100 uppercase tracking-wider">Wali Kelas</p>
                                <p class="font-bold text-xs"><?= htmlspecialchars($waliKelasSaya) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Statistik Kehadiran Saya
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-gray-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                                    </svg>
                                </div>
                                <span class="text-[10px] text-gray-400 font-semibold uppercase">Total</span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900"><?= $totalPertemuan ?></p>
                            <p class="text-xs text-gray-500 mt-1">Pertemuan</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-green-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-[10px] text-green-500 font-semibold uppercase">Hadir</span>
                            </div>
                            <p class="text-2xl font-bold text-green-600"><?= $totalHadir ?></p>
                            <p class="text-xs text-gray-500 mt-1">Kehadiran</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-[10px] text-blue-500 font-semibold uppercase">Izin</span>
                            </div>
                            <p class="text-2xl font-bold text-blue-600"><?= $totalIzin ?></p>
                            <p class="text-xs text-gray-500 mt-1">Izin resmi</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-yellow-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-yellow-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                </div>
                                <span class="text-[10px] text-yellow-600 font-semibold uppercase">Sakit</span>
                            </div>
                            <p class="text-2xl font-bold text-yellow-600"><?= $totalSakit ?></p>
                            <p class="text-xs text-gray-500 mt-1">Sakit</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-red-100 hover:shadow-md transition-shadow col-span-2 lg:col-span-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-red-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <span class="text-[10px] text-red-500 font-semibold uppercase">Alpa</span>
                            </div>
                            <p class="text-2xl font-bold text-red-600"><?= $totalAlpa ?></p>
                            <p class="text-xs text-gray-500 mt-1">Tanpa keterangan</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
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

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-purple-50 to-blue-50">
                            <div>
                                <h3 class="font-bold text-gray-800">📅 Jadwal Hari Ini</h3>
                                <p class="text-xs text-gray-500 mt-0.5"><?= $hariIni ?>, <?= $tanggalHariIni ?></p>
                            </div>
                            <a href="jadwal_saya.php" class="text-sm text-purple-600 font-medium hover:text-purple-800">Lihat Semua →</a>
                        </div>
                        <div class="p-4">
                            <?php if (empty($jadwalHariIniKhusus)): ?>
                            <div class="text-center py-8">
                                <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Jadwal untuk kelas <b><?= htmlspecialchars($kelas) ?></b> belum tersedia.</p>
                                <p class="text-xs text-gray-400 mt-1">Hubungi administrator jika ada pertanyaan.</p>
                            </div>
                            <?php else: ?>
                            <div class="space-y-2">
                                <?php foreach ($jadwalHariIniKhusus as $i => $pelajaran): ?>
                                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-purple-50 transition-colors border border-transparent hover:border-purple-100">
                                    <div class="text-center min-w-[70px] bg-purple-100 rounded-lg py-2 px-3">
                                        <p class="text-[10px] font-bold text-purple-600 uppercase">Jam</p>
                                        <p class="text-xs font-bold text-purple-800"><?= $pelajaran['jam'] ?></p>
                                    </div>
                                    <div class="h-10 w-px bg-gray-200"></div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($pelajaran['mapel']) ?></p>
                                        <p class="text-xs text-gray-500 mt-0.5">👨‍🏫 <?= htmlspecialchars($pelajaran['guru']) ?></p>
                                    </div>
                                    <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                        📍 <?= htmlspecialchars($pelajaran['ruang']) ?>
                                    </span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                            <h3 class="font-bold text-gray-800">🎯 Ringkasan Bulan Ini</h3>
                            <p class="text-xs text-gray-500 mt-0.5"><?= date('F Y') ?></p>
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Hadir</span>
                                </div>
                                <span class="font-bold text-green-600"><?= $totalHadir ?>x</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Tidak Hadir</span>
                                </div>
                                <span class="font-bold text-yellow-600"><?= ($totalIzin + $totalSakit + $totalAlpa) ?>x</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Izin</span>
                                </div>
                                <span class="font-bold text-blue-600"><?= $totalIzin ?>x</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Sakit</span>
                                </div>
                                <span class="font-bold text-pink-600"><?= $totalSakit ?>x</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <div>
                            <h3 class="font-bold text-gray-800">📋 Riwayat Kehadiran Terbaru</h3>
                            <p class="text-xs text-gray-500 mt-0.5">5 absensi terakhir kamu</p>
                        </div>
                        <a href="riwayat_kehadiran.php" class="text-sm text-purple-600 font-medium hover:text-purple-800">Lihat Semua →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <?php if (empty($absensiSaya)): ?>
                        <div class="p-12 text-center">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Belum ada riwayat kehadiran</p>
                            <p class="text-xs text-gray-400 mt-1">Data kehadiran akan muncul setelah guru melakukan absensi.</p>
                        </div>
                        <?php else: ?>
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Tanggal</th>
                                    <th class="px-6 py-3 font-semibold">Mata Pelajaran</th>
                                    <th class="px-6 py-3 font-semibold">Guru</th>
                                    <th class="px-6 py-3 font-semibold text-center">Status</th>
                                    <th class="px-6 py-3 font-semibold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach (array_slice($absensiSaya, 0, 5) as $absen): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900"><?= date('d M Y', strtotime($absen['tanggal'])) ?></div>
                                        <div class="text-xs text-gray-400"><?= $absen['waktu'] ?> WIB</div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($absen['mapel']) ?></td>
                                    <td class="px-6 py-4 text-xs text-gray-600"><?= htmlspecialchars($absen['guru']) ?></td>
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
                                    <td class="px-6 py-4 text-xs text-gray-600"><?= htmlspecialchars($absen['keterangan'] ?? '-') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">⚡ Aksi Cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <a href="jadwal_saya.php" class="flex flex-col items-center gap-2 p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition-all group">
                            <div class="bg-purple-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Jadwal Saya</span>
                        </a>
                        <a href="riwayat_kehadiran.php" class="flex flex-col items-center gap-2 p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all group">
                            <div class="bg-green-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Riwayat Kehadiran</span>
                        </a>
                        <a href="profil_siswa.php" class="flex flex-col items-center gap-2 p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all group">
                            <div class="bg-blue-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Profil Saya</span>
                        </a>
                        <a href="?action=logout" class="flex flex-col items-center gap-2 p-4 bg-red-50 hover:bg-red-100 rounded-xl transition-all group">
                            <div class="bg-red-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Logout</span>
                        </a>
                    </div>
                </div>

                <div class="mt-6 text-center text-xs text-gray-400">
                    <p>© 2026 SmartPresence - SMKN 1 Banyuwangi</p>
                    <p class="mt-1">Sistem Absensi Siswa Terpadu</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>