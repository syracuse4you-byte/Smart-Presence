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

$namaGuru = $_SESSION['nama'] ?? 'Budi Santoso, S.Pd.';
$mapelGuru = $_SESSION['mapel'] ?? 'Pemrograman Web';

$hariIndonesia = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$hariIniIndex = date('N');
$hariIniNama = $hariIndonesia[$hariIniIndex];
$tanggalHariIni = date('d F Y');

$allJadwal = [

    'X PPLG 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'ruang' => 'B.10', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'ruang' => 'B.10', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'B.10', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'B.10', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'ruang' => 'B.10', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'B.10', 'guru' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'B.10', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'ruang' => 'B.10', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'B.10', 'guru' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'B.10', 'guru' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'ruang' => 'B.10', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'ruang' => 'B.10', 'guru' => 'MELANOKE PRAMANIK, S.Kom.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian PPLG', 'ruang' => 'B.10', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.'],
        ],
    ],
    'X PPLG 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'G.1', 'guru' => 'RETNO DAMAYANTI, S.PdI'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'G.1', 'guru' => 'SITI HALUMA SADA, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'G.1', 'guru' => 'MUNTAMAH KHOIR, S.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'G.1', 'guru' => 'PUTY CHANDRA DARMAJANTI, M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'G.1', 'guru' => 'MUNTAMAH KHOIR, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'G.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'G.1', 'guru' => 'PUTY CHANDRA DARMAJANTI, M.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'G.1', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Sejarah', 'ruang' => 'G.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'G.1', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'G.1', 'guru' => 'SITI HALUMA SADA, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Sejarah', 'ruang' => 'G.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '08:15 - 09:45', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'G.1', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '09:45 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'G.1', 'guru' => 'RETNO DAMAYANTI, S.PdI'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'G.1', 'guru' => 'PUTY CHANDRA DARMAJANTI, M.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Seni Rupa', 'ruang' => 'G.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
    ],
    'X TJKT 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Internet of Things', 'ruang' => 'B.7', 'guru' => 'SLAMET SISWANTO UTOMO, S.T.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian TJKT', 'ruang' => 'B.7', 'guru' => 'NOVIM CICI HERBAVIANA, S.Kom, Gr.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'NOVIM CICI HERBAVIANA, S.Kom, Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian TJKT', 'ruang' => 'B.7', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian TJKT', 'ruang' => 'B.7', 'guru' => 'HAYKAL, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian TJKT', 'ruang' => 'B.7', 'guru' => 'NOVIM CICI HERBAVIANA, S.Kom, Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'B.7', 'guru' => 'ADE SHILVI VERAWATI, S.T.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian TJKT', 'ruang' => 'B.7', 'guru' => 'HAYKAL, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'NOVIM CICI HERBAVIANA, S.Kom, Gr.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'B.7', 'guru' => 'ADE SHILVI VERAWATI, S.T.'],
            ['jam' => '10:45 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian TJKT', 'ruang' => 'B.7', 'guru' => 'DWI HANDAYANI, S.Kom'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'B.7', 'guru' => 'ADE SHILVI VERAWATI, S.T.'],
        ],
    ],
    'X TJKT 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.1', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.1', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.1', 'guru' => 'MUJAKI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.1', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Jawa', 'ruang' => 'F.1', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.1', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.1', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.1', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'F.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.1', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.1', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '11:30 - 13:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.1', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'F.1', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.1', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
    ],
    'X PM 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'P.6', 'guru' => 'SURUR, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.6', 'guru' => 'MAX ARENS WALALAYO, S.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'P.6', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.6', 'guru' => 'ANGGUN SETYANINGTYAS, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.6', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'P.6', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.6', 'guru' => 'ANGGUN SETYANINGTYAS, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.6', 'guru' => 'MAX ARENS WALALAYO, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'P.6', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.6', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
        ],
    ],
    'X PM 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'L.1', 'guru' => 'SLAMET HARIYADI, S.Ag.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'L.1', 'guru' => 'CITRA KUMALASARI, M.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'L.1', 'guru' => 'Dra. IDA SURYANINGRUM'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'L.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Matematika', 'ruang' => 'L.1', 'guru' => 'SHELA OKTA GREFINA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'L.1', 'guru' => 'CITRA KUMALASARI, M.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'L.1', 'guru' => 'SLAMET HARIYADI, S.Ag.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'L.1', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Matematika', 'ruang' => 'L.1', 'guru' => 'SHELA OKTA GREFINA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'L.1', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Sejarah', 'ruang' => 'L.1', 'guru' => 'YUSTA RIANDA, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Seni Rupa', 'ruang' => 'L.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '08:15 - 09:45', 'mapel' => 'Matematika', 'ruang' => 'L.1', 'guru' => 'SHELA OKTA GREFINA, S.Pd'],
            ['jam' => '09:45 - 11:30', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'L.1', 'guru' => 'Dra. IDA SURYANINGRUM'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'L.1', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Sejarah', 'ruang' => 'L.1', 'guru' => 'YUSTA RIANDA, S.Pd.'],
        ],
    ],
    'X MPLB 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'RETNO AFIANTI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'ARUMMAISHA MAHMUDAH, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'ARUMMAISHA MAHMUDAH, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.2', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'ELIA ROSA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.2', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'F.2', 'guru' => 'M. YUSUF, M.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'RETNO AFIANTI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.2', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'KATMIRAH, S.Pd'],
        ],
    ],
    'X MPLB 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.3', 'guru' => 'LILIK ERNAWATI, S.S.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.3', 'guru' => 'MOHAMAD NOR SHODIQ, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.3', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.3', 'guru' => 'MOHAMAD NOR SHODIQ, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Matematika', 'ruang' => 'F.3', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'F.3', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'F.3', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.3', 'guru' => 'HEPI SETIAWAN, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'F.3', 'guru' => 'MUNTAMAH KHOIR, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.3', 'guru' => 'LILIK ERNAWATI, S.S.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.3', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.3', 'guru' => 'HEPI SETIAWAN, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'F.3', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Matematika', 'ruang' => 'F.3', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
        ],
    ],
    'X AKL 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Dasar-dasar Program Keahlian AKL', 'ruang' => 'N.1', 'guru' => 'DIAN NOVIA PURWANDARI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.1', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian AKL', 'ruang' => 'N.1', 'guru' => 'RIZKY KUSUMA DEWI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian AKL', 'ruang' => 'N.1', 'guru' => 'HADI PRANOWO, S.E.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian AKL', 'ruang' => 'N.1', 'guru' => 'RIZKY KUSUMA DEWI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.1', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.1', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian AKL', 'ruang' => 'N.1', 'guru' => 'DIAN NOVIA PURWANDARI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'N.1', 'guru' => 'HADI PRANOWO, S.E.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian AKL', 'ruang' => 'N.1', 'guru' => 'HADI PRANOWO, S.E.'],
        ],
    ],
    'X AKL 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.2', 'guru' => 'YOYOK HARSOYO'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.2', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.2', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'N.2', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.2', 'guru' => 'Dra. ISTI\'AH'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.2', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'N.2', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.2', 'guru' => 'YOYOK HARSOYO'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.2', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '08:15 - 09:45', 'mapel' => 'Sejarah', 'ruang' => 'N.2', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '09:45 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.2', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN2', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'N.2', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Sejarah', 'ruang' => 'N.2', 'guru' => 'WIDYAWATI, S.E'],
        ],
    ],
    'X AKL 3' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.3', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.3', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.3', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.3', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Matematika', 'ruang' => 'N.3', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Seni Rupa', 'ruang' => 'N.3', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Matematika', 'ruang' => 'N.3', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Sejarah', 'ruang' => 'N.3', 'guru' => 'M. DIGDAYA KHARISMA W., S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'N.3', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.3', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'N.3', 'guru' => 'M. DIGDAYA KHARISMA W., S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.3', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Seni Rupa', 'ruang' => 'N.3', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Matematika', 'ruang' => 'N.3', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
    ],
    'X PH 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ROHIMAH, M.Par.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KHARISMA MAHARANI, S.Tr.Par'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Layanan Area Publik', 'ruang' => 'K.3', 'guru' => 'KARNADI, S.ST.Par.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.3', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KARNADI, S.ST.Par.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ROHIMAH, M.Par.'],
            ['jam' => '08:15 - 09:45', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.3', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '09:45 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KHARISMA MAHARANI, S.Tr.Par'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KARNADI, S.ST.Par.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.3', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
        ],
    ],
    'X PH 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.4', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.4', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.4', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'K.4', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'K.4', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.4', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.4', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.4', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'K.4', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'K.4', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.4', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'K.4', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'K.4', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'K.4', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.4', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
        ],
    ],
    'X PH 3' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.5', 'guru' => 'DWI ANGGRIAWAN, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.5', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.5', 'guru' => 'CITRA KUMALASARI, M.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'K.5', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'K.5', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.5', 'guru' => 'DWI ANGGRIAWAN, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.5', 'guru' => 'HASBY MAULIDZANA AL-AMIN, M.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.5', 'guru' => 'CITRA KUMALASARI, M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'K.5', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'K.5', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.5', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'K.5', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'K.5', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'K.5', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.5', 'guru' => 'HASBY MAULIDZANA AL-AMIN, M.Pd.'],
        ],
    ],
    'X KL 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'H.1', 'guru' => 'NUR LAILI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'H.1', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'H.1', 'guru' => 'POLIN FEBIANA, S.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'H.1', 'guru' => 'TUTIK HARIYANI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'H.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'H.1', 'guru' => 'NUR LAILI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'H.1', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'H.1', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'H.1', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'H.1', 'guru' => 'TUTIK HARIYANI, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'H.1', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'H.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'H.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'H.1', 'guru' => 'TUTIK HARIYANI, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'H.1', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
        ],
    ],
    'X DKV 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Dasar-dasar Program Keahlian DKV', 'ruang' => 'E.1', 'guru' => 'ENI KHOIRIYAH, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'E.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian DKV', 'ruang' => 'E.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian DKV', 'ruang' => 'E.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian DKV', 'ruang' => 'E.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'E.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'E.1', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian DKV', 'ruang' => 'E.1', 'guru' => 'ENI KHOIRIYAH, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'E.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian DKV', 'ruang' => 'E.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
    ],
    'X DKV 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'E.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'E.2', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'E.2', 'guru' => 'MUJAKI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'E.2', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'E.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Jawa', 'ruang' => 'E.2', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'E.2', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'E.2', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'E.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'E.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'E.2', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'E.2', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '11:30 - 13:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'E.2', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'E.2', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'E.2', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
    ],
    'X SP 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Dasar-dasar Program Keahlian SP', 'ruang' => 'F.5', 'guru' => 'ANY EKA NUR HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.5', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian SP', 'ruang' => 'F.5', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian SP', 'ruang' => 'F.5', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian SP', 'ruang' => 'F.5', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.5', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.5', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian SP', 'ruang' => 'F.5', 'guru' => 'ANY EKA NUR HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'F.5', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian SP', 'ruang' => 'F.5', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
    ],
    'X SP 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.6', 'guru' => 'Dra. IDA SURYANINGRUM'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.6', 'guru' => 'CITRA KUMALASARI, M.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.6', 'guru' => 'SLAMET HARIYADI, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.6', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.6', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Jawa', 'ruang' => 'F.6', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.6', 'guru' => 'CITRA KUMALASARI, M.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.6', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.6', 'guru' => 'Dra. IDA SURYANINGRUM'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'F.6', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.6', 'guru' => 'SLAMET HARIYADI, S.Ag.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.6', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
            ['jam' => '11:30 - 13:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.6', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'F.6', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.6', 'guru' => 'Dra. ISTI\'AH'],
        ],
    ],
    'X BDP 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Dasar-dasar Program Keahlian BDP', 'ruang' => 'N.7', 'guru' => 'LILIK ERNAWATI, S.S.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.7', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian BDP', 'ruang' => 'N.7', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian BDP', 'ruang' => 'N.7', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian BDP', 'ruang' => 'N.7', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.7', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.7', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian BDP', 'ruang' => 'N.7', 'guru' => 'LILIK ERNAWATI, S.S.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'N.7', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian BDP', 'ruang' => 'N.7', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
    ],
    'X BDP 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.8', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.8', 'guru' => 'YOYOK HARSOYO'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.8', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.8', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'N.8', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Jawa', 'ruang' => 'N.8', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.8', 'guru' => 'YOYOK HARSOYO'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.8', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.8', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'N.8', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.8', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.8', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '11:30 - 13:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.8', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN2', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'N.8', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.8', 'guru' => 'Dra. ISTI\'AH'],
        ],
    ],
    'X ULP 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Dasar-dasar Program Keahlian ULP', 'ruang' => 'K.1', 'guru' => 'MOH. YUSRON, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian ULP', 'ruang' => 'K.1', 'guru' => 'KARNADI, S.ST.Par.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian ULP', 'ruang' => 'K.1', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian ULP', 'ruang' => 'K.1', 'guru' => 'KARNADI, S.ST.Par.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.1', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian ULP', 'ruang' => 'K.1', 'guru' => 'MOH. YUSRON, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'K.1', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian ULP', 'ruang' => 'K.1', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
    ],
    'X ULP 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.2', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.2', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.2', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'K.2', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'K.2', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.2', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.2', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.2', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'K.2', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'K.2', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.2', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'K.2', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'K.2', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'K.2', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.2', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
        ],
    ],

    'XI PPLG 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.'],
            ['jam' => '10:45 - 15:15', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'ACHRIYATUL SETYORINI, S.ST.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'ACHRIYATUL SETYORINI, S.ST.'],
            ['jam' => '09:15 - 13:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'MELANOKE PRAMANIK, S.Kom.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.'],
            ['jam' => '09:15 - 13:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'MOHAMMAD SUKMAN HADI, S.Kom.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pengembangan Gim', 'ruang' => 'B.2', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 10:00', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'MELANOKE PRAMANIK, S.Kom.'],
            ['jam' => '10:00 - 13:45', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'ACHRIYATUL SETYORINI, S.ST.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Rekayasa Perangkat Lunak', 'ruang' => 'B.2', 'guru' => 'RETNO IRES DEVINA YOLANTI, S.ST.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Pengembangan Gim', 'ruang' => 'B.2', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom'],
        ],
    ],
    'XI PPLG 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Sejarah', 'ruang' => 'G.2', 'guru' => 'SITI HALUMA SADA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'G.2', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'G.2', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'G.2', 'guru' => 'PUTY CHANDRA DARMAJANTI, M.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'G.2', 'guru' => 'MUNTAMAH KHOIR, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'G.2', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'G.2', 'guru' => 'PUTY CHANDRA DARMAJANTI, M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'G.2', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'G.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'G.2', 'guru' => 'RETNO DAMAYANTI, S.PdI'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'G.2', 'guru' => 'MUNTAMAH KHOIR, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'G.2', 'guru' => 'SITI HALUMA SADA, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'G.2', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
    ],
    'XI TJKT 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 11:30', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'SAHLAN, S.Kom.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'DWI HANDAYANI, S.Kom'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 13:00', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'SAHLAN, S.Kom.'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'HAYKAL, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'HAYKAL, S.Pd.'],
            ['jam' => '09:15 - 13:00', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'SAHLAN, S.Kom.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'DWI HANDAYANI, S.Kom'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 10:00', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'HAYKAL, S.Pd.'],
            ['jam' => '10:00 - 13:45', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'SAHLAN, S.Kom.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'HAYKAL, S.Pd.'],
        ],
    ],
    'XI TJKT 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.4', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.4', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.4', 'guru' => 'MUJAKI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.4', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.4', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Jawa', 'ruang' => 'F.4', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.4', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.4', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.4', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'F.4', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.4', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'F.4', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '11:30 - 13:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.4', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'F.4', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.4', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
    ],
    'XI PM 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Pengembangan Gim', 'ruang' => 'P.7', 'guru' => 'SURUR, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.7', 'guru' => 'MAX ARENS WALALAYO, S.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'P.7', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.7', 'guru' => 'ANGGUN SETYANINGTYAS, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.7', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'P.7', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.7', 'guru' => 'ANGGUN SETYANINGTYAS, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.7', 'guru' => 'MAX ARENS WALALAYO, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'P.7', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian PM', 'ruang' => 'P.7', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
        ],
    ],
    'XI PM 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'L.2', 'guru' => 'SLAMET HARIYADI, S.Ag.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'L.2', 'guru' => 'CITRA KUMALASARI, M.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'L.2', 'guru' => 'Dra. IDA SURYANINGRUM'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'L.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Matematika', 'ruang' => 'L.2', 'guru' => 'SHELA OKTA GREFINA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'L.2', 'guru' => 'CITRA KUMALASARI, M.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'L.2', 'guru' => 'SLAMET HARIYADI, S.Ag.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'L.2', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Matematika', 'ruang' => 'L.2', 'guru' => 'SHELA OKTA GREFINA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'L.2', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Sejarah', 'ruang' => 'L.2', 'guru' => 'YUSTA RIANDA, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Seni Rupa', 'ruang' => 'L.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '08:15 - 09:45', 'mapel' => 'Matematika', 'ruang' => 'L.2', 'guru' => 'SHELA OKTA GREFINA, S.Pd'],
            ['jam' => '09:45 - 11:30', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'L.2', 'guru' => 'Dra. IDA SURYANINGRUM'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'L.2', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Sejarah', 'ruang' => 'L.2', 'guru' => 'YUSTA RIANDA, S.Pd.'],
        ],
    ],
    'XI MPLB 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'RETNO AFIANTI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'ARUMMAISHA MAHMUDAH, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'ARUMMAISHA MAHMUDAH, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.2', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'ELIA ROSA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.2', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'F.2', 'guru' => 'M. YUSUF, M.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'RETNO AFIANTI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'F.2', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Dasar-dasar Program Keahlian MPLB', 'ruang' => 'F.2', 'guru' => 'KATMIRAH, S.Pd'],
        ],
    ],
    'XI MPLB 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.3', 'guru' => 'LILIK ERNAWATI, S.S.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.3', 'guru' => 'MOHAMAD NOR SHODIQ, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.3', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.3', 'guru' => 'MOHAMAD NOR SHODIQ, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Matematika', 'ruang' => 'F.3', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'F.3', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'F.3', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.3', 'guru' => 'HEPI SETIAWAN, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'F.3', 'guru' => 'MUNTAMAH KHOIR, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'F.3', 'guru' => 'LILIK ERNAWATI, S.S.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.3', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'F.3', 'guru' => 'HEPI SETIAWAN, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'F.3', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Matematika', 'ruang' => 'F.3', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
        ],
    ],
    'XI AKL 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Akuntansi', 'ruang' => 'N.1', 'guru' => 'DIAN NOVIA PURWANDARI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.1', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Akuntansi', 'ruang' => 'N.1', 'guru' => 'RIZKY KUSUMA DEWI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Akuntansi', 'ruang' => 'N.1', 'guru' => 'HADI PRANOWO, S.E.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Akuntansi', 'ruang' => 'N.1', 'guru' => 'RIZKY KUSUMA DEWI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.1', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.1', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Akuntansi', 'ruang' => 'N.1', 'guru' => 'DIAN NOVIA PURWANDARI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'N.1', 'guru' => 'HADI PRANOWO, S.E.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Akuntansi', 'ruang' => 'N.1', 'guru' => 'HADI PRANOWO, S.E.'],
        ],
    ],
    'XI AKL 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.2', 'guru' => 'YOYOK HARSOYO'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.2', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.2', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'N.2', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.2', 'guru' => 'Dra. ISTI\'AH'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.2', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'N.2', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.2', 'guru' => 'YOYOK HARSOYO'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.2', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '08:15 - 09:45', 'mapel' => 'Sejarah', 'ruang' => 'N.2', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '09:45 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.2', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN2', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'N.2', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Sejarah', 'ruang' => 'N.2', 'guru' => 'WIDYAWATI, S.E'],
        ],
    ],
    'XI AKL 3' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.3', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.3', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.3', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.3', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Matematika', 'ruang' => 'N.3', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Seni Rupa', 'ruang' => 'N.3', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Matematika', 'ruang' => 'N.3', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Sejarah', 'ruang' => 'N.3', 'guru' => 'M. DIGDAYA KHARISMA W., S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'N.3', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.3', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'N.3', 'guru' => 'M. DIGDAYA KHARISMA W., S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.3', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Seni Rupa', 'ruang' => 'N.3', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Matematika', 'ruang' => 'N.3', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
    ],
    'XI PH 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ROHIMAH, M.Par.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KHARISMA MAHARANI, S.Tr.Par'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Layanan Area Publik', 'ruang' => 'K.3', 'guru' => 'KARNADI, S.ST.Par.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.3', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KARNADI, S.ST.Par.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'ROHIMAH, M.Par.'],
            ['jam' => '08:15 - 09:45', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.3', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '09:45 - 11:30', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KHARISMA MAHARANI, S.Tr.Par'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Dasar-dasar Program Keahlian PH', 'ruang' => 'K.3', 'guru' => 'KARNADI, S.ST.Par.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.3', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
        ],
    ],
    'XI PH 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.4', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.4', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.4', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'K.4', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'K.4', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.4', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.4', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.4', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'K.4', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'K.4', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.4', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'K.4', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'K.4', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'K.4', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.4', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
        ],
    ],
    'XI PH 3' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.5', 'guru' => 'DWI ANGGRIAWAN, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.5', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.5', 'guru' => 'CITRA KUMALASARI, M.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'K.5', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'K.5', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.5', 'guru' => 'DWI ANGGRIAWAN, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.5', 'guru' => 'HASBY MAULIDZANA AL-AMIN, M.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.5', 'guru' => 'CITRA KUMALASARI, M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'K.5', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'K.5', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.5', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'K.5', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'K.5', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'K.5', 'guru' => 'DETRI ERWIN NURZANA, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.5', 'guru' => 'HASBY MAULIDZANA AL-AMIN, M.Pd.'],
        ],
    ],
    'XI KL 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'H.1', 'guru' => 'NUR LAILI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'H.1', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'H.1', 'guru' => 'POLIN FEBIANA, S.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'H.1', 'guru' => 'TUTIK HARIYANI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'H.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'H.1', 'guru' => 'NUR LAILI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'H.1', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'H.1', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'H.1', 'guru' => 'SHEILA NURVATISNA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'H.1', 'guru' => 'TUTIK HARIYANI, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'H.1', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'H.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'H.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'H.1', 'guru' => 'TUTIK HARIYANI, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'H.1', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
        ],
    ],
    'XI DKV 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Desain Grafis', 'ruang' => 'E.1', 'guru' => 'ENI KHOIRIYAH, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'E.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Desain Grafis', 'ruang' => 'E.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Desain Grafis', 'ruang' => 'E.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Desain Grafis', 'ruang' => 'E.1', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'E.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'E.1', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Desain Grafis', 'ruang' => 'E.1', 'guru' => 'ENI KHOIRIYAH, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'E.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Desain Grafis', 'ruang' => 'E.1', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
    ],
    'XI DKV 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'E.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'E.2', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'E.2', 'guru' => 'MUJAKI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'E.2', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'E.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Jawa', 'ruang' => 'E.2', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'E.2', 'guru' => 'SHIELDA SELINA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'E.2', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'E.2', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'E.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'E.2', 'guru' => 'MUJAKI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'E.2', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
            ['jam' => '11:30 - 13:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'E.2', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'DINI ANGGA MAHARANI, S.Pd'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'E.2', 'guru' => 'IKA AKPRILLIA AR ROCHMAH, S.Pd'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'E.2', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
    ],
    'XI SP 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Seni Tari', 'ruang' => 'N.7', 'guru' => 'ANY EKA NUR HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.7', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Seni Tari', 'ruang' => 'N.7', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Seni Tari', 'ruang' => 'N.7', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.4', 'guru' => 'KATMIRAH, S.Pd'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Seni Tari', 'ruang' => 'N.7', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.7', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.7', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Seni Tari', 'ruang' => 'N.7', 'guru' => 'ANY EKA NUR HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'N.7', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Seni Tari', 'ruang' => 'N.7', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
    ],
    'XI BDP 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Pemasaran', 'ruang' => 'N.8', 'guru' => 'LILIK ERNAWATI, S.S.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.8', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pemasaran', 'ruang' => 'N.8', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pemasaran', 'ruang' => 'N.8', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.5', 'guru' => 'DWI HANDAYANI, S.Kom'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pemasaran', 'ruang' => 'N.8', 'guru' => 'AGUS SUPRANTIYONO, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.8', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'N.8', 'guru' => 'TITIS VIDYA NURINA, S.PD'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Pemasaran', 'ruang' => 'N.8', 'guru' => 'LILIK ERNAWATI, S.S.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'N.8', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Pemasaran', 'ruang' => 'N.8', 'guru' => 'MIFTAHUL JANNAH, S.Sn.'],
        ],
    ],
    'XI BDP 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.9', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.9', 'guru' => 'YOYOK HARSOYO'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.9', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.9', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Seni Rupa', 'ruang' => 'N.9', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Bahasa Jawa', 'ruang' => 'N.9', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.9', 'guru' => 'YOYOK HARSOYO'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.9', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.9', 'guru' => 'Dra. DALLY INDAH KABUL'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'N.9', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'N.9', 'guru' => 'SRI ILMIYATI ZAKIYAH, S.Ag.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Matematika', 'ruang' => 'N.9', 'guru' => 'ULFA HIDAYATI, S.Pd.'],
            ['jam' => '11:30 - 13:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.9', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN2', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Sejarah', 'ruang' => 'N.9', 'guru' => 'WIDYAWATI, S.E'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.9', 'guru' => 'Dra. ISTI\'AH'],
        ],
    ],
    'XI ULP 1' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 10:45', 'mapel' => 'Usaha Layanan Perhotelan', 'ruang' => 'K.1', 'guru' => 'MOH. YUSRON, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Usaha Layanan Perhotelan', 'ruang' => 'K.1', 'guru' => 'KARNADI, S.ST.Par.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Usaha Layanan Perhotelan', 'ruang' => 'K.1', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Informatika', 'ruang' => 'D.3', 'guru' => 'MOH. NURKHOLIS, S.Pd.Gr.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Usaha Layanan Perhotelan', 'ruang' => 'K.1', 'guru' => 'KARNADI, S.ST.Par.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.1', 'guru' => 'MURNIATI, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 08:15', 'mapel' => 'Ilmu Pengetahuan Alam dan Sosial', 'ruang' => 'K.1', 'guru' => 'MURNIATI, S.Pd.'],
            ['jam' => '08:15 - 11:30', 'mapel' => 'Usaha Layanan Perhotelan', 'ruang' => 'K.1', 'guru' => 'MOH. YUSRON, S.Pd.'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Koding dan Kecerdasan Artifisial', 'ruang' => 'K.1', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 11:00', 'mapel' => 'Usaha Layanan Perhotelan', 'ruang' => 'K.1', 'guru' => 'ENDANG ISTORINA, S.ST.Par.'],
        ],
    ],
    'XI ULP 2' => [
        'Senin' => [
            ['jam' => '06:45 - 07:30', 'mapel' => 'UPACARA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:30 - 09:00', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.2', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.2', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.2', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Matematika', 'ruang' => 'K.2', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Sejarah', 'ruang' => 'K.2', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'K.2', 'guru' => 'TAMIM ZUHRI, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
        ],
        'Rabu' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.2', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Bahasa Inggris', 'ruang' => 'K.2', 'guru' => 'TRI SUKESI SULISTYOWATI, M.Pd.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Bahasa Jawa', 'ruang' => 'K.2', 'guru' => 'OSSY WIDYA KUSUMASTUTI, S.Pd'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'K.2', 'guru' => 'UMI RAHAYU, S.Pd.'],
        ],
        'Kamis' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 11:30', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'K.2', 'guru' => 'SITI ISTIQOMAH, S.Pd.I.'],
            ['jam' => '12:15 - 13:45', 'mapel' => 'Sejarah', 'ruang' => 'K.2', 'guru' => 'YUSTA RIANDA, S.Pd.'],
            ['jam' => '13:45 - 15:15', 'mapel' => 'Seni Rupa', 'ruang' => 'K.2', 'guru' => 'REYNI DESITA, S.IP.'],
        ],
        'Jumat' => [
            ['jam' => '06:45 - 07:45', 'mapel' => 'JUMAT BERSIH-BERTAQWA', 'ruang' => '-', 'guru' => '-'],
            ['jam' => '07:45 - 09:15', 'mapel' => 'Matematika', 'ruang' => 'K.2', 'guru' => 'UMI RAHAYU, S.Pd.'],
            ['jam' => '09:15 - 11:00', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'K.2', 'guru' => 'BAYU INDRA PERMANA, S.Pd.'],
        ],
    ],
];

$kelasDiajar = [];
$jamSekarang = date('H:i');

foreach ($allJadwal as $namaKelas => $jadwalPerHari) {
    if (isset($jadwalPerHari[$hariIniNama])) {
        foreach ($jadwalPerHari[$hariIniNama] as $sesi) {

            if (stripos($sesi['guru'], $namaGuru) !== false) {

                $status = 'Akan Datang';
                $jamMulai = explode(' - ', $sesi['jam'])[0];
                $jamSelesai = explode(' - ', $sesi['jam'])[1];

                if ($jamSekarang >= $jamMulai && $jamSekarang <= $jamSelesai) {
                    $status = 'Berlangsung';
                } elseif ($jamSekarang > $jamSelesai) {
                    $status = 'Selesai';
                }

                $kelasDiajar[] = [
                    'kelas' => $namaKelas,
                    'jumlah' => 32,
                    'jam' => $sesi['jam'],
                    'ruang' => $sesi['ruang'],
                    'status' => $status,
                    'mapel' => $sesi['mapel']
                ];
            }
        }
    }
}

usort($kelasDiajar, function ($a, $b) {
    return strcmp(explode(' - ', $a['jam'])[0], explode(' - ', $b['jam'])[0]);
});

$totalKelas = count($kelasDiajar);
$totalSiswa = array_sum(array_column($kelasDiajar, 'jumlah'));
$rataKehadiran = 92;

$fileAbsensi = __DIR__ . '/data_absensi.json';
$aktivitasTerbaru = [];

if (file_exists($fileAbsensi)) {
    $semuaAbsensi = json_decode(file_get_contents($fileAbsensi), true) ?: [];

    usort($semuaAbsensi, function ($a, $b) {
        return strtotime($b['tanggal'] . ' ' . $b['waktu']) - strtotime($a['tanggal'] . ' ' . $a['waktu']);
    });

    $top5 = array_slice($semuaAbsensi, 0, 5);

    foreach ($top5 as $absen) {
        $aktivitasTerbaru[] = [
            'kelas' => $absen['kelas'],
            'mapel' => $absen['mapel'],
            'waktu' => date('d M Y, H:i', strtotime($absen['tanggal'] . ' ' . $absen['waktu'])) . ' WIB',
            'hadir' => 1,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'status_detail' => $absen['status']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SmartPresence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .status-selesai {
            background: #DCFCE7;
            color: #166534;
        }

        .status-berlangsung {
            background: #FEF3C7;
            color: #92400E;
            animation: pulse 2s infinite;
        }

        .status-akan {
            background: #DBEAFE;
            color: #1E40AF;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
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
                    <p class="text-[10px] text-blue-400 font-medium uppercase tracking-widest">Portal Guru</p>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
                <div>
                    <p class="text-[10px] font-bold text-gray-500 mb-3 px-3 uppercase tracking-[0.2em]">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="dashboard_guru.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Dashboard
                        </a>
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
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
                </div>
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
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
                <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20 relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <div class="relative">
                        <p class="text-blue-100 text-sm font-medium"><?= $hariIniNama ?>, <?= $tanggalHariIni ?></p>
                        <h1 class="text-2xl font-bold mt-1">Selamat datang, <?= htmlspecialchars(explode(',', $namaGuru)[0]) ?>! 👋</h1>

                        <?php if ($totalKelas > 0): ?>
                            <p class="text-blue-100 mt-2 max-w-xl">Anda memiliki <span class="font-bold text-white"><?= $totalKelas ?> kelas</span> untuk diajar hari ini. Jangan lupa melakukan absensi kehadiran siswa.</p>
                        <?php else: ?>
                            <p class="text-blue-100 mt-2 max-w-xl">Tidak ada jadwal mengajar untuk Anda hari ini. Nikmati waktu luang atau persiapkan materi!</p>
                        <?php endif; ?>

                        <div class="mt-4 flex gap-3">
                            <a href="absensi_kelas.php" class="bg-white text-blue-600 hover:bg-blue-50 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all inline-flex items-center gap-2 shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Mulai Absensi
                            </a>
                            <a href="jadwal_mengajar.php" class="bg-white/20 hover:bg-white/30 backdrop-blur text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all inline-flex items-center gap-2 border border-white/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Lihat Jadwal
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="bg-blue-50 p-4 rounded-xl text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kelas Diajar</p>
                            <p class="text-2xl font-bold text-gray-900"><?= $totalKelas ?></p>
                            <p class="text-xs text-gray-400 mt-0.5">Kelas aktif hari ini</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="bg-green-50 p-4 rounded-xl text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                            <p class="text-2xl font-bold text-gray-900"><?= $totalSiswa ?></p>
                            <p class="text-xs text-gray-400 mt-0.5">Dari semua kelas hari ini</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kelas Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900"><?= $totalKelas ?></p>
                            <p class="text-xs text-gray-400 mt-0.5">Jadwal mengajar</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="bg-purple-50 p-4 rounded-xl text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rata-rata Kehadiran</p>
                            <p class="text-2xl font-bold text-gray-900"><?= $rataKehadiran ?>%</p>
                            <p class="text-xs text-green-500 mt-0.5 font-medium">↑ 2% dari minggu lalu</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <?php if ($totalKelas > 0): ?>
                        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <div>
                                    <h3 class="font-bold text-gray-800">Jadwal Mengajar Hari Ini</h3>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= $hariIniNama ?>, <?= $tanggalHariIni ?></p>
                                </div>
                                <a href="jadwal_mengajar.php" class="text-sm text-blue-600 font-medium hover:text-blue-800">Lihat Semua →</a>
                            </div>
                            <div class="divide-y divide-gray-100">
                                <?php foreach ($kelasDiajar as $kelas): ?>
                                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <div class="text-center min-w-[70px]">
                                                <p class="text-xs font-semibold text-gray-500">JAM</p>
                                                <p class="text-sm font-bold text-blue-600"><?= $kelas['jam'] ?></p>
                                            </div>
                                            <div class="h-10 w-px bg-gray-200"></div>
                                            <div>
                                                <p class="font-semibold text-gray-900"><?= htmlspecialchars($kelas['kelas']) ?></p>
                                                <p class="text-xs text-gray-500 mt-0.5">📍 <?= htmlspecialchars($kelas['ruang']) ?> • 👥 <?= $kelas['jumlah'] ?> siswa</p>
                                                <p class="text-xs text-blue-600 font-medium mt-0.5"><?= htmlspecialchars($kelas['mapel']) ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="status-<?= strtolower(str_replace(' ', '-', $kelas['status'])) ?> px-3 py-1 rounded-full text-xs font-semibold">
                                                <?= $kelas['status'] ?>
                                            </span>
                                            <?php if ($kelas['status'] === 'Berlangsung'): ?>
                                                <a href="absensi_kelas.php?kelas=<?= urlencode($kelas['kelas']) ?>" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-all">
                                                    Absen
                                                </a>
                                            <?php elseif ($kelas['status'] === 'Akan Datang'): ?>
                                                <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold px-4 py-2 rounded-lg transition-all">
                                                    Detail
                                                </button>
                                            <?php else: ?>
                                                <a href="rekap_absensi.php?kelas=<?= urlencode($kelas['kelas']) ?>" class="text-blue-600 hover:text-blue-800 text-xs font-semibold px-3 py-2">
                                                    Rekap →
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-12 text-center flex flex-col items-center justify-center min-h-[300px]">
                            <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg">Tidak Ada Jadwal Mengajar</h3>
                            <p class="text-gray-500 mt-2 max-w-md">Anda tidak memiliki jadwal mengajar pada hari <?= $hariIniNama ?>. Gunakan waktu ini untuk mempersiapkan materi atau mengecek rekap absensi minggu lalu.</p>
                            <div class="mt-6 flex gap-3 justify-center">
                                <a href="rekap_absensi.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                                    Cek Rekap Absensi
                                </a>
                                <a href="jadwal_mengajar.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                                    Lihat Jadwal Mingguan
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-800">Aktivitas Terbaru</h3>
                            <a href="rekap_absensi.php" class="text-sm text-blue-600 font-medium hover:text-blue-800">Semua</a>
                        </div>
                        <div class="p-4 space-y-3">
                            <?php if (empty($aktivitasTerbaru)): ?>
                                <div class="text-center py-8">
                                    <p class="text-sm text-gray-500">Belum ada aktivitas absensi.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($aktivitasTerbaru as $aktivitas): ?>
                                    <div class="p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-semibold text-sm text-gray-900"><?= htmlspecialchars($aktivitas['kelas']) ?></p>
                                                <p class="text-xs text-gray-500"><?= htmlspecialchars($aktivitas['mapel']) ?></p>
                                            </div>
                                            <span class="text-[10px] text-gray-400"><?= $aktivitas['waktu'] ?></span>
                                        </div>
                                        <div class="flex gap-2 mt-2">
                                            <span class="<?= $aktivitas['status_detail'] === 'Hadir' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                <?= $aktivitas['status_detail'] ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <a href="absensi_kelas.php" class="flex flex-col items-center gap-2 p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all group">
                            <div class="bg-blue-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Mulai Absensi</span>
                        </a>
                        <a href="rekap_absensi.php" class="flex flex-col items-center gap-2 p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all group">
                            <div class="bg-green-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-4V3m0 4a4 4 0 00-4 4v10"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Rekap Kehadiran</span>
                        </a>
                        <a href="jadwal_mengajar.php" class="flex flex-col items-center gap-2 p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition-all group">
                            <div class="bg-yellow-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Jadwal Mengajar</span>
                        </a>
                        <a href="profil_guru.php" class="flex flex-col items-center gap-2 p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition-all group">
                            <div class="bg-purple-600 text-white p-3 rounded-xl group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-700">Profil Saya</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>