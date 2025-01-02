<?php

namespace App\Controllers;

use App\Models\M_login;

class auth extends BaseController
{
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            // Ambil data dari form
            $username = $this->request->getPost('username');
            $first_name = $this->request->getPost('first_name');
            $last_name = $this->request->getPost('last_name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Validasi apakah username sudah ada di database
            $userModel = new M_login();
            if ($userModel->where('username', $username)->first()) {
                // Username sudah ada, kembalikan pesan error
                return redirect()->back()->withInput()->with('error', 'Username sudah digunakan, silakan pilih username lain.');
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Simpan data ke database
            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($userModel->insert($data)) {
                return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
            } else {
                return redirect()->back()->with('error', 'Registration failed. Please try again.');
            }
        }

        return view('register'); // Tampilkan halaman register
    }
}