
<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<?php foreach($mapa as $m){ ?>
<div class="col-md-12 centered">
    
    <div class="row centered">
        <div class="col-md-12 bordercont container-fluid">
            <div class='col-md-6 col-xs-12'>
                <div class=" col-md-12 map_canvas container-fluid">
					<div id="map_colision" class="col-md-10 container-fluid"></div>
					<!--img src="<?php //echo base_url(); ?>/public/img/maps/hack_height.png" /-->
                </div>
            </div>
            <div class='col-md-6 col-xs-12 inner' id="mapevent">
                <!--div id='mapevent'></div-->
            </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row centered">
        <div class="col-md-12 bordercont">
            <div id='gamepad'>
                <img src='<?php echo base_url(); ?>public/img/gamepad.png' ismap usemap="#Map"/>
                <map name='Map'>
                    <area shape="rect" coords="30,0,60,30" id="mup" href="#">
                    <area shape="rect" coords="30,60,60,90" id="mdown" href="#">
                    <area shape="rect" coords="0,30,30,60" id="mleft" href="#">
                    <area shape="rect" coords="60,30,90,60" id="mright" href="#">
                </map>
                <br />
                <span class='text-danger text-right'><strong>Mova seu avatar!</strong></span>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    #map_colision{
		z-index: 1;
        border: 1px solid red;
        *width: 83%;
        height: calc(400px - 80px); /*atualizar pelo top da colisao*/
    }
    
	.map_canvas{
		 z-index: 0;
		 background-image: url(../../public/img/maps/<?php echo $m->map_tile; ?>);
		 background-repeat: no-repeat;
		 *background-size: cover;
	}
	
    /*#map_canvas{
        * position: relative;
        * width: 380px;
        * height: 400px;
        background-image: url(../../public/img/maps/<?php echo $m->map_tile; ?>);
		background-repeat: no-repeat;
    }*/
	
    #mapevent{
        * height: 300px;
    }
    #gamepad{
        text-align: center;
        height: 100px;
    }
    #shape {
        width: 30px;
        height: 30px;
        background-color:#36d278;
    }
    #player{
        position: absolute;
        width: 30px;
        height: 60px;
        background-image: url(../../public/img/avatar/<?php echo $this->session->userdata('avtmap').".png"; ?>); 
        /*Alterar para o avatar em mapa correspondente do usuario.*/
    
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/canvasengine-latest.all.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/rpgjs-latest.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        
        var tile = "<div id=shape></div>";
        var alttile = Math.floor($("#map_canvas").height()/30);
        var largtile = Math.floor($("#map_canvas").width()/30);
        
        var player = "<div id='player'></div>"; //declara a div do avatar;
        
        $("#map_colision").append(player); //coloca o avatar do player na tela;
        
        //Seta a movimentação através do teclado
        $(document).keydown(function(e){
            
            var position = $("#player").position(); //posição top,left da div player
            var largmap = $("#map_colision").width() - $("#player").width() - 5; //largura do mapa
            var altmap = $("#map_colision").height() - $("#player").height() - 5; //altura do mapa
            
            //alert(largmap);
            switch(e.keyCode)
            {
                case 37: //esquerda
                    if(position.left <= 0){ //detecta borda esquerda do mapa
                        $('#player').css('left', position.left + 'px');
                    }else{
                        $('#player').css('left', position.left - 15 + 'px');
                    }
                    break;
                case 38: //acima
                    if(position.top <= 0){ //detecta boda superior do mapa
                        $('#player').css('top', position.top + 'px');
                    }else{
                        $('#player').css('top', position.top - 15 + 'px');
                    }
                    break;
                case 39: //direita
                    if(position.left >= largmap){
                        $('#player').css('left', position.left + 'px');
                    }else{    
                        $('#player').css('left', position.left + 15 + 'px');
                    }   
                    break;
                case 40: //abaixo
                    if(position.top >= altmap){
                        $('#player').css('top', position.top + 'px');
                    }else{
                        $('#player').css('top', position.top + 15 + 'px');
                    }
                    break;
            }
            
            mapevt();
            //$("#mapevent").load('<?php echo base_url(); ?>index.php/mapas/play/showop?mid=<?php echo $m->map_id; ?>');
        });
        
        //Seta a movimentação através do gamepad (ACIMA)
        $("#mup").click(function(){
            
            var position = $("#player").position(); //posição top,left da div player
            var largmap = $("#map_colision").width() - $("#player").width() - 5; //largura do mapa
            var altmap = $("#map_colision").height() - $("#player").height() - 5; //altura do mapa
            
            if(position.top <= 0){ //detecta boda superior do mapa
                $('#player').css('top', position.top + 'px');
            }else{
                $('#player').css('top', position.top - 15 + 'px');
            }
            
            mapevt();
        });
        
        //Seta a movimentação através do gamepad (ABAIXO)
        $("#mdown").click(function(){
            
            var position = $("#player").position(); //posição top,left da div player
            var largmap = $("#map_colision").width() - $("#player").width() - 5; //largura do mapa
            var altmap = $("#map_colision").height() - $("#player").height() - 5; //altura do mapa
            
            if(position.top >= altmap){
                $('#player').css('top', position.top + 'px');
            }else{
                $('#player').css('top', position.top + 15 + 'px');
            }
            
            mapevt();
        });
        
        //Seta a movimentação através do gamepad (ESQUERDA)
        $("#mleft").click(function(){
            
            var position = $("#player").position(); //posição top,left da div player
            var largmap = $("#map_colision").width() - $("#player").width() - 5; //largura do mapa
            var altmap = $("#map_colision").height() - $("#player").height() - 5; //altura do mapa
            
            if(position.left <= 0){ //detecta borda esquerda do mapa
                $('#player').css('left', position.left + 'px');
            }else{
                $('#player').css('left', position.left - 15 + 'px');
            }
            
            mapevt();
        });
        
        //Seta a movimentação através do gamepad (DIREITA)
        $("#mright").click(function(){
            
            var position = $("#player").position(); //posição top,left da div player
            var largmap = $("#map_colision").width() - $("#player").width() - 5; //largura do mapa
            var altmap = $("#map_colision").height() - $("#player").height() - 5; //altura do mapa
            
            if(position.left >= largmap){
                $('#player').css('left', position.left + 'px');
            }else{    
                $('#player').css('left', position.left + 15 + 'px');
            }
            
            mapevt();
        });
        
        function mapevt(){
            $("#mapevent").load('<?php echo base_url(); ?>index.php/mapas/play/showop?mid=<?php echo $m->map_id; ?>');
        };
    });
</script>
<?php } ?> 
