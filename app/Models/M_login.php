<?php

namespace App\Models;

use CodeIgniter\Model;

class M_login extends Model
{
    protected $table = 'users'; // Nama tabel di database
    protected $primaryKey = 'id'; // Kolom primary key
    protected $allowedFields = ['username', 'password', 'first_name', 'last_name', 'role', 'status', 'email', 'level']; // Tambahkan 'level'

    protected $useTimestamps = true; // Aktifkan timestamps
    protected $createdField  = 'created_at'; // Kolom untuk created_at
    protected $updatedField  = 'updated_at'; // Kolom untuk updated_at

    // Fungsi untuk mendapatkan user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first(); // Cari user berdasarkan username
    }

    // Fungsi untuk mendapatkan user berdasarkan level
    public function getUsersByLevel($level)
    {
        return $this->where('level', $level)->findAll(); // Cari semua user berdasarkan level
    }
}