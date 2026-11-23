<?php
$status = null;
$error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['nilai'] ?? '');
    if ($input === '' || !is_numeric($input)) {
        $error = 'Masukkan nilai berupa angka.';
    } else {
        $status = tentukanStatusNilai((float) $input);
    }
}
?>
<section class="content">
    <h2>Status Nilai</h2>
    <form method="post" action="">
        <label for="nilai">Nilai (0-100)</label>
        <input type="text" id="nilai" name="nilai" value="<?php echo e($_POST['nilai'] ?? ''); ?>" required>
        <button type="submit">Cek Status</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?php echo e($error); ?></p>
    <?php elseif ($status !== null): ?>
        <p class="hasil">Nilai <?php echo e($_POST['nilai']); ?> mendapat predikat <strong><?php echo e($status); ?></strong></p>
    <?php endif; ?>
</section>