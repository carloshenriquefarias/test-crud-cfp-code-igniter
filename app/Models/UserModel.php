<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $returnType       = 'object';

    protected $allowedFields    = [    
        'firstname', 
        'lastname',
        'email',
        'dateofbirth',
        'mobile', 
        'username', 
        'password'
    ];
    protected $useSoftDeletes       = true;
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at'; 
    protected $updatedField         = 'updated_at'; 
    protected $deletedField         = 'deleted_at'; 

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data) {        
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT );            
        } 
        return $data;
    }

    public function findUserByID(int $id){
        return $this->where('id', $id)->first();
    }

    protected $validationRules = [
        'id'            => 'max_length[19]',
        'firstname'     => 'required',
        'lastname'      => 'required',
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'dateofbirth'   => 'required|valid_date',
        'mobile'        => 'required|numeric',
        'username'      => 'required|alpha_numeric|min_length[6]|is_unique[users.username,id,{id}]',
        'password'      => 'required|min_length[6]'
    ];

    protected $validationMessages = [
        'firstname' => [
            'required' => 'The First Name field is required.'
        ],
        'lastname' => [
            'required' => 'The Last Name field is required.'
        ],
        'email' => [
            'required' => 'The Email field is required.',
            'valid_email' => 'Please enter a valid email address.',
            'is_unique' => 'This email is already registered.'
        ],
        'dateofbirth' => [
            'required' => 'The Date of Birth field is required.',
            'valid_date' => 'Please enter a valid date of birth.'
        ],
        'mobile' => [
            'required' => 'The Mobile field is required.',
            'numeric' => 'Please enter a valid mobile number.'
        ],
        'username' => [
            'required' => 'The Username field is required.',
            'alpha_numeric' => 'The Username field should contain only letters and numbers.',
            'min_length' => 'The Username must be at least 6 characters long.',
            'is_unique' => 'This username is already in use.'
        ],
        'password' => [
            'required' => 'The Password field is required.',
            'min_length' => 'The password must be at least 6 characters long.'
        ]
    ];
}
