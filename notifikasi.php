<?php
session_start();

// Proteksi: Hanya Admin dan Guru yang bisa akses
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'] ?? '';
if ($role !== 'admin' && $role !== 'guru') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

$namaUser = $_SESSION['nama'] ?? 'User';
$mapelGuru = $_SESSION['mapel'] ?? '';

// === FILE NOTIFIKASI ===
$notif_file = __DIR__ . '/data_notifikasi.json';
if (!file_exists($notif_file)) {
    file_put_contents($notif_file, json_encode([]));
}

$notifikasi = json_decode(file_get_contents($notif_file), true) ?: [];

// === GENERATE NOTIFIKASI OTOMATIS DARI ABSENSI ===
$absensi_file = __DIR__ . '/data_absensi.json';
if (file_exists($absensi_file)) {
    $semuaAbsensi = json_decode(file_get_contents($absensi_file), true) ?: [];
    $hariIni = date('Y-m-d');

    // Cek siswa yang alpa hari ini
    $alpaHariIni = array_filter($semuaAbsensi, fn($r) => $r['tanggal'] === $hariIni && $r['status'] === 'Alpa');
    if (count($alpaHariIni) > 0) {
        $kelasAlpa = array_unique(array_column($alpaHariIni, 'kelas'));
        $notifKey = 'alpa_' . $hariIni;
        $sudahAda = false;
        foreach ($notifikasi as $n) {
            if (($n['id'] ?? '') === $notifKey) {
                $sudahAda = true;
                break;
            }
        }
        if (!$sudahAda) {
            array_unshift($notifikasi, [
                'id' => $notifKey,
                'tipe' => 'peringatan',
                'judul' => 'Siswa Alpa Hari Ini',
                'pesan' => 'Terdapat ' . count($alpaHariIni) . ' siswa alpa di kelas ' . implode(', ', $kelasAlpa) . ' pada tanggal ' . date('d M Y') . '.',
                'waktu' => date('Y-m-d H:i:s'),
                'dibaca' => false,
                'sumber' => 'absensi'
            ]);
        }
    }

    // Cek siswa yang sakit hari ini
    $sakitHariIni = array_filter($semuaAbsensi, fn($r) => $r['tanggal'] === $hariIni && $r['status'] === 'Sakit');
    if (count($sakitHariIni) > 0) {
        $notifKey = 'sakit_' . $hariIni;
        $sudahAda = false;
        foreach ($notifikasi as $n) {
            if (($n['id'] ?? '') === $notifKey) {
                $sudahAda = true;
                break;
            }
        }
        if (!$sudahAda) {
            array_unshift($notifikasi, [
                'id' => $notifKey,
                'tipe' => 'info',
                'judul' => 'Siswa Sakit Hari Ini',
                'pesan' => 'Terdapat ' . count($sakitHariIni) . ' siswa sakit pada tanggal ' . date('d M Y') . '.',
                'waktu' => date('Y-m-d H:i:s'),
                'dibaca' => false,
                'sumber' => 'absensi'
            ]);
        }
    }

    // Cek absensi yang belum dilakukan hari ini (untuk guru)
    if ($role === 'guru') {
        $absensiHariIni = array_filter($semuaAbsensi, fn($r) => $r['tanggal'] === $hariIni);
        if (count($absensiHariIni) === 0 && date('H') >= 7 && date('H') <= 14) {
            $notifKey = 'belum_absen_' . $hariIni;
            $sudahAda = false;
            foreach ($notifikasi as $n) {
                if (($n['id'] ?? '') === $notifKey) {
                    $sudahAda = true;
                    break;
                }
            }
            if (!$sudahAda) {
                array_unshift($notifikasi, [
                    'id' => $notifKey,
                    'tipe' => 'pengingat',
                    'judul' => 'Absensi Belum Dilakukan',
                    'pesan' => 'Anda belum melakukan absensi hari ini. Silakan lakukan absensi kelas secepatnya.',
                    'waktu' => date('Y-m-d H:i:s'),
                    'dibaca' => false,
                    'sumber' => 'sistem'
                ]);
            }
        }
    }
}

// Simpan notifikasi yang sudah di-generate
file_put_contents($notif_file, json_encode($notifikasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// === PROSES AKSI ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'tandai_semua') {
        foreach ($notifikasi as &$n) {
            $n['dibaca'] = true;
        }
        file_put_contents($notif_file, json_encode($notifikasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header("Location: notifikasi.php");
        exit;
    }

    if ($aksi === 'tandai_baca') {
        $id = $_POST['id'] ?? '';
        foreach ($notifikasi as &$n) {
            if (($n['id'] ?? '') === $id) {
                $n['dibaca'] = true;
                break;
            }
        }
        file_put_contents($notif_file, json_encode($notifikasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header("Location: notifikasi.php");
        exit;
    }

    if ($aksi === 'hapus') {
        $id = $_POST['id'] ?? '';
        $notifikasi = array_values(array_filter($notifikasi, fn($n) => ($n['id'] ?? '') !== $id));
        file_put_contents($notif_file, json_encode($notifikasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header("Location: notifikasi.php");
        exit;
    }

    if ($aksi === 'hapus_semua') {
        file_put_contents($notif_file, json_encode([]));
        header("Location: notifikasi.php");
        exit;
    }
}

// === FILTER ===
$filterTipe = $_GET['tipe'] ?? 'semua';
$notifikasiFiltered = $notifikasi;
if ($filterTipe !== 'semua') {
    $notifikasiFiltered = array_filter($notifikasi, fn($n) => ($n['tipe'] ?? '') === $filterTipe);
}

// Statistik
$totalNotif = count($notifikasi);
$totalBelumDibaca = count(array_filter($notifikasi, fn($n) => !$n['dibaca']));
$totalPeringatan = count(array_filter($notifikasi, fn($n) => ($n['tipe'] ?? '') === 'peringatan'));
$totalInfo = count(array_filter($notifikasi, fn($n) => ($n['tipe'] ?? '') === 'info'));

// Tentukan halaman dashboard berdasarkan role
$dashboardUrl = ($role === 'admin') ? 'dashboard_admin.php' : 'dashboard_guru.php';

// Ikon dan warna berdasarkan tipe
function getNotifStyle($tipe)
{
    switch ($tipe) {
        case 'peringatan':
            return ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon_bg' => 'bg-red-100', 'icon_color' => 'text-red-600', 'badge' => 'bg-red-100 text-red-700'];
        case 'pengingat':
            return ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'icon_bg' => 'bg-yellow-100', 'icon_color' => 'text-yellow-600', 'badge' => 'bg-yellow-100 text-yellow-700'];
        case 'info':
            return ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'icon_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-600', 'badge' => 'bg-blue-100 text-blue-700'];
        case 'sukses':
            return ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'icon_bg' => 'bg-green-100', 'icon_color' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700'];
        default:
            return ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'icon_bg' => 'bg-gray-100', 'icon_color' => 'text-gray-600', 'badge' => 'bg-gray-100 text-gray-700'];
    }
}

function getNotifIcon($tipe)
{
    switch ($tipe) {
        case 'peringatan':
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
        case 'pengingat':
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>';
        case 'info':
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';
        case 'sukses':
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
        default:
            return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden">
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
                <p class="text-[10px] text-blue-400 font-medium uppercase tracking-widest"><?= $role === 'admin' ? 'Sistem Absensi' : 'Portal Guru' ?></p>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
            <div>
                <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Menu Utama</p>
                <nav class="space-y-1">
                    <a href="<?= $dashboardUrl ?>" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                        <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <?php if ($role === 'admin'): ?>
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
                    <?php else: ?>
                        <a href="absensi_kelas.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Absensi Kelas
                        </a>
                        <a href="jadwal_mengajar.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Jadwal Mengajar
                        </a>
                        <a href="rekap_absensi.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
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
                    <?php endif; ?>
                </nav>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Lainnya</p>
                <nav class="space-y-1">
                    <a href="notifikasi.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300 relative">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Notifikasi
                        <?php if ($totalBelumDibaca > 0): ?>
                            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?= $totalBelumDibaca ?></span>
                        <?php endif; ?>
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
        <header class="bg-white h-[72px] flex items-center justify-between px-8 border-b border-gray-200 sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-gray-800">Notifikasi</h2>
                <?php if ($totalBelumDibaca > 0): ?>
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?= $totalBelumDibaca ?> baru</span>
                <?php endif; ?>
            </div>
            <div class="flex gap-3">
                <?php if ($totalBelumDibaca > 0): ?>
                    <form method="POST" class="inline">
                        <input type="hidden" name="aksi" value="tandai_semua">
                        <button type="submit" class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all border border-blue-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tandai Semua Dibaca
                        </button>
                    </form>
                <?php endif; ?>
                <?php if ($totalNotif > 0): ?>
                    <form method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus semua notifikasi?')">
                        <input type="hidden" name="aksi" value="hapus_semua">
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all border border-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Semua
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </header>

        <div class="p-8">
            <!-- STATISTIK -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                    <div class="bg-blue-50 p-2.5 rounded-xl text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total</p>
                        <p class="text-lg font-bold text-gray-900"><?= $totalNotif ?></p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                    <div class="bg-red-50 p-2.5 rounded-xl text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Belum Dibaca</p>
                        <p class="text-lg font-bold text-red-600"><?= $totalBelumDibaca ?></p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                    <div class="bg-yellow-50 p-2.5 rounded-xl text-yellow-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Peringatan</p>
                        <p class="text-lg font-bold text-yellow-600"><?= $totalPeringatan ?></p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                    <div class="bg-green-50 p-2.5 rounded-xl text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Info</p>
                        <p class="text-lg font-bold text-green-600"><?= $totalInfo ?></p>
                    </div>
                </div>
            </div>

            <!-- FILTER TABS -->
            <div class="flex gap-2 mb-6 overflow-x-auto">
                <a href="?tipe=semua" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap transition-all <?= $filterTipe === 'semua' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    Semua (<?= $totalNotif ?>)
                </a>
                <a href="?tipe=peringatan" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap transition-all <?= $filterTipe === 'peringatan' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    ⚠ Peringatan
                </a>
                <a href="?tipe=pengingat" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap transition-all <?= $filterTipe === 'pengingat' ? 'bg-yellow-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    🔔 Pengingat
                </a>
                <a href="?tipe=info" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap transition-all <?= $filterTipe === 'info' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    ℹ Info
                </a>
            </div>

            <!-- DAFTAR NOTIFIKASI -->
            <?php if (empty($notifikasiFiltered)): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-700 mb-2">Tidak Ada Notifikasi</h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto">
                        <?php if ($filterTipe !== 'semua'): ?>
                            Tidak ada notifikasi dengan tipe "<?= $filterTipe ?>". Coba filter lainnya.
                        <?php else: ?>
                            Semua baik-baik saja! Notifikasi baru akan muncul di sini secara otomatis.
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($notifikasiFiltered as $notif):
                        $style = getNotifStyle($notif['tipe'] ?? 'info');
                        $icon = getNotifIcon($notif['tipe'] ?? 'info');
                        $isBelumDibaca = !$notif['dibaca'];
                    ?>
                        <div class="bg-white rounded-2xl shadow-sm border <?= $isBelumDibaca ? 'border-blue-300 ring-1 ring-blue-100' : 'border-gray-200' ?> overflow-hidden hover:shadow-md transition-all">
                            <div class="p-5 flex items-start gap-4">
                                <!-- Ikon -->
                                <div class="<?= $style['icon_bg'] ?> p-2.5 rounded-xl <?= $style['icon_color'] ?> flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <?= $icon ?>
                                    </svg>
                                </div>

                                <!-- Konten -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($notif['judul']) ?></h4>
                                                <?php if ($isBelumDibaca): ?>
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></span>
                                                <?php endif; ?>
                                                <span class="<?= $style['badge'] ?> text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                                                    <?= htmlspecialchars($notif['tipe'] ?? 'info') ?>
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 leading-relaxed"><?= htmlspecialchars($notif['pesan']) ?></p>
                                            <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <?= date('d M Y, H:i', strtotime($notif['waktu'])) ?> WIB
                                            </p>
                                        </div>

                                        <!-- Aksi -->
                                        <div class="flex items-center gap-1 flex-shrink-0">
                                            <?php if ($isBelumDibaca): ?>
                                                <form method="POST" class="inline">
                                                    <input type="hidden" name="aksi" value="tandai_baca">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($notif['id'] ?? '') ?>">
                                                    <button type="submit" title="Tandai sudah dibaca" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form method="POST" class="inline" onsubmit="return confirm('Hapus notifikasi ini?')">
                                                <input type="hidden" name="aksi" value="hapus">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($notif['id'] ?? '') ?>">
                                                <button type="submit" title="Hapus" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    </div>
</body>

</html>