<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // if (logged_in(true)) {
        //     return view('user/home');
        // }
        return view('Auth/Login');
    }
}
