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

<div class="col-md-12 centered">
    <div class="page-header text-left">
        <h3>Gerenciar Meus Cavaleiros</h3>
    </div>
    <div class="row centered">
        <div class="col-md-12 bordercont">
            <h4><strong>Sua Equipe de Batalha</strong></h4>
            <div class="row">
                <?php foreach($cavsu as $c){ ?>
                <div class="col-md-2 text-center">
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
			<div class="row">&nbsp;</div>
            <div class="row centered">
                <button class="btn btn-warning" id="btMudar">Mudar Ordem da Equipe</button>
            </div>
            <div class="row">&nbsp;</div>
            <h4><strong>Todos seus Cavaleiros Recrutados</strong></h4>
            <div class="row">
                <div class="col-md-12 col-xs-12">
					<?php foreach($cavsall as $cv){ ?>
						<div class="col-md-2 text-center">
							<p class="btn btn-info btcav" value="<?php echo $cv->cvu_id; ?>">
								<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $cv->cav_id; ?>.png" style="width: 99%;" ><br />
								<b><?php echo ($cv->cvu_apelido != "")? $cv->cvu_apelido : $cv->cav_nome; ?></b><br />
								<b>Level: <?php echo $cv->cvu_level; ?></b><br />
								<?php echo "HP: ".$cv->cvu_hp." / ".$cv->atr_hp; ?>
							</p>
						</div>
					<?php } ?>
				</div>
            </div>
        </div>
    </div>
</div>
