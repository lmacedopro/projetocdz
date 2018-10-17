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
class Cavaleiros_model extends CI_Model {
    
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
    public function insertCavini($dataCavini){
        
        $this->db->insert("cav_users",$dataCavini);
    }
    
    /*
     * Busca os cavaleiros iniciais na tabela Cavaleiros
     */
    public function getCavIniciais(){
        
        $query = $this->db->where("cav_inicial", 1);
        $query = $this->db->get("cavaleiros");
        
        return $query->result();     
    }
    
     /*
     * Busca os cavaleiros por id
     * @cid - id do cavaleiro
     */
    public function getCav($cid){
        
        $query = $this->db->where("cav_id", $cid);
        $query = $this->db->get("cavaleiros c");
        
        return $query->result();     
    }
    
    /*
     * Busca as info de cavaleiro por id e level para montar a tabela de dados de batalha
     * do oponente
     * @cid - Id do cavaleio
     * @clvl - Lvl do cavaleiro
     */
    public function getCavOpo($cid,$clvl){
        
        $query = $this->db->where("c.cav_id", $cid);
        $query = $this->db->where("a.atr_level", $clvl);
        $query = $this->db->join('classes cl', "c.cav_classe = cl.cls_id");
        $query = $this->db->join('atributos a', 'a.cls_id = cl.cls_id');
        $query = $this->db->join('tipos t', 'c.cav_tipo = t.tip_id');
        $query = $this->db->join('mapas_aux_peso mp', 'c.cav_raridade = mp.pes_id');
        $query = $this->db->get("cavaleiros c");
        
        return $query->result();
    }
    
    
    /*
     * Busca os cavaleiros da relacao cavs_users por id de usuario
     * @uid - Id de usuario
     */
    public function getCavsByUser($uid){
        
        #Certifica que as consulta retorne apenas os atrib coeespondentes a classe do cav
        $query = $this->db->where("cu.cvu_classe = a.cls_id");
        $query = $this->db->where("usu_id",$uid);
		$query = $this->db->where("cvu_lineup <>",1);
        $query = $this->db->order_by("cav_nome");
        $query = $this->db->join('cavaleiros c', 'c.cav_id = cu.cav_id');
        $query = $this->db->join('classes cl', "cu.cvu_classe = cl.cls_id");
        $query = $this->db->join('atributos a', 'a.atr_level = cu.cvu_level');
        $query = $this->db->join('tipos t', 'c.cav_tipo = t.tip_id');
        $query = $this->db->join('mapas_aux_peso mp', 'c.cav_raridade = mp.pes_id');
        $query = $this->db->get("cav_users cu");
        
        return $query->result();
    }

    /*
     * Busca os cavaleiros cadastrados na área de troca
     * @uid - Id de usuario
     */
    public function getCvuForTrade($uid){

        $query = $this->db->where("t.trc_usuid",$uid);
        $query = $this->db->select("t.trc_id, t.trc_datahora, u.usu_id, u.usu_username, t.trc_cvuid, cu.cvu_apelido, 
                                    cu.cvu_level, c.cav_id as cvu_cavid, c.cav_nome as cvu_nomecav, cl.cls_titulo as cvu_classe,
                                    tp.tip_titulo as cvu_tipo, t.trc_cavid, cc.cav_nome, ccl.cls_titulo as cav_classe,
                                    ttp.tip_titulo as cav_tipo");
        $query = $this->db->join('cav_users cu', "cu.cvu_id = t.trc_cvuid");
        $query = $this->db->join('users u', "u.usu_id = t.trc_usuid");
        $query = $this->db->join('cavaleiros c', "cu.cav_id = c.cav_id");
        $query = $this->db->join('classes cl', "c.cav_classe = cl.cls_id");
        $query = $this->db->join('tipos tp', "c.cav_tipo = tp.tip_id");
        $query = $this->db->join('cavaleiros cc', "t.trc_cavid = cc.cav_id");
        $query = $this->db->join('classes ccl', "cc.cav_classe = ccl.cls_id");
        $query = $this->db->join('tipos ttp', "cc.cav_tipo = ttp.tip_id");
        $query = $this->db->get("trocas t");

        return $query->result();
    }

    /*
     * Busca os cavaleiros cadastrados na área de troca que nao são do usuario logado
     * @uid - Id de usuario
     */
    public function getCavsForTrade($uid){

        $query = $this->db->where("t.trc_usuid <>",$uid);
        $query = $this->db->select("t.trc_id, t.trc_datahora, u.usu_id, u.usu_username, t.trc_cvuid, cu.cvu_apelido, 
                                    cu.cvu_level, c.cav_id as cvu_cavid, c.cav_nome as cvu_nomecav, cl.cls_titulo as cvu_classe,
                                    tp.tip_titulo as cvu_tipo, t.trc_cavid, cc.cav_nome, ccl.cls_titulo as cav_classe,
                                    ttp.tip_titulo as cav_tipo");
        $query = $this->db->join('cav_users cu', "cu.cvu_id = t.trc_cvuid");
        $query = $this->db->join('users u', "u.usu_id = t.trc_usuid");
        $query = $this->db->join('cavaleiros c', "cu.cav_id = c.cav_id");
        $query = $this->db->join('classes cl', "c.cav_classe = cl.cls_id");
        $query = $this->db->join('tipos tp', "c.cav_tipo = tp.tip_id");
        $query = $this->db->join('cavaleiros cc', "t.trc_cavid = cc.cav_id");
        $query = $this->db->join('classes ccl', "cc.cav_classe = ccl.cls_id");
        $query = $this->db->join('tipos ttp', "cc.cav_tipo = ttp.tip_id");
        $query = $this->db->get("trocas t");

        return $query->result();
    }

    /*
     * Busca os cavaleiros da relacao cavs_users por id de usuario, que podem ser trocados
     * (nao são do lineup e não estao na central de trocas)
     * @uid - Id de usuario
     */
    public function getCavsUserTrade($uid){

        #Certifica que as consulta retorne apenas os atrib coeespondentes a classe do cav
        $query = $this->db->where("usu_id",$uid);
        $query = $this->db->where("cvu_lineup <>",1);
        $query = $this->db->where("t.trc_cvuid IS NULL");
        $query = $this->db->join("trocas t","t.trc_cvuid = cu.cvu_id","left");
        $query = $this->db->join('cavaleiros c', 'c.cav_id = cu.cav_id');
        $query = $this->db->join('classes cl', 'cl.cls_id = c.cav_classe');
        $query = $this->db->join('tipos tp', 'tp.tip_id = c.cav_tipo');
        $query = $this->db->get("cav_users cu");

        
        return $query->result();
    }

    /*
     * Atualiza os dados do cavaleiro do usuario (usado em trocas)
     * @uid - Id do cavaleiro do usuario a ser atualizado
     * @data - dados a atualizar na tabela
     */
    public function updateCavTrade($uid,$cvuid,$data){
        
        $this->db->where('usu_id',$uid);
        $this->db->where('cvu_id',$cvuid);
        $this->db->update('cav_users',$data);
        
    }

    /*
     * Exclui a troca na tabela de trocas
     */
    public function deleteTroca($trcid){

        $this->db->where("trc_id",$trcid);
        $this->db->delete("trocas");
    }

    /*
     * Busca troca na tabela de trocas por id
     */
    public function getTroca($trcid){

        $query = $this->db->where("trc_id",$trcid);
        $query = $this->db->get("trocas");

        return $query->result();
    }

    /*
     * Busca todos cavaleiros 
     * @cid - Id do cavaleio
     * @clvl - Lvl do cavaleiro
     */
    /*ublic function getCavsTrade(){
        
        $query = $this->db->where("a.atr_level", 1); #rack pq precisa so da info basica
        $query = $this->db->order_by("cl.cls_id,c.cav_tipo,c.cav_nome","asc");
        $query = $this->db->join('classes cl', "c.cav_classe = cl.cls_id");
        $query = $this->db->join('atributos a', 'a.cls_id = cl.cls_id');
        $query = $this->db->join('tipos t', 'c.cav_tipo = t.tip_id');
        $query = $this->db->join('mapas_aux_peso mp', 'c.cav_raridade = mp.pes_id');
        $query = $this->db->get("cavaleiros c");
        
        return $query->result();
    }*/

    /*
     * Busca as info de cavaleiro por classe
     * @cls - Classe do cavaleio
     */
    public function getCavsTradeByCls($cls){
        
        $query = $this->db->where("c.cav_classe", $cls);
        $query = $this->db->where("a.atr_level", 1); #rack pq precisa so da info basica
        $query = $this->db->order_by("cl.cls_id,c.cav_tipo,c.cav_nome","asc");
        $query = $this->db->join('classes cl', "c.cav_classe = cl.cls_id");
        $query = $this->db->join('atributos a', 'a.cls_id = cl.cls_id');
        $query = $this->db->join('tipos t', 'c.cav_tipo = t.tip_id');
        $query = $this->db->join('mapas_aux_peso mp', 'c.cav_raridade = mp.pes_id');
        $query = $this->db->get("cavaleiros c");
        
        return $query->result();
    }



     /*
     * Retorna os dados de troca pelo id do usuario e do cavaleiro 
     * @cvu - Id do cavaleiro do usuario
     */
    public function getTrocaByCvu($cvu){

        $query = $this->db->where("trc_cvuid",$cvu);
        $query = $this->db->get("trocas");

        return $query->result();
    }

    /*
     * Insere os dados de troca na tabela de trocas
     * @data - Array de dados para cadastro na tabela de trocas
     */
    public function insertTroca($data){

        $this->db->insert("trocas",$data);
    }
	
	/*
     * Busca os cavaleiros da relacao cavs_users por id unico da tabela de cav_users
     * @cvuid - Id de usuario
     */
    public function getCavByCvu($cvuid){
        
        #Certifica que as consulta retorne apenas os atrib coeespondentes a classe do cav
        $query = $this->db->where("cu.cvu_classe = a.cls_id");
        $query = $this->db->where("cvu_id",$cvuid);
        $query = $this->db->join('cavaleiros c', 'c.cav_id = cu.cav_id');
        $query = $this->db->join('classes cl', "cu.cvu_classe = cl.cls_id");
        $query = $this->db->join('atributos a', 'a.atr_level = cu.cvu_level');
        $query = $this->db->join('tipos t', 'c.cav_tipo = t.tip_id');
        $query = $this->db->join('mapas_aux_peso mp', 'c.cav_raridade = mp.pes_id');
        $query = $this->db->get("cav_users cu");
        
        return $query->result();
    }

    /*
     * Busca os cavaleiros da relacao cavs_users por id de usuario
     * @uid - Id de usuario
     */
    public function getCavLineupByOrdem($uid,$ordem){
        
        
        #Certifica que as consulta retorne apenas os atrib coeespondentes a classe do cav
        $query = $this->db->where("cu.cvu_classe = a.cls_id");
        $query = $this->db->where("usu_id",$uid);
        //$query = $this->db->where("cvu_lineup",1);
        $query = $this->db->where("cvu_ordem",$ordem);
        $query = $this->db->join('cavaleiros c', 'c.cav_id = cu.cav_id');
        $query = $this->db->join('classes cl', "cu.cvu_classe = cl.cls_id");
        $query = $this->db->join('atributos a', 'a.atr_level = cu.cvu_level');
        $query = $this->db->join('tipos t', 'c.cav_tipo = t.tip_id');
        $query = $this->db->join('mapas_aux_peso mp', 'c.cav_raridade = mp.pes_id');
        $query = $this->db->order_by("cvu_ordem","asc");
        $query = $this->db->get("cav_users cu");
        
        return $query->result();
    }
    
    /*
     * Busca os cavaleiros da relacao cavs_users por id de usuario
     * @uid - Id de usuario
     */
    public function getCavsLineup($uid){
        
        
        #Certifica que as consulta retorne apenas os atrib coeespondentes a classe do cav
        $query = $this->db->where("cu.cvu_classe = a.cls_id");
        $query = $this->db->where("usu_id",$uid);
        $query = $this->db->where("cvu_lineup",1);
        $query = $this->db->join('cavaleiros c', 'c.cav_id = cu.cav_id');
        $query = $this->db->join('classes cl', "cu.cvu_classe = cl.cls_id");
        $query = $this->db->join('atributos a', 'a.atr_level = cu.cvu_level');
        $query = $this->db->join('tipos t', 'c.cav_tipo = t.tip_id');
        $query = $this->db->join('mapas_aux_peso mp', 'c.cav_raridade = mp.pes_id');
        $query = $this->db->order_by("cvu_ordem","asc");
        $query = $this->db->get("cav_users cu");

        
        return $query->result();
    }
    
    /*
     * Conta a quantidade de cavaleiros por usuario
     * @uid - Id de usuario
     */
    public function countCavsByUser($uid){
        
        $query = $this->db->where("usu_id",$uid);
        #metodo para contar aqui
    }
	
	/*
	 * Atualiza os dados do cavaleiro utilizado durante a batalha
	 * @uid - Id do cavaleiro do usuario a ser atualizado
	 * @data - dados a atualizar na tabela
	 */
	public function updateCavTurno($uid,$data){
		
		$this->db->where('cvu_id',$uid);
        $this->db->update('cav_users',$data);
		
	}
	
	/*
	 * Atualiza os dados do cavaleiro do usuario (usado em HOSPITAL)
	 * @uid - Id do cavaleiro do usuario a ser atualizado
	 * @data - dados a atualizar na tabela
	 */
	public function updateCavUser($uid,$data){
		
		$this->db->where('cvu_id',$uid);
        $this->db->update('cav_users',$data);
		
	}
	
	/*
	 * Retorna os dados dde classes de cavaleiros
	 * @cid - Id da classe do cavaleiro
	 */
	public function getClasse($cid){
		
		$this->db->where('cls_id',$cid);
		$query = $this->db->get("classes");
		
		return $query->result();
	}
	
	/*
	 * Retorna os dados da tabela auxiliar de recrutamento
	 * @cid - Id da classe do cavaleiro
	 * @itm - Id do item usado
	 */
	public function getAuxRecrutamento($cid,$itm){
		
		$this->db->where('cls_id',$cid);
		$this->db->where('itm_id',$itm);
		$query = $this->db->get('aux_recrutamento');
		
		return $query->result();
	}

}