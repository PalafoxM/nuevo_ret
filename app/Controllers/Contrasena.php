<?php
namespace App\Controllers;

class Contrasena extends BaseController {

	public function index()
	{
		if($this->session->get('api_logged'))
			return redirect()->to('panel');
		else if(funcionalidad(1) && $this->session->get('logged'))
		{
			$data['title']				=		'Registro Estatal de Turismo | Cambiar Contraseña';
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
			$data['main']			=		'private/password';
			$data['footer']			=		'public/footer';

			return view('template', $data);
		}
		else
			return redirect()->to('inicio');
	}

	public function actualizar()
	{
		if(funcionalidad(1) && $this->session->get('logged'))
		{
			$keypass_new 	= $this->request->getVar('keypass_new');
			$keypass_rpt 	= $this->request->getVar('keypass_rpt');

			if ($this->validate([
								'keypass_new'		=>		'required|matches[keypass_rpt]|min_length[8]|max_length[15]',
								'keypass_rpt'		=>		'required|min_length[8]|max_length[15]',
								]) == FALSE)
			{
				$alerta = array('titulo'			=>		'Validación',
								'mensaje'			=>		'Hubo un error en la validación. Favor de intentar más tarde.',
								'keypass_new'		=>		$keypass_new,
								'keypass_rpt'		=>		$keypass_rpt,
							);
				$this->session->setFlashdata($alerta);

				return redirect()->to('cambiar-contrasena');
			}
			else
			{
				if($update = $this->usuario_model->cambiar_password($keypass_new))
				{
					$this->session->destroy();
					return redirect()->to('ingresar');
				}
				else
				{
					$alerta = array('titulo'			=>		'Actualización',
									'mensaje'			=>		'Hubo un error en la actualización. Favor de intentar más tarde.',
									'keypass_new'		=>		$keypass_new,
									'keypass_rpt'		=>		$keypass_rpt,
								);
					$this->session->setFlashdata($alerta);

					return redirect()->to('cambiar-contrasena');
				}
			}
		}
		else
			return redirect()->to('ingresar');
   	}


}