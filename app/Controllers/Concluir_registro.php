<?php
namespace App\Controllers;

class Concluir_registro extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->usuario_model->get($this->session->get('id'), 'porcentaje_registro') < 100)
				return redirect()->to('empresa-avance');

			$data['title']				=		'Registro Estatal de Turismo | Registro Concluido';
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'registro.css?v=2.2',
												BASE_URL.STATIC_CSS.'form.css?v=2.0',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			$data['footer_js']			=	array(
												BASE_URL.STATIC_JS.'form-validation.js',
											);

			$data['nav']			=		'private/nav';
			$data['header']			=		'private/header';
			$data['main']			=		'private/form_template';
			$data['footer']			=		'public/footer';

			$data['controller']		=		'concluir-registro';
			$data['next_cont']		=		'';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Registro Concluido';
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'#';
			$data['form_id']		=		'form_concluir';
			$data['form_field']		=		[
												['link', '<i class="bi-list-stars icon-bar"></i> Ir al Panel', '_self', BASE_URL.'panel', '100', '', 'light', '', ''],
												['bar', '                 Trámite en Validación                 ', $this->session->get('icon_bs'), '', '', '', '', '', '¡Gracias por concluir tu inscripción al RET!'],
												['texto', 'Estaremos revisando tus documentos y si hubiera alguna observación o bien, esté aprobado tu registro te llegará un correo en un plazo máximo de 5 días hábiles.<br><br>¡Muchas gracias!<br>Cualquier duda estamos a tus órdenes en el teléfono<br>(472) 103 99 00 ext. 158 y/o 160'],
												['iframe', 'Su opinión es muy importante para nosotros', '', 'https://forms.gle/JiF6jpqRaAhQeAzS7', '', '', '', '', ' Lo invitamos a responder una breve encuesta de satifacción'],
												['hr'],
												['link', 'Cerrar Sesión', '_self', BASE_URL.'salir', '', '', 'danger', '', ''],
											];


			return view('template', $data);
		}
		else if($this->session->get('api_logged'))
			if($this->usuario_model->get_list_by_email($this->session->get('email'), 'api'))
				return redirect()->to('panel');
			else
				return redirect()->to('registro/nuevo');
		else
			return redirect()->to('ingresar');
	}


} 
