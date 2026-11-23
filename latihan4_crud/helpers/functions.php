<?php
/**
 * helpers/functions.php
 * Function umum yang dipakai oleh banyak modul.
 */

const DIR_GAMBAR = __DIR__ . '/../assets/gambar/';

// ---------- Tampilan ----------

// Escaping teks sebelum ditampilkan ke HTML (mencegah XSS)
function e($nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// ---------- Navigasi & pesan ----------

// Pindah ke halaman lain melalui router
function redirect(string $page): void
{
    header('Location: index.php?page=' . $page);
    exit;
}

function setFlash(string $type, string $text): void
{
    $_SESSION['flash'] = ['type' => $type, 'text' => $text];
}

// Ambil pesan sekali tampil, lalu hapus
function getFlash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

// ---------- Keamanan: CSRF ----------

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function csrfValid($token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

// ---------- Validasi data barang ----------

function daftarKategori(): array
{
    return ['Komputer', 'Elektronik', 'Hand Phone'];
}

// Mengembalikan [data_bersih, daftar_error]
function validasiBarang(array $in): array
{
    $errors = [];
    $data = [
        'nama'       => trim((string) ($in['nama'] ?? '')),
        'kategori'   => (string) ($in['kategori'] ?? ''),
        'harga_jual' => trim((string) ($in['harga_jual'] ?? '')),
        'harga_beli' => trim((string) ($in['harga_beli'] ?? '')),
        'stok'       => trim((string) ($in['stok'] ?? '')),
    ];

    if ($data['nama'] === '') {
        $errors[] = 'Nama barang wajib diisi.';
    }
    if (!in_array($data['kategori'], daftarKategori(), true)) {
        $errors[] = 'Kategori tidak valid.';
    }
    if (!is_numeric($data['harga_jual']) || $data['harga_jual'] < 0) {
        $errors[] = 'Harga jual harus berupa angka (0 atau lebih).';
    }
    if (!is_numeric($data['harga_beli']) || $data['harga_beli'] < 0) {
        $errors[] = 'Harga beli harus berupa angka (0 atau lebih).';
    }
    if (filter_var($data['stok'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $errors[] = 'Stok harus berupa bilangan bulat (0 atau lebih).';
    }

    return [$data, $errors];
}

// ---------- Gambar ----------

// Mengembalikan [nama_file_baru|null, pesan_error|null]
function uploadGambar(array $file): array
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, null]; // tidak ada file diunggah
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [null, 'Upload gambar gagal (kode ' . $file['error'] . ').'];
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        return [null, 'Ukuran gambar maksimal 2 MB.'];
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
        return [null, 'Format gambar harus jpg, jpeg, png, gif, atau webp.'];
    }
    if (@getimagesize($file['tmp_name']) === false) {
        return [null, 'File yang diunggah bukan gambar yang valid.'];
    }
    if (!is_dir(DIR_GAMBAR)) {
        mkdir(DIR_GAMBAR, 0755, true);
    }
    $nama = 'brg_' . bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], DIR_GAMBAR . $nama)) {
        return [null, 'Gagal menyimpan file gambar.'];
    }
    return [$nama, null];
}

// URL gambar untuk tag <img>; null jika tidak ada gambar
function gambarUrl($nama): ?string
{
    $base = basename((string) $nama); // data lama bisa berformat "gambar/x.png"
    if ($base === '') {
        return null;
    }
    return 'assets/gambar/' . rawurlencode($base);
}

function hapusFileGambar($nama): void
{
    $base = basename((string) $nama);
    if ($base !== '' && is_file(DIR_GAMBAR . $base)) {
        unlink(DIR_GAMBAR . $base);
    }
}
