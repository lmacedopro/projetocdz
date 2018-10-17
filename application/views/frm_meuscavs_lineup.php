<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<script src="<?php echo base_url(); ?>/public/js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		//Pega o valor da url da pagina
	    var protocol = window.location.protocol.toString();
	    var host = window.location.host.toString();
	    var pathname = window.location.pathname.toString();
	    var pathpart = pathname.split('/');

	    var base_url = protocol+"//"+host+"/"+pathpart[1]+"/"+pathpart[2]+"/"; //URL de BASE DO SITE
		
		var novaordem = [];
		var datapost = [];
		$("a[name='btLineup']").click(function(){
			

			var cvu = $(this).attr("value");
			//alert(typeof($(this).attr("disabled")));
			if(typeof($(this).attr("disabled")) === "undefined"){

				novaordem.push(cvu);
				$(this).attr("disabled","disabled");

				var novabadge = parseInt(novaordem.indexOf(cvu)) + 1;
				//var htmlalt = html.find("span").html(novabadge);
				var html = "<div id='"+cvu+"' class='col-md-12 col-xs-12 btn btn-default'>"+$(this).html();+"</div>";
				//alert(html);
				$("#novaordem").append(html);
				$("#"+cvu).find("span").html(novabadge);

				$("#hdnOrdem").val(novaordem);
			}
		});
	});
</script>
<div class="row">
	<p class="text-primary">Clique no Cavaleiro na ordem em que deseja, depois finalize clicando em "Finalizar".</p>
	<div class="col-md-12 col-xs-12 bordercont">
		<div class="row">
			<div class="col-md-6 col-xs-6">
				<h4>Seu Lineup Atual</h4>
				<?php foreach($lineup as $l){ ?>
	            	<a href="#" name="btLineup" value="<?php echo $l->cvu_id; ?>" data-ord="<?php echo $l->cvu_ordem; ?>" class="col-md-12 col-xs-12 btn btn-default">
	            		<div class="col-md-10"> 
	            			<img src="<?php echo base_url(); ?>public/img/cavs/<?php echo $l->cav_id; ?>.png" style="width: 99%;" ><br />
							<b><?php echo ($l->cvu_apelido != "")? $l->cvu_apelido : $l->cav_nome; ?></b><br />
	            		</div>
	            		<div class="col-md-2">
		            		<span class="badge"><?php echo $l->cvu_ordem; ?></span>
	            		</div>
	            	</a>	
	            <?php } ?>
			</div>
			<div class="col-md-6 col-xs-6">
				<h4>Nova ordem do Lineup</h4>
				<div id="novaordem"></div>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<?php echo form_open("dash/equipe/mudar/post"); ?>
					<input type="hidden" name="hdnOrdem" id="hdnOrdem" value="">
					<button id="btFinalizar" class="btn btn-success">Finalizar</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>