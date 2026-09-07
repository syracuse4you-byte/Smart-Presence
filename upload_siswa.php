<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = '';
$messageType = '';
$previewData = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_siswa'])) {
    $file = $_FILES['file_siswa'];
    $allowedExtensions = ['csv', 'txt'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        $handle = fopen($file['tmp_name'], 'r');
        $siswaData = [];
        $headerSkipped = false;
        $rowNumber = 1;

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            if (count($data) >= 3 && !empty(trim($data[1]))) {
                $siswaData[] = [
                    'no' => $rowNumber,
                    'nis' => trim($data[1]),
                    'nama' => trim($data[2]),
                    'kelas' => trim($data[3] ?? 'X PPLG 1'),
                    'jk' => trim($data[4] ?? 'Laki-laki')
                ];
                $rowNumber++;
            }
        }
        fclose($handle);

        if (!empty($siswaData)) {
            // Baca data yang sudah ada
            $dataFile = 'data_siswa.json';
            $existingData = [];

            if (file_exists($dataFile)) {
                $jsonData = file_get_contents($dataFile);
                $existingData = json_decode($jsonData, true) ?: [];
            }

            // Gabungkan data lama dan baru
            $mergedData = array_merge($existingData, $siswaData);

            // Update nomor urut
            foreach ($mergedData as $index => &$siswa) {
                $siswa['no'] = $index + 1;
            }

            // Simpan ke JSON
            if (file_put_contents($dataFile, json_encode($mergedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                $message = "Berhasil upload " . count($siswaData) . " data siswa!";
                $messageType = 'success';
            } else {
                $message = "Gagal menyimpan data. Periksa permission folder.";
                $messageType = 'error';
            }
        } else {
            $message = "File CSV kosong atau format tidak sesuai.";
            $messageType = 'error';
        }
    } else {
        $message = "Format file tidak valid. Gunakan file CSV atau TXT.";
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data Siswa - SmartPresence</title>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="data_siswa.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Data Siswa
                    </a>
                    <a href="jadwal.php" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl text-sm font-medium transition-all duration-300 group">
                        <svg class="w-5 h-5 mr-3 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Jadwal
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
            <h2 class="text-xl font-bold text-gray-800">Upload Data Siswa</h2>
            <a href="data_siswa.php" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 font-medium text-sm px-4 py-2 rounded-xl hover:bg-gray-100 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </header>

        <div class="p-8">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-xl <?php echo $messageType === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'; ?>">
                    <p class="font-semibold text-sm"><?php echo $message; ?></p>
                    <?php if ($messageType === 'success'): ?>
                        <a href="data_siswa.php" class="inline-block mt-2 text-sm font-semibold underline">Lihat Data Siswa →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 max-w-2xl mx-auto">
                <div class="text-center mb-6">
                    <div class="bg-blue-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Upload File CSV</h3>
                    <p class="text-sm text-gray-500">Format: No, NIS, Nama Siswa, Kelas, Jenis Kelamin</p>
                </div>

                <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih File CSV</label>
                        <input type="file" name="file_siswa" accept=".csv,.txt" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <p class="text-xs text-gray-500 mt-2">* File harus berformat CSV dengan pemisah koma (,)</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-500/30">
                            Upload Data
                        </button>
                        <a href="data_siswa.php" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                            Batal
                        </a>
                    </div>
                </form>

                <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                    <p class="text-xs font-semibold text-gray-700 mb-2">Contoh Format CSV:</p>
                    <pre class="text-xs text-gray-600 overflow-x-auto">1,22412/286.4.1,ACHMAD FAHRUR ROSI,X PPLG 1,Laki-laki
2,22413/287.4.1,ADEL PUSPITA SARI,X PPLG 1,Perempuan</pre>
                </div>
            </div>
        </div>
    </main>
</body>

</html>