<?php

namespace App\Controllers;

use App\Models\SekolahModel;

class Sekolah extends BaseController
{
    protected $sekolahModel;

    public function __construct()
    {
        // Memanggil Model agar koneksi database siap digunakan
        $this->sekolahModel = new SekolahModel();
    }

    // Fungsi untuk halaman Beranda (http://localhost:8080/)
    public function index()
    {
        // Pastikan nama file view untuk beranda kamu sudah benar (misal: v_dashboard atau v_home)
        return view('v_dashboard'); 
    }

    // Fungsi untuk halaman Peta (http://localhost:8080/sekolah/peta)
    public function peta()
    {
        return view('v_peta');
    }

    // API Endpoint yang ditarik oleh Javascript Fetch
    public function get_data_sekolah()
    {
        $jenjang = $this->request->getGet('filter') ?? 'all';
        $dataAsli = $this->sekolahModel->getSekolah($jenjang);
        
        $dataHasilPemetaan = [];

        foreach ($dataAsli as $row) {
            $dataHasilPemetaan[] = [
                'id'           => $row['id'],
                'nama_sekolah' => $row['nama_sekolah'],
                'name'         => $row['nama_sekolah'], 
                'jenjang'      => $row['jenjang'],
                'type'         => $row['jenjang'],      
                'alamat'       => $row['alamat'],
                'address'      => $row['alamat'],      
                'kecamatan'    => $row['kecamatan'],
                'latitude'     => $row['latitude'],
                'lat'          => $row['latitude'],     
                'longitude'    => $row['longitude'],
                'lng'          => $row['longitude'],    
            ];
        }

        return $this->response->setJSON($dataHasilPemetaan);
    }
}