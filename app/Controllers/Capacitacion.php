<?php
namespace App\Controllers;

class Capacitacion extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 13)
				return redirect()->to('datos-generales');
			if($this->usuario_model->get($this->session->get('id'), 'porcentaje_registro') < 60 || $this->usuario_model->get($this->session->get('id'), 'concluido') == 1)
				return redirect()->to('empresa-avance');

			$data['title']				=		'Registro Estatal de Turismo | '.$this->session->get('g_resumen');
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'jquery.min-3.3.1.js',
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'registro.css?v=1.1',
												BASE_URL.STATIC_CSS.'form.css',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			$data['footer_js']			=	array(
												BASE_URL.STATIC_JS.'form-validation.js',
											);

			$valueFlashdata 		= 		[];
			if($this->session->getFlashdata('values'))
				$valueFlashdata 	= 		$this->session->getFlashdata('values');

			$data['nav']			=		'private/nav';
			$data['header']			=		'private/header';
			$data['main']			=		'private/form_template';
			$data['footer']			=		'public/footer';

			$data['controller']		=		'capacitacion';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_capacitacion';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],

												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['text', 'Horario de servicio', 'horario', (($this->usuario_model->get($this->session->get('id'), 'horario', 'ret_frm_capacitacion', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'horario', 'ret_frm_capacitacion', 'clave'):(($this->session->getFlashdata('horario'))?$this->session->getFlashdata('horario'):'')), '0', '120', false, false, 'Horario', '', 'min_length[0]|max_length[120]'],
												['textarea', 'Asociaciones a las que pertenece', 'asociaciones', (($this->usuario_model->get($this->session->get('id'), 'asociaciones', 'ret_frm_capacitacion', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'asociaciones', 'ret_frm_capacitacion', 'clave'):(($this->session->getFlashdata('asociaciones'))?$this->session->getFlashdata('asociaciones'):'')), '0', '500', false, false, 'Asociaciones', '', ''],
												['textarea', 'Certificaciones y/o acreditaciones obtenidas', 'certificaciones', (($this->usuario_model->get($this->session->get('id'), 'certificaciones', 'ret_frm_capacitacion', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'certificaciones', 'ret_frm_capacitacion', 'clave'):(($this->session->getFlashdata('certificaciones'))?$this->session->getFlashdata('certificaciones'):'')), '0', '500', false, false, 'Certificaciones', '', ''],
												['textarea', 'Matrícula de carreras enfocadas al turismo', 'matricula', (($this->usuario_model->get($this->session->get('id'), 'matricula', 'ret_frm_capacitacion', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'matricula', 'ret_frm_capacitacion', 'clave'):(($this->session->getFlashdata('matricula'))?$this->session->getFlashdata('matricula'):'')), '0', '500', false, false, 'Asociaciones', '', ''],
												['hr'],
												['number', 'No. de personas que imparten la capacitación en los planteles', 'nopersonas', (($this->usuario_model->get($this->session->get('id'), 'nopersonas', 'ret_frm_capacitacion', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'nopersonas', 'ret_frm_capacitacion', 'clave'):((isset($valueFlashdata['nopersonas']))?$valueFlashdata['nopersonas']:'')), '1', '9999999999', true, false, 'No. de personas que imparten la capacitación en los planteles', '', 'required|min_length[1]|max_length[10]|numeric'],
												['bar', 'Servicios', 'record-circle', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['texto', 'Seleccione las características del servicio que ofrece el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Registro estatal', 'serv01', (($this->usuario_model->get($this->session->get('id'), 'serv01', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv01']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Registro federal', 'serv02', (($this->usuario_model->get($this->session->get('id'), 'serv02', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv02']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Sin registro', 'serv03', (($this->usuario_model->get($this->session->get('id'), 'serv03', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv03']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Autónoma', 'serv04', (($this->usuario_model->get($this->session->get('id'), 'serv04', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv04']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pública', 'serv05', (($this->usuario_model->get($this->session->get('id'), 'serv05', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv05']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Privada', 'serv06', (($this->usuario_model->get($this->session->get('id'), 'serv06', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv06']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Postgrados', 'serv07', (($this->usuario_model->get($this->session->get('id'), 'serv07', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv07']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Registro STPS', 'serv08', (($this->usuario_model->get($this->session->get('id'), 'serv08', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv08']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Instructor independiente', 'serv09', (($this->usuario_model->get($this->session->get('id'), 'serv09', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv09']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Instructor habilitado', 'serv10', (($this->usuario_model->get($this->session->get('id'), 'serv10', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv10']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Institución capacitadora', 'serv11', (($this->usuario_model->get($this->session->get('id'), 'serv11', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv11']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Vinculación escuela-empresa', 'serv12', (($this->usuario_model->get($this->session->get('id'), 'serv12', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv12']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Programa de becas', 'serv13', (($this->usuario_model->get($this->session->get('id'), 'serv13', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv13']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Intercambio escolar', 'serv14', (($this->usuario_model->get($this->session->get('id'), 'serv14', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv14']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Talleres especializados', 'serv15', (($this->usuario_model->get($this->session->get('id'), 'serv15', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv15']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Idiomas', 'serv16', (($this->usuario_model->get($this->session->get('id'), 'serv16', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['serv16']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['bar', 'Formas de Pago', 'credit-card', '', '', '', '', '', ''],
												['checkbox', 'American Express', 'tc01', (($this->usuario_model->get($this->session->get('id'), 'tc01', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['tc01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Visa', 'tc02', (($this->usuario_model->get($this->session->get('id'), 'tc02', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['tc02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Master Card', 'tc03', (($this->usuario_model->get($this->session->get('id'), 'tc03', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['tc03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Efectivo', 'tc06', (($this->usuario_model->get($this->session->get('id'), 'tc06', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['tc06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cheque de Viajero', 'tc04', (($this->usuario_model->get($this->session->get('id'), 'tc04', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['tc04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Otra', 'tc05', (($this->usuario_model->get($this->session->get('id'), 'tc05', 'ret_frm_capacitacion', 'clave') == 1)?'checked':((isset($valueFlashdata['tc05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['text', 'Otra, ¿Cuál?', 'otra_tc', (($this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_capacitacion', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_capacitacion', 'clave'):(($this->session->getFlashdata('otra_tc'))?$this->session->getFlashdata('otra_tc'):'')), '0', '120', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[120]','3'],
												['hr'],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
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