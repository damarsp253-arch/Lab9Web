<?php
if (!defined('APP_ROUTER')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

$result = mysqli_query($conn, 'SELECT * FROM data_barang ORDER BY id_barang');
?>
<section class="content">
    <h2>Data Barang</h2>
    <p><a class="btn" href="index.php?page=barang/add">Tambah Barang</a></p>

    <div class="table-wrap">
    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>
                    <?php $url = gambarUrl($row['gambar']); ?>
                    <?php if ($url): ?>
                        <img src="<?php echo e($url); ?>" alt="<?php echo e($row['nama']); ?>">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?php echo e($row['nama']); ?></td>
                <td><?php echo e($row['kategori']); ?></td>
                <td><?php echo formatRupiah((float) $row['harga_jual']); ?></td>
                <td><?php echo formatRupiah((float) $row['harga_beli']); ?></td>
                <td><?php echo e($row['stok']); ?></td>
                <td class="aksi">
                    <a class="btn" href="index.php?page=barang/edit&amp;id=<?php echo (int) $row['id_barang']; ?>">Ubah</a>
                    <form method="post" action="index.php?page=barang/delete" class="inline"
                          onsubmit="return confirm('Yakin hapus barang ini?');">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="id" value="<?php echo (int) $row['id_barang']; ?>">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">Belum ada data</td></tr>
        <?php endif; ?>
    </table>
    </div>
</section>
