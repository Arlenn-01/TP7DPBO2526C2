CREATE DATABASE IF NOT EXISTS db_recipes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_recipes;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    cook_time INT NOT NULL,
    instructions TEXT NOT NULL,
    CONSTRAINT fk_recipes_category FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    amount VARCHAR(100) NOT NULL,
    CONSTRAINT fk_ingredients_recipe FOREIGN KEY (recipe_id) REFERENCES recipes(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO categories (name) VALUES
    ('Masakan Utama'), ('Makanan Ringan'), ('Minuman'), ('Kue');

INSERT INTO recipes (category_id, title, cook_time, instructions) VALUES
    (1, 'Nasi Goreng Rumahan', 20, 'Tumis bumbu, masukkan telur dan nasi, lalu aduk sampai rata.'),
    (1, 'Soto Ayam', 45, 'Rebus ayam, tumis bumbu, lalu masak semua bahan sampai kuah harum.'),
    (2, 'Pisang Goreng', 25, 'Celupkan pisang ke adonan tepung dan goreng sampai keemasan.'),
    (3, 'Es Teh Lemon', 10, 'Seduh teh, tambahkan perasan lemon dan es batu, lalu sajikan.');

INSERT INTO ingredients (recipe_id, name, amount) VALUES
    (1, 'Nasi putih', '2 piring'),
    (1, 'Telur', '2 butir'),
    (1, 'Bawang putih', '2 siung'),
    (2, 'Daging ayam', '500 gram'),
    (2, 'Serai', '1 batang');