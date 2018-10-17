<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<div class="row">
	<div class="col-md-12 col-xs-12 bordercont">
		<h4>Selecione a Técnica a ser inserida no <strong>Slot <?php echo $slot; ?></strong></h4>
            <?php if(!empty($tecsel)){ ?>
            	<?php foreach($tecsel as $tc){ ?>
	            	<a class="col-md-12 col-xs-12 btn btn-default" name="btTec" href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/slottec/alter/?cvu=<?php echo $cvuid; ?>&slot=<?php echo $slot; ?>&tec=<?php echo $tc->tec_id; ?>" title="Clique para Adicionar/Alterar o slot selecionado com esta técnica">
	            		<div class="col-md-6 text-left"><strong><?php echo $tc->tec_desc; ?></strong></div>
	            		<div class="col-md-6 small">
	            			<div class="col-md-12">
		            			<span class="col-md-4 text-left"><strong>Acc(%): </strong><?php echo $tc->tec_acerto; ?></span>
		            			<span class="col-md-4 text-left"><strong>Lvl: </strong><?php echo $tc->tec_level; ?></span>
		            			<span class="col-md-4 text-left"><strong>Str: </strong><?php echo $tc->tec_forca; ?></span>
	            			</div>
	            			<div class="col-md-12">
	            				<span class="col-md-6 text-left"><strong>Tp: </strong><?php echo $tc->tip_titulo; ?></span>
	            			</div>
	            		</div>
	            	</a>	
	            <?php } ?>
            <?php }else{ ?>
            	<div class="col-md-12 col-xs-12 alert-danger">Não Foram Encontradas Técnicas Disponíveis ou Todas as tecnicas aprendidas já estão em Uso.</div>
        	<?php } ?>
		</div>
	</div>
</div>


