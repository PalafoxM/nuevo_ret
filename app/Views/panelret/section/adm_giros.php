<?php $this->session          = \Config\Services::session(); ?>


<div id="page-wrapper">
	<div class="row">
        	<div class="col-lg-12"><br>
			<div class="alert alert-success alert-dismissible" role="alert">
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  				<strong>PRINCIPAL. </strong> Estadistica general referente a los registros actualmente en la plataforma RET 3.0
			</div>
                </div>
 	</div>

	<?php if($this->session->getFlashdata('success')):?>
	<div class="alert alert-success">
               	<a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php echo $this->session->getFlashdata('success'); ?></strong>
	</div>

	<?php elseif($this->session->getFlashdata('error')):?>
        <div class="alert alert-warning">
        	<a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php echo $this->session->getFlashdata('error'); ?></strong>
	</div>
        <?php endif;?>

	<div class="row">
               	<div class="col-lg-12">      
			<table class="table">
                        	<thead>
                            		<tr class="bg-primary">
                                		<th style="font-size: 12px">GIRO COMERCIAL</th>
                                		<th style="font-size: 12px">REGISTROS ACTIVOS</th>
                                		<!--<th style="font-size: 12px">CONCLUIDOS</th>
                                		<th style="font-size: 12px">APROBADOS</th>-->
                            		</tr>
                        	</thead>

                        	<tbody>
                            	<?php foreach($giros as $row): ?>
                            		<tr>
                                		<td style="font-size: 12px"><b> <?php echo $row->giro; ?> </b></td>
                                		<td style="font-size: 16px"><b> <font color="red"> <?php echo $row->activos; ?> </font> </b></td>
                            		</tr>
			    	<?php endforeach; ?>
                        	</tbody>
                    	</table>
                </div>
	</div>
</div>



        <!-- Modal -->
        <div class="modal fade" id="deactivateConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirmación para Eliminar</h4>
                    </div>
                    <div class="modal-body">
                        <label>You are going to delete user <label id="user-email" style="color:blue;"></label>.</label><br/>
                        <label>Clic en<b>Aceptar</b> para continuar.</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a id="deactivateYesButton" class="btn btn-danger" >Si</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Modal -->
        <div class="modal fade" id="resetConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirmación para reestablecer contraseña</h4>
                    </div>
                    <div class="modal-body">
                        <label>You are going to reset user <label id="reset-user-email" style="color:blue;"></label>'s password.</label><br/>
                        <label>Tempolary password will be sent to this email.</label><br/>
                        <label>Click <b>Yes</b> to continue.</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a id="resetYesButton" class="btn btn-warning" >Yes</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Crear un nuevo usuario</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label> &nbsp;&nbsp;
                                    <label class="error" id="error_name"> field is required.</label>
                                    <label class="error" id="error_name2"> name must be alphanumeric.</label>
                                    <input class="form-control" id="name" placeholder="Name" name="name" type="text" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label> &nbsp;&nbsp;
                                    <label class="error" id="error_email"> field is required.</label>
                                    <label class="error" id="error_email2"> email has already exist.</label>
                                    <label class="error" id="error_email3"> invalid email adress.</label>
                                    <input class="form-control" id="email" placeholder="E-mail" name="email" type="email" autofocus>
                                </div> 
                            </div>
                      </div>
                      <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Role</label>&nbsp;&nbsp;
                                    <label class="error" id="error_role"> field is required.</label>
                                    <select name="role" id="role" class="form-control" >
                                        <option value="0" selected="selected">-- Seleccionar Rol --</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select> 
                                </div>
                            </div>
                      </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="newUserSubmit" type="button" class="btn btn-primary">Crear</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Actualizar detalles de Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"  id="edit-user-id" value=""/>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label> &nbsp;&nbsp;
                                    <label class="error" id="edit-error_name"> el campo es requerido.</label>
                                    <label class="error" id="edit-error_name2"> el nombre debe ser alfanumerico.</label>
                                    <input class="form-control" id="edit-name" placeholder="Nombre" name="edit-name" type="text" autofocus>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label> &nbsp;&nbsp;
                                    <label class="error" id="edit-error_email"> el campo es requerido.</label>
                                    <label class="error" id="edit-error_email2"> este correo electrónico, actualmente existe en los registros.</label>
                                    <label class="error" id="edit-error_email3"> correo electrónico inválido.</label>
                                    <input class="form-control" id="edit-email" placeholder="correo@dominio.com" name="edit-email" type="email" autofocus>
                                </div> 
                            </div>
                      </div>
                      <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Role</label>&nbsp;&nbsp;
                                    <label class="error" id="edit-error_role"> esl campo es requerido.</label>
                                    <select name="role" id="edit-role" class="form-control" >
                                    </select> 
                                </div>
                            </div>
                      </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="editUserSubmit" type="button" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
       
        <!-- /#page-wrapper -->
