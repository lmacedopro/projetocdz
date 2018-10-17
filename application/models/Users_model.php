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
class Users_model extends CI_Model {
    
    public function __construct(){
            
        parent::__construct();

    }
    
    /*
     * Insere o cadastro e o cavaleiro inicial do usuario
     * @$datauser - Array com dados do usuario
     * @$dataCavini - Array com dados do cavaleiro escolhido
     */
    public function insertUser($dataUser, $dataCavini){
        
        #Procede a insercao do usuario
        $this->db->insert('users',$dataUser);
        #Recupera o id inserido
        $usuid = $this->db->insert_id();
        $dataCavini["usu_id"] = $usuid; 
        #Procede a insercao do cavaleiro inicial
        $mc = new Cavaleiros_model();
        $mc->insertCavini($dataCavini);
    }
    
    /*
     * Busca o usuario no banco por username e senha
     * @return - Registro do usuario autentica ou null.
     */
    public function checkUser($data){
        
        $query = $this->db->where($data);
        $query = $this->db->get("users");
        
        return $query->result();
    }
    
    /*
     * Atualiza o campo de ultimo login do usuario
     * @$datetime - Data e hora no formato do banco
     * @uid - Id do usuario recem logado
     */
    public function updateLastlogin($datetime,$uid){
        
        $this->db->where("usu_id",$uid);
        $this->db->update("users",array("usu_lastlogin"=>$datetime));
    }
    
    /*
     * Recupera os dados do usuario pelo Id
     * @uid - Id do usuario recem logado
     */
    public function getUser($uid){
        
        $query = $this->db->where("usu_id",$uid);
        $query = $this->db->get("users");
        
        return $query->result();
    }

    /*
     * Recupera os dados do usuario pelo Username
     * @unm - username do usuario
     */
    public function getUserByUsername($unm){
        
        $query = $this->db->where("usu_username",$unm);
        $query = $this->db->get("users");
        
        return $query->result();
    }
    
    /*
     * Atualiza os dados de usuario
     * @data - Array de dados a serem atualizados
     * @uid - Id do usuario recem logado
     */
    public function update($data, $uid){
        
        $this->db->where('usu_id',$uid);
        $this->db->update('users',$data);
    }
}