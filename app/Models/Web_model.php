<?php 
namespace App\Models;
use CodeIgniter\Model;

class Web_model extends Model {
    
function get_giros()
    {
        $builder = $this->db->table('ret_giro');

        $builder->orderBy('id_giro','ASC');
        $builder->where('estatus = 1');
        $array = $builder->get()->getResultArray();
        if(count($array)>0)
            return $array;
        else
            return false;
    }

    function get_municipios($form = false)
    {
        $builder = $this->db->table('ret_municipio');

        if($form)
            $builder->select('id_municipio as value_id, municipio as value_name');
        
        $builder->orderBy('municipio','ASC');
        $array = $builder->get()->getResultArray();
        if(count($array)>0)
            return $array;
        else
            return false;
    }  


	
}