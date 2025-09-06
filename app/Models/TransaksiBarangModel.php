<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiBarangModel extends Model
{
    protected $table = 'transaksi_barang';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true; 

    protected $allowedFields = [
        'kode_barang',
        'id_master_barang',
        'tanggal_transaksi',  
        'jenis_transaksi',
        'informasi_tambahan',
        'jumlah_perubahan',
        'user_id',
        'deleted_at'
    ];

    // Tambah log transaksi (always set tanggal_transaksi)
    public function tambahTransaksi($data)
    {
        if (empty($data['tanggal_transaksi'])) {
            $data['tanggal_transaksi'] = date('Y-m-d H:i:s');
        }
        return $this->insert($data);
    }

    // Riwayat transaksi
    public function riwayatTransaksi($kode_barang)
    {
        return $this->where('kode_barang', $kode_barang)
            ->orderBy('tanggal_transaksi', 'desc')
            ->findAll();
    }
}
