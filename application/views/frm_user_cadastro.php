<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<div class="col-md-12">
    <?php echo form_open('user/signup/do'); ?>
    <div class="col-md-12 formbox">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-info"><strong>Passo 1: Não Sou Robô:</strong></h5>
                <div class="form-group">
                    <center><div class="g-recaptcha" data-sitekey="6LdLlhYUAAAAAOCfjrxPYGWzfyYm7aVryfg3v_e8" name="gcaptcha"></div></center>
                </div>
                <div class="row center-block">
                    <h5 class="text-info"><strong>Passo 2: Escolha de Personagem Inicial:</strong></h5>
                    <div class="col-md-5 vcenter">
                        <div class="form-group">
                            <select class="form-control selectpicker" name="selCavini" id="selCavini">
                                <option value="" <?php echo set_select('selCavini', '', TRUE); ?> >Selecione...</option>
                                <?php foreach($cavs as $c){ ?>
                                <option value="<?php echo $c->cav_id; ?>" 
                                    <?php echo set_select('selCavini', $c->cav_id); ?> >
                                            <?php echo $c->cav_nome; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <center><span id="showcavini"></span></center>
                    </div>
                    <?php echo form_error("selCavini"); ?>
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="text-info"><strong>Passo 3: Preencher os Dados Pessoais de Conta:</strong></h5>
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo set_value('txtNome'); ?>" name="txtNome" placeholder="João da Silva">
                    <?php echo form_error("txtNome"); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo set_value('txtUsername'); ?>" name="txtUsername" placeholder="Username">
                    <?php echo form_error("txtUsername"); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo set_value('txtEmail'); ?>" name="txtEmail" placeholder="email@exemplo.com">
                    <?php echo form_error("txtEmail"); ?>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" value="<?php echo set_value('txtPassword'); ?>" name="txtPassword" placeholder="Senha">
                    <?php echo form_error("txtPassword"); ?>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" value="<?php echo set_value('txtPassconf'); ?>" name="txtPassconf" placeholder="Senha Novamente">
                    <?php echo form_error("txtPassconf"); ?>
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="text-info"><strong>Passo 4: Escolha de Avatar:</strong></h5>
                <div class="row center-block">
                    <div class="col-md-8 vcenter">
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
                    <div class="col-md-4">
                        <center><span id="showavatar"></span></center>
                    </div>
                </div>
                <p>&nbsp;</p>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="<?php echo base_url(); ?>index.php" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
