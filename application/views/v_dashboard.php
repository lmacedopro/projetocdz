<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Modal para Explorar opções dos cavaleiros-->
<div class="modal fade" id="modal-cavextra">
   <div class="modal-dialog">
         <div class="modal-content container-fluid" style="padding: 0.3em">
            <div class="modal-header">
				<h4 class="modal-title">Informações de Cavaleiro
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</h4>
             </div>
             <div class="modal-body" id="cavcont">
               
             </div>
         </div>
     </div>
</div>

<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<?php foreach($user as $u){ ?>
<div class="col-md-12 centered">
    <div class="page-header text-left">
        <h3>Dashboard</h3>
    </div>
    <div class="row centered">
        <div class="col-md-3 bordercont">
            <p><img src="<?php echo base_url();?>public/img/avatar/<?php echo $u->usu_avatar; ?>.png" ><br />
                <b>Username:</b> <?php echo $u->usu_username; ?><br />
                <b>Guild:</b> <?php echo "Não definida"; ?><br />
                <b>Power:</b> <?php echo $u->usu_pwr; ?><br />
                <b>Dinheiro: $</b> <?php echo $u->usu_money; ?><br />
                <b>Vitórias/Derrotas:</b> <?php echo $u->usu_vitorias; ?> / <?php echo $u->usu_derrotas; ?><br />
                <b>Ranking:</b> <?php echo $u->usu_rank; ?><br />
                <b>Total Cavs:</b> <?php echo ""; #Total de cavaleiros ?></p>
        </div>
        <div class="col-md-4 bordercont">Conquistas</div>
        <div class="col-md-5 bordercont container-fluid">
			<h4><strong>Itens</strong></h4>
			<div class="col-md-12 col-xs-12 text-center" style="height: 18em; overflow-y: scroll;">
				<?php foreach($itens as $i){ ?>
					<div class="row showitem" title="<?php echo $i->itm_desc; ?>">
						<div class="col-md-3">
							<img class="img-responsive" src="<?php echo base_url(); ?>public/img/itens/<?php echo $i->itm_img; ?>" />
						</div>
						<div class="col-md-9 text-left">
							<strong><?php echo $i->itm_nome; ?></strong> x (<?php echo $i->usi_qtde; ?>)
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row centered">
        <div class="col-md-12 col-xs-12 bordercont container-fluid">
            <h4><strong>Equipe de Batalha</strong></h4>
            <div class="row">
            <?php foreach($cavsu as $c){ ?>
			<div class="col-md-2 col-xs-6 text-center">
				<?php if($c->cvu_hp > 0) { ?>
					<p class="btn btn-success btcav" value="<?php echo $c->cvu_id; ?>">
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $c->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($c->cvu_apelido != "")? $c->cvu_apelido : $c->cav_nome; ?></b><br />
						<b>Level: <?php echo $c->cvu_level; ?></b><br />
						<?php echo "HP: ".$c->cvu_hp." / ".$c->atr_hp; ?>
					</p>
				<?php }else{ ?>
					<p class="btn btn-danger btcav" value="<?php echo $c->cvu_id; ?>">
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $c->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($c->cvu_apelido != "")? $c->cvu_apelido : $c->cav_nome; ?></b><br />
						<b>Level: <?php echo $c->cvu_level; ?></b><br />
						<?php echo "HP: ".$c->cvu_hp." / ".$c->atr_hp; ?>
					</p>
				<?php } ?>
            </div>
            <?php } ?>
            </div>
            <div class="row">
				<div class="col-md-12 col-xs-12">&nbsp;</div>
				<div class="col-md-12 col-xs-12">
					<a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/dash/equipe">Gerenciar Meus Cavaleiros</a>
				</div>
            </div>
        </div>
    </div>
</div>
<?php } ?>