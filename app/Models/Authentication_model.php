<?php
namespace App\Models;
use CodeIgniter\Model;

class Authentication_model extends Model {

    function validate_login($postData)
    {
        $builder    =   $this->db->table('user');
        $where      =   [
                        'email'     =>  $postData['email'],
                        'password'  =>  md5($postData['password']),
                        'status'    =>  1
                        ];
        
        $builder->where($where);


        if($r = $builder->get()->getResult())
        {
            return $r;
        }
        else
            return false;
    }

}
