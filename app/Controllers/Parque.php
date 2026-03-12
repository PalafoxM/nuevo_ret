<?php
namespace App\Controllers;

class Parque extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 10)
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

			$data['controller']		=		'parque';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_parque';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],

												['number', 'Capacidad máxima del lugar', 'capacidad', (($this->usuario_model->get($this->session->get('id'), 'capacidad', 'ret_frm_parques', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'capacidad', 'ret_frm_parques', 'clave'):((isset($valueFlashdata['capacidad']))?$valueFlashdata['capacidad']:'')), '1', '9999999999', true, false, 'Capacidad máxima del lugar', '', 'required|min_length[1]|max_length[10]|numeric'],
												['texto', 'Seleccione los servicios adicionales que ofrece el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Agencia de viajes', 'serv01', (($this->usuario_model->get($this->session->get('id'), 'serv01', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv01']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Jardines ', 'serv02', (($this->usuario_model->get($this->session->get('id'), 'serv02', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv02']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Zona de carga y descarga', 'serv03', (($this->usuario_model->get($this->session->get('id'), 'serv03', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv03']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Area de registro', 'serv04', (($this->usuario_model->get($this->session->get('id'), 'serv04', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv04']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Restaurante', 'serv05', (($this->usuario_model->get($this->session->get('id'), 'serv05', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv05']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cafetería ', 'serv06', (($this->usuario_model->get($this->session->get('id'), 'serv06', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv06']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Arrendadora de auto', 'serv07', (($this->usuario_model->get($this->session->get('id'), 'serv07', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv07']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Asesoría financiera', 'serv08', (($this->usuario_model->get($this->session->get('id'), 'serv08', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv08']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Centro de negocios', 'serv09', (($this->usuario_model->get($this->session->get('id'), 'serv09', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv09']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Centro de servicios', 'serv10', (($this->usuario_model->get($this->session->get('id'), 'serv10', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv10']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Edecanes', 'serv11', (($this->usuario_model->get($this->session->get('id'), 'serv11', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv11']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Equipo audiovisual', 'serv12', (($this->usuario_model->get($this->session->get('id'), 'serv12', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv12']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Equipo de sonido', 'serv13', (($this->usuario_model->get($this->session->get('id'), 'serv13', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv13']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Estacionamiento', 'serv14', (($this->usuario_model->get($this->session->get('id'), 'serv14', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv14']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Fax', 'serv15', (($this->usuario_model->get($this->session->get('id'), 'serv15', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv15']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Florería', 'serv16', (($this->usuario_model->get($this->session->get('id'), 'serv16', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv16']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Guía de turismo', 'serv17', (($this->usuario_model->get($this->session->get('id'), 'serv17', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv17']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Colgado de lonas y mantas', 'serv18', (($this->usuario_model->get($this->session->get('id'), 'serv18', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv18']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Mobiliario de montaje', 'serv19', (($this->usuario_model->get($this->session->get('id'), 'serv19', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv19']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Montaje de stands', 'serv20', (($this->usuario_model->get($this->session->get('id'), 'serv20', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv20']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Oficinas administrativas', 'serv21', (($this->usuario_model->get($this->session->get('id'), 'serv21', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv21']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Renta de bodegas', 'serv22', (($this->usuario_model->get($this->session->get('id'), 'serv22', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv22']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Renta de taquillas', 'serv23', (($this->usuario_model->get($this->session->get('id'), 'serv23', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv23']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Sanitarios', 'serv24', (($this->usuario_model->get($this->session->get('id'), 'serv24', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv24']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Servicio médico', 'serv25', (($this->usuario_model->get($this->session->get('id'), 'serv25', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv25']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Guardería', 'serv26', (($this->usuario_model->get($this->session->get('id'), 'serv26', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv26']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Servicio de taxis', 'serv27', (($this->usuario_model->get($this->session->get('id'), 'serv27', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv27']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tabaquería', 'serv28', (($this->usuario_model->get($this->session->get('id'), 'serv28', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv28']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Teléfonos', 'serv29', (($this->usuario_model->get($this->session->get('id'), 'serv29', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv29']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Traducción simultánea', 'serv30', (($this->usuario_model->get($this->session->get('id'), 'serv30', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv30']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Proveedores', 'serv31', (($this->usuario_model->get($this->session->get('id'), 'serv31', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv31']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Organización de exposiciones', 'serv32', (($this->usuario_model->get($this->session->get('id'), 'serv32', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv32']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Organización de convenciones', 'serv33', (($this->usuario_model->get($this->session->get('id'), 'serv33', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv33']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Oficinas para comité organizador', 'serv34', (($this->usuario_model->get($this->session->get('id'), 'serv34', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv34']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Equipo de cómputo', 'serv35', (($this->usuario_model->get($this->session->get('id'), 'serv35', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['serv35']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['bar', 'Formas de Pago', 'credit-card', '', '', '', '', '', ''],
												['checkbox', 'American Express', 'tc01', (($this->usuario_model->get($this->session->get('id'), 'tc01', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['tc01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Visa', 'tc02', (($this->usuario_model->get($this->session->get('id'), 'tc02', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['tc02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Master Card', 'tc03', (($this->usuario_model->get($this->session->get('id'), 'tc03', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['tc03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Efectivo', 'tc04', (($this->usuario_model->get($this->session->get('id'), 'tc04', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['tc04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cheque de Viajero', 'tc05', (($this->usuario_model->get($this->session->get('id'), 'tc05', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['tc05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Otra', 'tc06', (($this->usuario_model->get($this->session->get('id'), 'tc06', 'ret_frm_parques', 'clave') == 1)?'checked':((isset($valueFlashdata['tc06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['text', 'Otra, ¿Cuál?', 'otra_tc', (($this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_parques', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_parques', 'clave'):(($this->session->getFlashdata('otra_tc'))?$this->session->getFlashdata('otra_tc'):'')), '0', '120', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[120]','3'],
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