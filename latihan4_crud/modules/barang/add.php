<?php
if (!defined('APP_ROUTER')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

$errors = [];
$old = ['nama' => '', 'kategori' => daftarKategori()[0], 'harga_jual' => '', 'harga_beli' => '', 'stok' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Token keamanan tidak valid. Muat ulang halaman lalu coba lagi.';
    } else {
        [$data, $errors] = validasiBarang($_POST);
        $old = $data; // agar isian form tidak hilang jika ada error

        $gambar = null;
        if (empty($errors)) {
            [$gambar, $errUpload] = uploadGambar($_FILES['file_gambar'] ?? []);
            if ($errUpload) {
                $errors[] = $errUpload;
            }
        }

        if (empty($errors)) {
            $nama       = $data['nama'];
            $kategori   = $data['kategori'];
            $harga_jual = (float) $data['harga_jual'];
            $harga_beli = (float) $data['harga_beli'];
            $stok       = (int) $data['stok'];
            $namaFile   = $gambar ?? '';

            $stmt = mysqli_prepare(
                $conn,
                'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) VALUES (?, ?, ?, ?, ?, ?)'
            );
            mysqli_stmt_bind_param($stmt, 'ssddis', $nama, $kategori, $harga_jual, $harga_beli, $stok, $namaFile);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            setFlash('success', 'Barang berhasil ditambahkan.');
            redirect('barang/list');
        }
    }
}

$judulForm      = 'Tambah Barang';
$formAction     = 'index.php?page=barang/add';
$gambarSaatIni  = null;
require __DIR__ . '/form.php';
