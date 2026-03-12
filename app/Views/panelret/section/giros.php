<?php $this->session          = \Config\Services::session(); ?>


<div id="page-wrapper">
	<div class="row">
        	<div class="col-lg-12"><br>
			<div class="alert alert-warning alert-dismissible" role="alert">
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  				<strong>PRINCIPAL. </strong> Estadistica general referente a los registros actualmente en la plataforma RET 2.0
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
                                <th style="font-size: 12px">Giro Comercial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($giros as $row): ?>
                            <tr>
                                <td style="font-size: 12px"><b> <?php echo $row->nombre_giro; ?> </b></td> 
                            </tr>
                            <?php endforeach; ?>                                               
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

       
        <!-- /#page-wrapper -->
        <script src="<?=BASE_URL?>assets/js/view/user_list.js"></script>