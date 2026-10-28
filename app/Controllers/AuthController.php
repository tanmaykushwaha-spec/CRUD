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
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel->where('email', $email)->first();

        $passwordMatches = false;
        $passwordIsHashed = false;

        if ($user !== null) {
            $storedPassword = (string) $user['password'];
            $passwordIsHashed = password_get_info($storedPassword)['algo'] !== null;
            $passwordMatches = $passwordIsHashed
                ? password_verify($password, $storedPassword)
                : hash_equals($storedPassword, $password);
        }

        if ($user !== null && $passwordMatches) {
            if (! $passwordIsHashed) {
                $passwordUpdated = $userModel->update($user['id'], [
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                ]);

                if (! $passwordUpdated) {
                    log_message('error', 'Failed to upgrade legacy password for user ID ' . $user['id'] . '.');

                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Unable to sign in right now. Please try again.');
                }
            }

            session()->regenerate();

            session()->set([
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to(site_url('userinfo'));
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
