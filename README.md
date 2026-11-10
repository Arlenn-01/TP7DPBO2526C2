# Katalog Resep Masakan

Proyek ini adalah aplikasi PHP Native berorientasi objek untuk mengelola kategori, resep, dan bahan masakan. Aplikasi tidak memakai framework, Composer, JavaScript, atau library eksternal.

## Menjalankan di Arch Linux

1. Pastikan ekstensi `mysqli` aktif. Buka konfigurasi PHP:

   ```bash
   sudo nano /etc/php/php.ini
   ```

   Pastikan baris berikut aktif (tidak diawali tanda `;`):

   ```ini
   extension=mysqli
   ```

2. Nyalakan MariaDB dan buat user database khusus proyek:

   ```bash
   sudo systemctl enable --now mariadb
   sudo mariadb
   ```

   Jalankan SQL berikut di prompt MariaDB:

   ```sql
   CREATE USER 'recipe_user'@'localhost' IDENTIFIED BY 'ganti_password_ini';
   GRANT ALL PRIVILEGES ON db_recipes.* TO 'recipe_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

   Sesuaikan nilai password di `config/db.php` dan perintah `CREATE USER` jika diperlukan.

3. Import database dan data contoh melalui command line:

   ```bash
   mariadb -u root -p < database/db_recipes.sql
   ```

4. Jalankan server bawaan PHP dari folder proyek:

   ```bash
   php -S localhost:8000
   ```

   Buka `http://localhost:8000` di browser.

## Alur Program

Browser mengakses `index.php`. File tersebut memuat class dari `class/`, membuat koneksi dari `config/db.php`, memproses POST, lalu memilih view berdasarkan whitelist parameter `page`. View memanggil method class untuk mengambil atau mengubah data. Setelah POST, aplikasi melakukan redirect agar memakai pola Post-Redirect-Get.

- `class/`: class `Category`, `Recipe`, dan `Ingredient` dengan method CRUD.
- `config/`: konfigurasi dan class koneksi mysqli.
- `database/`: struktur tabel, foreign key, dan data contoh.
- `view/`: header, footer, dan halaman HTML untuk tiap tabel.
- `index.php`: controller dan routing halaman.
- `style.css`: tampilan sederhana aplikasi.

Semua query menggunakan prepared statement. Foreign key kategori memakai `ON DELETE RESTRICT`, sedangkan bahan resep memakai `ON DELETE CASCADE`.