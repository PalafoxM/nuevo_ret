<?php
namespace App\Controllers;

class Salir extends BaseController {

	public function index()
	{
		$this->session->destroy();
		return redirect()->to('ingresar');
	}
}