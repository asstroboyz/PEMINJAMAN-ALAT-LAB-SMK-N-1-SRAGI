<?php
namespace App\Models;

use CodeIgniter\Model;

class PeminjamanHeaderModel extends Model
{
    protected $table      = 'peminjaman_header';
    protected $primaryKey = 'peminjaman_id';

    protected $allowedFields = [
        'kode_transaksi',
        'tanggal_permintaan',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_real',
        'id_user',           // yang mengajukan pinjam
        'approved_by',       // yang approval
        'ruangan_id_pinjam', // FK ke ruangan (tujuan)
        'ruangan_id_sebelum',// FK ke ruangan (sebelum dipinjam)
        'status',            // pending, dipinjam, kembali, ditolak
        'catatan',
        'approved_at',
        'tgl_proses',
    ];

    public function withUser($id)
    {
        return $this->select('peminjaman_header.*, u.username as peminjam, a.username as approver')
            ->join('users u', 'u.id = peminjaman_header.id_user', 'left')
            ->join('users a', 'a.id = peminjaman_header.approved_by', 'left')
            ->where('peminjaman_header.peminjaman_id', $id)
            ->first();
    }

    public function approvePinjam($peminjaman_id, $approved_by)
    {
        return $this->update($peminjaman_id, [
            'status' => 'dipinjam',
            'approved_by' => $approved_by,
            'tanggal_pinjam' => date('Y-m-d H:i:s'),
        ]);
    }
    public function rejectPinjam($peminjaman_id, $approved_by, $alasan = null)
    {
        return $this->update($peminjaman_id, [
            'status' => 'ditolak',
            'approved_by' => $approved_by,
            'catatan' => $alasan,
        ]);
    }
}
