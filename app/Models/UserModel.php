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

    public function getUserById($id)
    {
        $sql = "SELECT*
                FROM user_details
                WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        return $query->getRowArray();
    }
    
    public function insertUser(array $data)
    {
        $sql = "INSERT INTO user_details
                 (name, email, password, phone_no, address, age, nationality, blood_group)
                  VALUES (?,?,?,?,?,?,?,?)";
        
        $this->db->query($sql,[
            $data['name'],
            $data['email'],
            $data['password'],
            $data['phone_no'],
            $data['address'],
            $data['age'],
            $data['nationality'],
            $data['blood_group']
        ]);

        if($this->db->affectedRows() > 0){
            return $this->db->insertID();
        }

        return false;
    }

    public function updateUser($id, array $data, $updatedBy)
    {
        $sql = "UPDATE user_details
                SET 
                    name = ?,
                    email = ?,
                    phone_no = ?,
                    address = ?,
                    age = ?,
                    nationality = ?,
                    blood_group = ?,
                    update_date = CURRENT_TIMESTAMP,
                    updated_by = ?
                WHERE id = ?";
        
        $params = [
            $data['name'],
            $data['email'],
            $data['phone_no'],
            $data['address'],
            $data['age'],
            $data['nationality'],
            $data['blood_group'],
            $updatedBy,
            $id
        ];

        if (isset($data['password'])){

           $sql = "UPDATE user_details
                   SET 
                       name = ?,
                       email = ?,
                       password = ?,
                       phone_no = ?,
                       address = ?,
                       age = ?,
                       nationality = ?,
                       blood_group = ?,
                       update_date = CURRENT_TIMESTAMP,
                       updated_by = ?
                   WHERE id =?";
            
           $params = [
               $data['name'],
               $data['email'],
               $data['password'],
               $data['phone_no'],
               $data['address'],
               $data['age'],
               $data['nationality'],
               $data['blood_group'],
               $updatedBy,
               $id
           ];
            
        }
          
        $this->db->query($sql, $params);

        return $this->db->affectedRows() > 0;

    }

    public function deleteUserById($id)
    {
        $sql = "DELETE FROM user_details
                WHERE id = ?";
        $this->db->query($sql,[$id]);

        return $this->db->affectedRows() > 0;
    }
}
