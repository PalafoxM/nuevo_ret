<?php
$this->session          = \Config\Services::session();
?>

<!DOCTYPE html>
<html lang="es"> 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Registro Estatal de Turismo - Gobierno del Estado de Guanajuato" />
    <meta name="abstract" content="Registro Estatal de Turismo - Gobierno del Estado de Guanajuato, la Grandeza de México" />
    <meta name="keywords" content="Registro Estatal de Turismo, Hotel, Restaurante, Guía Turístico, Pueblos Mágicos, Guanajuato, León, Salamanca, Celaya, Irapuato, Silao" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta property="og:title" content="Registro Estatal de Turismo" />
    <meta property="og:description" content="Registro Estatal de Turismo del Estado de Guanajuato" />
    <meta property="og:image" content="https://guanajuato.gob.mx/imagesD/GTO-LOGOAsset.png" />
    <meta property="og:url" content="<?=BASE_URL?>" />
    <meta name="theme-color" content="#000f9f">
    <meta name="developer" content="palafox.marin@hotmail.com">

    <title><?=$title?></title>

    <link rel="shortcut icon" href="<?=BASE_URL?>static/images/icono_ret.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?=BASE_URL?>static/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=BASE_URL?>static/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=BASE_URL?>static/images/apple-touch-icon-114x114.png">

    <?php 
    if(isset($head_css))
      for($i = 0; $i < count($head_css); $i++)
        echo '<link rel="stylesheet" href="'.$head_css[$i].'"/>';
    ?>

    <?php
    if(isset($head_js))
      for($i = 0; $i < count($head_js); $i++)
        echo '<script type="text/javascript" src="'.$head_js[$i].'"></script>';
    ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-33018357-1"></script>
  <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-33018357-1');
  </script>

  </head>

  <body>

    <?php echo view($nav);?>
    <?php echo view($header);?>
    <?php echo view($main);?>
    <?php echo view($footer);?>

    <?php
    if(isset($footer_js))
      for($i = 0; $i < count($footer_js); $i++)
        echo '<script type="text/javascript" src="'.$footer_js[$i].'"></script>';

    if(isset($footer_script))
      for($i = 0; $i < count($footer_script); $i++)
        echo view('js/'.$footer_script[$i]);
    ?>

  </body>

</html>
