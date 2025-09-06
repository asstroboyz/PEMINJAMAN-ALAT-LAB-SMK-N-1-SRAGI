<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriBarangModel extends Model
{
    protected $table      = 'kategori_barang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kategori'];

    // Get all kategori
    public function fetchAll()
    {
        return $this->orderBy('nama_kategori', 'ASC')->findAll();
    }

    // Get by id
    public function fetchById($id)
    {
        return $this->find($id);
    }

    // Cek kategori by nama (untuk validasi unik)
    public function findByName($nama)
    {
        return $this->where('nama_kategori', $nama)->first();
    }
}
