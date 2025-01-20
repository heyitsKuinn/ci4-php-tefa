<?php
namespace App\Controllers;

use App\Models\M_login;
use CodeIgniter\I18n\Time;
use CodeIgniter\Email\Email;

class Auth extends BaseController
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


    // Halaman forgot password
    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'get') {
            return view('forgot_password'); // Menampilkan halaman forgot password
        }
    
        // Ambil email dari input form
        $email = $this->request->getPost('email');
    
        // Cek apakah email kosong
        if (empty($email)) {
            return redirect()->back()->with('error', 'Email tidak boleh kosong.');
        }
    
        // Cek apakah email ditemukan di database
        $userModel = new M_login();
        $user = $userModel->where('email', $email)->first();
    
        // Jika email tidak ditemukan
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }
    
        // Buat kode verifikasi
        $verificationCode = random_int(100000, 999999);
    
        // Kirim kode ke email pengguna (tanpa update database untuk saat ini)
        $this->sendVerificationCode($email, $verificationCode);
    
        // Arahkan pengguna ke halaman verifikasi kode setelah kode dikirimkan
        return redirect()->to('/verify-code')->with('success', 'Kode verifikasi telah dikirim ke email Anda.');
    }
    
    

// Halaman Verifikasi Kode
// public function verifyCode()
// {
//     // Menampilkan halaman verifikasi kode
//     return view('verify_code');
// }

public function verifyCode()
{
    // Cek apakah form disubmit atau tidak
    if ($this->request->getMethod() === 'post') {
        $email = $this->request->getPost('email');
        $verificationCode = $this->request->getPost('verification_code');

        // Validasi email dan kode verifikasi
        if (empty($email) || empty($verificationCode)) {
            return redirect()->back()->with('error', 'Email dan kode verifikasi tidak boleh kosong.');
        }

        $userModel = new M_login();
        $user = $userModel->where('email', $email)
                          ->where('verification_code', $verificationCode)
                          ->first();

        // Jika email dan kode tidak valid
        if (!$user) {
            return redirect()->back()->with('error', 'Kode verifikasi salah atau sudah kedaluwarsa.');
        }

        // Jika valid, simpan sesi untuk reset password
        session()->set('reset_email', $email);
        return redirect()->to('/reset-password');
    }

    // Jika bukan post request, tampilkan halaman verifikasi kode
    return view('verify_code');  // Menampilkan halaman verifikasi kode
}




public function resetPassword()
{
    $email = session()->get('reset_email');

    // Pastikan email sudah diset di sesi
    if (!$email) {
        return redirect()->to('/forgot-password')->with('error', 'Sesi tidak valid.');
    }

    // Ambil password dan konfirmasi password
    $password = $this->request->getPost('password');
    $confirmPassword = $this->request->getPost('confirm_password');

    // Cek apakah password dan konfirmasi password cocok
    if ($password !== $confirmPassword) {
        return redirect()->back()->with('error', 'Kata sandi tidak cocok.');
    }

    // Update password pengguna
    $userModel = new M_login();
    $userModel->update(['email' => $email], [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'verification_code' => null, // Hapus kode verifikasi setelah digunakan
        'code_expiry' => null
    ]);

    // Redirect ke halaman login setelah password berhasil diubah
    return redirect()->to('/login')->with('success', 'Kata sandi berhasil diubah.');
}

public function sendVerificationCode($email, $verificationCode)
{
    $emailService = \Config\Services::email();

    $config = [
        'protocol'    => 'smtp',
        'SMTPHost'    => 'smtp.gmail.com',
        'SMTPUser'    => '001tefait@gmail.com',
        'SMTPPass'    => 'asdqwe123@#$', // Ganti dengan app password jika menggunakan Gmail
        'SMTPPort'    => 587,
        'SMTPCrypto'  => 'tls',
        'mailType'    => 'html',
        'charset'     => 'UTF-8',
        'wordWrap'    => true,
    ];

    $emailService->initialize($config);

    $emailService->setFrom('001tefait@gmail.com', 'TEFA IT');
    $emailService->setTo($email);
    $emailService->setSubject('Kode Verifikasi');
    $emailService->setMessage("
        <p>Halo,</p>
        <p>Kode verifikasi Anda adalah <strong>{$verificationCode}</strong>.</p>
        <p>Kode ini berlaku selama 10 menit.</p>
    ");

    if (!$emailService->send()) {
        log_message('error', $emailService->printDebugger(['headers']));
        return false;
    }
    return true;
}

// private function sendVerificationEmail($email, $code)
// {
//     $emailService = \Config\Services::email();
//     $emailService->setTo($email);
//     $emailService->setFrom('no-reply@yourdomain.com', 'Your App Name');
//     $emailService->setSubject('Kode Verifikasi');
//     $emailService->setMessage("Kode verifikasi Anda adalah: $code. Berlaku selama 10 menit.");

//     if (!$emailService->send()) {
//         log_message('error', $emailService->printDebugger(['headers']));
//     }
// }

}

// if ($this->request->getMethod() === 'get') {
//     return view('forgot_password'); // Menampilkan halaman forgot password
// }