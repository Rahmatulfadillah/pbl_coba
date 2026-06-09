const schoolsData = [
    // SD (dengan koordinat)
    { 
        id: 1, 
        nama: "SD Negeri 1 Kota Baru", 
        jenjang: "SD", 
        alamat: "Jl. Pendidikan No. 1", 
        kecamatan: "Kota Baru", 
        akreditasi: "A", 
        jumlah_guru: 20, 
        jumlah_siswa: 320,
        lat: -6.200000,
        lng: 106.816666,
        telepon: "(021) 1234567"
    },
    { 
        id: 2, 
        nama: "SD Islam Terpadu Al-Falah", 
        jenjang: "SD", 
        alamat: "Jl. Cendana No. 5", 
        kecamatan: "Menteng", 
        akreditasi: "A", 
        jumlah_guru: 18, 
        jumlah_siswa: 280,
        lat: -6.190000,
        lng: 106.830000,
        telepon: "(021) 2345678"
    },
    { 
        id: 3, 
        nama: "SD Negeri 2 Harapan Jaya", 
        jenjang: "SD", 
        alamat: "Jl. Mawar No. 8", 
        kecamatan: "Harapan", 
        akreditasi: "B", 
        jumlah_guru: 15, 
        jumlah_siswa: 250,
        lat: -6.210000,
        lng: 106.800000,
        telepon: "(021) 3456789"
    },
    { 
        id: 4, 
        nama: "SD Kristen Petra", 
        jenjang: "SD", 
        alamat: "Jl. Melati No. 12", 
        kecamatan: "Sukamaju", 
        akreditasi: "A", 
        jumlah_guru: 22, 
        jumlah_siswa: 340,
        lat: -6.180000,
        lng: 106.840000,
        telepon: "(021) 4567890"
    },
    { 
        id: 5, 
        nama: "SDN 4 Karang Anyar", 
        jenjang: "SD", 
        alamat: "Jl. Karang Anyar No. 3", 
        kecamatan: "Karang Anyar", 
        akreditasi: "B", 
        jumlah_guru: 16, 
        jumlah_siswa: 270,
        lat: -6.220000,
        lng: 106.790000,
        telepon: "(021) 5678901"
    },
    
    // SMP
    { 
        id: 6, 
        nama: "SMP Negeri 1 Kota Baru", 
        jenjang: "SMP", 
        alamat: "Jl. Pendidikan No. 10", 
        kecamatan: "Kota Baru", 
        akreditasi: "A", 
        jumlah_guru: 35, 
        jumlah_siswa: 540,
        lat: -6.195000,
        lng: 106.820000,
        telepon: "(021) 6789012"
    },
    { 
        id: 7, 
        nama: "SMP Islam Al-Falah", 
        jenjang: "SMP", 
        alamat: "Jl. Cendana No. 8", 
        kecamatan: "Menteng", 
        akreditasi: "A", 
        jumlah_guru: 30, 
        jumlah_siswa: 480,
        lat: -6.185000,
        lng: 106.835000,
        telepon: "(021) 7890123"
    },
    { 
        id: 8, 
        nama: "SMP Negeri 2 Harapan Jaya", 
        jenjang: "SMP", 
        alamat: "Jl. Teratai No. 5", 
        kecamatan: "Harapan", 
        akreditasi: "B", 
        jumlah_guru: 28, 
        jumlah_siswa: 510,
        lat: -6.215000,
        lng: 106.795000,
        telepon: "(021) 8901234"
    },
    { 
        id: 9, 
        nama: "SMP Kristen Petra 1", 
        jenjang: "SMP", 
        alamat: "Jl. Anggrek No. 7", 
        kecamatan: "Sukamaju", 
        akreditasi: "A", 
        jumlah_guru: 32, 
        jumlah_siswa: 520,
        lat: -6.175000,
        lng: 106.845000,
        telepon: "(021) 9012345"
    },
    { 
        id: 10, 
        nama: "SMPN 5 Karang Anyar", 
        jenjang: "SMP", 
        alamat: "Jl. Karang Anyar No. 15", 
        kecamatan: "Karang Anyar", 
        akreditasi: "B", 
        jumlah_guru: 27, 
        jumlah_siswa: 490,
        lat: -6.225000,
        lng: 106.785000,
        telepon: "(021) 0123456"
    },
    
    // SMA
    { 
        id: 11, 
        nama: "SMA Negeri 1 Kota Baru", 
        jenjang: "SMA", 
        alamat: "Jl. Pendidikan No. 20", 
        kecamatan: "Kota Baru", 
        akreditasi: "A", 
        jumlah_guru: 45, 
        jumlah_siswa: 720,
        lat: -6.190000,
        lng: 106.825000,
        telepon: "(021) 1234567"
    },
    { 
        id: 12, 
        nama: "SMA Islam Al-Falah", 
        jenjang: "SMA", 
        alamat: "Jl. Cendana No. 12", 
        kecamatan: "Menteng", 
        akreditasi: "A", 
        jumlah_guru: 40, 
        jumlah_siswa: 680,
        lat: -6.180000,
        lng: 106.840000,
        telepon: "(021) 2345678"
    },
    { 
        id: 13, 
        nama: "SMA Negeri 2 Harapan Jaya", 
        jenjang: "SMA", 
        alamat: "Jl. Kenanga No. 3", 
        kecamatan: "Harapan", 
        akreditasi: "A", 
        jumlah_guru: 42, 
        jumlah_siswa: 700,
        lat: -6.205000,
        lng: 106.805000,
        telepon: "(021) 3456789"
    },
    { 
        id: 14, 
        nama: "SMA Kristen Petra 2", 
        jenjang: "SMA", 
        alamat: "Jl. Anggrek No. 9", 
        kecamatan: "Sukamaju", 
        akreditasi: "A", 
        jumlah_guru: 38, 
        jumlah_siswa: 650,
        lat: -6.170000,
        lng: 106.850000,
        telepon: "(021) 4567890"
    },
    { 
        id: 15, 
        nama: "SMAN 8 Karang Anyar", 
        jenjang: "SMA", 
        alamat: "Jl. Karang Anyar No. 22", 
        kecamatan: "Karang Anyar", 
        akreditasi: "B", 
        jumlah_guru: 36, 
        jumlah_siswa: 630,
        lat: -6.230000,
        lng: 106.780000,
        telepon: "(021) 5678901"
    }
];

// Hitung statistik
function getSchoolStats() {
    const total = schoolsData.length;
    const sd = schoolsData.filter(s => s.jenjang === "SD").length;
    const smp = schoolsData.filter(s => s.jenjang === "SMP").length;
    const sma = schoolsData.filter(s => s.jenjang === "SMA").length;
    return { total, sd, smp, sma };
}