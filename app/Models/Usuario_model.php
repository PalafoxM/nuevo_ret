<?php
namespace App\Models;
use CodeIgniter\Model;

class Usuario_model extends Model {

    function cambiar_password($nueva)
    {
        $session = \Config\Services::session();
        $builder = $this->db->table('ret_usr');
        
        $data = array(
           'pass' => password_hash($nueva, PASSWORD_DEFAULT)
        );
        
        $builder->where('id', $session->get('id'));
        $builder->update($data); 

        return true;
    }

    function cambiar_password_por_email($email, $nueva)
    {
        $builder = $this->db->table('ret_usr');

        $data = array(
           'pass' => password_hash($nueva, PASSWORD_DEFAULT),
           'activo' => 1,
        );

        $builder->where('email', $email);
        $builder->update($data);

        return ($this->db->affectedRows() >= 0);
    }

    function get($usuario, $campo, $tabla = 'vw_usr_datos', $id = 'id', $result = false, $array_where = [])
    {
        $builder = $this->db->table($tabla);

        $builder->select($campo);
        $where_and = array_merge($array_where, [$id       =>      $usuario]);
        $builder->where($where_and);

        if($result)
        {
            if($r = $builder->get()->getResultArray())
            {
                return $r;
            }
            else
                return false;
        }
        else
        {
            if($r = $builder->get()->getResultArray())
            {
                return $r[0][$campo];
            }
            else
                return false;
        }
    }

    function get_subrubros($form = false, $giro = 0)
    {
        $builder = $this->db->table('vw_giro_subrubro');

        if($form)
            $builder->select('idgiro_subrubro as value_id, descripcion as value_name');
        
        if($giro != 0)
            $builder->where('id_giro', $giro);
        
        $builder->orderBy('descripcion','ASC');
        $array = $builder->get()->getResultArray();
        if(count($array)>0)
            return $array;
        else
            return false;
    }  

    function get_by_rfc($rfc, $campo)
    {
        $builder = $this->db->table('vw_usr_datos');
        
        $builder->select($campo);
        $where_and = array('info_rfc'       =>      $rfc);
        $builder->where($where_and);

        //$query = $builder->get();

        if($r = $builder->get()->getResultArray())
        {
            return $r[0][$campo];
        }
        else
            return false;
    }

    function get_list_by_email($email = false, $from = '')
    {
        $builder = $this->db->table('vw_usr_datos');

        switch($from)
        {
            case 'api':
                $where = array(
                        'email'            =>      $email,
                        'goog_email'       =>      $email,
                        'msft_email'       =>      $email,
                        'fcbk_email'       =>      $email,
                    );
            break;
            default:
                $where = array(
                        'email'            =>      $email,
                    );

        }
        $builder->orWhere($where);

        if($result = $builder->get()->getResultArray())
            return $result;
        else
            return false;
    }

    function get_preregistro($preregistro, $campo)
    {
        $builder = $this->db->table('ret_preregistro');
        
        $builder->select($campo);
        $where_and = array(
                        'idpreregistro'   =>      $preregistro,
                        'status'          =>      1,
                        'used <='         =>      1,
                        'date_regi >='    =>      date('Y-m-d H:i:s', strtotime('-7 day', strtotime(date('Y-m-d H:i:s')))),
                    );
        $builder->where($where_and);

        if($r = $builder->get()->getResultArray())
        {
            return $r[0][$campo];
        }
        else
            return false;
    }

    function nuevo($array_data)
    {
        $session = \Config\Services::session();

        /* Insertar en Datos Generales */
        $builder    = $this->db->table('ret_datos_generales');

        $query      = $builder->insert($array_data);
        $id_pts     = $this->db->insertID();

        
        /* Genera clave RET */
        $clave      = 'RET'.sprintf("%02d",$array_data['giro']).sprintf("%02d",$array_data['municipio']).sprintf("%04d",$id_pts);

        
        $data       = array('clave' => $clave);
        
        /* Actualiza Datos Generales con clave */
        $builder    = $this->db->table('ret_datos_generales');

        $builder->where('id_pts', $id_pts);
        $builder->update($data); 

        
        /* Inserta en Datos Técnicos con clave */
        $builder    = $this->db->table('ret_frm_tecnicos');
        $query      = $builder->insert($data);


        /* Inserta en Archivos Legales con clave */
        $builder    = $this->db->table('ret_archivo_legal');
        $query      = $builder->insert($data);

        switch($array_data['giro'])
        {
            case '1': /* Inserta en giro de Hospedaje */
                $builder    = $this->db->table('ret_frm_hospedaje');
                $query      = $builder->insert($data);

                $detalle    = [
                                ['clave'    =>  $clave,'hab'      =>  1],
                                ['clave'    =>  $clave,'hab'      =>  2],
                                ['clave'    =>  $clave,'hab'      =>  3],
                                ['clave'    =>  $clave,'hab'      =>  4],
                                ['clave'    =>  $clave,'hab'      =>  5],
                                ['clave'    =>  $clave,'hab'      =>  6],
                                ['clave'    =>  $clave,'hab'      =>  7],
                                ['clave'    =>  $clave,'hab'      =>  8],
                                ['clave'    =>  $clave,'hab'      =>  9],
                                ['clave'    =>  $clave,'hab'      =>  10],
                            ];
                $builder    = $this->db->table('ret_frm_hospedaje_detalle');
                $query      = $builder->insertBatch($detalle);

                $estable    = [
                                ['clave'    =>  $clave,'estab'      =>  1],
                                ['clave'    =>  $clave,'estab'      =>  2],
                                ['clave'    =>  $clave,'estab'      =>  3],
                                ['clave'    =>  $clave,'estab'      =>  4],
                                ['clave'    =>  $clave,'estab'      =>  5],
                                ['clave'    =>  $clave,'estab'      =>  6],
                            ];
                $builder    = $this->db->table('ret_frm_hospedaje_estable');
                $query      = $builder->insertBatch($estable);
            break;
            case '2': /* Inserta en giro de Agencias */
                $builder    = $this->db->table('ret_frm_agencia');
                $query      = $builder->insert($data);
            break;
            case '3': /* Inserta en giro de Guías */
                $builder    = $this->db->table('ret_frm_guia');
                $query      = $builder->insert($data);
            break;
            case '4': /* Inserta en giro de Promotores */
                $builder    = $this->db->table('ret_frm_promotores');
                $query      = $builder->insert($data);
            break;
            case '5': /* Inserta en giro de Alimentos y Bebidas */
                $builder    = $this->db->table('ret_frm_restaurantes');
                $query      = $builder->insert($data);
            break;
            case '6': /* Inserta en giro de Golf */
                $builder    = $this->db->table('ret_frm_golf');
                $query      = $builder->insert($data);            
            break;
            case '7': /* Inserta en giro de Arte popular */
                $builder    = $this->db->table('ret_frm_arte');
                $query      = $builder->insert($data);            
            break;
            case '8': /* Inserta en giro de Educativas y Culturales */
                $builder    = $this->db->table('ret_frm_educativas');
                $query      = $builder->insert($data);
            break;
            case '9': /* Inserta en giro de Arrendadoras de Autos */
                $builder    = $this->db->table('ret_frm_arrendadora');
                $query      = $builder->insert($data);
            break;
            case '10': /* Inserta en giro de Parques Temáticos */
                $builder    = $this->db->table('ret_frm_parques');
                $query      = $builder->insert($data);
            break;
            case '11': /* Inserta en giro de Auxilio turístico */
                $builder    = $this->db->table('ret_frm_auxturistico');
                $query      = $builder->insert($data);
            break;
            case '12': /* Inserta en giro de Parques Acuáticos */
                $builder    = $this->db->table('ret_frm_balnearios');
                $query      = $builder->insert($data);
            break;
            case '13': /* Inserta en giro de Capacitación Turística */
                $builder    = $this->db->table('ret_frm_capacitacion');
                $query      = $builder->insert($data);
            break;
            case '14': /* Inserta en giro de Deporte */
                $builder    = $this->db->table('ret_frm_deporte');
                $query      = $builder->insert($data);
            break;
            case '15': /* Inserta en giro de Spas */
                $builder    = $this->db->table('ret_frm_spa');
                $query      = $builder->insert($data);
            break;
            case '16': /* Inserta en giro de Recintos */
                $builder    = $this->db->table('ret_frm_recinto');
                $query      = $builder->insert($data);
            break;
            case '17': /* Inserta en giro de Plataformas Digitales */
                $builder    = $this->db->table('ret_frm_hospedaje-digitales');
                $query      = $builder->insert($data);
                
                $detalle    = [
                                ['clave'    =>  $clave,'hab'      =>  1],
                                ['clave'    =>  $clave,'hab'      =>  2],
                                ['clave'    =>  $clave,'hab'      =>  3],
                                ['clave'    =>  $clave,'hab'      =>  4],
                                ['clave'    =>  $clave,'hab'      =>  5],
                                ['clave'    =>  $clave,'hab'      =>  6],
                                ['clave'    =>  $clave,'hab'      =>  7],
                                ['clave'    =>  $clave,'hab'      =>  8],
                                ['clave'    =>  $clave,'hab'      =>  9],
                                ['clave'    =>  $clave,'hab'      =>  10],
                            ];
                $builder    = $this->db->table('ret_frm_hospedaje-digitales_detalle');
                $query      = $builder->insertBatch($detalle);

                $estable    = [
                                ['clave'    =>  $clave,'estab'      =>  1],
                                ['clave'    =>  $clave,'estab'      =>  2],
                                ['clave'    =>  $clave,'estab'      =>  3],
                                ['clave'    =>  $clave,'estab'      =>  4],
                                ['clave'    =>  $clave,'estab'      =>  5],
                                ['clave'    =>  $clave,'estab'      =>  6],
                            ];
                $builder    = $this->db->table('ret_frm_hospedaje-digitales_estable');
                $query      = $builder->insertBatch($estable);
            break;
        }


        /* Inserta en Usuarios */
        $password   = password_generator();

        $ret_usr    = array(
                        'activo'                =>  1, 
                        'id'                    =>  $clave, 
                        'pass'                  =>  password_hash($password, PASSWORD_DEFAULT), 
                        'email'                 =>  $array_data['correo'],
                        'privacidad'            =>  $array_data['privacidad'], 
                        'ip_visitante'          =>  $array_data['ip_visitante'],
                        'id_perfil'             =>  3,
                        'fecha_registro'        =>  $array_data['fecha_registro'],
                        'porcentaje_registro'   =>  10
                    );


        switch($session->get('api_source'))
        {
            case 'google':
                $ret_usr = array_merge($ret_usr, array('goog_email'     =>  $session->get('email'), 'goog_name'      =>  $session->get('name')));
            break;
            case 'microsoft':
                $ret_usr = array_merge($ret_usr, array('msft_email'     =>  $session->get('email'), 'msft_name'      =>  $session->get('name')));
            break;
            case 'facebook':
                $ret_usr = array_merge($ret_usr, array('fcbk_email'     =>  $session->get('email'), 'fcbk_name'      =>  $session->get('name')));
            break;
        }  

        $builder    = $this->db->table('ret_usr');
        $builder->insert($ret_usr);


        /* Genera email para envío de acceso */
        $mensaje    = '<div>
                        <img src="'.BASE_URL.'static/images/logo_ret_azul.png" />
                        <h2>Bienvenido al Registro Estatal de Turismo del Estado de Guanajuato</h2>
                        <span>Le invitamos a acceder a la plataforma lo antes posible para completar su registro.</span><br/>
                        <span><b><h3>Tiene un máximo de 7 días naturales para el registro.</h3></b></span>
                        <span>Su acceso a la plataforma son los siguientes:</span><br/><br/>
                        <span><b>Usuario:</b></span><br/>
                        <span>'.$clave.'</span><br/>
                        <span><b>Contraseña:</b></span><br/>
                        <span>'.$password.'</span><br/><br/>
                        <span><b>Inicia sesión en este enlace:</b></span><br/>
                        <span><a href="'.BASE_URL.'ingresar" target="_blank">'.BASE_URL.'ingresar</a></span><br/><br/>
                        <span>Recuerda, ¡te estaremos esperando!</span><br/><br/>
                        <span><b>Cualquier duda comunicarse a la Secretaría de Turismo del Estado de Guanajuato al teléfono (472) 103 99 00 ext. 229 o al correo electrónico </b></span><a href="mailto:ret@guanajuato.gob.mx" target="_blank">ret@guanajuato.gob.mx</a><br/><br/>
                    </div>';

        $email_enviado = send_email('Acceso a la Plataforma', $array_data['correo'], $mensaje);

        if($email_enviado)
            $session->setFlashdata([
                'titulo'        =>  'Credenciales enviadas',
                'mensaje'       =>  'Tu acceso RET fue creado correctamente y las credenciales se enviaron al correo registrado.',
                'alert_type'    =>  'success',
                'modal_title'   =>  'Listo',
                'modal_message' =>  'Tu acceso RET fue creado correctamente. Revisa el correo que ingresaste: '.$array_data['correo'].', ahi te enviamos tus credenciales para continuar.',
                'modal_icon'    =>  'success',
            ]);
        else
            $session->setFlashdata([
                'titulo'        =>  'Registro completado',
                'mensaje'       =>  'Tu acceso RET ya fue creado, pero el correo con las credenciales no se pudo enviar en este momento. Puedes ingresar con los siguientes datos:<br><strong style="color:#198754;">Usuario:</strong> <strong style="color:#198754;">'.$clave.'</strong><br><strong style="color:#198754;">Contrasena:</strong> <strong style="color:#198754;">'.$password.'</strong>',
                'alert_type'    =>  'warning',
            ]);

        /* Inicia la sesión con usuario RET */
        ret_session($clave); 

        return $clave;

    }

    function update_data($array_data, $tabla, $campo, $id, $array_where = [])
    {
        $builder    = $this->db->table($tabla);

        $array_where = array_merge($array_where, [$campo    =>  $id]);
        $builder->where($array_where);

        return $builder->update($array_data);
    }

    function update_data_batch($array_data, $tabla, $array_where)
    {
        $builder    = $this->db->table($tabla);

        if(count($array_data) == count($array_where))
        {
            for($i = 0; $i < count($array_data); $i ++)
            {
                $builder->where($array_where[$i]);
                $builder->update($array_data[$i]);
            }
            return true;
        }
        else
            return false;
    }

    function preregistro($email, $str_verify)
    {
        $builder        = $this->db->table('ret_preregistro');
        
        $array_data     = array(
                            'email'             =>      $email,
                            'verification'      =>      password_hash($str_verify, PASSWORD_DEFAULT),
                    );


        $query              = $builder->insert($array_data);
        $idpreregistro      = $this->db->insertID();

        $mensaje    = '<div>
                        <img src="'.BASE_URL.'static/images/logo_ret_azul.png" />
                        <h2>Bienvenido al Registro Estatal de Turismo del Estado de Guanajuato</h2>
                        <span>¡Felicidades! Usted ha validado su dirección de correo electrónico, ahora continúe con su registro accediendo al siguiente enlace:</span><br/><br/>
                        <span><a href="'.BASE_URL.'registro/verificacion/'.$idpreregistro.'/'.$str_verify.'" target="_blank">'.BASE_URL.'registro/verificacion/'.$idpreregistro.'/'.$str_verify.'</a><br/><br/>
                        <span><b><h3>Tiene un máximo de 7 días naturales para continuar con el registro.</h3></b></span>
                        <span style="color:#0000ff"><b><h3>Te recordamos los requisitos:</h3></b></span>
                        <span><b>1. Registro Federal de contribuyentes (RFC).</b></span><br/>
                        <span><b>2. Comprobante de domicilio (Recibo de Luz, Agua o Teléfono).</b></span><br/>
                        <span><b>3. Identificación oficial</b></span><br/>
                        <span><b>4. Licencia de uso de suelo o Constancia de Situación Fiscal.</b></span><br/>
                        <span><b>5. Escritura Pública o Contrato de Arrendamiento.</b></span><br/>
                        <span><b>6. Acta constitutiva <span style="color: #ff0000;">(Aplica solo a Personas morales)</span>.</b></span><br/>
                        <span><b>7. Logotipo e Imágenes.</b></span><br/>
                        <span><b>8. Protocolo de Higiene <span style="color:#0000ff">(Aplica únicamente a Hospedaje de Plataformas Digitales)</span> *Ejemplo: Distintivo Guanajuato Sano, (secuencia de pasos a seguir en la higiene del establecimiento).</b></span><br/>
                        <span><b>Recuerda, ¡te estaremos esperando!</b></span><br/><br/>
                        <span><b>Cualquier duda comunicarse a la Secretaría de Turismo del Estado de Guanajuato al teléfono (472) 103 99 00 ext. 229 o al correo electrónico </b></span><a href="mailto:ret@guanajuato.gob.mx" target="_blank">ret@guanajuato.gob.mx</a><br/><br/>
                    </div>';

        return send_email('Validación de correo electrónico', $email, $mensaje, '');
    }

    function update_preregistro($idpreregistro, $uft = false)
    {
        try
        {
            $builder = $this->db->table('ret_preregistro');

            if($uft)
                $array_data =   array(
                                'status'          =>  0,
                                'used'            =>  2,
                                'date_used'       =>  date('Y-m-d H:i:s'),
                            );
            else
                $array_data =   array(
                                'status'          =>  1,
                                'used'            =>  1,
                                'date_used'       =>  date('Y-m-d H:i:s'),
                            );


            $builder->where('idpreregistro', $idpreregistro);
            $builder->update($array_data); 

            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    function get_funcionalidad($id)
    {
        $builder = $this->db->table('ret_funcionalidad');

        $where_and = array(
                            'idfuncionalidad'       =>      $id,
                            'estatus'               =>      1
                            );
        $builder->where($where_and);

        return $builder->get()->getResultArray();
    }

    function verify_db($giro, $clave) //Verifica que en los giros 1 y 17, la tabla de detalle y estable, tengan los registros pregrabados para su actualización
    {
        
        $detalle    = [];
        $estable    = [];

        switch($giro)
        {
            case 1: /* Inserta en giro de Hospedaje */
                $count      = 10;
                for($i = 1; $i <= $count; $i++)
                {
                    $detalle    =   array_merge($detalle, [['clave'    =>  $clave,'hab'      =>  $i]]);
                }

                $table      = 'ret_frm_hospedaje_detalle';


                $count_e    = 6;
                for($i = 1; $i <= $count_e; $i++)
                {
                    $estable    =   array_merge($estable, [['clave'    =>  $clave,'estab'      =>  $i]]);
                }

                $table_e    = 'ret_frm_hospedaje_estable';
            break;
            case 17: /* Inserta en giro de Plataformas Digitales */
                $count      = 10;
                for($i = 1; $i <= $count; $i++)
                {
                    $detalle    =   array_merge($detalle, [['clave'    =>  $clave,'hab'      =>  $i]]);
                }

                $table      = 'ret_frm_hospedaje-digitales_detalle';


                $count_e    = 6;
                for($i = 1; $i <= $count_e; $i++)
                {
                    $estable    =   array_merge($estable, [['clave'    =>  $clave,'estab'      =>  $i]]);
                }
                $table_e    = 'ret_frm_hospedaje-digitales_estable';
            break;
        }

        $builder = $this->db->table($table);
        $builder->select();
        $where_and = array('clave'       =>      $clave);
        $builder->where($where_and);
        $r = $builder->get()->getResultArray();

        $builder_e = $this->db->table($table_e);
        $builder_e->select();
        $where_and_e = array('clave'       =>      $clave);
        $builder_e->where($where_and_e);
        $r_e = $builder_e->get()->getResultArray();

        if(count($r) == $count && count($r_e) == $count_e)
            return true;
        else
        {
            $builder    = $this->db->table($table);
            $where_and  = array('clave'       =>      $clave);
            $builder->where($where_and);
            $builder->delete();

            $builder    = $this->db->table($table);
            $query      = $builder->insertBatch($detalle);



            $builder_e  = $this->db->table($table_e);
            $where_and_e= array('clave'       =>      $clave);
            $builder_e->where($where_and_e);
            $builder_e->delete();

            $builder_e      = $this->db->table($table_e);
            $query_e        = $builder_e->insertBatch($estable);

            return true;            

        }

    }
}
?>
