<?php
/** Class untuk mengelola data kategori resep. */
class Category
{
    private $db;

    /** Menerima koneksi database. @param mysqli $db */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /** Mengambil semua kategori. @return array */
    public function getAll()
    {
        $statement = $this->db->prepare('SELECT id, name FROM categories ORDER BY name');
        $statement->execute();
        $result = $statement->get_result();
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $categories;
    }

    /** Mengambil satu kategori berdasarkan id. @param int $id @return array|null */
    public function getById($id)
    {
        $statement = $this->db->prepare('SELECT id, name FROM categories WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $category = $statement->get_result()->fetch_assoc();
        $statement->close();
        return $category;
    }

    /** Menambahkan kategori. @param string $name @return bool */
    public function create($name)
    {
        $statement = $this->db->prepare('INSERT INTO categories (name) VALUES (?)');
        $statement->bind_param('s', $name);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }

    /** Mengubah kategori. @param int $id @param string $name @return bool */
    public function update($id, $name)
    {
        $statement = $this->db->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $statement->bind_param('si', $name, $id);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }

    /** Menghapus kategori. @param int $id @return bool */
    public function delete($id)
    {
        $statement = $this->db->prepare('DELETE FROM categories WHERE id = ?');
        $statement->bind_param('i', $id);
        $success = $statement->execute();
        $statement->close();
        return $success;
    }
}