<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
    <title>Projeto CDZ</title>

    <link href="<?php echo base_url(); ?>public/css/site_style.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/css/bootstrap-theme.min.css" rel="stylesheet">
    
    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="<?php echo base_url(); ?>/public/js/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="<?php echo base_url();?>/public/js/bootstrap.min.js"></script>
    <!-- API google para uso de Captcha -->
    <script src='https://www.google.com/recaptcha/api.js?hl=pt-BR'></script>
    <!-- API de funcoes jquery customizadas para o projeto -->
    <script src='<?php echo base_url(); ?>/public/js/site_functions.js'></script>
    <?php //$this->load->view('functions_jquery.php'); ?>
    
  </head>
  <body>
      
      <?php #$this->load->view("inicial_footer"); #Carrega a Barra inferior de rodape ?>
      
      <div class="container-fluid text-center full fill">
            <div class="row">
                <div class="col-md-12 col-xs-12 header">
                    <center><img src="<?php echo base_url(); ?>public/img/logo.png" class="img-responsive" alt="" /></center>
                </div>
            </div>
            <div class="row">
                <?php $this->load->view($pag); ?>
            </div>
        </div>
  </body>
</html>