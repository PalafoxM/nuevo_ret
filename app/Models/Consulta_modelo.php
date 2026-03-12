<?php
namespace App\Models;
use CodeIgniter\Model;

class Consulta_model extends Model {

	function fetch_data($query)
	{
		<!--$this->db->select("*");-->
		$this->db->from("ret_datos_generales");
		if($query != '')
		{
			$this->db->like('nombre_comercial', $query);
			$this->db->or_like('correo', $query);
			$this->db->or_like('web', $query);
			$this->db->or_like('lada', $query);
			$this->db->or_like('telefono', $query);
		}
		$this->db->order_by('nombre_comercial', 'DESC');
		return $this->db->get();
	}


}
