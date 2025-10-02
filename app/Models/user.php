<?php

namespace App\Models;

use CodeIgniter\Model;
use \Myth\Auth\Authorization\GroupModel;

class User extends Model
{
    protected $table = 'users';
    // protected $useTimestamps = true;
    protected $primarykey = 'id';
    protected $allowedFields = [
        'email',
        'username',
        'fullname',
        'foto',
        'password_hash',
        'reset_hash',
        'reset_at',
        'reset_expires',
        'activate_hash',
        'status',
        'status_message',
        'active',
        'force_pass_reset',
        // custom field
        'nisn',
        'is_siswa'
    ];

    public function getUsers($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
    public function get_users()
    {
        // Ambil data pengguna dari database, sesuaikan dengan struktur tabel Anda
        return $this->db->get('users')->result();
    }
}
