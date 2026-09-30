<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index(): string
    {
        $model = new UserModel();

        return view('users/index', [
            'title' => 'User Accounts',
            'users' => $model->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('users/new', [
            'title'  => 'New User',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
        ];

        $messages = [
            'username' => [
                'is_unique' => 'That username is already in use.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();

        $model->insert([
            'username'   => trim((string) $this->request->getPost('username')),
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'User created successfully.');
    }

    public function edit(int $id): string
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        return view('users/edit', [
            'title'  => 'Edit User',
            'user'   => $user,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        $rules = [
            'username'  => 'required|max_length[50]',
            'full_name' => 'required|max_length[100]',
            'avatar'    => [
                'uploaded[avatar]',
                'max_size[avatar,2048]',
                'is_image[avatar]',
                'mime_in[avatar,image/jpeg,image/png]',
                'ext_in[avatar,jpg,jpeg,png]',
            ],
        ];

        $avatar = $this->request->getFile('avatar');

        // Avatar upload is optional.
        if ($avatar === null || $avatar->getError() === UPLOAD_ERR_NO_FILE) {
            unset($rules['avatar']);
        }

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $username = trim(
            (string) $this->request->getPost('username')
        );

        // Check uniqueness while excluding the current user.
        $duplicate = $model
            ->where('username', $username)
            ->where('id !=', $id)
            ->first();

        if ($duplicate !== null) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'username' => 'That username is already in use.',
                ]);
        }

        $data = [
            'username'  => $username,
            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            ),
        ];

        if (
            $avatar !== null
            && $avatar->isValid()
            && ! $avatar->hasMoved()
        ) {
            $uploadDirectory = FCPATH . 'uploads/avatars';

            if (! is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0775, true);
            }

            $filename = $avatar->getRandomName();

            // Create a display-ready 200 x 200 thumbnail.
            service('image')
                ->withFile($avatar->getTempName())
                ->fit(200, 200, 'center')
                ->save(
                    $uploadDirectory
                    . DIRECTORY_SEPARATOR
                    . $filename,
                    85
                );

            // Only store the generated filename.
            $data['avatar'] = $filename;
        }

        $model->update($id, $data);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'User updated successfully.');
    }
}