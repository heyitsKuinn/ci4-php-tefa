<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        // Cek apakah session 'isLoggedIn' ada dan bernilai true
        if (!session()->get('isLoggedIn')) {
            // Jika belum login, arahkan ke halaman login
            return redirect()->to('/login');
        }

        // Jika sudah login, tampilkan halaman dashboard
        return view('dashboard_admin'); 
    }
}