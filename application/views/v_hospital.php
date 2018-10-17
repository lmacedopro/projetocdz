<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<?php //foreach($user as $u){ ?>
<div class="col-md-12 col-xs-12 centered">
    <div class="page-header text-left">
        <h3>Hospital</h3>
    </div>
    <div class="row centered">
        <div class="col-md-12 bordercont">
            Restaure a saúde dos seus Cavaleiros no Hospital.
        </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row centered">
        <div class="col-md-12 bordercont">
            <h4><strong>Sua Equipe</strong></h4>
			<?php foreach($lineup as $lnu){ ?>
				<div class="col-md-2 col-xs-2 text-center">
				<?php if($lnu->cvu_hp > 0) { ?>
					<p class="btn btn-success" >
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
						<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
					</p>
				<?php }else{ ?>
					<p class="btn btn-danger" >
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
						<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
					</p>
				<?php } ?>
            </div>
			<?php } ?>
			<div class="col-md-12 col-xs-12 text-center"><p>&nbsp;</p></div>
			<div class="col-md-12 col-xs-12 text-center">
				<a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/hospital/restaurar">Restaurar Meus Cavaleiros</a>
			</div>
        </div>
    </div>
</div>
<?php //} ?>