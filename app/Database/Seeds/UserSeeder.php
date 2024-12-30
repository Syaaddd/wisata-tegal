<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
        );

        $this->db->table('users')->insert($data);
    }
}
