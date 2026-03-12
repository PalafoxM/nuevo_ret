<?php
namespace App\Controllers;
require_once APPPATH."Libraries/autoload.php";
use CodeIgniter\API\ResponseTrait;

class Consulta_ciudadana extends BaseController {
	
	use ResponseTrait;

	public function index()
	{
		$data['title']			=	'Registro Estatal de Turismo | Consulta Ciudadana';
		$data['head_js']		=	[
										BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
										'https://www.google.com/recaptcha/api.js?render='.SITE_KEY,
										BASE_URL.STATIC_JS.'jquery.min-3.3.1.js',
										'https://accounts.google.com/gsi/client',
									];
		$data['head_css']		=	[
										BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
										BASE_URL.'cc/css/main.css',
										BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
										BASE_URL.STATIC_CSS.'header.css',
										BASE_URL.STATIC_CSS.'inicio.css?v=1.2',
										BASE_URL.STATIC_CSS.'footer.css?v=1.1',
										BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
									];

		$data['footer_script']	=	[
										'infinite_scroll'
									];

		$data['busqueda']		=	[
										'city' 			=>	$this->request->getVar('city'),
										'service' 		=>	$this->request->getVar('service'),
										'category' 		=>	$this->request->getVar('category'),
										'dist_h' 		=>	(($this->request->getVar('dist_h') == 'on')?1:0),
										'tesoros' 		=>	(($this->request->getVar('tesoros') == 'on')?1:0),
										'iso' 			=>	(($this->request->getVar('iso') == 'on')?1:0),
										'dist_m' 		=>	(($this->request->getVar('dist_m') == 'on')?1:0),
										'punto_limpio' 	=>	(($this->request->getVar('punto_limpio') == 'on')?1:0),
										'anfitrion' 	=>	(($this->request->getVar('anfitrion') == 'on')?1:0),
										'competencia' 	=>	(($this->request->getVar('competencia') == 'on')?1:0)										
									];

		$data['nav']			=	'public/nav';
		$data['header']			=	'public/header';
		$data['main']			=	'consulta/listado_infinito';
		$data['footer']			=	'public/footer';

		$data['municipios']		=	$this->web_model->get_municipios();
		$data['giros']			=	$this->web_model->get_giros();

		return view('template', $data);
	}

	public function ver($_clave = '')
	{
		if($_clave == '')
		{
			return redirect()->to('consulta-ciudadana');
		}
		else
		{
			$datos['result'] = $this->admin_model->get_data('vw_usr_datos', 'clave, lada, UPPER(nombre_comercial) AS nombre_comercial, LOWER(IFNULL(dg_correo_atncli,email)) AS correo, UPPER(calle) AS calle, numero, UPPER(colonia) AS colonia, UPPER(municipio_nombre) AS municipio, IFNULL(telefono_comercial,telefono) AS telefono, LOWER(web) AS web, UPPER(SUBSTR(g_giro,5)) AS giro, icon_bs', ['clave' => $_clave, 'visible' => 1, 'concluido' => 1, 'aprobado' => 1, 'giro <>' => 0, 'municipio <>' => 0], true, [], '', '', true, [], '0', '50');

			$datos['content']		=	'consulta/listado';
       		return view('consulta/directorio', $datos);
		}
	}

	public function listado()
	{
		if($this->request->getVar('token') == null)
		{
			$data 	=	[
						'success' 	=>	false,
						'level'		=>	'tkn'
						];

			return $this->respond($data);
		}
		else
		{
			$url 		=	'https://www.google.com/recaptcha/api/siteverify';
			$secret		=	SECRET_KEY;
			$ip 		=	$_SERVER['REMOTE_ADDR'];

			$page 			=	$this->request->getVar('page');
			$city 			=	$this->request->getVar('city');
			$service		=	$this->request->getVar('service');
			$category		=	$this->request->getVar('category');
			$dist_h			=	$this->request->getVar('dist_h');
			$tesoros		=	$this->request->getVar('tesoros');
			$iso			=	$this->request->getVar('iso');
			$dist_m			=	$this->request->getVar('dist_m');
			$punto_limpio	=	$this->request->getVar('punto_limpio');
			$anfitrion		=	$this->request->getVar('anfitrion');
			$competencia	=	$this->request->getVar('competencia');
			$token 			=	$this->request->getVar('token');

			if (! $this->validate([
								'page'		=>	'required',
								'token'		=>	'required',
								]))
			{
				$data 	=	[
							'success' 	=>	false,
							'level'		=>	'validation'
							];

				return $this->respond($data);

			}
			else
			{
				$credential = array(
								'secret'	=>	$secret,
								'response'	=>	$token
								);

				$verify 	= curl_init();
				curl_setopt($verify, CURLOPT_URL, $url);
				curl_setopt($verify, CURLOPT_POST, true);
				curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
				curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($verify);
				$responseKeys = json_decode($response, true);

				if($responseKeys["success"]) 
				{
					$itemsPerPage		=	10;
					$offset 			= 	($page - 1) * $itemsPerPage;

					$where 				=	['visible' => 1, 'concluido' => 1, 'aprobado' => 1];
					$where_str			=	'';

					if($service != '')
						$where_str 		=	"nombre_comercial LIKE '%".$service."%' ESCAPE '!'";
					
					if($city > 0)
						$where 			=	array_merge($where, ['municipio' => $city]);

					if($category > 0)
						$where 			=	array_merge($where, ['giro' => $category]);

					if($dist_h == 1)
						$where 			=	array_merge($where, ['h' => $dist_h]);

					if($tesoros == 1)
						$where 			=	array_merge($where, ['tesoros' => $tesoros]);

					if($iso == 1)
						$where 			=	array_merge($where, ['iso' => $iso]);

					if($dist_m == 1)
						$where 			=	array_merge($where, ['m' => $dist_m]);

					if($punto_limpio == 1)
						$where 			=	array_merge($where, ['punto_limpio' => $punto_limpio]);

					if($anfitrion == 1)
						$where 			=	array_merge($where, ['anfitrion' => $anfitrion]);

					if($competencia == 1)
						$where 			=	array_merge($where, ['estandares' => $competencia]);

					//, 'giro <>' => 0, 

					$datos['result'] 	=	$this->admin_model->get_data('vw_usr_datos', 'clave, lada, UPPER(nombre_comercial) AS nombre_comercial, LOWER(IFNULL(dg_correo_atncli,email)) AS correo, UPPER(calle) AS calle, numero, UPPER(colonia) AS colonia, UPPER(municipio_nombre) AS municipio, IFNULL(telefono_comercial,telefono) AS telefono, LOWER(web) AS web, UPPER(SUBSTR(g_giro,5)) AS giro, icon_bs', $where, true, [], '', $where_str, true, [], "{$offset}", "{$itemsPerPage}");

					header('Content-Type: application/json');
					echo json_encode($datos['result']);
					//return $this->respond($datos['result']);
				}
				else
				{
					$data 	=	[
								'success' 	=>	false,
								'level'		=>	'bot'
								];

					return $this->respond($data);
				}


			}
		}
   	}



}