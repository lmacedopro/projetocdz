<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<div class="col-md-3 col-xs-1">&nbsp;</div>
<div class="col-md-6 col-xs-10">
                                  
    <div class="col-md-7 col-xs-0">&nbsp;</div>
    <div class="col-md-5 col-xs-12 loginbox">
        <?php if(!is_null($erro)){ ?>
            <div class="text-danger small"><?php echo $erro; ?></div>
        <?php } ?>
        <?php echo form_open('user/login'); ?>

        <div class="form-group">
            <label for="txtUsername">Username</label>
            <input type="text" class="form-control" name="txtUsername" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="txtPassword">Password</label>
            <input type="password" class="form-control" name="txtPassword" placeholder="Password">
        </div>
        <p><button type="submit" class="btn btn-info">Login</button>
            <a href="<?php echo base_url(); ?>index.php/user/signup" class="btn btn-default">Cadastre-se</a></p>
        <p><a href="#">Esqueceu a senha?</a></p>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="col-md-3 col-xs-1">&nbsp;</div>