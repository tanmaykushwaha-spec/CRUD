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
     
     
    public function add()
    {
        // Only logged-in users can open the form.
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        // Display the Add User form.
        return view('users/add');
    }

    public function create()
    {
        // 1. Check login status.
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        // 2. Define server-side validation rules.
        $rules = [
            'name' => [
                'label' => 'Name',
                'rules' => 'required',
            ],

            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[user_details.email]',
                'errors' => [
                    'is_unique' => 'This email is already registered.',
                ],
            ],

            'password' => [
                'label' => 'Password',
                'rules' => [
                    'required',
                    'min_length[8]',
                    'regex_match[/^(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{8,}$/]',
                ],
                'errors' => [
                    'min_length' => 'Password must contain at least 8 characters.',
                    'regex_match' => 'Password must contain an uppercase letter and a special character.',
                ],
            ],

            'phone_no' => [
                'label' => 'Phone Number',
                'rules' => 'required|regex_match[/^(?=(?:\D*\d){10}\D*$)[0-9+().\-\s]+$/]',
                'errors' => [
                    'regex_match' => 'Enter a valid phone number containing exactly 10 digits.',
                ],
            ],

            'address' => [
                'label' => 'Address',
                'rules' => 'required',
            ],

            'age' => [
                'label' => 'Age',
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'integer' => 'Age must be a whole number.',
                    'greater_than' => 'Age must be greater than zero.',
                ],
            ],

            'nationality' => [
                'label' => 'Nationality',
                'rules' => 'required',
            ],

            'blood_group' => [
                'label' => 'Blood Group',
                'rules' => 'required',
            ],
        ];

        // 3. Validate all submitted fields.
        if (! $this->validate($rules)) {
            return redirect()->to(site_url('users/new'))
                ->withInput()
                ->with('validation_errors', $this->validator->getErrors());
        }

        // 4. Prepare the data for insertion.
        $userModel = new \App\Models\UserModel();

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'email' => trim((string) $this->request->getPost('email')),
            'password' => password_hash(
                (string) $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'phone_no' => trim((string) $this->request->getPost('phone_no')),
            'address' => trim((string) $this->request->getPost('address')),
            'age' => (int) $this->request->getPost('age'),
            'nationality' => trim((string) $this->request->getPost('nationality')),
            'blood_group' => trim((string) $this->request->getPost('blood_group')),
        ];

        // 5. Insert the new record into the database.
        if (! $userModel->insert($data)) {
            log_message('error', 'Failed to insert a user: ' . json_encode($userModel->errors()));

            return redirect()->to(site_url('users/new'))
                ->withInput()
                ->with('error', 'Unable to save the user. Please try again.');
        }

        // 6. Redirect to the table with a success message.
        return redirect()->to(site_url('userinfo'))
            ->with('success', 'User added successfully.');
        }


    
}
