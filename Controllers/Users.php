<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index(): string
    {
        $users = [
            [
                'username'  => 'admin',
                'full_name' => 'Maloi Ricaldre',
                'role'      => 'Administrator',
            ],
            [
                'username'  => 'cashier01',
                'full_name' => 'JL Torreliza',
                'role'      => 'Cashier',
            ],
            [
                'username'  => 'cashier02',
                'full_name' => 'Akira Morishita',
                'role'      => 'Cashier',
            ],
            [
                'username'  => 'manager01',
                'full_name' => 'Joy Barcoma',
                'role'      => 'Manager',
            ],
            [
                'username'  => 'stock01',
                'full_name' => 'Baus Rufo',
                'role'      => 'Inventory Clerk',
            ],
        ];

        return view('users/index', [
            'title' => 'User Accounts',
            'users' => $users,
        ]);
    }
}