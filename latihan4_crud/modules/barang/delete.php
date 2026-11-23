<?php
if (!defined('APP_ROUTER')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

// Penghapusan hanya boleh lewat POST + token CSRF, bukan sekadar membuka URL
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash('error', 'Penghapusan harus dilakukan melalui tombol Hapus.');
    redirect('barang/list');
}
if (!csrfValid($_POST['csrf_token'] ?? null)) {
    setFlash('error', 'Token keamanan tidak valid.');
    redirect('barang/list');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false || $id === null) {
    setFlash('error', 'ID barang tidak valid.');
    redirect('barang/list');
}

// Ambil nama gambar dulu agar file-nya ikut dihapus
$stmt = mysqli_prepare($conn, 'SELECT gambar FROM data_barang WHERE id_barang = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$barang) {
    setFlash('error', 'Data barang tidak ditemukan.');
    redirect('barang/list');
}

$stmt = mysqli_prepare($conn, 'DELETE FROM data_barang WHERE id_barang = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

hapusFileGambar($barang['gambar']);

setFlash('success', 'Barang berhasil dihapus.');
redirect('barang/list');
