<?php

namespace App\Models;

use CodeIgniter\Model;

class PengadaanModel extends Model
{
    protected $table = 'pengadaan_barang';
    // protected $useTimestamps = true;
    protected $primarykey = 'pengadaan_barang_id';
    protected $allowedFields = ['pengadaan_barang_id', 'tanggal_pengadaan', 'tahun_periode','id_user'];

    public function getPengadaan($id = false)
    {
        if ($id == false) {
            return $this
                ->orderBy('pengadaan_barang_id', 'DESC')
                ->findAll();
        }
        return $this->where(['pengadaan_barang_id' => $id])->first();
    }
    public function getAll()
    {
        $query = $this->table('pengadaan_barang')->query('select * from pengadaan_barang');
        return $query->getResult();
    }

    public function hapusPengadaan($id)
    {
        return $this->db->table($this->table)->delete(['pengadaan_barang_id' => $id]);
    }
}