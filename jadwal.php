<?php
session_start();
// Proteksi Halaman
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// === DATA WALI KELAS ===
$waliKelas = [
    'X PPLG 1' => 'SITI HALUMA SADA, S.Pd.',
    'X PPLG 2' => 'DIAH PITALOKA KUSUMASTUTI, S.Pd.',
    'X TJKT 1' => 'NOVIM CICI HERBAVIANA, S.Kom, Gr.',
    'X TJKT 2' => 'ADE SHILVI VERAWATI, S.T.',
    'X PM 1' => 'MAX ARENS WALALAYO, S.Pd',
    'X PM 2' => 'CITRA KUMALASARI, M.Pd',
    'X MPLB 1' => 'PUTY CHANDRA DARMAJANTI, M.Pd',
    'X MPLB 2' => 'KATMIRAH, S.Pd',
    'X AKL 1' => 'DIAN NOVIA PURWANDARI, S.Pd',
    'X AKL 2' => 'RIZKY KUSUMA DEWI, S.Pd',
    'X AKL 3' => 'ERWYN FRIANDRIAS, S.Pd.',
    'X PH 1' => 'TAMIM ZUHRI, S.Pd',
    'X PH 2' => 'REYNI DESITA, S.IP.',
    'X PH 3' => 'TUTIK HARIYANI, S.Pd',
    'X KL 1' => 'DINI ANGGA MAHARANI, S.Pd',
    'X DKV 1' => 'ENI KHOIRIYAH, S.Pd',
    'X DKV 2' => 'WIDYAWATI, S.E',
    'X SP 1' => 'ANY EKA NUR HIDAYATI, S.Pd.',
    'X SP 2' => 'TITIS VIDYA NURINA, S.PD',
    'X BDP 1' => 'LILIK ERNAWATI, S.S.',
    'X BDP 2' => 'AGUS SUPRANTIYONO, S.Pd',
    'X ULP 1' => 'MOH. YUSRON, S.Pd.',
    'X ULP 2' => 'YUDI WAHYU PRABASANGKA., S.E',
    'XI PPLG 1' => 'DWI ANGGRIAWAN, S.Pd',
    'XI PPLG 2' => 'TRI SUKESI SULISTYOWATI, M.Pd.',
    'XI TJKT 1' => 'SAHLAN, S.Kom.',
    'XI TJKT 2' => 'HEPI SETIAWAN, S.Pd.',
    'XI PM 1' => 'ANGGUN SETYANINGTYAS, S.Pd',
    'XI PM 2' => 'LUDFY YANA, S.Pd',
    'XI MPLB 1' => 'ELIA ROSA, S.Pd.',
    'XI MPLB 2' => 'M. YUSUF, M.Pd',
    'XI AKL 1' => 'YUSTA RIANDA, S.Pd.',
    'XI AKL 2' => 'MOHAMAD NOR SHODIQ, S.Pd',
    'XI AKL 3' => 'M. DIGDAYA KHARISMA W., S.Pd.',
    'XI PH 1' => 'HASBY MAULIDZANA AL-AMIN, M.Pd.',
    'XI PH 2' => 'SUHARTATIK, S.Pd',
    'XI PH 3' => 'KHOIRUN NISA MAULIDYAH. S.Pd, Gr',
    'XI KL 1' => 'ANUNGGILING TYAS ADI R., S.Pd',
    'XI DKV 1' => 'SHEILA NURVATISNA, S.Pd.',
    'XI DKV 2' => 'SHIELDA SELINA, S.Pd.',
    'XI SP 1' => 'SITI ISTIQOMAH, S.Pd.I.',
    'XI BDP 1' => 'MUNTAMAH KHOIR, S.Pd',
    'XI BDP 2' => 'ENDANG WIJIATI, S.Pd., M.Pd',
    'XI ULP 1' => 'TIURMA SRIULINA BR. SILAEN',
    'XI ULP 2' => 'RETNO DAMAYANTI, S.PdI',
];

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
            ['jam' => '13:00 - 15:15', 'mapel' => 'Pengembangan Gim', 'ruang' => 'B.2', 'guru' => 'NOVAL HARWIN ROZIN, S.Kom'],
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
            ['jam' => '13:00 - 15:15', 'mapel' => 'Tehnik Komputer dan Jaringan', 'ruang' => 'B.4', 'guru' => 'DWI HANDAYANI, S.Kom'],
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
            ['jam' => '10:45 - 15:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'L.2', 'guru' => 'Dra. IDA SURYANINGRUM'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ANDI WAHYUDI, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'L.2', 'guru' => 'YUDI WAHYU PRABASANGKA., S.E'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Matematika', 'ruang' => 'L.2', 'guru' => 'SHELA OKTA GREFINA, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'L.2', 'guru' => 'CITRA KUMALASARI, M.Pd'],
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
            ['jam' => '09:15 - 12:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.3', 'guru' => 'MOHAMAD NOR SHODIQ, S.Pd'],
            ['jam' => '12:45 - 15:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'HANIF IRIANTO, S.Pd'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Seni Rupa', 'ruang' => 'F.3', 'guru' => 'REYNI DESITA, S.IP.'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'F.3', 'guru' => 'MOHAMAD NOR SHODIQ, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'F.3', 'guru' => 'ENDANG WIJIATI, S.Pd., M.Pd'],
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
            ['jam' => '12:15 - 15:15', 'mapel' => 'Pendidikan Agama dan Budi Pekerti', 'ruang' => 'F.3', 'guru' => 'HARIS BUDI UTOMO, S.Ag.'],
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
            ['jam' => '09:15 - 12:45', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.3', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '12:45 - 15:15', 'mapel' => 'Bahasa Indonesia', 'ruang' => 'N.3', 'guru' => 'DIDIK SUPRIYADI, S.S.'],
        ],
        'Selasa' => [
            ['jam' => '06:45 - 09:00', 'mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'ruang' => 'LAPANGAN', 'guru' => 'ERWYN FRIANDRIAS, S.Pd.'],
            ['jam' => '09:15 - 10:45', 'mapel' => 'Pendidikan Pancasila dan Kewarganegaraan', 'ruang' => 'N.3', 'guru' => 'Dra. ISTI\'AH'],
            ['jam' => '10:45 - 12:15', 'mapel' => 'Bahasa Inggris', 'ruang' => 'N.3', 'guru' => 'POLIN FEBIANA, S.Pd'],
            ['jam' => '12:15 - 15:15', 'mapel' => 'Matematika', 'ruang' => 'N.3', 'guru' => 'UMI RAHAYU, S.Pd.'],
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


// === LOGIKA PEMILIHAN KELAS ===
$daftarKelas = array_keys($allJadwal);
sort($daftarKelas);

$kelasDipilih = $_GET['kelas'] ?? '';

// Validasi kelas yang dipilih
if ($kelasDipilih && !isset($allJadwal[$kelasDipilih])) {
    $kelasDipilih = '';
}

// Ambil jadwal kelas yang dipilih
$jadwalKelas = $kelasDipilih ? $allJadwal[$kelasDipilih] : [];
$waliKelasSaya = $kelasDipilih ? ($waliKelas[$kelasDipilih] ?? 'Belum Ditentukan') : '';

// Hitung total jam per minggu
$totalJam = 0;
foreach ($jadwalKelas as $hari => $sessions) {
    $totalJam += count($sessions);
}

// Hari ini
$hariIndonesia = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$hariIniIndex = date('N');
$hariIniNama = $hariIndonesia[$hariIniIndex];
$tanggalHariIni = date('d F Y');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - SmartPresence</title>
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
    <!-- SIDEBAR -->
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
                    <a href="jadwal.php" class="flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 rounded-xl text-sm font-semibold border-l-4 border-blue-500 shadow-sm transition-all duration-300">
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
                <h2 class="text-xl font-bold text-gray-800">Jadwal Pelajaran</h2>
                <p class="text-xs text-gray-500">Tahun Ajaran 2026/2027 - Semester Ganjil</p>
            </div>
            <div class="flex gap-3">
                <?php if ($kelasDipilih): ?>
                    <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all shadow-lg shadow-emerald-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Jadwal
                    </button>
                <?php endif; ?>
            </div>
        </header>

        <div class="p-8">
            <!-- PILIH KELAS -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
                <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Kelas</label>
                        <select name="kelas" onchange="this.form.submit()" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Kelas --</option>
                            <?php
                            // Kelompokkan kelas X dan XI
                            $kelasX = array_filter($daftarKelas, fn($k) => strpos($k, 'X ') === 0);
                            $kelasXI = array_filter($daftarKelas, fn($k) => strpos($k, 'XI ') === 0);
                            ?>
                            <optgroup label="Kelas X">
                                <?php foreach ($kelasX as $k): ?>
                                    <option value="<?= htmlspecialchars($k) ?>" <?= $kelasDipilih === $k ? 'selected' : '' ?>><?= htmlspecialchars($k) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Kelas XI">
                                <?php foreach ($kelasXI as $k): ?>
                                    <option value="<?= htmlspecialchars($k) ?>" <?= $kelasDipilih === $k ? 'selected' : '' ?>><?= htmlspecialchars($k) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                    <?php if ($kelasDipilih): ?>
                        <a href="jadwal.php" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-sm transition-all">
                            Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <?php if (!$kelasDipilih): ?>
                <!-- EMPTY STATE -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Pilih Kelas untuk Melihat Jadwal</h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto">Silakan pilih kelas dari dropdown di atas untuk melihat jadwal pelajaran lengkap.</p>
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3 max-w-2xl mx-auto">
                        <?php foreach (array_slice($daftarKelas, 0, 8) as $k): ?>
                            <a href="?kelas=<?= urlencode($k) ?>" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                                <?= htmlspecialchars($k) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- INFO KELAS -->
                <div class="mb-6 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Kelas</p>
                            <h1 class="text-3xl font-bold mt-1"><?= htmlspecialchars($kelasDipilih) ?></h1>
                            <p class="text-blue-100 mt-2">Wali Kelas: <span class="font-semibold text-white"><?= htmlspecialchars($waliKelasSaya) ?></span></p>
                            <p class="text-blue-100 text-sm mt-1">Tahun Ajaran 2026/2027 - Semester Ganjil</p>
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl text-center">
                                <p class="text-xs text-blue-100">Total Jam/Minggu</p>
                                <p class="text-2xl font-bold"><?= $totalJam ?></p>
                            </div>
                            <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl text-center">
                                <p class="text-xs text-blue-100">Hari Ini</p>
                                <p class="text-2xl font-bold"><?= $hariIniNama ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- JADWAL PER HARI (CARD) -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-6">
                    <?php foreach ($jadwalKelas as $hari => $sessions):
                        $isToday = ($hari === $hariIniNama);
                    ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden <?= $isToday ? 'ring-2 ring-blue-500' : '' ?>">
                            <div class="<?= $isToday ? 'bg-blue-600' : 'bg-gray-50' ?> px-4 py-3 flex justify-between items-center">
                                <h3 class="font-bold <?= $isToday ? 'text-white' : 'text-gray-800' ?>"><?= $hari ?></h3>
                                <?php if ($isToday): ?>
                                    <span class="text-[10px] bg-white/20 text-white px-2 py-0.5 rounded-full">Hari Ini</span>
                                <?php endif; ?>
                            </div>
                            <div class="p-3 space-y-2">
                                <?php if (empty($sessions)): ?>
                                    <div class="text-center py-4 text-gray-400 text-xs italic">Tidak ada jadwal</div>
                                <?php else: ?>
                                    <?php foreach ($sessions as $session): ?>
                                        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 hover:shadow-md transition-shadow">
                                            <p class="text-xs font-bold text-blue-600 mb-1"><?= $session['jam'] ?></p>
                                            <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($session['mapel']) ?></p>
                                            <p class="text-xs text-gray-500 mt-1">📍 <?= htmlspecialchars($session['ruang']) ?></p>
                                            <?php if ($session['guru'] !== '-'): ?>
                                                <p class="text-[10px] text-gray-400 mt-0.5 truncate">👨‍🏫 <?= htmlspecialchars($session['guru']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- TABEL JADWAL LENGKAP -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <div>
                            <h3 class="font-bold text-gray-800">Tabel Jadwal Lengkap</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Jadwal pelajaran kelas <?= htmlspecialchars($kelasDipilih) ?></p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Hari</th>
                                    <th class="px-6 py-4 font-semibold">Jam</th>
                                    <th class="px-6 py-4 font-semibold">Mata Pelajaran</th>
                                    <th class="px-6 py-4 font-semibold">Ruang</th>
                                    <th class="px-6 py-4 font-semibold">Pengajar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($jadwalKelas as $hari => $sessions): ?>
                                    <?php foreach ($sessions as $i => $session): ?>
                                        <tr class="hover:bg-gray-50 transition-colors <?= $hari === $hariIniNama ? 'bg-blue-50/30' : '' ?>">
                                            <?php if ($i === 0): ?>
                                                <td class="px-6 py-4 font-bold text-blue-600" rowspan="<?= count($sessions) ?>">
                                                    <?= $hari ?>
                                                    <?php if ($hari === $hariIniNama): ?>
                                                        <span class="ml-2 text-[10px] bg-blue-600 text-white px-2 py-0.5 rounded-full">Hari Ini</span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                            <td class="px-6 py-4 font-mono text-xs"><?= $session['jam'] ?></td>
                                            <td class="px-6 py-4 font-semibold text-gray-900"><?= htmlspecialchars($session['mapel']) ?></td>
                                            <td class="px-6 py-4">
                                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                    <?= htmlspecialchars($session['ruang']) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 text-sm"><?= htmlspecialchars($session['guru']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p class="font-semibold text-gray-900 mb-1">Informasi Jadwal</p>
                            <ul class="space-y-0.5 text-xs">
                                <li>• Jadwal ini berlaku untuk Tahun Ajaran 2026/2027 Semester Ganjil</li>
                                <li>• Jam pelajaran dapat berubah sewaktu-waktu sesuai kebijakan sekolah</li>
                                <li>• Upacara bendera dilaksanakan setiap hari Senin</li>
                                <li>• Jumat Bersih-Bertaqwa dilaksanakan setiap hari Jumat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>