<?php

namespace App\Entities;

use Myth\Auth\Entities\User as MythUser;

class User extends MythUser
{
    protected $attributes = [
        'nisn'     => null,
        'is_siswa' => 0,
        'fullname' => null,
        'foto'     => 'profil.svg',
    ];

    protected $casts = [
        'username'         => 'string',
        'email'            => 'string',
        'fullname'         => 'string',
        'nisn'             => 'string',
        'is_siswa'         => 'integer',
        'active'           => 'boolean',
        'force_pass_reset' => 'boolean',
    ];
}
