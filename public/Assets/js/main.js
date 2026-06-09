// main.js - Enhanced Version
let currentFilter = 'all';
let currentKeyword = '';
let schoolsData = [];
let map = null;
let markers = [];
let chart = null;

// DOM Elements
const schoolGrid = document.getElementById('schoolGrid');
const searchInput = document.getElementById('searchInput');
const clearSearch = document.getElementById('clearSearch');
const resultCount = document.getElementById('resultCount');
const fab = document.getElementById('fab');

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadSchools();
    initDateTime();
    initEventListeners();
    initScrollEffects();
});

function initDateTime() {
    const dateTimeElement = document.getElementById('currentDateTime');
    if (dateTimeElement) {
        updateDateTime();
        setInterval(updateDateTime, 1000);
    }
}

function updateDateTime() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('currentDateTime').innerHTML = 
        `<i class="far fa-calendar-alt"></i> ${now.toLocaleDateString('id-ID', options)}`;
}

function initEventListeners() {
    // Navigation
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            updateActiveFilter();
            loadSchools();
        });
    });
    
    // Search
    searchInput.addEventListener('input', function() {
        currentKeyword = this.value;
        clearSearch.style.display = currentKeyword ? 'block' : 'none';
        loadSchools();
    });
    
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        currentKeyword = '';
        this.style.display = 'none';
        loadSchools();
    });
    
    // View Toggle
    document.getElementById('btnList').addEventListener('click', () => toggleView('list'));
    document.getElementById('btnMap').addEventListener('click', () => toggleView('map'));
    
    // Hero Buttons
    document.getElementById('exploreBtn')?.addEventListener('click', () => toggleView('map'));
    document.getElementById('statsBtn')?.addEventListener('click', () => {
        document.getElementById('statsSummary').scrollIntoView({ behavior: 'smooth' });
    });
    
    // Stat Cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', () => {
            const type = card.dataset.type;
            if (type && type !== 'all') {
                document.querySelector(`.nav-link[data-filter="${type}"]`).click();
            }
        });
    });
    
    // FAB
    fab.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

function updateActiveFilter() {
    document.querySelectorAll('.stat-card').forEach(card => {
        if (card.dataset.type === currentFilter) {
            card.style.transform = 'scale(1.05)';
            card.style.boxShadow = 'var(--shadow-xl)';
        } else {
            card.style.transform = 'scale(1)';
            card.style.boxShadow = 'var(--shadow-sm)';
        }
    });
}

function toggleView(view) {
    const listContainer = document.getElementById('listContainer');
    const mapContainer = document.getElementById('mapContainer');
    const btnList = document.getElementById('btnList');
    const btnMap = document.getElementById('btnMap');
    
    if (view === 'list') {
        listContainer.style.display = 'block';
        mapContainer.style.display = 'none';
        btnList.classList.add('active');
        btnMap.classList.remove('active');
    } else {
        listContainer.style.display = 'none';
        mapContainer.style.display = 'block';
        btnMap.classList.add('active');
        btnList.classList.remove('active');
        initMap();
        updateMap();
    }
}

function loadSchools() {
    showLoading();
    
    let url = `${BASE_URL}index.php/sekolah/get_data?jenis=${currentFilter}&keyword=${encodeURIComponent(currentKeyword)}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            schoolsData = data;
            updateStats();
            updateProgressBars();
            displaySchools();
            updateResultCount();
            
            if (document.getElementById('mapContainer').style.display === 'block') {
                updateMap();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            schoolGrid.innerHTML = '<div class="error">Gagal memuat data</div>';
        });
}

function showLoading() {
    schoolGrid.innerHTML = `
        <div class="loading-skeleton">
            <div class="skeleton-card"></div>
            <div class="skeleton-card"></div>
            <div class="skeleton-card"></div>
            <div class="skeleton-card"></div>
        </div>
    `;
}

function updateStats() {
    const total = schoolsData.length;
    const sd = schoolsData.filter(s => s.jenjang === 'SD').length;
    const smp = schoolsData.filter(s => s.jenjang === 'SMP').length;
    const sma = schoolsData.filter(s => s.jenjang === 'SMA').length;
    
    document.getElementById('totalSchools').textContent = total;
    document.getElementById('totalSD').textContent = sd;
    document.getElementById('totalSMP').textContent = smp;
    document.getElementById('totalSMA').textContent = sma;
    
    // Update hero stats
    document.getElementById('heroTotalSchools')?.querySelector('.floating-number').setAttribute('data-target', total);
    
    // Animate numbers
    animateNumber('totalSchools', total);
    animateNumber('totalSD', sd);
    animateNumber('totalSMP', smp);
    animateNumber('totalSMA', sma);
}

function animateNumber(elementId, targetValue) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    let currentValue = 0;
    const duration = 1000;
    const stepTime = 20;
    const steps = duration / stepTime;
    const increment = targetValue / steps;
    
    const timer = setInterval(() => {
        currentValue += increment;
        if (currentValue >= targetValue) {
            element.textContent = targetValue;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(currentValue);
        }
    }, stepTime);
}

function updateProgressBars() {
    const total = schoolsData.length;
    const sd = schoolsData.filter(s => s.jenjang === 'SD').length;
    const smp = schoolsData.filter(s => s.jenjang === 'SMP').length;
    const sma = schoolsData.filter(s => s.jenjang === 'SMA').length;
    
    const sdPercent = total ? (sd / total) * 100 : 0;
    const smpPercent = total ? (smp / total) * 100 : 0;
    const smaPercent = total ? (sma / total) * 100 : 0;
    
    const sdProgress = document.querySelector('.sd-progress');
    const smpProgress = document.querySelector('.smp-progress');
    const smaProgress = document.querySelector('.sma-progress');
    
    if (sdProgress) sdProgress.style.width = `${sdPercent}%`;
    if (smpProgress) smpProgress.style.width = `${smpPercent}%`;
    if (smaProgress) smaProgress.style.width = `${smaPercent}%`;
}

function updateResultCount() {
    if (resultCount) {
        resultCount.textContent = schoolsData.length;
    }
}

function displaySchools() {
    if (schoolsData.length === 0) {
        schoolGrid.innerHTML = `
            <div class="no-data" style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                <i class="fas fa-school-circle-exclamation" style="font-size: 3rem; color: var(--gray);"></i>
                <p>Tidak ada data sekolah ditemukan</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    schoolsData.forEach((school, index) => {
        let jenjangClass = '';
        let jenjangColor = '';
        if (school.jenjang === 'SD') {
            jenjangClass = 'sd-badge';
            jenjangColor = '#06d6a0';
        } else if (school.jenjang === 'SMP') {
            jenjangClass = 'smp-badge';
            jenjangColor = '#ffd166';
        } else {
            jenjangClass = 'sma-badge';
            jenjangColor = '#ef476f';
        }
        
        html += `
            <div class="school-card" style="animation-delay: ${index * 0.05}s">
                <div class="school-header" style="background: linear-gradient(135deg, ${jenjangColor}, ${adjustColor(jenjangColor, -20)})">
                    <h3>${escapeHtml(school.nama)}</h3>
                    <span class="badge">${school.jenjang}</span>
                </div>
                <div class="school-details">
                    <p><i class="fas fa-map-marker-alt"></i> ${escapeHtml(school.alamat)}</p>
                    <p><i class="fas fa-city"></i> Kecamatan: ${escapeHtml(school.kecamatan)}</p>
                    ${school.akreditasi ? `<p><i class="fas fa-star"></i> Akreditasi: ${school.akreditasi}</p>` : ''}
                    ${school.lat && school.lng ? `<p><i class="fas fa-location-dot"></i> Koordinat: ${school.lat}, ${school.lng}</p>` : ''}
                </div>
            </div>
        `;
    });
    
    schoolGrid.innerHTML = html;
}

function adjustColor(color, percent) {
    // Simple color adjustment for gradient
    return color;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function initMap() {
    if (map !== null) return;
    
    map = L.map('map').setView([-6.200000, 106.816666], 12);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        subdomains: 'abcd',
        maxZoom: 19,
        minZoom: 10
    }).addTo(map);
    
    // Add custom control
    const customControl = L.Control.extend({
        options: { position: 'topright' },
        onAdd: function() {
            const div = L.DomUtil.create('div', 'custom-map-control');
            div.innerHTML = '<i class="fas fa-info-circle"></i> ' + schoolsData.length + ' sekolah';
            return div;
        }
    });
    map.addControl(new customControl());
}

function updateMap() {
    if (map === null) return;
    
    // Clear existing markers
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    
    // Add new markers
    schoolsData.forEach(school => {
        if (school.lat && school.lng) {
            let color = '#3498db';
            let iconHtml = '';
            
            if (school.jenjang === 'SD') {
                color = '#06d6a0';
                iconHtml = '<i class="fas fa-chalkboard-user"></i>';
            } else if (school.jenjang === 'SMP') {
                color = '#ffd166';
                iconHtml = '<i class="fas fa-users"></i>';
            } else if (school.jenjang === 'SMA') {
                color = '#ef476f';
                iconHtml = '<i class="fas fa-graduation-cap"></i>';
            }
            
            const customIcon = L.divIcon({
                html: `<div style="background: ${color}; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">${iconHtml}</div>`,
                iconSize: [30, 30],
                className: 'custom-marker'
            });
            
            const marker = L.marker([school.lat, school.lng], { icon: customIcon }).addTo(map);
            marker.bindPopup(`
                <div style="min-width: 200px;">
                    <strong style="color: ${color}">${school.nama}</strong><br>
                    <span style="background: ${color}; color: white; padding: 2px 8px; border-radius: 50px; font-size: 11px;">${school.jenjang}</span><br>
                    <i class="fas fa-map-marker-alt"></i> ${school.alamat}<br>
                    <i class="fas fa-city"></i> Kec. ${school.kecamatan}
                </div>
            `);
            markers.push(marker);
        }
    });
    
    // Fit bounds to markers
    if (markers.length > 0) {
        const group = L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

function initScrollEffects() {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            fab.style.display = 'flex';
            fab.style.opacity = '1';
        } else {
            fab.style.opacity = '0';
            setTimeout(() => {
                if (window.scrollY <= 300) fab.style.display = 'none';
            }, 300);
        }
    });
    fab.style.display = 'none';
}