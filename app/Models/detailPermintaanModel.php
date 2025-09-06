<?php

namespace App\Models;

use CodeIgniter\Model;

class detailPermintaanModel extends Model
{
    protected $table = 'detail_permintaan_barang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'kode_barang', 'id_balasan_permintaan', 'id_permintaan_barang', 'nama_pengaju', 'perihal', 'detail', 'tanggal_pengajuan', 'tanggal_diproses', 'jumlah', 'tanggal_selesai', 'status', 'status_akhir'];

    public function getDetailPermintaan($id = false)
    {
        if ($id == false) {
            return $this
                ->select('detail_permintaan_barang.*, master_barang.nama_brg, satuan.nama_satuan,permintaan_barang.tanggal_permintaan, barang.id_master_barang, master_barang.merk, detail_master.tipe_barang')
                ->join('barang', 'barang.kode_barang = detail_permintaan_barang.kode_barang')
                ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
                ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
                ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
               
                ->join('permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
                ->findAll();
        }

        return $this
            ->select('detail_permintaan_barang.*, master_barang.nama_brg, satuan.nama_satuan,permintaan_barang.tanggal_permintaan, detail_permintaan_barang.id as id_detail_permintaan, barang.id_master_barang, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'barang.kode_barang = detail_permintaan_barang.kode_barang')
            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')

           
            ->join('permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')

            ->where(['detail_permintaan_barang.id' => $id])
            ->first();
    }

    public function getPermintaanProses()
    {
        return $this
            ->select('detail_permintaan_barang.*, master_barang.nama_brg, satuan.nama_satuan,permintaan_barang.tanggal_permintaan, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'barang.kode_barang = detail_permintaan_barang.kode_barang')
            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')

            ->join('users', 'users.id = detail_permintaan_barang.id_user')
            ->join('permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where(['detail_permintaan_barang.status' => 'diproses'])
            ->findAll();
    }
    public function getPermintaanMasuk()
    {
        return $this
            ->select('detail_permintaan_barang.*, master_barang.nama_brg, satuan.nama_satuan,permintaan_barang.tanggal_permintaan, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'barang.kode_barang = detail_permintaan_barang.kode_barang')
            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where(['detail_permintaan_barang.status' => 'belum diproses'])
            ->findAll();
    }

    public function getPermintaanSelesai()
    {
        return $this
            ->select('detail_permintaan_barang.*, master_barang.nama_brg, satuan.nama_satuan,permintaan_barang.tanggal_permintaan, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'barang.kode_barang = detail_permintaan_barang.kode_barang')
            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('users', 'users.id = detail_permintaan_barang.id_user')
            ->join('permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where(['detail_permintaan_barang.status' => 'selesai'])
            ->findAll();
    }
    public function find($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['kode_barang' => $id])
            ->first();
    }

    public function getAll()
    {
        $query = $this->table('permintaan_barang')->query('select * from permintaan_barang');
        return $query->getResult();
    }
    public function getPermintaanWithBarang()
    {
        return $this->db->table('permintaan_barang')
            ->join('barang', 'barang.kode_barang = permintaan_barang.kode_barang')
            ->get()
            ->getResultArray();
    }
}
