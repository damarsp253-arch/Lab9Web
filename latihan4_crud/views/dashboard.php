<?php
if (!defined('APP_ROUTER')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

$ringkasan = mysqli_fetch_assoc(mysqli_query(
    $conn,
    'SELECT COUNT(*) AS total_jenis, COALESCE(SUM(stok), 0) AS total_stok FROM data_barang'
));
?>
<section class="content">
    <h2>Dashboard</h2>
    <ul>
        <li>Jumlah jenis barang: <strong><?php echo e($ringkasan['total_jenis']); ?></strong></li>
        <li>Total stok: <strong><?php echo e($ringkasan['total_stok']); ?></strong></li>
    </ul>
    <p>
        <a class="btn" href="index.php?page=barang/list">Lihat Data Barang</a>
        <a class="btn" href="index.php?page=barang/add">Tambah Barang</a>
    </p>
</section>
