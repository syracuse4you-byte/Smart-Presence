<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$dataFile = 'data_siswa.json';
$message = '';
$messageType = '';

function bacaDataSiswa($file)
{
    if (!file_exists($file)) return [];
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

function simpanDataSiswa($file, $data)
{
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswaList = bacaDataSiswa($dataFile);
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $nis = trim($_POST['nis'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $kelas = trim($_POST['kelas'] ?? '');
        $jk = trim($_POST['jk'] ?? 'Laki-laki');

        if ($nis === '' || $nama === '' || $kelas === '') {
            $message = 'NIS, Nama, dan Kelas wajib diisi!';
            $messageType = 'error';
        } else {
            $duplikat = false;
            foreach ($siswaList as $s) {
                if ($s['nis'] === $nis) {
                    $duplikat = true;
                    break;
                }
            }
            if ($duplikat) {
                $message = 'NIS sudah terdaftar!';
                $messageType = 'error';
            } else {
                $siswaList[] = [
                    'no' => count($siswaList) + 1,
                    'nis' => $nis,
                    'nama' => $nama,
                    'kelas' => $kelas,
                    'jk' => $jk
                ];
                if (simpanDataSiswa($dataFile, $siswaList)) {
                    $message = 'Data siswa berhasil ditambahkan!';
                    $messageType = 'success';
                } else {
                    $message = 'Gagal menyimpan data.';
                    $messageType = 'error';
                }
            }
        }
    }

    elseif ($action === 'edit') {
        $index = (int)($_POST['index'] ?? -1);
        $nis = trim($_POST['nis'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $kelas = trim($_POST['kelas'] ?? '');
        $jk = trim($_POST['jk'] ?? 'Laki-laki');

        if (isset($siswaList[$index])) {
            $duplikat = false;
            foreach ($siswaList as $i => $s) {
                if ($i !== $index && $s['nis'] === $nis) {
                    $duplikat = true;
                    break;
                }
            }
            if ($nis === '' || $nama === '' || $kelas === '') {
                $message = 'NIS, Nama, dan Kelas wajib diisi!';
                $messageType = 'error';
            } elseif ($duplikat) {
                $message = 'NIS sudah digunakan siswa lain!';
                $messageType = 'error';
            } else {
                $siswaList[$index]['nis'] = $nis;
                $siswaList[$index]['nama'] = $nama;
                $siswaList[$index]['kelas'] = $kelas;
                $siswaList[$index]['jk'] = $jk;
                if (simpanDataSiswa($dataFile, $siswaList)) {
                    $message = 'Data siswa berhasil diperbarui!';
                    $messageType = 'success';
                } else {
                    $message = 'Gagal memperbarui data.';
                    $messageType = 'error';
                }
            }
        }
    }

    elseif ($action === 'delete') {
        $index = (int)($_POST['index'] ?? -1);
        if (isset($siswaList[$index])) {
            $namaHapus = $siswaList[$index]['nama'];
            array_splice($siswaList, $index, 1);
            foreach ($siswaList as $i => &$s) {
                $s['no'] = $i + 1;
            }
            if (simpanDataSiswa($dataFile, $siswaList)) {
                $message = "Data siswa <b>{$namaHapus}</b> berhasil dihapus!";
                $messageType = 'success';
            } else {
                $message = 'Gagal menghapus data.';
                $messageType = 'error';
            }
        }
    }
}

$siswaList = bacaDataSiswa($dataFile);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }

        .modal-overlay {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
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
                    <a href="data_siswa.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <main class="flex-1 flex flex-col h-full overflow-y-auto">
        <header class="bg-white h-[72px] flex items-center justify-between px-8 border-b border-gray-200 sticky top-0 z-20">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Data Siswa</h2>
                <p class="text-xs text-gray-500">Kelola data siswa untuk sistem absensi</p>
            </div>
            <div class="flex gap-3">
                <a href="upload_siswa.php" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all shadow-lg shadow-emerald-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload CSV
                </a>
                <button onclick="openModal('add')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all shadow-lg shadow-blue-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Siswa
                </button>
            </div>
        </header>

        <div class="p-8">
            <?php if ($message): ?>
                <div id="notif" class="mb-6 p-4 rounded-xl flex items-center justify-between <?= $messageType === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'; ?>">
                    <p class="font-semibold text-sm"><?= $message ?></p>
                    <button onclick="document.getElementById('notif').remove()" class="text-lg font-bold hover:opacity-70">×</button>
                </div>
            <?php endif; ?>

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 mb-6 flex gap-4">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama atau NIS..." class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <select id="filterKelas" onchange="filterTable()" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none">
                    <option value="">Semua Kelas</option>
                    <?php
                    $kelasList = array_unique(array_column($siswaList, 'kelas'));
                    foreach ($kelasList as $k): ?>
                        <option><?= htmlspecialchars($k) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (empty($siswaList)): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-700 mb-2">Belum Ada Data Siswa</h3>
                    <p class="text-sm text-gray-500 mb-6">Silakan upload data siswa via CSV atau tambahkan manual</p>
                    <div class="flex justify-center gap-3">
                        <button onclick="openModal('add')" class="inline-flex bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all">
                            Tambah Manual
                        </button>
                        <a href="upload_siswa.php" class="inline-flex bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all">
                            Upload Data CSV
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <p class="text-sm text-gray-600">Menampilkan <span class="font-bold text-gray-900"><?= count($siswaList) ?></span> siswa</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="tabelSiswa" class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">No</th>
                                    <th class="px-6 py-4 font-semibold">NIS</th>
                                    <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                                    <th class="px-6 py-4 font-semibold">Kelas</th>
                                    <th class="px-6 py-4 font-semibold">Jenis Kelamin</th>
                                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($siswaList as $index => $siswa): ?>
                                    <tr class="hover:bg-gray-50 transition-colors row-siswa">
                                        <td class="px-6 py-4"><?= $siswa['no'] ?></td>
                                        <td class="px-6 py-4 font-medium font-mono text-xs"><?= htmlspecialchars($siswa['nis']) ?></td>
                                        <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($siswa['nama']) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                <?= htmlspecialchars($siswa['kelas']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="<?= $siswa['jk'] === 'Laki-laki' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' ?> px-3 py-1 rounded-full text-xs font-semibold">
                                                <?= htmlspecialchars($siswa['jk']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
                                                <button onclick='openModal("edit", <?= $index ?>, <?= json_encode($siswa) ?>)' title="Edit" class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </button>
                                                <form method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa <?= htmlspecialchars($siswa['nama']) ?>?')" class="inline">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="index" value="<?= $index ?>">
                                                    <button type="submit" title="Hapus" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <div id="modalSiswa" class="fixed inset-0 modal-overlay hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <h3 id="modalTitle" class="font-bold text-lg">Tambah Siswa</h3>
                <button onclick="closeModal()" class="hover:bg-white/20 p-1 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" class="p-6 space-y-4">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="index" id="formIndex" value="">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIS <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" id="inputNis" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 22412/286.4.1">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="inputNama" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama siswa">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                        <input type="text" name="kelas" id="inputKelas" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="X PPLG 1">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="jk" id="inputJk" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-500/30">
                        Simpan Data
                    </button>
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(mode, index = null, data = null) {
            const modal = document.getElementById('modalSiswa');
            const title = document.getElementById('modalTitle');
            const action = document.getElementById('formAction');
            const idx = document.getElementById('formIndex');

            if (mode === 'add') {
                title.textContent = 'Tambah Siswa Baru';
                action.value = 'add';
                idx.value = '';
                document.getElementById('inputNis').value = '';
                document.getElementById('inputNama').value = '';
                document.getElementById('inputKelas').value = '';
                document.getElementById('inputJk').value = 'Laki-laki';
            } else if (mode === 'edit' && data) {
                title.textContent = 'Edit Data Siswa';
                action.value = 'edit';
                idx.value = index;
                document.getElementById('inputNis').value = data.nis;
                document.getElementById('inputNama').value = data.nama;
                document.getElementById('inputKelas').value = data.kelas;
                document.getElementById('inputJk').value = data.jk;
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modalSiswa');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const kelas = document.getElementById('filterKelas').value;
            const rows = document.querySelectorAll('.row-siswa');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowKelas = row.children[3].textContent.trim();
                const matchSearch = text.includes(search);
                const matchKelas = kelas === '' || rowKelas === kelas;
                row.style.display = (matchSearch && matchKelas) ? '' : 'none';
            });
        }

        setTimeout(() => {
            const notif = document.getElementById('notif');
            if (notif) {
                notif.style.transition = 'opacity 0.5s';
                notif.style.opacity = '0';
                setTimeout(() => notif.remove(), 500);
            }
        }, 4000);

        document.getElementById('modalSiswa').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>

</html>