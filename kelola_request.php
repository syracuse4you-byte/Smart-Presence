<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$request_file = __DIR__ . '/data_requests.json';
$data_siswa_file = __DIR__ . '/data_siswa.json';

if (!file_exists($request_file)) {
    file_put_contents($request_file, json_encode([]));
}

// Proses approve/reject
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';
    $request_id = $_POST['request_id'] ?? '';

    $requests = json_decode(file_get_contents($request_file), true) ?: [];

    foreach ($requests as &$req) {
        if ($req['id'] === $request_id) {
            if ($aksi === 'approve') {
                $req['status'] = 'approved';
                $req['catatan_admin'] = $_POST['catatan'] ?? '';

                // Generate password baru
                $password_baru = 'Pass' . rand(1000, 9999) . '!';
                $req['password_baru'] = $password_baru;

                // Jika request daftar baru, tambahkan siswa ke data_siswa.json
                if ($req['tipe'] === 'daftar_baru' && !empty($req['nis'])) {
                    $siswa_list = file_exists($data_siswa_file) ?
                        (json_decode(file_get_contents($data_siswa_file), true) ?: []) : [];

                    // Cek apakah NIS sudah ada
                    $nis_exists = false;
                    foreach ($siswa_list as $s) {
                        if ($s['nis'] === $req['nis']) {
                            $nis_exists = true;
                            break;
                        }
                    }

                    if (!$nis_exists) {
                        $siswa_list[] = [
                            'no' => count($siswa_list) + 1,
                            'nis' => $req['nis'],
                            'nama' => $req['nama'],
                            'kelas' => $req['kelas'] ?? 'X PPLG 1',
                            'jk' => 'Laki-laki',
                            'password' => $password_baru
                        ];
                        file_put_contents($data_siswa_file, json_encode($siswa_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    }
                }

                // Jika lupa password, update password di data_siswa
                if ($req['tipe'] === 'lupa_password' && !empty($req['nis'])) {
                    if (file_exists($data_siswa_file)) {
                        $siswa_list = json_decode(file_get_contents($data_siswa_file), true) ?: [];
                        foreach ($siswa_list as &$s) {
                            if ($s['nis'] === $req['nis']) {
                                $s['password'] = $password_baru;
                                break;
                            }
                        }
                        file_put_contents($data_siswa_file, json_encode($siswa_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    }
                }
            } elseif ($aksi === 'reject') {
                $req['status'] = 'rejected';
                $req['catatan_admin'] = $_POST['catatan'] ?? '';
            }
            break;
        }
    }

    file_put_contents($request_file, json_encode($requests, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: kelola_request.php");
    exit;
}

$requests = json_decode(file_get_contents($request_file), true) ?: [];

// Statistik
$total_request = count($requests);
$total_pending = count(array_filter($requests, fn($r) => $r['status'] === 'pending'));
$total_approved = count(array_filter($requests, fn($r) => $r['status'] === 'approved'));
$total_rejected = count(array_filter($requests, fn($r) => $r['status'] === 'rejected'));

// Filter
$filter_status = $_GET['status'] ?? 'semua';
$filtered = $requests;
if ($filter_status !== 'semua') {
    $filtered = array_filter($requests, fn($r) => $r['status'] === $filter_status);
}

// Urutkan: pending dulu
usort($filtered, function ($a, $b) {
    if ($a['status'] === 'pending' && $b['status'] !== 'pending') return -1;
    if ($a['status'] !== 'pending' && $b['status'] === 'pending') return 1;
    return strtotime($b['waktu']) - strtotime($a['waktu']);
});
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Permintaan - SmartPresence</title>
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
    <aside class="w-[260px] bg-gradient-to-b from-[#0B1121] to-[#161d31] text-gray-300 flex flex-col flex-shrink-0 h-full shadow-2xl">
        <div class="h-20 flex items-center px-6 border-b border-white/5">
            <div class="bg-blue-600 shadow-lg shadow-blue-600/30 text-white p-2 rounded-xl mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h1 class="text-white font-bold text-[16px] tracking-tight">SmartPresence</h1>
                <p class="text-[10px] text-blue-400 font-medium uppercase tracking-widest">Panel Admin</p>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
            <div>
                <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Menu Utama</p>
                <nav class="space-y-1">
                    <a href="dashboard_admin.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="data_siswa.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Data Siswa
                    </a>
                    <a href="jadwal.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <a href="riwayat_login.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <a href="kelola_request.php" class="flex items-center px-4 py-3 bg-orange-600/20 text-orange-400 rounded-xl text-sm font-semibold border-l-4 border-orange-500 transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Kelola Request
                        <?php if ($total_pending > 0): ?>
                            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?= $total_pending ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="?action=logout" class="flex items-center px-4 py-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </a>
                </nav>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white h-[72px] flex items-center justify-between px-8 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Kelola Permintaan User</h2>
                <p class="text-xs text-gray-500">Proses permintaan akun & reset password dari user</p>
            </div>
        </header>

        <div class="p-8">
            <!-- STATISTIK -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Total Request</p>
                        <p class="text-xl font-bold text-gray-900"><?= $total_request ?></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-orange-100 flex items-center gap-4">
                    <div class="bg-orange-50 p-3 rounded-xl text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Pending</p>
                        <p class="text-xl font-bold text-orange-600"><?= $total_pending ?></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-green-100 flex items-center gap-4">
                    <div class="bg-green-50 p-3 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Approved</p>
                        <p class="text-xl font-bold text-green-600"><?= $total_approved ?></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-red-100 flex items-center gap-4">
                    <div class="bg-red-50 p-3 rounded-xl text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Rejected</p>
                        <p class="text-xl font-bold text-red-600"><?= $total_rejected ?></p>
                    </div>
                </div>
            </div>

            <!-- FILTER -->
            <div class="flex gap-2 mb-6">
                <a href="?status=semua" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all <?= $filter_status === 'semua' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    Semua (<?= $total_request ?>)
                </a>
                <a href="?status=pending" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all <?= $filter_status === 'pending' ? 'bg-orange-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    Pending (<?= $total_pending ?>)
                </a>
                <a href="?status=approved" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all <?= $filter_status === 'approved' ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    Approved (<?= $total_approved ?>)
                </a>
                <a href="?status=rejected" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all <?= $filter_status === 'rejected' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    Rejected (<?= $total_rejected ?>)
                </a>
            </div>

            <!-- LIST REQUEST -->
            <?php if (empty($filtered)): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-700 mb-2">Tidak Ada Permintaan</h3>
                    <p class="text-sm text-gray-500">Belum ada permintaan dari user pada status ini.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($filtered as $req):
                        $tipe_label = [
                            'daftar_baru' => ['🆕 Daftar Akun Baru', 'bg-blue-100 text-blue-700'],
                            'lupa_password' => ['🔑 Lupa Password', 'bg-orange-100 text-orange-700'],
                            'akun_diblokir' => ['🚫 Akun Diblokir', 'bg-red-100 text-red-700'],
                            'lainnya' => ['📝 Lainnya', 'bg-gray-100 text-gray-700']
                        ];
                        $status_label = [
                            'pending' => ['Pending', 'bg-orange-100 text-orange-700'],
                            'approved' => ['Approved', 'bg-green-100 text-green-700'],
                            'rejected' => ['Rejected', 'bg-red-100 text-red-700']
                        ];
                        $tipe = $tipe_label[$req['tipe']] ?? ['Lainnya', 'bg-gray-100 text-gray-700'];
                        $stat = $status_label[$req['status']] ?? ['Unknown', 'bg-gray-100 text-gray-700'];
                    ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="<?= $tipe[1] ?> px-3 py-1 rounded-full text-xs font-bold"><?= $tipe[0] ?></span>
                                    <span class="<?= $stat[1] ?> px-3 py-1 rounded-full text-xs font-bold"><?= $stat[0] ?></span>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400"><?= date('d M Y, H:i', strtotime($req['waktu'])) ?></p>
                                    <p class="text-[10px] text-gray-300 font-mono"><?= $req['id'] ?></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Nama</p>
                                    <p class="font-semibold text-gray-900"><?= htmlspecialchars($req['nama']) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Email</p>
                                    <p class="font-medium text-gray-900"><?= htmlspecialchars($req['email']) ?></p>
                                </div>
                                <?php if (!empty($req['nis'])): ?>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">NIS</p>
                                        <p class="font-mono text-gray-900"><?= htmlspecialchars($req['nis']) ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($req['kelas'])): ?>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Kelas</p>
                                        <p class="text-gray-900"><?= htmlspecialchars($req['kelas']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($req['pesan'])): ?>
                                <div class="mb-4">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Pesan</p>
                                    <div class="bg-gray-50 p-3 rounded-xl text-sm text-gray-700"><?= nl2br(htmlspecialchars($req['pesan'])) ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($req['status'] === 'approved' && !empty($req['password_baru'])): ?>
                                <div class="mb-4 bg-green-50 border border-green-200 p-4 rounded-xl">
                                    <p class="text-xs font-bold text-green-700 uppercase mb-1">✅ Password Baru Telah Dibuat</p>
                                    <div class="flex items-center gap-2">
                                        <code class="bg-white px-3 py-1.5 rounded-lg text-sm font-mono font-bold text-green-700 border border-green-200"><?= htmlspecialchars($req['password_baru']) ?></code>
                                        <span class="text-xs text-green-600">← Kirim password ini ke email user</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($req['status'] === 'rejected' && !empty($req['catatan_admin'])): ?>
                                <div class="mb-4 bg-red-50 border border-red-200 p-4 rounded-xl">
                                    <p class="text-xs font-bold text-red-700 uppercase mb-1">❌ Alasan Ditolak</p>
                                    <p class="text-sm text-red-700"><?= htmlspecialchars($req['catatan_admin']) ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ($req['status'] === 'pending'): ?>
                                <div class="border-t border-gray-100 pt-4">
                                    <form method="POST" class="space-y-3">
                                        <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan (opsional)</label>
                                            <input type="text" name="catatan" placeholder="Contoh: Password sudah dikirim ke email"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" name="aksi" value="approve" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-all flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Approve & Buat Password
                                            </button>
                                            <button type="submit" name="aksi" value="reject" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition-all">
                                                Tolak
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>