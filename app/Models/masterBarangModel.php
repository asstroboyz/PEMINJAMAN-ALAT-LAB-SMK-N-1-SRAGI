<?php
namespace App\Models;

use CodeIgniter\Model;

class MasterBarangModel extends Model
{
    protected $table      = 'master_barang';
    protected $primaryKey = 'kode_brg';

    // Pastikan field di DB update! (kalau belum, biarin dulu, tapi ini best practice)
    protected $allowedFields = [
        'kode_brg',
        'nama_brg',
        'kategori_id',
        'merk_id',    // ganti dari merk
        'tipe_serie', // tambahan untuk model/seri barang
        'jenis_brg',
        'spesifikasi',
        'foto',
        'id_satuan',
        'is_active',
        'created_at',
        'updated_at',
    ];

    // FUNCTION LAMA: getMasterInventory
    public function getMasterInventory($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->where('kode_brg', $id)->first();
        }
    }

    // FUNCTION LAMA: getMasterBarang (tetap ada, hanya di-improve query-nya)
    public function getMasterBarang($id = false)
    {
        $builder = $this->select('
                master_barang.*,
                satuan.nama_satuan,
                kategori_barang.nama_kategori,
                merk_barang.nama_merk
            ')
            ->join('satuan', 'satuan.satuan_id = master_barang.id_satuan', 'left')
            ->join('kategori_barang', 'kategori_barang.id = master_barang.kategori_id', 'left')
            ->join('merk_barang', 'merk_barang.id = master_barang.merk_id', 'left')
            ->orderBy('master_barang.jenis_brg', 'ASC');

        if ($id === false) {
            return $builder->findAll();
        } else {
            return $builder->where('master_barang.kode_brg', $id)->first();
        }
    }

    // Tambahan: Dapetin merk2 valid by kategori (buat kebutuhan dynamic dropdown)
    public function getMerkByKategori($kategori_id)
    {
        return $this->db->table('merk_kategori_barang')
            ->join('merk_barang', 'merk_barang.id = merk_kategori_barang.merk_id')
            ->where('merk_kategori_barang.kategori_id', $kategori_id)
            ->select('merk_barang.id, merk_barang.nama_merk')
            ->get()
            ->getResultArray();
    }

    // Tambahan: Dapetin kategori
    public function getKategori()
    {
        return $this->db->table('kategori_barang')
            ->select('id, nama_kategori')
            ->get()
            ->getResultArray();
    }

    // Tambahan: Dapetin satuan
    public function getSatuan()
    {
        return $this->db->table('satuan')
            ->select('satuan_id, nama_satuan')
            ->get()
            ->getResultArray();
    }
}
