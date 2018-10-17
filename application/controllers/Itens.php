<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itens extends CI_Controller {

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
        
			verifyUser();
			
			//recupera os dados de usuario
			$user = $this->users_model->getUser($this->session->userdata("uid"));
			
			//recupera a lista de itens
			$itens = $this->itens_model->getItens();
			$this->load->view('inicial_interna',array("pag"=>'v_shop',"user"=>$user,"itens"=>$itens,"erro"=>""));
	}
        
	/**
	 * Função que realiza a compra do usuario no shop
	 */
	public function comprar(){
		
		verifyUser();
		
		#Recebe os dados do formulario de compra
		$total = $this->input->post("hdnTotalcompra");
		$compra = $this->input->post("selQtd[]");
		
		//pega a lista de itens
		$itens = $this->itens_model->getItens();
		
		//pega os dados do usuario da seção
		$user = $this->users_model->getUser($this->session->userdata("uid"));
		foreach($user as $u){
			
			if($u->usu_money <= $total){ //usuario nao tem dinheiro para comprar
				
				$erro = "Não é possível realizar a compra. Você não tem dinheiro suficiente.";
				$this->load->view('inicial_interna',array("pag"=>'v_shop',"user"=>$user,"itens"=>$itens,"erro"=>$erro));
				
			}else{
				
				//Faz o procedimento de inserção dos itens comprados ao usuario
				foreach($compra as $itmid => $qtd){
			
					if(!empty($qtd)){ //itens comprados
					
						//echo "item: $key - Qtd: $value";

						//Verifica se o usuario ja tem o item, se sim atualiza a quantidade
						$flagitem = 0;
						$existeitem = $this->itens_model->getItemByUser($u->usu_id, $itmid);
						//print_r($existeitem);

						//exit(0);
						$item = $this->itens_model->getItem($itmid);
						foreach($item as $i){
							
							if(empty($existeitem)){

								//inclui cada item e a qtd passada na tabela user_itens
								$data = array("usu_id"=>$u->usu_id,
										  "itm_id"=>$i->itm_id,
										  "usi_qtde"=>$qtd);
							
								$this->itens_model->insertUserItem($data);
							}else{

								//Pega a qtd de itens e atualiza
								foreach($existeitem as $ei){

									//soma o item comprado a qtde existente
									$eqtde = $ei->usi_qtde + $qtd;
									$data = array("usi_qtde"=>$eqtde);

									$this->itens_model->updateUserItem($u->usu_id,$i->itm_id,$data);
								}
							}
							
						}
					}
				}
				
				//subtrai o valor total da compra do dinheiro do usuario
				$money = $u->usu_money;
				$money -= $total;
				
				$data = array("usu_money" => $money);
				$this->users_model->update($data,$u->usu_id);
				
				//redireciona para a tela de compra de itens
				redirect("shop","refresh");
			}
		}
	}
}
