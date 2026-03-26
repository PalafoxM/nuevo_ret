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

        // Libraries
        $this->validation               = \Config\Services::validation();
        $this->encrypter                = \Config\Services::encrypter();
        $this->security                 = \Config\Services::security();
        $this->session                  = \Config\Services::session();
        $this->email                    = \Config\Services::email();
        $this->pager                    = \Config\Services::pager();

        $httpHost = $_SERVER['HTTP_HOST'] ?? '';
        $serverName = $_SERVER['SERVER_NAME'] ?? '';
        $serverAddr = $_SERVER['SERVER_ADDR'] ?? '';
        $serverHost = strtolower(trim($httpHost !== '' ? $httpHost : $serverName, '[]'));
        $serverAddr = strtolower(trim($serverAddr, '[]'));
        $isLocalHost = in_array($serverHost, ['localhost', '127.0.0.1', '::1'], true)
            || in_array($serverAddr, ['127.0.0.1', '::1'], true)
            || str_starts_with($serverHost, 'localhost:')
            || str_starts_with($serverHost, '127.0.0.1:')
            || str_starts_with($serverHost, '[::1]')
            || str_starts_with($serverHost, '::1:');

        try {
            $this->db = \Config\Database::connect('default');

            // Models
            $this->web_model                = new \App\Models\Web_model();
            $this->usuario_model            = new \App\Models\Usuario_model();
            $this->admin_model              = new \App\Models\Admin_model();
            $this->authentication_model     = new \App\Models\Authentication_model();
        } catch (\Throwable $exception) {
            if (!$isLocalHost) {
                throw $exception;
            }

            // En local permitimos abrir vistas publicas aunque la BD aun no exista.
            $this->db = null;
            $this->web_model = null;
            $this->usuario_model = null;
            $this->admin_model = null;
            $this->authentication_model = null;

            log_message('warning', 'Conexion local a base de datos no disponible: {message}', [
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
