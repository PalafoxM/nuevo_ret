 <?php
namespace App\Controllers;

class Consulta_buscar extends BaseController {
	public function index()
	$this->load->model('Web_model');
	if($_POST){
		$buscar=$this->input->post('Busqueda RET');

	}else{
		$buscar='';
	}
		$data['ret_datos_generales'] = $this->Web_model->buscar($buscar);
		$this->load->view('busca', data);

}