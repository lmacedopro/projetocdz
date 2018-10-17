<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<?php if($erro != ""){ ?>
<div class="modal fade" id="modal-mensagem">
   <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title">Mensagem ao usuário <?php echo $this->session->userdata("username"); ?>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</h4>
             </div>
             <div class="modal-body">
                <p class="text-danger"><?php echo $erro; ?></p>
             </div>
         </div>
     </div>
</div>
<?php } ?>

<?php echo form_open("banco/transferir"); ?>
<?php foreach($user as $u){ ?>
<div class="col-md-12 com-xs-12 centered">
    <div class="page-header text-left">
        <h3>Banco</h3>
    </div>
    <div class="row centered">
        <div class="col-md-12 col-xs-12 bordercont">
            Transfira dinheiro para outros jogadores aqui.<br />
            <span class="text-danger"><strong>Atenção:</strong> O banco cobra uma taxa de 25% pelos serviços de transferência</span>
        </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row centered">
        <div class="col-md-12 col-xs-12 bordercont">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="col-md-6 col-xs-12">
						<h4>De: <span class="text-success"><?php echo $u->usu_username; ?></span><?php echo nbs(3); ?>Dinheiro: $ <?php echo $u->usu_money; ?></h4>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="col-sm-12 form-group">
		                    <h4 for="txtUserrec" class="col-sm-3 control-label">Para: </h4>
		                    <div class="col-sm-9">
		                        <input type="text" class="form-control" name="txtUserrec" value="<?php echo set_value('txtUserrec'); ?>" placeholder="Username de quem recebe...">
		                        <?php echo form_error('txtUserrec'); ?>
		                    </div>
		                </div>
		                <div class="col-sm-12 form-group">
		                    <h4 for="txtValor" class="col-sm-3 control-label">Valor($): </h4>
		                    <div class="col-sm-9">
		                        <input type="text" class="form-control" name="txtValor" value="<?php echo set_value('txtValor'); ?>" placeholder="Ex: 1000">
		                        <?php echo form_error('txtValor'); ?>
		                    </div>
		                </div>
		            </div>
	          	</div>
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">
				<div class="col-md-6 col-xs-12 text-center">
					<input class="btn btn-success" type="submit" name="btTransferir" value="Transferir Dinheiro" />
				</div>
				<div class="col-md-6 col-xs-12 text-center">
					<a href="<?php echo base_url(); ?>index.php/dash" class="btn btn-warning">Cancelar Transação</a>
				</div>
			</div>
        </div>
    </div>
</div>
<?php } ?>
<?php echo form_close(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#modal-mensagem").modal();
	});
</script>