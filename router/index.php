<?php
/**
 * index.php - titik masuk aplikasi sekaligus router.
 * Akses: index.php?page=<nama-rute>
 */

// Function umum (e(), formatRupiah(), dll.) dari Latihan 2
require_once __DIR__ . '/../helpers.php';

// Daftar rute yang DIIZINKAN (whitelist).
// key   = nilai parameter ?page=
// file  = file konten yang dimuat (ditentukan aplikasi, bukan input URL)
// title = judul halaman
$routes = [
    'home'            => ['file' => __DIR__ . '/views/home.php',              'title' => 'Home'],
    'about'           => ['file' => __DIR__ . '/views/about.php',             'title' => 'Tentang'],
    'kontak'          => ['file' => __DIR__ . '/views/kontak.php',            'title' => 'Kontak'],
    'fungsi/suhu'     => ['file' => __DIR__ . '/modules/fungsi/suhu.php',     'title' => 'Konversi Suhu'],
    'fungsi/nilai'    => ['file' => __DIR__ . '/modules/fungsi/nilai.php',    'title' => 'Status Nilai'],
    'fungsi/belanja'  => ['file' => __DIR__ . '/modules/fungsi/belanja.php',  'title' => 'Total Belanja'],
];

// Menu navigasi: key rute => teks menu
$menu = [
    'home'           => 'Home',
    'about'          => 'Tentang',
    'kontak'         => 'Kontak',
    'fungsi/suhu'    => 'Suhu',
    'fungsi/nilai'   => 'Nilai',
    'fungsi/belanja' => 'Belanja',
];

// Ambil parameter page; jika tidak ada, gunakan 'home'
$page = $_GET['page'] ?? 'home';

// Validasi: harus string DAN terdaftar di whitelist
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $currentPage = null;
    $pageTitle   = '404 - Tidak Ditemukan';
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $currentPage = $page;
    $pageTitle   = $routes[$page]['title'];
    $contentFile = $routes[$page]['file'];
}

// Susun halaman: header + konten + footer
require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';