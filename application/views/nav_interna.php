<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
          <img src="<?php echo base_url(); ?>public/img/logo_brand.png" class="img-responsive" alt="" />
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="btn-default">
            <a href="<?php echo base_url(); ?>index.php/dash">Dashboard</a>
        </li>
		<li class="btn-default">
			<a href="<?php echo base_url(); ?>index.php/mapas">Mapas</a>
		</li>
		<li class="btn-default">
			<a href="<?php echo base_url(); ?>index.php/missoes">Missões</a>
		</li>
		<li class="btn-default">
			<a href="<?php echo base_url(); ?>index.php/arena">Arena</a>
		</li>
		<li class="btn-default">
			<a href="<?php echo base_url(); ?>index.php/santuario">Santuário</a>
		</li>
        <!--li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              Mapas e Desafios<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="<?php //echo base_url(); ?>index.php/mapas">Mapas Livres</a></li>
                <li><a href="<?php //echo base_url(); ?>index.php/missoes">Missões</a></li>
                <li><a href="<?php //echo base_url(); ?>index.php/batalhas">Batalhas de Usuários</a></li>
                <li><a href="<?php //echo base_url(); ?>index.php/desafios">Outros Desafios</a></li>
            </ul>
        </li-->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">
                Bem-vindo <strong><?php echo $this->session->userdata("username"); ?></strong>. 
                Seu último acesso foi em <strong><?php echo $this->session->userdata("lastlogin"); ?>.</strong></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              Conta<span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>index.php/user/conta">Minha Conta</a></li>
            <li><a href="#">Contate-nos</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo base_url(); ?>index.php/user/logout">Sair</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>