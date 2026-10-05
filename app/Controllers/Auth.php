<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    /**
     * Display the login page.
     */
    public function login(): string|RedirectResponse
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(site_url('customers'));
        }

        return view('auth/login', [
            'title'  => 'Login',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    /**
     * Process the submitted login form.
     */
    public function attempt(): RedirectResponse
    {
        $rules = [
            'username' => [
                'required',
                'max_length[50]',
            ],
            'password' => [
                'required',
                'max_length[255]',
            ],
        ];

        $messages = [
            'username' => [
                'required'   => 'Username is required.',
                'max_length' => 'Username cannot exceed 50 characters.',
            ],
            'password' => [
                'required'   => 'Password is required.',
                'max_length' => 'Password is too long.',
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

        $username = trim(
            (string) $this->request->getPost('username')
        );

        $password = (string) $this->request->getPost('password');

        $model = new UserModel();

        $user = $model
            ->where('username', $username)
            ->first();

        if (
            $user === null
            || empty($user['password'])
            || ! password_verify(
                $password,
                (string) $user['password']
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'The username or password is incorrect.'
                );
        }

        session()->regenerate(true);

        session()->set([
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'full_name'    => $user['full_name'],
            'is_logged_in' => true,
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with(
                'success',
                'Welcome back, ' . $user['full_name'] . '!'
            );
    }

    /**
     * Display the public signup page.
     */
    public function signup(): string|RedirectResponse
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(site_url('customers'));
        }

        return view('auth/signup', [
            'title'  => 'Sign Up',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    /**
     * Process the submitted signup form.
     */
    public function register(): RedirectResponse
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(site_url('customers'));
        }

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
                'required'   => 'Username is required.',
                'max_length' => 'Username cannot exceed 50 characters.',
                'is_unique'  => 'That username is already in use.',
            ],
            'full_name' => [
                'required'   => 'Full name is required.',
                'max_length' => 'Full name cannot exceed 100 characters.',
            ],
            'password' => [
                'required'   => 'Password is required.',
                'min_length' => 'Password must contain at least 8 characters.',
                'max_length' => 'Password is too long.',
            ],
            'password_confirm' => [
                'required' => 'Please confirm your password.',
                'matches'  => 'The password confirmation does not match.',
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

        $password = (string) $this->request->getPost('password');

        $model = new UserModel();

        $inserted = $model->insert([
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

        if ($inserted === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'The account could not be created. Please try again.'
                );
        }

        return redirect()
            ->to(site_url('login'))
            ->with(
                'success',
                'Account created successfully. You may now log in.'
            );
    }

    /**
     * Log out the current user.
     */
    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()
            ->to(site_url('login'))
            ->with(
                'success',
                'You have been logged out.'
            );
    }
}