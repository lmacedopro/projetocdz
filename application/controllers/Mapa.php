<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends CI_Controller {

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
	public function index()
        {
            
	}
        
        /**
         * Função que busca os cavaleiros associados ao mapa, calcula as chances
         * de um oponente aparecer, escolhe aleatoriamente um cavaleiro que corresponde ao
         * grupo (Comum, raro, etc.), e exibe suas informações de batalha para o jogador.
         * 
         * Função chamada por Ajax. Persiste as informações na seção para evitar 
         * multiplas pesquisas em banco de dados
         */
        public function showOponent(){
            
            #Recebe o id do mapa sendo jogado pelo usuario
            $mapid = $this->input->get("mid");
            
            //echo $mapid;
            
            #Busca os registros de peso e monta o vetor
            $auxpeso = $this->mapas_model->getMapPesos();
            $pesos = array();
            foreach($auxpeso as $a){
                $pesos = array_merge($pesos,array($a->pes_id => $a->pes_value));
            }
            
            //$pesos = array("N"=>370,"C"=>590,"R"=>30,"E"=>8,"L"=>2); //substitua pelos parametros do banco tabela aux_pesos

            #Executa o rand na função sortRandWeight(array $weightedValues)
            $sort = sortRandWeight($pesos);
            
            //echo "SORTEOU: $sort <br /><br />";
            #se o sorteio foi diferente de nenhum
            if($sort != 'N'){
                
                #Busca os cavaleiros associados ao mapa
                $cavs = $this->mapas_model->getCavsMap($mapid,$sort);
                
                //sorteia um dentre os indices do array
                $ind = array_rand($cavs); 
                $oponent = $cavs[$ind];
                
                $oplvl = rand($oponent->mcv_lvlmin, $oponent->mcv_lvlmax);
                #Cria uma sessao para passar as info de batalha. Esta sessao é destruida
                #apos a batalha ser concluida.
                //$this->session->set_userdata("oponent",$opobattle); 

                $this->load->view("v_batalha_oponent",array('oponent' => $oponent, "oplvl"=>$oplvl));
            }
            
            
            #
        }
}
