<?php

namespace App\Models;

use CodeIgniter\Model;

class M_login extends Model
{
    protected $table = 'users'; // Nama tabel di database
    protected $primaryKey = 'id'; // Kolom primary key
    protected $allowedFields = ['username', 'password']; // Kolom yang boleh diubah

    // Fungsi untuk mendapatkan user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first(); // Mencari user berdasarkan username
    }
}