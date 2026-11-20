<?php
require_once 'config/koneksi.php';

// ambil parameter pencarian dan filter kategori dari URL (GET)
$keyword  = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

// bangun query dinamis yang aman menggunakan Prepared Statement PDO
$sql = "SELECT * FROM barang WHERE 1=1";
$params = [];

if ($keyword !== '') {
    $sql .= " AND nama_barang LIKE :keyword";
    $params[':keyword'] = "%$keyword%";
}

if ($kategori !== '') {
    $sql .= " AND kategori = :kategori";
    $params[':kategori'] = $kategori;
}

$sql .= " ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$daftar_barang = $stmt->fetchAll();

$daftar_kategori = ['Kertas', 'Alat Tulis', 'Buku', 'Peralatan Kantor'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk | UK Stationery </title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Montserrat', sans-serif; }
        body { background-color: #FAF8F5; color: #222222; line-height: 1.6; }
        
        /* navbar */
        header {
            background-color: #FFFFFF;
            border-bottom: 1px solid #E5E0D8;
            padding: 18px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .brand { font-size: 1.25rem; font-weight: 700; color: #1E3A8A; text-decoration: none; }
        .btn-admin {
            padding: 8px 16px;
            background-color: #1E3A8A;
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .btn-admin:hover { background-color: #162D6B; }

        /* hero & filter section */
        .container { max-width: 1140px; margin: 0 auto; padding: 32px 20px; }
        .hero { text-align: center; margin-bottom: 28px; }
        .hero h1 { font-size: 1.8rem; margin-bottom: 8px; color: #111827; }
        .hero p { color: #6B7280; font-size: 0.95rem; }

        .search-box {
            display: flex;
            max-width: 540px;
            margin: 20px auto;
            gap: 8px;
        }
        .search-box input {
            flex: 1;
            padding: 11px 15px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 0.95rem;
            background: #FFFFFF;
        }
        .search-box button {
            padding: 11px 20px;
            background-color: #1E3A8A;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .filter-bar {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 32px;
        }
        .filter-btn {
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid #D1D5DB;
            background-color: #FFFFFF;
            color: #374151;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .filter-btn:hover, .filter-btn.active {
            background-color: #1E3A8A;
            color: #FFFFFF;
            border-color: #1E3A8A;
        }

        /* grid katalog */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }
        .card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
        .card-img {
            width: 100%;
            height: 170px;
            background-color: #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
        .badge-kategori {
            font-size: 0.75rem;
            color: #6B7280;
            font-weight: 600;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .card-title { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 8px; }
        .card-price { font-size: 1.05rem; font-weight: 700; color: #1E3A8A; margin-top: auto; margin-bottom: 12px; }
        
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid #F3F4F6;
            font-size: 0.8rem;
        }
        .status-ready {
            background-color: #DCFCE7;
            color: #166534;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 700;
        }
        .status-habis {
            background-color: #FEE2E2;
            color: #991B1B;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 700;
        }
        .stok-angka { color: #4B5563; font-weight: 600; }
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E5E7EB;
            color: #6B7280;
        }
    </style>
</head>
<body>

<header>
    <a href="index.php" class="brand"> UK Stationery </a>
    <a href="admin/login.php" class="btn-admin">Login Admin</a>
</header>

<div class="container">
    <div class="hero">
        <h1>Katalog Perlengkapan & Alat Tulis</h1>
        <p>Cek ketersediaan stok barang secara real-time sebelum berkunjung ke UK Stationery </p>

        <form action="index.php" method="GET" class="search-box">
            <?php if ($kategori !== ''): ?>
                <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
            <?php endif; ?>
            <input type="text" name="cari" placeholder="Cari pulpen, kertas HVS, buku tulis..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="filter-bar">
        <a href="index.php<?= $keyword !== '' ? '?cari=' . urlencode($keyword) : '' ?>" 
           class="filter-btn <?= $kategori === '' ? 'active' : '' ?>">Semua</a>
        <?php foreach ($daftar_kategori as $kat): ?>
            <?php
                $url = "index.php?kategori=" . urlencode($kat);
                if ($keyword !== '') $url .= "&cari=" . urlencode($keyword);
            ?>
            <a href="<?= $url ?>" class="filter-btn <?= $kategori === $kat ? 'active' : '' ?>">
                <?= htmlspecialchars($kat) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (count($daftar_barang) > 0): ?>
        <div class="grid">
            <?php foreach ($daftar_barang as $item): ?>
                <?php
                    // Deteksi otomatis: link URL eksternal atau file lokal di folder assets/img/
                    $foto = $item['foto'];
                    if (strpos($foto, 'http://') === 0 || strpos($foto, 'https://') === 0) {
                        $src_foto = $foto;
                    } elseif (!empty($foto) && file_exists("assets/img/" . $foto)) {
                        $src_foto = "assets/img/" . $foto;
                    } else {
                        // Gambar placeholder otomatis jika file lokal belum diunggah
                        $src_foto = "https://placehold.co/400x300/E5E7EB/374151?text=" . urlencode($item['kategori']);
                    }
                ?>
                <div class="card">
                    <div class="card-img">
                        <img src="<?= htmlspecialchars($src_foto) ?>" alt="<?= htmlspecialchars($item['nama_barang']) ?>">
                    </div>
                    <div class="card-body">
                        <span class="badge-kategori"><?= htmlspecialchars($item['kategori']) ?></span>
                        <h3 class="card-title"><?= htmlspecialchars($item['nama_barang']) ?></h3>
                        <div class="card-price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                        <div class="card-footer">
                            <?php if ($item['stok'] > 0): ?>
                                <span class="status-ready">Ready</span>
                                <span class="stok-angka">Stok: <?= $item['stok'] ?></span>
                            <?php else: ?>
                                <span class="status-habis">Stok Habis</span>
                                <span class="stok-angka">Stok: 0</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>Barang yang kamu cari tidak ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>