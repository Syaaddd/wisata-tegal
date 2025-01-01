<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Models\User;

class AdminController extends BaseController
{
    protected $helpers = ['cifunctions', 'form', 'url', 'CImail'];
    protected $User;

    public function index()
    {
        $data = [
            'pageTitle' => 'Dashboard'
        ];
        return view('backend/pages/home', $data);
    }

    public function logoutHandler()
    {
        CIAuth::forget();
        return redirect()->route('admin.login.form')->with('fail', 'Logout successfully');
    }

    public function profile()
    {
        $data = [
            'pageTitle' => 'Profile'
        ];
        return view('backend/pages/profile', $data);
    }

    public function updatePersonalDetails()
    {
        $validation = \Config\Services::validation();
        $user_id = CIAuth::user()->id;
    
        // Validasi input
        $validation->setRules([
            'name' => 'required',
            'username' => 'required|min_length[4]|is_unique[users.username,id,' . $user_id . ']',
        ], [
            'name' => ['required' => 'Name is required'],
            'username' => [
                'required' => 'Username is required',
                'min_length' => 'Username must have at least 4 characters',
                'is_unique' => 'Username is already taken',
            ],
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembalikan ke halaman profil dengan pesan kesalahan
            return redirect()->route('admin.profile')->with('errors', $validation->getErrors());
        }
    
        // Proses pembaruan data
        $userModel = new User();
        $data = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'bio' => $this->request->getPost('bio'),
        ];
        $userModel->update($user_id, $data);
    
        // Jika berhasil, arahkan kembali ke halaman profil dengan pesan sukses
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully');
    }
    
}
