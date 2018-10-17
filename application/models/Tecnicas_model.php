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
class Tecnicas_model extends CI_Model {
    
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
     * Busca a técnica por id
     */
    public function getTecnica($id){
        
        $query = $this->db->where("tec_id",$id);
        $query = $this->db->get("tecnicas");
        
        return $query->result();
    }
    
    /*
     * Busca os cavaleiros iniciais na tabela Cavaleiros
     */
    public function getTecByLevel($level){
        
        $query = $this->db->where("tec_level", $level);
        $query = $this->db->order_by("tec_id","asc");
        $query = $this->db->get("tecnicas");
        
        return $query->result();     
    }
    
    /*
     * Busca as info de tecnicas basicas para montar as tecnicas
     * do oponente que serão usadas em batalha
     * @cid
     * @clvl - Lvl do cavaleiro
     */
    public function getTecnicasBasicas($clvl){
        
        $query = $this->db->where('tec_basica',1);
        $query = $this->db->where('tec_level <=',$clvl);
        $query = $this->db->join("tipos tp","t.tec_tipo = tp.tip_id");
        $query = $this->db->get('tecnicas t');
        
        return $query->result();
        
    }
    
    /*
     * Busca as info de tecnicas por id de cavaleiro e level para montar as tecnicas
     * do oponente que serão usadas em batalha
     * @clvl - Lvl do cavaleiro
     */
    public function getTecnicasByCav($cid, $clvl){
        
        $query = $this->db->select('t.*,tp.*');
        $query = $this->db->where('c.cav_id',$cid);
        $query = $this->db->where('t.tec_level <=',$clvl);
        $query = $this->db->join("cav_tecnicas ct","t.tec_id = ct.tec_id");
        $query = $this->db->join("cavaleiros c","c.cav_id = ct.cav_id");
        $query = $this->db->join("tipos tp","t.tec_tipo = tp.tip_id");
        $query = $this->db->get('tecnicas t');
        
        return $query->result();
        
    }
	
	/*
     * Busca as info de tecnicas por id de Tecnica
     * @tid - id das tecnicas
     */
    public function getTecnicas($tid){
        
        $query = $this->db->where('tec_id',$tid);
        $query = $this->db->get('tecnicas');
        
        return $query->result();
        
    }
	
	/*
	 * Busca vantagem de tipo por tipo da tecnica contra tipo de oponente
	 * @tip - id do tipo da tecnica
	 * @tcv - id do tipo de cavaleiro que toma o ataque
	 */
	 public function getTecVantagem($tip,$tcv){
		 
		 $query = $this->db->where('tip_tec_id',$tip);
		 $query = $this->db->where('tip_cav_id',$tcv);
		 $query = $this->db->get('tipo_aux_vantagem');
		 
		 return $query->result();
	 }
	 
}