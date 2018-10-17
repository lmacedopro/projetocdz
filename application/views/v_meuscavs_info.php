<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php foreach($cavinfo as $ci){ ?>
<div class="row">
	<div class="col-md-12 col-xs-12 bordercont">
		<div class="col-md-12 col-xs-12">
			<div class="col-md-6 col-xs-12">
				<h4 class="text-info"><strong><?php echo $ci->cav_nome; ?></strong></h4>
				<span><?php echo ($ci->cvu_apelido != "") ? $ci->cvu_apelido : "Sem Apelido."; ?></span>
			</div>
			<div class="col-md-6 col-xs-12 text-left">
				<a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/?cvu=<?php echo $ci->cvu_id; ?>" title="Personalize golpes, apelidos e itens do cavaleiro">Personalizar</a>
				<?php if($troca == null){ ?>
					<?php if($ci->cvu_lineup == 1){ ?>
						<?php if($qtdln > 1){ ?>
							<a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/lineup/remove/?cvu=<?php echo $ci->cvu_id; ?>" title="Remover o Cavaleiro do Lineup">Remover do Lineup</a>
						<?php } ?>
					<?php }elseif($qtdln <= 6){ ?> 
						<a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/lineup/add/?cvu=<?php echo $ci->cvu_id; ?>" title="Adiciona o Cavaleiro do Lineup">Adicionar ao Lineup</a>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		
		<div class="col-md-6 container-fluid">
			<img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $ci->cav_imgright; ?>" width='100%' />
			<p class="text-justify"><strong>Descrição: </strong><?php echo $ci->cav_desc; ?></p>
			<p class="text-justify">
				<strong>Evolução: </strong>(proxima evo) [btn_evoluir] (se tiver mais de uma, listar)
			</p>
		</div>
		<div class="col-md-6 container-fluid small text-left">
			<p><strong>Level: </strong><?php echo $ci->cvu_level; ?></p>
			<p>
				<strong>Atributos: </strong><br />
				 HP: <?php echo $ci->cvu_hp; ?>/<?php echo $ci->atr_hp; ?>
				ATK: <?php echo $ci->atr_atk; ?> 
				DEF: <?php echo $ci->atr_def; ?>
				SPA: <?php echo $ci->atr_spatk; ?>
				SPD: <?php echo $ci->atr_spdef; ?>
			</p>
			<p>
				<strong>Exp: </strong><?php echo $ci->cvu_exp; ?><br />
			   	<span class="text-success"><strong>Prox. Lvl: </strong><?php echo $ci->atr_expnext; ?></span>
			</p>
			
			<p>
				<strong>Tipo: </strong> - 
				<strong>Classe: </strong><?php echo $ci->cls_titulo; ?>
			</p>
			<?php foreach($raridade as $r){ ?>
				<p><strong>Raridade: </strong><?php echo $r->pes_desc; ?></p>
			<?php } ?>
			<p>
				<strong>Técnicas: </strong><br />
				<div class="col-md-12 col-xs-12  text-left">
					<?php 

						echo ($ci->cvu_tec1 != 0) ? "<span class='text-primary'>".$ci->cvu_tec1desc." (PP: ".$ci->cvu_tec1pp.")</span><br />" : "<span class='text-danger'>slot vazio</span><br />";
						echo ($ci->cvu_tec2 != 0) ? "<span class='text-primary'>".$ci->cvu_tec2desc." (PP: ".$ci->cvu_tec2pp.")</span><br />" : "<span class='text-danger'>slot vazio</span><br />";
						echo ($ci->cvu_tec3 != 0) ? "<span class='text-primary'>".$ci->cvu_tec3desc." (PP: ".$ci->cvu_tec3pp.")</span><br />" : "<span class='text-danger'>slot vazio</span><br />";
						echo ($ci->cvu_tec4 != 0) ? "<span class='text-primary'>".$ci->cvu_tec4desc." (PP: ".$ci->cvu_tec4pp.")</span><br />" : "<span class='text-danger'>slot vazio</span><br />";
						echo ($ci->cvu_tec5 != 0) ? "<span class='text-primary'>".$ci->cvu_tec1desc." (PP: ".$ci->cvu_tec1pp.")</span>" : "<span class='text-danger'>slot vazio</span>";
					?>
				</div>
			</p>
			<p>&nbsp;</p>
			<p>
				<strong>Item Equip: </strong>1 slot. selecionar itens de equip para equipar.
			</p>
			<?php if($troca != null){ ?>
				<p class="text-danger">
					<strong><a class="text-danger" href="<?php echo base_url(); ?>index.php/trocas/?op=2" title="Clique para ir a Central de Trocas">Cavaleiro está na Central de Trocas</a></strong>
				</p>
			<?php } ?>						
		</div>
		
	</div>
</div>

<?php } ?>


