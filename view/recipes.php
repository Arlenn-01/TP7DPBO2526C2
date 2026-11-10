<?php
// View resep mengambil daftar resep dan kategori melalui object masing-masing.
$recipes = $recipe->getAll();
$categories = $category->getAll();
$editRecipe = null;
if (isset($_GET['edit']) && ctype_digit($_GET['edit'])) {
    $editRecipe = $recipe->getById((int) $_GET['edit']);
}
?>
<section class="page-heading"><h2>Resep</h2><p>Daftar resep dan langkah memasaknya.</p></section>
<form method="post" class="form-card">
    <input type="hidden" name="action" value="<?= $editRecipe ? 'update_recipe' : 'create_recipe'; ?>">
    <?php if ($editRecipe): ?><input type="hidden" name="id" value="<?= (int) $editRecipe['id']; ?>"><?php endif; ?>
    <label for="recipe-title">Judul resep</label>
    <input id="recipe-title" type="text" name="title" required value="<?= $editRecipe ? htmlspecialchars($editRecipe['title'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    <label for="recipe-category">Kategori</label>
    <select id="recipe-category" name="category_id" required>
        <option value="">Pilih kategori</option>
        <?php foreach ($categories as $item): ?>
            <option value="<?= (int) $item['id']; ?>" <?= $editRecipe && $editRecipe['category_id'] == $item['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></option>
        <?php endforeach; ?>
    </select>
    <label for="cook-time">Waktu masak (menit)</label>
    <input id="cook-time" type="number" name="cook_time" min="1" required value="<?= $editRecipe ? (int) $editRecipe['cook_time'] : ''; ?>">
    <label for="instructions">Instruksi</label>
    <textarea id="instructions" name="instructions" required><?= $editRecipe ? htmlspecialchars($editRecipe['instructions'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
    <button type="submit"><?= $editRecipe ? 'Simpan Perubahan' : 'Tambah Resep'; ?></button>
    <?php if ($editRecipe): ?><a class="button secondary" href="index.php?page=recipes">Batal</a><?php endif; ?>
</form>
<table>
    <thead><tr><th>Judul</th><th>Kategori</th><th>Waktu</th><th>Instruksi</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($recipes as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($item['category_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= (int) $item['cook_time']; ?> menit</td>
            <td><?= nl2br(htmlspecialchars($item['instructions'], ENT_QUOTES, 'UTF-8')); ?></td>
            <td class="actions">
                <a class="button secondary" href="index.php?page=recipes&amp;edit=<?= (int) $item['id']; ?>">Edit</a>
                <a class="button secondary" href="index.php?page=ingredients&amp;recipe_id=<?= (int) $item['id']; ?>">Bahan</a>
                <form method="post" class="inline-form">
                    <input type="hidden" name="action" value="delete_recipe">
                    <input type="hidden" name="id" value="<?= (int) $item['id']; ?>">
                    <button class="danger" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>