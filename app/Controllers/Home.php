<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Memastikan tampilan yang dimuat adalah 'index' atau file lainnya
        return view('index'); // Gantilah 'index' dengan nama file yang sesuai
    }
}