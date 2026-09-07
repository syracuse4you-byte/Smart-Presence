<?php
session_start();
// Proteksi: Hanya admin yang bisa akses
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$data_absensi_file = __DIR__ . '/data_absensi.json';
$data_siswa_file = __DIR__ . '/data_siswa.json';

// Baca data absensi
$semuaAbsensi = [];
if (file_exists($data_absensi_file)) {
    $semuaAbsensi = json_decode(file_get_contents($data_absensi_file), true) ?: [];
}

// Baca data siswa untuk info tambahan
$semuaSiswa = [];
if (file_exists($data_siswa_file)) {
    $semuaSiswa = json_decode(file_get_contents($data_siswa_file), true) ?: [];
}

// Filter berdasarkan parameter
$filterKelas = $_GET['kelas'] ?? '';
$filterTanggal = $_GET['tanggal'] ?? '';
$filterStatus = $_GET['status'] ?? '';
$filterMapel = $_GET['mapel'] ?? '';
$filterGuru = $_GET['guru'] ?? '';

$dataFiltered = $semuaAbsensi;

if ($filterKelas) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => $r['kelas'] === $filterKelas);
}
if ($filterTanggal) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => $r['tanggal'] === $filterTanggal);
}
if ($filterStatus) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => $r['status'] === $filterStatus);
}
if ($filterMapel) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => $r['mapel'] === $filterMapel);
}
if ($filterGuru) {
    $dataFiltered = array_filter($dataFiltered, fn($r) => ($r['guru'] ?? '') === $filterGuru);
}

// Urutkan terbaru
usort($dataFiltered, function ($a, $b) {
    return strtotime($b['tanggal'] . ' ' . $b['waktu']) - strtotime($a['tanggal'] . ' ' . $a['waktu']);
});

// Statistik
$totalData = count($dataFiltered);
$totalHadir = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Hadir'));
$totalIzin = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Izin'));
$totalSakit = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Sakit'));
$totalAlpa = count(array_filter($dataFiltered, fn($r) => $r['status'] === 'Alpa'));

// Ambil daftar unik untuk filter
$daftarKelas = array_unique(array_column($semuaAbsensi, 'kelas'));
$daftarMapel = array_unique(array_column($semuaAbsensi, 'mapel'));
$daftarGuru = array_unique(array_column($semuaAbsensi, 'guru'));
$daftarTanggal = array_unique(array_column($semuaAbsensi, 'tanggal'));
sort($daftarKelas);
sort($daftarMapel);
sort($daftarGuru);
rsort($daftarTanggal);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            aside {
                display: none !important;
            }

            main {
                width: 100% !important;
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden">
    <!-- SIDEBAR (sama seperti dashboard_admin.php) -->
    <aside class="w-[260px] bg-gradient-to-b from-[#0B1121] to-[#161d31] text-gray-300 flex flex-col flex-shrink-0 h-full shadow-2xl no-print">
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
                    <a href="dashboard_admin.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                        <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <a href="rekap_absensi_admin.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <!-- HEADER -->
        <header class="bg-white h-[72px] flex items-center justify-between px-8 border-b border-gray-200 no-print">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Rekap Absensi</h2>
                <p class="text-xs text-gray-500">Laporan kehadiran siswa seluruh sekolah</p>
            </div>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all shadow-lg shadow-emerald-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Laporan
                </button>
                <a href="dashboard_admin.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </header>

        <div class="p-8">
            <!-- STATISTIK CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-gray-100 p-2.5 rounded-xl text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase">Total Data</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900"><?= $totalData ?></p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-green-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-green-100 p-2.5 rounded-xl text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 uppercase">Hadir</span>
                    </div>
                    <p class="text-2xl font-bold text-green-600"><?= $totalHadir ?></p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-blue-100 p-2.5 rounded-xl text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-blue-600 uppercase">Izin</span>
                    </div>
                    <p class="text-2xl font-bold text-blue-600"><?= $totalIzin ?></p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-yellow-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-yellow-100 p-2.5 rounded-xl text-yellow-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-yellow-600 uppercase">Sakit</span>
                    </div>
                    <p class="text-2xl font-bold text-yellow-600"><?= $totalSakit ?></p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-red-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-red-100 p-2.5 rounded-xl text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-red-600 uppercase">Alpa</span>
                    </div>
                    <p class="text-2xl font-bold text-red-600"><?= $totalAlpa ?></p>
                </div>
            </div>

            <!-- FILTER -->
            <form method="GET" class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-6 no-print">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal</label>
                        <select name="tanggal" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Semua Tanggal</option>
                            <?php foreach ($daftarTanggal as $t): ?>
                                <option value="<?= $t ?>" <?= $filterTanggal === $t ? 'selected' : '' ?>><?= date('d M Y', strtotime($t)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kelas</label>
                        <select name="kelas" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Semua Kelas</option>
                            <?php foreach ($daftarKelas as $k): ?>
                                <option value="<?= htmlspecialchars($k) ?>" <?= $filterKelas === $k ? 'selected' : '' ?>><?= htmlspecialchars($k) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Mapel</label>
                        <select name="mapel" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Semua Mapel</option>
                            <?php foreach ($daftarMapel as $m): ?>
                                <option value="<?= htmlspecialchars($m) ?>" <?= $filterMapel === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Guru</label>
                        <select name="guru" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Semua Guru</option>
                            <?php foreach ($daftarGuru as $g): ?>
                                <option value="<?= htmlspecialchars($g) ?>" <?= $filterGuru === $g ? 'selected' : '' ?>><?= htmlspecialchars($g) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status</label>
                        <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Semua Status</option>
                            <option value="Hadir" <?= $filterStatus === 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                            <option value="Izin" <?= $filterStatus === 'Izin' ? 'selected' : '' ?>>Izin</option>
                            <option value="Sakit" <?= $filterStatus === 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                            <option value="Alpa" <?= $filterStatus === 'Alpa' ? 'selected' : '' ?>>Alpa</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl text-sm transition-all">
                            Filter
                        </button>
                        <a href="rekap_absensi_admin.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-3 rounded-xl text-sm transition-all" title="Reset">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </form>

            <!-- TABEL REKAP -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-bold text-gray-900"><?= $totalData ?></span> data absensi
                        <?php if ($filterKelas || $filterTanggal || $filterStatus || $filterMapel || $filterGuru): ?>
                            <span class="text-blue-600">(difilter)</span>
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
                        <h4 class="font-semibold text-gray-700 mb-1">Belum Ada Data Absensi</h4>
                        <p class="text-sm text-gray-500 max-w-md mx-auto">
                            <?php if (empty($semuaAbsensi)): ?>
                                Data absensi belum tersedia. Guru dapat melakukan absensi melalui menu Absensi Kelas.
                            <?php else: ?>
                                Tidak ada data yang cocok dengan filter yang dipilih.
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
                                    <th class="px-6 py-4 font-semibold">NIS</th>
                                    <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                                    <th class="px-6 py-4 font-semibold">Kelas</th>
                                    <th class="px-6 py-4 font-semibold">Mapel</th>
                                    <th class="px-6 py-4 font-semibold">Guru</th>
                                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                                    <th class="px-6 py-4 font-semibold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($dataFiltered as $i => $row): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4"><?= $i + 1 ?></td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900"><?= date('d M Y', strtotime($row['tanggal'])) ?></div>
                                            <div class="text-xs text-gray-400"><?= $row['waktu'] ?> WIB</div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-xs text-gray-600"><?= htmlspecialchars($row['nis']) ?></td>
                                        <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($row['nama']) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                                                <?= htmlspecialchars($row['kelas']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 text-xs"><?= htmlspecialchars($row['mapel']) ?></td>
                                        <td class="px-6 py-4 text-gray-600 text-xs max-w-[150px] truncate" title="<?= htmlspecialchars($row['guru'] ?? '-') ?>">
                                            <?= htmlspecialchars($row['guru'] ?? '-') ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php
                                            $statusColors = [
                                                'Hadir' => 'bg-green-100 text-green-700',
                                                'Izin' => 'bg-blue-100 text-blue-700',
                                                'Sakit' => 'bg-yellow-100 text-yellow-700',
                                                'Alpa' => 'bg-red-100 text-red-700'
                                            ];
                                            $status = $row['status'];
                                            $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
                                            ?>
                                            <span class="<?= $color ?> px-3 py-1 rounded-full text-xs font-bold">
                                                <?= $status ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-600 max-w-[200px] truncate" title="<?= htmlspecialchars($row['keterangan'] ?? '-') ?>">
                                            <?= htmlspecialchars($row['keterangan'] ?? '-') ?>
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
</body>

</html>