<?php


namespace App\Models;

use CodeIgniter\Model;

class satuanModel extends Model
{
    protected $table = 'satuan';
    protected $primaryKey = 'satuan_id';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_satuan', 'keterangan', 'created_at', 'updated_at'];

    public function getSatuan($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['satuan_id' => $id])->first();
    }
}