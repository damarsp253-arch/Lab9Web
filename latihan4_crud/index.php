<?php
/**
 * index.php - titik masuk aplikasi sekaligus router.
 * Akses: index.php?page=<nama-rute>
 */
session_start();
define('APP_ROUTER', true);

require_once __DIR__ . '/config/database.php';   // koneksi ($conn)
require_once __DIR__ . '/helpers/functions.php'; // function umum

// Whitelist rute: key = nilai ?page=, file = file yang dimuat,
// title = judul halaman, menu = menu navigasi yang ditandai aktif
$routes = [
    'dashboard'     => ['file' => __DIR__ . '/views/dashboard.php',        'title' => 'Dashboard',      'menu' => 'dashboard'],
    'barang/list'   => ['file' => __DIR__ . '/modules/barang/list.php',    'title' => 'Data Barang',    'menu' => 'barang/list'],
    'barang/add'    => ['file' => __DIR__ . '/modules/barang/add.php',     'title' => 'Tambah Barang',  'menu' => 'barang/add'],
    'barang/edit'   => ['file' => __DIR__ . '/modules/barang/edit.php',    'title' => 'Ubah Barang',    'menu' => 'barang/list'],
    'barang/delete' => ['file' => __DIR__ . '/modules/barang/delete.php',  'title' => 'Hapus Barang',   'menu' => 'barang/list'],
];

// Menu navigasi: key rute => teks menu
$menu = [
    'dashboard'   => 'Dashboard',
    'barang/list' => 'Data Barang',
    'barang/add'  => 'Tambah Barang',
];

$page = $_GET['page'] ?? 'dashboard';

if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $currentMenu = null;
    $pageTitle   = '404 - Tidak Ditemukan';
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $currentMenu = $routes[$page]['menu'];
    $pageTitle   = $routes[$page]['title'];
    $contentFile = $routes[$page]['file'];
}

// Konten dijalankan lebih dulu (ditampung di buffer) supaya modul dapat
// melakukan redirect setelah simpan/ubah/hapus sebelum header HTML dikirim.
ob_start();
require $contentFile;
$content = ob_get_clean();

require_once __DIR__ . '/views/header.php';
echo $content;
require_once __DIR__ . '/views/footer.php';
