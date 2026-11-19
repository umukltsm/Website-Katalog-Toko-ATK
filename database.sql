CREATE DATABASE IF NOT EXISTS db_toko_atk;
USE db_toko_atk;

-- 1. tabel users untuk Role Admin
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- akun admin (username: admintoko, password: adminatk123)
INSERT INTO users (username, password) VALUES 
('admintoko', '$2y$10$wK8x9P2mQ7vL4nR1tY6zOuJ3hG5fD8sA0qW2eR4tY6uI8oP0aS2dF');

-- 2. tabel barang untuk Katalog & Stok ATK
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    foto VARCHAR(255) DEFAULT 'default.jpg'
);

-- 20 sampel data barang ATK 
INSERT INTO barang (nama_barang, kategori, harga, stok, foto) VALUES
-- kategori kertas
('Kertas HVS A4 Sinar Dunia', 'Kertas', 48000, 15, 'hvs_a4.jpg'),
('Kertas HVS F4 Sinar Dunia', 'Kertas', 53000, 12, 'hvs_f4.jpg'),
('Kertas Bufalo Warna Campur', 'Kertas', 22000, 7, 'kertas_bufalo.jpg'),
('Kertas Foto Glossy A4', 'Kertas', 28000, 9, 'kertas_foto.jpg'),
('Amplop Putih Polos Paperline', 'Kertas', 24000, 0, 'amplop_paperline.jpg'),

-- kategori alat tulis
('Pulpen Pilot Balliner Hitam', 'Alat Tulis', 18000, 24, 'pilot.jpg'),
('Pulpen Standard AE7 Hitam', 'Alat Tulis', 20000, 18, 'standard.jpg'),
('Pensil Stabilo 2B', 'Alat Tulis', 45000, 14, 'pensil_st_2b.jpg'),
('Spidol Whiteboard Snowman Hitam', 'Alat Tulis', 8500, 0, 'spidol_snowman.jpg'),
('Penghapus Pensil Joyko', 'Alat Tulis', 3500, 32, 'penghapus_joyko.jpg'),

-- kategori buku
('Buku Tulis Sidu 38 Lembar', 'Buku', 35000, 10, 'buku_sidu_38.jpg'),
('Buku Tulis Sidu 58 Lembar', 'Buku', 46000, 8, 'buku_sidu_58.jpg'),
('Buku Nota Kontan Paperline', 'Buku', 6500, 20, 'nota_kontan.jpg'),
('Buku Kwitansi Paperline', 'Buku', 5500, 16, 'kwitansi_paperline.jpg'),
('Buku Folio Bergaris Hardcover', 'Buku', 19000, 6, 'buku_folio.jpg'),

-- kategori peralatan kantor
('Map Snelhecter Plastik Merah', 'Peralatan Kantor', 3500, 30, 'map.jpg'),
('Stapler Kangaro HD-10', 'Peralatan Kantor', 12000, 9, 'stapler_kangaro.jpg'),
('Isi Staples Kenko No. 10', 'Peralatan Kantor', 3000, 40, 'isi_staples.jpg'),
('Lakban Bening Goldtape', 'Peralatan Kantor', 18500, 0, 'lakban_goldtape.jpg'),
('Gunting Kertas Joyko SC-838', 'Peralatan Kantor', 11000, 11, 'gunting_joyko.jpg');