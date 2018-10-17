<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<div class="col-md-12 col-xs-12 loginbox">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<h1 class="text-success">Usuário <?php echo $this->session->userdata("username"); ?> VENCEU a Batalha!</h1>
		</div>
	</div>
	<div class="row"><div class="col-md-12 col-xs-12">&nbsp;</div></div>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="col-md-12 col-xs-12 ">
				<h4 class="text-success">Log de Batalha</h4>
				<div class="col-md-12 col-xs-12 bordercont text-center" style="height: 11.5em; overflow-y: scroll; background: #FFF;">
					<?php echo $this->session->userdata("btl_log"); ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="row"><div class="col-md-12 col-xs-12">&nbsp;</div></div>
	<div class="row">
		<div class="col-md-6 col-xs-12 text-center">
			<a href="<?php echo base_url(); ?>index.php/mapas/play?mid=<?php echo $this->session->userdata("playmap"); ?>" class="btn btn-success">Voltar ao Mapa</a>
		</div>
		<div class="col-md-6 col-xs-12 text-center">
			<a href="<?php echo base_url(); ?>index.php/dash" class="btn btn-success">Voltar à Dashboard</a>
		</div>
	</div>
</div>