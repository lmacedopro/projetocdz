<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<div class="row">
    <div class="col-md-12 col-xs-12 text-left">
        <h4><strong>Selecione uma opção</strong></h4>
        <a class="btn btn-default" href="<?php echo base_url(); ?>index.php/trocas/?op=1" title="Selecione esta opção para ver o que os jogadores estão trocando.">Ver Ofertas</a>
        <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/trocas/?op=2" title="Selecione esta opção para ver Suas Trocas.">Minhas Trocas</a>
    </div>
    </div>
<div class="row">&nbsp;</div>
<div class="row" id="trocas">
    <h4><strong>Visualize seus Cavaleiros no Centro de Troca</strong></h4>
    <p>&nbsp;</p>
    <div class="col-md-12 col-xs-12">
        <?php foreach($selcvu as $sc){ ?>
            <div class="row">
                <div class="col-md-12 col-xs-12 loginbox">
                    <div class="col-md-10 col-xs-12">
                        <div class="col-md-6 btn btn-danger">
                            <div class="col-md-3">
                                <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $sc->cvu_cavid; ?>.png" />
                            </div>
                            <div class="col-md-7 small">
                                <span><strong><?php echo ($sc->cvu_apelido != "") ? $sc->cvu_apelido : $sc->cvu_nomecav; ?> - Lv. <?php echo $sc->cvu_level; ?></strong><br />
                                Cls: (<?php echo $sc->cvu_classe ?>) | Tipo: (<?php echo $sc->cvu_tipo ?>)</span>
                            </div>
                            <div class="col-md-2 text-right">
                                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="col-md-6 btn btn-info">
                            <div class="col-md-3">
                                <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $sc->trc_cavid; ?>.png" />
                            </div>
                            <div class="col-md-7 small">
                                <span><strong><?php echo $sc->cav_nome; ?></strong><br />
                                    Cls: (<?php echo $sc->cav_classe ?>) | Tipo: (<?php echo $sc->cav_tipo ?>)</span>
                            </div>
                            <div class="col-md-2 text-right">
                                <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <span class="small"><?php echo $sc->trc_datahora; ?></span><br />
                         <a class="text-danger small" href="<?php echo base_url(); ?>index.php/troca/cancela/?trc=<?php echo $sc->trc_id; ?>" >Cancelar Troca</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>