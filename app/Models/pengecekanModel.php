<?php
namespace App\Models;

use CodeIgniter\Model;

class pengecekanModel extends Model
{
    protected $table         = 'pengecekan';
    protected $primaryKey    = 'pengecekan_id';
    protected $allowedFields = [
        'id_inventaris',      // varchar(255), FK ke inventaris.kode_barang
        'tanggal_pengecekan', // date
        'ruangan_id_lama',    // int (nullable), FK ke ruangan.id
        'keterangan',         // varchar(255)
    ];

    public function getPengecekan($id = false)
    {
        $builder = $this
            ->select('pengecekan.*, inventaris.*, master_barang.nama_brg, master_barang.merk_id, master_barang.kategori_id')
            ->join('inventaris', 'inventaris.kode_barang = pengecekan.id_inventaris', 'left')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang', 'left');

        if ($id === false) {
            return $builder->findAll();
        }

        return $builder->where(['pengecekan_id' => $id])->first();
    }

    // Ambil semua pengecekan berdasar master barang
    public function detailMaster($id_master)
    {
        return $this
            ->select('pengecekan.*, inventaris.*, master_barang.nama_brg')
            ->join('inventaris', 'inventaris.kode_barang = pengecekan.id_inventaris', 'left')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang', 'left')
            ->where('inventaris.id_master_barang', $id_master)
            ->findAll();
    }
}
