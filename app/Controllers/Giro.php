<?php
namespace App\Controllers;

class Giro extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			switch($this->session->get('giro'))
			{
				case 1:
					return redirect()->to('hospedaje');
				break;
				case 2:
					return redirect()->to('agencia');
				break;
				case 3:
					return redirect()->to('guias');
				break;
				case 4:
					return redirect()->to('promotor');
				break;
				case 5:
					return redirect()->to('restaurante');
				break;
				case 6:
					return redirect()->to('golf');
				break;
				case 7:
					return redirect()->to('arte');
				break;
				case 8:
					return redirect()->to('concluir-registro');
				break;
				case 9:
					return redirect()->to('arrendadora');
				break;
				case 10:
					return redirect()->to('parque');
				break;
				case 11:
					return redirect()->to('auxilio');
				break;
				case 12:
					return redirect()->to('balneario');
				break;
				case 13:
					return redirect()->to('capacitacion');
				break;
				case 14:
					return redirect()->to('deporte');
				break;
				case 15:
					return redirect()->to('spa');
				break;
				case 16:
					return redirect()->to('recinto');
				break;
				case 17:
					return redirect()->to('hospedaje-digital');
				break;
				default:
					return redirect()->to('datos-generales');
			}

		}
		else
			return redirect()->to('panel');
	}


} 