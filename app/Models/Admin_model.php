<?php
namespace App\Models;
use CodeIgniter\Model;

class Admin_model extends Model {

	public function get_data($tabla, $select = '', $array_where = [], $object = false, $array_groupby = [], $orderby = '', $wherestr = '', $resultArr = false, $join = [], $limit_st = '', $limit_qt = '')
	{
        $builder = $this->db->table($tabla);

        if(count($join) > 0)
			foreach($join as $j)
				$builder->join($j['tabla'], $j['condicion'], $j['tipo']);

        if($select != '')
        	$builder->select($select, false);

        if(count($array_where) > 0)
        	$builder->where($array_where);

        if($wherestr != '')
        	$builder->where($wherestr);

        if(count($array_groupby) > 0)
        	$builder->groupBy($array_groupby);

        if($orderby != '')
        	$builder->orderBy($orderby);

        if($limit_st != '' && $limit_qt != '')
            $builder->limit($limit_qt, $limit_st);

        //$sql = $builder->getCompiledSelect(); echo $sql; die;
        if($object)
        {
        	if($resultArr)
	        	return $builder->get()->getResultArray();
	        else
	        	return $builder->get()->getResult();
        }
        else
        {
            if($r = $builder->get()->getResultArray())
            {
                return $r[0][$select];
            }
            else
                return false;
        }
    }

    public function set_data($tabla, $array_set = [], $array_where = [], $wherestr = '')
    {
    	$builder = $this->db->table($tabla);

    	if($wherestr != '')
    		$builder->where($wherestr);

    	if(count($array_where) > 0)
    		$builder->where($array_where);

    	$builder->update($array_set);

    	return;
    }

    public function delete_data($clave)
    {
    	$builder = $this->db->table('ret_usr');
    	$builder->delete(['id' => $clave]);
    	
    	$builder = $this->db->table('ret_datos_generales');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_tecnicos');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_archivo_legal');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_hospedaje');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_hospedaje_detalle');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_agencia');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_guia');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_promotores');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_restaurantes');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_golf');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_arte');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_educativas');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_arrendadora');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_parques');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_auxturistico');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_balnearios');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_capacitacion');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_deporte');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_spa');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_recinto');
    	$builder->delete(['clave' => $clave]);
    	
    	$builder = $this->db->table('ret_frm_hospedaje-digitales');
    	$builder->delete(['clave' => $clave]);

    	return;
    	
    }

	


}
