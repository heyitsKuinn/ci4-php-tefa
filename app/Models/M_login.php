<?php

namespace App\Models;

use CodeIgniter\Model;

class M_login extends Model
{
    protected $table = 'users'; // Nama tabel di database
    protected $primaryKey = 'id'; // Kolom primary key
    protected $allowedFields = ['username', 'password', 'first_name', 'last_name', 'role', 'status', 'email']; // Kolom yang boleh diubah

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Fungsi untuk mendapatkan user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first(); // Mencari user berdasarkan username
    }
}