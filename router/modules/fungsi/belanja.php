<?php
$total = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $harga  = trim($_POST['harga'] ?? '');
    $jumlah = trim($_POST['jumlah'] ?? '');
    if (!is_numeric($harga) || $harga < 0 || filter_var($jumlah, FILTER_VALIDATE_INT) === false || (int) $jumlah < 1) {
        $error = 'Harga harus angka (>= 0) dan jumlah harus bilangan bulat (>= 1).';
    } else {
        $total = hitungTotal((float) $harga, (int) $jumlah);
    }
}
?>
<section class="content">
    <h2>Hitung Total Belanja</h2>
    <form method="post" action="">
        <label for="harga">Harga satuan (Rp)</label>
        <input type="text" id="harga" name="harga" value="<?php echo e($_POST['harga'] ?? ''); ?>" required>
        <label for="jumlah">Jumlah</label>
        <input type="text" id="jumlah" name="jumlah" value="<?php echo e($_POST['jumlah'] ?? ''); ?>" required>
        <button type="submit">Hitung</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?php echo e($error); ?></p>
    <?php elseif ($total !== null): ?>
        <p class="hasil">Total belanja: <strong><?php echo formatRupiah($total); ?></strong></p>
    <?php endif; ?>
</section>