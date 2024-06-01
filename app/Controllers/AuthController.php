<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/weather');
        }
        else{
            return view('login');
        }
    }
    public function login(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $AuthModel = new AuthModel();
        $user = $AuthModel->authenticate($email, $password);
        
        if ($user) {
            $ses_data = array(
                // 'id' => $user->id,
                'id' => $user['id'],
                'isLoggedIn' => TRUE
            );
            // Authentication successful
            // set session data or redirect to dashboard;
            $session = session();
            $session->set($ses_data);
            return redirect()->to('/weather');
        } else {
            // Authentication failed
            // Redirect back to login page with error message
            return redirect()->to('/')->with('error', '<div class="alert border-0 bg-light-danger alert-dismissible fade show"><div class="text-danger">Invalid email or password!</div></div>');
        }
    }
    public function logout()
    {

        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
