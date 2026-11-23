<?php
/**
 * config/database.php
 * Satu-satunya tempat koneksi database dikelola (MySQLi, sama seperti Lab8).
 * Variabel $conn dipakai oleh seluruh modul.
 */
if (!defined('APP_ROUTER')) {
    http_response_code(403);
    exit('Akses langsung tidak diizinkan.');
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'latihan1';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($host, $user, $pass, $db);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    // Detail error tidak ditampilkan kepada pengguna
    error_log($e->getMessage());
    http_response_code(500);
    exit('Terjadi kesalahan pada koneksi database.');
}
