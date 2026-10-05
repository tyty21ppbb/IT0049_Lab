<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use RuntimeException;

class ExistingUserPasswordSeeder extends Seeder
{
    public function run()
    {
        $temporaryPassword = env('TFA4_INITIAL_PASSWORD');

        if (empty($temporaryPassword)) {
            throw new RuntimeException(
                'Set TFA4_INITIAL_PASSWORD in .env before running this seeder.'
            );
        }

        $passwordHash = password_hash(
            (string) $temporaryPassword,
            PASSWORD_DEFAULT
        );

        $this->db
            ->table('users')
            ->update([
                'password' => $passwordHash,
            ]);
    }
}