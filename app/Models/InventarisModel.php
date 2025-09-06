<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarisModel extends Model
{
    protected $table = 'inventaris';
    protected $primaryKey = 'kode_barang';

    protected $allowedFields = [
        'kode_barang',        // PK
        'id_master_barang',   // FK ke master_barang
        'sn',                 // serial number
        'foto',               // path/file gambar unit
        'kondisi',            // baru/bekas/rusak
        'spesifikasi',        // detail khusus per unit
        'id_satuan',          // FK ke satuan
        'ruangan_id',         // FK ke ruangan
        'status',             // tersedia/dipinjam/dll
        'qrcode',             // qr string/file
        'file',               // lampiran/file tambahan
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // GET SEMUA inventaris + join master_barang, kategori, merk, satuan, ruangan
    public function fetchAllWithRelasi()
    {
        return $this->select('
                inventaris.*,
                master_barang.nama_brg,
                master_barang.tipe_serie,
                master_barang.jenis_brg,
                kategori_barang.nama_kategori,
                merk_barang.nama_merk,
                satuan.nama_satuan,
                ruangan.nama_ruangan
            ')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
            ->join('kategori_barang', 'kategori_barang.id = master_barang.kategori_id', 'left')
            ->join('merk_barang', 'merk_barang.id = master_barang.merk_id', 'left')
            ->join('satuan', 'satuan.satuan_id = inventaris.id_satuan', 'left')
            ->join('ruangan', 'ruangan.id = inventaris.ruangan_id', 'left')
            ->findAll();
    }

    // GET inventaris BY kode_barang (PK)
    public function fetchById($kode_barang)
    {
        return $this->select('
                inventaris.*,
                master_barang.nama_brg,
                master_barang.tipe_serie,
                master_barang.jenis_brg,
                kategori_barang.nama_kategori,
                merk_barang.nama_merk,
                satuan.nama_satuan,
                ruangan.nama_ruangan
            ')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
            ->join('kategori_barang', 'kategori_barang.id = master_barang.kategori_id', 'left')
            ->join('merk_barang', 'merk_barang.id = master_barang.merk_id', 'left')
            ->join('satuan', 'satuan.satuan_id = inventaris.id_satuan', 'left')
            ->join('ruangan', 'ruangan.id = inventaris.ruangan_id', 'left')
            ->where('inventaris.kode_barang', $kode_barang)
            ->first();
    }

    // GET inventaris BERDASARKAN id_master_barang (semua unit dari satu tipe master_barang)
    public function fetchByMaster($id_master_barang)
    {
        return $this->select('
                inventaris.*,
                master_barang.nama_brg,
                master_barang.tipe_serie,
                master_barang.jenis_brg,
                kategori_barang.nama_kategori,
                merk_barang.nama_merk,
                satuan.nama_satuan,
                ruangan.nama_ruangan
            ')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
            ->join('kategori_barang', 'kategori_barang.id = master_barang.kategori_id', 'left')
            ->join('merk_barang', 'merk_barang.id = master_barang.merk_id', 'left')
            ->join('satuan', 'satuan.satuan_id = inventaris.id_satuan', 'left')
            ->join('ruangan', 'ruangan.id = inventaris.ruangan_id', 'left')
            ->where('inventaris.id_master_barang', $id_master_barang)
            ->findAll();
    }

    // Standar insert/update
    public function insertData($data)
    {
        return $this->insert($data);
    }
    public function updateData($id, $data)
    {
        return $this->update($id, $data);
    }
}
