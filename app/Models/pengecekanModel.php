<?php

namespace App\Models;

use CodeIgniter\Model;


class pengecekanModel extends Model
{
    protected $table = 'pengecekan';
    protected $primaryKey = 'pengecekan_id';
    protected $allowedFields = ['id_inventaris', 'tanggal_pengecekan', 'keterangan', 'lokasi_lama'];


    public function getPengecekan($id = false)
    {
        if ($id == false) {
            return $this
                ->join('inventaris', 'inventaris.kode_barang = pengecekan.id_inventaris')
                ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
                ->findAll();
        }

        return $this->where(['pengecekan_id' => $id])
            ->join('inventaris', 'inventaris.kode_barang = pengecekan.id_inventaris')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
            ->first();
    }

    public function detailMaster($id_master)
    {
        return $this->where('id_master_barang', $id_master)
            ->join('satuan', 'satuan.satuan_id = pengecekan.id_satuan')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
            ->findAll();
    }
}