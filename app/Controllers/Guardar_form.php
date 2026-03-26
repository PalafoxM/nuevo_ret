<?php
namespace App\Controllers;
use CodeIgniter\Files\File;

class Guardar_form extends BaseController {


	public function index()
	{
		if($this->session->get('logged'))
		{
			$this->validation       = \Config\Services::validation();


			$fields 	= 	$this->session->getFlashdata('fields') ?? [];
			$matrix 	= 	$this->session->getFlashdata('matrix') ?? [];
			$files 		= 	$this->session->getFlashdata('files') ?? [];
			$validate 	= 	$this->session->getFlashdata('validate') ?? [];
			$controller	= 	$this->session->getFlashdata('controller');
			$next_cont	= 	$this->session->getFlashdata('next_cont');
	        
	        $dbfield 	=	[];
	        $dbmatrx 	=	[];
	        $wrmatrx 	=	[];
	        $imtrx		=	0;


			foreach($fields as $field)
			{
				$name 		=	$field['name'];
				$type 		=	$field['type'];


				if($type == 'checkbox')
					$$name 		=	(($this->request->getVar($name) == 'on')?1:0);
				else
					$$name 		=	$this->request->getVar($name);
				
				$dbfield 	=	array_merge($dbfield, [$name	=>	$$name]);
				
			}

			foreach($files as $file)
			{
				$name 		=	$file['name'];

				$$name 		= 	$this->request->getFile($name);

				if(
					! $$name
					|| ! ($$name instanceof \CodeIgniter\HTTP\Files\UploadedFile)
					|| $$name->getError() === UPLOAD_ERR_NO_FILE
					|| ! $$name->isValid()
				)
				{
					unset($$name);
					unset($validate[$name]);
				}
			}

			foreach($matrix as $matrx)
			{
				$imtrx++;
				$name0 		=	$matrx['name0'];
				$field0		=	$matrx['dbfield0'];
				$name1 		=	$matrx['name1'];
				$field1		=	$matrx['dbfield1'];
				$name2 		=	$matrx['name2'];
				$field2		=	$matrx['dbfield2'];

				$$name0 		= 	$this->request->getVar($name0);
				$$name1 		= 	$this->request->getVar($name1);
				$$name2 		= 	$this->request->getVar($name2);

				$dbmatrx 	=	array_merge($dbmatrx, [[
																		$field0	=>	$$name0,
																		$field1	=>	$$name1,
																		$field2	=>	$$name2
																	]]);
				$wrmatrx 	=	array_merge($wrmatrx, [[
																		'clave'		=>	$this->session->get('id'),
																		'hab'		=>	$imtrx,
																	]]);

			}

			$this->validation->setRules($validate);

			if (! $this->validate($validate))
			{

				$alerta = array('titulo'			=>		'Validación',
								'mensaje'			=>		'Hubo un error en la validación. Favor de verificar la información cargada e intentar nuevamente.',
								'alert_type'		=>		'danger',
								'errors'			=>		$this->validation->getErrors(),
								'values'			=>		$dbfield
							);
				$this->session->setFlashdata($alerta);

				return redirect()->to($controller);
			}
			else
			{	
				foreach($files as $file)
				{
					$name 	=	$file['name'];
					
					if(isset($$name))
						if (! $$name->hasMoved()) 
						{
							$ruta 		=	'./'.$controller;
				            $filepath 	= 	$$name->store($ruta);

				            $dbfield 	=	array_merge($dbfield, [$name	=>	$filepath]);
				        } 
				        else 
				        {
				            $dbfield 	=	array_merge($dbfield, [$name	=>	'Error']);
				            $controller =	'';
				        }
				}

				$response 	= false;
				$giro 		= false;
				switch($controller)
				{
					case 'datos-generales':
						$response 	=	$this->usuario_model->update_data($dbfield, 'ret_datos_generales', 'clave', $this->session->get('id'));
					break;
					case 'datos-tecnicos':
						$response 	=	$this->usuario_model->update_data($dbfield, 'ret_frm_tecnicos', 'clave', $this->session->get('id'));
					break;
					case 'datos-legales':
						$response 	=	$this->usuario_model->update_data($dbfield, 'ret_archivo_legal', 'clave', $this->session->get('id'));
					break;
					case 'imagenes':
						$response 	=	$this->usuario_model->update_data($dbfield, 'ret_archivo_legal', 'clave', $this->session->get('id'));
					break;
					case 'hospedaje':
						$this->usuario_model->verify_db(1, $this->session->get('id'));

						$giro 		= 	$this->usuario_model->update_data($dbfield, 'ret_frm_hospedaje', 'clave', $this->session->get('id'));

						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0,
											'autoclasificacion'		=>		$this->usuario_model->get($this->session->get('id'), 'categoria', 'ret_frm_hospedaje', 'clave')
										];

						// $response 	=	($giro && $this->usuario_model->update_data_batch($dbmatrx, 'ret_frm_hospedaje_detalle', $wrmatrx) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
						$response 	=	($giro && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'agencia':
						$giro 		= 	$this->usuario_model->update_data($dbfield, 'ret_frm_agencia', 'clave', $this->session->get('id'));

						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0,
											'autoclasificacion'		=>		$this->usuario_model->get($this->session->get('id'), 'modalidad', 'ret_frm_agencia', 'clave')
										];

						$response 	=	($giro && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'guias':
						$giro 		=	$this->usuario_model->update_data($dbfield, 'ret_frm_guia', 'clave', $this->session->get('id'));

						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0,
											'autoclasificacion'		=>		$this->usuario_model->get($this->session->get('id'), 'guia', 'ret_frm_guia', 'clave')
										];

						$response 	=	($giro && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'promotor':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];

						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_promotores', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'restaurante':
						$giro 		=	$this->usuario_model->update_data($dbfield, 'ret_frm_restaurantes', 'clave', $this->session->get('id'));

						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0,
											'autoclasificacion'		=>		$this->usuario_model->get($this->session->get('id'), 'tipo_establecimiento', 'ret_frm_restaurantes', 'clave')
										];

						$response 	=	($giro && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'golf':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_golf', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'arte':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_arte', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'educativa':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_educativas', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'arrendadora':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_arrendadora', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'parque':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_parques', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'auxilio':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_auxturistico', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'balneario':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_balnearios', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'capacitacion':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_capacitacion', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'deporte':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_deporte', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'spa':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_spa', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'recinto':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_recinto', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					case 'hospedaje-digital':
						$dgrales 	=	[
											'concluido'				=>		1,
											'renovar'				=>		0
										];


						$this->usuario_model->verify_db(17, $this->session->get('id'));
						$response 	=	($this->usuario_model->update_data($dbfield, 'ret_frm_hospedaje-digitales', 'clave', $this->session->get('id')) && $this->usuario_model->update_data($dgrales, 'ret_datos_generales', 'clave', $this->session->get('id')));
					break;
					default:
						$response 	=	false;
				}

				if($response)
				{
					$alerta = array('titulo'			=>		'Datos guardados',
									'mensaje'			=>		'Su información ha sido guardada con éxito.',
									'alert_type'		=>		'success'
								);
					$this->session->setFlashdata($alerta);
					return redirect()->to($next_cont);
				}
				else
				{
					$alerta = array('titulo'		=>		'Problema al guardar',
									'mensaje'		=>		'Hubo un error en el registro. Favor de verificar e intentar nuevamente.',
									'alert_type'	=>		'warning',
									'values'		=>		[$dbfield, $dbmatrx, $wrmatrx],
								);
					$this->session->setFlashdata($alerta);
					return redirect()->to($controller);
				}
			}

		}
		else
		{
			return redirect()->to('panel');
		}

	}

}
