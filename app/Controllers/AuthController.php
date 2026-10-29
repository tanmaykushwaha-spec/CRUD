<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please enter a valid email address.',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password is required.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(site_url('login'))
                ->withInput()
                ->with('validation_errors', $this->validator->getErrors());
        }

        // Step 2: Read the validated input.
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        // Step 3: Find the user by email.
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        $passwordMatches = false;
        $passwordIsHashed = false;

        // Step 4: Verify the password.
        if ($user !== null) {
            $storedPassword = (string) $user['password'];

            $passwordIsHashed =
                password_get_info($storedPassword)['algo'] !== null;

            $passwordMatches = $passwordIsHashed
                ? password_verify($password, $storedPassword)
                : hash_equals($storedPassword, $password);
        }

        // Step 5: Continue if the credentials are correct.
        if ($user !== null && $passwordMatches) {

            // Upgrade a legacy plain-text password to a hash.
            if (! $passwordIsHashed) {
                $passwordUpdated = $userModel->update($user['id'], [
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                ]);

                if (! $passwordUpdated) {
                    log_message(
                        'error',
                        'Failed to upgrade legacy password for user ID '
                        . $user['id'] . '.'
                    );

                    return redirect()->to(site_url('login'))
                        ->withInput()
                        ->with('error', 'Unable to sign in right now. Please try again.');
                }
            }

            // Step 6: Start the logged-in session.
            session()->regenerate();

            session()->set([
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'isLoggedIn' => true,
            ]);

            // Step 7: Redirect to the user-details page.
            return redirect()->to(site_url('userinfo'));
        }

        // Step 8: Invalid credentials.
        return redirect()->to(site_url('login'))
            ->withInput()
            ->with('error', 'Invalid email or password.')
            ->with('auth_failed', true);
    }
    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
