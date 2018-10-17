<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<?php foreach($user as $u){ ?>
<div class="col-md-12 centered">
    <div class="page-header text-left">
        <h3>Perfil de <?php echo $this->session->userdata("username"); ?></h3>
    </div>
    <div class="row centered">
        <div class="col-md-12 bordercont">
            <div class="col-md-6">
                <!-- Inicio do formulario de alteração do avatar o usuario -->
                <?php echo form_open('user/avatar/update/do'); ?>
                <div class="row">
                    <h4><strong>Seu Avatar</strong></h4>
                    <div class="col-md-6">
                        <p><strong>Avatar Atual</strong></p>
                        <img src="<?php echo base_url(); ?>public/img/avatar/<?php echo $u->usu_avatar; ?>.png" >
                    </div>
                    <div class="col-md-6">
                        <p class="text-danger"><strong>Novo Avatar</strong></p>
                        <center><span id="showavatar"></span></center>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-group" role="group" aria-label="..." id="btavatar">
                                <button type="button" class="btn btn-warning" id="01">A 01</button>
                                <button type="button" class="btn btn-warning" id="02">A 02</button>
                                <button type="button" class="btn btn-warning" id="03">A 03</button>
                                <button type="button" class="btn btn-warning" id="04">A 04</button>
                                <br />
                                <button type="button" class="btn btn-warning" id="05">A 05</button>
                                <button type="button" class="btn btn-warning" id="06">A 06</button>
                                <button type="button" class="btn btn-warning" id="07">A 07</button>
                                <button type="button" class="btn btn-warning" id="08">A 08</button>
                                <br />
                                <button type="button" class="btn btn-warning" id="09">A 09</button>
                                <button type="button" class="btn btn-warning" id="10">A 10</button>
                                <button type="button" class="btn btn-warning" id="11">A 11</button>
                                <button type="button" class="btn btn-warning" id="12">A 12</button>
                                <br />
                                <input type="hidden" class="form-control" value="<?php echo set_value('hdnAvatar'); ?>" name="hdnAvatar" id="hdnAvatar" placeholder="">
                                <?php echo form_error("hdnAvatar"); ?>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p><button type="submit" class="btn btn-primary">Alterar Avatar</button></p>
                </div>
                <?php echo form_close(); ?>
                <!-- Fim do formulario de alteração do avatar o usuario -->
            </div>
            <div class="col-md-6 text-justify">
                <?php echo form_open("user/info/update/do"); ?>
                <div class="row">
                    <h4 class="text-center"><strong>Informações de Conta</strong></h4>
                    <div class="form-group form-horizontal">
                        <label for="txtNome">Nome Completo:</label>
                        <input type="text" class="form-control" 
                               value="<?php echo (isset($u->usu_nome))? $u->usu_nome : set_value('txtNome'); ?>" 
                               name="txtNome" placeholder="João da Silva">
                        <?php echo form_error("txtNome"); ?>
                    </div>
                    <div class="form-group form-horizontal">
                        <label for="txtDtnasc">Aniversário:</label>
                        <input type="text" class="form-control" 
                               value="<?php echo (isset($u->usu_dtnasc))? date('d/m/Y', strtotime($u->usu_dtnasc)) : set_value('txtDtnasc'); ?>" 
                               name="txtDtnasc" placeholder="12/03/1998">
                        <?php echo form_error("txtDtnasc"); ?>
                    </div>
                    <div class="form-group form-horizontal">
                        <label for="txtCidade">Cidade:</label>
                        <input type="text" class="form-control" 
                               value="<?php echo (isset($u->usu_cidade))? $u->usu_cidade : set_value('txtCidade'); ?>" 
                               name="txtCidade" placeholder="Canas">
                        <?php echo form_error("txtCidade"); ?>
                    </div>
                    <div class="form-group form-horizontal">
                        <label for="txtPais">País:</label>
                        <input type="text" class="form-control" 
                               value="<?php echo (isset($u->usu_pais))? $u->usu_pais : set_value('txtPais'); ?>" 
                               name="txtPais" placeholder="Brasil">
                        <?php echo form_error("txtPais"); ?>
                    </div>
                    <div class="form-group form-horizontal">
                        <label for="txtEmail">Email: </label> 
                        <strong class="text-success"><?php echo $u->usu_email; ?></strong>
                    </div>
                    <div class="form-group form-horizontal">
                        <label for="txtUsername">Username: </label>
                        <strong class="text-success"><?php echo $u->usu_username; ?></strong>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row text-center">
                    <p><button type="submit" class="btn btn-primary">Alterar Informações</button></p>
                </div>
                <?php echo form_close(); ?>
                <div class="row">&nbsp;</div>
                <?php echo form_open("user/passwd/update/do"); ?>
                <div class="row">
                    <h4 class="text-center"><strong>Alteração de Senha</strong></h4>
                    <div class="form-group form-horizontal">
                        <label for="txtPassnova">Nova Senha:</label>
                        <input type="password" class="form-control" 
                               value="<?php echo set_value('txtPassnova'); ?>" 
                               name="txtPassnova">
                        <?php echo form_error("txtPassnova"); ?>
                    </div>
                    <div class="form-group form-horizontal">
                        <label for="txtPassconf">Repita a Nova Senha:</label>
                        <input type="password" class="form-control" 
                               value="<?php echo set_value('txtPassconf'); ?>" 
                               name="txtPassconf">
                        <?php echo form_error("txtPassconf"); ?>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row text-center">
                    <p><button type="submit" class="btn btn-primary">Alterar Senha</button></p>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php } 