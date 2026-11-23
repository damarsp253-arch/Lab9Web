<?php
/**
 * Bagian form yang dipakai bersama oleh add.php dan edit.php (bukan rute).
 * Variabel yang dibutuhkan: $judulForm, $formAction, $old, $errors, $gambarSaatIni
 */
if (!defined('APP_ROUTER')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }
?>
<section class="content">
    <h2><?php echo e($judulForm); ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo e($formAction); ?>" enctype="multipart/form-data">
        <?php echo csrfField(); ?>
        <div class="input">
            <label for="nama">Nama Barang</label>
            <input type="text" id="nama" name="nama" value="<?php echo e($old['nama']); ?>" required>
        </div>
        <div class="input">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori">
                <?php foreach (daftarKategori() as $kat): ?>
                    <option value="<?php echo e($kat); ?>"<?php echo ($old['kategori'] === $kat) ? ' selected' : ''; ?>><?php echo e($kat); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input">
            <label for="harga_jual">Harga Jual</label>
            <input type="text" id="harga_jual" name="harga_jual" value="<?php echo e($old['harga_jual']); ?>" required>
        </div>
        <div class="input">
            <label for="harga_beli">Harga Beli</label>
            <input type="text" id="harga_beli" name="harga_beli" value="<?php echo e($old['harga_beli']); ?>" required>
        </div>
        <div class="input">
            <label for="stok">Stok</label>
            <input type="text" id="stok" name="stok" value="<?php echo e($old['stok']); ?>" required>
        </div>
        <div class="input">
            <label for="file_gambar">File Gambar</label>
            <?php $urlLama = gambarUrl($gambarSaatIni); ?>
            <?php if ($urlLama): ?>
                <div><img class="preview" src="<?php echo e($urlLama); ?>" alt="Gambar saat ini"></div>
                <small>Pilih file baru hanya jika ingin mengganti gambar.</small>
            <?php endif; ?>
            <input type="file" id="file_gambar" name="file_gambar" accept="image/*">
        </div>
        <div class="submit">
            <button type="submit" class="btn">Simpan</button>
            <a href="index.php?page=barang/list">Batal</a>
        </div>
    </form>
</section>
