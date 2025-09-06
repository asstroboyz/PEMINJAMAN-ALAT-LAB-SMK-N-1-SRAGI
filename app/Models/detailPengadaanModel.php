<?php

namespace App\Models;

use CodeIgniter\Model;

class detailPengadaanModel extends Model
{
    protected $table = 'detail_pengadaan_barang';
    // protected $useTimestamps = true;
    protected $primarykey = 'id';
    protected $allowedFields = ['id', 'id_pengadaan_barang', 'id_user', 'id_balasan_pengadaan', 'nama_pengaju', 'nama_barang', 'spesifikasi', 'jumlah', 'alasan_pengadaan', 'jumlah_disetujui', 'catatan', 'tgl_pengajuan', 'tgl_proses', 'tgl_selesai', 'status', 'status_akhir'];

    public function getDetailPengadaan($id = false)
    {
        if ($id == false) {
            return $this
                ->join('pengadaan_barang', 'pengadaan_barang.pengadaan_barang_id = detail_pengadaan_barang.id_pengadaan_barang')
                ->orderBy('detail_pengadaan_barang.id', 'DESC')
                ->findAll();
        }
        return $this
            ->join('pengadaan_barang', 'pengadaan_barang.pengadaan_barang_id = detail_pengadaan_barang.id_pengadaan_barang')
            ->where(['id' => $id])->first();
    }
    public function getAll()
    {
        $query = $this->table('detail_pengadaan_barang')->query('select * from detail_pengadaan_barang');

        return $query->getResult();
    }
}