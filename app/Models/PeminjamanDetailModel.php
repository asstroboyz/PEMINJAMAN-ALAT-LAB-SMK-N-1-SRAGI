<?php
namespace App\Models;

use CodeIgniter\Model;

class PeminjamanDetailModel extends Model
{
    protected $table      = 'peminjaman_detail';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_user',
        'peminjaman_id',
        'jumlah',
        'jumlah_kembali',
        'kondisi_kembali',
        'detail',
        'inventaris_id',
        'ruangan_id', // FK ke ruangan (actual lokasi detail)
    ];

    // JOIN ke inventaris dan ruangan (untuk tampilan)
    public function withInventaris($peminjaman_id)
    {
        return $this->select('
                peminjaman_detail.*,
                i.kode_barang,
                i.kondisi,
                i.spesifikasi,
                m.nama_brg,
                m.merk,
                r.nama_ruangan
            ')
            ->join('inventaris i', 'i.kode_barang = peminjaman_detail.inventaris_id', 'left')
            ->join('master_barang m', 'm.kode_brg = i.id_master_barang', 'left')
            ->join('ruangan r', 'r.id = peminjaman_detail.ruangan_id', 'left')
            ->where('peminjaman_detail.peminjaman_id', $peminjaman_id)
            ->findAll();
    }

    // Semua data "masuk" (pending)
public function getPeminjamanMasuk() {
    return $this->select('peminjaman_detail.*, h.kode_transaksi, h.status, h.tanggal_permintaan')
        ->join('peminjaman_header h', 'h.peminjaman_id = peminjaman_detail.peminjaman_id', 'left')
        ->where('h.status', 'pending')
        ->findAll();
}

// Semua data "diproses"/"dipinjam"
public function getPeminjamanProses() {
    return $this->select('peminjaman_detail.*, h.kode_transaksi, h.status, h.tanggal_permintaan')
        ->join('peminjaman_header h', 'h.peminjaman_id = peminjaman_detail.peminjaman_id', 'left')
        ->where('h.status', 'dipinjam')
        ->findAll();
}

// Semua data "selesai" (kembali/ditolak)
public function getPeminjamanSelesai() {
    return $this->select('peminjaman_detail.*, h.kode_transaksi, h.status, h.tanggal_permintaan')
        ->join('peminjaman_header h', 'h.peminjaman_id = peminjaman_detail.peminjaman_id', 'left')
        ->groupStart()
            ->where('h.status', 'kembali')
            ->orWhere('h.status', 'ditolak')
        ->groupEnd()
        ->findAll();
}

}
