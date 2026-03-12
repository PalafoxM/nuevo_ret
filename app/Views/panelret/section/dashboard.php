<?php $this->session          = \Config\Services::session(); ?>

	<div id="page-wrapper">

        	<?php if($this->session->getFlashdata('success')):?> &nbsp;

		<div class="alert alert-success">
                	<a href="#" class="close" data-dismiss="alert">&times;</a>
                	<strong><?php echo $this->session->getFlashdata('success'); ?></strong>
     		</div>

        	<?php elseif($this->session->getFlashdata('error')):?> &nbsp;

		<div class="alert alert-warning">
                	<a href="#" class="close" data-dismiss="alert">&times;</a>
                	<strong><?php echo $this->session->getFlashdata('error'); ?></strong>
		</div>

         	<?php endif;?>

		<div class="row">
			<div class="col-lg-12">
				<h4 class="page-header alert alert-success"> Dashboard / Google DataStudio / SECTUR Guanajuato </h4>
                	</div>

                	<div class="col-md-12">
						<iframe width="100%" height="1920" src="https://lookerstudio.google.com/embed/reporting/a17060df-153c-4fbf-a02c-26eb2debf9c1/page/dljMC" frameborder="0" style="border:0" allowfullscreen></iframe>
                	</div>
		</div>
        </div>
</div>
            






