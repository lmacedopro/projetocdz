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
    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body>
      
      <?php $this->load->view("nav_interna"); #Carrega a Barra inferior de rodape ?>
      
      <div class="container-fluid text-center fulldash fill">
            <div class="row margin-row-top">
                <div class="col-md-12 col-xs-12 centered">
                    <div class="col-md-12 col-xs-12 formdash">
                        <div class="row row-padding">
                            <div class="col-md-2 col-xs-12">
                                <p><img src="<?php echo base_url(); ?>public/img/logo_lateral.png" class="img-responsive" alt="" /></p>
                                <p>&nbsp;</p>
                                <p class="menulink"><a href="<?php echo base_url(); ?>index.php/dash/equipe">Minha Equipe</a></p>
                                <p class="menulink"><a href="<?php echo base_url(); ?>index.php/shop">Item Shop</a></p>
                                <p class="menulink"><a href="<?php echo base_url(); ?>index.php/hospital">Hospital</a></p>
                                <p class="menulink"><a href="<?php echo base_url(); ?>index.php/banco">Banco</a></p>
                                <p class="menulink"><a href="<?php echo base_url(); ?>index.php/trocas">Central de Trocas</a></p>
                                
                                <p class="menulink"><a href="#">Link 7</a></p>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                  <?php $this->load->view($pag); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
        

    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
    <!-- API google para uso de Captcha -->
    <script src='https://www.google.com/recaptcha/api.js?hl=pt-BR'></script>
    <!-- API de funcoes jquery customizadas para o projeto -->
    <script src='<?php echo base_url(); ?>public/js/site_functions.js'></script>
    <script src='<?php echo base_url(); ?>public/js/map_functions.js'></script>
  </body>
</html>