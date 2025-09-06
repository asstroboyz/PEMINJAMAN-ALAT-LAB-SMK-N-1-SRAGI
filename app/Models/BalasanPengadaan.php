<?php

namespace App\Models;

use CodeIgniter\Model;

class BalasanPengadaan extends Model
{
    protected $table = 'balasan_pengadaan';
    // protected $useTimestamps = true;
    protected $primarykey = 'id';
    protected $allowedFields = ['id', 'id_pengadaan', 'kategori', 'balasan_pengadaan'];

    public function getBalas($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
