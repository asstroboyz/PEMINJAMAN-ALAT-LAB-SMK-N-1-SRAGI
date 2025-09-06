<?php

namespace App\Models;

use CodeIgniter\Model;

class MerkBarangModel extends Model
{
    protected $table      = 'merk_barang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_merk'];

    // Get all merk
    public function fetchAll()
    {
        return $this->orderBy('nama_merk', 'ASC')->findAll();
    }

    // Get by id
    public function fetchById($id)
    {
        return $this->find($id);
    }

    // Cek merk by nama
    public function findByName($nama)
    {
        return $this->where('nama_merk', $nama)->first();
    }
}
