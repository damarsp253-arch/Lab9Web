<?php
if (!defined('APP_ROUTER')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

// Validasi id dari URL
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false || $id === null) {
    setFlash('error', 'ID barang tidak valid.');
    redirect('barang/list');
}

// Ambil data barang
$stmt = mysqli_prepare($conn, 'SELECT * FROM data_barang WHERE id_barang = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$barang) {
    setFlash('error', 'Data barang tidak ditemukan.');
    redirect('barang/list');
}

$errors = [];
$old = [
    'nama'       => $barang['nama'],
    'kategori'   => $barang['kategori'],
    'harga_jual' => $barang['harga_jual'],
    'harga_beli' => $barang['harga_beli'],
    'stok'       => $barang['stok'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Token keamanan tidak valid. Muat ulang halaman lalu coba lagi.';
    } else {
        [$data, $errors] = validasiBarang($_POST);
        $old = $data;

        $gambarBaru = null;
        if (empty($errors)) {
            [$gambarBaru, $errUpload] = uploadGambar($_FILES['file_gambar'] ?? []);
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

            if ($gambarBaru !== null) {
                $stmt = mysqli_prepare(
                    $conn,
                    'UPDATE data_barang SET nama = ?, kategori = ?, harga_jual = ?, harga_beli = ?, stok = ?, gambar = ? WHERE id_barang = ?'
                );
                mysqli_stmt_bind_param($stmt, 'ssddisi', $nama, $kategori, $harga_jual, $harga_beli, $stok, $gambarBaru, $id);
            } else {
                $stmt = mysqli_prepare(
                    $conn,
                    'UPDATE data_barang SET nama = ?, kategori = ?, harga_jual = ?, harga_beli = ?, stok = ? WHERE id_barang = ?'
                );
                mysqli_stmt_bind_param($stmt, 'ssddii', $nama, $kategori, $harga_jual, $harga_beli, $stok, $id);
            }
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Gambar lama dihapus hanya jika diganti
            if ($gambarBaru !== null) {
                hapusFileGambar($barang['gambar']);
            }

            setFlash('success', 'Barang berhasil diubah.');
            redirect('barang/list');
        }
    }
}

$judulForm     = 'Ubah Barang';
$formAction    = 'index.php?page=barang/edit&id=' . $id;
$gambarSaatIni = $barang['gambar'];
require __DIR__ . '/form.php';
