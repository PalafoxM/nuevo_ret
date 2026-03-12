<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'file', 'form', 'date', 'ret', 'admret'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //Class
        $this->db               = \Config\Database::connect('default');

        // Libraries
        $this->validation               = \Config\Services::validation();
        $this->encrypter                = \Config\Services::encrypter();
        $this->security                 = \Config\Services::security();
        $this->session                  = \Config\Services::session();
        $this->email                    = \Config\Services::email();
        $this->pager                    = \Config\Services::pager();

        // Models
        $this->web_model                = new \App\Models\Web_model();
        $this->usuario_model            = new \App\Models\Usuario_model();
        $this->admin_model              = new \App\Models\Admin_model();
        $this->authentication_model     = new \App\Models\Authentication_model();
    }
}
