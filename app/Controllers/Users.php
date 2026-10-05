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
            'users' => $model
                ->orderBy('id', 'ASC')
                ->findAll(),
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
            'username' => [
                'required',
                'max_length[50]',
                'is_unique[users.username]',
            ],
            'full_name' => [
                'required',
                'max_length[100]',
            ],
            'password' => [
                'required',
                'min_length[8]',
                'max_length[255]',
            ],
            'password_confirm' => [
                'required',
                'matches[password]',
            ],
        ];

        $messages = [
            'username' => [
                'required' => 'Username is required.',
                'max_length' =>
                    'Username cannot exceed 50 characters.',
                'is_unique' =>
                    'That username is already in use.',
            ],
            'full_name' => [
                'required' => 'Full name is required.',
                'max_length' =>
                    'Full name cannot exceed 100 characters.',
            ],
            'password' => [
                'required' => 'Password is required.',
                'min_length' =>
                    'Password must contain at least 8 characters.',
                'max_length' =>
                    'Password cannot exceed 255 characters.',
            ],
            'password_confirm' => [
                'required' =>
                    'Please confirm the password.',
                'matches' =>
                    'The password confirmation does not match.',
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

        $model = new UserModel();

        $password = (string) $this->request->getPost(
            'password'
        );

        $model->insert([
            'username' => trim(
                (string) $this->request->getPost('username')
            ),
            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            ),
            'password' => password_hash(
                $password,
                PASSWORD_DEFAULT
            ),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to(site_url('users'))
            ->with(
                'success',
                'User created successfully.'
            );
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
            'username' => [
                'required',
                'max_length[50]',
            ],
            'full_name' => [
                'required',
                'max_length[100]',
            ],
        ];

        $messages = [
            'username' => [
                'required' => 'Username is required.',
                'max_length' =>
                    'Username cannot exceed 50 characters.',
            ],
            'full_name' => [
                'required' => 'Full name is required.',
                'max_length' =>
                    'Full name cannot exceed 100 characters.',
            ],
        ];

        $newPassword = (string) $this->request->getPost(
            'password'
        );

        // A password change is optional on the Edit User page.
        if ($newPassword !== '') {
            $rules['password'] = [
                'min_length[8]',
                'max_length[255]',
            ];

            $rules['password_confirm'] = [
                'required',
                'matches[password]',
            ];

            $messages['password'] = [
                'min_length' =>
                    'Password must contain at least 8 characters.',
                'max_length' =>
                    'Password cannot exceed 255 characters.',
            ];

            $messages['password_confirm'] = [
                'required' =>
                    'Please confirm the new password.',
                'matches' =>
                    'The password confirmation does not match.',
            ];
        }

        $avatar = $this->request->getFile('avatar');

        if (
            $avatar !== null
            && $avatar->getError() !== UPLOAD_ERR_NO_FILE
        ) {
            $rules['avatar'] = [
                'uploaded[avatar]',
                'max_size[avatar,2048]',
                'is_image[avatar]',
                'mime_in[avatar,image/jpeg,image/png]',
                'ext_in[avatar,jpg,jpeg,png]',
            ];

            $messages['avatar'] = [
                'uploaded' =>
                    'Select an avatar to upload.',
                'max_size' =>
                    'The avatar must not exceed 2 MB.',
                'is_image' =>
                    'The uploaded file must be an image.',
                'mime_in' =>
                    'The avatar must be a JPG or PNG image.',
                'ext_in' =>
                    'The avatar must use a JPG or PNG extension.',
            ];
        }

        if (! $this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $username = trim(
            (string) $this->request->getPost('username')
        );

        // Exclude the current user from the uniqueness check.
        $duplicate = $model
            ->where('username', $username)
            ->where('id !=', $id)
            ->first();

        if ($duplicate !== null) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'username' =>
                        'That username is already in use.',
                ]);
        }

        $data = [
            'username' => $username,
            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            ),
        ];

        // Only replace the stored hash when a new password
        // was entered.
        if ($newPassword !== '') {
            $data['password'] = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );
        }

        $oldAvatar = $user['avatar'] ?? null;

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

            service('image')
                ->withFile($avatar->getTempName())
                ->fit(200, 200, 'center')
                ->save(
                    $uploadDirectory
                    . DIRECTORY_SEPARATOR
                    . $filename,
                    85
                );

            $data['avatar'] = $filename;
        }

        $model->update($id, $data);

        // Delete the previous avatar only after the database
        // update succeeds.
        if (
            isset($data['avatar'])
            && ! empty($oldAvatar)
            && $oldAvatar !== $data['avatar']
        ) {
            $oldAvatarPath = FCPATH
                . 'uploads/avatars/'
                . basename((string) $oldAvatar);

            if (is_file($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }

        return redirect()
            ->to(site_url('users'))
            ->with(
                'success',
                'User updated successfully.'
            );
    }
}