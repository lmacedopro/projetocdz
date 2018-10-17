<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cavaleiros
 *
 * @author Telemática
 */
class Itens_model extends CI_Model {
    
    public function __construct(){
            
        parent::__construct();

    }
    
    /*
     * Insere um item na tabela itens
     * @data - Dados do item a ser inserido
     */
    public function insert($data){
        
        $this->db->insert("itens",$data);
    }
    
    /*
     * Busca item por id
     */
    public function getItem($id){
        
        $query = $this->db->where("itm_id",$id);
        $query = $this->db->get("itens");
        
        return $query->result();
    }
	
	/*
	 * Busca todos os itens cadastrados
	 */
	 public function getItens(){
		 
		$query = $this->db->get("itens");
        
        return $query->result();
	 }
	 
	 /*
	  * Insere itens na tabela auxiliar do usuario
	  */
	 public function insertUserItem($data){
		 
		 $this->db->insert("users_itens",$data);
	 }
	 
	 /*
	  * Atualiza os itens na tabela auxiliar do usuario
	  */
	 public function updateUserItem($uid,$itmid,$data){
		 
		 $this->db->where("usu_id",$uid);
		 $this->db->where("itm_id",$itmid);
		 $this->db->update("users_itens",$data);
	 }
	 
	 /* Busca itens por usuario
	  *
	  */
	public function getItensByUser($uid){
		
		$query = $this->db->where('ui.usu_id',$uid);
		$query = $this->db->join("itens i",'i.itm_id = ui.itm_id');
		$query = $this->db->get("users_itens ui");
		
		return $query->result();
	}
	
	public function getItemByUser($uid, $itmid){
	
		$query = $this->db->where('ui.usu_id',$uid);
		$query = $this->db->where('i.itm_id',$itmid);
		$query = $this->db->join("itens i",'i.itm_id = ui.itm_id');
		$query = $this->db->get("users_itens ui");
		
		return $query->result();
	}
	
	public function removeItem($uid, $itmid){
		
		$this->db->where('itm_id',$itmid);
		$this->db->where('usu_id',$uid);
		$this->db->delete("users_itens");
	}
    
    
    
	 
}