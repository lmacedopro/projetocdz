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
class Mapas_model extends CI_Model {
    
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
     * Busca os Mapas ativos para preencher a tela de Mapas livres
     */
    public function getMapasAtivos(){
        
        $query = $this->db->where("map_ativo", 1);
        $query = $this->db->get("mapas");
        
        return $query->result();     
    }
    
    /*
     * Busca o Mapa pelo id
     */
    public function getMapa($mid){
        
        $query = $this->db->where("map_ativo", 1);
        $query = $this->db->where("map_id", $mid);
        $query = $this->db->get("mapas");
        
        return $query->result();     
    }
    
    /*
     * Busca os dados de cavaleiros associados ao mapa
     */
    public function getCavsMap($mid,$peso){
        
        $query = $this->db->where("map_id", $mid);
        $query = $this->db->where("cav_raridade", $peso);
        $query = $this->db->join("cavaleiros c","c.cav_id = mc.cav_id");
        $query = $this->db->join("mapas_aux_peso mp","c.cav_raridade = mp.pes_id");
        $query = $this->db->get("mapas_cavs mc");
        
        return $query->result();     
    }
    
    /*
     * Busca os dados de peso para soreteio de cavaleiros no mapa
     */
    public function getMapPesos(){
        
        $query = $this->db->get("mapas_aux_peso");
        
        return $query->result();     
    }
	
	/*
     * Busca os dados de peso pela raridade do cavaleiro
     */
    public function getMapPesoByRaridade($cavr){
        
		$query = $this->db->where("pes_id",$cavr);
        $query = $this->db->get("mapas_aux_peso");
        
        return $query->result();     
    }
}