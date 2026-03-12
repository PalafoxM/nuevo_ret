<?php
namespace App\Controllers;

class Datos_tecnicos extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->usuario_model->get($this->session->get('id'), 'porcentaje_registro') < 20 || $this->usuario_model->get($this->session->get('id'), 'concluido') == 1)
				return redirect()->to('empresa-avance');

			$data['title']				=		'Registro Estatal de Turismo | Datos Técnicos';
			$data['head_js']			=	array(
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

			$valueFlashdata = [];
			if($this->session->getFlashdata('values'))
				$valueFlashdata = $this->session->getFlashdata('values');

			$data['nav']			=		'private/nav';
			$data['header']			=		'private/header';
			$data['main']			=		'private/form_template';
			$data['footer']			=		'public/footer';

			$data['controller']		=		'datos-tecnicos';
			$data['next_cont']		=		'datos-legales';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Datos Técnicos';
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_dt';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'datos-generales', '50', '', 'light', '', ''],
												['button', '<i class="bi-fast-forward icon-bar"></i> Siguiente', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Continuar', '', 'primary', '', '', false, false, ''],
												['bar', 'Personal y Organización', 'diagram-3', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '40', '1', '2', false, true, 'porcentaje_registro'],
												['number', '¿Cuántos empleados son fijos? Hombres.', 'fijos_h', (($this->usuario_model->get($this->session->get('id'), 'fijos_h') != NULL)?$this->usuario_model->get($this->session->get('id'), 'fijos_h'):((isset($valueFlashdata['fijos_h']))?$valueFlashdata['fijos_h']:'')), '0', '9999', true, false, 'Hombres', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['number', '¿Cuántos empleados son fijos? Mujeres.', 'fijos_m', (($this->usuario_model->get($this->session->get('id'), 'fijos_m') != NULL)?$this->usuario_model->get($this->session->get('id'), 'fijos_m'):((isset($valueFlashdata['fijos_m']))?$valueFlashdata['fijos_m']:'')), '0', '9999', true, false, 'Mujeres', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['number', '¿Cuántos empleados son temporales? Hombres.', 'tempo_h', (($this->usuario_model->get($this->session->get('id'), 'tempo_h') != NULL)?$this->usuario_model->get($this->session->get('id'), 'tempo_h'):((isset($valueFlashdata['tempo_h']))?$valueFlashdata['tempo_h']:'')), '0', '9999', true, false, 'Hombres', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['number', '¿Cuántos empleados son temporales? Mujeres.', 'tempo_m', (($this->usuario_model->get($this->session->get('id'), 'tempo_m') != NULL)?$this->usuario_model->get($this->session->get('id'), 'tempo_m'):((isset($valueFlashdata['tempo_m']))?$valueFlashdata['tempo_m']:'')), '0', '9999', true, false, 'Mujeres', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['number', '¿Cuántos de ellos con discapacidad? Hombres.', 'disca_h', (($this->usuario_model->get($this->session->get('id'), 'disca_h') != NULL)?$this->usuario_model->get($this->session->get('id'), 'disca_h'):((isset($valueFlashdata['disca_h']))?$valueFlashdata['disca_h']:'')), '0', '9999', true, false, 'Hombres', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['number', '¿Cuántos de ellos con discapacidad? Mujeres.', 'disca_m', (($this->usuario_model->get($this->session->get('id'), 'disca_m') != NULL)?$this->usuario_model->get($this->session->get('id'), 'disca_m'):((isset($valueFlashdata['disca_m']))?$valueFlashdata['disca_m']:'')), '0', '9999', true, false, 'Mujeres', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['hr'],
												['select', '¿Capacitación a sus empleados?', 'capacita', (($this->usuario_model->get($this->session->get('id'), 'capacita') != NULL)?$this->usuario_model->get($this->session->get('id'), 'capacita'):((isset($valueFlashdata['capacita']))?$valueFlashdata['capacita']:'')), '', '', true, false, '', [
																																['value_id' => '1', 'value_name' => 'SI'],
																																['value_id' => '0', 'value_name' => 'NO'],
																															], 'required', '6'],
												['select', '¿Certificados Médicos de sus empleados?', 'cert_med', (($this->usuario_model->get($this->session->get('id'), 'cert_med') != NULL)?$this->usuario_model->get($this->session->get('id'), 'cert_med'):((isset($valueFlashdata['cert_med']))?$valueFlashdata['cert_med']:'')), '', '', true, false, '', [
																																['value_id' => '1', 'value_name' => 'SI'],
																																['value_id' => '0', 'value_name' => 'NO'],
																															], 'required', '6'],
												['select', '¿Instalaciones para personas con discapacidad?', 'inst_disca', (($this->usuario_model->get($this->session->get('id'), 'inst_disca') != NULL)?$this->usuario_model->get($this->session->get('id'), 'inst_disca'):((isset($valueFlashdata['inst_disca']))?$valueFlashdata['inst_disca']:'')), '', '', true, false, '', [
																																['value_id' => '1', 'value_name' => 'SI'],
																																['value_id' => '0', 'value_name' => 'NO'],
																															], 'required', '6'],
												['select', '¿Tienen formación para brindar un trato inclusivo a personas LGBTTTIQ+?', 'lgbttit', (($this->usuario_model->get($this->session->get('id'), 'lgbttit') != NULL)?$this->usuario_model->get($this->session->get('id'), 'lgbttit'):((isset($valueFlashdata['lgbttit']))?$valueFlashdata['lgbttit']:'')), '', '', true, false, '', [
																																['value_id' => '1', 'value_name' => 'SI'],
																																['value_id' => '0', 'value_name' => 'NO'],
																															], 'required', '6'],
												['hr'],
												['select', '¿Es un espacio Pet Friendly?', 'pet_friendly', (($this->usuario_model->get($this->session->get('id'), 'pet_friendly') != NULL)?$this->usuario_model->get($this->session->get('id'), 'pet_friendly'):((isset($valueFlashdata['pet_friendly']))?$valueFlashdata['pet_friendly']:'')), '', '', true, false, '', [
																																['value_id' => '1', 'value_name' => 'SI'],
																																['value_id' => '0', 'value_name' => 'NO'],
																															], 'required', '6'],
												['hr'],
												['select', 'Tipo de Inversión', 'inversion', (($this->usuario_model->get($this->session->get('id'), 'inversion'))?$this->usuario_model->get($this->session->get('id'), 'inversion'):((isset($valueFlashdata['inversion']))?$valueFlashdata['inversion']:'')), '', '', true, false, '', [
																																['value_id' => 'Nacional', 'value_name' => 'NACIONAL'],
																																['value_id' => 'Extranjera', 'value_name' => 'EXTRANJERA'],
																																['value_id' => 'Ambas', 'value_name' => 'AMBAS'],
																															], 'required', '6'],
												['date', 'Fecha de Inicio de Operaciones', 'inicio_opera', (($this->usuario_model->get($this->session->get('id'), 'inicio_opera'))?$this->usuario_model->get($this->session->get('id'), 'inicio_opera'):((isset($valueFlashdata['inicio_opera']))?$valueFlashdata['inicio_opera']:'')), '', '', true, false, 'dd/mm/aaaa', '', 'required|valid_date[Y-m-d]', '6'],
												['select', 'Tipo de Organización', 'organizacion', (($this->usuario_model->get($this->session->get('id'), 'organizacion'))?$this->usuario_model->get($this->session->get('id'), 'organizacion'):((isset($valueFlashdata['organizacion']))?$valueFlashdata['organizacion']:'')), '', '', true, false, '', [
																																['value_id' => 'Independiente', 'value_name' => 'INDEPENDIENTE'],
																																['value_id' => 'Cadena Local', 'value_name' => 'CADENA LOCAL'],
																																['value_id' => 'Cadena Regional', 'value_name' => 'CADENA REGIONAL'],
																																['value_id' => 'Cadena Nacional', 'value_name' => 'CADENA NACIONAL'],
																																['value_id' => 'Cadena Transnacional', 'value_name' => 'CADENA TRANSNACIONAL'],
																															], 'required', '6'],
												['bar', 'Tipo de Mercado', 'people', '', '', '', '', '', 'Elija al menos una opción.'],
												['checkbox', 'Local', 'local', (((($this->usuario_model->get($this->session->get('id'), 'local'))?$this->usuario_model->get($this->session->get('id'), 'local'):((isset($valueFlashdata['local']))?$valueFlashdata['local']:'')) == 1)?'checked':''), '', '', false, false, '', '', '', '6'],
												['checkbox', 'Regional', 'regional', (((($this->usuario_model->get($this->session->get('id'), 'regional'))?$this->usuario_model->get($this->session->get('id'), 'regional'):((isset($valueFlashdata['regional']))?$valueFlashdata['regional']:'')) == 1)?'checked':''), '', '', false, false, '', '', '', '6'],
												['checkbox', 'Nacional', 'nacional', (((($this->usuario_model->get($this->session->get('id'), 'nacional'))?$this->usuario_model->get($this->session->get('id'), 'nacional'):((isset($valueFlashdata['nacional']))?$valueFlashdata['nacional']:'')) == 1)?'checked':''), '', '', false, false, '', '', '', '6'],
												['checkbox', 'Internacional', 'internacional', (((($this->usuario_model->get($this->session->get('id'), 'internacional'))?$this->usuario_model->get($this->session->get('id'), 'internacional'):((isset($valueFlashdata['internacional']))?$valueFlashdata['internacional']:'')) == 1)?'checked':''), '', '', false, false, '', '', '', '6'],
												['bar', 'Cámaras y Asociaciones', 'union', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['text', '¿A qué cadena pertence?', 'cadenaper', (($this->usuario_model->get($this->session->get('id'), 'cadenaper'))?$this->usuario_model->get($this->session->get('id'), 'cadenaper'):((isset($valueFlashdata['cadenaper']))?$valueFlashdata['cadenaper']:'')), '0', '150', false, false, 'Cámaras o Asociaciones Turísticas', '', 'max_length[150]'],
												['hr'],
												['button', 'Guardar y Continuar', '', 'primary', '', '', false, false, ''],
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