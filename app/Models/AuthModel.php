<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    // protected $allowedFields = ['email', 'password'];
    public function authenticate($email, $password){
        // Query the database to check if the user exists
        $pass=md5($password);
        $user = $this->where('email', $email)->where('password', $pass)->first();
        
        return $user;
    }
}
