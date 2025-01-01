<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('password123', PASSWORD_DEFAULT);

        $data = [
            [
                'username' => 'admin',
                'password' => $password,
            ],
            [
                'username' => 'user1',
                'password' => $password,
            ],
        ];

        // Masukkan data ke tabel users
        $this->db->table('users')->insertBatch($data);
    }
}