<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

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
		$this->load->view('inicial');
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