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
class Atributos_model extends CI_Model {
    
    public function __construct(){
            
        parent::__construct();

    }
    
    /*
     * Insere um cavaleiro inicial na tabela cav_users
     * @uid - Id do usuario recem cadastrado
     * @dataCavini - Dados do cavaleiro a ser inserido
     * 
     * #OBS - Para inserção de cavaleiro inicial, o level é default na tabela cav_users
     */
    public function insert($data){
        
        //$this->db->insert("cav_users",$dataCavini);
    }
    
    /*
     * Busca os cavaleiros iniciais na tabela Cavaleiros
     */
    public function getAttrByLevel($level){
        
        $query = $this->db->where("atr_level", $level);
        $query = $this->db->where('cls_id',1); #Classe D para cavaleiros iniciais
        $query = $this->db->get("atributos");
        
        return $query->result();     
    }

    /*
     * Busca os atributos do level seguinte ao do cavaleiro
     */
    public function getNextAttr($level,$classe){

        $query = $this->db->where("atr_level", $level+1); //level atual do cavaeiro + 1 (proximo level)
        $query = $this->db->where('cls_id',$classe);
        $query = $this->db->get("atributos");
        
        return $query->result();

    }
}