<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Modal para Alterar os Slots de Tecnicas dos cavaleiros do usuário-->
<div class="modal fade" id="modal-cvutec">
   <div class="modal-dialog">
         <div class="modal-content container-fluid" style="padding: 0.3em">
            <div class="modal-header">
                <h4 class="modal-title">Alteração de Técnica do Cavaleiro
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>
             </div>
             <div class="modal-body" id="cvuteccont">
               
             </div>
         </div>
     </div>
</div>

<!--Modal para mostrar as opcoes de troca de cavaleiros -->
<div class="modal fade" id="modal-formtroca">
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
<?php foreach($cavu as $c){ ?>
<?php 
    #verifica quantas tecnicas tem, se for a unica, não mostra o link de remover
    $ntec = 0;
    $tecs = array($c->cvu_tec1,$c->cvu_tec2,$c->cvu_tec3,$c->cvu_tec4,$c->cvu_tec5);
    for($i=0;$i<5;$i++){
        if($tecs[$i] != 0){
            $ntec ++;
        }
    }
?>
<div class="col-md-12 centered">
    <div class="col-md-12 col-xs-12 page-header text-left">
        <div class="col-md-8 col-xs-8">
            <h3>Personalizando <?php echo $c->cav_nome; ?></h3>
        </div>
        <div class="col-md-4 col-xs-4 text-right">
            <a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/dash/equipe">Voltar á Equipe</a>
            <a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/dash">Voltar á Dashboard</a>
        </div>
    </div>
    <div class="row centered">
        <div class="col-md-12 bordercont">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-12 container-fluid">
                        <img class="img-responsive" src="<?php echo base_url(); ?>public/img/cavs/<?php echo $c->cav_imgright; ?>" width='100%' />
                    </div>
                    <div class="col-md-6 col-xs-12 text-left">
                        <div class="col-md-12 col-xs-12">
                            <h4 class="page-header"><strong>Principal:</strong></h4>
                            <?php echo form_open("dash/equipe/personalize/apelido"); ?>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="txtApelido" class="col-sm-2 text-info control-label">Apelido: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="txtApelido" placeholder="Apelido" value="<?php echo (isset($c->cvu_apelido))? $c->cvu_apelido : set_value('txtApelido'); ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary">OK</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtDesc" class="col-sm-2 text-info control-label">Descrição: </label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control" name="txtDesc" value="<?php echo $c->cav_desc; ?>">
                                        <input type="hidden" readonly class="form-control" name="hdnCvu" value="<?php echo $c->cvu_id; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <h4 class="page-header"><strong>Atributos:</strong></h4>
                            <div class="col-md-12 col-xs-12">
                                <p class="col-md-4 btn btn-info"><strong>LEVEL: </strong><?php echo $c->cvu_level; ?></p>
                                <p class="col-md-4 btn btn-info"><strong>HP: </strong><?php echo $c->cvu_hp; ?> / <?php echo $c->atr_hp; ?></p>
                                <p class="col-md-4 btn btn-info"><strong>ATK: </strong><?php echo $c->atr_atk; ?></p> 
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <p class="col-md-4 btn btn-info"><strong>DEF: </strong><?php echo $c->atr_def; ?></p>
                                <p class="col-md-4 btn btn-info"><strong>SPA: </strong><?php echo $c->atr_spatk; ?></p>
                                <p class="col-md-4 btn btn-info"><strong>SPD: </strong><?php echo $c->atr_spdef; ?></p>
                            </div>
                            <div class="col-md-12 col-xs-12">&nbsp;</div>
                            <span class="col-md-6 col-xs-6 text-left"><strong>EXP: </strong><?php echo $c->cvu_exp; ?></span>
                            <?php if($c->atr_expnext != null){ ?>
                                <span class="col-md-6 col-xs-6 text-right"><strong>Prox. Lvl: </strong><?php echo $c->atr_expnext; ?></span>
                            <?php }else{ ?> 
                                <span class="col-md-6 col-xs-6 text-right"><strong>Prox. Lvl: </strong>Máximo</span>
                            <?php } ?>
                            <div class="col-md-12 col-xs-12">
                                <div class="progress">
                                    <?php if($c->atr_expnext != null){ ?>
                                        <div class="progress-bar progress-bar-striped progress-bar-success active" 
                                             role="progressbar" 
                                             aria-valuenow="<?php echo round(($c->cvu_exp/$c->atr_expnext)*100); ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100" 
                                             style="width: <?php echo round(($c->cvu_exp/$c->atr_expnext)*100); ?>%">
                                        </div>
                                    <?php }else{ ?>
                                        <div class="progress-bar progress-bar-striped progress-bar-success active" 
                                             role="progressbar" 
                                             aria-valuenow="100" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100" 
                                             style="width: 100%">
                                        </div>
                                    <?php } ?>
                                </div> 
                            </div>
                            <span class="col-md-4 col-xs-4 text-left"><strong>Tipo: </strong><?php echo $c->tip_titulo; ?></span>
                            <span class="col-md-4 col-xs-4 text-center"><strong>Classe: </strong><?php echo $c->cls_titulo; ?></span>
                            <span class="col-md-4 col-xs-4 text-right"><strong>Raridade: </strong><?php echo $c->pes_desc; ?></span>
                            <div class="col-md-12 col-xs-12">&nbsp;</div>
                            <h4 class="page-header"><strong>Técnicas:</strong></h4>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <span class="col-md-10 text-left"><strong>Slot 1: </strong>
                                        <?php echo ($c->cvu_tec1 != 0) ? "<span class='text-primary'>".$c->cvu_tec1desc." (PP: ".$c->cvu_tec1pp.")</span><br />" : "<span class='text-danger'>slot vazio</span>"; ?>
                                    </span>
                                    <span class"col-md-1 text-left">
                                        <a href="#" class="text-success" name="Slot[<?php echo $c->cvu_tec1; ?>]" value="1" data-cvu="<?php echo $c->cvu_id; ?>" title="Adicionar/Alterar Técnica de Slot 1">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                    </span>
                                    <?php if(($c->cvu_tec1 != 0) & ($ntec > 1)){ ?>
                                    <span class"col-md-1 text-right">
                                        <a href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/slottec/del/?cvu=<?php echo $c->cvu_id; ?>&slot=1" class="text-danger" title="Remove a Técnica de Slot 1">
                                            &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </a>
                                    </span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <span class="col-md-10"><strong>Slot 2: </strong>
                                        <?php echo ($c->cvu_tec2 != 0) ? "<span class='text-primary'>".$c->cvu_tec2desc." (PP: ".$c->cvu_tec2pp.")</span><br />" : "<span class='text-danger'>slot vazio</span>"; ?>
                                    </span>
                                    <span class"col-md-1">
                                        <a href="#" class="text-success" name="Slot[<?php echo $c->cvu_tec2; ?>]" value="2" data-cvu="<?php echo $c->cvu_id; ?>" title="Adicionar/Alterar Técnica de Slot 2">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                    </span>
                                    <?php if(($c->cvu_tec2 != 0) & ($ntec > 1)){ ?>
                                        <span class"col-md-1 text-right">
                                            <a href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/slottec/del/?cvu=<?php echo $c->cvu_id; ?>&slot=2" class="text-danger" title="Remove a Técnica de Slot 1">
                                                &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <span class="col-md-10"><strong>Slot 3: </strong>
                                        <?php echo ($c->cvu_tec3 != 0) ? "<span class='text-primary'>".$c->cvu_tec3desc." (PP: ".$c->cvu_tec3pp.")</span><br />" : "<span class='text-danger'>slot vazio</span>"; ?>
                                    </span>
                                    <span class"col-md-1">
                                        <a href="#" class="text-success" name="Slot[<?php echo $c->cvu_tec3; ?>]" value="3" data-cvu="<?php echo $c->cvu_id; ?>" title="Adicionar/Alterar Técnica de Slot 3">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                    </span>
                                    <?php if(($c->cvu_tec3 != 0) & ($ntec > 1)){ ?>
                                        <span class"col-md-1 text-right">
                                            <a href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/slottec/del/?cvu=<?php echo $c->cvu_id; ?>&slot=3" class="text-danger" title="Remove a Técnica de Slot 1">
                                                &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <span class="col-md-10"><strong>Slot 4: </strong>
                                        <?php echo ($c->cvu_tec4 != 0) ? "<span class='text-primary'>".$c->cvu_tec4desc." (PP: ".$c->cvu_tec4pp.")</span><br />" : "<span class='text-danger'>slot vazio</span>"; ?>
                                    </span>
                                    <span class"col-md-1">
                                        <a href="#" class="text-success" name="Slot[<?php echo $c->cvu_tec4; ?>]" value="4" data-cvu="<?php echo $c->cvu_id; ?>" title="Adicionar/Alterar Técnica de Slot 4">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                    </span>
                                    <?php if(($c->cvu_tec4 != 0) & ($ntec > 1)){ ?>
                                        <span class"col-md-1 text-right">
                                            <a href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/slottec/del/?cvu=<?php echo $c->cvu_id; ?>&slot=4" class="text-danger" title="Remove a Técnica de Slot 1">
                                                &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <span class="col-md-10"><strong>Slot 5: </strong>
                                        <?php echo ($c->cvu_tec5 != 0) ? "<span class='text-primary'>".$c->cvu_tec1desc." (PP: ".$c->cvu_tec1pp.")</span>" : "<span class='text-danger'>slot vazio</span>"; ?>
                                    </span>
                                    <span class"col-md-1">
                                        <a href="#" type="button" class="text-success" name="Slot[<?php echo $c->cvu_tec5; ?>]" value="5" data-cvu="<?php echo $c->cvu_id; ?>" title="Adicionar/Alterar Técnica de Slot 5">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                    </span>
                                    <?php if(($c->cvu_tec5 != 0) & ($ntec > 1)){ ?>
                                        <span class"col-md-1 text-right">
                                            <a href="<?php echo base_url(); ?>index.php/dash/equipe/personalize/slottec/del/?cvu=<?php echo $c->cvu_id; ?>&slot=5" class="text-danger" title="Remove a Técnica de Slot 1">
                                                &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12">&nbsp;</div>
                            <h4 class="page-header"><strong>Item Equipado:</strong></h4>
                            <h4 class="page-header"><strong>Evoluções:</strong></h4> 
                            <?php if(($c->cvu_lineup == 0) & ($troca == null)){ ?>
                                <h4 class="page-header"><strong>Trocar Cavaleiro:</strong></h4>
                                <button id="btnseltroca" class="btn btn-danger" value="<?php echo $c->cvu_id; ?>" data-cls="<?php echo $c->cls_id; ?>" >Adicionar à Central de Trocas</button>
                            <?php }else{ ?>
                                <h4 class="page-header"><strong>Trocar Cavaleiro:</strong></h4>
                                <a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/trocas/?op=2" >Ir à Central de Trocas</a>                          
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
