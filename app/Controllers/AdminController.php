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
            return redirect()->to('/admin/profile?tab=details')
                ->with('errors_details', $validation->getErrors());
        }
        
        return redirect()->to('/admin/profile?tab=details')
            ->with('success_details', 'Details updated successfully');
        
        

        // Proses pembaruan data
        $userModel = new User();
        $data = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'bio' => $this->request->getPost('bio'),
        ];
        $userModel->update($user_id, $data);

    }


    public function changePassword()
    {
        $validation = \Config\Services::validation();
        $user_id = CIAuth::user()->id;

        // Validasi input
        $this->validate([
                    'current_password' => [
                        'rules' => 'required|min_length[5]|check_current_password[current_password]',
                        'errors' => [
                            'required' => 'Current password is required',
                            'min_length' => 'Current password must have at least 5 characters',
                            'check_current_password' => 'Current password is incorrect',
                        ],
                    ],
                    'new_password' => [
                        'rules' => 'required|min_length[5]|max_length[20]|is_password_strong[new_password]',
                        'errors' => [
                            'required' => 'New password is required',
                            'min_length' => 'New password must have at least 5 characters',
                            'max_length' => 'New password must not exceed 20 characters',
                            'is_password_strong' => 'New password is not strong enough',
                        ],
                    ],
                    'confirm_password' => [
                        'rules' => 'required|matches[new_password]',
                        'errors' => [
                            'required' => 'Confirm password is required',
                            'matches' => 'Confirm password does not match with new password',
                        ],
                    ],
                ]);

                if (!$validation->withRequest($this->request)->run()) {
                    return redirect()->to('/admin/profile?tab=password')
                        ->with('errors_password', $validation->getErrors());
                }
                
                return redirect()->to('/admin/profile?tab=password')
                    ->with('success_password', 'Password updated successfully');
                
                
        // Proses pembaruan data
        $userModel = new User();
        $data = [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ];
        $userModel->update($user_id, $data);
    }

    public function updatePersonalPicture()
    {
        $file = $this->request->getFile('croppedImage');
        $user_id = CIAuth::user()->id;
        $userModel = new User();
        $path = 'images/users/';
        $old_picture = $userModel->find($user_id)['picture'];

        if ($file && $file->isValid()) {
            $new_filename = 'UIMG_' . $user_id . '_' . $file->getRandomName();

            if ($file->move($path, $new_filename)) {
                // Hapus gambar lama jika ada
                if ($old_picture && file_exists($path . $old_picture)) {
                    unlink($path . $old_picture);
                }

                // Update gambar di database
                $userModel->update($user_id, ['picture' => $new_filename]);

                return redirect()->route('admin.profile')->with('success', 'Profile picture updated successfully');
            }
        }
        return redirect()->route('admin.profile')->with('fail', 'Failed to upload cropped image');
    }


}
