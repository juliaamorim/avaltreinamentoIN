<?php
	class Usuario {
		private $intId;
		private $strNome;
		private $strEmail;
		private $strSenha;
		private $strNivel;
		private $intIdEmpresa;
		private $intAtivo;
	
	public function getId(){
    	return $this->intId;
	}
	public function setId($id){
    	$this->intId=$id;
	}

	public function getNome(){
    	return $this->strNome;
	}
	public function setNome($nome){
    	$this->strNome=$nome;
	}

	public function getEmail(){
    	return $this->strEmail;
	}
	public function setEmail($email){
    	$this->strEmail=$email;
	}

	public function getSenha(){
    	return $this->strSenha;
	}
	public function setSenha($senha){
    	$this->strSenha=$senha;
	}

	public function getNivel(){
    	return $this->strNivel;
	}
	public function setNivel($nivel){
    	$this->strNivel=$nivel;
	}

	public function getEmpresa(){
    	return $this->intIdEmpresa;
	}
	public function setEmpresa($empresa){
    	$this->intIdEmpresa=$empresa;
	}

	public function getAtivo(){
    	return $this->intAtivo;
	}
	public function setAtivo($ativo){
    	$this->intAtivo=$ativo;
	}
}
?>