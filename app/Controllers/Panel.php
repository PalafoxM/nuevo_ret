<?php
namespace App\Controllers;
require_once APPPATH."Libraries/vendor/autoload.php";
use Mpdf\Mpdf;

class Panel extends BaseController {


	public function index()
	{
		if($this->session->get('logged'))
			panel_session($this->session->get('email'), 'email');

		
		if($this->session->get('api_logged'))
		{
			if($data['result'] = $this->usuario_model->get_list_by_email($this->session->get('email'), 'api'))
			{
				$data['title']				=		'Registro Estatal de Turismo | Panel de Usuario';
				$data['head_js']			=	array(
													BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
													BASE_URL.STATIC_JS.'jquery.min-3.3.1.js',
													BASE_URL.STATIC_JS.'datatables/js/jquery.dataTables.min.js',
													BASE_URL.STATIC_JS.'datatables/js/dataTables.bootstrap5.min.js',
												);
				$data['head_css']			=	array(
													BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
													BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
													BASE_URL.STATIC_CSS.'header.css',
													BASE_URL.STATIC_CSS.'redireccion.css?v=1.1',
													BASE_URL.STATIC_CSS.'footer.css?v=1.1',
													BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
													BASE_URL.STATIC_JS.'datatables/css/dataTables.bootstrap5.min.css',
												);

				$data['dt_mx']			=		BASE_URL.STATIC_JS.'datatables/lang/dataTables.esmx.json';
				$data['nav']			=		'private/nav';
				$data['header']			=		'private/header';
				$data['main']			=		'private/panel';
				$data['footer']			=		'public/footer';


				return view('template', $data);
			}
			else
				return redirect()->to('registro/nuevo');
		}
		else
			return redirect()->to('inicio');
	}

	public function empresa($_id = '')
	{
		if($this->session->get('api_logged') && $_id != '' && $this->usuario_model->get($_id, 'email') == $this->session->get('email'))
		{
			ret_session($_id);
			return redirect()->to('empresa-avance');
		}
		else
			return redirect()->to('panel');
	}

	public function enviar_cedula($_id)
	{
		if($this->session->get('api_logged') && $_id != '' && $this->usuario_model->get($_id, 'email') == $this->session->get('email'))
		{
			@chmod(WRITEPATH.'uploads/mpdf', 0777);
			@chmod(WRITEPATH.'uploads/mpdf/ttfontdata', 0777);

			$mpdf = new \Mpdf\Mpdf([
								'tempDir'			=>		WRITEPATH.'uploads',
								'mode' 				=> 		'utf-8',
								'format' 			=> 		[217.523394, 281.563128],
								'orientation' 		=> 		'L',
								'default_font' 		=> 		'chelvetica',
								'margin_top' 		=> 		0,
								'margin_bottom'		=> 		0,
								'margin_left' 		=> 		0,
								'margin_right' 		=> 		0,
								'mirrorMargins' 	=> 		true
									]);

			$data 		=	[
							'qrcode'	=>	qrcode_generator(BASE_URL.'consulta-ciudadana/ver/'.$_clave),
							'cedula'	=>	$this->admin_model->get_data('vw_usr_datos', 'clave, nombre_comercial, razon_social, calle, numero, interior, colonia, cp, municipio_nombre AS municipio, autoclasificacion, g_giro, SUBSTR(dg_fecha_registro_alt, 1, 10) AS fecha_alt, SUBSTR(dg_fecha_registro, 1, 10) AS fecha, cadena_aprobacion', 
																			['clave'		=>	$_id, 
																			'visible'		=>	1, 
																			'concluido'		=>	1, 
																			'aprobado'		=>	1, 
																			'giro <>'		=>	0, 
																			'municipio <>'	=>	0], true, [], '', '', true)
							];

			$mpdf->SetDisplayMode('fullwidth');
			$mpdf->WriteHTML(view('panelret/section/cedula', $data));

			
			$mpdf->Output(BASE_ROOT.'writable/uploads/mpdf/Cedula_'.$_id.'.pdf', \Mpdf\Output\Destination::FILE);

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

	        send_email('Trámite RET / APROBADO', $this->usuario_model->get($_id, 'email'), $mensaje, EMAIL_CC, '', BASE_ROOT.'writable/uploads/mpdf/Cedula_'.$_id.'.pdf', '');

		}

		return redirect()->to('panel');
	}

	public function eliminar_empresa($_id)
	{
		if($this->session->get('api_logged') && $_id != '' && $this->usuario_model->get($_id, 'email') == $this->session->get('email'))
			$this->admin_model->delete_data($_id);
		
		return redirect()->to('panel');
	}

}