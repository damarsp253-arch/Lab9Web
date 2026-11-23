<?php
$hasil = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['celcius'] ?? '');
    if ($input === '' || !is_numeric($input)) {
        $error = 'Masukkan angka suhu yang valid.';
    } else {
        $hasil = konversiCelciusKeFahrenheit((float) $input);
    }
}
?>
<section class="content">
    <h2>Konversi Celcius ke Fahrenheit</h2>
    <form method="post" action="">
        <label for="celcius">Suhu (&deg;C)</label>
        <input type="text" id="celcius" name="celcius" value="<?php echo e($_POST['celcius'] ?? ''); ?>" required>
        <button type="submit">Konversi</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?php echo e($error); ?></p>
    <?php elseif ($hasil !== null): ?>
        <p class="hasil"><?php echo e($_POST['celcius']); ?>&deg;C = <strong><?php echo round($hasil, 2); ?>&deg;F</strong></p>
    <?php endif; ?>
</section>