<?php

namespace App\Models;

use CodeIgniter\Model;

class profil extends Model
{
    protected $table = 'users';
    // protected $useTimestamps = true;
    protected $primarykey = 'id';
    protected $allowedFields = ['username', 'email', 'foto'];

    public function getUsers($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
