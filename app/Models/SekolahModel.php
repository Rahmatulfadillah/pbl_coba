<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    // Nama tabel di database
    protected $table            = 'sekolah';
    // Nama primary key tabel
    protected $primaryKey       = 'id';
    // Kolom yang diizinkan untuk diisi/dimanipulasi
    protected $allowedFields    = ['nama_sekolah', 'jenjang', 'alamat', 'kecamatan', 'latitude', 'longitude'];

    /**
     * Mengambil semua data sekolah atau berdasarkan jenjang (SD/SMP/SMA)
     */
    public function getSekolah($jenjang = null)
    {
        if ($jenjang === null || $jenjang == 'all') {
            return $this->findAll();
        }
        return $this->where('jenjang', $jenjang)->findAll();
    }
}