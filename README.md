# Katalog Resep Masakan

Proyek ini adalah aplikasi PHP Native berorientasi objek untuk mengelola kategori, resep, dan bahan masakan. Aplikasi tidak memakai framework, Composer, JavaScript, atau library eksternal.

## Tema Web

Website ini mengangkat tema katalog resep masakan. Pengguna dapat melihat daftar
resep, kategori, dan bahan yang digunakan, serta mengelola data tersebut melalui
formulir tambah, ubah, dan hapus. Tampilan dibuat sederhana dan mudah dibaca
dengan nuansa warna hijau, krem, dan putih yang memberi kesan alami serta sesuai
dengan tema makanan.

## Database dan Tabel

Aplikasi menggunakan database MySQL/MariaDB bernama `db_recipes` dengan tiga
tabel utama:

- `categories`: menyimpan `id` dan `name` kategori resep.
- `recipes`: menyimpan `id`, kategori, judul, waktu masak, dan instruksi resep.
  Kolom `category_id` menjadi foreign key ke tabel `categories`.
- `ingredients`: menyimpan `id`, resep, nama bahan, dan jumlah bahan. Kolom
  `recipe_id` menjadi foreign key ke tabel `recipes`.

Relasi kategori ke resep menggunakan `ON DELETE RESTRICT` agar kategori yang
masih dipakai tidak dapat dihapus. Relasi resep ke bahan menggunakan
`ON DELETE CASCADE`, sehingga bahan ikut terhapus ketika resepnya dihapus.

File `database/db_recipes.sql` berisi pembuatan database, struktur tabel,
foreign key, dan data contoh.

## Alur Program

Browser mengakses `index.php` sebagai controller utama. File tersebut memuat
class dari folder `class/`, membuat koneksi database melalui `config/db.php`,
dan menentukan halaman berdasarkan parameter `page`. Hanya halaman
`categories`, `recipes`, dan `ingredients` yang diizinkan.

Saat menerima request `POST`, `index.php` memeriksa action formulir, memvalidasi
data, lalu memanggil method CRUD pada class yang sesuai. Setelah proses selesai,
aplikasi menyimpan pesan status ke session dan melakukan redirect ke halaman
sebelumnya agar tidak terjadi pengiriman ulang formulir saat browser di-refresh.

Untuk request halaman biasa, controller memuat `view/header.php`, memilih view
berdasarkan halaman yang diminta, lalu memuat `view/footer.php`. Setiap view
mengambil data melalui object `Category`, `Recipe`, atau `Ingredient`, kemudian
menampilkan formulir dan tabel data. Semua query database menggunakan prepared
statement, sedangkan output dari database di-escape menggunakan
`htmlspecialchars()` sebelum ditampilkan.

- `class/`: class `Category`, `Recipe`, dan `Ingredient` dengan method CRUD.
- `config/`: konfigurasi dan class koneksi mysqli.
- `database/`: struktur tabel, foreign key, dan data contoh.
- `view/`: header, footer, dan halaman HTML untuk tiap tabel.
- `index.php`: controller dan routing halaman.
- `style.css`: tampilan sederhana aplikasi.

Semua query menggunakan prepared statement. Foreign key kategori memakai `ON DELETE RESTRICT`, sedangkan bahan resep memakai `ON DELETE CASCADE`.