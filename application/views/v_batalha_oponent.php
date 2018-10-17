<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php //foreach($oponent as $o){ ?>
<div class="row">
	<div class="col-md-12 col-xs-12">
		<div class="col-md-6 container-fluid">
			<img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $oponent->cav_imgright; ?>" width='100%' />
			
			<strong class="text-danger">Oponente <?php echo $oponent->cav_nome; ?> apareceu!!!</strong><br />
			<strong> Level: <?php echo $oplvl; ?></strong> | <strong class="text-success"><?php echo $oponent->pes_desc; ?></strong><br /><br />
			<a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/batalha?opoid=<?php echo $oponent->cav_id; ?>&opolvl=<?php echo $oplvl; ?>">Lute!</a>
		</div>
		
	</div>
</div>

<?php 

/*<a class='btn btn-warning' href="<?php echo base_url(); ?>index.php/batalha?opoid=<?php echo $oponent->cav_id; ?>&opolvl=<?php echo $oplvl; ?>">Lute!*/ 

?>
<?php //}