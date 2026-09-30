<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index(): string
    {
        $model = new CustomerModel();

        return view('customers/index', [
            'title' => 'Customer Accounts',
            'customers' => $model
                ->orderBy('id', 'ASC')
                ->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('customers/new', [
            'title' => 'New Customer',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        $messages = [
            'full_name' => [
                'required' => 'Full name is required.',
                'max_length' => 'Full name cannot exceed 100 characters.',
            ],
            'email' => [
                'required' => 'Email address is required.',
                'valid_email' => 'Enter a valid email address.',
                'max_length' => 'Email cannot exceed 100 characters.',
            ],
            'phone' => [
                'max_length' => 'Phone number cannot exceed 20 characters.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $model = new CustomerModel();

        $model->insert([
            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            ),
            'email' => trim(
                (string) $this->request->getPost('email')
            ),
            'phone' => trim(
                (string) $this->request->getPost('phone')
            ),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with(
                'success',
                'Customer created successfully.'
            );
    }

    public function edit(int $id): string
    {
        $model = new CustomerModel();
        $customer = $model->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound(
                'Customer not found.'
            );
        }

        return view('customers/edit', [
            'title' => 'Edit Customer',
            'customer' => $customer,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        $customer = $model->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound(
                'Customer not found.'
            );
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        $messages = [
            'full_name' => [
                'required' => 'Full name is required.',
                'max_length' => 'Full name cannot exceed 100 characters.',
            ],
            'email' => [
                'required' => 'Email address is required.',
                'valid_email' => 'Enter a valid email address.',
                'max_length' => 'Email cannot exceed 100 characters.',
            ],
            'phone' => [
                'max_length' => 'Phone number cannot exceed 20 characters.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $model->update($id, [
            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            ),
            'email' => trim(
                (string) $this->request->getPost('email')
            ),
            'phone' => trim(
                (string) $this->request->getPost('phone')
            ),
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with(
                'success',
                'Customer updated successfully.'
            );
    }
}