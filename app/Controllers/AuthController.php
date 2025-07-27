<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        return view('auth/login_form');
    }

    public function showSignupForm()
    {
        return view('auth/signup_form');
    }

    public function logoutConfirm()
    {
        return view('auth/logout_confirm');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid credentials']);
        }

        session()->set(['user_id' => $user['id'], 'user_name' => $user['firstname']]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Login successful!']);
    }

   public function signup()
    {
        $rules = [
            'email'           => 'required|valid_email|is_unique[users.email]',
            'firstname'       => 'required',
            'lastname'        => 'required',
            'password'        => 'required|min_length[6]',
            'password_confirm'=> 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $userModel = new UserModel();
        $userModel->save([
            'email'     => $this->request->getPost('email'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname'  => $this->request->getPost('lastname'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        $user = $userModel->where('email', $this->request->getPost('email'))->first();
        session()->set(['user_id' => $user['id'], 'user_name' => $user['firstname']]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Sign up successful. You are now logged in!']);
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}