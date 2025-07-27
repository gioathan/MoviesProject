<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'email',
        'firstname',
        'lastname',
        'password',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

    public function getFullName($user_id)
    {
        return $this->select('firstname, lastname')
                    ->where('id', $user_id)
                    ->first();
    }
}