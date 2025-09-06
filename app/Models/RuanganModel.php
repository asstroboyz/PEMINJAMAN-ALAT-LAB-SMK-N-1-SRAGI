<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table      = 'ruangan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_ruangan', 'keterangan', 'is_active', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Ambil ruangan yang aktif saja
    public function getRuanganAktif()
    {
        return $this->where('is_active', 1)->orderBy('nama_ruangan', 'asc')->findAll();
    }

    // Ambil semua ruangan (jika perlu di admin)
    public function getAllRuangan()
    {
        return $this->orderBy('nama_ruangan', 'asc')->findAll();
    }
}
