<?php
// Memuat class yang diperlukan oleh controller.
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/class/Category.php';
require_once __DIR__ . '/class/Recipe.php';
require_once __DIR__ . '/class/Ingredient.php';

session_start();
$database = new Database();
$db = $database->connect();
$category = new Category($db);
$recipe = new Recipe($db);
$ingredient = new Ingredient($db);

// Menyimpan pesan agar dapat ditampilkan setelah redirect.
function setMessage($type, $text)
{
	$_SESSION['message'] = array('type' => $type, 'text' => $text);
}

function isValidId($value)
{
	return isset($value) && ctype_digit((string) $value) && (int) $value > 0;
}

// Memproses semua perubahan data hanya melalui POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	try {
		if ($action === 'create_category' || $action === 'update_category') {
			$name = trim(isset($_POST['name']) ? $_POST['name'] : '');
			if ($name === '') {
				throw new Exception('Nama kategori wajib diisi.');
			}
			if ($action === 'create_category') {
				$category->create($name);
				setMessage('success', 'Kategori berhasil ditambahkan.');
			} elseif (isValidId(isset($_POST['id']) ? $_POST['id'] : null)) {
				$category->update((int) $_POST['id'], $name);
				setMessage('success', 'Kategori berhasil diubah.');
			} else {
				throw new Exception('ID kategori tidak valid.');
			}
		} elseif ($action === 'delete_category') {
			if (!isValidId(isset($_POST['id']) ? $_POST['id'] : null)) {
				throw new Exception('ID kategori tidak valid.');
			}
			$category->delete((int) $_POST['id']);
			setMessage('success', 'Kategori berhasil dihapus.');
		} elseif ($action === 'create_recipe' || $action === 'update_recipe') {
			$title = trim(isset($_POST['title']) ? $_POST['title'] : '');
			$instructions = trim(isset($_POST['instructions']) ? $_POST['instructions'] : '');
			$categoryId = isset($_POST['category_id']) ? $_POST['category_id'] : '';
			$cookTime = isset($_POST['cook_time']) ? $_POST['cook_time'] : '';
			if ($title === '' || $instructions === '' || !isValidId($categoryId) || !ctype_digit((string) $cookTime) || (int) $cookTime <= 0) {
				throw new Exception('Judul, kategori, instruksi, dan waktu masak harus diisi dengan benar.');
			}
			if ($action === 'create_recipe') {
				$recipe->create((int) $categoryId, $title, (int) $cookTime, $instructions);
				setMessage('success', 'Resep berhasil ditambahkan.');
			} elseif (isValidId(isset($_POST['id']) ? $_POST['id'] : null)) {
				$recipe->update((int) $_POST['id'], (int) $categoryId, $title, (int) $cookTime, $instructions);
				setMessage('success', 'Resep berhasil diubah.');
			} else {
				throw new Exception('ID resep tidak valid.');
			}
		} elseif ($action === 'delete_recipe') {
			if (!isValidId(isset($_POST['id']) ? $_POST['id'] : null)) {
				throw new Exception('ID resep tidak valid.');
			}
			$recipe->delete((int) $_POST['id']);
			setMessage('success', 'Resep berhasil dihapus beserta bahan-bahannya.');
		} elseif ($action === 'create_ingredient' || $action === 'update_ingredient') {
			$name = trim(isset($_POST['name']) ? $_POST['name'] : '');
			$amount = trim(isset($_POST['amount']) ? $_POST['amount'] : '');
			$recipeId = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : '';
			if ($name === '' || $amount === '' || !isValidId($recipeId)) {
				throw new Exception('Resep, nama bahan, dan jumlah wajib diisi.');
			}
			if ($action === 'create_ingredient') {
				$ingredient->create((int) $recipeId, $name, $amount);
				setMessage('success', 'Bahan berhasil ditambahkan.');
			} elseif (isValidId(isset($_POST['id']) ? $_POST['id'] : null)) {
				$ingredient->update((int) $_POST['id'], (int) $recipeId, $name, $amount);
				setMessage('success', 'Bahan berhasil diubah.');
			} else {
				throw new Exception('ID bahan tidak valid.');
			}
		} elseif ($action === 'delete_ingredient') {
			if (!isValidId(isset($_POST['id']) ? $_POST['id'] : null)) {
				throw new Exception('ID bahan tidak valid.');
			}
			$ingredient->delete((int) $_POST['id']);
			setMessage('success', 'Bahan berhasil dihapus.');
		}
	} catch (mysqli_sql_exception $exception) {
		setMessage('error', 'Aksi gagal. Data mungkin masih dipakai oleh data lain.');
	} catch (Exception $exception) {
		setMessage('error', $exception->getMessage());
	}

	// Redirect mencegah pengiriman ulang form saat halaman dimuat ulang.
	$redirectPage = isset($_GET['page']) ? $_GET['page'] : 'recipes';
	header('Location: index.php?page=' . urlencode($redirectPage));
	exit;
}

// Hanya halaman yang masuk whitelist yang boleh dirender.
$allowedPages = array('categories', 'recipes', 'ingredients');
$page = isset($_GET['page']) && in_array($_GET['page'], $allowedPages, true) ? $_GET['page'] : 'recipes';

require __DIR__ . '/view/header.php';
if ($page === 'categories') {
	require __DIR__ . '/view/categories.php';
} elseif ($page === 'ingredients') {
	require __DIR__ . '/view/ingredients.php';
} else {
	require __DIR__ . '/view/recipes.php';
}
require __DIR__ . '/view/footer.php';
