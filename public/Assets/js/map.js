// Inisialisasi peta
let map;
let markersLayer = [];
let currentMapFilter = "all";

function initMap() {
    // Center peta di koordinat rata-rata semua sekolah
    const centerLat = schoolsData.reduce((sum, s) => sum + s.lat, 0) / schoolsData.length;
    const centerLng = schoolsData.reduce((sum, s) => sum + s.lng, 0) / schoolsData.length;
    
    map = L.map('map').setView([centerLat, centerLng], 13);
    
    // Tile layer dari OpenStreetMap (gratis)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
}

function updateMarkers(filter = "all") {
    // Hapus marker yang ada
    markersLayer.forEach(marker => map.removeLayer(marker));
    markersLayer = [];
    
    // Filter data
    let filtered = schoolsData;
    if (filter !== "all") {
        filtered = schoolsData.filter(school => school.jenjang === filter);
    }
    
    // Warna marker berdasarkan jenjang
    const getMarkerColor = (jenjang) => {
        if (jenjang === "SD") return "green";
        if (jenjang === "SMP") return "orange";
        return "red";
    };
    
    // Buat marker baru
    filtered.forEach(school => {
        // Custom icon dengan warna berbeda
        const markerIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background-color: ${getMarkerColor(school.jenjang)}; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.5);"></div>`,
            iconSize: [12, 12],
            popupAnchor: [0, -6]
        });
        
        const marker = L.marker([school.lat, school.lng], { icon: markerIcon }).addTo(map);
        
        // Info window (popup)
        const popupContent = `
            <div style="min-width: 200px;">
                <h3 style="color: #1e3c72; margin-bottom: 8px;">${school.nama}</h3>
                <p style="margin: 5px 0;"><strong>Jenjang:</strong> ${school.jenjang}</p>
                <p style="margin: 5px 0;"><strong>Alamat:</strong> ${school.alamat}</p>
                <p style="margin: 5px 0;"><strong>Kecamatan:</strong> ${school.kecamatan}</p>
                <p style="margin: 5px 0;"><strong>Akreditasi:</strong> ${school.akreditasi}</p>
                <p style="margin: 5px 0;"><strong>Telepon:</strong> ${school.telepon}</p>
                <hr style="margin: 8px 0;">
                <p style="margin: 5px 0;"><i class="fas fa-chalkboard-user"></i> ${school.jumlah_guru} Guru</p>
                <p style="margin: 5px 0;"><i class="fas fa-user-graduate"></i> ${school.jumlah_siswa} Siswa</p>
            </div>
        `;
        
        marker.bindPopup(popupContent);
        markersLayer.push(marker);
    });
    
    // Jika ada marker, zoom ke area yang mencakup semua marker
    if (markersLayer.length > 0) {
        const group = L.featureGroup(markersLayer);
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

// Fungsi untuk fokus ke sekolah tertentu dari daftar
function focusOnSchool(schoolId) {
    const school = schoolsData.find(s => s.id === schoolId);
    if (school && map) {
        map.setView([school.lat, school.lng], 17);
        // Buka popup marker yang sesuai
        const marker = markersLayer.find((m, idx) => {
            const latlng = m.getLatLng();
            return latlng.lat === school.lat && latlng.lng === school.lng;
        });
        if (marker) {
            marker.openPopup();
        }
    }
}