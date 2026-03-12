<?php
namespace App\Controllers;

class Consulta_ciu_busqueda extends BaseController
{
public function index()
	{	
	$this->load->view('consulta/Buscar_live');
    }

public function autocompletar()
{
	
	$builder = $this->db->table('ret_datos_generales');
	$builder->select('nombre_comercial, correo, web, lada, telefono');
	$builder->like('nombre_comercial', $busca_data, 'both');
	$query = $builder->get();
	$resultados = $query->getResult();
	$busca_data = $this->input->post('busca_data');
	if(!empty($resultados))
	{
		foreach ($resultados as $row):
			echo "<li><a href= '#'>" . $row->nombre_comercial . "</li></a>";
		endforeach;
	}
	else
	{
		echo "<li><em>No se encuentran registros</li></em>";
	}
}
}
?>