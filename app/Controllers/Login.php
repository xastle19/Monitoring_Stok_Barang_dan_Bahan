<?php

namespace App\Controllers;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = hash('sha256', $this->request->getPost('password'));
        $role     = $this->request->getPost('role');

        $model = new UserModel();
        $user = $model->where('username', $username)
                      ->where('password', $password)
                      ->where('role', $role)
                      ->first();

        if ($user) {
            // Multi-session per role
            switch ($role) {
                case 'Karyawan':
                    session()->set('karyawan_user', $user);
                    return redirect()->to('/karyawan');
                case 'Staf Gudang':
                    session()->set('staf_user', $user);
                    return redirect()->to('/stafgudang');
                case 'Manajer Gudang':
                    session()->set('manajer_user', $user);
                    return redirect()->to('/manajer');
                case 'Keuangan':
                    session()->set('keuangan_user', $user);
                    return redirect()->to('/keuangan');
                default:
                    return redirect()->back()->with('error', 'Peran tidak dikenali.');
            }
        } else {
            return redirect()->back()->with('error', 'Login gagal. Periksa username, password, dan peran.');
        }
    }

    public function logout()
    {
        session()->remove('karyawan_user');
        session()->remove('staf_user');
        session()->remove('manajer_user');
        session()->remove('keuangan_user');

        return redirect()->to('/login');
    }
}
