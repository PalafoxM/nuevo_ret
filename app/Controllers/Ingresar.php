<?php
namespace App\Controllers;
require_once APPPATH."Libraries/autoload.php";
use CodeIgniter\API\ResponseTrait;

class Ingresar extends BaseController {

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
			$data['title']				=		'Registro Estatal de Turismo | Iniciar Sesión';
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
			$data['main']			=		'public/login';
			$data['footer']			=		'public/footer';

			return view('template', $data);
		}
	}

	public function google_login()
	{
		$client = new \Google\Client();
		$client->setClientId(GOOGLE_ID);
		$client->setClientSecret(GOOGLE_SECRET);
		$client->setRedirectUri(BASE_URL.'ingresar/google-login');
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

			return redirect()->to('panel');
			
		}
		else
		{
			$url = $client->createAuthUrl();
			return redirect()->to(filter_var($url,FILTER_SANITIZE_URL));
		}
	}

	public function microsoft_login()
	{
		$MsftConfig = [
						'callback'	=> 	BASE_URL.'ingresar/microsoft-login',
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
				return redirect()->to('ingresar');

			$client->authenticate('MicrosoftGraph');

			$adapters = $client->getConnectedAdapters();

			$UserInfoMsft = $adapters['MicrosoftGraph']->getUserProfile();

			$data['name'] = $UserInfoMsft->displayName;
			$data['email'] = $UserInfoMsft->email;

			panel_session($data['email'], 'microsoft', $data['name']);

			return redirect()->to('panel');


		} 
		catch(Throwable $e) 
		{
			return redirect()->to('ingresar');

		}
	}

	public function facebook_login()
	{
		$FaceConfig = [
						'callback'	=> 	BASE_URL.'ingresar/facebook-login/',
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
				return redirect()->to('ingresar');

			$client->authenticate('Facebook');

			$adapters = $client->getConnectedAdapters();

			$UserInfoFace = $adapters['Facebook']->getUserProfile();

			$data['name'] = $UserInfoFace->displayName;
			$data['email'] = $UserInfoFace->email;

			panel_session($data['email'], 'facebook', $data['name']);

			return redirect()->to('panel');

		} 
		catch(Throwable $e) 
		{
			return redirect()->to('ingresar');
		}
	}

	public function recaptcha()
	{
		if($this->request->getVar('token') == null)
		{
			return redirect()->to('registro');
		}
		else
		{
			$url 		= 'https://www.google.com/recaptcha/api/siteverify';
			$secret		=	SECRET_KEY;
			$ip 		=	$_SERVER['REMOTE_ADDR'];

			$usuario = $this->request->getVar('clave');
			$contrasena = $this->request->getVar('pass');
			$token = $this->request->getVar('token');

			if (! $this->validate([
								'clave'		=>	'required',
								'pass'		=>	'required',
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
					$login = ret_login($usuario,$contrasena);

					if($login)
					{
						ret_session($usuario);

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

}