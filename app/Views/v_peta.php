<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Geografis Sebaran Sekolah Pro - Dinas Pendidikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary: #1e3a8a;
            --accent: #2563eb;
            --dark: #0f172a;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        body { 
            background: #f8fafc; 
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #334155;
            overflow-x: hidden;
        }

        /* Navigasi Header Ultra Modern */
        .main-header {
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
            border-bottom: 4px solid var(--accent);
        }

        /* Card Statistik Interaktif */
        .stat-box {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            position: relative;
        }
        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
        .progress-mini {
            height: 6px;
            border-radius: 10px;
            margin-top: 12px;
        }

        /* Kapsul Filter */
        .filter-pill .nav-link {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.2s;
        }
        .filter-pill .nav-link.active {
            background-color: var(--accent) !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        /* Manajemen Peta */
        #map {
            height: 600px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        /* Kartu Sekolah Glass-Style */
        .card-sekolah-modern {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        .card-sekolah-modern:hover {
            border-color: var(--accent);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.05);
        }

        /* Sidebar Detail Geser (Slide-out Panel) */
        .info-sidebar {
            position: fixed;
            top: 0; right: -400px; width: 400px; height: 100%;
            background: white; z-index: 1050;
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 30px;
            display: flex;
            flex-direction: column;
        }
        .info-sidebar.open { right: 0; }
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.3); backdrop-filter: blur(4px);
            z-index: 1040; display: none;
        }
        .sidebar-overlay.active { display: block; }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <div class="info-sidebar" id="infoSidebar">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0 text-dark"><i class="fas fa-circle-info text-accent me-2"></i>Detail Sekolah</h4>
            <button class="btn-close" onclick="closeSidebar()"></button>
        </div>
        <div class="text-center py-3 bg-light rounded-4 mb-4">
            <i class="fas fa-school fa-3x text-muted mb-2"></i>
            <h5 class="fw-bold m-0 px-2" id="sideNama">Nama Sekolah</h5>
            <span class="badge mt-2 fs-6 px-3 py-1 rounded-pill" id="sideBadge">SD</span>
        </div>
        <div class="flex-grow-1 overflow-y-auto">
            <div class="mb-3">
                <label class="text-muted small fw-bold text-uppercase d-block mb-1"><i class="fas fa-map-pin me-2 text-danger"></i>Alamat Lengkap</label>
                <p class="fw-medium text-secondary bg-light p-3 rounded-3" id="sideAlamat">-</p>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1"><i class="fas fa-city me-2 text-primary"></i>Kecamatan</label>
                    <p class="fw-bold text-dark" id="sideKecamatan">-</p>
                </div>
                <div class="col-6">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1"><i class="fas fa-compass me-2 text-warning"></i>Koordinat GPS</label>
                    <p class="small text-muted text-truncate" id="sideKoordinat">-</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mt-auto">
            <a href="#" id="sideRouteBtn" target="_blank" class="btn btn-primary rounded-pill flex-grow-1 fw-bold"><i class="fas fa-location-arrow me-2"></i>Rute Petunjuk</a>
            <button onclick="shareSchool()" class="btn btn-outline-success rounded-pill px-3"><i class="fas fa-share-nodes"></i></button>
        </div>
    </div>

    <div class="main-header text-white py-4 shadow-sm position-relative">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="mb-0 fw-bold animate__animated animate__fadeInDown"><i class="fas fa-globe-asia text-warning me-2 animate__animated animate__pulse animate__infinite"></i> Spatial-GIS Pendidikan v2.0</h3>
                <p class="mb-0 text-white-50 small">Sistem Analisis Geografis Sekolah Berbasis Data Real-Time</p>
            </div>
            <a href="<?= base_url('/') ?>" class="btn btn-outline-light btn-sm rounded-pill px-4 fw-semibold transition"><i class="fas fa-circle-chevron-left me-2"></i>Kembali</a>
        </div>
    </div>

    <div class="container my-4">
        <div class="bg-white p-3 rounded-4 shadow-sm border mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <ul class="nav nav-pills filter-pill" id="filterContainer">
                <li class="nav-item"><a class="nav-link active" href="#" data-filter="all"><i class="fas fa-layer-group me-2"></i>Semua Data</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="SD"><i class="fas fa-child me-2 text-danger"></i>Jenjang SD</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="SMP"><i class="fas fa-user-shield me-2 text-warning"></i>Jenjang SMP</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="SMA"><i class="fas fa-user-graduate me-2 text-success"></i>Jenjang SMA</a></li>
            </ul>
            
            <div class="btn-group bg-light p-1 rounded-pill border">
                <button id="viewList" class="btn btn-dark rounded-pill px-4 active"><i class="fas fa-list me-2"></i>Daftar</button>
                <button id="viewMap" class="btn btn-light rounded-pill px-4"><i class="fas fa-map-location-dot me-2"></i>Peta Spasial</button>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><span class="text-muted small fw-bold">TOTAL DATA</span><h2 class="fw-bold text-dark m-0 mt-1" id="countTotal">0</h2></div>
                        <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3"><i class="fas fa-database fa-lg"></i></div>
                    </div>
                    <div class="progress progress-mini bg-light"><div class="progress-bar bg-primary" style="width: 100%"></div></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><span class="text-muted small fw-bold">SEKOLAH DASAR</span><h2 class="fw-bold text-dark m-0 mt-1" id="countSD">0</h2></div>
                        <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3"><i class="fas fa-children fa-lg"></i></div>
                    </div>
                    <div class="progress progress-mini bg-light"><div class="progress-bar bg-danger" id="barSD" style="width: 0%"></div></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><span class="text-muted small fw-bold">MENENGAH PERTAMA</span><h2 class="fw-bold text-dark m-0 mt-1" id="countSMP">0</h2></div>
                        <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3"><i class="fas fa-user-tie fa-lg"></i></div>
                    </div>
                    <div class="progress progress-mini bg-light"><div class="progress-bar bg-warning" id="barSMP" style="width: 0%"></div></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><span class="text-muted small fw-bold">MENENGAH ATAS</span><h2 class="fw-bold text-dark m-0 mt-1" id="countSMA">0</h2></div>
                        <div class="p-3 bg-success bg-opacity-10 text-success rounded-3"><i class="fas fa-graduation-cap fa-lg"></i></div>
                    </div>
                    <div class="progress progress-mini bg-light"><div class="progress-bar bg-success" id="barSMA" style="width: 0%"></div></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div id="mapWrapper" style="display: none;" class="position-relative animate__animated animate__fadeIn">
                    <div id="map"></div>
                </div>

                <div id="listWrapper" class="animate__animated animate__fadeIn">
                    <div class="position-relative mb-4">
                        <span class="position-absolute top-50 start-0 translate-middle-y ps-4 text-muted"><i class="fas fa-magnifying-glass"></i></span>
                        <input type="text" id="liveSearch" class="form-control form-control-lg border ps-5 rounded-4 shadow-sm" placeholder="Ketik kata kunci nama sekolah atau nama wilayah kecamatan...">
                    </div>
                    <div class="row g-4" id="cardsGrid">
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let mainMap = null;
        let layerGroup = [];
        let fetchedDataCache = [];
        let activeSharedData = null;

        // Mesin Utama Penarik Sinkronisasi Database Dinamis
        function sinkronisasiGIS(kategori = 'all') {
            fetch(`<?= base_url('sekolah/get_data_sekolah') ?>?filter=${kategori}`)
                .then(res => res.json())
                .then(data => {
                    fetchedDataCache = data;

                    // Hitung & Jalankan Animasi Progress Bar Akurat
                    let sd = 0, smp = 0, sma = 0;
                    data.forEach(x => {
                        let t = x.jenjang || x.type;
                        if(t === 'SD') sd++;
                        if(t === 'SMP') smp++;
                        if(t === 'SMA') sma++;
                    });

                    document.getElementById('countTotal').innerText = data.length;
                    document.getElementById('countSD').innerText = sd;
                    document.getElementById('countSMP').innerText = smp;
                    document.getElementById('countSMA').innerText = sma;

                    // Atur persentase visual grafik batang mini
                    let total = data.length || 1;
                    document.getElementById('barSD').style.width = `${(sd/total)*100}%`;
                    document.getElementById('barSMP').style.width = `${(smp/total)*100}%`;
                    document.getElementById('barSMA').style.width = `${(sma/total)*100}%`;

                    // Panggil mesin render komponen
                    renderDaftarGrid(data);
                    renderTitikPeta(data);
                })
                .catch(err => console.error("Koneksi API Gagal Terbuka:", err));
        }

        // Render Kartu Grid List Modern
        function renderDaftarGrid(data) {
            const wadah = document.getElementById('cardsGrid');
            wadah.innerHTML = '';

            if(data.length === 0) {
                wadah.innerHTML = '<div class="col-12 text-center py-5 text-muted"><i class="fas fa-hourglass-empty fa-2x mb-2"></i><p>Data kosong pada klasifikasi ini.</p></div>';
                return;
            }

            data.forEach(item => {
                let badgeStyle = item.jenjang === 'SD' ? 'bg-danger' : (item.jenjang === 'SMP' ? 'bg-warning text-dark' : 'bg-success');
                wadah.innerHTML += `
                    <div class="col-md-6 col-lg-4 card-item-filter">
                        <div class="card-sekolah-modern p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge ${badgeStyle} px-3 py-1.5 rounded-pill">${item.jenjang}</span>
                                    <span class="small text-muted fw-semibold"><i class="fas fa-location-dot me-1 text-secondary"></i>${item.kecamatan}</span>
                                </div>
                                <h5 class="fw-bold text-dark mb-2 target-search-nama">${item.nama_sekolah}</h5>
                                <p class="small text-muted mb-0 text-truncate-2"><i class="fas fa-map-marked me-1"></i>${item.alamat}</p>
                            </div>
                            <div class="mt-4">
                                <button onclick='openSidebarDetail(${JSON.stringify(item).split('"').join('"')})' class="btn btn-light border btn-sm w-100 rounded-pill fw-bold text-accent"><i class="fas fa-folder-open me-2"></i>Periksa Profil</button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        // Inisialisasi Sistem Multi-Basemap Peta Terpadu
        function renderTitikPeta(data) {
            if (!mainMap) {
                // Definisi Variasi Layer Basemap Premium
                let osmStandard = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: 'OSM' });
                let satelliteHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', { subdomains:['mt0','mt1','mt2','mt3'], attribution: 'Google' });
                let darkMuted = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png', { attribution: 'CartoDB' });

                mainMap = L.map('map', {
                    center: [-6.1751, 106.6327],
                    zoom: 12,
                    layers: [osmStandard] // Mode default bawaan halaman
                });

                let baseMaps = {
                    "Peta Jalan Raya": osmStandard,
                    "Satelit & Kontur": satelliteHybrid,
                    "Muted Dark Mode": darkMuted
                };

                // Tambahkan panel switcher kontrol di pojok kanan atas peta
                L.control.layers(baseMaps, null, { position: 'topright' }).addTo(mainMap);

                // Tambahkan Tombol Fitur Geolokasi Pengguna (Find Me) di Peta
                let lokasiKontrol = L.control({ position: 'topleft' });
                lokasiKontrol.onAdd = function() {
                    let div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-custom-control');
                    div.innerHTML = '<button onclick="findUserGeolocation()" style="background:white; border:none; width:30px; height:30px; cursor:pointer;" title="Cari Lokasi Saya"><i class="fas fa-crosshairs text-primary"></i></button>';
                    return div;
                };
                lokasiKontrol.addTo(mainMap);
            }

            // Sapu bersih marker lama sebelum memuat filter baru
            layerGroup.forEach(m => mainMap.removeLayer(m));
            layerGroup = [];

            // Letakkan titik koordinat baru dari server database
            data.forEach(loc => {
                if(loc.latitude && loc.longitude) {
                    let m = L.marker([parseFloat(loc.latitude), parseFloat(loc.longitude)])
                        .addTo(mainMap)
                        .bindPopup(`
                            <div class="p-1">
                                <h6 class="fw-bold mb-1 text-dark">${loc.nama_sekolah}</h6>
                                <p class="small text-muted mb-2">${loc.alamat}</p>
                                <button class="btn btn-primary btn-xs text-white px-2 py-0.5 rounded" style="font-size:11px" onclick='openSidebarDetail(${JSON.stringify(loc).split('"').join('"')})'>Detail</button>
                            </div>
                        `);
                    layerGroup.push(m);
                }
            });
        }

        // Fitur Deteksi Posisi Pengguna Otomatis (Geolokasi)
        function findUserGeolocation() {
            if (!navigator.geolocation) {
                alert("Browser laptop/HP kamu tidak mendukung fitur akses GPS.");
                return;
            }
            navigator.geolocation.getCurrentPosition(position => {
                let lat = position.coords.latitude;
                let lng = position.coords.longitude;
                L.marker([lat, lng]).addTo(mainMap).bindPopup("<b>Anda di Sini</b>").openPopup();
                mainMap.setView([lat, lng], 14);
            }, () => {
                alert("Akses GPS ditolak. Pastikan izin lokasi browser kamu sudah aktif.");
            });
        }

        // Buka Panel Slide-out Kanan Modern
        function openSidebarDetail(obj) {
            activeSharedData = obj;
            document.getElementById('sideNama').innerText = obj.nama_sekolah;
            document.getElementById('sideBadge').innerText = obj.jenjang;
            document.getElementById('sideBadge').className = `badge mt-2 fs-6 px-3 py-1 rounded-pill ${obj.jenjang === 'SD' ? 'bg-danger' : (obj.jenjang === 'SMP' ? 'bg-warning text-dark' : 'bg-success')}`;
            document.getElementById('sideAlamat').innerText = obj.alamat;
            document.getElementById('sideKecamatan').innerText = obj.kecamatan;
            document.getElementById('sideKoordinat').innerText = `${obj.latitude}, ${obj.longitude}`;
            document.getElementById('sideRouteBtn').href = `https://www.google.com/maps/dir/?api=1&destination=${obj.latitude},${obj.longitude}`;

            document.getElementById('infoSidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('active');
        }

        function closeSidebar() {
            document.getElementById('infoSidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }

        // Fitur Cepat Berbagi Informasi Lokasi (Share Button)
        function shareSchool() {
            if(activeSharedData) {
                let text = `Lokasi Sekolah: ${activeSharedData.nama_sekolah}\nAlamat: ${activeSharedData.alamat}\nLink Google Maps: https://www.google.com/maps/search/?api=1&query=${activeSharedData.latitude},${activeSharedData.longitude}`;
                navigator.clipboard.writeText(text);
                alert("Informasi rute lokasi berhasil disalin ke clipboard! Siap dibagikan ke WhatsApp.");
            }
        }

        // Fitur Real-Time Live Search Multi-Variabel
        document.getElementById('liveSearch').addEventListener('input', function(e) {
            let key = e.target.value.toLowerCase();
            let items = document.querySelectorAll('.card-item-filter');
            
            items.forEach(card => {
                let text = card.innerText.toLowerCase();
                if(text.includes(key)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });

        // Kontrol Tombol Switch Mode Panel Tampilan
        const viewList = document.getElementById('viewList');
        const viewMap = document.getElementById('viewMap');
        const listWrapper = document.getElementById('listWrapper');
        const mapWrapper = document.getElementById('mapWrapper');

        viewList.addEventListener('click', () => {
            viewList.className = "btn btn-dark rounded-pill px-4 active";
            viewMap.className = "btn btn-light rounded-pill px-4";
            listWrapper.style.display = "block";
            mapWrapper.style.display = "none";
        });

        viewMap.addEventListener('click', () => {
            viewMap.className = "btn btn-dark rounded-pill px-4 active";
            viewList.className = "btn btn-light rounded-pill px-4";
            listWrapper.style.display = "none";
            mapWrapper.style.display = "block";
            
            if (mainMap) {
                setTimeout(() => { mainMap.invalidateSize(); }, 200);
            }
        });

        // Event inisialisasi awal dokumen
        document.addEventListener("DOMContentLoaded", () => {
            sinkronisasiGIS('all');

            document.querySelectorAll('#filterContainer .nav-link').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('#filterContainer .nav-link.active').classList.remove('active');
                    this.classList.add('active');
                    sinkronisasiGIS(this.getAttribute('data-filter'));
                });
            });
        });
    </script>
</body>
</html>