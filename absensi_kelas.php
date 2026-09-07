<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'guru') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

$data_siswa_file = __DIR__ . '/data_siswa.json';
$data_absensi_file = __DIR__ . '/data_absensi.json';

if (!file_exists($data_absensi_file)) {
    file_put_contents($data_absensi_file, json_encode([]));
}

function bacaDataSiswa($file)
{
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

function simpanAbsensi($file, $dataBaru)
{
    $dataLama = json_decode(file_get_contents($file), true) ?: [];
    $dataGabungan = array_merge($dataLama, $dataBaru);
    return file_put_contents($file, json_encode($dataGabungan, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$namaGuru = $_SESSION['nama'] ?? 'Guru';
$mapelGuru = $_SESSION['mapel'] ?? 'Mata Pelajaran';
$kelasDipilih = $_GET['kelas'] ?? '';
$pesan = '';
$tipePesan = '';

$semuaSiswa = bacaDataSiswa($data_siswa_file);
$daftarKelas = array_unique(array_column($semuaSiswa, 'kelas'));
sort($daftarKelas);

$siswaKelas = [];
if ($kelasDipilih) {
    $siswaKelas = array_filter($semuaSiswa, fn($s) => $s['kelas'] === $kelasDipilih);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_absensi'])) {
    $kelas = $_POST['kelas'] ?? '';
    $tanggal = date('Y-m-d');
    $waktu = date('H:i:s');
    $dataAbsensiBaru = [];

    if (isset($_POST['status']) && is_array($_POST['status'])) {
        foreach ($_POST['status'] as $nis => $status) {
            $dataAbsensiBaru[] = [
                'id_absen' => uniqid('ABS_'),
                'tanggal' => $tanggal,
                'waktu' => $waktu,
                'kelas' => $kelas,
                'guru' => $namaGuru,
                'mapel' => $mapelGuru,
                'nis' => $nis,
                'nama' => $_POST['nama_siswa'][$nis] ?? 'Tidak Diketahui',
                'status' => $status,
                'keterangan' => $_POST['keterangan'][$nis] ?? '-'
            ];
        }

        if (simpanAbsensi($data_absensi_file, $dataAbsensiBaru)) {
            $pesan = "Absensi untuk kelas <b>{$kelas}</b> berhasil disimpan!";
            $tipePesan = "success";
            
        } else {
            $pesan = "Gagal menyimpan data absensi. Periksa izin folder.";
            $tipePesan = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Kelas - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .radio-hadir:checked+label {
            background-color: #DCFCE7;
            color: #166534;
            border-color: #86EFAC;
        }

        .radio-izin:checked+label {
            background-color: #DBEAFE;
            color: #1E40AF;
            border-color: #93C5FD;
        }

        .radio-sakit:checked+label {
            background-color: #FEF3C7;
            color: #92400E;
            border-color: #FCD34D;
        }

        .radio-alpa:checked+label {
            background-color: #FEE2E2;
            color: #991B1B;
            border-color: #FCA5A5;
        }
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
                    <p class="text-[10px] text-blue-400 font-medium uppercase tracking-widest">Portal Guru</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="dashboard_guru.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="absensi_kelas.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    </nav>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Lainnya</p>
                    <a href="profil_guru.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>
                    <nav class="space-y-1">
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
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 class="text-xl font-bold text-gray-800">Absensi Kelas</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($namaGuru) ?></p>
                        <p class="text-xs text-gray-500"><?= htmlspecialchars($mapelGuru) ?></p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold border border-blue-200">
                        <?= strtoupper(substr($namaGuru, 0, 1)) ?>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 flex-1">
                <?php if ($pesan): ?>
                    <div id="notif" class="mb-6 p-4 rounded-xl flex items-center justify-between <?= $tipePesan === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'; ?>">
                        <p class="font-semibold text-sm"><?= $pesan ?></p>
                        <button onclick="document.getElementById('notif').remove()" class="text-lg font-bold hover:opacity-70">×</button>
                    </div>
                <?php endif; ?>

                <?php if (!$kelasDipilih): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto mt-10">
                        <div class="text-center mb-6">
                            <div class="bg-blue-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Pilih Kelas untuk Diabsen</h3>
                            <p class="text-sm text-gray-500 mt-1">Silakan pilih kelas yang akan Anda lakukan presensi hari ini.</p>
                        </div>

                        <?php if (empty($daftarKelas)): ?>
                            <div class="text-center p-4 bg-yellow-50 text-yellow-700 rounded-xl text-sm">
                                Belum ada data kelas. Pastikan admin sudah mengupload data siswa.
                            </div>
                        <?php else: ?>
                            <form action="absensi_kelas.php" method="GET" class="flex gap-3">
                                <select name="kelas" required class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($daftarKelas as $k): ?>
                                        <option value="<?= htmlspecialchars($k) ?>"><?= htmlspecialchars($k) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-blue-500/30">
                                    Lanjut
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                <?php else: ?>
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Kelas: <?= htmlspecialchars($kelasDipilih) ?></h3>
                            <p class="text-sm text-gray-500">Tanggal: <?= date('d F Y') ?> • Total Siswa: <?= count($siswaKelas) ?></p>
                        </div>
                        <a href="absensi_kelas.php" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1 bg-white px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Ganti Kelas
                        </a>
                    </div>

                    <?php if (empty($siswaKelas)): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                            <p class="text-gray-500">Tidak ada siswa terdaftar di kelas <b><?= htmlspecialchars($kelasDipilih) ?></b>.</p>
                            <a href="absensi_kelas.php" class="inline-block mt-4 text-blue-600 font-semibold hover:underline">Pilih kelas lain</a>
                        </div>
                    <?php else: ?>
                        <form method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <input type="hidden" name="kelas" value="<?= htmlspecialchars($kelasDipilih) ?>">

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-4 font-semibold w-16">No</th>
                                            <th class="px-6 py-4 font-semibold">NIS & Nama Siswa</th>
                                            <th class="px-6 py-4 font-semibold text-center">Status Kehadiran</th>
                                            <th class="px-6 py-4 font-semibold">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <?php $no = 1;
                                        foreach ($siswaKelas as $siswa):
                                            $nis = htmlspecialchars($siswa['nis']);
                                            $nama = htmlspecialchars($siswa['nama']);
                                        ?>
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 font-medium text-gray-500"><?= $no++ ?></td>
                                                <td class="px-6 py-4">
                                                    <p class="font-semibold text-gray-900"><?= $nama ?></p>
                                                    <p class="text-xs text-gray-500 font-mono"><?= $nis ?></p>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex justify-center gap-2">
                                                        
                                                        <div class="relative">
                                                            <input type="radio" name="status[<?= $nis ?>]" id="h_<?= $nis ?>" value="Hadir" class="radio-hadir sr-only" checked>
                                                            <label for="h_<?= $nis ?>" class="cursor-pointer block px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold transition-all hover:bg-green-50">H</label>
                                                        </div>
                                  
                                                        <div class="relative">
                                                            <input type="radio" name="status[<?= $nis ?>]" id="i_<?= $nis ?>" value="Izin" class="radio-izin sr-only">
                                                            <label for="i_<?= $nis ?>" class="cursor-pointer block px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold transition-all hover:bg-blue-50">I</label>
                                                        </div>

                                                        <div class="relative">
                                                            <input type="radio" name="status[<?= $nis ?>]" id="s_<?= $nis ?>" value="Sakit" class="radio-sakit sr-only">
                                                            <label for="s_<?= $nis ?>" class="cursor-pointer block px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold transition-all hover:bg-yellow-50">S</label>
                                                        </div>

                                                        <div class="relative">
                                                            <input type="radio" name="status[<?= $nis ?>]" id="a_<?= $nis ?>" value="Alpa" class="radio-alpa sr-only">
                                                            <label for="a_<?= $nis ?>" class="cursor-pointer block px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold transition-all hover:bg-red-50">A</label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" name="keterangan[<?= $nis ?>]" placeholder="Opsional..." class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                                    <input type="hidden" name="nama_siswa[<?= $nis ?>]" value="<?= $nama ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                                <a href="absensi_kelas.php" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-all">
                                    Batal
                                </a>
                                <button type="submit" name="simpan_absensi" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Absensi
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
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