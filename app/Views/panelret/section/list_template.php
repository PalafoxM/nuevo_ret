<?php $session          = \Config\Services::session(); ?>


<div id="page-wrapper">
	<div class="row">
            <?php if(isset($header_bar)) { ?>
        	
            <div class="col-lg-12"><br>
    			<h5 style="text-align: left; color: <?=$header_bar['color']?>; background-color: <?=$header_bar['bgcolor']?>; padding: 14px 20px; border-bottom-right-radius:40px; border-top-right-radius:40px;">
				<strong><?=$header_bar['title']?></strong> 
				<?=$header_bar['detail']?>
			    </h5>
            </div>

            <?php } ?>

            <?php if(isset($button00)) { ?>

            <div class="col-lg-2">
                <a class="btn btn-block btn-flat" style="color: <?=$button00['color']?>; background-color: <?=$button00['bgcolor']?>;" href="<?=$button00['url']?>" <?=((isset($button00['confirm']))?'onclick="return confirm(\''.$button00['confirm'].'\')"':'')?> target="<?=$button00['target']?>"><span class="fa fa-<?=$button00['icon']?>"></span> <?=$button00['tag']?></a>
            </div>

            <?php } ?>
            <?php if(isset($button01)) { ?>

            <div class="col-lg-2">
                <a class="btn btn-block btn-flat" style="color: <?=$button01['color']?>; background-color: <?=$button01['bgcolor']?>;" href="<?=$button01['url']?>" <?=((isset($button01['confirm']))?'onclick="return confirm(\''.$button01['confirm'].'\')"':'')?> target="<?=$button01['target']?>"><span class="fa fa-<?=$button01['icon']?>"></span> <?=$button01['tag']?></a>
            </div>

            <?php } ?>
            <?php if(isset($button02)) { ?>

            <div class="col-lg-2">
                <a class="btn btn-block btn-flat" style="color: <?=$button02['color']?>; background-color: <?=$button02['bgcolor']?>;" href="<?=$button02['url']?>" <?=((isset($button02['confirm']))?'onclick="return confirm(\''.$button02['confirm'].'\')"':'')?> target="<?=$button02['target']?>"><span class="fa fa-<?=$button02['icon']?>"></span> <?=$button02['tag']?></a>
            </div>

            <?php } ?>
            <?php if(isset($button03)) { ?>

            <div class="col-lg-2">
                <a class="btn btn-block btn-flat" style="color: <?=$button03['color']?>; background-color: <?=$button03['bgcolor']?>;" href="<?=$button03['url']?>" <?=((isset($button03['confirm']))?'onclick="return confirm(\''.$button03['confirm'].'\')"':'')?> target="<?=$button03['target']?>"><span class="fa fa-<?=$button03['icon']?>"></span> <?=$button03['tag']?></a>
            </div>

            <?php } ?>
    </div>


	<br>
            <?php if($session->getFlashdata('success')):?>
                <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?=$session->getFlashdata('success')?></strong>
                </div>
            <?php elseif($session->getFlashdata('error')):?>
                <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?=$session->getFlashdata('error')?></strong>
                </div>
            <?php endif;?>


            <div class="row">
                <div class="col-lg-12">      
                    <table class="table table-striped table-bordered table-hover" id="datalist">
                        <thead>
                            <tr class="bg-primary" style="background-color: #205081; color: #fff;">
                                <?php for($i = 0; $i < count($table_tag); $i ++) {?>

                                <th style="font-size: 10px"><?=$table_tag[$i]?></th>

                                <?php } ?>

                                <?php if(isset($table_action)) {?>

                                <th style="font-size: 10px">ACCIONES</th>
                                
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($lista as $row): ?>
                
                            <tr>
                                <?php for($i = 0; $i < count($table_value); $i ++) {?>

                                
                                <td align="center">
                                    <b>
                                    <?php if(count($table_url[$i]) > 0) { $url = $table_url[$i]; ?>

                                        <?php switch($table_value[$i]) { 

                                                case '_cedula_': ?>

                                        <a href="<?=$url[0].$row[$table_id]?>" target="<?=$url[1]?>"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>

                                            <?php break; ?>
                                            <?php case '_envio_': ?>
                                                <?php if($row['notifica_aprobado'] == 1) { ?>

                                        <a href="<?=$url[0].$row[$table_id]?>" target="<?=$url[1]?>"><br><span class="label" style="background-color: #32AA00; color: #fff;"> <span class="fa fa-check"></span>  </span></a>

                                                <?php } else { ?>

                                        <a href="<?=$url[0].$row[$table_id]?>" target="<?=$url[1]?>"><br><span class="label" style="background-color: #ef6c00; color: #fff;"> <span class="fa fa-times"></span> </span></a>

                                                <?php } ?>
                                            
                                            <?php break; 

                                                default: ?>

                                        <a href="<?=$url[0].$row[$table_id]?>" target="<?=$url[1]?>"><?=$row[$table_value[$i]]?></a>


                                        <?php } ?>
                                    <?php } else {?>

                                        <?php switch($table_value[$i]) { 


                                            case '_cedula_': ?>

                                        <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>

                                            <?php break; ?>
                                            <?php case '_envio_': ?>
                                                <?php if($row['notifica_aprobado'] == 1) { ?>

                                        <br><span class="label" style="background-color: #32AA00; color: #fff;"> <span class="fa fa-check"></span>  </span>

                                                <?php } else { ?>

                                        <br><span class="label" style="background-color: #ef6c00; color: #fff;"> <span class="fa fa-times"></span> </span>
                                                
                                                <?php } ?>

                                            <?php break; 

                                                default: ?>

                                        <?=$row[$table_value[$i]]?>


                                        <?php } ?>

                                    <?php }?>

                                    </b>


                                    <?php if(count($table_label[$i]) > 0) { $label = $table_label[$i]; ?>
                                
                                    <br>

                                        <?php 

                                        if($row['visible'] == 1 AND $row['renovar'] == 0 AND $row['concluido'] == 0)
                                            echo '<span class="label" style="background-color: #FF8200; color: #fff;"> REGISTRADO </span><br>';
                                        if($row['visible'] == 1 AND $row['renovar'] == 1)
                                            echo '<span class="label" style="background-color: #40a9ea; color: #fff;"> RENOVACIÓN </span><br>';
                                        if($row['visible'] == 1 AND $row['concluido'] == 0 AND $row['renovar'] == 0 AND $row['aprobado'] == 0)
                                            echo '<span class="label label-warning"> PENDIENTE </span><br>';
                                        if($row['concluido'] == 1 AND $row['renovar'] == 0 AND $row['visible'] == 1 AND $row['aprobado'] == 0)
                                            echo '<span class="label" style="background-color: #0066FF; color: #fff;"> CONCLUIDO </span><br>';
                                        if($row['dias_transcurridos'] <= 1095 AND $row['concluido'] == 1 AND $row['aprobado'] == 1 AND $row['visible'] == 1)
                                            echo '<span class="label" style="background-color: #32AA00; color: #fff;"> APROBADO </span><br>';
                                        if($row['dias_transcurridos'] > 1095 AND $row['renovar'] == 0)
                                            echo '<span class="label" style="background-color: #df0a15; color: #fff;"> VENCIDO </span><br>';


                                        ?>

                                    <?php }?>
				                
                                </td>


                                <?php }?>


                                <?php if(isset($table_action)) {?>
                				
                                <td>

                                    <?php foreach($table_action as $action) {?>

                                    <a class="btn btn-<?=$action['class']?> btn-xs" href="<?=$action['url']?><?=$row[$table_id]; ?>" onclick="return confirm('<?=$action['confirm']?>')" title="<?=$action['tag']?>"> <span class="fa fa-<?=$action['icon']?>"></span> </a>

                                    <?php } ?>

                				</td>
                                
                                <?php }?>
                                
                            </tr>
                
                            <?php endforeach; ?>
                            
                        </tbody>
                    </table>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>

        <!-- /#page-wrapper -->
