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

    public function getAllUserDetails(): array 
    {
        $sql = 'SELECT id, email, name, phone_no, address, age, nationality, blood_group 
                FROM user_details
                ORDER BY id ASC';
        
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
}
