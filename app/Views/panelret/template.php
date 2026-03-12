<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RET | Registro Estatal de Turismo del Estado de Guanajuato</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=BASE_URL?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=BASE_URL?>assets/css/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?=BASE_URL?>assets/css/dataTables.bootstrap.css" rel="stylesheet">

    <link href="<?=BASE_URL?>assets/css/bootstrap-editable.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=BASE_URL?>assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=BASE_URL?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom tab icons -->
    <link rel="shortcut icon" href="<?=BASE_URL?>assets/images/favicon.ico" type="image/x-icon">
    <link href="<?=BASE_URL?>assets/js/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="<?=BASE_URL?>assets/js/jquery-ui-1.11.4.custom/jquery-ui-custom-datepicker.css" rel="stylesheet" type="text/css" />
    
    <input type="hidden"  id="base-url" value="<?=BASE_URL?>"/>

</head>

<body>
<div class="overlay"></div>
    <img id="loading"  width="250px" src="<?=BASE_URL?>assets/images/loading.gif" alt="Cargando...">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">#</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=BASE_URL?>">
                    <div class="inline"> &nbsp;PANEL ADMINISTRADOR </div>
                    <!--<div class="inline"> <img src="<?=BASE_URL?>assets/images/sectur_horizontal.png" width="110px" style="position: relative; top: 0px; left: 30px" /> </div>-->
                </a>

            </div>

            
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a  id="header-dropdown" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i id="header-icon" class="fa fa-user fa-fw"></i>  <i id="header-icon" class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fa fa-refresh fa-fw"></i> Cambiar Contraseña</a></li>
                        <li class="divider"></li>-->
                        <li><a href="<?=BASE_URL?>panelauth/logout"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>

    <div class=" navbar-brand navbar-right navbar-access-level">
        <b>Bienvenido</b> <?=$name?>
    </div>
            <!-- /.navbar-top-links -->


            <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Cambiar Contraseña (<?=$email?>)</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="error" id="error_changePassword">contraseña actual incorrecta</label>
                                <label class="error" id="error_changePassword2">la contraseña debe ser un máximo de 8 caracteres (alfanumericos o caracteres especiales)</label>
                            </div>
                        </div>
                        &nbsp;
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Current Password</label> &nbsp;&nbsp;
                                    <label class="error" id="error_currentPassword"> el campo es requerido.</label>
                                    <input class="form-control" id="currentPassword" placeholder="Contraseña Actual" name="currentPassword" type="password" autofocus>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nueva Contraseña</label> &nbsp;&nbsp;
                                    <label class="error" id="error_newPassword"> el campo es requerido.</label>
                                    <label class="error" id="error_newPassword2"> la contraseña no coincide</label>
                                    <input class="form-control" id="newPassword" placeholder="Nueva Contraseña" name="newPassword" type="password" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Confirmar Nueva Contraseña</label> &nbsp;&nbsp;
                                    <input class="form-control" id="confirmNewPassword" placeholder="Confirma Nueva Contraseña" name="confirmNewPassword" type="password" autofocus>
                                </div> 
                            </div>
                      </div>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="changePasswordSubmit" type="button" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                    <li>
                                        <br><center><img src="<?=BASE_URL?>assets/images/logo_ret.png" width='210' /></center><br>
                                </li>

                                <li>
                        <a href="<?=BASE_URL?>paneldash"><i class="fa fa-area-chart"></i><b> Dashboard </b></a>
                                </li>

                                <li>
                        <a href="<?=BASE_URL?>paneladm/giros"><i class="fa fa-bars"></i> Resumen </a>
                                </li>

                                <li>
                                        <a href="#"><i class="fa fa-newspaper-o"></i> Trámites <span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level active">
                            <li> <a href="<?=BASE_URL?>paneladm/hoy"><i class="fa fa-bell-o" aria-hidden="true"></i> Hoy </a> </li>
                            <li> <a href="<?=BASE_URL?>paneladm/registrados"><i class="fa fa-clock-o" aria-hidden="true"></i> En Periodo (7 días) </a> </li>
                            <li> <a href="<?=BASE_URL?>paneladm/pendientes"><i class="fa fa-tasks" aria-hidden="true"></i> Pendientes </a> </li>
                            <li> <a href="<?=BASE_URL?>paneladm/renovaciones"><i class="fa fa-refresh" aria-hidden="true"></i> Renovaciones </a> </li>
                            <li> <a href="<?=BASE_URL?>paneladm/concluidos"><i class="fa fa-calendar-o" aria-hidden="true"></i> Concluidos (Para Validar) </a> </li>
                            <li> <a href="<?=BASE_URL?>paneladm/aprobados"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aprobados (Vigentes) </a> </li>
                            <li> <a href="<?=BASE_URL?>paneladm/vencidos"><i class="fa fa-times-circle" aria-hidden="true"></i> Vencidos </a> </li>
                            <li> <a href="<?=BASE_URL?>paneladm/todos"><i class="fa fa-database" aria-hidden="true"></i> Todos </a> </li>
                                        </ul>
                                </li>                                       
                            </ul>
                    </div>
                </div>
    </nav>        




    <?php echo view($main);?>







        <div class="col-lg-12 text-right" style="padding:15px;"><small><b> Derechos Reservados &copy; <?=date('Y')?> | Secretaria de Turismo del Estado de Guanajuato </b></small></div>
        </div>
        <!-- /#wrapper -->

        <!-- jQuery 

        <script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?=BASE_URL?>assets/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=BASE_URL?>assets/js/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <!--<script src="<?=BASE_URL?>assets/js/jquery.dataTables.min.js"></script>-->
    <!--<script src="<?=BASE_URL?>assets/js/dataTables.bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/bootstrap-editable.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/bootstrap-editable.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="<?=BASE_URL?>assets/js/sb-admin-2.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

    <?php
    if(isset($footer_script))
      for($i = 0; $i < count($footer_script); $i++)
        echo view('panelret/js/'.$footer_script[$i]);
    ?>

</body>

</html>