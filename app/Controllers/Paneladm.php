<?php
namespace App\Controllers;
require_once APPPATH."Libraries/vendor/autoload.php";
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Paneladm extends BaseController {

		public function index()
		{
			return redirect()->to('paneladm/giros');
		}

    	public function giros()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$data = [
        			'main'			=>		'panelret/section/adm_giros',
        			'footer_script'	=>		['user_list'],
            		'formTitle' 	=> 		'Todos los Giros',
            		'title' 		=> 		'GIROS',
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'giros' 		=> 		$this->admin_model->get_data('vw_usr_datos', 'g_giro as giro, COUNT(visible) AS activos', 
            																											['visible'	=>	1, 
            																											'g_giro <>'  => ''], true, ['g_giro'], 'g_giro ASC')
        			];

	        return view('panelret/template', $data);
    	}

    	public function hoy()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'hoy');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'hoy',
        			'header_bar'	=>		['title' 	=> 'REGISTROS AL DÍA DE HOY.', 
        									'detail' 	=> 'Estos son registros recientes durante el día de hoy, de igual manera, haz el seguimiento al PST.', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#ff8200'],
        			'table_tag'		=>		['CLAVE RET', 'GIRO TURÍSTICO', 'NOMBRE COMERCIAL', 'CORREO', 'MUNICIPIO', 'REGISTRO'],
        			'table_value'	=>		['clave', 'giro_subrubro', 'nombre_comercial', 'correo', 'municipio_nombre', 'dg_fecha_registro_alt'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										['registrado'],[],[],[],[],[]
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[],[],[],[],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Reestablecer Contraseña', 'url' => BASE_URL.'paneladm/accion/resetpass/', 'icon' => 'key', 'class' => 'info', 'confirm' => 'El proceso reestablecerá la contraseña y enviará los nuevos accesos por correo electrónico.'],
        										['tag' => 'Eliminar Registro', 'url' => BASE_URL.'paneladm/accion/eliminar/', 'icon' => 'trash', 'class' => 'danger', 'confirm' => 'Al eliminar registro(s) los cambios son irreversibles. \n\n ¿Estás completamente seguro en ELIMINAR este registro?'],
        									],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, CONCAT_WS("<br>", g_giro, subrubro_descripcion) as giro_subrubro, correo, visible, concluido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos", renovar, aprobado, g_giro, nombre_comercial, razon_social, municipio_nombre, dg_fecha_registro_alt, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['visible'	=>	1, 
            																					'fecha'		=>	date('Y-m-d')], true, [], 'g_giro ASC', '', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function registrados()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'registrados');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'registrados',
        			'header_bar'	=>		['title' 	=> 'REGISTROS EN PERIODO DE TRÁMITE (7 días).', 
        									'detail' 	=> 'No olvides dar seguimiento al PST para finalizar su trámite.', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#ff8200'],
        			'table_tag'		=>		['CLAVE RET', 'GIRO TURÍSTICO', 'NOMBRE COMERCIAL', 'RAZÓN SOCIAL', 'MUNICIPIO', 'REGISTRO'],
        			'table_value'	=>		['clave', 'giro_subrubro', 'nombre_comercial', 'razon_social', 'municipio_nombre', 'dg_fecha_registro_alt'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										['registrado'],[],[],[],[],[]
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[],[],[],[],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Reestablecer Contraseña', 'url' => BASE_URL.'paneladm/accion/resetpass/', 'icon' => 'key', 'class' => 'info', 'confirm' => 'El proceso reestablecerá la contraseña y enviará los nuevos accesos por correo electrónico.'],
        										['tag' => 'Eliminar Registro', 'url' => BASE_URL.'paneladm/accion/eliminar/', 'icon' => 'trash', 'class' => 'danger', 'confirm' => 'Al eliminar registro(s) los cambios son irreversibles. \n\n ¿Estás completamente seguro en ELIMINAR este registro?'],
        									],
        			'button00'		=>		['tag' 		=> 'Exportar a Excel', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/periodo7', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#336633'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, CONCAT_WS("<br>", g_giro, subrubro_descripcion) as giro_subrubro, visible, concluido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos", renovar, aprobado, g_giro, nombre_comercial, razon_social, municipio_nombre, dg_fecha_registro_alt, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['visible'	=>	1, 
            																					'concluido'	=>	0, 
            																					'aprobado'	=>	0], 
            															true, [], 'giro ASC', 'fecha_registro BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function pendientes()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'pendientes');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'pendientes',
        			'header_bar'	=>		['title' 	=> 'REGISTROS INCOMPLETOS.', 
        									'detail' 	=> 'Por proceso, debes ponerte en contacto con el PST para finalizar su trámite o bien, elimina el registro.', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#dd0303'],
        			'table_tag'		=>		['CLAVE RET', 'GIRO TURÍSTICO', 'NOMBRE COMERCIAL', 'CONTACTO', 'MUNICIPIO', 'REGISTRO'],
        			'table_value'	=>		['clave', 'giro_subrubro', 'nombre_comercial', 'contacto', 'municipio_nombre', 'dg_fecha_registro_alt'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										['pendiente'],[],[],[],[],[]
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[],[],[],[],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Reestablecer Contraseña', 'url' => BASE_URL.'paneladm/accion/resetpass/', 'icon' => 'key', 'class' => 'info', 'confirm' => 'El proceso reestablecerá la contraseña y enviará los nuevos accesos por correo electrónico.'],
        										['tag' => 'Eliminar Registro', 'url' => BASE_URL.'paneladm/accion/eliminar/', 'icon' => 'trash', 'class' => 'danger', 'confirm' => 'Al eliminar registro(s) los cambios son irreversibles. \n\n ¿Estás completamente seguro en ELIMINAR este registro?'],
        									],
        			'button00'		=>		['tag' 		=> 'Exportar a Excel', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/pendientes', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#336633'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, CONCAT_WS("<br>", g_giro, subrubro_descripcion) as giro_subrubro, visible, concluido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos", renovar, aprobado, g_giro, contacto, nombre_comercial, razon_social, municipio_nombre, dg_fecha_registro_alt, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['visible'		=>	1, 
            																					'concluido'		=>	0, 
            																					'aprobado'		=>	0, 
            																					'giro <>'		=>	0, 
            																					'municipio <>'	=>	0], true, [], 'giro ASC', '', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function renovaciones()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'renovaciones');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'renovaciones',
        			'header_bar'	=>		['title' 	=> 'INSTRUCCIONES DEL PROCESO DE RENOVACIÓN: <br><br>', 
        									'detail' 	=> '1. Enviar el registro a <b>RENOVACIONES</b>. En automático, el PST recibirá su acceso reestablecido por email. <br>2. Pedirle al PST que actualice toda su información y finalice su trámite de renovación presionando el botón <b>ENVIAR A VALIDACIÓN</b>. <br>3. Una vez que el PST complete su registro, verás reflejado el registro en la sección <b>CONCLUIDOS</b>. <br>', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#40a9ea'],
        			'table_tag'		=>		['CLAVE RET', 'GIRO TURÍSTICO', 'NOMBRE COMERCIAL', 'CORREO', 'MUNICIPIO', 'FECHA DE RENOVACIÓN'],
        			'table_value'	=>		['clave', 'giro_subrubro', 'nombre_comercial', 'correo', 'municipio_nombre', 'dg_fecha_registro_alt'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										['renovacion'],[],[],[],[],[]
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[],[],[],[],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Reestablecer Contraseña', 'url' => BASE_URL.'paneladm/accion/resetpass/', 'icon' => 'key', 'class' => 'info', 'confirm' => 'El proceso reestablecerá la contraseña y enviará los nuevos accesos por correo electrónico.'],
        										['tag' => 'Eliminar Registro', 'url' => BASE_URL.'paneladm/accion/eliminar/', 'icon' => 'trash', 'class' => 'danger', 'confirm' => 'Al eliminar registro(s) los cambios son irreversibles. \n\n ¿Estás completamente seguro en ELIMINAR este registro?'],
        									],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, CONCAT_WS("<br>", g_giro, subrubro_descripcion) as giro_subrubro, visible, concluido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos", renovar, aprobado, g_giro, contacto, nombre_comercial, correo, fecha_renovacion_alt, razon_social, municipio_nombre, dg_fecha_registro_alt, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['visible'		=>	1, 
            																					'renovar'		=>	1, 
            																					'giro <>'		=>	0, 
            																					'municipio <>'	=>	0], true, [], 'giro ASC', '', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function concluidos()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'concluidos');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'concluidos',
        			'header_bar'	=>		['title' 	=> 'REGISTROS CONCLUIDOS.', 
        									'detail' 	=> 'Estos son tus registros por <b>APROBAR</b>, haz el seguimiento para la emisión de Cédula RET.', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#0066ff'],
        			'table_tag'		=>		['CLAVE RET', 'GIRO TURÍSTICO', 'NOMBRE COMERCIAL', 'CORREO', 'MUNICIPIO', 'REGISTRO'],
        			'table_value'	=>		['clave', 'giro_subrubro', 'nombre_comercial', 'correo', 'municipio_nombre', 'dg_fecha_registro_alt'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										['concluido'],[],[],[],[],[],[]
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[],[],[],[],[],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Aprobar Registro', 'url' => BASE_URL.'paneladm/accion/aprobar/', 'icon' => 'check-circle', 'class' => 'success', 'confirm' => 'El registro del Prestado de Servicio Turístico seleccionado, ha sido aprobado y listo para la emisión de Cédula RET. A su vez, le ha sido notificado al PST via correo electrónico que el proporcionó.'],
        									],
        			'button00'		=>		['tag' 		=> 'Exportar a Excel', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/concluidos', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#336633'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, CONCAT_WS("<br>", g_giro, subrubro_descripcion) as giro_subrubro, visible, concluido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos", renovar, aprobado, g_giro, contacto, nombre_comercial, autoclasificacion, correo, razon_social, municipio_nombre, dg_fecha_registro_alt, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['visible'		=>	1, 
            																					'concluido'		=>	1, 
            																					'aprobado'		=>	0, 
            																					'giro <>'		=>	0, 
            																					'municipio <>'	=>	0], true, [], 'giro ASC', '', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function aprobados()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'aprobados');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'aprobados',
        			'header_bar'	=>		['title' 	=> 'REGISTROS APROBADOS.', 
        									'detail' 	=> 'Tienen impacto y visualización en el sitio GTOMX, Consulta Ciudadana y App Visita Guanajuato.', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#0066ff'],
        			'table_tag'		=>		['CLAVE RET', 'CÉDULA', '¿ENVÍO DIGITAL?', 'GIRO TURÍSTICO / CATEGORIA - SUBRUBRO', 'NOMBRE COMERCIAL / CORREO / MUNICIPIO', 'INSCRIPCIÓN', 'VIGENCIA'],
        			'table_value'	=>		['clave', '_cedula_', '_envio_', 'giro_autoclasificacion', 'nombre_correo_mun', 'dg_fecha_registro_alt', 'fecha_vencimiento_alt'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										['aprobado'],[],[],[],[],[],[],[],[],[]
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[BASE_URL.'paneladm/cedula/descargar/', '_blank'],[],[],[],[],[],[],[],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Enviar Cédula', 'url' => BASE_URL.'paneladm/cedula/enviar/', 'icon' => 'envelope-o', 'class' => 'success', 'confirm' => '¿Deseas enviar la Cédula por correo electrónico?'],
        										['tag' => 'Renovar Trámite', 'url' => BASE_URL.'paneladm/accion/renovar/', 'icon' => 'refresh', 'class' => 'info', 'confirm' => 'Has determinado que el registro genere un proceso de renovación con fecha del día de hoy. \n\n ¿Estas seguro que deseas aplicarlo?'],
        										['tag' => 'Enviar a Vencidos', 'url' => BASE_URL.'paneladm/accion/baja/', 'icon' => 'arrow-circle-o-down', 'class' => 'danger', 'confirm' => 'Al actualizar el estatus VENCIDO de este registro, el cambio será aplicado de inmediato. Posteriormente, deberás tomar la decisión de eliminarlo desde la sección Vencidos. \n\n ¿Estás completamente seguro en dar de BAJA/VENCIDO este registro?'],
        									],
        			'button00'		=>		['tag' 		=> 'Exportar a Excel', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/aprobados', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#336633'],
        			'button01'		=>		['tag' 		=> 'App (Hospedaje)', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/apphospedaje', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#ff8200'],
        			'button02'		=>		['tag' 		=> 'App (Plataformas Digitales)', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/appdigital', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#ff8200'],
        			'button03'		=>		['tag' 		=> 'App (Restaurante)', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/apprestaurante', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#ff8200'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, notifica_aprobado, visible, aprobado, CONCAT_WS("<br>", g_giro, subrubro_descripcion) as giro_autoclasificacion, CONCAT_WS("<br>", nombre_comercial, email, municipio_nombre) as nombre_correo_mun, municipio_nombre, dg_fecha_registro_alt, fecha_renovacion_alt, DATE_FORMAT(DATE_ADD( dg_fecha_registro, INTERVAL 3 YEAR ), \'%d/%m/%Y %H:%i\') AS fecha_vencimiento_alt, concluido, correo, renovar, DATE_ADD( dg_fecha_registro, INTERVAL 3 YEAR ) AS "fecha_vencimiento", DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos", DATEDIFF(DATE_ADD( dg_fecha_registro, INTERVAL 3 YEAR), CURRENT_TIMESTAMP ) AS  "dias_vigentes"', ['visible'		=>	1, 
												'concluido'		=>	1, 
												'aprobado'		=>	1, 
												'giro <>'		=>	0, 
												'municipio <>'	=>	0], true, [], 'giro ASC', '', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function vencidos()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'vencidos');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'vencidos',
        			'header_bar'	=>		['title' 	=> 'REGISTROS VENCIDOS.', 
        									'detail' 	=> 'Registros que han superado los 2 años que se vigencia para cédula y han sido de dados de baja.', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#df0a15'],
        			'table_tag'		=>		['CLAVE RET', 'INFORMACIÓN'],
        			'table_value'	=>		['clave', 'informacion'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										[],['vencido'],
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Eliminar Registro', 'url' => BASE_URL.'paneladm/accion/eliminar/', 'icon' => 'trash', 'class' => 'danger', 'confirm' => 'Al eliminar registro(s) los cambios son irreversibles. \n\n ¿Estás completamente seguro en ELIMINAR este registro?'],

        									],
        			'button00'		=>		['tag' 		=> 'Exportar a Excel', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/vencidos', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#336633'],
        			'button01'		=>		['tag' 		=> 'Eliminar Todos', 
        									'icon' 		=> 'trash', 
        									'url' 		=> BASE_URL.'paneladm/eliminar-todos', 
        									'target' 	=> '_self', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#df0a15',
        									'confirm'	=> 'Esta acción elimina permanentemente todos los registros vencidos, ¿deseas continuar?'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, visible, concluido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos", renovar, aprobado, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, 
            								CONCAT_WS("<br>", 
            									CONCAT("Fecha de Inscripción: ", fecha_registro_alt),
            									CONCAT("Giro Comercial: ", g_giro),
            									CONCAT("RFC: ", info_rfc),
            									CONCAT("Nombre Comercial: ", nombre_comercial),
            									CONCAT("Municipio: ", municipio_nombre), 
            									CONCAT("<span style=\'font-size: 11px; color: #ec0505\'> (Hace <strong>", DATEDIFF(CURRENT_TIMESTAMP, DATE_ADD( fecha, INTERVAL 3 YEAR)), "</strong> días) </span>")
            										) as informacion
            								', ['visible'		=>	0, 
												'concluido'		=>	0, 
												'aprobado'		=>	0, 
												'giro <>'		=>	0, 
												'municipio <>'	=>	0], true, [], 'giro ASC', '', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function todos()
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$this->session->setFlashdata('o_function', 'todos');
        	$data = [
        			'main'			=>		'panelret/section/list_template',
        			'o_function'	=>		'todos',
        			'header_bar'	=>		['title' 	=> 'TODOS LOS REGISTROS.', 
        									'detail' 	=> ' Estos son todos los registros hasta hoy '.date("d/m/Y").'.', 
        									'color' 	=> '#31708f', 
        									'bgcolor' 	=> '#d9edf7'],
        			'table_tag'		=>		['CLAVE RET', 'GIRO TURÍSTICO', 'NOMBRE COMERCIAL', 'REPRESENTANTE', 'MUNICIPIO', 'REGISTRO'],
        			'table_value'	=>		['clave', 'giro_subrubro', 'nombre_comercial', 'representante', 'municipio_nombre', 'dg_fecha_registro_alt'],
        			'table_id'		=>		'clave',
        			'table_label'	=>		[
        										['registrado', 'pendiente', 'concluido', 'aprobado', 'renovacion', 'vencido'],[],[],[],[],[],
        									],
        			'table_url'		=>		[
        										[BASE_URL.'paneladm/ver/', '_self'],[],[],[],[],[]
        									],
        			'table_action'	=>		[
        										['tag' => 'Editar Registro', 'url' => BASE_URL.'paneladm/editar/', 'icon' => 'pencil', 'class' => 'success', 'confirm' => '¿Deseas editar el registro?'],
        										['tag' => 'Renovar Trámite', 'url' => BASE_URL.'paneladm/accion/renovar/', 'icon' => 'refresh', 'class' => 'info', 'confirm' => 'Has determinado que el registro genere un proceso de renovación con fecha del día de hoy. \n\n ¿Estas seguro que deseas aplicarlo?'],
												['tag' => 'Reestablecer Contraseña', 'url' => BASE_URL.'paneladm/accion/resetpass/', 'icon' => 'key', 'class' => 'info', 'confirm' => 'El proceso reestablecerá la contraseña y enviará los nuevos accesos por correo electrónico.'],
        										['tag' => 'Enviar a Vencidos', 'url' => BASE_URL.'paneladm/accion/baja/', 'icon' => 'arrow-circle-o-down', 'class' => 'danger', 'confirm' => 'Al actualizar el estatus VENCIDO de este registro, el cambio será aplicado de inmediato. Posteriormente, deberás tomar la decisión de eliminarlo desde la sección Vencidos. \n\n ¿Estás completamente seguro en dar de BAJA/VENCIDO este registro?'],
        										['tag' => 'Eliminar Registro', 'url' => BASE_URL.'paneladm/accion/eliminar/', 'icon' => 'trash', 'class' => 'danger', 'confirm' => 'Al eliminar registro(s) los cambios son irreversibles. \n\n ¿Estás completamente seguro en ELIMINAR este registro?'],
        									],
        			'button00'		=>		['tag' 		=> 'Exportar a Excel', 
        									'icon' 		=> 'file-excel-o', 
        									'url' 		=> BASE_URL.'paneladm/reportexls/todos', 
        									'target' 	=> '_blank', 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#336633'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'lista'			=> 		$this->admin_model->get_data('vw_usr_datos', 'clave, CONCAT_WS("<br>", g_giro, subrubro_descripcion) as giro_subrubro, g_giro, nombre_comercial, representante, municipio_nombre, dg_fecha_registro_alt, concluido, visible, renovar, aprobado, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['giro <>'		=>	0, 
																								'municipio <>'	=>	0], true, [], 'giro ASC', '', true)
        			];

	        return view('panelret/template', $data);
    	}

    	public function ver($_clave)
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$o_function = $this->session->getFlashdata('o_function');
        	$data = [
        			'main'			=>		'panelret/section/detail_template',
        			'o_function'	=>		$o_function,
        			'header_bar'	=>		['title' 	=> 'CONTENIDO DE INFORMACIÓN DEL TRÁMITE:', 
        									'detail' 	=> $_clave, 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#000f9f'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
            		'detalle'		=> 		$this->admin_model->get_data('vw_usr_datos', '*, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['clave'		=>	$_clave], true, [], '', '', true),
            		'giro'			=>		$this->admin_model->get_data('vw_usr_datos', 'giro', ['clave'		=>	$_clave], false, [], '', '', false)
        			];

        	$detalle 	= $data['detalle'];
        	if(count($detalle) == 0)
        	{
        		$this->session->setFlashdata('error', 'No existe el registro solicitado.');
        		return redirect()->to('paneladm/'.$o_function);
        	}

        	switch($giro	=	$data['giro'])
        	{
        		case 1:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_hospedaje', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 2:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_agencia', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 3:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_guia', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 4:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_promotores', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 5:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_restaurantes', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 6:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_golf', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 7:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_arte', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 8:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_educativas', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 9:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_arrendadora', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 10:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_parques', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 11:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_auxturistico', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 12:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_balnearios', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 13:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_capacitacion', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 14:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_deporte', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 15:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_spa', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 16:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_recinto', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        		case 17:
        			$data 	=	array_merge($data, [
        											'giro_data'		=>		$this->admin_model->get_data('ret_frm_hospedaje-digitales', '*', ['clave'	=>	$_clave], true, [], '', '', true)
        											]);
        		break;
        	}
        	


	        return view('panelret/template', $data);
    	}

    	public function editar($_clave)
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

        	$o_function = $this->session->getFlashdata('o_function');
        	$data = [
        			'main'			=>		'panelret/section/edit_template',
        			'o_function'	=>		$o_function,
        			'header_bar'	=>		['title' 	=> 'EDICIÓN DE INFORMACIÓN DEL TRÁMITE:', 
        									'detail' 	=> $_clave, 
        									'color' 	=> '#fff', 
        									'bgcolor' 	=> '#fd881c'],
        			'footer_script'	=>		['user_list'],
    				'name'			=>		ucfirst($this->session->get('name_adm')),
    				'email'			=>		$this->session->get('email_adm'),
    				'municipios'	=>		$this->web_model->get_municipios(),
            		'detalle'		=> 		$this->admin_model->get_data('vw_usr_datos', '*, DATEDIFF(CURRENT_TIMESTAMP, fecha_renovacion) AS dias_vencido, DATEDIFF(CURRENT_TIMESTAMP, dg_fecha_registro) AS "dias_transcurridos"', ['clave'		=>	$_clave], true, [], '', '', true)
        			];

        	$detalle = $data['detalle'];
        	if(count($detalle) == 0)
        	{
        		$this->session->setFlashdata('error', 'No existe el registro solicitado.');
        		return redirect()->to('paneladm/'.$o_function);
        	}

	        return view('panelret/template', $data);
    	}

    	public function guardar($_clave)
		{
			$fecha_registro		=	((is_null($this->request->getVar('renovar_registro')))?$this->request->getVar('fecha_registro'):date("Y-m-d H:i:s"));
			$idgiro_subrubro	=	$this->request->getVar('idgiro_subrubro');
			$nombre_comercial	=	$this->request->getVar('nombre_comercial');
			$info_rfc			=	$this->request->getVar('info_rfc');
			$tipo_persona		=	$this->request->getVar('tipo_persona');
			$razon_social		=	$this->request->getVar('razon_social');
			$representante_moral=	$this->request->getVar('representante_moral');
			$municipio 			=	$this->request->getVar('municipio');
			$telefono			=	$this->request->getVar('telefono');
			$correo				=	$this->request->getVar('correo');
			$descripcion 		=	$this->request->getVar('descripcion');
			$calle				=	$this->request->getVar('calle');
			$numero				=	$this->request->getVar('numero');
			$interior			=	$this->request->getVar('interior');
			$colonia			=	$this->request->getVar('colonia');
			$cp					=	$this->request->getVar('cp');
			
			$files 				=	[
										['name' 	=>	'rfc', 'controller'		=>	'datos-legales'],
										['name' 	=>	'curp', 'controller'		=>	'datos-legales'],
										['name' 	=>	'ife', 'controller'		=>	'datos-legales'],
										['name' 	=>	'licencia_suelo', 'controller'		=>	'datos-legales'],
										['name' 	=>	'escritura_publica', 'controller'		=>	'datos-legales'],
										['name' 	=>	'acta_constitutiva', 'controller'		=>	'datos-legales'],
										['name' 	=>	'rfc_legal', 'controller'		=>	'datos-legales'],
										['name' 	=>	'domicilio', 'controller'		=>	'datos-legales'],
										['name' 	=>	'protocolo_higiene', 'controller'		=>	'datos-legales'],
										['name' 	=>	'carta_protesta', 'controller'		=>	'datos-legales'],
										['name' 	=>	'logo', 'controller'		=>	'imagenes'],
										['name' 	=>	'imagen1', 'controller'		=>	'imagenes'],
										['name' 	=>	'imagen2', 'controller'		=>	'imagenes'],
										['name' 	=>	'imagen3', 'controller'		=>	'imagenes'],
										['name' 	=>	'imagen_promocional', 'controller'		=>	'imagenes'],
									];

			$validate 			=	[
										'idgiro_subrubro'		=>		'required',
										'nombre_comercial'		=>		'required|min_length[3]|max_length[200]',
										'info_rfc'				=>		'required|min_length[9]|max_length[13]',
										'tipo_persona'			=>		'required',
										'razon_social'			=>		'required|min_length[3]|max_length[255]',
										'representante_moral'	=>		'required|min_length[0]|max_length[60]',
										'municipio'				=>		'required',
										'telefono'				=>		'required|min_length[3]|max_length[200]',
										'correo'				=>		'required|valid_email|min_length[6]|max_length[120]',
										'descripcion'			=>		'required',
										'calle'					=>		'required|min_length[3]|max_length[120]',
										'numero'				=>		'required|min_length[1]|max_length[10]',
										'interior'				=>		'min_length[0]|max_length[5]',
										'colonia'				=>		'required|min_length[3]|max_length[50]',
										'cp'					=>		'required|min_length[3]|max_length[10]',
										'rfc'					=>		'uploaded[rfc]|max_size[rfc,10240]|ext_in[rfc,pdf,jpeg,jpg,png]|mime_in[rfc,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'curp'					=>		'uploaded[curp]|max_size[curp,10240]|ext_in[curp,pdf,jpeg,jpg,png]|mime_in[curp,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'ife'					=>		'uploaded[ife]|max_size[ife,10240]|ext_in[ife,pdf,jpeg,jpg,png]|mime_in[ife,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'licencia_suelo'		=>		'uploaded[licencia_suelo]|max_size[licencia_suelo,10240]|ext_in[licencia_suelo,pdf,jpeg,jpg,png]|mime_in[licencia_suelo,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'escritura_publica'		=>		'uploaded[escritura_publica]|max_size[escritura_publica,10240]|ext_in[escritura_publica,pdf,jpeg,jpg,png]|mime_in[escritura_publica,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'acta_constitutiva'		=>		'uploaded[acta_constitutiva]|max_size[acta_constitutiva,10240]|ext_in[acta_constitutiva,pdf,jpeg,jpg,png]|mime_in[acta_constitutiva,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'rfc_legal'				=>		'uploaded[rfc_legal]|max_size[rfc_legal,10240]|ext_in[rfc_legal,pdf,jpeg,jpg,png]|mime_in[rfc_legal,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'domicilio'				=>		'uploaded[domicilio]|max_size[domicilio,10240]|ext_in[domicilio,pdf,jpeg,jpg,png]|mime_in[domicilio,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'protocolo_higiene'		=>		'uploaded[protocolo_higiene]|max_size[protocolo_higiene,10240]|ext_in[protocolo_higiene,pdf,jpeg,jpg,png]|mime_in[protocolo_higiene,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'carta_protesta'		=>		'uploaded[carta_protesta]|max_size[carta_protesta,10240]|ext_in[carta_protesta,pdf,jpeg,jpg,png]|mime_in[carta_protesta,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]',
										'logo'					=>		'uploaded[logo]|max_size[logo,10240]|ext_in[logo,jpeg,jpg,png]|mime_in[logo,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[logo,5000,5000]|is_image[logo]',
										'imagen1'				=>		'uploaded[imagen1]|max_size[imagen1,10240]|ext_in[imagen1,jpeg,jpg,png]|mime_in[imagen1,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen1,5000,5000]|is_image[imagen1]',
										'imagen2'				=>		'uploaded[imagen2]|max_size[imagen2,10240]|ext_in[imagen2,jpeg,jpg,png]|mime_in[imagen2,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen2,5000,5000]|is_image[imagen2]',
										'imagen3'				=>		'uploaded[imagen3]|max_size[imagen3,10240]|ext_in[imagen3,jpeg,jpg,png]|mime_in[imagen3,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen3,5000,5000]|is_image[imagen3]',
										'imagen_promocional'	=>		'uploaded[imagen_promocional]|max_size[imagen_promocional,10240]|ext_in[imagen_promocional,jpeg,jpg,png]|mime_in[imagen_promocional,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen_promocional,5000,5000]|is_image[imagen_promocional]',
									];
			
			foreach($files as $file)
			{
				$name 		=	$file['name'];

				$$name 		= 	$this->request->getFile($name);

				if(!($$name->isValid()))
				{
					unset($$name);
					unset($validate[$name]);
				}
			}

			$this->validation->setRules($validate);

			if (! $this->validate($validate))
			{

				$tipoMsj 	=	'error';
				$txtMsj		=	'Faltan campos oblgatorios, favor de verificar.';

				$this->session->setFlashdata($tipoMsj, $txtMsj);

				return redirect()->to('paneladm/editar/'.$_clave);
			}
			else
			{
				$dbarim = [];

				foreach($files as $file)
				{
					$name 			=	$file['name'];
					$controller 	=	$file['controller'];
					
					if(isset($$name))
						if (! $$name->hasMoved()) 
						{
							$ruta 		=	'./'.$controller;
				            $filepath 	= 	$$name->store($ruta);

			            	$dbarim 	=	array_merge($dbarim, [$name	=>	$filepath]);
				        } 

				}

				$dg  = true;
				$usr = true;
				$arl = true;

				// Guardar en Datos Generales
				$dgdatos 	=	array(
										'idgiro_subrubro'		=>	$idgiro_subrubro,
										'fecha_registro'		=>	$fecha_registro,
										'nombre_comercial'		=>	$nombre_comercial,
										'info_rfc'				=>	$info_rfc,
										'tipo_persona'			=>	$tipo_persona,
										'razon_social'			=>	$razon_social,
										'representante_moral'	=>	$representante_moral,
										'municipio'				=>	$municipio,
										'telefono'				=>	$telefono,
										'correo'				=>	$correo,
										'descripcion'			=>	$descripcion,
										'calle'					=>	$calle,
										'numero'				=>	$numero,
										'interior'				=>	$interior,
										'colonia'				=>	$colonia,
										'cp'					=>	$cp,
									); //var_dump($dgdatos);die;

				$dg = $this->usuario_model->update_data($dgdatos, 'ret_datos_generales', 'clave', $_clave);

				// Guardar en Usuarios
				$usrdatos 	=	array(
										'fecha_registro'		=>	$fecha_registro,
										'fecha_renovacion'		=>	$fecha_registro,
										'email'					=>	$correo,
									);

				$usr = $this->usuario_model->update_data($usrdatos, 'ret_usr', 'id', $_clave);
				
				// Guardar en Archivos Legales
				if(count($dbarim) > 0)
					$arl = $this->usuario_model->update_data($dbarim, 'ret_archivo_legal', 'clave', $_clave);
				

				if(isset($dg) && isset($usr) && isset($arl))
				{
					$tipoMsj 	=	'success';
					$txtMsj		=	'Los cambios han sido guardados con éxito.';

					$this->session->setFlashdata($tipoMsj, $txtMsj);

					return redirect()->to('paneladm/ver/'.$_clave);
				}
				else
				{
					$tipoMsj 	=	'error';
					$txtMsj		=	'Faltan campos y/o archivos, favor de verificar.';

					$this->session->setFlashdata($tipoMsj, $txtMsj);

					return redirect()->to('paneladm/ver/'.$_clave);
				}
			}
	   	}

    	public function descargar($_userfile, $_clave)
    	{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');
			
		   	switch($_userfile)
		   	{
		   		case 'rfc':
		   			$field = 'a_rfc';
		   		break;
		   		case 'rfc_legal':
		   			$field = 'a_rfc_legal';
		   		break;
		   		case 'curp':
		   			$field = 'a_curp';
		   		break;
		   		case 'ife':
		   			$field = 'a_ife';
		   		break;
		   		case 'licencia_suelo':
		   			$field = 'a_licencia_suelo';
		   		break;
		   		case 'registro_patronal':
		   			$field = 'a_registro_patronal';
		   		break;
		   		case 'acta_constitutiva':
		   			$field = 'a_acta_constitutiva';
		   		break;
		   		case 'escritura_publica':
		   			$field = 'a_escritura_publica';
		   		break;
		   		case 'no_poder':
		   			$field = 'a_no_poder';
		   		break;
		   		case 'prot_civil':
		   			$field = 'a_prot_civil';
		   		break;
		   		case 'sec_salud':
		   			$field = 'a_sec_salud';
		   		break;
		   		case 'domicilio':
		   			$field = 'a_domicilio';
		   		break;
		   		case 'proveedor':
		   			$field = 'a_proveedor';
		   		break;
		   		case 'protocolo_higiene':
		   			$field = 'a_protocolo_higiene';
		   		break;
		   		case 'carta_protesta':
		   			$field = 'a_carta_protesta';
		   		break;
		   		case 'logo':
		   			$field = 'a_logo';
		   		break;
		   		case 'imagen1':
		   			$field = 'a_imagen1';
		   		break;
		   		case 'imagen2':
		   			$field = 'a_imagen2';
		   		break;
		   		case 'imagen3':
		   			$field = 'a_imagen3';
		   		break;
		   		case 'imagen4':
		   			$field = 'a_imagen4';
		   		break;
		   		case 'imagen5':
		   			$field = 'a_imagen5';
		   		break;
		   		case 'imagen6':
		   			$field = 'a_imagen6';
		   		break;
		   		case 'imagen_promocional':
		   			$field = 'a_imagen_promocional';
		   		break;
		   		default:
		   			$field = '';
		   	}

			if($field == '' || ! $file = $this->usuario_model->get($_clave, $field))
				return redirect()->to('paneladm');
			else
			{
				try{
					$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

					$ext 			= 	$fileInstance->guessExtension();
					
					return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($_clave.'_'.$_userfile.'.'.$ext);

				}
				catch( \Exception $e){
					return redirect()->to('paneladm');
				}

			}
		}

		public function enviar_observaciones()
		{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

		   	$this->validation       = \Config\Services::validation();

		   	$observaciones 	= 	$this->request->getVar('txtObservaciones');
		   	$clave 			= 	$this->request->getVar('clave');

			if (! $this->validate([
									'txtObservaciones'		=>	'required',
									]))
			{
				$tipoMsj 	=	'error';
				$txtMsj		=	'Su solicitud no fue procesada, favor de enviar un mensaje válido.';
	
	        	$this->session->setFlashdata($tipoMsj, $txtMsj);
				return redirect()->to('paneladm/ver/'.$clave);
			}
			else
			{
		        /* Genera email para envío de observaciones */
		        $mensaje    = '<img src="'.BASE_URL.'static/images/anterior_horizontal_logo_ret_altb_.png" /><br>
		        		<strong> Estimado Prestador de Servicio: </strong> <br><br> 

					Te informamos que tu trámite no ha sido aprobado por falta de documentación o sus documentos están incorrectos, el motivo es el siguiente: <br><br>'  

					.'<strong>' .$observaciones. '</strong>'.

					'<br><br><span><b>Inicia sesión en este enlace con tu usuario y contraseña:</b></span><br/>
			        <span><a href="'.BASE_URL.'ingresar" target="_blank">'.BASE_URL.'ingresar</a></span><br/><br/>
			        <br><br><span><b>Atiende las observaciones siguiendo el manual de usuario:</b></span><br/>
			        <span><a href="'.BASE_URL.'manual-ret" target="_blank">'.BASE_URL.'manual-ret</a></span><br/><br/>
			        Contarás con 3 días a partir de esta fecha para realizar las modificaciones solicitadas para concluir tu trámite. <br> 
					Cualquier duda o aclaración con respecto a tu trámite, favor de comunicarte al teléfono (472) 103 99 00 ext. 229 <br><br>
					<strong> ATENTAMENTE <br><br>
					Registro Estatal de Turismo <br>
					Secretaría de Turismo del Estado de Guanajuato </strong>';

		        send_email('Observaciones en el Trámite: '.$clave, $this->usuario_model->get($clave, 'email'), $mensaje, '');

				return redirect()->to('paneladm/accion/pendiente/'.$clave);
			}
		}

		public function accion($_action = '', $_clave = '')
		{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

			$return 	=	'lista';
			$o_function = $this->session->getFlashdata('o_function');
			switch($_action)
			{
				case 'resetpass':
					$pass   = password_generator();
					$this->admin_model->set_data('ret_usr', [
												'activo'			=>	1,
												'pass' 				=> 	password_hash($pass, PASSWORD_DEFAULT)
												], ['id'	=>	$_clave]);

			        /* Genera email para envío de acceso */
			        $mensaje    = '<div>
			                        <img src="'.BASE_URL.'static/images/anterior_horizontal_logo_ret_altb_.png" />
			                        <h2>Bienvenido al Registro Estatal de Turismo del Estado de Guanajuato</h2>
			                        <span>Le invitamos a acceder a la plataforma lo antes posible para completar su registro.</span><br/>
			                        <span><b><h3>Tiene un máximo de 7 días naturales para el registro.</h3></b></span>
			                        <span>Su acceso a la plataforma son los siguientes:</span><br/><br/>
			                        <span><b>Usuario:</b></span><br/>
			                        <span>'.$_clave.'</span><br/>
			                        <span><b>Contraseña:</b></span><br/>
			                        <span>'.$pass.'</span><br/><br/>
			                        <span><b>Inicia sesión en este enlace:</b></span><br/>
			                        <span><a href="'.BASE_URL.'ingresar" target="_blank">'.BASE_URL.'ingresar</a></span><br/><br/>
			                        <span>Recuerda, ¡te estaremos esperando!</span><br/><br/>
			                        <span><b>Cualquier duda comunicarse a la Secretaría de Turismo del Estado de Guanajuato al teléfono (472) 103 99 00 ext. 229 o al correo electrónico </b></span><a href="mailto:ret@guanajuato.gob.mx" target="_blank">ret@guanajuato.gob.mx</a><br/><br/>
			                    </div>';

			        send_email('Su contraseña ha sido reestablecida', $this->usuario_model->get($_clave, 'email'), $mensaje);

        			$tipoMsj 	=	'success';
					$txtMsj		=	'CONTRASEÑA REESTABLECIDA y enviada con exito al usuario con clave: '.$_clave.'.';

					$return 	=	'lista';
				break;
				case 'eliminar':
					$this->admin_model->delete_data($_clave);
					
					$tipoMsj 	=	'success';
					$txtMsj		=	'El registro con la clave '.$_clave.' ha sido ELIMINADO.';

					$return 	=	'lista';
				break;
				case 'pendiente':
					$this->admin_model->set_data('ret_datos_generales', [
												'visible'			=>	1,
												'concluido'			=>	0,
												'aprobado'			=>	0
												], ['clave'	=>	$_clave]);

					$this->admin_model->set_data('ret_usr', [
												'porcentaje_registro'			=>	10
												], ['id'	=>	$_clave]);

	    			$tipoMsj 	=	'success';
					$txtMsj		=	'Observaciones enviadas satisfactoriamente y registro '.$_clave.' enviado a PENDIENTES.';

					$return 	=	'vista';
				break;
				case 'aprobar':
					$this->admin_model->set_data('ret_datos_generales', [
												'renovar'			=>	0,
												'concluido'			=>	1,
												'aprobado'			=>	1,
												'notifica_aprobado'	=>	1,
												'cadena_aprobacion'	=>	string_generator(120)
												], ['clave'	=>	$_clave]);

					$this->admin_model->set_data('ret_usr', [
												'activo'			=>	0,
												], ['id'	=>	$_clave]);


					@chmod(WRITEPATH.'uploads/mpdf', 0777);
					@chmod(WRITEPATH.'uploads/mpdf/ttfontdata', 0777);

					$mpdf = new \Mpdf\Mpdf([
										'tempDir'			=>		WRITEPATH.'uploads',
										'mode' 				=> 		'utf-8',
										'format' 			=> 		[217.523394, 281.563128],
										'orientation' 		=> 		'L',
										'margin_top' 		=> 		0,
										'margin_bottom'		=> 		0,
										'margin_left' 		=> 		0,
										'margin_right' 		=> 		0,
										'mirrorMargins' 	=> 		true
											]);

					$mpdf->falseBoldWeight = 20;

					$data 		=	[
									'qrcode'	=>	qrcode_generator(BASE_URL.'consulta-ciudadana/ver/'.$_clave),
									'cedula'	=>	$this->admin_model->get_data('vw_usr_datos', 'clave, subrubro_descripcion, idgiro_subrubro, giro, nombre_comercial, razon_social, calle, numero, interior, colonia, cp, municipio_nombre AS municipio, autoclasificacion, g_giro, SUBSTR(fecha_registro_alt, 1, 10) AS fecha_alt, SUBSTR(fecha_registro, 1, 10) AS fecha, cadena_aprobacion', 
																					['clave'		=>	$_clave, 
																					'visible'		=>	1, 
																					'concluido'		=>	1, 
																					'aprobado'		=>	1, 
																					'giro <>'		=>	0, 
																					'municipio <>'	=>	0], true, [], '', '', true)
									];

					$mpdf->SetDisplayMode('fullwidth');
					$mpdf->WriteHTML(view('panelret/section/cedula', $data));

					
					$mpdf->Output(BASE_ROOT.'writable/uploads/mpdf/Cedula_'.$_clave.'.pdf', \Mpdf\Output\Destination::FILE);

			        /* Genera email para envío de cédula */
			        $mensaje    = '<img src="'.BASE_URL.'static/images/anterior_horizontal_logo_ret_altb_.png" /><br>
			        		<strong> Estimado Prestador de Servicios Turísticos, </strong> <br><br> 

					Reciba un cordial saludo y aprovecho para informarle que su trámite del Registro Estatal de Turismo del Estado de Guanajuato ha sido <b>APROBADO</b>.<br><br>
					Adjunto, te hacemos llegar la cédula RET dígital para su impresión. <br><br>														 

					<b>Recuerda que:</b>
					<ul>
						<li>Tú cédula RET es única e intransferible.</li>
						<li>Posee código QR para identificación de trámite.</li>
						<li>Posee sello digital para identificación de trámite único.</li>
					</ul>

					<br>

					<strong> ATENTAMENTE, <br>
					Registro Estatal de Turismo <br>
					Secretaría de Turismo del Estado de Guanajuato </strong>';

			        send_email('Trámite RET / APROBADO', $this->usuario_model->get($_clave, 'email'), $mensaje, '', '', BASE_ROOT.'writable/uploads/mpdf/Cedula_'.$_clave.'.pdf');

					$tipoMsj 	=	'success';
					$txtMsj		=	'El registro '.$_clave.' fue APROBADO y la Cédula enviada satisfactoriamente.';

					$return 	=	'vista';
					$o_function = 'aprobados';
				break;
				case 'renovar':
					$this->admin_model->set_data('ret_datos_generales', [
												'renovar'				=>	1,
												'visible'				=>	1,
												'concluido'				=>	0,
												'aprobado'				=>	0,
												'fecha_registro'		=>	date('Y-m-d h:i:s')
												], ['clave'	=>	$_clave]);

					$pass   = password_generator();

					$this->admin_model->set_data('ret_usr', [
												'activo'				=>	1,
												'pass' 					=> 	password_hash($pass, PASSWORD_DEFAULT),
												'fecha_renovacion'		=>	date('Y-m-d h:i:s'),
												'porcentaje_registro'	=>	10,
												'fecha_registro'		=>	date('Y-m-d h:i:s')
												], ['id'	=>	$_clave]);

			        /* Genera email para envío de acceso */
			        $mensaje    = '<div>
			                        <img src="'.BASE_URL.'static/images/anterior_horizontal_logo_ret_altb_.png" />
			                        <h2>Bienvenido al Registro Estatal de Turismo del Estado de Guanajuato</h2>
			                        <span>Le invitamos a acceder a la plataforma lo antes posible para renovar su registro.</span><br/>
			                        <span><b><h3>Tiene un máximo de 7 días naturales para el registro.</h3></b></span>
			                        <span>Su acceso a la plataforma son los siguientes:</span><br/><br/>
			                        <span><b>Usuario:</b></span><br/>
			                        <span>'.$_clave.'</span><br/>
			                        <span><b>Contraseña:</b></span><br/>
			                        <span>'.$pass.'</span><br/><br/>
			                        <span><b>Inicia sesión en este enlace:</b></span><br/>
			                        <span><a href="'.BASE_URL.'ingresar" target="_blank">'.BASE_URL.'ingresar</a></span><br/><br/>
			                        <span>Recuerda, ¡te estaremos esperando!</span><br/><br/>
			                        <span><b>Cualquier duda comunicarse a la Secretaría de Turismo del Estado de Guanajuato al teléfono (472) 103 99 00 ext. 229 o al correo electrónico </b></span><a href="mailto:ret@guanajuato.gob.mx" target="_blank">ret@guanajuato.gob.mx</a><br/><br/>
			                    </div>';

			        send_email('Renovación de su registro y su acceso ha sido reestablecido', $this->usuario_model->get($_clave, 'email'), $mensaje);
					
					$tipoMsj 	=	'success';
					$txtMsj		=	'El registro '.$_clave.' fue enviado para RENOVACIÓN satisfactoriamente y se ha REESTABLECIDO su acceso a la plataforma.';

					$return 	=	'vista';
				break;
				case 'baja':
					$this->admin_model->set_data('ret_datos_generales', [
												'visible'			=>	0,
												'concluido'			=>	0,
												'aprobado'			=>	0
												], ['clave'	=>	$_clave]);
					$tipoMsj 	=	'success';
					$txtMsj		=	'El registro '.$_clave.' fue dado de BAJA satisfactoriamente.';

					$return 	=	'vista';
				break;
				default:
					$tipoMsj 	=	'error';
					$txtMsj		=	'Su solicitud no fue procesada.';

					$return 	=	'lista';
			}
        	$this->session->setFlashdata('o_function', $o_function);

        	$this->session->setFlashdata($tipoMsj, $txtMsj);
			
			if($return == 'lista')
				return redirect()->to('paneladm/'.$o_function);
			else if($return == 'vista')
				return redirect()->to('paneladm/ver/'.$_clave);
		}

		public function reminder()
		{
	        /* Genera email recordatorio de 30 días */
	        $por_vencer30 	=	$this->admin_model->get_data('vw_usr_datos', '*', 
	        							['concluido'	=>	1, 
										'aprobado'		=>	1, 
										'giro <>'		=>	0, 
										'municipio <>'	=>	0], true, [], 'giro ASC', 'DATEDIFF(CURRENT_TIMESTAMP, DATE_ADD( fecha_registro, INTERVAL 3 YEAR)) = -30', true);

	        /*$por_vencer30 	=	$this->admin_model->get_data('vw_usr_datos', '*', 
	        							['giro <>'		=>	0, 
										'municipio <>'	=>	0], true, [], 'giro ASC', 'email = "conectimx@gmail.com" OR email = "mgmankel@gmail.com" OR email = "mgskc@yahoo.com" OR email = "ret@guanajuato.gob.mx" OR email = "mgmiguel@outlook.com"', true);*/

	        if($por_vencer30)
	        	foreach($por_vencer30 as $pv30)
	        	{
			        $mensaje    	=	'<div>
			                        <img src="'.BASE_URL.'static/images/anterior_horizontal_logo_ret_altb_.png" />
			                        <h2>Estimado '.$pv30['nombre_comercial'].'</h2>
			                        <span>Le informamos que su trámite RET vence en 30 días.</span><br/>
			                        <span>Te recordamos que la vigencia es de 3 años y <b>renovarlo es muy fácil.</b></span>
			                        <span><b>Inicia sesión en este enlace:</b></span><br/>
			                        <span><a href="'.BASE_URL.'ingresar" target="_blank">'.BASE_URL.'ingresar</a></span><br/><br/>
			                        <span>Revisa que la información sea correcta, o en su caso, actualizarla.</span><br/><br/>
			                        <span><b>ÚNICAMENTE SE ANEXARÁ LA SIGUIENTE DOCUMENTACIÓN:</b></span><br/>
			                        <span>-Constancia de Situación Fiscal reciente</span><br/>
			                        <span>-Comprobante de domicilio reciente </span><br/>
			                        <span>-Contrato de arrendamiento vigente (si aplica el caso)</span><br/><br/>
			                        <span><b>Cualquier duda comunicarse a la Secretaría de Turismo del Estado de Guanajuato al teléfono (472) 103 99 00 ext. 229 o al correo electrónico </b></span><a href="mailto:ret@guanajuato.gob.mx" target="_blank">ret@guanajuato.gob.mx</a><br/><br/>
			                    </div>';

			        send_email('Trámite RET vence en 30 días', $this->usuario_model->get($pv30['clave'], 'email'), $mensaje);
	        	}

	        /* Genera email recordatorio de 30 días */

	        $por_vencer15 	=	$this->admin_model->get_data('vw_usr_datos', '*', 
	        							['concluido'	=>	1, 
										'aprobado'		=>	1, 
										'giro <>'		=>	0, 
										'municipio <>'	=>	0], true, [], 'giro ASC', 'DATEDIFF(CURRENT_TIMESTAMP, DATE_ADD( fecha_registro, INTERVAL 3 YEAR)) = -15', true);

	        /*$por_vencer15 	=	$this->admin_model->get_data('vw_usr_datos', '*', 
	        							['giro <>'		=>	0, 
										'municipio <>'	=>	0], true, [], 'giro ASC', 'email = "conectimx@gmail.com" OR email = "mgmankel@gmail.com" OR email = "mgskc@yahoo.com" OR email = "ret@guanajuato.gob.mx" OR email = "mgmiguel@outlook.com"', true);*/

	        if($por_vencer15)
	        	foreach($por_vencer15 as $pv15)
	        	{
			        $mensaje    	=	'<div>
			                        <img src="'.BASE_URL.'static/images/anterior_horizontal_logo_ret_altb_.png" />
			                        <h2>Estimado '.$pv15['nombre_comercial'].'</h2>
			                        <span>Le informamos que su trámite RET vence en 15 días.</span><br/>
			                        <span>Te recordamos que la vigencia es de 3 años y <b>renovarlo es muy fácil.</b></span>
			                        <span><b>Inicia sesión en este enlace:</b></span><br/>
			                        <span><a href="'.BASE_URL.'ingresar" target="_blank">'.BASE_URL.'ingresar</a></span><br/><br/>
			                        <span>Revisa que la información sea correcta, o en su caso, actualizarla.</span><br/><br/>
			                        <span><b>ÚNICAMENTE SE ANEXARÁ LA SIGUIENTE DOCUMENTACIÓN:</b></span><br/>
			                        <span>-Constancia de Situación Fiscal reciente</span><br/>
			                        <span>-Comprobante de domicilio reciente </span><br/>
			                        <span>-Contrato de arrendamiento vigente (si aplica el caso)</span><br/><br/>
			                        <span><b>Cualquier duda comunicarse a la Secretaría de Turismo del Estado de Guanajuato al teléfono (472) 103 99 00 ext. 229 o al correo electrónico </b></span><a href="mailto:ret@guanajuato.gob.mx" target="_blank">ret@guanajuato.gob.mx</a><br/><br/>
			                    </div>';

			        send_email('Trámite RET vence en 15 días', $this->usuario_model->get($pv15['clave'], 'email'), $mensaje);
	        	}

	        exit;
		}

		public function cedula($_action = '', $_clave = '')
		{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

			$return 	=	'lista';
			$o_function = $this->session->getFlashdata('o_function');

			switch($_action)
			{
				case 'descargar':
					@chmod(WRITEPATH.'uploads/mpdf', 0777);
					@chmod(WRITEPATH.'uploads/mpdf/ttfontdata', 0777);

					// $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
					// $fontDirs = $defaultConfig['fontDir'];

					// $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
					// $fontData = $defaultFontConfig['fontdata'];

					$mpdf = new \Mpdf\Mpdf([
										'tempDir'			=>		WRITEPATH.'uploads',
										'mode' 				=> 		'utf-8',
										'format' 			=> 		[217.523394, 281.563128],
										'orientation' 		=> 		'L',
										'margin_top' 		=> 		0,
										'margin_bottom'		=> 		0,
										'margin_left' 		=> 		0,
										'margin_right' 		=> 		0,
										'mirrorMargins' 	=> 		true
											]);

					$mpdf->falseBoldWeight = 20;

					$data 		=	[
									'qrcode'	=>	qrcode_generator(BASE_URL.'consulta-ciudadana/ver/'.$_clave),
									'cedula'	=>	$this->admin_model->get_data('vw_usr_datos', 'clave, subrubro_descripcion, idgiro_subrubro, giro, nombre_comercial, razon_social, calle, numero, interior, colonia, cp, municipio_nombre AS municipio, autoclasificacion, g_giro, SUBSTR(dg_fecha_registro_alt, 1, 10) AS fecha_alt, SUBSTR(dg_fecha_registro, 1, 10) AS fecha, cadena_aprobacion', 
																					['clave'		=>	$_clave, 
																					'visible'		=>	1, 
																					'concluido'		=>	1, 
																					'aprobado'		=>	1, 
																					'giro <>'		=>	0, 
																					'municipio <>'	=>	0], true, [], '', '', true)
									];

					$mpdf->SetDisplayMode('fullwidth');
					$mpdf->WriteHTML(view('panelret/section/cedula', $data));

					
					$mpdf->Output('Cedula_'.$_clave.'.pdf', \Mpdf\Output\Destination::INLINE); exit;

				break;
				case 'enviar':
					@chmod(WRITEPATH.'uploads/mpdf', 0777);
					@chmod(WRITEPATH.'uploads/mpdf/ttfontdata', 0777);

					$mpdf = new \Mpdf\Mpdf([
										'tempDir'			=>		WRITEPATH.'uploads',
										'mode' 				=> 		'utf-8',
										'format' 			=> 		[217.523394, 281.563128],
										'orientation' 		=> 		'L',
										'margin_top' 		=> 		0,
										'margin_bottom'		=> 		0,
										'margin_left' 		=> 		0,
										'margin_right' 		=> 		0,
										'mirrorMargins' 	=> 		true
											]);

					$mpdf->falseBoldWeight = 20;

					$data 		=	[
									'qrcode'	=>	qrcode_generator(BASE_URL.'consulta-ciudadana/ver/'.$_clave),
									'cedula'	=>	$this->admin_model->get_data('vw_usr_datos', 'clave, subrubro_descripcion, idgiro_subrubro, giro, nombre_comercial, razon_social, calle, numero, interior, colonia, cp, municipio_nombre AS municipio, autoclasificacion, g_giro, SUBSTR(dg_fecha_registro_alt, 1, 10) AS fecha_alt, SUBSTR(dg_fecha_registro, 1, 10) AS fecha, cadena_aprobacion', 
																					['clave'		=>	$_clave, 
																					'visible'		=>	1, 
																					'concluido'		=>	1, 
																					'aprobado'		=>	1, 
																					'giro <>'		=>	0, 
																					'municipio <>'	=>	0], true, [], '', '', true)
									];

					$mpdf->SetDisplayMode('fullwidth');
					$mpdf->WriteHTML(view('panelret/section/cedula', $data));

					
					$mpdf->Output(BASE_ROOT.'writable/uploads/mpdf/Cedula_'.$_clave.'.pdf', \Mpdf\Output\Destination::FILE);

			        /* Genera email para envío de cédula */
			        $mensaje    = '<img src="'.BASE_URL.'static/images/anterior_horizontal_logo_ret_altb_.png" /><br>
			        		<strong> Estimado Prestador de Servicios Turísticos, </strong> <br><br> 

					Reciba un cordial saludo y aprovecho para informarle que su trámite del Registro Estatal de Turismo del Estado de Guanajuato ha sido <b>APROBADO</b>.<br><br>
					Adjunto, te hacemos llegar la cédula RET dígital para su impresión. <br><br>														 

					<b>Recuerda que:</b>
					<ul>
						<li>Tú cédula RET es única e intransferible.</li>
						<li>Posee código QR para identificación de trámite.</li>
						<li>Posee sello digital para identificación de trámite único.</li>
					</ul>

					<br>

					<strong> ATENTAMENTE, <br>
					Registro Estatal de Turismo <br>
					Secretaría de Turismo del Estado de Guanajuato </strong>';

			        send_email('Trámite RET / APROBADO', $this->usuario_model->get($_clave, 'email'), $mensaje, '', '', BASE_ROOT.'writable/uploads/mpdf/Cedula_'.$_clave.'.pdf');



					$tipoMsj 	=	'success';
					$txtMsj		=	'La cédula fue enviada con éxito.';

					$return 	=	'lista';
				break;
				default:
					$tipoMsj 	=	'error';
					$txtMsj		=	'Su solicitud no fue procesada.';

					$return 	=	'lista';
			}
        	$this->session->setFlashdata('o_function', $o_function);

        	$this->session->setFlashdata($tipoMsj, $txtMsj);

			if($return = 'lista')
				return redirect()->to('paneladm/'.$o_function);
			else if($return = 'vista')
				return redirect()->to('paneladm/ver/'.$_clave);
		}

		public function eliminar_todos()
		{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

			$o_function = $this->session->getFlashdata('o_function');

			$lista 		=	$this->admin_model->get_data('vw_usr_datos', 'clave', 
										['visible'		=>	0, 
										'concluido'		=>	0, 
										'aprobado'		=>	0, 
										'giro <>'		=>	0, 
										'municipio <>'	=>	0], true, [], 'giro ASC', '', true);

			foreach($lista as $delete)
			{
				$this->admin_model->delete_data($delete['clave']);
			}
			
			$tipoMsj 	=	'success';
			$txtMsj		=	'Los registros vencidos han sido ELIMINADOS.';

        	$this->session->setFlashdata('o_function', $o_function);

        	$this->session->setFlashdata($tipoMsj, $txtMsj);
			
			return redirect()->to('paneladm/'.$o_function);
		}

		public function reportexls($_tipo = '')
		{
	    	if(! $this->session->get('logged_adm')) 
		   		return redirect()->to('panelauth');

		   	\PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder() );

			$o_function 		= 	$this->session->getFlashdata('o_function');
			$valido 			=	false;

			$reportesDir		=	ROOTPATH.'writable/reportes/';
			$plantillaDir		=	$reportesDir.'plantilla/';

			if(! is_dir($reportesDir))
				@mkdir($reportesDir, 0777, true);

			if(! is_dir($plantillaDir))
				@mkdir($plantillaDir, 0777, true);

			$template 			=	ROOTPATH.'writable/reportes/plantilla/'.$_tipo.'.xlsx';

			$loadTemplateOrCreate = static function($template, array $headers = []) {
				if(is_file($template))
				{
					$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet = $spreadsheet->getActiveSheet();
				}
				else
				{
					$spreadsheet = new Spreadsheet();
					$worksheet = $spreadsheet->getActiveSheet();

					if(count($headers) > 0)
					{
						$column = 'A';
						foreach($headers as $header)
						{
							$worksheet->setCellValue($column.'1', $header);
							$worksheet->getStyle($column.'1')->getFont()->setBold(true);
							$column++;
						}
					}
				}

				return [$spreadsheet, $worksheet];
			};
			
			switch($_tipo)
			{
				case 'periodo7':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	7;

					$data				= 		$this->admin_model->get_data('vw_usr_datos', '', ['visible'	=>	1, 
												'concluido'	=>	0, 
												'aprobado'	=>	0], true, [], 'giro ASC', 'fecha_registro BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()', true);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['correo']);
						$worksheet->getCell('I'.$fila)->setValue($value['municipio_nombre']);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'pendientes':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	7;

					$data				= 		$this->admin_model->get_data('vw_usr_datos', '', ['visible'		=>	1, 
            																					'concluido'		=>	0, 
            																					'aprobado'		=>	0, 
            																					'giro <>'		=>	0, 
            																					'municipio <>'	=>	0], true, [], 'giro ASC', '', true);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['representante']);
						$worksheet->getCell('I'.$fila)->setValue($value['calle']);
						$worksheet->getCell('J'.$fila)->setValue($value['numero']);
						$worksheet->getCell('K'.$fila)->setValue($value['colonia']);
						$worksheet->getCell('L'.$fila)->setValue($value['telefono']);
						$worksheet->getCell('M'.$fila)->setValue($value['correo']);
						$worksheet->getCell('N'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('O'.$fila)->setValue($value['dg_fecha_registro']);
						$worksheet->getStyle('O'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'concluidos':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	7;

					$data				= 	$this->admin_model->get_data('vw_usr_datos', '', ['visible'		=>	1, 
            																					'concluido'		=>	1, 
            																					'aprobado'		=>	0, 
            																					'giro <>'		=>	0, 
            																					'municipio <>'	=>	0], true, [], 'giro ASC', '', true);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['representante']);
						$worksheet->getCell('I'.$fila)->setValue($value['calle']);
						$worksheet->getCell('J'.$fila)->setValue($value['numero']);
						$worksheet->getCell('K'.$fila)->setValue($value['colonia']);
						$worksheet->getCell('L'.$fila)->setValue($value['telefono']);
						$worksheet->getCell('M'.$fila)->setValue($value['correo']);
						$worksheet->getCell('N'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('O'.$fila)->setValue($value['dg_fecha_registro']);
						$worksheet->getStyle('O'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'apphospedaje':

					[$spreadsheet, $worksheet] = $loadTemplateOrCreate($template, [
						'CLAVE RET',
						'VISIBLE',
						'CONCLUIDO',
						'APROBADO',
						'GIRO',
						'SUBRUBRO',
						'NOMBRE COMERCIAL',
						'MUNICIPIO ID',
						'MUNICIPIO',
						'CATEGORIA',
						'TIPO',
						'FECHA REGISTRO',
					]);
					$fila				=	is_file($template) ? 2 : 2;

					$data				= 	$this->admin_model->get_data('vw_usr_datos', 'vw_usr_datos.subrubro_descripcion, vw_usr_datos.dg_fecha_registro, vw_usr_datos.clave, vw_usr_datos.visible, vw_usr_datos.concluido, vw_usr_datos.aprobado, vw_usr_datos.g_giro, vw_usr_datos.nombre_comercial, vw_usr_datos.municipio, vw_usr_datos.municipio_nombre, ret_frm_hospedaje.categoria, ret_frm_hospedaje.tipo, vw_usr_datos.fecha', ['visible'		=>	1, 
												'concluido'		=>	1, 
												'aprobado'		=>	1, 
												'vw_usr_datos.giro '			=>	1, 
												'municipio <>'	=>	0], true, [], 'vw_usr_datos.giro ASC', '', true,
            																					[['tabla' 		=>	'ret_frm_hospedaje',
            																					'condicion'		=>	'vw_usr_datos.clave = ret_frm_hospedaje.clave',
            																					'tipo'			=>	'left'
            																					]]);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['municipio']);
						$worksheet->getCell('I'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('J'.$fila)->setValue($value['categoria']);
						$worksheet->getCell('K'.$fila)->setValue($value['tipo']);
						$worksheet->getCell('L'.$fila)->setValue($value['dg_fecha_registro']);
						$worksheet->getStyle('L'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'appdigital':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	2;

					$data				= 	$this->admin_model->get_data('vw_usr_datos', 'vw_usr_datos.dg_fecha_registro, vw_usr_datos.clave, vw_usr_datos.visible, vw_usr_datos.concluido, vw_usr_datos.aprobado, vw_usr_datos.g_giro, vw_usr_datos.nombre_comercial, vw_usr_datos.municipio, vw_usr_datos.municipio_nombre, vw_usr_datos.airbnb, vw_usr_datos.kayak, vw_usr_datos.booking, vw_usr_datos.tripadvisor, vw_usr_datos.trivago, vw_usr_datos.otrap, vw_usr_datos.otradigital, vw_usr_datos.fecha', ['visible'		=>	1, 
												'concluido'		=>	1, 
												'aprobado'		=>	1, 
												'vw_usr_datos.giro '			=>	17, 
												'municipio <>'	=>	0], true, [], 'vw_usr_datos.giro ASC', '', true,
            																					[['tabla' 		=>	'ret_frm_hospedaje-digitales',
            																					'condicion'		=>	'vw_usr_datos.clave = ret_frm_hospedaje-digitales.clave',
            																					'tipo'			=>	'left'
            																					]]);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('G'.$fila)->setValue($value['municipio']);
						$worksheet->getCell('H'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('I'.$fila)->setValue($value['airbnb']);
						$worksheet->getCell('J'.$fila)->setValue($value['kayak']);
						$worksheet->getCell('K'.$fila)->setValue($value['booking']);
						$worksheet->getCell('L'.$fila)->setValue($value['tripadvisor']);
						$worksheet->getCell('M'.$fila)->setValue($value['trivago']);
						$worksheet->getCell('N'.$fila)->setValue($value['otrap']);
						$worksheet->getCell('O'.$fila)->setValue($value['otradigital']);
						$worksheet->getCell('P'.$fila)->setValue($value['dg_fecha_registro']);
						$worksheet->getStyle('P'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'apprestaurante':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	2;

					$data				= 	$this->admin_model->get_data('vw_usr_datos', 'vw_usr_datos.subrubro_descripcion, vw_usr_datos.dg_fecha_registro, vw_usr_datos.clave, vw_usr_datos.visible, vw_usr_datos.concluido, vw_usr_datos.aprobado, vw_usr_datos.g_giro, vw_usr_datos.nombre_comercial, vw_usr_datos.municipio, vw_usr_datos.municipio_nombre, ret_frm_restaurantes.tipo_establecimiento, ret_frm_restaurantes.tipo_cocina, vw_usr_datos.fecha', ['visible'		=>	1, 
												'concluido'		=>	1, 
												'aprobado'		=>	1, 
												'vw_usr_datos.giro '			=>	5, 
												'municipio <>'	=>	0], true, [], 'vw_usr_datos.giro ASC', '', true,
            																					[['tabla' 		=>	'ret_frm_restaurantes',
            																					'condicion'		=>	'vw_usr_datos.clave = ret_frm_restaurantes.clave',
            																					'tipo'			=>	'left'
            																					]]);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['municipio']);
						$worksheet->getCell('I'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('J'.$fila)->setValue($value['tipo_establecimiento']);
						$worksheet->getCell('K'.$fila)->setValue($value['tipo_cocina']);
						$worksheet->getCell('L'.$fila)->setValue($value['dg_fecha_registro']);
						$worksheet->getStyle('L'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'aprobados':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	7;

					$data				= 	$this->admin_model->get_data('vw_usr_datos', '*, DATE_FORMAT(dg_fecha_registro, \'%d/%m/%Y\') AS dg_fecha_registro_alt_short', ['visible'		=>	1, 
												'concluido'		=>	1, 
												'aprobado'		=>	1, 
												'giro <>'		=>	0, 
												'municipio <>'	=>	0], true, [], 'giro ASC', 'DATE_ADD( dg_fecha_registro, INTERVAL 3 YEAR ) >= NOW()', true);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['info_rfc']);
						$worksheet->getCell('I'.$fila)->setValue($value['representante']);
						$worksheet->getCell('J'.$fila)->setValue($value['fijos_h']);
						$worksheet->getCell('K'.$fila)->setValue($value['fijos_m']);
						$worksheet->getCell('L'.$fila)->setValue($value['tempo_h']);
						$worksheet->getCell('M'.$fila)->setValue($value['tempo_m']);
						$worksheet->getCell('N'.$fila)->setValue($value['disca_h']);
						$worksheet->getCell('O'.$fila)->setValue($value['disca_m']);
						$worksheet->getCell('P'.$fila)->setValue((($value['inst_disca'] == 1)?'SI':'NO'));
						$worksheet->getCell('Q'.$fila)->setValue((($value['pet_friendly'] == 1)?'SI':'NO'));
						$worksheet->getCell('R'.$fila)->setValue((($value['lgbttit'] == 1)?'SI':'NO'));
						$worksheet->getCell('S'.$fila)->setValue((($value['capacita'] == 1)?'SI':'NO'));
						$worksheet->getCell('T'.$fila)->setValue((($value['cert_med'] == 1)?'SI':'NO'));
						$worksheet->getCell('U'.$fila)->setValue($value['inversion']);
						$worksheet->getCell('V'.$fila)->setValue($value['inicio_opera']);
						$worksheet->getCell('W'.$fila)->setValue($value['organizacion']);
						$worksheet->getCell('X'.$fila)->setValue($value['calle']);
						$worksheet->getCell('Y'.$fila)->setValue($value['numero']);
						$worksheet->getCell('Z'.$fila)->setValue($value['colonia']);
						$worksheet->getCell('AA'.$fila)->setValue($value['telefono']);
						$worksheet->getCell('AB'.$fila)->setValue($value['latitud']);
						$worksheet->getCell('AC'.$fila)->setValue($value['longitud']);
						$worksheet->getCell('AD'.$fila)->setValue($value['correo']);
						$worksheet->getCell('AE'.$fila)->setValue($value['web']);
						$worksheet->getCell('AF'.$fila)->setValue($value['facebook']);
						$worksheet->getCell('AG'.$fila)->setValue($value['twitter']);
						$worksheet->getCell('AH'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('AI'.$fila)->setValue($value['descripcion']);
						$worksheet->getCell('AJ'.$fila)->setValue($value['dg_fecha_registro_alt_short']);
						$worksheet->getStyle('AJ'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'vencidos':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	7;

					$data				= 	$this->admin_model->get_data('vw_usr_datos', '', ['visible'		=>	0, 
												'concluido'		=>	0, 
												'aprobado'		=>	0, 
												'giro <>'		=>	0, 
												'municipio <>'	=>	0], true, [], 'giro ASC', '', true);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['representante']);
						$worksheet->getCell('I'.$fila)->setValue($value['calle']);
						$worksheet->getCell('J'.$fila)->setValue($value['numero']);
						$worksheet->getCell('K'.$fila)->setValue($value['colonia']);
						$worksheet->getCell('L'.$fila)->setValue($value['telefono']);
						$worksheet->getCell('M'.$fila)->setValue($value['correo']);
						$worksheet->getCell('N'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('O'.$fila)->setValue($value['dg_fecha_registro']);
						$worksheet->getStyle('O'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);

						$fila++;
					}

            		$valido 			=		true;
				break;
				case 'todos':

					$spreadsheet 		=	\PhpOffice\PhpSpreadsheet\IOFactory::load($template);
					$worksheet 			=	$spreadsheet->getActiveSheet();
					$fila				=	7;

					$data				= 	$this->admin_model->get_data('vw_usr_datos', '', ['giro <>'		=>	0, 
																								'municipio <>'	=>	0], true, [], 'giro ASC', '', true);

					foreach($data as $key 	=>	$value)
					{
						$worksheet->getCell('A'.$fila)->setValue($value['clave']);
						$worksheet->getCell('B'.$fila)->setValue((($value['visible'] == 1)?'SI':'NO'));
						$worksheet->getCell('C'.$fila)->setValue((($value['concluido'] == 1)?'SI':'NO'));
						$worksheet->getCell('D'.$fila)->setValue((($value['aprobado'] == 1)?'SI':'NO'));
						$worksheet->getCell('E'.$fila)->setValue($value['g_giro']);
						$worksheet->getCell('F'.$fila)->setValue($value['subrubro_descripcion']);
						$worksheet->getCell('G'.$fila)->setValue($value['nombre_comercial']);
						$worksheet->getCell('H'.$fila)->setValue($value['info_rfc']);
						$worksheet->getCell('I'.$fila)->setValue($value['representante']);
						$worksheet->getCell('J'.$fila)->setValue($value['fijos_h']);
						$worksheet->getCell('K'.$fila)->setValue($value['fijos_m']);
						$worksheet->getCell('L'.$fila)->setValue($value['tempo_h']);
						$worksheet->getCell('M'.$fila)->setValue($value['tempo_m']);
						$worksheet->getCell('N'.$fila)->setValue($value['disca_h']);
						$worksheet->getCell('O'.$fila)->setValue($value['disca_m']);
						$worksheet->getCell('P'.$fila)->setValue((($value['inst_disca'] == 1)?'SI':'NO'));
						$worksheet->getCell('Q'.$fila)->setValue((($value['pet_friendly'] == 1)?'SI':'NO'));
						$worksheet->getCell('R'.$fila)->setValue((($value['lgbttit'] == 1)?'SI':'NO'));
						$worksheet->getCell('S'.$fila)->setValue((($value['capacita'] == 1)?'SI':'NO'));
						$worksheet->getCell('T'.$fila)->setValue((($value['cert_med'] == 1)?'SI':'NO'));
						$worksheet->getCell('U'.$fila)->setValue($value['inversion']);
						$worksheet->getCell('V'.$fila)->setValue($value['inicio_opera']);
						$worksheet->getCell('W'.$fila)->setValue($value['organizacion']);
						$worksheet->getCell('X'.$fila)->setValue($value['calle']);
						$worksheet->getCell('Y'.$fila)->setValue($value['numero']);
						$worksheet->getCell('Z'.$fila)->setValue($value['colonia']);
						$worksheet->getCell('AA'.$fila)->setValue($value['telefono']);
						$worksheet->getCell('AB'.$fila)->setValue($value['latitud']);
						$worksheet->getCell('AC'.$fila)->setValue($value['longitud']);
						$worksheet->getCell('AD'.$fila)->setValue($value['correo']);
						$worksheet->getCell('AE'.$fila)->setValue($value['web']);
						$worksheet->getCell('AF'.$fila)->setValue($value['facebook']);
						$worksheet->getCell('AG'.$fila)->setValue($value['twitter']);
						$worksheet->getCell('AH'.$fila)->setValue($value['municipio_nombre']);
						$worksheet->getCell('AI'.$fila)->setValue($value['descripcion']);
						$worksheet->getCell('AJ'.$fila)->setValue($value['dg_fecha_registro']);
						$worksheet->getStyle('AJ'.$fila)
								  ->getNumberFormat()
								  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME);
						$fila++;
					}

            		$valido 			=		true;
				break;
				default:
					$valido 			=		false;
			}

			if($valido)
			{
				$writer 			=	\PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
				$ruta 				=	ROOTPATH.'writable/reportes/';
				$documento 			=	'RET_'.$_tipo.'.xlsx';
				$writer->save($ruta.$documento);

				try{
					$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'reportes/'.$documento, true);

					return $this->response->download(WRITEPATH.'reportes/'.$documento, null)->setFileName('RET_'.$_tipo.'_'.date('Ymdhis').'.xlsx');

				}
				catch( \Exception $e){
					return redirect()->to('paneladm');
				}

			}
			else
		   		return redirect()->to('panelauth');
		}

}
