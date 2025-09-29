<?php
namespace App\Models;

use CodeIgniter\Model;

class PeminjamanHeaderModel extends Model
{
    protected $table      = 'peminjaman_header';
    protected $primaryKey = 'peminjaman_id';

    protected $allowedFields = [
        'kode_transaksi',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_real',
        'id_user',             // pengaju
        'approved_by',         // approver
        'ruangan_id_pinjam',   // FK ruangan tujuan
        'ruangan_id_sebelum',  // FK ruangan asal
        'status',              // pending, dipinjam, kembali, ditolak
        'catatan',
        'approved_at',
        'alasan_reject',
        'user_penerima_kembali',
    ];

    // biar created_at & updated_at auto
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function withUser($id)
    {
        return $this->select('peminjaman_header.*, u.username as peminjam, a.username as approver')
            ->join('users u', 'u.id = peminjaman_header.id_user', 'left')
            ->join('users a', 'a.id = peminjaman_header.approved_by', 'left')
            ->where('peminjaman_header.peminjaman_id', $id)
            ->first();
    }

    public function approvePinjam($peminjaman_id, $approved_by, $hariRencana = 3)
    {
        return $this->update($peminjaman_id, [
            'status'                  => 'dipinjam',
            'approved_by'             => $approved_by,
            'approved_at'             => date('Y-m-d H:i:s'),
            'tanggal_pinjam'          => date('Y-m-d H:i:s'),
            'tanggal_kembali_rencana' => date('Y-m-d H:i:s', strtotime("+{$hariRencana} days")),
        ]);
    }

    public function rejectPinjam($peminjaman_id, $approved_by, $alasan = null)
    {
        return $this->update($peminjaman_id, [
            'status'        => 'ditolak',
            'approved_by'   => $approved_by,
            'approved_at'   => date('Y-m-d H:i:s'),
            'alasan_reject' => $alasan,
        ]);
    }
}
