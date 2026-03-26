<?php
namespace App\Controllers;

class Deporte extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 14)
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
												BASE_URL.STATIC_CSS.'registro.css?v=2.2',
												BASE_URL.STATIC_CSS.'form.css?v=2.0',
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

			$data['controller']		=		'deporte';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_deporte';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],

												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['texto', 'Seleccione el tipo de actividad que ofrece el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Pesca Deportiva', 'pesca', (($this->usuario_model->get($this->session->get('id'), 'pesca', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['pesca']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Rancho Cinegético', 'rancho', (($this->usuario_model->get($this->session->get('id'), 'rancho', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['rancho']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Deporte', 'deporte', (($this->usuario_model->get($this->session->get('id'), 'deporte', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['deporte']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Recreación', 'recreacion', (($this->usuario_model->get($this->session->get('id'), 'recreacion', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['recreacion']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['hr'],
												['textarea', 'Detallar la Actividad', 'detalle', (($this->usuario_model->get($this->session->get('id'), 'detalle', 'ret_frm_deporte', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'detalle', 'ret_frm_deporte', 'clave'):(($this->session->getFlashdata('detalle'))?$this->session->getFlashdata('detalle'):'')), '0', '500', true, false, 'Actividades en Detalle', '', 'required|min_length[0]|max_length[500]'],
												['number', 'Superficie (hectáreas)', 'superficie', (($this->usuario_model->get($this->session->get('id'), 'superficie', 'ret_frm_deporte', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'superficie', 'ret_frm_deporte', 'clave'):((isset($valueFlashdata['superficie']))?$valueFlashdata['superficie']:'')), '0', '9999999999', false, false, 'Superficie', '', 'min_length[0]|max_length[10]|numeric'],
												['bar', 'Servicios', 'record-circle', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['texto', 'Seleccione los servicios que ofrece el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Hotel', 'serv01', (($this->usuario_model->get($this->session->get('id'), 'serv01', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv01']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Restaurante', 'serv02', (($this->usuario_model->get($this->session->get('id'), 'serv02', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv02']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Renta de armas', 'serv03', (($this->usuario_model->get($this->session->get('id'), 'serv03', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv03']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Venta de cartuchos', 'serv04', (($this->usuario_model->get($this->session->get('id'), 'serv04', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv04']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Venta de equipo fotográfico', 'serv05', (($this->usuario_model->get($this->session->get('id'), 'serv05', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv05']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Servicio de transporte', 'serv06', (($this->usuario_model->get($this->session->get('id'), 'serv06', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv06']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Asistente o guía', 'serv07', (($this->usuario_model->get($this->session->get('id'), 'serv07', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv07']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Safari fotográfico', 'serv08', (($this->usuario_model->get($this->session->get('id'), 'serv08', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv08']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['hr'],
												['texto', 'Seleccione los servicios adicionales que ofrece el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Evaluación física y nutricional', 'serv09', (($this->usuario_model->get($this->session->get('id'), 'serv09', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv09']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Gimnasia', 'serv10', (($this->usuario_model->get($this->session->get('id'), 'serv10', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv10']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Aerobics', 'serv11', (($this->usuario_model->get($this->session->get('id'), 'serv11', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv11']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Piscina cubierta', 'serv12', (($this->usuario_model->get($this->session->get('id'), 'serv12', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv12']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Piscina descubierta', 'serv13', (($this->usuario_model->get($this->session->get('id'), 'serv13', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv13']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Gimnasia acuática', 'serv14', (($this->usuario_model->get($this->session->get('id'), 'serv14', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv14']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Campos de golf', 'serv15', (($this->usuario_model->get($this->session->get('id'), 'serv15', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv15']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Club hípico', 'serv16', (($this->usuario_model->get($this->session->get('id'), 'serv16', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv16']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Talasoterapia', 'serv17', (($this->usuario_model->get($this->session->get('id'), 'serv17', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv17']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Masaje suizo', 'serv18', (($this->usuario_model->get($this->session->get('id'), 'serv18', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv18']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Masaje reductivo', 'serv19', (($this->usuario_model->get($this->session->get('id'), 'serv19', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv19']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Masaje terapéutico', 'serv20', (($this->usuario_model->get($this->session->get('id'), 'serv20', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv20']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Masaje deportivo', 'serv21', (($this->usuario_model->get($this->session->get('id'), 'serv21', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv21']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Aroma terapia', 'serv22', (($this->usuario_model->get($this->session->get('id'), 'serv22', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv22']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Reflexología', 'serv23', (($this->usuario_model->get($this->session->get('id'), 'serv23', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv23']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Algas', 'serv24', (($this->usuario_model->get($this->session->get('id'), 'serv24', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv24']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Fangos', 'serv25', (($this->usuario_model->get($this->session->get('id'), 'serv25', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv25']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Herbales', 'serv26', (($this->usuario_model->get($this->session->get('id'), 'serv26', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv26']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Sauna', 'serv27', (($this->usuario_model->get($this->session->get('id'), 'serv27', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv27']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Vapor	', 'serv28', (($this->usuario_model->get($this->session->get('id'), 'serv28', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv28']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Jacuzzi', 'serv29', (($this->usuario_model->get($this->session->get('id'), 'serv29', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv29']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tratamientos faciales', 'serv30', (($this->usuario_model->get($this->session->get('id'), 'serv30', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv30']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Boutique', 'serv31', (($this->usuario_model->get($this->session->get('id'), 'serv31', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv31']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Salón de belleza', 'serv32', (($this->usuario_model->get($this->session->get('id'), 'serv32', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv32']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cafetería', 'serv33', (($this->usuario_model->get($this->session->get('id'), 'serv33', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv33']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Restaurantes', 'serv34', (($this->usuario_model->get($this->session->get('id'), 'serv34', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv34']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Enfermería', 'serv35', (($this->usuario_model->get($this->session->get('id'), 'serv35', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv35']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Hotel', 'serv36', (($this->usuario_model->get($this->session->get('id'), 'serv36', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv36']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Villas', 'serv37', (($this->usuario_model->get($this->session->get('id'), 'serv37', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv37']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cabañas', 'serv38', (($this->usuario_model->get($this->session->get('id'), 'serv38', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv38']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Bungalows', 'serv39', (($this->usuario_model->get($this->session->get('id'), 'serv39', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv39']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Áreas de acampar', 'serv40', (($this->usuario_model->get($this->session->get('id'), 'serv40', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv40']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Servicio a cuartos', 'serv41', (($this->usuario_model->get($this->session->get('id'), 'serv41', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv41']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Áreas para eventos', 'serv42', (($this->usuario_model->get($this->session->get('id'), 'serv42', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv42']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Lavandería y tintorería', 'serv43', (($this->usuario_model->get($this->session->get('id'), 'serv43', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv43']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Bar', 'serv44', (($this->usuario_model->get($this->session->get('id'), 'serv44', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv44']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Entrenadores', 'serv45', (($this->usuario_model->get($this->session->get('id'), 'serv45', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv45']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Otros', 'serv46', (($this->usuario_model->get($this->session->get('id'), 'serv46', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['serv46']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['text', 'Otro, ¿Cuál?', 'otrostxt', (($this->usuario_model->get($this->session->get('id'), 'otrostxt', 'ret_frm_deporte', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otrostxt', 'ret_frm_deporte', 'clave'):(($this->session->getFlashdata('otrostxt'))?$this->session->getFlashdata('otrostxt'):'')), '0', '500', false, false, 'Otro, ¿Cuál?', '', 'min_length[0]|max_length[500]','4'],
												['hr'],
												['number', 'No. de personas que imparten la capacitación en los planteles', 'nopersonas', (($this->usuario_model->get($this->session->get('id'), 'nopersonas', 'ret_frm_deporte', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'nopersonas', 'ret_frm_deporte', 'clave'):((isset($valueFlashdata['nopersonas']))?$valueFlashdata['nopersonas']:'')), '1', '9999999999', true, false, 'No. de personas que imparten la capacitación en los planteles', '', 'required|min_length[1]|max_length[10]|numeric'],
												['bar', 'Tipos de Caza', 'bullseye', '', '', '', '', '', ''],
												['texto', 'Seleccione que tipo de aves acuáticas que se pueden cazar en el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Pato charreteras', 'caza01', (($this->usuario_model->get($this->session->get('id'), 'caza01', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza01']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato golondrino', 'caza02', (($this->usuario_model->get($this->session->get('id'), 'caza02', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza02']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato chalcuan', 'caza03', (($this->usuario_model->get($this->session->get('id'), 'caza03', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza03']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato cuaresmeño', 'caza04', (($this->usuario_model->get($this->session->get('id'), 'caza04', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza04']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cercetas listas verdes', 'caza05', (($this->usuario_model->get($this->session->get('id'), 'caza05', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza05']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cerceta café', 'caza06', (($this->usuario_model->get($this->session->get('id'), 'caza06', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza06']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato triguero', 'caza07', (($this->usuario_model->get($this->session->get('id'), 'caza07', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza07']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cerceta alas azules', 'caza08', (($this->usuario_model->get($this->session->get('id'), 'caza08', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza08']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato cabeza roja', 'caza09', (($this->usuario_model->get($this->session->get('id'), 'caza09', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza09']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato boludo prieto', 'caza10', (($this->usuario_model->get($this->session->get('id'), 'caza10', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza10']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato boludo grande', 'caza11', (($this->usuario_model->get($this->session->get('id'), 'caza11', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza11']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato coacoxtle', 'caza12', (($this->usuario_model->get($this->session->get('id'), 'caza12', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza12']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Branta negra o del pacífico', 'caza13', (($this->usuario_model->get($this->session->get('id'), 'caza13', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza13']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ganso canadiense	', 'caza14', (($this->usuario_model->get($this->session->get('id'), 'caza14', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza14']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato chillón jorobado', 'caza15', (($this->usuario_model->get($this->session->get('id'), 'caza15', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza15']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato chillón ojos dorados', 'caza16', (($this->usuario_model->get($this->session->get('id'), 'caza16', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza16']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ganso nevado o ansar azul', 'caza17', (($this->usuario_model->get($this->session->get('id'), 'caza17', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza17']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ganso ross', 'caza18', (($this->usuario_model->get($this->session->get('id'), 'caza18', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza18']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato pichichi', 'caza19', (($this->usuario_model->get($this->session->get('id'), 'caza19', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza19']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato phichihuila', 'caza20', (($this->usuario_model->get($this->session->get('id'), 'caza20', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza20']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Gallaereta', 'caza21', (($this->usuario_model->get($this->session->get('id'), 'caza21', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza21']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Grulla gris', 'caza22', (($this->usuario_model->get($this->session->get('id'), 'caza22', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza22']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Mergo caperuza', 'caza23', (($this->usuario_model->get($this->session->get('id'), 'caza23', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza23']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Negreta alas blancas', 'caza24', (($this->usuario_model->get($this->session->get('id'), 'caza24', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza24']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Negreta de merejada', 'caza25', (($this->usuario_model->get($this->session->get('id'), 'caza25', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza25']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Mergo americano', 'caza26', (($this->usuario_model->get($this->session->get('id'), 'caza26', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza26']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Mergo copetón', 'caza27', (($this->usuario_model->get($this->session->get('id'), 'caza27', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza27']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pato tepalcate', 'caza28', (($this->usuario_model->get($this->session->get('id'), 'caza28', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza28']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['texto', 'Seleccione que tipo de palomas que se pueden cazar en el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Paloma de collar', 'caza29', (($this->usuario_model->get($this->session->get('id'), 'caza29', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza29']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Paloma morada', 'caza30', (($this->usuario_model->get($this->session->get('id'), 'caza30', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza30']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Paloma montañera', 'caza31', (($this->usuario_model->get($this->session->get('id'), 'caza31', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza31']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Paloma arroyera o suelera', 'caza32', (($this->usuario_model->get($this->session->get('id'), 'caza32', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza32']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['texto', 'Seleccione que tipo de palomas que se pueden cazar en el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Tordo charretero ganga', 'caza33', (($this->usuario_model->get($this->session->get('id'), 'caza33', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza33']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Codorniz de california', 'caza34', (($this->usuario_model->get($this->session->get('id'), 'caza34', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza34']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Codorniz de douglas', 'caza35', (($this->usuario_model->get($this->session->get('id'), 'caza35', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza35']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Codorniz de gambel', 'caza36', (($this->usuario_model->get($this->session->get('id'), 'caza36', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza36']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Codorniz de yucatán', 'caza37', (($this->usuario_model->get($this->session->get('id'), 'caza37', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza37']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Codorniz enmascarada o común', 'caza38', (($this->usuario_model->get($this->session->get('id'), 'caza38', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza38']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Codorniz moctezuma o pinta', 'caza39', (($this->usuario_model->get($this->session->get('id'), 'caza39', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza39']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Agachona', 'caza40', (($this->usuario_model->get($this->session->get('id'), 'caza40', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza40']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Agrarista o tordo negro', 'caza41', (($this->usuario_model->get($this->session->get('id'), 'caza41', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza41']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Chachalaca', 'caza42', (($this->usuario_model->get($this->session->get('id'), 'caza42', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza42']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Codorniz listada', 'caza43', (($this->usuario_model->get($this->session->get('id'), 'caza43', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza43']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Zanate cola de bote', 'caza44', (($this->usuario_model->get($this->session->get('id'), 'caza44', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza44']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Estornino', 'caza45', (($this->usuario_model->get($this->session->get('id'), 'caza45', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza45']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Chanate cabeza amarilla', 'caza46', (($this->usuario_model->get($this->session->get('id'), 'caza46', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza46']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['texto', 'Seleccione que tipo de pequeños mamíferos que se pueden cazar en el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Tepezcuintle', 'caza47', (($this->usuario_model->get($this->session->get('id'), 'caza47', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza47']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla de harris', 'caza48', (($this->usuario_model->get($this->session->get('id'), 'caza48', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza48']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Agutio guaqueque', 'caza49', (($this->usuario_model->get($this->session->get('id'), 'caza49', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza49']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Armadillo de nueve cintas', 'caza50', (($this->usuario_model->get($this->session->get('id'), 'caza50', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza50']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tlacuache', 'caza51', (($this->usuario_model->get($this->session->get('id'), 'caza51', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza51']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Coyote', 'caza52', (($this->usuario_model->get($this->session->get('id'), 'caza52', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza52']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Liebre cola negra', 'caza53', (($this->usuario_model->get($this->session->get('id'), 'caza53', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza53']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Liebre torda', 'caza54', (($this->usuario_model->get($this->session->get('id'), 'caza54', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza54']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tejón o coatí', 'caza55', (($this->usuario_model->get($this->session->get('id'), 'caza55', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza55']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Mapache', 'caza56', (($this->usuario_model->get($this->session->get('id'), 'caza56', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza56']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla collie	', 'caza57', (($this->usuario_model->get($this->session->get('id'), 'caza57', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza57']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla nayarita', 'caza58', (($this->usuario_model->get($this->session->get('id'), 'caza58', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza58']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla cola anallada', 'caza59', (($this->usuario_model->get($this->session->get('id'), 'caza59', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza59']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla mexicana', 'caza60', (($this->usuario_model->get($this->session->get('id'), 'caza60', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza60']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla moteada', 'caza61', (($this->usuario_model->get($this->session->get('id'), 'caza61', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza61']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla de las rocas', 'caza62', (($this->usuario_model->get($this->session->get('id'), 'caza62', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza62']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Ardilla gris', 'caza63', (($this->usuario_model->get($this->session->get('id'), 'caza63', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza63']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Conejo audubon', 'caza64', (($this->usuario_model->get($this->session->get('id'), 'caza64', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza64']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Conejo del bosque tropical', 'caza65', (($this->usuario_model->get($this->session->get('id'), 'caza65', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza65']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Conejo mexicano', 'caza66', (($this->usuario_model->get($this->session->get('id'), 'caza66', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza66']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Conejo del este', 'caza67', (($this->usuario_model->get($this->session->get('id'), 'caza67', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza67']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['texto', 'Seleccione que tipo de animales especiales que se pueden cazar en el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Venado bura de sonora', 'caza68', (($this->usuario_model->get($this->session->get('id'), 'caza68', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza68']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Venado cola blanca texano	', 'caza69', (($this->usuario_model->get($this->session->get('id'), 'caza69', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza69']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Borrego de cimarrón', 'caza70', (($this->usuario_model->get($this->session->get('id'), 'caza70', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza70']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['texto', 'Seleccione que tipo de animales limitados que se pueden cazar en el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Becerrillo', 'caza71', (($this->usuario_model->get($this->session->get('id'), 'caza71', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza71']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Perdiz o tinamu', 'caza72', (($this->usuario_model->get($this->session->get('id'), 'caza72', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza72']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Gato montes', 'caza73', (($this->usuario_model->get($this->session->get('id'), 'caza73', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza73']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Venado temazate rojo', 'caza74', (($this->usuario_model->get($this->session->get('id'), 'caza74', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza74']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Venado temazate café', 'caza75', (($this->usuario_model->get($this->session->get('id'), 'caza75', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza75']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Guajolote silvestre', 'caza76', (($this->usuario_model->get($this->session->get('id'), 'caza76', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza76']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Pavo ocelado', 'caza77', (($this->usuario_model->get($this->session->get('id'), 'caza77', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza77']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Faisán de collar	', 'caza78', (($this->usuario_model->get($this->session->get('id'), 'caza78', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza78']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Puma', 'caza79', (($this->usuario_model->get($this->session->get('id'), 'caza79', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza79']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Venado bura', 'caza80', (($this->usuario_model->get($this->session->get('id'), 'caza80', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza80']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Venado cola blanca', 'caza81', (($this->usuario_model->get($this->session->get('id'), 'caza81', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza81']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Jabalí europeo', 'caza82', (($this->usuario_model->get($this->session->get('id'), 'caza82', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza82']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Jabalí de collar', 'caza83', (($this->usuario_model->get($this->session->get('id'), 'caza83', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza83']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Jabalí de labios blancos', 'caza84', (($this->usuario_model->get($this->session->get('id'), 'caza84', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza84']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Perdíz o tinamu real', 'caza85', (($this->usuario_model->get($this->session->get('id'), 'caza85', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza85']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Zorra gris', 'caza86', (($this->usuario_model->get($this->session->get('id'), 'caza86', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['caza86']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['bar', 'Formas de Pago', 'credit-card', '', '', '', '', '', ''],
												['checkbox', 'American Express', 'tc01', (($this->usuario_model->get($this->session->get('id'), 'tc01', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['tc01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Visa', 'tc02', (($this->usuario_model->get($this->session->get('id'), 'tc02', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['tc02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Master Card', 'tc03', (($this->usuario_model->get($this->session->get('id'), 'tc03', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['tc03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Efectivo', 'tc06', (($this->usuario_model->get($this->session->get('id'), 'tc06', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['tc06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cheque de Viajero', 'tc04', (($this->usuario_model->get($this->session->get('id'), 'tc04', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['tc04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Otra', 'tc05', (($this->usuario_model->get($this->session->get('id'), 'tc05', 'ret_frm_deporte', 'clave') == 1)?'checked':((isset($valueFlashdata['tc05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['text', 'Otra, ¿Cuál?', 'otra_tc', (($this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_deporte', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_deporte', 'clave'):(($this->session->getFlashdata('otra_tc'))?$this->session->getFlashdata('otra_tc'):'')), '0', '120', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[120]','3'],
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
