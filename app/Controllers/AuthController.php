<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class AuthController extends BaseController
{
    private function setSessionUser($data)
    {
        session()->set([
            'isLoggedIn' => true,
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'loggedInTime' => date('Y-m-d H:i:s'),
        ]);
    }

    public function index()
    {
        if ($this->request->getMethod(true) !== 'POST') {
            return view('layout/AuthLayout');
        }

        $model = new User();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $model->where('email', $email)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => false,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Invalid email.',
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->response->setJSON([
                'status' => false,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Invalid password.',
            ]);
        }

        $this->setSessionUser($user);
        return $this->response->setJSON([
            'status' => true,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Login successful.',
        ]);
    }

    public function Logout()
    {
        session()->destroy();
        return $this->response->setJSON([
            'success' => TRUE,
            'icon' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Logout Berhasil',
        ]);
    }
}
