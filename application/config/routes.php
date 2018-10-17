<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'controle';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['user/login'] = 'controle/login';
$route['user/logout'] = 'controle/logout';

$route['user/signup'] = 'controle/signup';

$route['user/conta'] = 'controle/userconta';
$route['user/signup/do'] = 'usuarios/cadastrar';
$route['user/avatar/update/do'] = 'usuarios/atualizarAvatar';
$route['user/info/update/do'] = 'usuarios/atualizar';
$route['user/passwd/update/do'] = 'usuarios/atualizarSenha';


$route['dash'] = "controle/dashboard";
$route['dash/equipe'] = "controle/gerirequipe";
$route['dash/equipe/info'] = "cavaleiros/cavinfo";
$route['dash/equipe/mudar'] = "cavaleiros/cavmudalineup";
$route['dash/equipe/mudar/post'] = "cavaleiros/cavmudalineuppost";
$route['dash/equipe/personalize'] = "cavaleiros/cavpersonalize";
$route['dash/equipe/personalize/lineup/remove'] = "cavaleiros/cavdellineup";
$route['dash/equipe/personalize/lineup/add'] = "cavaleiros/cavaddlineup";
$route['dash/equipe/personalize/apelido'] = "cavaleiros/cavalterapelido";
$route['dash/equipe/personalize/slottec'] = "cavaleiros/cavaltertec";
$route['dash/equipe/personalize/slottec/alter'] = "cavaleiros/cavalterslot";
$route['dash/equipe/personalize/slottec/del'] = "cavaleiros/cavdelslot";

$route['batalha'] = "controle/batalha";
$route['batalha/vitoria'] = "controle/batalha_win";
$route['batalha/derrota'] = "controle/batalha_lose";
$route['batalha/efcura'] = "controle/batalha_cura";

$route['hospital'] = "controle/hospital";
$route['hospital/restaurar'] = "controle/hospRestore";

$route['mapas'] = "controle/mapas_livres";
$route['mapas/play'] = "controle/genmaps";
$route['mapas/play/showop'] = "mapa/showOponent";

$route['shop'] = "itens";
$route['shop/comprar'] = "itens/comprar";

$route['banco'] = "controle/banco";
$route['banco/transferir'] = "controle/bancotransf";

$route['trocas'] = "trocas/index";
//$route['troca/verofertas'] = "trocas/verofertas";
$route['troca/novatroca'] = "trocas/selcvutroca";
$route['troca/accoferta'] = "trocas/selcavoferta";
$route['troca/novatroca/do'] = "trocas/cadtroca";
$route['troca/ofertas/acc'] = "trocas/accoferta";
$route['troca/cancela'] = "trocas/cancelatroca";


$route['missoes'] = "controle/missoes";
#$route['batalhas'] = "controle/batalhas";
$route['desafios'] = "controle/desafios"; //alterada para teste de mapa
