<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends CI_Controller {

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
		
        #Carrega a pagina inicial com o formulario de login
        $this->load->view('inicial',array("pag"=>'frm_login', "erro"=>null));
	}
        
    /*
     * Exibe a pagina de cadastro do usuario
     */
    public function signup(){
		
        #Carrega os cavaleiros iniciais
        $cavsini = $this->cavaleiros_model->getCavIniciais();
        $this->load->view('inicial',array("pag"=>'frm_user_cadastro',
                                          "cavs"=>$cavsini));
    }
        
    /*
     * Faz a verificacao dos dados do formulario e realiza login
     */
    public function login(){
            
        $username = $this->input->post("txtUsername");
        $senha = $this->input->post("txtPassword");
            
        $data = array("usu_username" => $username,
                      "usu_password" => md5($senha));
            
        # Busca informações de usuario no BD e Valida usuario
        $check = $this->users_model->checkUser($data);

        # Cria as secoes de controle do usuario
        if(!empty($check)){
            foreach($check as $c){
                $this->session->set_userdata("uid",$c->usu_id);
                $this->session->set_userdata("username",$c->usu_username);
                    
                $dtf = time($c->usu_lastlogin);
                    
                $this->session->set_userdata("lastlogin",date("d M, Y",$dtf));
                $this->session->set_userdata("logado",TRUE);
                    
                $this->session->set_userdata("avatar",$c->usu_avatar);
                $this->session->set_userdata("avtmap",$c->usu_avtmap);
                    
                redirect('dash', 'refresh');
            }
        }else{
                
            #Cria mensagem de erro de login
            $error = "Username ou Senha não conferem!";
            $this->load->view('inicial',array("pag"=>"frm_login", "erro"=>$error));
        }
    }
        
    /*
     * Formulario de alteração de dados de conta de usuario
     * #protegina pelo controle de sessao
     */
    public function userconta(){
            
        #Verifica a sessao iniciada
        verifyUser();
            
        #Busca os dados do usuario
        $user = $this->users_model->getUser($this->session->userdata("uid"));
            
        $this->load->view('inicial_interna',array("pag"=>'frm_user_conta',"user"=>$user));
    }
         
    /*
     * Função de carregamento da pagina de dashboard
     * #protegina pelo controle de sessao
     */
    public function dashboard(){
            
        #Verifica a sessao iniciada
        verifyUser();

        #Verifica o level dos cavs do lineup e atualiza os levels
		$this->verificaLevel();
            
        #Busca os dados do usuario
        $user = $this->users_model->getUser($this->session->userdata("uid"));
		
		#Busca o lineup do usuario
        $cavsu = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		
		#Busca os itens do usuario
		$itens = $this->itens_model->getItensByUser($this->session->userdata("uid"));

        $this->load->view('inicial_interna',array("pag"=>'v_dashboard',"user"=>$user,"cavsu"=>$cavsu,"itens"=>$itens));
    }
        
	/*
	 * Função de carregamento da pagina de gerenciamento de equipe
	 * #protegida pelo controle de sessao
	 */
	public function gerirequipe(){
		
		#Verifica a sessao iniciada
		verifyUser();
		
		#Busca os dados dos cavaleiros
		$cavsu = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		$cavsall = $this->cavaleiros_model->getCavsByUser($this->session->userdata("uid"));
		
		$this->load->view('inicial_interna',array("pag"=>'v_meuscavs',"cavsu"=>$cavsu,"cavsall"=>$cavsall));
	}

	/*
	 * Função de carregamento da pagina de hospital (curar lineup)
	 * #protegida pelo contorle de acesso
	 */ 
	public function hospital(){
		
		verifyUser();
		
		#Busca o lineup do usuario
		$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		
		$this->load->view('inicial_interna',array("pag"=>'v_hospital',"lineup"=>$lineup));
	} 
	
	/*
	 * Função que restaura o hp de todos os cavaleiros do usuário
	 * #protegida pelo contorle de acesso
	 */ 
	public function hospRestore(){
		
		verifyUser();
		
		#Busca o lineup do usuario
		$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		
		foreach($lineup as $lnu){
			
			#pega as tecnicas de cada cavaleiro para restaurar o PP
			if($lnu->cvu_tec1 != 0){
				$tec1 = $this->tecnicas_model->getTecnicas($lnu->cvu_tec1);
				
				foreach($tec1 as $t){
					$lnu->cvu_tec1pp = $t->tec_pp;
				}
				
			}
			
			if($lnu->cvu_tec2 != 0){
				$tec2 = $this->tecnicas_model->getTecnicas($lnu->cvu_tec2);
				
				foreach($tec2 as $t){
					$lnu->cvu_tec2pp = $t->tec_pp;
				}
				
			}
			
			if($lnu->cvu_tec3 != 0){
				$tec3 = $this->tecnicas_model->getTecnicas($lnu->cvu_tec3);
				
				foreach($tec3 as $t){
					$lnu->cvu_tec3pp = $t->tec_pp;
				}
				
			}
			
			if($lnu->cvu_tec4 != 0){
				$tec4 = $this->tecnicas_model->getTecnicas($lnu->cvu_tec4);
				
				foreach($tec4 as $t){
					$lnu->cvu_tec4pp = $t->tec_pp;
				}
				
			}
			
			if($lnu->cvu_tec5 != 0){
				$tec5 = $this->tecnicas_model->getTecnicas($lnu->cvu_tec5);
				
				foreach($tec5 as $t){
					$lnu->cvu_tec5pp = $t->tec_pp;
				}
				
			}
			
			#copia o atributo de HP para o hp do cavaleiro
			$lnu->cvu_hp = $lnu->atr_hp;
			
			#atualiza no banco de dados
			$data = array("cvu_tec1pp" => $lnu->cvu_tec1pp,
						  "cvu_tec2pp" => $lnu->cvu_tec2pp,
						  "cvu_tec3pp" => $lnu->cvu_tec3pp,
						  "cvu_tec4pp" => $lnu->cvu_tec4pp,
						  "cvu_tec5pp" => $lnu->cvu_tec5pp,
						  "cvu_hp" => $lnu->cvu_hp,
			);
			
			$this->cavaleiros_model->updateCavUser($lnu->cvu_id,$data);

		}
		
		redirect('hospital', 'refresh');

	}

	/*
	 * Função de carregamento da pagina do banco
	 */
	public function banco(){

		#Verifica a sessao iniciada
		verifyUser();

		$user = $this->users_model->getUser($this->session->userdata("uid"));

		$this->load->view('inicial_interna',array("pag"=>'v_banco',"user"=>$user,"erro"=>""));
	} 

	/*
	 * Recebe os dados do formulario de transferência de dinheiro e atualiza as contas dos
	 * usuarios envolvidos na transacao
	 */
	public function bancotransf(){

		#Verifica a sessao iniciada
		verifyUser();

		#Recupera os dados do cadastro e formata para inserção no BD
        $user = $this->users_model->getUser($this->session->userdata("uid"));

        foreach($user as $u){

        	$this->load->library('form_validation');
            
	        #<--- Configura os textos de erro --->
	        $this->form_validation->set_error_delimiters('<div class="text-danger"><small>', '</small></div>');
	            
	        #<--- Prepara a validacao dos campos do formulario --->
	        $this->form_validation->set_rules('txtUserrec', 'Username', 'trim|required|min_length[5]',
	                array(
	                        'required' => 'O Campo {field} é requerido!', 
	                        'min_length' => 'O Campo {field} deve conter mais de 5 caracteres!'
	                    )
	            );
	        $this->form_validation->set_rules('txtValor', 'Valor', 'trim|required|is_natural_no_zero|less_than_equal_to['.$u->usu_money.']|greater_than_equal_to[100]',
	                array(
	                    'required' => 'O Campo {field} é requerido!',
	                    'is_natural_no_zero'=> 'O {field} deve ser um Número maior que 0 (Zero)!',
	                    'less_than_equal_to'=> 'Você não tem Dinheiro Suficiente para Transferir!',
	                    'greater_than_equal_to'=> 'O Limite mínimo de tranferência é $ 100!'
	                    )
	            ); 
	            
            if ($this->form_validation->run() == FALSE){ # Testa a validacao e caso tenha algum erro, redireciona para a tela de cadastro
                
                $this->load->view('inicial_interna',array("pag"=>'v_banco',"user"=>$user,"erro"=>""));

            }else { # Caso contrario, faz os procedimentos para cadastro e redireciona para o proximo passo 

                $userrec = trim($this->input->post("txtUserrec"));
				$valor = trim($this->input->post("txtValor"));

				#verificar se o usuario digitado existe no banco
				$usurec = $this->users_model->getUserByUsername($userrec);
				if($usurec == null){ //se nao retonar um usuario retorna erro que nao existe o username digitado

					$erro = "O Username digitado não Existe na base de dados!";

					$this->load->view('inicial_interna',array("pag"=>'v_banco',"user"=>$user,"erro"=>$erro));
				}else{


					#subtrai o valor do usuario logado e atualiza seu dinheiro
					$usumoney = $u->usu_money - $valor;
					$data1 = array("usu_money"=>$usumoney);

					#tira 25% de taxa de serviço do valor
					$valcor = round($valor * 0.75);

					foreach($usurec as $ur){

						#adiciona o valor corrigido na conta do usuario que recebe
						$urmoney = $ur->usu_money + $valcor;
						$data2 = array("usu_money"=>$urmoney);

						$this->users_model->update($data2,$ur->usu_id); //adiciona o valor corrigido
						$this->users_model->update($data1,$u->usu_id); //subtrai o valor do usuario
					}

					//redireciona para a tela de compra de itens
					redirect("banco","refresh");
					
				}
			}

        }

	}
   
	/*
	 * Função de carregamento da pagina de mapas e missoes
	 * #protegina pelo controle de sessao
	 */
	public function mapas_livres(){
		
		#Verifica a sessao iniciada
		verifyUser();
		
		#Busca os dados dos mapas
		$mapas = $this->mapas_model->getMapasAtivos();
		//$cavsall = $this->cavaleiros_model->getCavsByUser($this->session->userdata("uid"));
		
		$this->load->view('inicial_interna',array("pag"=>'v_mapaslivres', "maps"=>$mapas));
	}
	
	/*
	 * Função de carregamento do mapa escolhido para jogar
	 * #protegina pelo controle de sessao
	 */
	public function genmaps(){
		
		#Verifica a sessao iniciada
		verifyUser();

		#Verifica o level dos cavs do lineup e atualiza os levels
		$this->verificaLevel();
		
		$mid = trim($this->input->get("mid"));
		
		#Busca os dados dos mapas
		$mapa = $this->mapas_model->getMapa($mid);
		
		//guarda o id do mapa na seção do usuario
		foreach($mapa as $m){
			$this->session->set_userdata("playmap",$m->map_id);
		}
		
		//verifica se o usuario tem lineup com hp para batalhar
		$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		$usudie = $this->checkLineup($lineup);
		
		if($usudie == TRUE){
			$this->load->view('inicial_interna',array("pag"=>'v_batalha_aviso'));
		}else{
			$this->load->view('inicial_interna',array("pag"=>'v_genmap', "mapa"=>$mapa));
		}
	}
	
	/*
	 * Exibe a pagina de vitoria caso o usuario vença a batalha
	 * #protegina pelo controle de sessao
	 */
	public function batalha_win(){
		
		verifyUser();
		
		$this->load->view('inicial_interna',array("pag"=>'v_batalha_vitoria'));	
	}
	
	/*
	 * Exibe a pagina de derrota caso o usuario perca a batalha
	 * #protegina pelo controle de sessao
	 */
	public function batalha_lose(){
		
		verifyUser();
		
		$this->load->view('inicial_interna',array("pag"=>'v_batalha_derrota'));	
	}
        
	/*
	 * Função de carregamento de oponentes para batalha
	 * #protegina pelo controle de sessao
	 */
	public function batalha(){
		
		#Verifica a sessao iniciada
		verifyUser();
			
		#Recebe as var de level e id de oponente, e cria o vetor de oponente
		$op = trim($this->input->get("op")); #passa as decisoes do jogador a cada turno
		
		#Busca os itens do usuario
		$itens = $this->itens_model->getItensByUser($this->session->userdata("uid"));
		
		/*Switch op - Para verificar qual função chamar
		 * atk = ataque (tem returno)
		 * use = usa um item do inventario (tem returno)
		 * alt = altera o cavaleiro na batalha (sem returno)
		 * run = encerra a batalha atual (todos o dano e efeitos ate o momento sao contados)
		 */
			
		switch($op){
			case "atk":
				#pega o id da tecnica usada
				$tec = trim($this->input->get("tec"));
				$slot = trim($this->input->get("slot"));
				
				#pega sessao de usuario e oponente
				$cavucur = $this->session->userdata("btl_usercav_cur");
				$cavopocur = $this->session->userdata("btl_oponent_cur");
				
				#pega a tecnica selecionada
				$tecu = $this->tecnicas_model->getTecnica($tec);
				
				#Pega as tecnicas do oponente e sorteia uma
				$tecopo = $this->session->userdata("btl_oponent_tec");
				$opotec = sortTecnicas($tecopo);
				
				#Pega o lineup do usuario e atualiza seção
				$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
								
				//verifica se usuario morreu
				$userdie = $this->checkDieTurno($cavucur,$lineup);
				//atualiza dados do usuario
				$this->atualizaTurno($cavucur);
				//atualiza o lineup
				$this->session->set_userdata("btl_lineup",$lineup);
				
				#Controla os turnos
				//pega o lvl do usuario e oponente
				$userlvl = null;
				$oponentlvl = null;
				foreach($cavucur as $cu){
					$userlvl = $cu->cvu_level;
				}
				foreach($cavopocur as $op){
					$oponentlvl = $op->atr_level;
				}

				//pega a variavel de status de usuario e oponente
				$useref = $this->session->userdata("btl_usercav_status");
				$oponentef = $this->session->userdata("btl_oponent_status");
				
				//Verifica se usuario possui efeito antes do ataque;
				$this->verificaEfeito($useref,$cavucur,$oponentlvl);
				if($useref["efatk"] == TRUE){
					$this->battleUserAtk($cavucur,$cavopocur,$slot,$tecu, $oponentef);
				}
				
				//atualiza dados do usuario
				$this->atualizaTurno($cavucur);
				
				//verifica se oponente morreu
				$opodie = $this->checkDie($cavopocur);
				
				if($opodie == FALSE){
					//Verifica se oponente possui efeito
					$this->verificaEfeito($oponentef,$cavopocur,$userlvl);
					if($oponentef["efatk"] == TRUE){
						$this->battleReturno($cavucur,$cavopocur,$opotec, $useref);
					}
				}
				
				//atualiza dados do usuario
				$this->atualizaTurno($cavucur);
				
				//verifica se usuario morreu
				$userdie = $this->checkDieTurno($cavucur,$lineup);
				
				if($userdie == TRUE){
					#guarda dados da derrota no banco
					$user = $this->users_model->getUser($this->session->userdata("uid"));
					
					foreach($user as $s){
						$derrotas = $s->usu_derrotas;
					}
					
					$derrotas += 1;
					
					#atribui o dinheiro a conta do usuario
					$datau = array("usu_derrotas" => $derrotas);
					$this->users_model->update($datau,$this->session->userdata("uid"));
					
					//redireciona para página de derrota
					redirect("batalha/derrota","refresh");
					
				}elseif($opodie == TRUE){
					
					#guarda dados da vitoria no banco
					$user = $this->users_model->getUser($this->session->userdata("uid"));
					
					foreach($user as $s){
						$vitorias = $s->usu_vitorias;
						$money = $s->usu_money;
					}
					
					#conta a vitoria
					$vitorias += 1;
					
					#Calcula o XP 
					
					$exp = $this->battleCalcXp($cavopocur,null,false);
					
					#Verifica o drop do dinheiro e soma ao dinheiro do usuario
					$logmoney = 0;
					foreach($cavopocur as $c){
						$moneycav = $c->atr_dropmoney;
						$logmoney = $c->atr_dropmoney;
					}
					
					$money += $moneycav;
					
					#filtra o array de cavaleiros que lutaram
					$cavlutou = array_unique($this->session->userdata("btl_cavlutou"));
					$qtd = count($cavlutou);
					
					#---divide o xp pelo nr de cav que lutararam e atuaiza o xp de cada um ----
					$partxp = $exp/$qtd;
					if($partxp < 1){ //se q qtd de xp fo menor que 1 atribui 1 de xp a cada cav que lutou
						$partxp = 1;
					}
					
					foreach($cavlutou as $c){
						
						//Pega os cavaleiros que lutaram e atribui xp a eles
						$cavp = $this->cavaleiros_model->getCavByCvu($c);
						
						foreach($cavp as $cp){
							
							$cavxp = ($cp->cvu_exp + $partxp);
							
							//Verifica se tem item se aumento de xp equipado
							if($cp->cvu_equipitem != 0){
								
								//busca o item equipado
								$itemequip = $this->itens_model->getItem($cp->cvu_equipitem);
								foreach($itemequip as $itm){
									$cavxp = round($cavxp * $itm->itm_fatorxp); //aumenta o xp pelo fator de aumento do item
								}
								
							}
							
							$data = array("cvu_exp"=>$cavxp);
							$this->cavaleiros_model->updateCavUser($cp->cvu_id,$data);
						}
					}
					#---FIM divide o xp pelo nr de cav que lutararam e atuaiza o xp de cada um ----
					
					#atribui o dinheiro a conta do usuario
					$datau = array("usu_vitorias" => $vitorias,
								   "usu_money" => $money);
					$this->users_model->update($datau,$this->session->userdata("uid"));
					
					//atualiza variavel de log registrando estat de Batalha
					$usuario = $this->session->userdata("username");
					$logat = "<p class='text-success'>".$usuario." <b>VENCEU</b> a Batalha! Recebeu <b>EXP: $exp; DINHEIRO: $logmoney</b></p>";
					$log = $logat.$this->session->userdata("btl_log");
					$this->session->set_userdata("btl_log",$log);
					
					//redireciona para página de derrota
					redirect("batalha/vitoria","refresh");
					
				}else{
					
					$this->load->view('inicial_interna',array("pag"=>'v_batalha',"itens"=>$itens));
				}
				
				break;
			case "pas":
				
				$cavucur = $this->session->userdata("btl_usercav_cur");
				$novocav = null;
				foreach($cavucur as $cv){
					$novocav = $cv->cvu_id;
				}
				
				#recupera os dados do novo cavaleiro
				$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
				$this->session->set_userdata("btl_lineup",$lineup);
				
				$ind = count($lineup);
				for($i=0;$i<$ind;$i++){
					
					if($lineup[$i]->cvu_id == $novocav){
						
						$cavsel[] = $lineup[$i];
						break;
					}
				}
				
				#atualiza a seção de batalha
				$this->session->set_userdata("btl_usercav",$cavsel);
				$this->session->set_userdata("btl_usercav_cur",$cavsel);
				
				$this->load->view('inicial_interna',array("pag"=>'v_batalha',"itens"=>$itens));
				break;
			case "use":
			
				//recebe o id od item
				$itmid = $this->input->get("itm");
				
				//pega o item do usuario
				$useritem = $this->itens_model->getItemByUser($this->session->userdata('uid'), $itmid);
				 
				#pega sessao de usuario e oponente
				$cavucur = $this->session->userdata("btl_usercav_cur");
				$cavop = $this->session->userdata("btl_oponent");
				$cavopocur = $this->session->userdata("btl_oponent_cur");
				
				#Pega as tecnicas do oponente e sorteia uma
				$tecopo = $this->session->userdata("btl_oponent_tec");
				$opotec = sortTecnicas($tecopo);
				
				#Pega o lineup do usuario e atualiza seção
				$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
				
				$probrec = "NULL";
				$opodie = FALSE;
				
				//Recupera as informações de item do usuario
				foreach($cavucur as $cv){
					foreach($useritem as $i){
							
						//Verifica o efeito do item e aplica ao cavaleiro 
						if($i->itm_cura != 0){ //item de efeito de cura
							
							$cv->cvu_hp += $i->itm_cura;
							
							//atualiza variavel de log
							$nomecav = (isset($cv->cvu_apelido) | empty($cv->cvu_apelido)) ? $cv->cav_nome : $cv->cvu_apelido;
							$logat = "<p class='text-warning'>".$nomecav." Usou ".$i->itm_nome.". Restauração de ".$i->itm_cura." pontos de HP!</p>";
							$log = $logat.$this->session->userdata("btl_log");
							$this->session->set_userdata("btl_log",$log);
							
						}elseif($i->itm_recrut != 0){ //item de recrutamento
							
							//chama a função de recrutamento
							//print_r($cavopocur);
							
							foreach($cavop as $co){
								foreach($cavopocur as $coc){
									
									//calcula a porcentagem de HP
									$perhp = porcentagem($coc->atr_hp,$co->atr_hp);
									
									#recupera a porcentagem de recrutamento
									$precrut = $this->cavaleiros_model->getAuxRecrutamento($coc->cls_id,$i->itm_id);
									
									#Calcula a probabilidade de recrutamento
									$probrec = geraTabRecrutRank($precrut, $coc->atr_level, $perhp);
									
									if($probrec == "TRUE"){
										
										$opodie = TRUE;
									}elseif($probrec == "FALSE"){
										
										$opodie = FALSE;
									}

								}
							}
							
							//exit(0);
							
						}elseif($i->itm_cstatus != 0){ //item que tira status de batalha
							
							#exclui os efeitos do usuario
							$useref = array("efeito"=>$c->cvu_status,"cont"=>0,"efcura"=>0,"efdano"=>0,"efatk"=>TRUE);
							$this->session->set_userdata("btl_usercav_status",$useref);
							
							//atualiza variavel de log
							$nomecav = (isset($cv->cvu_apelido) | empty($cv->cvu_apelido)) ? $cv->cav_nome : $cv->cvu_apelido;
							$logat = "<p class='text-warning'>".$nomecav." Usou ".$i->itm_nome.". TODOS os Efeitos cancelados!</p>";
							$log = $logat.$this->session->userdata("btl_log");
							$this->session->set_userdata("btl_log",$log);
						}
						
						//subtrai o item usado
						$qtd = $i->usi_qtde - 1;
						
						//remove o item do registro do usuario
						if($qtd <= 0){ //item usado acabou
							
							$this->itens_model->removeItem($this->session->userdata("uid"),$itmid);
						}else{
							
							//atualiza a qtde
							$data = array("usi_qtde"=>$qtd);
							$this->itens_model->updateUserItem($this->session->userdata("uid"),$itmid,$data);
						}
						
					}
				}
				
				#Controla os turnos
				//pega o lvl do usuario e oponente
				$userlvl = null;
				$oponentlvl = null;
				foreach($cavucur as $cu){
					$userlvl = $cu->cvu_level;
				}
				foreach($cavopocur as $op){
					$oponentlvl = $op->atr_level;
				}

				//pega a variavel de status de usuario e oponente
				$useref = $this->session->userdata("btl_usercav_status");
				$oponentef = $this->session->userdata("btl_oponent_status");
				
				//Verifica se usuario possui efeito;
				$this->verificaEfeito($useref,$cavucur,$oponentlvl);
				
				//atualiza dados do usuario
				$this->atualizaTurno($cavucur);
				
				//verifica se oponente morreu
				//$opodie = $this->checkDie($cavopocur);
				
				if($opodie == FALSE){
					//Verifica se oponente possui efeito
					$this->verificaEfeito($oponentef,$cavopocur,$userlvl);
					if($oponentef["efatk"] == TRUE){
						$this->battleReturno($cavucur,$cavopocur,$opotec, $useref);
					}
				}
				
				//atualiza dados do usuario
				$this->atualizaTurno($cavucur);
				
				//verifica se usuario morreu
				$userdie = $this->checkDieTurno($cavucur,$lineup);
				
				if($userdie == TRUE){
					#guarda dados da derrota no banco
					$user = $this->users_model->getUser($this->session->userdata("uid"));
					
					foreach($user as $s){
						$derrotas = $s->usu_derrotas;
					}
					
					$derrotas += 1;
					
					#atribui o dinheiro a conta do usuario
					$datau = array("usu_derrotas" => $derrotas);
					$this->users_model->update($datau,$this->session->userdata("uid"));
					
					//redireciona para página de derrota
					redirect("batalha/derrota","refresh");
					
				}elseif($opodie == TRUE){
					
					#guarda dados da vitoria no banco
					$user = $this->users_model->getUser($this->session->userdata("uid"));
					
					foreach($user as $s){
						//$vitorias = $s->usu_vitorias;
						$money = $s->usu_money;
					}
					
					#Calcula o XP 
					$exp = $this->battleCalcXp($cavopocur,null,false);
					
					#Verifica o drop do dinheiro e soma ao dinheiro do usuario
					$logmoney = 0;
					foreach($cavopocur as $c){
						$moneycav = $c->atr_dropmoney;
						$logmoney = $c->atr_dropmoney;
					}
					
					$money += $moneycav;

					#filtra o array de cavaleiros que lutaram
					$cavlutou = array_unique($this->session->userdata("btl_cavlutou"));
					if(empty($cavlutou)){ //se for um recrutamento direto atribui o xp ao cavaleiro ativo
						foreach($cavucur as $u){
							$this->battleCavLutou($u->cvu_id); #adiciona id do cavaleiro que lutou para calculo de distribuição de xp ao fim da batalha
							$cavlutou = array_unique($this->session->userdata("btl_cavlutou"));
						}
					}
					$qtd = count($cavlutou);

					#---divide o xp pelo nr de cav que lutararam e atuaiza o xp de cada um ----
					$partxp = $exp/$qtd;
					if($partxp < 1){ //se q qtd de xp fo menor que 1 atribui 1 de xp a cada cav que lutou
						$partxp = 1;
					}
					
					foreach($cavlutou as $c){
						
						//Pega os cavaleiros que lutaram e atribui xp a eles
						$cavp = $this->cavaleiros_model->getCavByCvu($c);
						
						foreach($cavp as $cp){
							
							$cavxp = ($cp->cvu_exp + $partxp);
							
							//Verifica se tem item se aumento de xp equipado
							if($cp->cvu_equipitem != 0){
								
								//busca o item equipado
								$itemequip = $this->itens_model->getItem($cp->cvu_equipitem);
								foreach($itemequip as $itm){
									$cavxp = round($cavxp * $itm->itm_fatorxp); //aumenta o xp pelo fator de aumento do item
								}
								
							}
							
							$data = array("cvu_exp"=>$cavxp);
							$this->cavaleiros_model->updateCavUser($cp->cvu_id,$data);
						}
					}
					#---FIM divide o xp pelo nr de cav que lutararam e atuaiza o xp de cada um ----
					
					#atribui o dinheiro a conta do usuario
					$datau = array("usu_money" => $money);
					$this->users_model->update($datau,$this->session->userdata("uid"));
					
					#Coleta os dados do oponente e adiciona aos cavaleiros do usuario
					foreach($cavopocur as $cu){
						foreach($opotec as $opt){ //ultima tecnica usada do cavaleiro
						
							$datacavrec = array('usu_id'=>$this->session->userdata('uid'),
												'cav_id'=>$cu->cav_id,
												'cvu_classe'=>$cu->cls_id,
												'cvu_level'=>$cu->atr_level,
												'cvu_hp'=>$cu->atr_hp,
												'cvu_tec1'=>$opt->tec_id,
												'cvu_tec1desc'=>$opt->tec_desc,
												'cvu_tec1pp'=>$opt->tec_pp
												
							);
							
							//print_r($datacavrec);
							$this->cavaleiros_model->insertCavini($datacavrec);
						}
						
						//atualiza variavel de log registrando estat de Batalha
						$usuario = $this->session->userdata("username");
						$logat = "<p class='text-success'>".$usuario." <b>RECRUTOU</b> ".$cu->cav_nome." com Sucesso! Recebeu <b>EXP: $exp; DINHEIRO: $logmoney</b></p>";
						$log = $logat.$this->session->userdata("btl_log");
						$this->session->set_userdata("btl_log",$log);
					}
					
					//redireciona para página de derrota
					redirect("batalha/vitoria","refresh");
					
				}else{
					
					//Cavaleiro nao foi recrutado, atualiza o log
					//atualiza variavel de log registrando estat de Batalha
					$usuario = $this->session->userdata("username");
					$logat = "<p class='text-warning'>".$usuario." <b>TENTOU RECRUTAR</b> ".$cu->cav_nome." sem Sucesso!</p>";
					$log = $logat.$this->session->userdata("btl_log");
					$this->session->set_userdata("btl_log",$log);
					
					redirect('batalha?op=pas','refresh');
				}
				
				break;
			case "alt":
				
				$novocav = trim($this->input->get("cvu"));
				
				#recupera os dados do novo cavaleiro
				$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
				$this->session->set_userdata("btl_lineup",$lineup);
				
				$ind = count($lineup);
				for($i=0;$i<$ind;$i++){
					
					if($lineup[$i]->cvu_id == $novocav){
						
						$cavsel[] = $lineup[$i];
						break;
					}
				}
				
				#atualiza a seção de batalha
				$this->session->set_userdata("btl_usercav",$cavsel);
				$this->session->set_userdata("btl_usercav_cur",$cavsel);
				
				$this->load->view('inicial_interna',array("pag"=>'v_batalha',"itens"=>$itens));

				break;
			case "run":
				#chama funcao fugir, contabiliza o dano ate o momento
				//redireciona para página de derrota
				redirect("batalha/derrota","refresh");
				break;
			default:  

				$opoid = trim($this->input->get("opoid"));
				$opolvl = trim($this->input->get("opolvl"));

				#Busca dados do cavaleiro oponente e seus dados de batalha
				$cavop = $this->cavaleiros_model->getCavOpo($opoid,$opolvl);
				$cavopcur = $this->cavaleiros_model->getCavOpo($opoid,$opolvl);

				#Busca a lineup do usuario
				$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
				
				#Seleciona o cavaleiro que nao está morto para iniciar a batalha
				$ind = count($lineup);
				for($i=0;$i<$ind;$i++){
					
					if($lineup[$i]->cvu_hp > 0){
						$cavu[] = $lineup[$i];
						break;
					}
				}
				
				$this->session->set_userdata("btl_usercav",$cavu);
				$this->session->set_userdata("btl_usercav_cur",$cavu);
				
				//cria a variavel de status (Efeito) do usuario
				foreach($cavu as $c){
					$this->session->set_userdata("btl_usercav_status",array("efeito"=>$c->cvu_status,"cont"=>0,"efcura"=>0,"efdano"=>0,"efatk"=>TRUE));
				}
				
				//print_r($cavucur);
				#Cria a sessao de dados do oponente, do cavaleiro e do lineup
				$this->session->set_userdata("btl_oponent",$cavop);
				$this->session->set_userdata("btl_oponent_cur",$cavopcur);
				
				/*
				 * Baseado no level do oponente, seleciona as técnicas que podem ser usadas 
				 * pelo mesmo, então sorteia a quantidade de tecnicas (de 1 a 5) e cria o vetor de
				 * tecnicas. quando o cavaleiro for recrutado, as tecnicas aleatorias selecionadas
				 * são incluidas no registro do cavaleiro.
				 */
				$tecbasopo = $this->tecnicas_model->getTecnicasBasicas($opolvl);
				$teccavopo = $this->tecnicas_model->getTecnicasByCav($opoid,$opolvl);

				$tecopo = null;
				if(!is_null($teccavopo)){
					$tecopo = array_merge($tecbasopo,$teccavopo);
				}else{
					$tecopo = $tecbasopo;
				}

				$this->session->set_userdata("btl_oponent_tec",$tecopo);
				
				//cria a variavel de status (Efeito) do oponente para zero
				$this->session->set_userdata("btl_oponent_status",array("efeito"=>0,"cont"=>0,"efcura"=>0,"efdano"=>0,"efatk"=>TRUE));
				
				#Cria variavel que controla os cavaleiros do usuario que lutaram
				#Variavel vai ser preenchida com um array após o cavaleiro usado executar um golpe;
				$res = [];
				$this->session->set_userdata("btl_cavlutou",$res);
				
				#Cria a variavel de seção que guarda o status das lutas;
				$this->session->set_userdata("btl_log","");
				
				$this->session->set_userdata("btl_lineup",$lineup);
				
				$this->load->view('inicial_interna',array("pag"=>'v_batalha',"itens"=>$itens));
		}  
	}
	
	public function batalha_cura(){
		
		verifyUser();
		
		$heal = trim($this->input->get("pt"));
		$cvu = trim($this->input->get("cvu"));
		
		#busca o cavaleiro 
		$cavu = $this->cavaleiros_model->getCavByCvu($cvu);
		foreach($cavu as $c){
			
			#soma o heal passado no hp do cavaleiro
			$cura = $c->cvu_hp + $heal; //hack para efeito de cura
			
			if($cura >= $c->atr_hp){ //se o hp estiver no maximo, mantem no maximo
				$cura = $c->atr_hp;
			}
			
			$data = array("cvu_hp" => $cura);
			
			#atualiza os dados do Cavaleiro
			$this->cavaleiros_model->updateCavUser($c->cvu_id,$data);
		
			#gera o log de efeito
			$efdesc = checkEfeito(1); //efeito de cura
			$nomecav = (empty($c->cvu_apelido)) ? $c->cav_nome : $c->cvu_apelido;
			$logat = "<p class='text-warning'>".$nomecav." Efeito $efdesc ativado. Curou $heal de HP!</p>";
			$log = $logat.$this->session->userdata("btl_log");
			$this->session->set_userdata("btl_log",$log);
		}
		
		#zera o efeito do oponente
		$oponentef = $this->session->userdata("btl_oponent_status");
		$oponentef["efeito"] = 0;
		$oponentef["efcura"] = 0;
		$this->session->set_userdata("btl_oponent_status",$oponentef);
		
		//redireciona para a pagina de batalha
		redirect("batalha?op=pas","refresh");
	}
	
	/*
	 * Recebe a tecnica usada pelo usuario e calcula os danos no cavaleiro oponente
	 * Depende das seções de batalha terem sido criadas para executar a função
	 * @usuario - vetor de atributos do atacante;
	 * @oponente - vetor de atributo do atacado;
	 * @slot - tecnica do usuario que foi utilizada;
	 * @tecnica - tecnica do usuario;
	 * @opstatus - array de status do oponente;
	 * 
	 */
	public function battleUserAtk($usuario,$oponente,$slot,$tecnica,$opstatus){
		
		#Verifica a sessao iniciada
		verifyUser();		
		 
		foreach($usuario as $at){
			foreach($oponente as $atq){
				
				//Verifica se usuario tem PP
				if($at->$slot < 1){ //Se o PP for menor que 1 nao pode usar a tecnica
					
					//atualiza variavel de log
					$nomecav = (empty($at->cvu_apelido)) ? $at->cav_nome : $at->cvu_apelido;
					$logat = "<p class='text-info'>".$nomecav." Não possui PP suficiente!</p>";
					$log = $logat.$this->session->userdata("btl_log");
					$this->session->set_userdata("btl_log",$log);
					
				}else{
					
					//Determina se o ataque é normal, ou avançado
					$vantm = "";
					foreach($tecnica as $t){
					
						$tecdesc = $t->tec_desc; #nome da tecnica. usada no log de batalha
						
						if($t->tec_basica == 1){
						
							#Executa ataque normal
							//$dano = $atq->atr_hp;
							$dano = DanoNormal($at->cvu_level,$at->atr_atk,$t->tec_forca,$atq->atr_def); //Função que calcula dano normal
						
						}else{
							
							#Executa ataque especial Normal
							$dano = DanoEspecial($at->cvu_level,$at->atr_spatk,$t->tec_forca,$atq->atr_spdef);
							
							#dano de tecnica avançada, verifica usuario e oponente de mesmo tipo
							if($t->tec_tipo == $atq->cav_tipo){
								
								$dano = DanoEspMesmoTipo($at->cvu_level,$at->atr_spatk,$t->tec_forca,$atq->atr_spdef); //Calcula dano de mesmo tipo
								
							}else{
								
								$dano = DanoEspVantagemTipo($at->cvu_level,$at->atr_spatk,$t->tec_forca,$atq->atr_spdef); //Calcula dano de vantagem de tipo
							
								//consulta o tipo da tecnica e o tipo do oponente para verificar vantagem ou desvantagem
								$tecvant = $this->tecnicas_model->getTecVantagem($t->tec_tipo,$atq->cav_tipo);
								foreach($tecvant as $tv){
									if($tv->tip_operador == 'V'){ //Atribui ataque com desvantagem
										
										$dano = round($dano * 2); //aumenta o dano com vantagem
										$vantm = "Vantagem de Tipo";
										
									}elseif($tv->tip_operador == 'D'){
										
										$dano = round($dano * 0.5); //Reduz o dano em 50%
										$vantm = "Desvantagem de Tipo";
									}
								}
							}
						}
						
						#verifica se a tecnica tem um efeito e ativa o efeito no oponente
						if($t->tec_status != 0){
								
							$opstatus["efeito"] = $t->tec_status; //muda o status do oponente apos o ataque
							$opstatus["efcura"] = $dano; //caso o status do oponente seja de cura, usa esta variavel para restaurar HP.
						
							if($t->tec_status == 5){ //congelamento
								$opstatus["cont"] = 2;
							}elseif($t->tec_status == 6){ //paralisia
								$opstatus["cont"] = 1;
							}elseif($t->tec_status == 7 & $atq->atr_atk < 100){ //bloqueio (força de ataque do cavaleiro menos que 100)
								$opstatus["cont"] = 1;
							}
							
							if($t->tec_status == 8){ //ataque suicida (Espera-se que mate o inimigo, pois caso haja returno, perderá a batalha)
								$at->cvu_hp = 1;
							}
						}
					}
					
					
					$at->$slot -= 1; #subtrai do pp usado do atacante
					
								
					$atq->atr_hp -= $dano; #subtrai o dano do oponente
					$this->battleCavLutou($at->cvu_id); #adiciona id do cavaleiro que lutou para calculo de distribuição de xp ao fim da batalha
					
					//hack para nao ocorrer dano num ataque de cura
					if($opstatus["efeito"] == 1){
						$atq->atr_hp += $dano; 
					}
					
					//atualiza variavel de log
					$nomecav = (isset($at->cvu_apelido) | empty($at->cvu_apelido)) ? $at->cav_nome : $at->cvu_apelido;
					$logat = "<p class='text-info'>".$nomecav." Atacou com $tecdesc. $vantm. $dano de Dano em ".$atq->cav_nome."</p>";
					$log = $logat.$this->session->userdata("btl_log");
					$this->session->set_userdata("btl_log",$log);
				}
			}
		}
		
		#Atualiza sessao de batalha
		$this->session->set_userdata("btl_oponent_status",$opstatus);
		$this->session->set_userdata("btl_usercav_cur",$usuario);
		$this->session->set_userdata("btl_oponent_cur",$oponente);
	}
	
	/*
	 * Verifica se cavaleiro lutou e coloca no array de participantes
	*/
	function battleCavLutou($idcav){
		
		$varsess = $this->session->userdata("btl_cavlutou");
	
		array_push($varsess,$idcav);

		$this->session->set_userdata("btl_cavlutou",$varsess);
	}
	
	/*
	 * Usa uma tecnica aleatoria do oponente e calcula o dano no usuário
	 * @usuario - vetor de atributos do atacante;
	 * @oponente - vetor de atributo do atacado;
	 * @tecnica - tecnica do oponente sorteada aleatoriamente;
	 * @userstatus - array de status do usuario;
	 */
	public function battleReturno($usuario, $oponente, $tecnica, $userstatus){
		
		verifyUser();
		
		foreach($usuario as $at){
			foreach($oponente as $atq){        
				
				#verifica tecnica basica, ou avançada e usa o algoritmo correto
				$vantm = "";
				foreach($tecnica as $t){
			
					$tecdesc = $t->tec_desc; #nome da tecnica. usada no log de batalha
					
					if($t->tec_basica == 1){

						#Executa ataque normal
						
						$dano = DanoNormal($atq->atr_level,$atq->atr_atk,$t->tec_forca,$at->atr_def); //Função que calcula dano normal

					}else{
						
						#Executa ataque especial Normal
						$dano = DanoEspecial($atq->atr_level,$atq->atr_spatk,$t->tec_forca,$at->atr_spdef);
						
						#dano de tecnica avançada, verifica usuario e oponente de mesmo tipo
						if($t->tec_tipo == $at->cav_tipo){
								
							$dano = DanoEspMesmoTipo($atq->cvu_level,$atq->atr_spatk,$t->tec_forca,$at->atr_spdef); //Calcula dano de mesmo tipo
								
						}else{
								
							$dano = DanoEspVantagemTipo($atq->cvu_level,$atq->atr_spatk,$t->tec_forca,$at->atr_spdef); //Calcula dano de vantagem de tipo
							
							//consulta o tipo da tecnica e o tipo do oponente para verificar vantagem ou desvantagem
							$tecvant = $this->tecnicas_model->getTecVantagem($t->tec_tipo,$at->cav_tipo);
							foreach($tecvant as $tv){
								if($tv->tip_operador == 'V'){ //Atribui ataque com desvantagem
										
									$dano = round($dano * 2);
									$vantm = "Vantagem de Tipo";
									
								}elseif($tv->tip_operador == 'D'){ //Atribui ataque com desvantagem
								
									$dano = round($dano * 0.5); //Reduz o dano em 50%
									$vantm = "Desvantagem de Tipo";
								}
							}
						}

					}
					
					#verifica se a tecnica tem um efeito e ativa o efeito no oponente
					if($t->tec_status != 0){
								
						$userstatus["efeito"] = $t->tec_status; //muda o status do oponente apos o ataque
						$userstatus["efcura"] = $dano; //caso o status do oponente seja de cura, usa esta variavel para restaurar HP.
						
						if($t->tec_status == 5){ //congelamento
							$opstatus["cont"] = 2;
						}elseif($t->tec_status == 6){ //paralisia
							$opstatus["cont"] = 1;
						}elseif($t->tec_status == 7 & $atq->atr_atk < 100){ //bloqueio (força de ataque do cavaleiro menos que 100)
							$opstatus["cont"] = 1;
						}
						
						if($t->tec_status == 8){ //ataque suicida
							$atq->cvu_hp = 1;
						}
					}
				}
					
				#subtrai o hp do oponente
				$at->cvu_hp -= $dano;
					
				//atualiza variavel de log
				$nomecav = (isset($at->cvu_apelido) | empty($at->cvu_apelido)) ? $at->cav_nome : $at->cvu_apelido;
				$logat = "<p class='text-info'>".$atq->cav_nome." Atacou com $tecdesc. $vantm. $dano de Dano em ".$nomecav."!</p>";
				$log = $logat.$this->session->userdata("btl_log");
				$this->session->set_userdata("btl_log",$log);
			}
		} 
		
		#Atualiza sessao de batalha
		$this->session->set_userdata("btl_usercav_status",$userstatus);
		$this->session->set_userdata("btl_usercav_cur",$usuario);
		$this->session->set_userdata("btl_oponent_cur",$oponente);
	}

	/*
	 * Função que checa o status (efeito) do usuario
	 * @status - variavel de status a verificar (usuario ou oponente)
	 * @lutador - dados de batalha do lutador (usuario ou oponente)
	 * @opolvl - level do oponente (se for usuario, lvl do oponente e vice versa)
	 */
	 public function verificaEfeito($status, $lutador, $opolvl){
		 
		 foreach($lutador as $l){
			 if($status["efeito"] == 1){ 
				 
				 //Executa o efeito de cura
				 
				 
			 }elseif($status["efeito"] == 2 | $status["efeito"] == 3 | $status["efeito"] == 4){ 
				 
				 //Executa o efeito de envenenamento, sangramento e queimadura
				 $ef = $opolvl / 3;

				 if($ef <= 1){
					 $ef = 1;
				 }else{
					 $ef = round($ef);
				 }

				
				 
				 if(isset($l->cvu_id)){ //efeito em usuario
					 
					 $l->cvu_hp -= $ef;
					 
				 }else{ //efeito em oponente
				 
					 $l->atr_hp -= $ef;
				 }	
				 
				 //Atualiza variaveis de sessão de batalha
				 if(isset($l->cvu_id)){
					$this->session->set_userdata("btl_usercav_cur",$lutador);
				 }else{
					$this->session->set_userdata("btl_oponent_cur",$lutador);
				 }
				 
				 //atualiza variavel de log
				 $efdesc = checkEfeito($status["efeito"]);
				  
				 $nomecav = (isset($at->cvu_apelido) | empty($l->cvu_apelido)) ? $l->cav_nome : $l->cvu_apelido;
				 $logat = "<p class='text-warning'>".$nomecav." Efeito $efdesc ativado. $ef de Dano!</p>";
				 $log = $logat.$this->session->userdata("btl_log");
				 $this->session->set_userdata("btl_log",$log);
			 }elseif($status["efeito"] == 5){
				 
				 //Executa o efeito de congelamento
				 if($status["cont"] > 0){ 
					 
					 $status["cont"] -= 1; //subtrai contador de efeito;
					 $status["efatk"] = FALSE;
					 
					 //atualiza variavel de log
					 $turnos = $status["cont"] + 1; //para mostrar contagem certa no log
					 $efdesc = checkEfeito($status["efeito"]);
				 
					 $nomecav = (isset($at->cvu_apelido) | empty($l->cvu_apelido)) ? $l->cav_nome : $l->cvu_apelido;
					 $logat = "<p class='text-warning'>".$nomecav." Efeito $efdesc ativado. Não ataca por $turnos Turno(s)!</p>";
					 $log = $logat.$this->session->userdata("btl_log");
					 $this->session->set_userdata("btl_log",$log);
				 }else{
					 
					 $status["cont"] = 0; //subtrai contador de efeito;
					 $status["efatk"] = TRUE;
					 $status["efeito"] = 0; //acaba o efeito
				 }
				
				 //Atualiza variaveis de sessão de batalha
				 if(isset($l->cvu_id)){
					$this->session->set_userdata("btl_usercav_status",$status);
				 }else{
					$this->session->set_userdata("btl_oponent_status",$status);
				 }
				 
			 }elseif($status["efeito"] == 6){
				 
				 //Executa o efeito de paralisia
				 if($status["cont"] > 0){
					 
					$paral = array(TRUE,FALSE);
					$ind = array_rand($paral);
				 
					$status["efatk"] = $paral[$ind];
					
					$status["cont"] -= 1; //subtrai contador de efeito;
					
					//atualiza variavel de log
					$efdesc = checkEfeito($status["efeito"]);
					
					$nomecav = (isset($at->cvu_apelido) | empty($l->cvu_apelido)) ? $l->cav_nome : $l->cvu_apelido;
					$logat = "<p class='text-warning'>".$nomecav." Efeito $efdesc ativado. 50% de chance de Atacar no proximo Turno!</p>";
					$log = $logat.$this->session->userdata("btl_log");
					$this->session->set_userdata("btl_log",$log);
				 }else{
					 
					 $status["cont"] = 0; //subtrai contador de efeito;
					 $status["efatk"] = TRUE;
					 $status["efeito"] = 0; //acaba o efeito
				 }
				 
				 //Atualiza variaveis de sessão de batalha
				 if(isset($l->cvu_id)){
					$this->session->set_userdata("btl_usercav_status",$status);
				 }else{
					$this->session->set_userdata("btl_oponent_status",$status);
				 }
			 }elseif($status["efeito"] == 7){
				 
				 //executa o efeito de bloqueio
				 if($status["cont"] > 0){ 
					 
					 $status["efatk"] = FALSE;
					 $status["cont"] -= 1; //subtrai contador de efeito;
					 
					 //atualiza variavel de log
					 $turnos = $status["cont"] + 1; //para mostrar contagem certa no log
					 $efdesc = checkEfeito($status["efeito"]);
				 
					 $nomecav = (isset($at->cvu_apelido) | empty($l->cvu_apelido)) ? $l->cav_nome : $l->cvu_apelido;
					 $logat = "<p class='text-warning'>".$nomecav." Efeito $efdesc ativado. Não ataca por $turnos Turno(s)!</p>";
					 $log = $logat.$this->session->userdata("btl_log");
					 $this->session->set_userdata("btl_log",$log);
				 }else{
					 
					 $status["cont"] = 0; //subtrai contador de efeito;
					 $status["efatk"] = TRUE;
					 $status["efeito"] = 0; //acaba o efeito
				 }
				 
				 //Atualiza variaveis de sessão de batalha
				 if(isset($l->cvu_id)){
					$this->session->set_userdata("btl_usercav_status",$status);
				 }else{
					$this->session->set_userdata("btl_oponent_status",$status);
				 }
			 }elseif($status["efeito"] == 8){ 
				 
				 //executa efeito morte (Ataque suicida)
				 
			 }
		 }
	 }	
	
	/* Função que checa se todo o lineup do usuario esta em condições de lutar
	 * @lineup - dados de batalha do lutador (usuario ou oponente)
	 * retorna TRUE ou FALSE
	 */
	public function checkLineup($lineup){
		
		verifyUser();
		
		$ind = count($lineup);

		//cria um vetor de teste para ver se cada cavaleiro morreu
		$teste[] = null;
		for($i=0;$i<$ind;$i++){
			$teste[$i] = 0;
		}
		
		//testa se o hp ta zerado
		for($i=0;$i<$ind;$i++){
			if($lineup[$i]->cvu_hp <= 0){
				$teste[$i] = 1;
			}
		}
		
		$result = array_unique($teste);

		if (count($result) == 1){
			if($result[0] == 1){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
		
		exit(0);
	}
	
	/* Função que checa se todo o lineup do usuario esta em condições de lutar
	 * @lineup - dados de batalha do lutador oponente
	 * retorna TRUE ou FALSE
	 */
	public function checkOponentLineup($lineup){
		
		verifyUser();
		
		$ind = count($lineup);

		//cria um vetor de teste para ver se cada cavaleiro morreu
		$teste[] = null;
		for($i=0;$i<$ind;$i++){
			$teste[$i] = 0;
		}
		
		//testa se o hp ta zerado
		for($i=0;$i<$ind;$i++){
			if($lineup[$i]->atr_hp <= 0){
				$teste[$i] = 1;
			}
		}
		
		//verifica se o hp foi zerado
		$result = array_unique($teste);

		if (count($result) == 1){
			if($result[0] == 1){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	/* Função que checa se o lutador morreu
	 * @lutador - dados de batalha do lutador (usuario ou oponente)
	 * retorna TRUE/FALSE com a condição do usuario
	 */
	public function checkDie($lutador){
		
		verifyUser();
		
		foreach($lutador as $l){
						
			if($l->atr_hp <= 0){ 
					
				$l->atr_hp = 0;
				$this->session->set_userdata("btl_oponent_cur",$lutador);
					
				return TRUE;
			}
			
			return FALSE;
		}
	}

	/*
	 * Função que checa se lutador morreu a cada turno. Passando um lineup, checa qual o proximo a ser invocado em caso de morte
	 * 
	 */
	public function checkDieTurno($lutador){
	
		verifyUser();
		
		foreach($lutador as $l){
				
			//lineup de usuario
			if($l->cvu_hp <= 0){
					
				$this->atualizaTurno($lutador); //atualiza dado do usuario
				
				#Testa se o lineup ainda tem alguem vivo
				$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
				
				$testedie = $this->CheckLineup($lineup);
				
				if($testedie != 1){ //se ainda tiver alguem vivo no lineup
					#Seleciona o cavaleiro que nao está morto para iniciar a batalha
					$ind = count($lineup);
					for($i=0;$i<$ind;$i++){
						if($lineup[$i]->cvu_hp > 0){
							$cvuid = $lineup[$i]->cvu_id;
							break;
						}
					}
					
					//echo "Proximo cav vivo: $cvuid";
					redirect(base_url()."index.php/batalha?op=alt&cvu=".$cvuid,"refresh");
				}else{
					
					return TRUE;
				}
			}
		}
	}
	
	/*
	 * Calcula a Qtd de XP que um oponente cede ao usuario apos uma vitoria
	 * @oponente - array de atributos do oponente
	 * @tpp - Selvagem ou PvP
	 * @incxp - Usuário possui item de aumento de xp
	 */
	function battleCalcXp($oponente, $tpp, $incxp){ 
		
		foreach($oponente as $o){
			
			if($tpp == "pvp"){ //se o oponente é selvagem ou pvp
				$a = 1.5;
			}else{
				$a = 1;
			}
			
			if($o->atr_level > 50){ //se o oponente é level maior que 50
				$f = 1.2;
			}else{
				$f = 1;
			}
			
			$peso = $this->mapas_model->getMapPesoByRaridade($o->cav_raridade); //recupera o peso pela raridade do cavaleiro
			foreach($peso as $p){
				$s = $p->pes_calcxp;
			}
			
			$exp = ($a * $o->atr_exptotal * $o->atr_level * $f * $o->cls_calcxp) / (7 * $s);
			
			if($exp > 0 & $exp <= 1){
				$exp = 1;
			}
			return round($exp);
			
		}
	}

	/*
	 * Função que atualiza os dados de batalha do usuario a cada turno
	 * @cavucur - vetor de dados de batalha do usuario
	 */
	public function atualizaTurno($cavucur){
		
		#Verifica a sessao iniciada
		verifyUser();
		
		$useref = $this->session->userdata("btl_usercav_status");
		$cid = null;
		
		foreach($cavucur as $c){
			
			$cid = $c->cvu_id; //pega o id do cavaleiro do usuario
			
			if($c->cvu_hp <= 0){ //hp e menor que zero
				$c->cvu_hp = 0;
			}
			
			if($c->cvu_hp >= $c->atr_hp){ //HP é maior que o HP maximo do level
				$c->cvu_hp = $c->atr_hp;
			}
			
			$data = array("cvu_hp" => $c->cvu_hp,
						  "cvu_status"=>$useref["efeito"], //cada turno atualiza o efeito do cavaleiro
						  "cvu_tec1pp" => $c->cvu_tec1pp,
						  "cvu_tec2pp" => $c->cvu_tec2pp,
						  "cvu_tec3pp" => $c->cvu_tec3pp,
						  "cvu_tec4pp" => $c->cvu_tec4pp,
						  "cvu_tec5pp" => $c->cvu_tec5pp);
						  
			$this->cavaleiros_model->updateCavTurno($c->cvu_id,$data);
		}
		
		//Atualiza o lineup do usuario
		$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		$this->session->set_userdata("btl_lineup",$lineup);
		
		//Atualiza a secao de batalha do usuario
		$ind = count($lineup);
		for($i=0;$i<$ind;$i++){
			if($lineup[$i]->cvu_id == $cid){
				$cavatu[] = $lineup[$i];
				break;
			}
		}
		$this->session->set_userdata("btl_usercav_cur",$cavatu);
	}

	/*
	 * Função que verifica a xp dos cavaleiros do usuario e atualiza conforme o level
	 * #protegida pelo controle de sessao
	 */
	public function verificaLevel(){

		#Verifica a sessao iniciada
		verifyUser();

		#Recupera o lineup do usuario
		$lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
	
		#percorre o lineup
		foreach($lineup as $lp){
			
			#busca os atributos do proximo level da classe de cada cavaleiro
			$nextlevel = $this->atributos_model->getNextAttr($lp->cvu_level,$lp->cls_id);
			

			foreach($nextlevel as $nl){

				if($lp->cvu_exp > $lp->atr_expnext){

					$data = array("cvu_level"=>$nl->atr_level,
								  "cvu_hp"=>$nl->atr_hp);

					$this->cavaleiros_model->updateCavUser($lp->cvu_id,$data);

				}

			}
			
		}



	}
	
	/*
	 * Função de carregamento da pagina de mapas e missoes
	 * #protegina pelo controle de sessao
	 */
	public function missoes(){
		
		#Verifica a sessao iniciada
		verifyUser();
		
		#Busca os dados dos cavaleiros
		//$cavsu = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		//$cavsall = $this->cavaleiros_model->getCavsByUser($this->session->userdata("uid"));
		
		$this->load->view('inicial_interna',array("pag"=>'v_missoes'));
	}
	
	/*
	 * Função de carregamento da pagina de mapas e missoes
	 * #protegina pelo controle de sessao
	 */
	public function desafios(){
		
		#Verifica a sessao iniciada
		verifyUser();
		
		#Busca os dados dos cavaleiros
		//$cavsu = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
		//$cavsall = $this->cavaleiros_model->getCavsByUser($this->session->userdata("uid"));
		
		//$this->load->view('inicial_interna',array("pag"=>'v_desafios')); //alterada para testes
		$this->load->view('inicial_interna',array("pag"=>'v_genmap'));
	}
	
	/*
	 * Faz o logout do usuario e mata as sessoes
	 */
	public function logout(){
		
		verifyUser();
		
		
		#insere a data e hora do login no campo latlogin
		$this->users_model->updateLastlogin(date("Y-m-d H:i:s"),$this->session->userdata('uid'));
		
		# logica para logout aqui
		$this->session->sess_destroy();
		
		#redireciona para a tela inicial
		redirect(base_url(),'refresh');
	}
        
}
