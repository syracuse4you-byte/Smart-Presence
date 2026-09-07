<?php
session_start();
$error = '';

$riwayat_file = __DIR__ . '/riwayat_login.json';
$data_guru_file = __DIR__ . '/data_guru.json';
$data_siswa_file = __DIR__ . '/data_siswa.json';

if (!file_exists($riwayat_file)) {
    file_put_contents($riwayat_file, json_encode([]));
}

if (!file_exists($data_guru_file)) {
    $defaultGuru = [
        [
            'nip' => '198501012010011001',
            'nama' => 'Budi Santoso, S.Pd.',
            'email' => 'budi@guru.smk.id',
            'password' => 'guru123',
            'mapel' => 'Pemrograman Web'
        ]
    ];
    file_put_contents($data_guru_file, json_encode($defaultGuru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function simpanRiwayat($file, $data)
{
    $riwayat = json_decode(file_get_contents($file), true) ?: [];
    array_unshift($riwayat, $data);
    $riwayat = array_slice($riwayat, 0, 100);
    file_put_contents($file, json_encode($riwayat, JSON_PRETTY_PRINT));
}

function bacaDataGuru($file)
{
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

function bacaDataSiswa($file)
{
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $ip = $_SERVER['REMOTE_ADDR'] ?? '-';
    $waktu = date('Y-m-d H:i:s');
    $browser = $_SERVER['HTTP_USER_AGENT'] ?? '-';

    $loginBerhasil = false;
    $role = '';
    $namaUser = '';

    if ($username === 'useradmin01' && $password === 'admin001') {
        $loginBerhasil = true;
        $role = 'admin';
        $namaUser = 'Administrator';
    }
    elseif (!$loginBerhasil && strpos($username, '@guru.smk.id') !== false) {
        $guruList = bacaDataGuru($data_guru_file);
        $guruDitemukan = false;

        foreach ($guruList as $guru) {
            if ($guru['email'] === $username && $guru['password'] === $password) {
                $loginBerhasil = true;
                $role = 'guru';
                $namaUser = $guru['nama'];
                $_SESSION['nip'] = $guru['nip'];
                $_SESSION['mapel'] = $guru['mapel'];
                $guruDitemukan = true;
                break;
            }
        }

        if (!$guruDitemukan && $password === 'guru123') {
            $loginBerhasil = true;
            $role = 'guru';
            $namaUser = ucfirst(explode('@', $username)[0]);
            $_SESSION['nip'] = '000000000000000000';
            $_SESSION['mapel'] = 'Guru';
        }
    }
    elseif (!$loginBerhasil) {
        $siswaList = bacaDataSiswa($data_siswa_file);
        foreach ($siswaList as $siswa) {
            $passwordSiswa = $siswa['nis']; 
            if ($siswa['nis'] === $username && $password === $passwordSiswa) {
                $loginBerhasil = true;
                $role = 'siswa';
                $namaUser = $siswa['nama'];
                $_SESSION['nis'] = $siswa['nis'];
                $_SESSION['kelas'] = $siswa['kelas'];
                break;
            }
        }
    }

    if ($loginBerhasil) {
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $namaUser;

        simpanRiwayat($riwayat_file, [
            'username' => $username,
            'waktu' => $waktu,
            'ip' => $ip,
            'browser' => $browser,
            'status' => 'Berhasil'
        ]);

        // Redirect sesuai role
        if ($role === 'admin') {
            header("Location: dashboard_admin.php");
        } elseif ($role === 'guru') {
            header("Location: dashboard_guru.php");
        } elseif ($role === 'siswa') {
            header("Location: dashboard_siswa.php");
        }
        exit;
    } else {
        $error = "<p class='text-red-500 text-sm text-center mb-4 font-medium'>Email/NIS atau password salah.</p>";

        if (!empty($username)) {
            simpanRiwayat($riwayat_file, [
                'username' => $username,
                'waktu' => $waktu,
                'ip' => $ip,
                'browser' => $browser,
                'status' => 'Gagal'
            ]);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F0F4F8;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center relative overflow-hidden">
    <div class="bg-white w-full max-w-md p-8 rounded-[20px] shadow-[0_8px_30px_rgb(0,0,0,0.08)] z-10 mx-4 backdrop-blur-sm bg-white/95 border border-white/20">

        <div class="flex flex-col items-center justify-center mb-8">
            <div class="flex items-center gap-4">
                <img src="../images/logosmk.png" alt="logo" class="w-14 h-14 object-contain" onerror="this.style.display='none'">
                <div>
                    <h1 class="text-[24px] font-bold text-gray-900 tracking-tight leading-none">SmartPresence</h1>
                    <p class="text-[13px] font-medium text-gray-500 mt-1">Sistem Absensi Siswa</p>
                </div>
            </div>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-[20px] font-bold text-gray-900">Login ke Akun Anda</h2>
            <p class="text-sm text-gray-500 mt-2">Silakan masuk untuk melanjutkan</p>
        </div>

        <?= $error ?>

        <form action="" method="POST" class="space-y-5">
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1.5">Email atau NIS</label>
                <input type="text" id="username" name="username" placeholder="Masukkan email atau NIS" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
            </div>
            <div class="relative">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 pr-10">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-[38px] text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Ingat saya</span>
                </label>
                <a href="lupa_password.php" class="text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline transition-colors">
                    Lupa password?
                </a>
            </div>
           <button type="submit" onclick="morphLogin(event)"
                class="w-full bg-[#1a56db] hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/30 mt-4 relative overflow-hidden">
                <span id="btn-text" class="relative z-10 flex items-center justify-center transition-opacity duration-200">Login</span>
            </button>
        </form>

        <p class="text-center text-sm font-medium text-gray-500 mt-8">
            Belum punya akun? <a href="contact_admin.php" class="text-blue-600 hover:text-blue-800 hover:underline">Hubungi administrator</a>
        </p>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />`;
            }
        }

        // PERBAIKAN: Menambahkan deklarasi function yang sebelumnya hilang
        function morphLogin(event) {
            const form = event.target.closest('form');
            
            // Cek apakah email dan password sudah diisi (validasi HTML5)
            if (!form.checkValidity()) {
                return; // Jika kosong, biarkan peringatan bawaan browser muncul
            }

            // Tahan form agar tidak langsung pindah halaman
            event.preventDefault(); 
            
            const btn = event.currentTarget;
            const rect = btn.getBoundingClientRect();
            
            // Sembunyikan teks "Login" saat diklik
            document.getElementById('btn-text').style.opacity = '0';
            
            // Buat elemen lingkaran biru untuk efek morphing
            const overlay = document.createElement('div');
            overlay.className = 'fixed bg-[#1a56db] rounded-full z-[9999] transition-all duration-700 ease-in-out pointer-events-none';
            
            // Hitung posisi awal (tepat di tengah tombol)
            const startX = rect.left + (rect.width / 2);
            const startY = rect.top + (rect.height / 2);
            
            // Hitung ukuran akhir agar menutupi seluruh layar
            const maxSize = Math.max(window.innerWidth, window.innerHeight) * 2.5;
            
            overlay.style.width = '0px';
            overlay.style.height = '0px';
            overlay.style.left = startX + 'px';
            overlay.style.top = startY + 'px';
            overlay.style.transform = 'translate(-50%, -50%)';
            
            document.body.appendChild(overlay);
            
            // Trigger efek membesar (delay sedikit agar transisi CSS terbaca)
            setTimeout(() => {
                overlay.style.width = maxSize + 'px';
                overlay.style.height = maxSize + 'px';
            }, 10);

            // Akali agar PHP tetap mendeteksi 'isset($_POST["login"])'
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'login';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);

            // Submit form secara otomatis setelah animasi menutupi layar (600ms)
            setTimeout(() => {
                form.submit();
            }, 600);
        }
    </script>
</body>

</html>