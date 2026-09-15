<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index(): string
    {
        $customers = [
            [
                'full_name' => 'Alfea Zulueta',
                'email'     => 'alfea@gmail.com',
                'phone'     => '0917-111-1111',
            ],
            [
                'full_name' => 'Gwen Apuli',
                'email'     => 'gwen@gmail.com',
                'phone'     => '0917-222-2222',
            ],
            [
                'full_name' => 'Art Panulde',
                'email'     => 'art@gmail.com',
                'phone'     => '0917-333-3333',
            ],
            [
                'full_name' => 'Sheena Belarmino',
                'email'     => 'sheena@gmail.com',
                'phone'     => '0917-444-4444',
            ],
            [
                'full_name' => 'Aiah Arceta',
                'email'     => 'aiah@gmail.com',
                'phone'     => '0917-555-5555',
            ],
        ];

        return view('customers/index', [
            'title'     => 'Customer Accounts',
            'customers' => $customers,
        ]);
    }
}