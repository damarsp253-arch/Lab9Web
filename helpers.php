<?php
/**
 * helpers.php
 * Kumpulan function umum yang dipakai oleh banyak halaman.
 * Muat dengan: require_once __DIR__ . '/helpers.php';
 */

// Escaping teks sebelum ditampilkan ke HTML (mencegah XSS)
function e(string $nilai): string
{
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

// 1. Konversi suhu Celcius ke Fahrenheit: F = (C x 9/5) + 32
function konversiCelciusKeFahrenheit(float $c): float
{
    return ($c * 9 / 5) + 32;
}

// 2. Menentukan predikat berdasarkan rentang nilai
//    85-100 : A (Sangat Baik)
//    70-84  : B (Baik)
//    60-69  : C (Cukup)
//    50-59  : D (Kurang)
//    0-49   : E (Sangat Kurang)
function tentukanStatusNilai(float $nilai): string
{
    if ($nilai < 0 || $nilai > 100) {
        return 'Nilai tidak valid (harus 0-100)';
    }
    if ($nilai >= 85) {
        return 'A (Sangat Baik)';
    } elseif ($nilai >= 70) {
        return 'B (Baik)';
    } elseif ($nilai >= 60) {
        return 'C (Cukup)';
    } elseif ($nilai >= 50) {
        return 'D (Kurang)';
    }
    return 'E (Sangat Kurang)';
}

// 3. Menghitung total belanja = harga x jumlah
function hitungTotal(float $harga, int $jumlah): float
{
    return $harga * $jumlah;
}

// Pendukung: format angka menjadi Rupiah
function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
