<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cavaleiros extends CI_Controller {

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
		
	}

    /*
     * Chama o formulario de alteração da ordem de lineup no modal da gerencia de cavaleiros
     */
    public function cavmudalineup(){

        #Verifica a sessao iniciada
        verifyUser();

        #seleciona o lineup do usuario
        $lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));

        $this->load->view('frm_meuscavs_lineup',array("lineup"=>$lineup));
    }

    public function cavmudalineuppost(){

        #Verifica a sessao iniciada
        verifyUser();

        $datarec = trim($this->input->post("hdnOrdem"));

        #explode os dados
        $dados = explode(",",$datarec);

        $lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
        $indl = count($lineup);

        if(count($dados) == $indl){

            foreach($dados as $key => $value){

                #explode os dados em cvu e posicao
                //$temp = explode("_",$d);
                $cvu = $value;
                $pos = $key+1;

                #busca o cavaleiro para alterar a posicao
                $cav = $this->cavaleiros_model->getCavByCvu($cvu);
                foreach($cav as $c){

                    $data = array("cvu_ordem"=>$pos);

                    #atualiza os dados do cavaleiro
                    $this->cavaleiros_model->updateCavUser($c->cvu_id,$data);
                }
            }

        }else{

            echo "<script>alert('Você deve selecionar todos os cavaleiros do lineup');</script>";
            
        }

        redirect("dash/equipe", 'refresh');
    }

    /*
     * Gera a pagina de informações do cavaleiro a ser viasualizado na gerencia de cavaleiros
     */
    public function cavinfo(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvu = trim($this->input->get("cvuid"));

        $cavinfo = $this->cavaleiros_model->getCavByCvu($cvu);

        $lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
        $qtdln = count($lineup);

        $troca = $this->cavaleiros_model->getTrocaByCvu($cvu);

        foreach($cavinfo as $ci){

            #busca info de raridade
            $raridade = $this->mapas_model->getMapPesoByRaridade($ci->cav_raridade);

            $this->load->view("v_meuscavs_info",array("cavinfo"=>$cavinfo,"troca"=>$troca,"qtdln"=>$qtdln,"raridade"=>$raridade));
        }    
    }

    /*
     * Gera a pagina de personalização de dados do cavaleiro do usuario
     */
    public function cavpersonalize(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvuid = trim($this->input->get("cvu"));

        #busca cavaleiro por cvu
        $cavu = $this->cavaleiros_model->getCavByCvu($cvuid);

        $troca = $this->cavaleiros_model->getTrocaByCvu($cvuid);

        $this->load->view('inicial_interna',array("pag"=>'v_meuscavs_personalize',
                                          "cavu"=>$cavu,"troca"=>$troca));
    }

    /*
     * Remove o cavaleiro do lineup
     */
    public function cavdellineup(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvuid = trim($this->input->get("cvu"));

        #busca o lineup do usuario
        $lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));

        #Atualiza o campo lineup e ordem para zero
        $cavu = $this->cavaleiros_model->getCavByCvu($cvuid);
        foreach($cavu as $c){

            $data = array("cvu_lineup"=>0,
                          "cvu_ordem"=>0);

            #atualiza os dados do cavaleiro
            $this->cavaleiros_model->updateCavUser($c->cvu_id,$data);
        }

        redirect("dash/equipe", 'refresh');

    }

    /*
     * Adiciona o cavaleiro ao lineup até o limite de 6 cavaleiros
     */
    public function cavaddlineup(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvuid = trim($this->input->get("cvu"));

        #busca o lineup do usuario para verificar quantos tem
        $lineup = $this->cavaleiros_model->getCavsLineup($this->session->userdata("uid"));
        $qtdln = count($lineup);

        if($qtdln < 6){ //se tem menos de 6 cavs no lineup adiciona o cav na primeira posição vaga

            #verifica a primeira posicao vaga do lineup
            for($i=1;$i<=6;$i++){

                $cavpos = $this->cavaleiros_model->getCavLineupByOrdem($this->session->userdata("uid"),$i);
                

                if(empty($cavpos)){ //nao encontrou cavaleiro nessa posicao

                    #recupera o cavaleiro a ser adicionado no lineup e atualiza os dados
                    $cavu = $this->cavaleiros_model->getCavByCvu($cvuid);
                    foreach($cavu as $c){

                        $data = array("cvu_lineup"=>1,
                                      "cvu_ordem"=>$i);

                        #atualiza a tecnica do cavaleiro
                        $this->cavaleiros_model->updateCavUser($c->cvu_id,$data); 
                    }

                    break;
                }
            }
        }else{

            #imprime mensagem de erro
        }

        redirect("dash/equipe", 'refresh');
    }

    /*
     * Altera o apelido do cavaleiro
     */
    public function cavalterapelido(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvuid = trim($this->input->post("hdnCvu"));
        $cvuap = trim($this->input->post("txtApelido"));

        #busca as info do cavaleiro do usuario
        $cav = $this->cavaleiros_model->getCavByCvu($cvuid);
        foreach($cav as $c){

            #monta o array de dados para atualizar o valor
            $data = array("cvu_apelido"=>$cvuap);

            #atualiza a tecnica do cavaleiro
            $this->cavaleiros_model->updateCavUser($c->cvu_id,$data);
        }

        redirect("dash/equipe/personalize/?cvu=$cvuid", 'refresh');
    }

    /*
     * Gera formulario de seleção de tecnicas utilizadas pelo cavaleiro
     */
    public function cavaltertec(){

        #Verifica a sessao iniciada
        verifyUser();

        #slot que sera alterado
        $slot = trim($this->input->get("slt"));

        $cvuid = trim($this->input->get("cvu"));

        #busca as info do cavaleiro do usuario
        $cav = $this->cavaleiros_model->getCavByCvu($cvuid);

        $tecsel = null;
        foreach($cav as $c){

            #busca as tecnicas disponiveis para o cavaleiro
            $tecbas = $this->tecnicas_model->getTecnicasBasicas($c->cvu_level);
            $teccav = $this->tecnicas_model->getTecnicasByCav($c->cav_id,$c->cvu_level);

            $tecnicas = null;
            if(!is_null($teccav)){
                $tecnicas = array_merge($tecbas,$teccav);
            }else{
                $tecnicas = $tecbas;
            }

            #verifica as tecnicas já selecionadas nos slots do cavaleiro
            $ind = count($tecnicas);
            for($i=0;$i<$ind;$i++){
                    
                if(($c->cvu_tec1 != $tecnicas[$i]->tec_id) & ($c->cvu_tec2 != $tecnicas[$i]->tec_id) & ($c->cvu_tec3 != $tecnicas[$i]->tec_id) & ($c->cvu_tec4 != $tecnicas[$i]->tec_id) & ($c->cvu_tec5 != $tecnicas[$i]->tec_id)){
                    
                    $tecsel[] = $tecnicas[$i];
                }
            }
        
        }
        
        $this->load->view('frm_meuscavs_tecnicas',array("tecsel"=>$tecsel,"slot"=>$slot,"cvuid"=>$cvuid));
    }

    /*
     * Função que remove a tecnica selecionada do slot do cavaleiro
     */
    public function cavdelslot(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvuid = trim($this->input->get("cvu"));
        $slot = trim($this->input->get("slot"));

        #busca o cav selecionado
        $cavu = $this->cavaleiros_model->getCavByCvu($cvuid);

        foreach($cavu as $c){

            #monta o array de dados para atualizar o valor
            $data = array("cvu_tec$slot"=>0,
                          "cvu_tec".$slot."desc"=>"",
                          "cvu_tec".$slot."pp"=>0);


            #atualiza a tecnica do cavaleiro
            $this->cavaleiros_model->updateCavUser($c->cvu_id,$data);

        }

        redirect("dash/equipe/personalize/?cvu=$cvuid", 'refresh');
        
    }

    /*
     * Função que recupera os dados de slot e tecnica selecionada e adiciona/altera ao slot do cavaleiro
     */
    public function cavalterslot(){

        #Verifica a sessao iniciada
        verifyUser();

        $cvuid = trim($this->input->get("cvu"));
        $slot = trim($this->input->get("slot"));
        $tecid = trim($this->input->get("tec"));

        #busca o cav selecionado
        $cavu = $this->cavaleiros_model->getCavByCvu($cvuid);

        foreach($cavu as $c){

            #busca a tecnica selecionada
            $tecnica = $this->tecnicas_model->getTecnica($tecid);
            foreach($tecnica as $t){

                #monta o array de dados para atualizar o valor
                $data = array("cvu_tec$slot"=>$t->tec_id,
                              "cvu_tec".$slot."desc"=>$t->tec_desc,
                              "cvu_tec".$slot."pp"=>$t->tec_pp);

                #atualiza a tecnica do cavaleiro
                $this->cavaleiros_model->updateCavUser($c->cvu_id,$data);
            }
        }

        redirect("dash/equipe/personalize/?cvu=$cvuid", 'refresh');
        

    }


            
        /*
         * Faz o cadastro de usuario.
         */
        public function cadastrar()
        {
            
            $this->load->library('form_validation');
            
            #<--- Configura os textos de erro --->
            $this->form_validation->set_error_delimiters('<div class="text-danger"><small>', '</small></div>');
            
            #<--- Prepara a validacao dos campos do formulario --->
            $this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[5]',
                array(
                        'required' => 'O Campo {field} é requerido!', 
                        'min_length' => 'O Campo {field} deve conter mais de 5 caracteres!'
                    )
            );
            $this->form_validation->set_rules('txtUsername', 'Username', 'trim|required|is_unique[users.usu_username]|min_length[5]|max_length[45]',
                array(
                    'required' => 'O Campo {field} é requerido!',
                    'is_unique'=> 'Já Existe este Username Cadastrado. Escolha outro!',
                    'min_length' => 'O Campo {field} deve conter mais de 5 caracteres!',
                    'min_length' => 'O Campo {field} deve conter menos de 45 caracteres!'
                    )
            );
            $this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|min_length[6]',
                array(
                    'required' => 'O Campo {field} é requerido!', 
                    'min_length' => 'O Campo {field} deve conter pelo menos 6 caracteres!'
                )
            );
            $this->form_validation->set_rules('txtPassconf', 'Password Confirmation', 'trim|required|matches[txtPassword]',
                array(
                    'required' => 'O Campo {field} é requerido!', 
                    'matches' => 'O Campo {field} deve conter o mesmo texto do campo Password!'
                )    
            );
            $this->form_validation->set_rules('txtEmail', 'Email', 'trim|required|valid_email|is_unique[users.usu_email]',
               array(
                    'required' => 'O Campo {field} é requerido!', 
                    'matches' => 'O Campo {field} deve conter um endereço de Email válido!',
                    'is_unique' => 'Este Email já está cadastrado. Escolha outro!'
                )     
            );
            $this->form_validation->set_rules('hdnAvatar', 'Avatar', 'trim|required',
               array(
                    'required' => 'Selecione um {field} clicando em uma Opção!', 
                )     
            );
            $this->form_validation->set_rules('selCavini', 'Cavaleiro Inicial', 'trim|required',
               array(
                    'required' => 'Selecione um {field} selecionando uma opção!', 
                )     
            );
            
            # ---- CONFIGURAÇÃO E VALIDAÇÃO DE CAPTCHA ----
            $secret = "6LdLlhYUAAAAAGHiXin4wWyNYAfQHqkTUHmLPfPp";
            $response = null;

            // verifique a chave secreta
            $reCaptcha = new ReCaptcha($secret);

            // se submetido, verifique a resposta
            if ($this->input->post("g-recaptcha-response"))
            {
                $response = $reCaptcha->verifyResponse(
                    $this->input->server("REMOTE_ADDR"),
                    $this->input->post("g-recaptcha-response")
                );
            }
            
            if ($response != null && $response->success) { 
                # Se a validacao do captcha for ok, executa validação do formulario
                if ($this->form_validation->run() == FALSE){ # Testa a validacao e caso tenha algum erro, redireciona para a tela de cadastro
                    #recupera a lista de cavaleiros iniciais
                    $cavsini = $this->cavaleiros_model->getCavIniciais();
                    $this->load->view('inicial',array("pag"=>'frm_user_cadastro',
                                                      "cavs"=>$cavsini));
                }
                else { # Caso contrario, faz os procedimentos para cadastro e redireciona para o proximo passo
                

                    #Recupera os dados do cadastro e formata para inserção no BD
                    $cavini = trim($this->input->post("selCavini"));
                    $nome = trim(ucfirst($this->input->post("txtNome")));
                    $usern = trim($this->input->post("txtUsername"));
                    $email = trim($this->input->post("txtEmail"));
                    $pass = trim($this->input->post("txtPassword"));
                    $avatar = trim($this->input->post("hdnAvatar"));
                    $avtmap = trim($this->input->post("hdnAvatar")."_mini");
                    
                    //  ESSE PROCEDIMENTO DEVE SER REALIZADO PARA INCLUIR NAS DEVIDAS TABELAS
                    //  O USUARIO, O CAVALEIRO INICIAL NA TABELA CAV_USERS, VERIFICAR O LEVEL
                    //  INICIAL NA TABELA DE ATRIBUTOS E MARCAR O PRIMEIRO CAVALEIRO COMO
                    //  PERTENCENTE AO LINEUP DO USUARIO.
                    #Monta o array de dados para ser passado a classe que insere os dados
                    $dataU = array("usu_username" => $usern,
                                  "usu_password" => md5($pass),
                                  "usu_email" => $email,
                                  "usu_nome" => $nome,
                                  "usu_avatar" => $avatar,
                                  "usu_avtmap" => $avtmap,
                                  "usu_dtcad" => date("Y-m-d H:i:s"));
                    
                    #Busca a classe do cavaleiro inicial
                    $cav = $this->cavaleiros_model->getCav($cavini);
                    foreach($cav as $c){
                        $cavcls = $c->cav_classe;
                    }
                    
                    
                    #Busca o level um pois esta inserindo um cavaleiro inicial
                    $attr = $this->atributos_model->getAttrByLevel(1);
                    foreach($attr as $a){
                        $level = $a->atr_level;
                        $hp = $a->atr_hp;
                    }
                    
                    #Busca a tecnica inicial padrao do cav inicial e adiciona a tabela //cav_users_tecnicas
                    $tec = $this->tecnicas_model->getTecByLevel(1);
                    foreach($tec as $t){
                        $tecini = $t->tec_id;
                        $tecdesc = $t->tec_desc;
                        $tecpp = $t->tec_pp;
                    }
                    
                    #Array contendo o cavaleiro inicial
                    $dataA = array("cav_id" => $cavini,
                                   "cvu_classe" => $cavcls,
                                   "cvu_level" => $level,
                                   "cvu_hp"=>$hp,
                                   "cvu_lineup" => 1,
                                   "cvu_tec1" => $tecini,
                                   "cvu_tec1desc" => $tecdesc,
                                   "cvu_tec1pp" => $tecpp);
                    
                    #Insere os dados no banco de dados
                    $this->users_model->insertUser($dataU, $dataA);
                    
                    $this->load->view('inicial',array("pag"=>'v_cadastro_success'));
                    
                    #Criptografa campo id, gera o link e envia para o email cadastrado o link de ativação do cadastro
                    
                    #Redireciona para a página de sucesso de cadastro
                    
                }
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('Valide o Captcha antes de Prosseguir com o Cadastro!')";
                echo "</script>";
                
                #recupera a lista de cavaleiros iniciais
                $cavsini = $this->cavaleiros_model->getCavIniciais();
                $this->load->view('inicial',array("pag"=>'frm_user_cadastro',
                                                  "cavs"=>$cavsini));
            } 
        }
        
        /*
         * Altera o cadastro do avatar do usuario
         * #protegina pelo controle de sessao
         */
        public function atualizarAvatar()
        {
            #controle de sessao do usuario
            verifyUser();
            
            #Recebe os dados do avatar
            $this->load->library('form_validation');
            
            #<--- Configura os textos de erro --->
            $this->form_validation->set_error_delimiters('<div class="text-danger"><small>', '</small></div>');
            
            #<--- Prepara a validacao dos campos do formulario --->
            $this->form_validation->set_rules('hdnAvatar', 'Avatar', 'trim|required',
               array(
                    'required' => 'Selecione um {field} clicando em uma Opção!', 
                )     
            );
            
            
            if ($this->form_validation->run() == FALSE){ # Testa a validacao e caso tenha algum erro, redireciona para a tela de cadastro
                
                #recupera a lista de cavaleiros iniciais
                $user = $this->users_model->getUser($this->session->userdata("uid"));
                $this->load->view('inicial_interna',array("pag"=>'frm_user_conta',"user"=>$user));
                
            }else{ # Caso contrario, faz os procedimentos para cadastro e redireciona para o proximo passo
                

                #Recupera os dados do cadastro e formata para inserção no BD
                $avatar = trim($this->input->post("hdnAvatar"));
                $avtmap = trim($this->input->post("hdnAvatar")."_mini");
                
                #Monta o array de dados para ser passado a classe que insere os dados
                $data = array("usu_avatar" => $avatar,
                              "usu_avtmap" => $avtmap);

                #Atualiza o cadastro
                $this->users_model->update($data, $this->session->userdata("uid"));
                
                #Atualiza a Secao do usuario com avatares novos
                $this->session->set_userdata("avatar",$avatar);
                $this->session->set_userdata("avtmap",$avtmap);

                redirect('user/conta', 'refresh');

            }
        }
        
        
        /*
         * Altera o cadastro de senha do usuario
         * #protegina pelo controle de sessao
         */
        public function atualizarSenha()
        {
            #controle de sessao do usuario
            verifyUser();
            
            #Recebe os dados do avatar
            $this->load->library('form_validation');
            
            #<--- Configura os textos de erro --->
            $this->form_validation->set_error_delimiters('<div class="text-danger"><small>', '</small></div>');
            
            #<--- Prepara a validacao dos campos do formulario --->
            $this->form_validation->set_rules('txtPassnova', 'Nova Senha', 'trim|required|min_length[6]',
                array(
                    'required' => 'O Campo {field} é requerido!', 
                    'min_length' => 'O Campo {field} deve conter pelo menos 6 caracteres!'
                )
            );
            $this->form_validation->set_rules('txtPassconf', 'Nova Senha (Confirmação)', 'trim|required|matches[txtPassnova]',
                array(
                    'required' => 'O Campo {field} é requerido!', 
                    'matches' => 'O Campo {field} deve conter o mesmo texto do campo Password!'
                )    
            );
            
            if ($this->form_validation->run() == FALSE){ # Testa a validacao e caso tenha algum erro, redireciona para a tela de cadastro
                
                #recupera a lista de cavaleiros iniciais
                $user = $this->users_model->getUser($this->session->userdata("uid"));
                $this->load->view('inicial_interna',array("pag"=>'frm_user_conta',"user"=>$user));
                
            }else{ # Caso contrario, faz os procedimentos para cadastro e redireciona para o proximo passo
                

                #Recupera os dados do cadastro e formata para inserção no BD
                $passnova = trim($this->input->post("txtPassnova"));

                #Monta o array de dados para ser passado a classe que insere os dados
                $data = array("usu_password" => md5($passnova));

                #Atualiza o cadastro
                $this->users_model->update($data, $this->session->userdata("uid"));

                echo "<script type='text/javascript'>";
                echo "alert('Senha Alterada Com Sucesso!')";
                echo "</script>";
                
                redirect('user/conta', 'refresh');
                

            }
        }
        
        /*
         * Altera o cadastro do usuario
         * #protegina pelo controle de sessao
         */
        public function atualizar()
        {
            
            #controle de sessao do usuario
            verifyUser();
            
            #Recebe os dados do avatar
            $this->load->library('form_validation');
            
            #<--- Configura os textos de erro --->
            $this->form_validation->set_error_delimiters('<div class="text-danger"><small>', '</small></div>');
            
            #<--- Prepara a validacao dos campos do formulario --->
            $this->form_validation->set_rules('txtNome', 'Nome', 'trim|required|min_length[5]',
                array(
                        'required' => 'O Campo {field} é requerido!', 
                        'min_length' => 'O Campo {field} deve conter mais de 5 caracteres!'
                    )
            );
            $this->form_validation->set_rules('txtDtnasc', 'Aniversário', 'trim|callback_valid_date',
                array(
                        'valid_date' => 'O Campo {field} deve Ser uma Data Válida!'
                    )
            );
            $this->form_validation->set_rules('txtCidade', 'Cidade', 'trim|min_length[5]',
                array( 
                        'min_length' => 'O Campo {field} deve conter mais de 5 caracteres!'
                    )
            );
            $this->form_validation->set_rules('txtPais', 'Pais', 'trim|min_length[5]',
                array(
                        'min_length' => 'O Campo {field} deve conter mais de 5 caracteres!'
                    )
            );
                  
            
            if ($this->form_validation->run() == FALSE){ # Testa a validacao e caso tenha algum erro, redireciona para a tela de cadastro
                
                #recupera a lista de cavaleiros iniciais
                $user = $this->users_model->getUser($this->session->userdata("uid"));
                $this->load->view('inicial_interna',array("pag"=>'frm_user_conta',"user"=>$user));
                
            }else{ # Caso contrario, faz os procedimentos para cadastro e redireciona para o proximo passo
                

                #Recupera os dados do cadastro e formata para inserção no BD
                $nome = trim($this->input->post("txtNome"));
                $cidade = trim($this->input->post("txtCidade"));
                $pais = trim($this->input->post("txtPais"));
                $aniv = trim($this->input->post("txtDtnasc"));
                
                $aniv2 = str_replace("/", "-", $aniv);
                $anivf = date('Y-m-d', strtotime($aniv2));
                
                #Monta o array de dados para ser passado a classe que insere os dados
                $data = array("usu_nome" => $nome,
                              "usu_cidade" => $cidade,
                              "usu_pais" => $pais,
                              "usu_dtnasc" => $anivf);

                #Atualiza o cadastro
                $this->users_model->update($data, $this->session->userdata("uid"));

                echo "<script type='text/javascript'>";
                echo "alert('Informações Alteradas Com Sucesso!')";
                echo "</script>";
                
                redirect('user/conta', 'refresh');
                

            }
            
        }
        
        /*
         * Busca os dados de um usuario no banco de dados.
         */
        public function getuser()
        {
            
            # logica para buscar cadastro aqui.
            
        }
        
        /*
         * @ Administrador
         * Busca todos os usuarios cadastrados no banco de dados.
         */
        public function getall()
        {
            
            # logica para buscar todos cadastros aqui.
            
        }
        
         /*
          * @ Administrador
          * Inativa o Cadastro do usuario.
          */
        public function inativa()
        {
            
            # logica para inativar cadastro aqui.
            
        }
        
        /*
         * @ Administrador
         * Exclui da base de dados um usuario.
         */
        public function deleta()
        {
            
            # logica para deletar cadastro aqui.
            
        } 
        
        
public function valid_date($date)
{
    //Some date fields are not compulsory
    //If all of them are compulsory then just remove this check
    if ($date == '')
    {
        return true;
    }

    //If in dd/mm/yyyy format
    if (preg_match("^\d{2}/\d{2}/\d{4}^", $date))
    {
        //Extract date parts
        $date_array = explode('/', $date);

        //If it is not a date
        if (! checkdate($date_array[1], $date_array[0], $date_array[2]))
        {
            $this->form_validation->set_message('validate_date', 'The %s field must contain a valid date.');
            return false;
        }
    }
    //If not in dd/mm/yyyy format
    else
    {
        $this->form_validation->set_message('validate_date', 'The %s field must contain a valid date.');
        return false;
    }

    return true;
}
        
}