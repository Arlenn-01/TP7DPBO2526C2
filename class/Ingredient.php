<?php
/** Class untuk mengelola data bahan resep dan relasinya dengan resep. */
class Ingredient
{
    private $db;

    /** Menerima koneksi database. @param mysqli $db */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /** Mengambil semua bahan beserta judul resep. @return array */
    public function getAll()
    {
        $statement = $this->db->prepare('SELECT ingredients.id, ingredients.recipe_id, ingredients.name, ingredients.amount, recipes.title AS recipe_title FROM ingredients JOIN recipes ON recipes.id = ingredients.recipe_id ORDER BY ingredients.id DESC');
        $statement->execute();
        $ingredients = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $ingredients;
    }

    /** Mengambil satu bahan. @param int $id @return array|null */
    public function getById($id)
    {
        $statement = $this->db->prepare('SELECT id, recipe_id, name, amount FROM ingredients WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $ingredient = $statement->get_result()->fetch_assoc();
        $statement->close();
        return $ingredient;
    }

    /** Mengambil bahan dari satu resep. @param int $recipeId @return array */
    public function getByRecipe($recipeId)
    {
        $statement = $this->db->prepare('SELECT id, recipe_id, name, amount FROM ingredients WHERE recipe_id = ? ORDER BY id');
        $statement->bind_param('i', $recipeId);
        $statement->execute();
        $ingredients = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $ingredients;
    }

    /** Menambahkan bahan. @param int $recipeId @param string $name @param string $amount @return bool */
    public function create($recipeId, $name, $amount)
    {
        $statement = $this->db->prepare('INSERT INTO ingredients (recipe_id, name, amount) VALUES (?, ?, ?)');
        $statement->bind_param('iss', $recipeId, $name, $amount);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }

    /** Mengubah bahan. @param int $id @param int $recipeId @param string $name @param string $amount @return bool */
    public function update($id, $recipeId, $name, $amount)
    {
        $statement = $this->db->prepare('UPDATE ingredients SET recipe_id = ?, name = ?, amount = ? WHERE id = ?');
        $statement->bind_param('issi', $recipeId, $name, $amount, $id);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }

    /** Menghapus bahan. @param int $id @return bool */
    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM ingredients WHERE id = ?');
        $statement->bind_param('i', $id);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }
}