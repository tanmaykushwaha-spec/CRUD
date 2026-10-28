<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user_details';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'email',
        'password',
        'name',
        'phone_no',
        'address',
        'age',
        'nationality',
        'blood_group',
    ];
}
