<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="col-md-12 col-xs-12">
            <p class="text-left">1. Selecione seu Cavaleiro para Trocar:</p>
            <div class="col-md-12" style="height: 10em; overflow-y: scroll;">
                <?php foreach($troca as $t){ ?>
                    <?php foreach($listacvu as $lc){ ?>
                        <div class="col-md-12 showitem">
                            <div class="col-md-2">
                                <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $lc->cav_id; ?>.png" />
                            </div>
                            <div class="col-md-8 text-left">
                                <strong><?php echo ($lc->cvu_apelido != "") ? $lc->cvu_apelido : $lc->cav_nome; ?></strong> | Lv: (<?php echo $lc->cvu_level; ?>) | Cls: (<?php echo $lc->cls_titulo ?>) | Tip: (<?php echo $lc->tip_titulo ?>)
                            </div>
                            <div class="btcav col-md-2 text-right">
                                <?php echo form_open("troca/ofertas/acc"); ?>
                                    <input type="hidden" name="hdnTrcid" value="<?php echo $t->trc_id; ?>" />
                                    <input type="hidden" name="hdnOldcvuid" value="<?php echo $t->trc_cvuid; ?>" />
                                    <input type="hidden" name="hdnOldusuid" value="<?php echo $t->trc_usuid; ?>" />
                                    <input type="hidden" name="hdnNewcvuid" value="<?php echo $lc->cvu_id; ?>" />
                                    <input type="hidden" name="hdnNewusuid" value="<?php echo $lc->usu_id; ?>" />
                                    <input type="submit" class="btn btn-info"  value="Trocar">
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
