<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="<?php echo base_url(); ?>/public/js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $("button[name^='btselcav']").click(function(){

            var cavid = $(this).attr("value");
            $("#hdnCavid").val(cavid);

            //$("button[name^='btselcav']").prop("disabled","disabled");


            var html = $(".showitem").html();

            $("#resumo").html(html);
            $("div#resumo button").remove();
            $("div#resumo").addClass("btn");
            $("div#resumo").addClass("btn-danger");

            $("button[name^='btselcav']").prop("disabled","disabled");
;        });
    });
</script>

<!DOCTYPE html>

<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="col-md-12 col-xs-12">
            <p class="text-left">1. Selecione o Cavaleiro Desejado:</p>
            <div class="col-md-12" style="height: 10em; overflow-y: scroll;">
                <?php foreach($selcav as $ca){ ?>
                    <div class="col-md-12 showitem" title="<?php echo $ca->cav_desc; ?>">
                        <div class="col-md-2">
                            <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $ca->cav_id; ?>.png" />
                        </div>
                        <div class="col-md-8 text-left">
                            <strong><?php echo $ca->cav_nome; ?></strong> | Cls: (<?php echo $ca->cls_titulo ?>) | Tip: (<?php echo $ca->tip_titulo ?>)
                        </div>
                        <div class="btcav col-md-2 text-right">
                            <button name="btselcav[<?php echo $ca->cav_id; ?>]" class="btn btn-info btn-sm" value="<?php echo $ca->cav_id; ?>" >Selecionar</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row">&nbsp;</div>
<?php foreach($selcvu as $sc){ ?>
<?php echo form_open("troca/novatroca/do"); ?>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <p class="text-left">3. Verifique e Confirme sua Troca</p>
        <div class-"col-md-12 col-xs-12">
            <p class="text-success text-left"><strong>Seu Cavaleiro: </strong></p>
                <div class="col-md-12 btn btn-success" title="<?php echo $sc->cav_desc; ?>">
                    <div class="col-md-2">
                        <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $sc->cav_id; ?>.png" />
                    </div>
                    <div class="col-md-8 text-left">
                        <strong><?php echo ($sc->cvu_apelido != "") ? $sc->cvu_apelido : $sc->cav_nome; ?></strong> | Cls: (<?php echo $sc->cls_titulo; ?>) | Lvl: (<?php echo $sc->cvu_level ?>)
                    </div>
                </div>
                <input type="hidden" name="hdnCvuid" value="<?php echo $sc->cvu_id; ?>" />
                <input type="hidden" name="hdnCvuLevel" value="<?php echo $sc->cvu_level; ?>" />
        </div>
        <div class-"col-md-12 col-xs-12">&nbsp;</div>
        <div class-"col-md-12 col-xs-12">
            <p class="text-danger text-left"><strong>Cavaleiro Selecionado: </strong></p>
            <div id="resumo" class="col-md-12 col-xs-12"></div>
            <input type="hidden" name="hdnCavid" id="hdnCavid" value="" />
        </div>
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">
    <div class="col-md-12 col-xs-12">   
        <input type="submit" class="btn btn-success" value="Confirmar Troca">    
        <a href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/?=<?php echo $sc->cvu_id; ?>" class="btn btn-danger">Cancelar</a>
    </div>
</div>
<?php } ?>
<?php echo form_close(); ?>
