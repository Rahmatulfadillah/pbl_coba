<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Resmi Dinas Pendidikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0f172a;
            --accent-color: #2563eb;
            --light-bg: #f8fafc;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #334155;
        }
        /* Navbar Custom */
        .navbar {
            background-color: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
        }
        /* Hero Section Premium */
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: white;
            padding: 100px 0 140px 0;
            position: relative;
            overflow: hidden;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--light-bg);
            clip-path: polygon(0 100%, 100% 100%, 100% 0);
        }
        .btn-custom {
            background-color: var(--accent-color);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }
        .btn-custom:hover {
            background-color: #1d4ed8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
        }
        /* Fitur / Layanan Cards */
        .feature-card {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .icon-box {
            width: 60px;
            height: 60px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--accent-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                <i class="fas fa-graduation-cap me-2 text-warning fs-3"></i>
                <span class="fw-bold tracking-wide">DISDIK PORTAL</span>
            </a>
        </div>
    </nav>

    <section class="hero-section d-flex align-items-center mt-5">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-warning text-dark mb-3 fw-bold px-3 py-2 rounded-pill">SISTEM INFORMASI GEOGRAFIS</span>
                    <h1 class="display-4 fw-extrabold mb-3 text-white">Modernisasi Data & Pemetaan Sekolah</h1>
                    <p class="lead text-white-50 mb-4">Selamat datang di portal resmi penataan akurasi data wilayah persebaran jenjang pendidikan SD, SMP, dan SMA berbasis peta digital interaktif.</p>
                    <a href="<?= base_url('sekolah/peta') ?>" class="btn btn-custom btn-lg"><i class="fas fa-map-location-dot me-2"></i> Eksplorasi Peta</a>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-map-marked-alt text-white-50" style="font-size: 180px; opacity: 0.15; animation: float 3s ease-in-out infinite;"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-5 py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Layanan Utama Portal</h2>
            <p class="text-muted">Akses transparansi data pendidikan dalam satu pintu terintegrasi</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4">
                    <div class="icon-box"><i class="fas fa-chart-pie"></i></div>
                    <h5 class="fw-bold">Statistik Real-time</h5>
                    <p class="text-muted text-sm">Menampilkan akumulasi jumlah sekolah per jenjang yang diperbarui secara periodik dan berkala.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4">
                    <div class="icon-box"><i class="fas fa-location-crosshairs"></i></div>
                    <h5 class="fw-bold">Geolokasi Presisi</h5>
                    <p class="text-muted text-sm">Titik koordinat akurat memanfaatkan peta open-source tanpa bergantung pada lisensi API komersial.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4">
                    <div class="icon-box"><i class="fas fa-filter"></i></div>
                    <h5 class="fw-bold">Filter Cerdas</h5>
                    <p class="text-muted text-sm">Kemudahan memisahkan kategori sekolah (SD, SMP, SMA) hanya dengan sekali klik kendali.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white-50 py-4 mt-5 border-top border-secondary">
        <div class="container text-center">
            <small>&copy; 2026 Dinas Pendidikan Kota. Terintegrasi CodeIgniter 4 & LeafletJS.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>