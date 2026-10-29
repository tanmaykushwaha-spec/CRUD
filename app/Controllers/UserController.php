<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    protected function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        return null;
    }

    public function getinfo()
    {
       
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $users = $this->userModel->getAllUserDetails();
        return view('users/userinfo', [
            'users' => $users,
        ]);
    }
}
