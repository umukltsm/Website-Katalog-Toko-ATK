# Website Katalog Produk dan Manajemen Stok — UK Stationery (Toko ATK)

Website berbasis PHP dan MySQL (PDO) untuk menampilkan katalog produk alat tulis kantor secara real-time kepada pelanggan serta menyediakan panel manajemen stok bagi admin.

---

## Progres Milestone UAS — Tahap 1
Pengembangan tahap 1 berfokus pada perancangan basis data dan pembangunan halaman katalog publik pada branch `feature/katalog-atk`:

- [x] **Inisialisasi Repository & Struktur Proyek:** Membuat repository GitHub serta memisahkan struktur folder proyek (`config/`, `assets/img/`).
- [x] **Perancangan & Implementasi Basis Data (`database.sql`):** Membuat database `db_toko_atk` dengan tabel `users` (autentikasi admin berbasis password hash) dan tabel `barang` (20 data awal produk alat tulis kantor).
- [x] **Konfigurasi Koneksi Database (`config/koneksi.php`):** Menghubungkan aplikasi PHP dengan MySQL menggunakan ekstensi PDO yang aman dari SQL Injection.
- [x] **Halaman Katalog Produk Publik (`index.php` & `assets/img/`):** 
  - Menampilkan daftar produk lengkap dengan gambar, kategori, harga, dan jumlah stok tanpa perlu login.
  - Fitur pencarian produk berdasarkan nama barang.
  - Filter cepat berdasarkan 4 kategori (*Kertas*, *Alat Tulis*, *Buku*, dan *Peralatan Kantor*).
  - Indikator status ketersediaan stok otomatis (`Ready` untuk stok > 0 dan `Stok Habis` untuk stok = 0).
