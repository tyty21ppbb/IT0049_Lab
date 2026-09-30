<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    protected CustomerModel $customerModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->customerModel = new CustomerModel();
    }

    public function index(): string
    {
        return view('customers/index', [
            'title'     => 'Customer Accounts',
            'customers' => $this->customerModel
                ->orderBy('id', 'ASC')
                ->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('customers/new', [
            'title' => 'New Customer',
        ]);
    }

    public function create()
    {
        $rules = [
            'full_name' => [
                'label' => 'Full name',
                'rules' => 'required|max_length[100]',
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[100]',
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'permit_empty|max_length[20]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->insert([
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'email'      => trim((string) $this->request->getPost('email')),
            'phone'      => trim((string) $this->request->getPost('phone')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with('success', 'Customer created successfully.');
    }

    public function edit(int $id): string
    {
        $customer = $this->customerModel->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound(
                'Customer record not found.'
            );
        }

        return view('customers/edit', [
            'title'    => 'Edit Customer',
            'customer' => $customer,
        ]);
    }

    public function update(int $id)
    {
        $customer = $this->customerModel->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound(
                'Customer record not found.'
            );
        }

        $rules = [
            'full_name' => [
                'label' => 'Full name',
                'rules' => 'required|max_length[100]',
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[100]',
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'permit_empty|max_length[20]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->update($id, [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')),
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with('success', 'Customer updated successfully.');
    }
}