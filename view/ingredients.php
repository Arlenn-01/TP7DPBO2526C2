<?php
// View bahan dapat memfilter bahan berdasarkan recipe_id.
$recipes = $recipe->getAll();
$recipeId = isset($_GET['recipe_id']) && ctype_digit($_GET['recipe_id']) ? (int) $_GET['recipe_id'] : 0;
$ingredients = $recipeId > 0 ? $ingredient->getByRecipe($recipeId) : $ingredient->getAll();
$editIngredient = null;
if (isset($_GET['edit']) && ctype_digit($_GET['edit'])) {
    $editIngredient = $ingredient->getById((int) $_GET['edit']);
}
?>
<section class="page-heading"><h2>Bahan</h2><p>Kelola bahan untuk setiap resep.</p></section>
<form method="post" class="form-card">
    <input type="hidden" name="action" value="<?= $editIngredient ? 'update_ingredient' : 'create_ingredient'; ?>">
    <?php if ($editIngredient): ?><input type="hidden" name="id" value="<?= (int) $editIngredient['id']; ?>"><?php endif; ?>
    <label for="ingredient-recipe">Resep</label>
    <select id="ingredient-recipe" name="recipe_id" required>
        <option value="">Pilih resep</option>
        <?php foreach ($recipes as $item): ?>
            <option value="<?= (int) $item['id']; ?>" <?= ($editIngredient && $editIngredient['recipe_id'] == $item['id']) || (!$editIngredient && $recipeId == $item['id']) ? 'selected' : ''; ?>><?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></option>
        <?php endforeach; ?>
    </select>
    <label for="ingredient-name">Nama bahan</label>
    <input id="ingredient-name" type="text" name="name" required value="<?= $editIngredient ? htmlspecialchars($editIngredient['name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    <label for="ingredient-amount">Jumlah</label>
    <input id="ingredient-amount" type="text" name="amount" required placeholder="Contoh: 2 siung" value="<?= $editIngredient ? htmlspecialchars($editIngredient['amount'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    <button type="submit"><?= $editIngredient ? 'Simpan Perubahan' : 'Tambah Bahan'; ?></button>
    <?php if ($editIngredient): ?><a class="button secondary" href="index.php?page=ingredients">Batal</a><?php endif; ?>
</form>
<table>
    <thead><tr><th>Resep</th><th>Nama bahan</th><th>Jumlah</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($ingredients as $item): ?>
        <tr>
            <td><?= htmlspecialchars(isset($item['recipe_title']) ? $item['recipe_title'] : $recipe->getById($item['recipe_id'])['title'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($item['amount'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="actions">
                <a class="button secondary" href="index.php?page=ingredients&amp;edit=<?= (int) $item['id']; ?>">Edit</a>
                <form method="post" class="inline-form">
                    <input type="hidden" name="action" value="delete_ingredient">
                    <input type="hidden" name="id" value="<?= (int) $item['id']; ?>">
                    <button class="danger" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>