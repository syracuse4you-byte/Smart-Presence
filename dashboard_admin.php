<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// === BACA DATA SISWA ===
$data_siswa_file = __DIR__ . '/data_siswa.json';
$data_siswa = [];
if (file_exists($data_siswa_file)) {
    $data_siswa = json_decode(file_get_contents($data_siswa_file), true) ?: [];
}
$total_siswa = count($data_siswa);

// === BACA DATA ABSENSI ===
$data_absensi_file = __DIR__ . '/data_absensi.json';
$data_absensi = [];
if (file_exists($data_absensi_file)) {
    $data_absensi = json_decode(file_get_contents($data_absensi_file), true) ?: [];
}

// === STATISTIK HARI INI ===
$hariIni = date('Y-m-d');
$absensiHariIni = array_filter($data_absensi, fn($r) => $r['tanggal'] === $hariIni);

$total_hadir = count(array_filter($absensiHariIni, fn($r) => $r['status'] === 'Hadir'));
$total_izin = count(array_filter($absensiHariIni, fn($r) => $r['status'] === 'Izin'));
$total_sakit = count(array_filter($absensiHariIni, fn($r) => $r['status'] === 'Sakit'));
$total_alpa = count(array_filter($absensiHariIni, fn($r) => $r['status'] === 'Alpa'));

// === AKTIVITAS TERBARU (Dikelompokkan per sesi absensi) ===
// Kelompokkan berdasarkan id_absen (satu sesi absensi = satu kelas + mapel + waktu)
$aktivitasGrouped = [];
foreach ($data_absensi as $row) {
    $key = $row['id_absen'] ?? ($row['kelas'] . '|' . $row['mapel'] . '|' . $row['tanggal'] . '|' . $row['waktu']);
    if (!isset($aktivitasGrouped[$key])) {
        $aktivitasGrouped[$key] = [
            'id_absen' => $row['id_absen'] ?? $key,
            'kelas' => $row['kelas'],
            'mapel' => $row['mapel'],
            'guru' => $row['guru'] ?? '-',
            'tanggal' => $row['tanggal'],
            'waktu' => $row['waktu'],
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'total' => 0
        ];
    }
    $aktivitasGrouped[$key]['total']++;
    switch ($row['status']) {
        case 'Hadir':
            $aktivitasGrouped[$key]['hadir']++;
            break;
        case 'Izin':
            $aktivitasGrouped[$key]['izin']++;
            break;
        case 'Sakit':
            $aktivitasGrouped[$key]['sakit']++;
            break;
        case 'Alpa':
            $aktivitasGrouped[$key]['alpa']++;
            break;
    }
}

// Urutkan berdasarkan tanggal & waktu terbaru
usort($aktivitasGrouped, function ($a, $b) {
    $timeA = strtotime($a['tanggal'] . ' ' . $a['waktu']);
    $timeB = strtotime($b['tanggal'] . ' ' . $b['waktu']);
    return $timeB - $timeA;
});

// Ambil 5 aktivitas terbaru
$aktivitasTerbaru = array_slice($aktivitasGrouped, 0, 5);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-[260px] bg-gradient-to-b from-[#0B1121] to-[#161d31] text-gray-300 flex flex-col flex-shrink-0 h-full shadow-2xl">
            <div class="h-20 flex items-center px-6 border-b border-white/5">
                <div class="bg-blue-600 shadow-lg shadow-blue-600/30 text-white p-2 rounded-xl mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-[16px] tracking-tight">SmartPresence</h1>
                    <p class="text-[10px] text-blue-400 font-medium uppercase tracking-widest">Sistem Absensi</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="dashboard_admin.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="data_siswa.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Data Siswa
                        </a>
                        <a href="jadwal.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Jadwal
                        </a>
                        <a href="rekap_absensi_admin.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                            </svg>
                            Rekap Absensi
                        </a>
                        <a href="riwayat_login.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Riwayat Login
                        </a>
                    </nav>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Lainnya</p>
                    <nav class="space-y-1">

                        <a href="notifikasi.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            Notifikasi
                        </a>
                        <a href="kelola_request.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Kelola Request
                            <?php
                            $req_file = __DIR__ . '/data_requests.json';
                            $pending_count = 0;
                            if (file_exists($req_file)) {
                                $reqs = json_decode(file_get_contents($req_file), true) ?: [];
                                $pending_count = count(array_filter($reqs, fn($r) => $r['status'] === 'pending'));
                            }
                            if ($pending_count > 0):
                            ?>
                                <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full animate-pulse"><?= $pending_count ?></span>
                            <?php endif; ?>
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
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 lg:px-10 z-10">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Overview</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900">Administrator</p>
                        <p class="text-xs text-gray-500">SMKN 1 Banyuwangi</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold border border-blue-200">A</div>
                </div>
            </header>

            <div class="p-6 lg:p-10 flex-1">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Selamat datang, Admin! 👋</h1>
                    <p class="text-gray-500 mt-1">Berikut adalah ringkasan absensi siswa hari ini (<?= date('d F Y') ?>).</p>
                </div>

                <!-- STATISTIK CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="bg-blue-50 p-4 rounded-xl text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                            <p class="text-2xl font-bold text-gray-900"><?= $total_siswa ?></p>
                            <p class="text-xs text-gray-400 mt-0.5"><?= $total_siswa > 0 ? 'Terdaftar di sistem' : 'Belum ada data' ?></p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="bg-green-50 p-4 rounded-xl text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Hadir (Hari Ini)</p>
                            <p class="text-2xl font-bold text-green-600"><?= $total_hadir ?></p>
                            <p class="text-xs text-gray-400 mt-0.5"><?= date('d M Y') ?></p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Izin / Sakit</p>
                            <p class="text-2xl font-bold text-yellow-600"><?= $total_izin + $total_sakit ?></p>
                            <p class="text-xs text-gray-400 mt-0.5">Izin: <?= $total_izin ?> • Sakit: <?= $total_sakit ?></p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="bg-red-50 p-4 rounded-xl text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alpa</p>
                            <p class="text-2xl font-bold text-red-600"><?= $total_alpa ?></p>
                            <p class="text-xs text-gray-400 mt-0.5">Tanpa keterangan</p>
                        </div>
                    </div>
                </div>

                <!-- AKTIVITAS ABSENSI TERBARU -->
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Aktivitas Absensi Terbaru</h3>
                    <a href="rekap_absensi_admin.php" class="text-sm text-blue-600 font-medium hover:text-blue-800 inline-flex items-center gap-1">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <?php if (empty($aktivitasTerbaru)): ?>
                    <div class="p-12 text-center">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-700 mb-1">Belum Ada Aktivitas</h4>
                        <p class="text-sm text-gray-500 max-w-md mx-auto">
                            Data absensi siswa belum tersedia. Guru dapat melakukan absensi melalui menu <span class="font-semibold text-blue-600">Absensi Kelas</span>.
                        </p>
                        <div class="mt-6 flex justify-center gap-3">
                            <a href="data_siswa.php" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Kelola Data Siswa
                            </a>
                            <a href="jadwal.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-5 py-2.5 rounded-xl transition-all inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Lihat Jadwal
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Waktu</th>
                                    <th class="px-6 py-4 font-semibold">Kelas</th>
                                    <th class="px-6 py-4 font-semibold">Mata Pelajaran</th>
                                    <th class="px-6 py-4 font-semibold">Guru</th>
                                    <th class="px-6 py-4 font-semibold text-center">Total</th>
                                    <th class="px-6 py-4 font-semibold">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($aktivitasTerbaru as $aktivitas): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900"><?= date('d M Y', strtotime($aktivitas['tanggal'])) ?></div>
                                            <div class="text-xs text-gray-400"><?= date('H:i', strtotime($aktivitas['waktu'])) ?> WIB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                <?= htmlspecialchars($aktivitas['kelas']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($aktivitas['mapel']) ?></td>
                                        <td class="px-6 py-4 text-gray-600 text-xs max-w-[200px] truncate" title="<?= htmlspecialchars($aktivitas['guru']) ?>">
                                            <?= htmlspecialchars($aktivitas['guru']) ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-bold">
                                                <?= $aktivitas['total'] ?> siswa
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1.5 flex-wrap">
                                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                    ✓ H: <?= $aktivitas['hadir'] ?>
                                                </span>
                                                <?php if ($aktivitas['izin'] > 0): ?>
                                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                        I: <?= $aktivitas['izin'] ?>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($aktivitas['sakit'] > 0): ?>
                                                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                        S: <?= $aktivitas['sakit'] ?>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($aktivitas['alpa'] > 0): ?>
                                                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                        A: <?= $aktivitas['alpa'] ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
    </div>
    </main>
    </div>
</body>

</html>