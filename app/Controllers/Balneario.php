<?php
namespace App\Controllers;

class Balneario extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 12)
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

			$data['controller']		=		'balneario';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_balneario';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],

												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['texto', 'Horario de Servicio', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Matutino', 'hor_mat', (($this->usuario_model->get($this->session->get('id'), 'hor_mat', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['hor_mat']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Vespertino', 'hor_vesp', (($this->usuario_model->get($this->session->get('id'), 'hor_vesp', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['hor_vesp']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Diurno', 'hor_diur', (($this->usuario_model->get($this->session->get('id'), 'hor_diur', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['hor_diur']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['number', 'Capacidad máxima del lugar', 'capacidad', (($this->usuario_model->get($this->session->get('id'), 'capacidad', 'ret_frm_balnearios', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'capacidad', 'ret_frm_balnearios', 'clave'):((isset($valueFlashdata['capacidad']))?$valueFlashdata['capacidad']:'')), '1', '9999999999', true, false, 'Capacidad máxima del lugar', '', 'required|min_length[1]|max_length[10]|numeric', '6'],
												['number', 'Número de Albercas', 'alberca', (($this->usuario_model->get($this->session->get('id'), 'alberca', 'ret_frm_balnearios', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'alberca', 'ret_frm_balnearios', 'clave'):((isset($valueFlashdata['alberca']))?$valueFlashdata['alberca']:'')), '1', '9999999999', true, false, 'Número de Albercas', '', 'required|min_length[1]|max_length[10]|numeric', '6'],
												['number', 'Número de Chapoteaderos', 'chapoteadero', (($this->usuario_model->get($this->session->get('id'), 'chapoteadero', 'ret_frm_balnearios', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'chapoteadero', 'ret_frm_balnearios', 'clave'):((isset($valueFlashdata['chapoteadero']))?$valueFlashdata['chapoteadero']:'')), '1', '9999999999', true, false, 'Número de Chapoteaderos', '', 'required|min_length[1]|max_length[10]|numeric', '6'],
												['number', 'Número de Toboganes', 'tobogan', (($this->usuario_model->get($this->session->get('id'), 'tobogan', 'ret_frm_balnearios', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'tobogan', 'ret_frm_balnearios', 'clave'):((isset($valueFlashdata['tobogan']))?$valueFlashdata['tobogan']:'')), '1', '9999999999', true, false, 'Número de Toboganes', '', 'required|min_length[1]|max_length[10]|numeric', '6'],
												['number', 'Número de Cajones de Estacionamiento', 'estacionamiento', (($this->usuario_model->get($this->session->get('id'), 'estacionamiento', 'ret_frm_balnearios', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'estacionamiento', 'ret_frm_balnearios', 'clave'):((isset($valueFlashdata['estacionamiento']))?$valueFlashdata['estacionamiento']:'')), '1', '9999999999', true, false, 'Número de Cajones de Estacionamiento', '', 'required|min_length[1]|max_length[10]|numeric', '6'],
												['select', 'Apertura al Público', 'apertura', (($this->usuario_model->get($this->session->get('id'), 'apertura', 'ret_frm_balnearios', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'apertura', 'ret_frm_balnearios', 'clave'):((isset($valueFlashdata['apertura']))?$valueFlashdata['apertura']:'')), '', '', true, false, '', [
																																['value_id' => 'Todo el año', 'value_name' => 'Todo el año'],
																																['value_id' => 'Fines de semana', 'value_name' => 'Fines de semana'],
																																['value_id' => 'Temporadas', 'value_name' => 'Temporadas'],
																														], 'required', '6'],
												['textarea', 'Mencionar el material promocional que manejan', 'material', (($this->usuario_model->get($this->session->get('id'), 'material', 'ret_frm_balnearios', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'material', 'ret_frm_balnearios', 'clave'):(($this->session->getFlashdata('material'))?$this->session->getFlashdata('material'):'')), '0', '500', false, false, 'Material Promocional', '', ''],
												['textarea', 'Mencionar los medios publicidad que manejan', 'medios', (($this->usuario_model->get($this->session->get('id'), 'medios', 'ret_frm_balnearios', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'medios', 'ret_frm_balnearios', 'clave'):(($this->session->getFlashdata('medios'))?$this->session->getFlashdata('medios'):'')), '0', '500', false, false, 'Medios Publicitairos', '', ''],
												['texto', 'Seleccione los servicios adicionales que ofrece el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Lago artificial', 'serv01', (($this->usuario_model->get($this->session->get('id'), 'serv01', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv01']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Lago natural', 'serv02', (($this->usuario_model->get($this->session->get('id'), 'serv02', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv02']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Aguas termales', 'serv03', (($this->usuario_model->get($this->session->get('id'), 'serv03', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv03']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Albercas de olas', 'serv04', (($this->usuario_model->get($this->session->get('id'), 'serv04', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv04']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Personal salvavidas', 'serv05', (($this->usuario_model->get($this->session->get('id'), 'serv05', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv05']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Toboganes', 'serv06', (($this->usuario_model->get($this->session->get('id'), 'serv06', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv06']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Chapoteaderos', 'serv07', (($this->usuario_model->get($this->session->get('id'), 'serv07', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv07']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tren escénico', 'serv08', (($this->usuario_model->get($this->session->get('id'), 'serv08', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv08']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Áreas verdes', 'serv09', (($this->usuario_model->get($this->session->get('id'), 'serv09', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv09']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Regaderas', 'serv10', (($this->usuario_model->get($this->session->get('id'), 'serv10', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv10']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cafetería', 'serv11', (($this->usuario_model->get($this->session->get('id'), 'serv11', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv11']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Área de asadores', 'serv12', (($this->usuario_model->get($this->session->get('id'), 'serv12', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv12']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Vestidores', 'serv13', (($this->usuario_model->get($this->session->get('id'), 'serv13', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv13']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Sanitarios', 'serv14', (($this->usuario_model->get($this->session->get('id'), 'serv14', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv14']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Área de juegos infantiles', 'serv15', (($this->usuario_model->get($this->session->get('id'), 'serv15', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv15']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Equipo de contingencias', 'serv16', (($this->usuario_model->get($this->session->get('id'), 'serv16', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv16']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Aplicación de mascarillas', 'serv17', (($this->usuario_model->get($this->session->get('id'), 'serv17', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv17']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Masajes', 'serv18', (($this->usuario_model->get($this->session->get('id'), 'serv18', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv18']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Fuentes de sodas', 'serv19', (($this->usuario_model->get($this->session->get('id'), 'serv19', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv19']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Restaruante', 'serv20', (($this->usuario_model->get($this->session->get('id'), 'serv20', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv20']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tienda de souvenirs', 'serv21', (($this->usuario_model->get($this->session->get('id'), 'serv21', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv21']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Boutique', 'serv22', (($this->usuario_model->get($this->session->get('id'), 'serv22', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv22']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Bar', 'serv23', (($this->usuario_model->get($this->session->get('id'), 'serv23', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv23']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Albercas privadas', 'serv24', (($this->usuario_model->get($this->session->get('id'), 'serv24', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv24']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Servicio médico', 'serv25', (($this->usuario_model->get($this->session->get('id'), 'serv25', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv25']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Estacionamiento', 'serv26', (($this->usuario_model->get($this->session->get('id'), 'serv26', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv26']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Hotel', 'serv27', (($this->usuario_model->get($this->session->get('id'), 'serv27', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv27']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Villas', 'serv28', (($this->usuario_model->get($this->session->get('id'), 'serv28', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv28']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cabañas', 'serv29', (($this->usuario_model->get($this->session->get('id'), 'serv29', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv29']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Bungalows', 'serv30', (($this->usuario_model->get($this->session->get('id'), 'serv30', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv30']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Área de acampar', 'serv31', (($this->usuario_model->get($this->session->get('id'), 'serv31', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv31']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Área de para eventos', 'serv32', (($this->usuario_model->get($this->session->get('id'), 'serv32', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv32']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Lavandería y tintorería', 'serv33', (($this->usuario_model->get($this->session->get('id'), 'serv33', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv33']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Spa', 'serv34', (($this->usuario_model->get($this->session->get('id'), 'serv34', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv34']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Palapas', 'serv35', (($this->usuario_model->get($this->session->get('id'), 'serv35', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv35']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Temazcal', 'serv36', (($this->usuario_model->get($this->session->get('id'), 'serv36', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['serv36']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['textarea', 'Otros Servicios', 'serv_otro', (($this->usuario_model->get($this->session->get('id'), 'serv_otro', 'ret_frm_balnearios', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'serv_otro', 'ret_frm_balnearios', 'clave'):(($this->session->getFlashdata('serv_otro'))?$this->session->getFlashdata('serv_otro'):'')), '0', '800', false, false, 'En caso de contar más servicios', '', ''],
												['bar', 'Formas de Pago', 'credit-card', '', '', '', '', '', ''],
												['checkbox', 'American Express', 'tc01', (($this->usuario_model->get($this->session->get('id'), 'tc01', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['tc01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Visa', 'tc02', (($this->usuario_model->get($this->session->get('id'), 'tc02', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['tc02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Master Card', 'tc03', (($this->usuario_model->get($this->session->get('id'), 'tc03', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['tc03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Efectivo', 'tc04', (($this->usuario_model->get($this->session->get('id'), 'tc04', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['tc04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cheque de Viajero', 'tc05', (($this->usuario_model->get($this->session->get('id'), 'tc05', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['tc05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Otra', 'tc06', (($this->usuario_model->get($this->session->get('id'), 'tc06', 'ret_frm_balnearios', 'clave') == 1)?'checked':((isset($valueFlashdata['tc06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['text', 'Otra, ¿Cuál?', 'otra_tc', (($this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_balnearios', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_balnearios', 'clave'):(($this->session->getFlashdata('otra_tc'))?$this->session->getFlashdata('otra_tc'):'')), '0', '120', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[120]','3'],
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