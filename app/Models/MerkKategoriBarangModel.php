<?php

namespace App\Models;

use CodeIgniter\Model;

class MerkKategoriBarangModel extends Model
{
    protected $table      = 'merk_kategori_barang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kategori_id', 'merk_id'];

    // Get all relasi kategori-merk
    public function fetchAll()
    {
        return $this
            ->select('merk_kategori_barang.*, kategori_barang.nama_kategori, merk_barang.nama_merk')
            ->join('kategori_barang', 'kategori_barang.id = merk_kategori_barang.kategori_id', 'left')
            ->join('merk_barang', 'merk_barang.id = merk_kategori_barang.merk_id', 'left')
            ->orderBy('kategori_barang.nama_kategori', 'ASC')
            ->findAll();
    }

    // Get all merk by kategori (buat dropdown dinamis)
    public function getMerkByKategori($kategori_id)
    {
        return $this
            ->select('merk_barang.id, merk_barang.nama_merk')
            ->join('merk_barang', 'merk_barang.id = merk_kategori_barang.merk_id')
            ->where('merk_kategori_barang.kategori_id', $kategori_id)
            ->findAll();
    }

    // Cek relasi sudah ada/belum (biar gak double entry)
    public function checkExists($kategori_id, $merk_id)
    {
        return $this->where([
            'kategori_id' => $kategori_id,
            'merk_id'     => $merk_id
        ])->first();
    }
}
