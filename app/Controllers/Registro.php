<?php
namespace App\Controllers;
require_once APPPATH . "Libraries/autoload.php";

use CodeIgniter\API\ResponseTrait;

class Registro extends BaseController
{
	use ResponseTrait;

	public function index()
	{
		if ($this->session->get('logged'))
			return redirect()->to('datos-generales');
		else if ($this->session->get('api_logged'))
		{
			try
			{
				if ($this->usuario_model && $this->usuario_model->get_list_by_email($this->session->get('email'), 'api'))
					return redirect()->to('panel');
			}
			catch (\Throwable $exception)
			{
				$this->session->remove(['api_logged', 'api_source', 'email', 'name']);
				$this->session->setFlashdata([
					'titulo'	=>	'Registro',
					'mensaje'	=>	'La base de datos del RET no esta disponible en este entorno. Puedes revisar esta pantalla renovada, pero el formulario completo requiere la BD del sistema.',
				]);
			}

			return redirect()->to('registro');
		}
		else
		{
			$data['title'] = 'Registro Estatal de Turismo | Inscribete';
			$data['head_js'] = [
				BASE_URL . STATIC_JS . 'bootstrap.bundle.min.5.1.0.js',
			];
			$data['head_css'] = [
				BASE_URL . STATIC_CSS . 'bootstrap.min.5.1.0.css',
				BASE_URL . STATIC_CSS . 'template.css?v=1.1.2',
				BASE_URL . STATIC_CSS . 'header.css',
				BASE_URL . STATIC_CSS . 'ingresar.css?v=2.1',
				BASE_URL . STATIC_CSS . 'footer.css?v=1.1',
				BASE_URL . STATIC_CSS . 'bootstrap-icons.css',
			];
			$data['nav'] = 'public/nav';
			$data['header'] = 'public/header';
			$data['main'] = 'public/registro';
			$data['footer'] = 'public/footer';

			return view('template', $data);
		}
	}

	public function google_signin()
	{
		$client = new \Google\Client();
		$client->setClientId(GOOGLE_ID);
		$client->setClientSecret(GOOGLE_SECRET);
		$client->setRedirectUri(BASE_URL . 'registro/google-signin');
		$client->addScope(['https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile']);

		if ($code = $this->request->getVar('code'))
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
			return redirect()->to(filter_var($url, FILTER_SANITIZE_URL));
		}
	}

	public function microsoft_signin()
	{
		$MsftConfig = [
			'callback' => BASE_URL . 'registro/microsoft-signin',
			'providers' => [
				'MicrosoftGraph' => [
					'enabled' => true,
					'keys' => [
						'id' => MICROSOFT_ID,
						'secret' => MICROSOFT_SECRET,
					],
				],
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
		catch (\Throwable $e)
		{
			return redirect()->to('registro');
		}
	}

	public function facebook_signin()
	{
		$FaceConfig = [
			'callback' => BASE_URL . 'registro/facebook-signin/',
			'providers' => [
				'Facebook' => [
					'enabled' => true,
					'keys' => [
						'id' => FACEBOOK_ID,
						'secret' => FACEBOOK_SECRET,
					],
				],
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
		catch (\Throwable $e)
		{
			return redirect()->to('registro');
		}
	}

	public function guardar()
	{
		$rfc = str_replace(" ", "", strtoupper($this->request->getVar('rfc')));
		$giro = $this->request->getVar('giro');
		$municipio = $this->request->getVar('municipio');
		$nombre_comercial = strtoupper(field_replace($this->request->getVar('nombre_comercial')));
		$fecha_inicio_operacion = $this->request->getVar('fecha_inicio_operacion');
		$acepta_avisos = $this->request->getVar('acepta_avisos');

		$ip_visitante = $_SERVER['REMOTE_ADDR'];

		if (! $this->validate([
			'rfc' => 'required|min_length[9]|max_length[13]',
			'giro' => 'required',
			'municipio' => 'required',
			'nombre_comercial' => 'required|min_length[3]|max_length[200]',
			'fecha_inicio_operacion' => 'required|valid_date[Y-m-d]',
			'acepta_avisos' => 'required',
		]))
		{
			$alerta = [
				'titulo' => 'Validacion',
				'mensaje' => 'Hubo un error en la validacion. Favor de intentar mas tarde.',
				'rfc' => $rfc,
				'giro' => $giro,
				'municipio' => $municipio,
				'nombre_comercial' => $nombre_comercial,
				'fecha_inicio_operacion' => $fecha_inicio_operacion,
				'acepta_avisos' => $acepta_avisos,
			];
			$this->session->setFlashdata($alerta);

			return redirect()->to('registro/nuevo');
		}
		else
		{
			$array_datos = [
				'info_rfc' => $rfc,
				'giro' => $giro,
				'municipio' => $municipio,
				'nombre_comercial' => $nombre_comercial,
				'fecha_inicio_operacion' => $fecha_inicio_operacion,
				'correo' => $this->session->get('email'),
				'privacidad' => (($acepta_avisos == 'on') ? 1 : 0),
				'ip_visitante' => $ip_visitante,
				'fecha' => date("Y-m-d"),
				'fecha_registro' => date("Y-m-d H:i:s"),
			];

			$registro = $this->usuario_model->nuevo($array_datos);

			if (isset($registro))
			{
				return redirect()->to('datos-generales');
			}
			else
			{
				$alerta = [
					'titulo' => 'Registro',
					'mensaje' => 'Hubo un error en el registro. Favor de verificar su email o intentar nuevamente.',
				];
				$this->session->setFlashdata($alerta);

				return redirect()->to('registro');
			}
		}
	}

	public function nuevo()
	{
		if ($this->session->get('api_logged'))
		{
			$data['title'] = 'Registro Estatal de Turismo | Registro Nuevo';
			$data['head_js'] = [
				BASE_URL . STATIC_JS . 'bootstrap.bundle.min.5.1.0.js',
			];
			$data['head_css'] = [
				BASE_URL . STATIC_CSS . 'bootstrap.min.5.1.0.css',
				BASE_URL . STATIC_CSS . 'template.css?v=1.1.2',
				BASE_URL . STATIC_CSS . 'header.css',
				BASE_URL . STATIC_CSS . 'registro.css?v=2.1',
				BASE_URL . STATIC_CSS . 'footer.css?v=1.1',
				BASE_URL . STATIC_CSS . 'bootstrap-icons.css',
			];
			$data['footer_js'] = [
				BASE_URL . STATIC_JS . 'form-validation.js',
			];

			$data['nav'] = 'private/nav';
			$data['header'] = 'private/header';
			$data['main'] = 'private/registro_nuevo';
			$data['footer'] = 'public/footer';

			$data['demo_mode'] = false;
			$data['giros'] = [];
			$data['municipios'] = [];

			try
			{
				if (! $this->web_model)
					throw new \RuntimeException('Web model unavailable');

				$data['giros'] = $this->web_model->get_giros();
				$data['municipios'] = $this->web_model->get_municipios();
			}
			catch (\Throwable $exception)
			{
				$data['demo_mode'] = true;
				$data['giros'] = [
					['id_giro' => 1, 'giro' => 'Hospedaje'],
					['id_giro' => 5, 'giro' => 'Alimentos y Bebidas'],
					['id_giro' => 10, 'giro' => 'Parques Tematicos'],
					['id_giro' => 17, 'giro' => 'Hospedaje en Plataformas Digitales'],
				];
				$data['municipios'] = [
					['id_municipio' => 11, 'municipio' => 'Leon'],
					['id_municipio' => 15, 'municipio' => 'Guanajuato'],
					['id_municipio' => 17, 'municipio' => 'Irapuato'],
					['id_municipio' => 20, 'municipio' => 'San Miguel de Allende'],
				];
			}

			return view('template', $data);
		}
		else if ($this->session->get('logged'))
			return redirect()->to('datos-generales');
		else
			return redirect()->to('inicio');
	}

	public function recaptcha()
	{
		$email = strtolower(trim((string) $this->request->getVar('email')));
		$repeat_email = strtolower(trim((string) $this->request->getVar('repeat_email')));

		if (! $this->validate([
			'email' => 'required|valid_email|min_length[6]|max_length[120]',
			'repeat_email' => 'required|valid_email|min_length[6]|max_length[120]',
		]))
		{
			$data = [
				'success' => false,
				'level' => 'validation',
				'message' => 'Verifica el correo electronico capturado.',
			];

			if ($this->request->isAJAX())
				return $this->respond($data, 422);

			$this->session->setFlashdata([
				'titulo' => 'Registro',
				'mensaje' => $data['message'],
			]);

			return redirect()->to('registro');
		}

		if ($email !== $repeat_email)
		{
			$data = [
				'success' => false,
				'level' => 'validation',
				'message' => 'Los correos electronicos no coinciden.',
			];

			if ($this->request->isAJAX())
				return $this->respond($data, 422);

			$this->session->setFlashdata([
				'titulo' => 'Registro',
				'mensaje' => $data['message'],
			]);

			return redirect()->to('registro');
		}

		panel_session($email, 'email');

		$data = [
			'success' => true,
			'level' => 'logged',
			'redirect' => BASE_URL . 'registro/nuevo',
		];

		if ($this->request->isAJAX())
			return $this->respond($data);

		return redirect()->to('registro/nuevo');
	}

	public function verificacion($_preregistro = '', $_verify = '')
	{
		if (valida_preregistro($_preregistro, $_verify))
		{
			$data['title'] = 'Registro Estatal de Turismo | Verificacion';
			$data['head_js'] = [
				BASE_URL . STATIC_JS . 'bootstrap.bundle.min.5.1.0.js',
			];
			$data['head_css'] = [
				BASE_URL . STATIC_CSS . 'bootstrap.min.5.1.0.css',
				BASE_URL . STATIC_CSS . 'template.css?v=1.1.2',
				BASE_URL . STATIC_CSS . 'header.css',
				BASE_URL . STATIC_CSS . 'redireccion.css?v=1.1',
				BASE_URL . STATIC_CSS . 'footer.css?v=1.1',
				BASE_URL . STATIC_CSS . 'bootstrap-icons.css',
			];
			$data['nav'] = 'public/nav';
			$data['header'] = 'public/header';
			$data['main'] = 'public/redireccion';
			$data['footer'] = 'public/footer';

			$data['message'] = 'La verificacion de direccion de correo electronico ha sido validada. Espera un momento para continuar con tu registro.';
			$data['icon'] = 'envelope-check';
			$data['time'] = 5000;
			$data['subtitle'] = 'Verificacion de Pre-registro';
			$data['url'] = BASE_URL . 'registro/nuevo';

			return view('template', $data);
		}
		else
		{
			$data['title'] = 'Registro Estatal de Turismo | Verificacion';
			$data['head_js'] = [
				BASE_URL . STATIC_JS . 'bootstrap.bundle.min.5.1.0.js',
			];
			$data['head_css'] = [
				BASE_URL . STATIC_CSS . 'bootstrap.min.5.1.0.css',
				BASE_URL . STATIC_CSS . 'template.css?v=1.1.2',
				BASE_URL . STATIC_CSS . 'header.css',
				BASE_URL . STATIC_CSS . 'redireccion.css?v=1.1',
				BASE_URL . STATIC_CSS . 'footer.css?v=1.1',
				BASE_URL . STATIC_CSS . 'bootstrap-icons.css',
			];
			$data['nav'] = 'public/nav';
			$data['header'] = 'public/header';
			$data['main'] = 'public/redireccion';
			$data['footer'] = 'public/footer';

			$data['message'] = 'La verificacion de direccion de correo electronico no es valida, favor de verificar.';
			$data['icon'] = 'envelope-slash';
			$data['time'] = 5000;
			$data['subtitle'] = 'Verificacion de Pre-registro';
			$data['url'] = BASE_URL . 'registro';

			return view('template', $data);
		}
	}
}
