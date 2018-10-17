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
			<h1 class="text-warning"><?php echo $this->session->userdata("username"); ?> Você não pode batalhar porque TODOS os seus Cavaleiros estão Hospitalizados!</h1>
		</div>
	</div>
	<div class="row"><div class="col-md-12 col-xs-12">&nbsp;</div></div>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<center><img class="img-responsive" src="<?php echo base_url(); ?>public/img/extra/img_hospital.png" /></center>
		</div>
	</div>
	<div class="row"><div class="col-md-12 col-xs-12">&nbsp;</div></div>
	<div class="row">
		<div class="col-md-6 col-xs-12 text-center">
			<a href="<?php echo base_url(); ?>index.php/hospital" class="btn btn-warning">Ir ao Hospital</a>
		</div>
		<div class="col-md-6 col-xs-12 text-center">
			<a href="<?php echo base_url(); ?>index.php/dash" class="btn btn-warning">Voltar à Dashboard</a>
		</div>
	</div>
</div>