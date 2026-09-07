<?php
session_start();
$message_sent = false;
$request_id = '';

// File untuk menyimpan request
$request_file = __DIR__ . '/data_requests.json';
if (!file_exists($request_file)) {
    file_put_contents($request_file, json_encode([]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
    $nama = trim($_POST['nama'] ?? '');
    $nis = trim($_POST['nis'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');
    $tipe_request = $_POST['tipe_request'] ?? 'daftar_baru';
    
    if (!empty($nama) && !empty($email) && !empty($pesan) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $request_id = 'REQ-' . time() . '-' . rand(1000, 9999);
        
        $requests = json_decode(file_get_contents($request_file), true) ?: [];
        $requests[] = [
            'id' => $request_id,
            'tipe' => $tipe_request,
            'nama' => $nama,
            'nis' => $nis,
            'kelas' => $kelas,
            'email' => $email,
            'pesan' => $pesan,
            'waktu' => date('Y-m-d H:i:s'),
            'status' => 'pending',
            'catatan_admin' => ''
        ];
        file_put_contents($request_file, json_encode($requests, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        $message_sent = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hubungi Administrator - SmartPresence</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>body { font-family: 'Inter', sans-serif; background-color: #F0F4F8; }</style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden py-8">
<div class="bg-white w-full max-w-lg p-8 rounded-[20px] shadow-[0_8px_30px_rgb(0,0,0,0.08)] z-10 mx-4">
    <div class="flex items-center mb-6">
        <a href="login.php" class="text-gray-400 hover:text-blue-600 transition-colors p-2 -ml-2 rounded-lg hover:bg-blue-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
        <h2 class="text-[20px] font-bold text-gray-900 ml-2">Pusat Bantuan</h2>
    </div>

    <?php if($message_sent): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-xl mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="font-semibold text-sm">Pesan Berhasil Dikirim!</p>
                <p class="text-xs mt-1">Admin akan memproses permintaan Anda dalam 1x24 jam. Informasi akun baru akan dikirim ke email: <b><?= htmlspecialchars($email ?? '') ?></b></p>
                <p class="text-[10px] mt-2 text-green-600">ID Request: <code><?= htmlspecialchars($request_id) ?></code></p>
            </div>
        </div>
    </div>
    <a href="login.php" class="block text-center w-full bg-[#1a56db] hover:bg-blue-800 text-white font-semibold text-sm py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/30">
        Kembali ke halaman Login
    </a>
    <?php else: ?>
    <p class="text-sm text-gray-500 mb-6">Silakan isi formulir di bawah ini untuk meminta akun baru atau melaporkan kendala.</p>
    
    <form action="" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Permintaan</label>
            <select name="tipe_request" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="daftar_baru">🆕 Daftar Akun Baru</option>
                <option value="akun_diblokir">🚫 Akun Diblokir</option>
                <option value="lainnya">📝 Lainnya</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Nama lengkap Anda" required
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">NIS (jika ada)</label>
                <input type="text" name="nis" placeholder="00XXXXXXXX"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kelas & Jurusan</label>
                <input type="text" name="kelas" placeholder="XI PPLG 1"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Aktif</label>
            <input type="email" name="email" placeholder="nama@email.com" required
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <p class="text-[11px] text-gray-400 mt-1">* Akun/password akan dikirim ke email ini</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Detail Permintaan</label>
            <textarea name="pesan" rows="3" placeholder="Jelaskan kebutuhan Anda..." required
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"></textarea>
        </div>

        <button type="submit" name="send_message"
            class="w-full bg-[#1a56db] hover:bg-blue-800 text-white font-semibold text-sm py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex justify-center items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Kirim Permintaan
        </button>
    </form>
    <?php endif; ?>
</div>
</body>
</html>