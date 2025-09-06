<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $useSoftDeletes = true;
    protected $primaryKey = 'kode_barang'; // Menggunakan 'kode_barang' sebagai primary key
    protected $allowedFields = ['kode_barang', 'id_master_barang', 'id_satuan', 'jenis_transaksi', 'tanggal_barang_masuk', 'tanggal_barang_keluar', 'deleted_at', 'stok'];

    public function getBarang($kode_barang = false)
    {
        if ($kode_barang == false) {
            return $this
                ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
                ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
                ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
                ->findAll();
        }

        return $this
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')

            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->where(['kode_barang' => $kode_barang])
            ->first();
    }

    public function getMaster($kode_barang)
    {
        return $this
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')

            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->where('id_master_barang', $kode_barang)
            ->findAll();
    }

    
    public function softDeleteWithRelations($kode_barang)
    {
        // Hapus soft delete di tabel Barang
        $this->delete($kode_barang);

        // Hapus record di tabel TransaksiBarang terkait
        $transaksiModel = new TransaksiBarangModel();
        $transaksiModel->where('kode_barang', $kode_barang)->delete();
    }
    public function restoreBarang($kode_barang)
    {
        // Menggunakan withDeleted() untuk memastikan bahwa data yang dihapus lunak juga termasuk
        $barang = $this->withDeleted()->find($kode_barang);

        if ($barang) {
            // Lakukan restore hanya jika data yang sesuai ditemukan
            return $this->update($kode_barang, ['deleted_at' => null, 'stok' => 0]);
        } else {
            return false; // Tidak ada data yang sesuai
        }
    }


    public function transaksi()
    {
        return $this->hasMany('App\Models\TransaksiModel', 'kode_barang', 'kode_barang');
    }

    public function tambahStok($kodeBarang, $jumlah, $tanggalMasuk)
    {
        if ($this->where('kode_barang', $kodeBarang)->set('stok', "stok + $jumlah", false)->update()) {
            return true;
        } else {
            return false;
        }
    }

    public function kurangiStok($kodeBarang, $jumlah)
    {
        $builder = $this->db->table($this->table);
        $builder->set('stok', "stok - $jumlah", false);
        $builder->where('kode_barang', $kodeBarang);
        $builder->update();
    }
    public function getBarangMasuk()
    {
        return $this->where('jumlah_penambahan_stok >', 0)->findAll();
    }

    public function getBarangKeluar()
    {
        return $this->where('jumlah_pengurangan_stok >', 0)->findAll();
    }

    public function deleteBarang($kode_barang)
    {
        // Hapus barang dan transaksi yang terkait
        $barang = $this->find($kode_barang);

        if (!$barang) {
            return false; // Barang tidak ditemukan
        }

        // Hapus transaksi yang terkait
        $TransaksiBarangModel = new TransaksiBarangModel();
        $TransaksiBarangModel->where('kode_barang', $kode_barang)->delete();

        // Hapus barang
        return $this->delete($kode_barang);
    }
}
