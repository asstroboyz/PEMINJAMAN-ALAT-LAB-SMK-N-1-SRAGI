<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('front/landing');
    }

    // public function user()
    // {
    //     return view('auth/index');
    // }
}
