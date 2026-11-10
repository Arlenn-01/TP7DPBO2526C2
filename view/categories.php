<?php
// View kategori mengambil data melalui object Category.
$categories = $category->getAll();
$editCategory = null;
if (isset($_GET['edit']) && ctype_digit($_GET['edit'])) {
    $editCategory = $category->getById((int) $_GET['edit']);
}
?>
<section class="page-heading">
    <h2>Kategori</h2>
    <p>Kelola kelompok resep yang tersedia.</p>
</section>
<form method="post" class="form-card">
    <input type="hidden" name="action" value="<?= $editCategory ? 'update_category' : 'create_category'; ?>">
    <?php if ($editCategory): ?><input type="hidden" name="id" value="<?= (int) $editCategory['id']; ?>"><?php endif; ?>
    <label for="category-name">Nama kategori</label>
    <input id="category-name" type="text" name="name" required value="<?= $editCategory ? htmlspecialchars($editCategory['name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    <button type="submit"><?= $editCategory ? 'Simpan Perubahan' : 'Tambah Kategori'; ?></button>
    <?php if ($editCategory): ?><a class="button secondary" href="index.php?page=categories">Batal</a><?php endif; ?>
</form>
<table>
    <thead><tr><th>No.</th><th>Nama</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($categories as $number => $item): ?>
        <tr>
            <td><?= $number + 1; ?></td>
            <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="actions">
                <a class="button secondary" href="index.php?page=categories&amp;edit=<?= (int) $item['id']; ?>">Edit</a>
                <form method="post" class="inline-form">
                    <input type="hidden" name="action" value="delete_category">
                    <input type="hidden" name="id" value="<?= (int) $item['id']; ?>">
                    <button class="danger" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>