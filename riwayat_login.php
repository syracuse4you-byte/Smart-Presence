<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$riwayat_file = __DIR__ . '/riwayat_login.json';
if (!file_exists($riwayat_file)) {
    file_put_contents($riwayat_file, json_encode([]));
}

if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    file_put_contents($riwayat_file, json_encode([]));
    header("Location: riwayat_login.php");
    exit;
}

$riwayat = json_decode(file_get_contents($riwayat_file), true) ?: [];
$total_berhasil = count(array_filter($riwayat, fn($r) => $r['status'] === 'Berhasil'));
$total_gagal = count(array_filter($riwayat, fn($r) => $r['status'] === 'Gagal'));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Login - SmartPresence</title>
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
                    <a href="rekap_absensi_admin.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                            </svg>
                            Rekap Absensi
                        </a>
                    <a href="riwayat_login.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
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
    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white h-[72px] flex items-center justify-between px-8 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Riwayat Login</h2>
            <?php if (!empty($riwayat)): ?>
                <a href="?action=clear" onclick="return confirm('Yakin ingin menghapus semua riwayat login?')" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all border border-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Semua
                </a>
            <?php endif; ?>
        </header>
        <div class="p-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Total Aktivitas</p>
                        <p class="text-xl font-bold text-gray-900"><?= count($riwayat) ?></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-green-50 p-3 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Login Berhasil</p>
                        <p class="text-xl font-bold text-gray-900"><?= $total_berhasil ?></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-red-50 p-3 rounded-xl text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Login Gagal</p>
                        <p class="text-xl font-bold text-gray-900"><?= $total_gagal ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <?php if (empty($riwayat)): ?>
                    <div class="p-12 text-center">
                        <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada riwayat login</p>
                        <p class="text-sm text-gray-400 mt-1">Aktivitas login akan muncul di sini</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">No</th>
                                    <th class="px-6 py-4 font-semibold">Username / NIS</th>
                                    <th class="px-6 py-4 font-semibold">Waktu Login</th>
                                    <th class="px-6 py-4 font-semibold">IP Address</th>
                                    <th class="px-6 py-4 font-semibold">Browser / Device</th>
                                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($riwayat as $i => $row): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4"><?= $i + 1 ?></td>
                                        <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($row['username']) ?></td>
                                        <td class="px-6 py-4 text-gray-600">
                                            <div class="font-medium"><?= date('d M Y', strtotime($row['waktu'])) ?></div>
                                            <div class="text-xs text-gray-400"><?= date('H:i:s', strtotime($row['waktu'])) ?> WIB</div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 font-mono text-xs"><?= htmlspecialchars($row['ip']) ?></td>
                                        <td class="px-6 py-4 text-gray-600 text-xs max-w-[200px] truncate" title="<?= htmlspecialchars($row['browser']) ?>">
                                            <?= htmlspecialchars(substr($row['browser'], 0, 50)) ?>...
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if ($row['status'] === 'Berhasil'): ?>
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Berhasil</span>
                                            <?php else: ?>
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Gagal</span>
                                            <?php endif; ?>
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