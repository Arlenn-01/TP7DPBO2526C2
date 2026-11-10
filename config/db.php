<?php
/** Class untuk membuat koneksi database aplikasi. */
class Database
{
    private $host = 'localhost';
    private $user = 'recipe_user';
    private $password = 'tp7wow';
    private $database = 'db_recipes';

    /** Membuat koneksi mysqli dan mengatur charset. @return mysqli */
    public function connect()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($connection->connect_error) {
            die('Koneksi database gagal. Periksa konfigurasi di config/db.php.');
        }
        $connection->set_charset('utf8mb4');
        return $connection;
    }
}