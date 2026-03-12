<?php
use App\Libraries\Ciqrcode;

if(!function_exists('qrcode_generator'))
{
    
    function qrcode_generator($data)
    {
        $ciqrcode = new Ciqrcode;

        /* Data */
        $hex_data   = bin2hex($data);
        $save_name  = $hex_data . '.png';

        /* Path */
        $dir        = WRITEPATH.'uploads/qrcode/';
        @chmod(WRITEPATH.'uploads/qrcode/', 0777);

        /* QR Configuration  */
        $config['cacheable']    = true;
        $config['imagedir']     = $dir;
        $config['quality']      = true;
        $config['size']         = '512';
        $config['black']        = [255, 255, 255];
        $config['white']        = [0, 0, 0];

        $ciqrcode->initialize($config);

        /* QR Data  */
        $params['data']     = $data;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = $config['imagedir'] . $save_name;

        $ciqrcode->generate($params);
        return $params['savename'];
        //return $ciqrcode->generate($params); //Habilitar línea para regresar IMG al OMITIR ruta para guardar

    }

}
