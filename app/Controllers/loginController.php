<?php
namespace App\Controllers;

use App\Models\M_login;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    // Halaman login
    public function index()
    {
        return view('login');  // Pastikan 'login.php' berada di folder 'app/Views/'
    }

    // Proses login
    public function login()
    {
        // Ambil data username dan password dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek apakah username dan password valid
        $userModel = new M_login();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Jika login berhasil, set session
            session()->set('isLoggedIn', true);
            session()->set('username', $user['username']);

            // Redirect ke halaman dashboard
            return redirect()->to('/dashboard');  // Halaman dashboard setelah login
        } else {
            // Jika login gagal, beri pesan error
            session()->setFlashdata('loginError', 'Username atau Password salah.');
            return redirect()->to('/login');  // Kembali ke halaman login dengan pesan error
        }
    }

    // Logout
    public function logout()
    {
        session()->destroy();  // Hapus session
        return redirect()->to('/login');  // Kembali ke halaman login
    }
}