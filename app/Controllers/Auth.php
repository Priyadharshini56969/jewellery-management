<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

if ($user && $password === $user['password']) {
            $session->set([
                'isLoggedIn' => true,
                'username'   => $user['username']
            ]);
            return redirect()->to('/product'); // or /dashboard if you have one
        } else {
            return redirect()->back()->with('error', 'Invalid username or password.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
