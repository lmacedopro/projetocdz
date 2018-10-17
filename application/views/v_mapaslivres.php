<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
Formulario de Login para acesso ao Game CDZ - Reino de Athena
-->
<?php //foreach($user as $u){ ?>
<div class="col-md-12 centered">
    <div class="page-header text-left">
        <h3>Mapas Livres</h3>
    </div>
    <div class="row centered">
        <div class="col-md-12 bordercont">
            <?php foreach($maps as $m){ ?>
            <div class="row">
                <div class="col-md-12 menulink2">
                    <div class="col-md-6 text-justify">
                        <h3 class="text-success"><?php echo $m->map_titulo; ?></h3>
                        <p class="text-danger">Power: <?php echo $m->map_power; ?></p>
                        <p class="text-info"><?php echo $m->map_desc; ?></p>
                        <p class="text-center"><a class='btn btn-warning' href="<?php echo base_url(); ?>index.php/mapas/play?mid=<?php echo $m->map_id; ?>">Jogar Neste Mapa</a></p>
                    </div>
                    <div class="col-md-6">
                        <img src="<?php echo base_url(); ?>public/img/maps/<?php echo $m->map_mini; ?>"
                         width="100%" />
                    </div> 
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>