<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--Modal para mostrar as opcoes de troca de cavaleiros -->
<div class="modal fade" id="modal-accoferta">
   <div class="modal-dialog">
         <div class="modal-content container-fluid" style="padding: 0.3em">
            <div class="modal-header">
                <h4 class="modal-title">Troca de Cavaleiro
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>
             </div>
             <div class="modal-body" id="cvuseltroca">
               
             </div>
         </div>
     </div>
</div>

<!DOCTYPE html>

<div class="row">
    <div class="col-md-12 col-xs-12 text-left">
        <h4><strong>Selecione uma opção</strong></h4>
        <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/trocas/?op=1" title="Selecione esta opção para ver o que os jogadores estão trocando.">Ver Ofertas</a>
        <a class="btn btn-default" href="<?php echo base_url(); ?>index.php/trocas/?op=2" title="Selecione esta opção para ver Suas Trocas.">Minhas Trocas</a>
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row" id="ofertas">
    <div class="col-md-12 col-xs-12">
        <h4><strong>Visualize Ofertas de trocas de cavaleiros</strong></h4>
        <p>&nbsp;</p>
        <?php foreach($trocasok as $t){ ?>
            <div class="row">
                <div class="col-md-12 col-xs-12 loginbox">
                    <div class="col-md-2 col-xs-12">
                        <p><strong><?php echo $t->usu_username; ?></strong><br /><span class="small"><?php echo $t->trc_datahora; ?></span></p>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="col-md-12 col-xs-12">
                            <div class="col-md-6 btn btn-danger">
                                <div class="col-md-3">
                                    <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $t->cvu_cavid; ?>.png" />
                                </div>
                                <div class="col-md-7 small">
                                    <span><strong><?php echo ($t->cvu_apelido != "") ? $t->cvu_apelido : $t->cvu_nomecav; ?> - Lv. <?php echo $t->cvu_level; ?></strong><br />
                                    Cls: (<?php echo $t->cvu_classe ?>) | Tipo: (<?php echo $t->cvu_tipo ?>)</span>
                                </div>
                                <div class="col-md-2 text-right">
                                    <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-md-6 btn btn-info">
                                <div class="col-md-3">
                                    <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $t->trc_cavid; ?>.png" />
                                </div>
                                <div class="col-md-7 small">
                                    <span><strong><?php echo $t->cav_nome; ?></strong><br />
                                        Cls: (<?php echo $t->cav_classe ?>) | Tipo: (<?php echo $t->cav_tipo ?>)</span>
                                </div>
                                <div class="col-md-2 text-right">
                                    <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <button name="btnaccoferta[<?php echo $t->trc_id; ?>]" class="btn btn-danger" value="<?php echo $t->trc_id; ?>" >Trocar</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>