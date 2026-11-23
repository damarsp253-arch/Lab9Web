 <?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';
?>
<section class="content">
    <h2>Ringkasan Pemanggilan Function</h2>
    <p>Halaman ini memanggil semua function dari <code>helpers.php</code> dengan nilai contoh.</p>
    <ul>
        <li>konversiCelciusKeFahrenheit(37) = <?php echo konversiCelciusKeFahrenheit(37); ?>&deg;F</li>
        <li>tentukanStatusNilai(78) = <?php echo e(tentukanStatusNilai(78)); ?></li>
        <li>hitungTotal(15000, 3) = <?php echo formatRupiah(hitungTotal(15000, 3)); ?></li>
    </ul>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
