<?php

namespace App\Models;

use CodeIgniter\Model;

class BalasanModel extends Model
{
    protected $table = 'balasan_permintaan';
    // protected $useTimestamps = true;
    protected $primarykey = 'id';
    protected $allowedFields = ['id', 'id_permintaan_barang', 'kategori', 'balasan_permintaan'];

    public function getBalasan($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
