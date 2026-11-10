<?php
/** Class untuk mengelola data resep dan relasinya dengan kategori. */
class Recipe
{
    private $db;

    /** Menerima koneksi database. @param mysqli $db */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /** Mengambil semua resep beserta nama kategori. @return array */
    public function getAll()
    {
        $statement = $this->db->prepare('SELECT recipes.id, recipes.category_id, recipes.title, recipes.cook_time, recipes.instructions, categories.name AS category_name FROM recipes JOIN categories ON categories.id = recipes.category_id ORDER BY recipes.id DESC');
        $statement->execute();
        $recipes = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $recipes;
    }

    /** Mengambil satu resep. @param int $id @return array|null */
    public function getById($id)
    {
        $statement = $this->db->prepare('SELECT id, category_id, title, cook_time, instructions FROM recipes WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $recipe = $statement->get_result()->fetch_assoc();
        $statement->close();
        return $recipe;
    }

    /** Menambahkan resep. @param int $categoryId @param string $title @param int $cookTime @param string $instructions @return bool */
    public function create($categoryId, $title, $cookTime, $instructions)
    {
        $statement = $this->db->prepare('INSERT INTO recipes (category_id, title, cook_time, instructions) VALUES (?, ?, ?, ?)');
        $statement->bind_param('isis', $categoryId, $title, $cookTime, $instructions);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }

    /** Mengubah resep. @param int $id @param int $categoryId @param string $title @param int $cookTime @param string $instructions @return bool */
    public function update($id, $categoryId, $title, $cookTime, $instructions)
    {
        $statement = $this->db->prepare('UPDATE recipes SET category_id = ?, title = ?, cook_time = ?, instructions = ? WHERE id = ?');
        $statement->bind_param('isisi', $categoryId, $title, $cookTime, $instructions, $id);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }

    /** Menghapus resep. @param int $id @return bool */
    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM recipes WHERE id = ?');
        $statement->bind_param('i', $id);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }
}