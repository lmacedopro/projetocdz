<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	
	//Parte de codigo destinada a realizar o efeito de Cura durante a batalha
	$oponentef = $this->session->userdata("btl_oponent_status");

?>
<?php if($oponentef["efeito"] == 1){ ?>
<div class="modal fade" id="modal-mensagem">
   <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title">Escolha um Cavaleiro para Curar</h4>
             </div>
             <div class="modal-body">
                <?php foreach($this->session->userdata('btl_lineup') as $lnu){ ?>
					<?php if(porcentagem($lnu->cvu_hp,$lnu->atr_hp) > 80) { ?>
						<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/batalha/efcura?pt=<?php echo $oponentef["efcura"]; ?>&cvu=<?php echo $lnu->cvu_id; ?>" >
							<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
							<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
							<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
						</a>
					<?php }elseif((porcentagem($lnu->cvu_hp,$lnu->atr_hp) <= 80) & (porcentagem($lnu->cvu_hp,$lnu->atr_hp) >= 30)){ ?>
						<a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/batalha/efcura?pt=<?php echo $oponentef["efcura"]; ?>&cvu=<?php echo $lnu->cvu_id; ?>" >
							<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
							<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
							<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
						</a>
					<?php }else{ ?>
						<a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/batalha/efcura?pt=<?php echo $oponentef["efcura"]; ?>&cvu=<?php echo $lnu->cvu_id; ?>" >
							<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
							<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
							<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
						</a>
					<?php } ?>
				<?php } ?>
             </div>
         </div>
     </div>
</div>
<?php } ?>

<!--Modal para selecao de itens de batalha-->
<div class="modal fade" id="modal-itens">
   <div class="modal-dialog">
         <div class="modal-content container-fluid" style="padding: 0.3em">
            <div class="modal-header">
				<h4 class="modal-title">Itens do Usuário
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</h4>
             </div>
             <div class="modal-body">
                <div class="col-md-12 col-xs-12 text-center" style="height: 18em; overflow-y: scroll;">
					<?php foreach($itens as $i){ ?>
						<div class="row showitem" title="<?php echo $i->itm_desc; ?>">
							<div class="col-md-2">
								<img class="img-responsive" src="<?php echo base_url(); ?>public/img/itens/<?php echo $i->itm_img; ?>" />
							</div>
							<div class="col-md-8 text-left">
								<strong><?php echo $i->itm_nome; ?></strong> x (<?php echo $i->usi_qtde; ?>)
							</div>
							<div class="col-md-2 text-right">
								<a class="btn btn-info btitens" href="<?php echo base_url(); ?>index.php/batalha?op=use&itm=<?php echo $i->itm_id; ?>" >Usar</a>
							</div>
						</div>
					<?php } ?>
				</div>
             </div>
         </div>
     </div>
</div>
<!DOCTYPE html>

<?php foreach($this->session->userdata('btl_oponent') as $opo){ ?>
<?php foreach($this->session->userdata('btl_oponent_cur') as $opoc){ ?>
<div class="col-md-12 col-xs-12 centered">
    <div class="page-header text-left">
        <h3>Batalha Contra <?php echo $opo->cav_nome; ?> !!!</h3>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 bordercont">
            <div class="col-md-4 col-xs-5">
                <?php foreach($this->session->userdata('btl_usercav') as $ucav){ ?>
                <?php foreach($this->session->userdata('btl_usercav_cur') as $ucavc){ ?>
                    <h5>
                    <strong><?php echo (empty($ucav->cvu_apelido)) ? $ucav->cav_nome : $ucav->cvu_apelido; ?></strong><br />
                    Level: <?php echo $ucav->cvu_level; ?>
                </h5>
                <img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $ucav->cav_imgright;?>" class="img-responsive" alt="" />
                <strong>HP: <?php echo $ucavc->cvu_hp; ?> / <?php echo $ucavc->atr_hp; ?></strong><div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-danger active" 
                         role="progressbar" 
                         aria-valuenow="<?php echo round(($ucavc->cvu_hp/$ucav->cvu_hp)*100); ?>" 
                         aria-valuemin="0" 
                         aria-valuemax="100" 
                         style="width: <?php echo round(($ucavc->cvu_hp/$ucavc->atr_hp)*100); ?>%"></div>
                </div> 
                <?php } ?>
                <?php } ?>
            </div>
            <div class="col-md-4 col-xs-2">&nbsp;</div>
            <div class="col-md-4 col-xs-5">
                <h5>
                    <strong><?php echo $opo->cav_nome; ?></strong><br />
                    Level: <?php echo $opo->atr_level; ?>
                </h5>
                <img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $opo->cav_imgleft;?>" class="img-responsive" alt="" />
                <strong>HP: <?php echo $opoc->atr_hp; ?> / <?php echo $opo->atr_hp; ?></strong><div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-danger active" 
                         role="progressbar" 
                         aria-valuenow="<?php echo round(($opoc->atr_hp/$opo->atr_hp)*100); ?>" 
                         aria-valuemin="0" 
                         aria-valuemax="100" 
                         style="width: <?php echo round(($opoc->atr_hp/$opo->atr_hp)*100); ?>%"></div>
                </div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 bordercont text-center" style="height: 6.5em; overflow-y: scroll; background: #FFF;">
            <?php echo $this->session->userdata("btl_log"); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 bordercont text-center">
			<div class="col-md-8 col-xs-12 text-left">
				<h5><strong>Técnicas do Cavaleiro</strong></h5>
				<?php if($ucavc->cvu_tec1 != 0){ ?>
					<a class="btn btn-primary bttec" href="<?php echo base_url(); ?>index.php/batalha?op=atk&slot=cvu_tec1pp&tec=<?php echo $ucavc->cvu_tec1; ?>">
						<?php echo $ucavc->cvu_tec1desc; ?><br /><?php echo "PP: ".$ucavc->cvu_tec1pp; ?>
					</a>
				<?php } ?>
				<?php if($ucavc->cvu_tec2 != 0){ ?>
					<a class="btn btn-primary bttec" href="<?php echo base_url(); ?>index.php/batalha?op=atk&slot=cvu_tec2pp&tec=<?php echo $ucavc->cvu_tec2; ?>">
						<?php echo $ucavc->cvu_tec2desc; ?><br /><?php echo "PP: ".$ucavc->cvu_tec2pp; ?>
					</a>
				<?php } ?>
				<?php if($ucavc->cvu_tec3 != 0){ ?>
					<a class="btn btn-primary bttec" href="<?php echo base_url(); ?>index.php/batalha?op=atk&slot=cvu_tec3pp&tec=<?php echo $ucavc->cvu_tec3; ?>">
						<?php echo $ucavc->cvu_tec3desc; ?><br /><?php echo "PP: ".$ucavc->cvu_tec3pp; ?>
					</a>
				<?php } ?>
				<?php if($ucavc->cvu_tec4 != 0){ ?>
					<a class="btn btn-primary bttec" href="<?php echo base_url(); ?>index.php/batalha?op=atk&slot=cvu_tec4pp&tec=<?php echo $ucavc->cvu_tec4; ?>">
						<?php echo $ucavc->cvu_tec4desc; ?><br /><?php echo "PP: ".$ucavc->cvu_tec4pp; ?>
					</a>
				<?php } ?>
				<?php if($ucavc->cvu_tec5 != 0){ ?>
					<a class="btn btn-primary bttec" href="<?php echo base_url(); ?>index.php/batalha?op=atk&slot=cvu_tec5pp&tec=<?php echo $ucavc->cvu_tec5; ?>">
						<?php echo $ucavc->cvu_tec5desc; ?><br /><?php echo "PP: ".$ucavc->cvu_tec5pp; ?>
					</a>
				<?php } ?> 
			</div>
			<div class="col-md-4 col-xs-12 text-right">
				<h5 class="text-right"><strong>Itens e Opções</strong></h5>
				<input type="button" class="btn btn-warning" name="btItemuse" id="btItemuse" value="Usar Item" />
				<a class="btn btn-warning" href="<?php echo base_url(); ?>/index.php/batalha?op=run">Desistir da Luta</a>
			</div>
        </div> 
    </div>
    <div class="row">&nbsp;</div>
    <div class="row">
        <div class="col-md-12 col-xs-12 bordercont">
            <h4><strong>Sua Equipe</strong></h4>
            <?php foreach($this->session->userdata('btl_lineup') as $lnu){ ?>
            <div class="col-md-2 col-xs-2 text-center">
				<?php if(porcentagem($lnu->cvu_hp,$lnu->atr_hp) > 80) { ?>
					<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/batalha?op=alt&cvu=<?php echo $lnu->cvu_id; ?>" >
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
						<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
					</a>
				<?php }elseif((porcentagem($lnu->cvu_hp,$lnu->atr_hp) <= 80) & (porcentagem($lnu->cvu_hp,$lnu->atr_hp) >= 30)){ ?>
					<a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/batalha?op=alt&cvu=<?php echo $lnu->cvu_id; ?>" >
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
						<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
					</a>
				<?php }elseif(porcentagem($lnu->cvu_hp,$lnu->atr_hp) < 30 & $lnu->cvu_hp > 0){ ?>
					<a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/batalha?op=alt&cvu=<?php echo $lnu->cvu_id; ?>" >
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
						<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
					</a>
				<?php }else{ ?>
					<a class="btn btn-danger" href="#" >
						<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lnu->cav_id; ?>.png" style="width: 99%;" ><br />
						<b><?php echo ($lnu->cvu_apelido != "")? $lnu->cvu_apelido : $lnu->cav_nome; ?></b><br />
						<?php echo "HP: ".$lnu->cvu_hp." / ".$lnu->atr_hp; ?>
					</a>
				<?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
<?php } ?>
<script src="<?php echo base_url(); ?>/public/js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#modal-mensagem").modal();
	});
</script>
