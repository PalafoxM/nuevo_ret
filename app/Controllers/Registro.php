<?php 
namespace App\Controllers;
require_once APPPATH."Libraries/autoload.php";
use CodeIgniter\API\ResponseTrait;

class Registro extends BaseController {

	use ResponseTrait;

	public function index()
	{
		if($this->session->get('logged'))
			return redirect()->to('datos-generales');
		else if($this->session->get('api_logged'))
			if($this->usuario_model->get_list_by_email($this->session->get('email'), 'api'))
				return redirect()->to('panel');
			else
				return redirect()->to('registro/nuevo');
		else
		{
			$data['title']				=		'Registro Estatal de Turismo | Inscríbete';
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
												'https://www.google.com/recaptcha/api.js?render='.SITE_KEY,
												BASE_URL.STATIC_JS.'jquery.min-3.3.1.js',
												'https://accounts.google.com/gsi/client',
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'ingresar.css',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			$data['nav']			=		'public/nav';
			$data['header']			=		'public/header';
			$data['main']			=		'public/registro';
			$data['footer']			=		'public/footer';

			return view('template', $data);
		}
	}

	public function google_signin()
	{
		$client = new \Google\Client();
		$client->setClientId(GOOGLE_ID);
		$client->setClientSecret(GOOGLE_SECRET);
		$client->setRedirectUri(BASE_URL.'registro/google-signin');
		$client->addScope(['https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile']);
		
		if($code = $this->request->getVar('code'))
		{
			$token = $client->fetchAccessTokenWithAuthCode($code);
			$client->setAccessToken($token);
			$oauth = new \Google\Service\Oauth2($client);
			
			$user_info = $oauth->userinfo->get();
			$data['name'] = $user_info->name;
			$data['email'] = $user_info->email;
			
			panel_session($data['email'], 'google', $data['name']);

			return redirect()->to('registro/nuevo');
			
		}
		else
		{
			$url = $client->createAuthUrl();
			return redirect()->to(filter_var($url,FILTER_SANITIZE_URL));
		}
	}

	public function microsoft_signin()
	{
		$MsftConfig = [
						'callback'	=> 	BASE_URL.'registro/microsoft-signin',
						'providers'	=>	[
										'MicrosoftGraph'	=>	[
										            			'enabled'	=> 	true,
																'keys'		=> 	[
																				'id' 		=> MICROSOFT_ID,
																				'secret' 	=> MICROSOFT_SECRET
																				],
																]
										],
						];


		try 
		{
			$client = new \Hybridauth\Hybridauth($MsftConfig);

			if (isset($_GET['error']) && ($_GET['error'] == 'access_denied' || $_GET['error'] == 'user_cancelled_login' || $_GET['error'] == 'user_cancelled_authorize'))
				return redirect()->to('registro');

			$client->authenticate('MicrosoftGraph');

			$adapters = $client->getConnectedAdapters();

			$UserInfoMsft = $adapters['MicrosoftGraph']->getUserProfile();

			$data['name'] = $UserInfoMsft->displayName;
			$data['email'] = $UserInfoMsft->email;

			panel_session($data['email'], 'microsoft', $data['name']);

			return redirect()->to('registro/nuevo');

		} 
		catch(Throwable $e) 
		{
			return redirect()->to('registro');

		}
	}

	public function facebook_signin()
	{
		$FaceConfig = [
						'callback'	=> 	BASE_URL.'registro/facebook-signin/',
						'providers'	=>	[
										'Facebook'	=>	[
										            			'enabled'	=> 	true,
																'keys'		=> 	[
																				'id' 		=> FACEBOOK_ID,
																				'secret' 	=> FACEBOOK_SECRET
																				],
																]
										],
						];


		try 
		{
			$client = new \Hybridauth\Hybridauth($FaceConfig);

			if (isset($_GET['error']) && ($_GET['error'] == 'access_denied' || $_GET['error'] == 'user_cancelled_login' || $_GET['error'] == 'user_cancelled_authorize'))
				return redirect()->to('registro');

			$client->authenticate('Facebook');

			$adapters = $client->getConnectedAdapters();

			$UserInfoFace = $adapters['Facebook']->getUserProfile();

			$data['name'] = $UserInfoFace->displayName;
			$data['email'] = $UserInfoFace->email;

			panel_session($data['email'], 'facebook', $data['name']);

			return redirect()->to('registro/nuevo');

		} 
		catch(Throwable $e) 
		{
			return redirect()->to('registro');
		}
	}

	public function guardar()
	{
		$rfc 				= str_replace(" ", "", (strtoupper($this->request->getVar('rfc'))));
		$giro 				= $this->request->getVar('giro');
		$municipio 			= $this->request->getVar('municipio');
		$nombre_comercial 	= strtoupper(field_replace($this->request->getVar('nombre_comercial')));
		$acepta_avisos 		= $this->request->getVar('acepta_avisos');

		$ip_visitante		= $_SERVER['REMOTE_ADDR'];

		if (! $this->validate([
								'rfc'				=>		'required|min_length[9]|max_length[13]',
								'giro'				=>		'required',
								'municipio'			=>		'required',
								'nombre_comercial'	=>		'required|min_length[3]|max_length[200]',
								'acepta_avisos'		=>		'required',
								]))
		{

			$alerta = array('titulo'			=>		'Validación',
							'mensaje'			=>		'Hubo un error en la validación. Favor de intentar más tarde.',
							'rfc'				=>		$rfc,
							'giro'				=>		$giro,
							'municipio'			=>		$municipio,
							'nombre_comercial'	=>		$nombre_comercial,
							'acepta_avisos'		=>		$acepta_avisos,
						);
			$this->session->setFlashdata($alerta);

			return redirect()->to('registro/nuevo');
		}
		else
		{
			$array_datos 	=	array(
									'info_rfc'				=>		$rfc,
									'giro'					=>		$giro,
									'municipio'				=>		$municipio,
									'nombre_comercial'		=>		$nombre_comercial,
									'correo'				=>		$this->session->get('email'),
									'privacidad'			=>		(($acepta_avisos == 'on')?1:0),
									'ip_visitante'			=>		$ip_visitante,
									'fecha'					=>		date("Y-m-d"),
									'fecha_registro'		=>		date("Y-m-d H:i:s"),
								);

			$registro = $this->usuario_model->nuevo($array_datos);

			if(isset($registro))
			{
				return redirect()->to('datos-generales');
			}
			else
			{
				$alerta = array('titulo'		=>		'Registro',
								'mensaje'		=>		'Hubo un error en el registro. Favor de verificar su email o intentar nuevamente.');
				$this->session->setFlashdata($alerta);

				return redirect()->to('registro');
			}
		}
   	}

	public function nuevo()
	{
		if($this->session->get('api_logged'))
		{
			$data['title']				=		'Registro Estatal de Turismo | Registro Nuevo';
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'registro.css?v=1.1',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			$data['footer_js']			=	array(
												BASE_URL.STATIC_JS.'form-validation.js',
											);

			$data['nav']			=		'private/nav';
			$data['header']			=		'private/header';
			$data['main']			=		'private/registro_nuevo';
			$data['footer']			=		'public/footer';

			$data['giros']			=		$this->web_model->get_giros();
			$data['municipios']		=		$this->web_model->get_municipios();

			return view('template', $data);
		}
		else if($this->session->get('logged'))
			return redirect()->to('datos-generales');
		else
			return redirect()->to('inicio');
	}

	public function recaptcha()
	{
		if($this->request->getVar('token') == null)
		{
			return redirect()->to('registro');
		}
		else
		{
			$url 		= 	'https://www.google.com/recaptcha/api/siteverify';
			$secret		=	SECRET_KEY;
			$ip 		=	$_SERVER['REMOTE_ADDR'];

			$email = $this->request->getVar('email');
			$token = $this->request->getVar('token');

			
			if (! $this->validate([
									'email'		=>	'required|valid_email|min_length[6]|max_length[120]',
									'token'		=>	'required'
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

				if($responseKeys['success']) 
				{
					$str_verify  = password_generator(40); 
					$preregistro = $this->usuario_model->preregistro($email, $str_verify);

					if($preregistro)
					{

						$data 	=	[
									'success' 	=>	true,
									'level'		=>	'logged'
									];

						return $this->respond($data);
					}
					else
					{
						$data 	=	[
									'success' 	=>	false,
									'level'		=>	'nologged'
									];

						return $this->respond($data);
					}
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

	public function verificacion($_preregistro = '', $_verify = '')
	{
		if(valida_preregistro($_preregistro, $_verify))
		{
			$data['title']				=		'Registro Estatal de Turismo | Verificación';
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js'
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'redireccion.css?v=1.1',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			$data['nav']			=		'public/nav';
			$data['header']			=		'public/header';
			$data['main']			=		'public/redireccion';
			$data['footer']			=		'public/footer';

			$data['message']		=		'La verificación de dirección de correo electrónico ha sido validada. Espera un momento para continuar con tu registro.';
			$data['icon']			=		'envelope-check';
			$data['time']			=		5000;

			$data['subtitle']		=		'Verificación de Pre-registro';
			$data['url']			=		BASE_URL.'registro/nuevo';


			return view('template', $data);
		}
		else
		{
			$data['title']				=		'Registro Estatal de Turismo | Verificación';
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js'
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'redireccion.css?v=1.1',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			$data['nav']			=		'public/nav';
			$data['header']			=		'public/header';
			$data['main']			=		'public/redireccion';
			$data['footer']			=		'public/footer';

			$data['message']		=		'La verificación de dirección de correo electrónico no es válida, favor de verificar.';
			$data['icon']			=		'envelope-slash';
			$data['time']			=		5000;

			$data['subtitle']		=		'Verificación de Pre-registro';
			$data['url']			=		BASE_URL.'registro';

			return view('template', $data);
		}
	}

}