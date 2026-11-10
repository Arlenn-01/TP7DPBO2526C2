<?php
// Header bersama untuk navigasi dan pesan aksi.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Resep Masakan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1>Katalog Resep Masakan</h1>
            <nav>
                <a href="index.php?page=recipes">Resep</a>
                <a href="index.php?page=categories">Kategori</a>
                <a href="index.php?page=ingredients">Bahan</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php if (!empty($_SESSION['message'])): ?>
            <div class="message <?= htmlspecialchars($_SESSION['message']['type'], ENT_QUOTES, 'UTF-8'); ?>">
                <?= htmlspecialchars($_SESSION['message']['text'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>