<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trocas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function index(){

        #Verifica a sessao iniciada
        verifyUser();

        $op = $this->input->get("op");

        
        $form = "v_trocas_ofertas";
        if(($op == null) | ($op == 1)){

            $form = "v_trocas_ofertas";

            #Busca as trocas dos outros usuarios
            $cavtrocas = $this->cavaleiros_model->getCavsForTrade($this->session->userdata("uid"));

            #Busca todos os cavaleiros que o usuario tem que podem ser trocados (lineup = 0; sem estar na tabela de trocas)
            $cavsusu = $this->cavaleiros_model->getCavsUserTrade($this->session->userdata("uid"));

            #Filtra as trocas comparando o level e a classe com seus cavaleiros, se tiver marca com uma flag
            $trocasok = [];
            foreach($cavtrocas as $ct){

                #calcula a faixa de levels para exibir a troca
                $levelmin = $ct->cvu_level - 10;
                if($levelmin <= 0){
                    $levelmin = 1;
                }

                $levelmax = $ct->cvu_level + 10;
                if($levelmax >= 100){
                    $levelmax = 100;
                }

                foreach($cavsusu as $cu){

                    #verifica se o id de cada cavaleiro do usuario, corresponde a um id de cavaleiro para troca
                    if($ct->trc_cavid == $cu->cav_id){

                        #verifica se o level do cavaleiro está na faixa de levels
                        if(($cu->cvu_level >= $levelmin) & ($cu->cvu_level <= $levelmax)){

                            array_push($trocasok,$ct);
                            break;
                        }
                    }
                }
            }

            $this->load->view("inicial_interna",array("pag"=>'v_trocas',"form"=>$form,"trocasok"=>$trocasok));
        }else{
            $form = "v_trocas_usertrocas";

            #Busca as trocas cadastradas do usuario
            $selcvu = $this->cavaleiros_model->getCvuForTrade($this->session->userdata("uid"));

            $this->load->view("inicial_interna",array("pag"=>'v_trocas',"form"=>$form, "selcvu"=>$selcvu));
        }   
    }

    public function accoferta(){

        #Verifica a sessao iniciada
        verifyUser();

        $trcid = trim($this->input->post("hdnTrcid"));
        $oldcvu = trim($this->input->post("hdnOldcvuid"));
        $oldusu = trim($this->input->post("hdnOldusuid"));
        $oldcav = trim($this->input->post("hdnOldcavid"));
        $newcvu = trim($this->input->post("hdnNewcvuid"));
        $newusu = trim($this->input->post("hdnNewusuid"));
        $newcav = trim($this->input->post("hdnNewcavid"));

        #Verifica os dados da troca para confirmar
        $troca = $this->cavaleiros_model->getTroca($trcid);

        if($troca == null){

            echo "<script type='text/javascript'>alert(Esta oferta não existe ou Já foi aceita!);</script>";
            exit(0);
        }
        
        #Atualiza o cvu do olduser pelo newuser e vice versa
        $data = array("usu_id" => $oldusu);
        $this->cavaleiros_model->updateCavTrade($newusu,$newcvu,$data);

        $data2 = array("usu_id" => $newusu);
        $this->cavaleiros_model->updateCavTrade($oldusu,$oldcvu,$data2);

        #invalida a troca da tabela de trocas
        $this->cavaleiros_model->deleteTroca($trcid);

        redirect("trocas","refresh");
    }

    /*
     * Função que busca os cavaleiros do usuarios que podem ser trocados 
     * e exibe o modal de selecção de cavaleiros para troca
     */
    public function selcvutroca(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvuid = trim($this->input->get("cvuid"));
        $clsid = trim($this->input->get("clsid"));

        
        #Busca os dados do cavaleiro do usuario
        $selcvu = $this->cavaleiros_model->getCavByCvu($cvuid);

        #Busca os cavaleiros disponiveis no jogo para o usuario escolher de acordo com a classe do cav que ele quer trocar
        $selcav = $this->cavaleiros_model->getCavsTradeByCls($clsid);


        $this->load->view("frm_cavtroca", array("selcvu"=>$selcvu,"selcav"=>$selcav));
    }

    public function selcavoferta(){

        #Verifica a sessao iniciada
        verifyUser();

        #recebe os dados da troca
        $trcid = trim($this->input->get("trcid"));

        #Pega os dados da troca
        $troca = $this->cavaleiros_model->getTroca($trcid);

        #Busca todos os cavaleiros que o usuario tem que podem ser trocados (lineup = 0; sem estar na tabela de trocas)
        $cavsusu = $this->cavaleiros_model->getCavsUserTrade($this->session->userdata("uid"));

        #Filtra as trocas comparando o level e a classe com seus cavaleiros, se tiver marca com uma flag
        $listacvu = [];
        $arraux = []; #array auxiliar para definir dados da troca
        foreach($troca as $ct){

            #calcula a faixa de levels para exibir a troca
            $levelmin = $ct->trc_cvulevel - 10;
            if($levelmin <= 0){
                $levelmin = 1;
            }

            $levelmax = $ct->trc_cvulevel + 10;
            if($levelmax >= 100){
                $levelmax = 100;
            }

            foreach($cavsusu as $cu){

                #verifica se o id de cada cavaleiro do usuario, corresponde a um id de cavaleiro para troca
                if($ct->trc_cavid == $cu->cav_id){

                    #verifica se o level do cavaleiro está na faixa de levels
                    if(($cu->cvu_level >= $levelmin) & ($cu->cvu_level <= $levelmax)){

                        array_push($listacvu,$cu);
                    }
                }
            }
        }

        $this->load->view("frm_accoferta", array("troca"=>$troca, "listacvu"=>$listacvu));
    }

    /*
     * Faz o cadastro de uma nova troca do usuario
     */
    public function cadtroca(){

        #Verifica a sessao iniciada
        verifyUser();

        #recebe os dados da troca
        $cvuid = trim($this->input->post("hdnCvuid"));
        $cvulvl = trim($this->input->post("hdnCvuLevel"));
        $cavid = trim($this->input->post("hdnCavid"));

        #Recupera a datahora da transacao
        $datahora = date("Y-m-d H:i:s");

        #Verifica os dados do cvu
        $selcvu = $this->cavaleiros_model->getCavByCvu($cvuid);
        foreach($selcvu as $cu){
            if($cu->usu_id != $this->session->userdata("uid")){ //confirma se o cavleiro escolhido é do usuario logado
                echo "<p class='panel panel-danger'>Há divergência nos dados do seu cavaleiro e os enviados para troca. Troca não cadastrada!</p>";
                exit(0);
            }
        }

        #cria o vetor de dados
        $data = array("trc_usuid"=>$this->session->userdata("uid"),
                      "trc_cvuid"=>$cvuid,
                      "trc_cvulevel"=>$cvulvl,
                      "trc_cavid"=>$cavid,
                      "trc_datahora"=>$datahora);

        #Adiciona a troca
        $this->cavaleiros_model->insertTroca($data);

        //redireciona para a pagina de personalização do cavaleiro
        redirect("dash/equipe/personalize/?cvu=$cvuid","refresh");
    }

    public function cancelatroca(){

         #Verifica a sessao iniciada
        verifyUser();

        #recebe os dados da troca
        $trcid = trim($this->input->get("trc"));

        $this->cavaleiros_model->deleteTroca($trcid);

        redirect("trocas/?op=2","refresh");
    }
        
}