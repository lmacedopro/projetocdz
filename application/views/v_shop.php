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

<?php echo form_open("shop/comprar"); ?>
<?php foreach($user as $u){ ?>
<div class="col-md-12 com-xs-12 centered">
    <div class="page-header text-left">
        <h3>Item Shop</h3>
    </div>
    <div class="row centered">
        <div class="col-md-12 col-xs-12 bordercont">
            Lista de itens para o usuario comprar com dinheiro do jogo.
        </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row centered">
        <div class="col-md-12 col-xs-12 bordercont">
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<h4>Usuario: <span class="text-success"><?php echo $u->usu_username; ?></span><?php echo nbs(3); ?>Dinheiro: $ <?php echo $u->usu_money; ?></h4></div>
				<div class="col-md-2 col-xs-12">&nbsp;</div>
				<div class="col-md-4 col-xs-12">
					<h4>Total da Compra: $ <em name="totalcompra">0</em></h4>
					<input type="hidden" name="hdnTotalcompra" />
				</div>
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<?php foreach($itens as $i){ ?>
						<div class="col-md-4 col-xs-6 text-center btn btn-default" title="<?php echo $i->itm_desc; ?>">
							<div class="row">
								<div class="col-md-3">
									<img class="img-responsive" src="<?php echo base_url(); ?>public/img/itens/<?php echo $i->itm_img; ?>" />
								</div>
								<div class="col-md-8 text-left">
									<strong><?php echo $i->itm_nome; ?></strong><br />
									Preço: $ <?php echo $i->itm_valor; ?><br />
									Add: <select name="selQtd[<?php echo $i->itm_id; ?>]" data-item="<?php echo $i->itm_id; ?>" data-preco="<?php echo $i->itm_valor; ?>">
									<option value="0" data-preco="0">0</option>
									<?php for($i=1;$i<=10;$i++){ ?>
										<option value="<?php echo $i; ?>"><?php echo $i;?></option>
									<?php } ?>
									</select>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">
				<div class="col-md-6 col-xs-12 text-center">
					<input class="btn btn-success" type="submit" name="btComprar" value="Comprar Itens" />
				</div>
				<div class="col-md-6 col-xs-12 text-center">
					<a href="<?php echo base_url(); ?>index.php/dash" class="btn btn-warning">Cancelar Compra</a>
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