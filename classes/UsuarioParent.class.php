<?php
//á
class UsuarioParent {

/**
* nId
* @access private
*/
var $nId;
/**
* nIdGrupoUsuario
* @access private
*/
var $nIdGrupoUsuario;
/**
* sNmUsuario
* @access private
*/
var $sNmUsuario;
/**
* sLogin
* @access private
*/
var $sLogin;
/**
* sSenha
* @access private
*/
var $sSenha;
/**
* sEmail
* @access private
*/
var $sEmail;
/**
* bLogado
* @access private
*/
var $bLogado;
/**
* dDtCadastro
* @access private
*/
var $dDtCadastro;
/**
* bPublicado
* @access private
*/
var $bPublicado;
/**
* bAtivo
* @access private
*/
var $bAtivo;

	
	/**
	* Construtor de Usuario
	* @param $nId Id
	* @param $nIdGrupoUsuario IdGrupoUsuario
	* @param $sNmUsuario NmUsuario
	* @param $sLogin Login
	* @param $sSenha Senha
	* @param $sEmail Email
	* @param $bLogado Logado
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	
	/*
	function Usuario($nId,$nIdGrupoUsuario,$sNmUsuario,$sLogin,$sSenha,$sEmail,$bLogado,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setIdGrupoUsuario($nIdGrupoUsuario);
		$this->setNmUsuario($sNmUsuario);
		$this->setLogin($sLogin);
		$this->setSenha($sSenha);
		$this->setEmail($sEmail);
		$this->setLogado($bLogado);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	*/
	
	/**
	* Recupera o valor do atributo $nId. 
	* @return $nId Id
	*/
	function getId(){
		return $this->nId;
	}
	/**
	* Atribui valor ao atributo $nId. 
	* @param $nId Id
	* @access public
	*/
	function setId($nId){
		$this->nId = $nId;
	}

	/**
	* Recupera o valor do atributo $nIdGrupoUsuario. 
	* @return $nIdGrupoUsuario IdGrupoUsuario
	*/
	function getIdGrupoUsuario(){
		return $this->nIdGrupoUsuario;
	}
	/**
	* Atribui valor ao atributo $nIdGrupoUsuario. 
	* @param $nIdGrupoUsuario IdGrupoUsuario
	* @access public
	*/
	function setIdGrupoUsuario($nIdGrupoUsuario){
		$this->nIdGrupoUsuario = $nIdGrupoUsuario;
	}

	/**
	* Recupera o valor do atributo $sNmUsuario. 
	* @return $sNmUsuario NmUsuario
	*/
	function getNmUsuario(){
		return $this->sNmUsuario;
	}
	/**
	* Atribui valor ao atributo $sNmUsuario. 
	* @param $sNmUsuario NmUsuario
	* @access public
	*/
	function setNmUsuario($sNmUsuario){
		$this->sNmUsuario = $sNmUsuario;
	}

	/**
	* Recupera o valor do atributo $sLogin. 
	* @return $sLogin Login
	*/
	function getLogin(){
		return $this->sLogin;
	}
	/**
	* Atribui valor ao atributo $sLogin. 
	* @param $sLogin Login
	* @access public
	*/
	function setLogin($sLogin){
		$this->sLogin = $sLogin;
	}

	/**
	* Recupera o valor do atributo $sSenha. 
	* @return $sSenha Senha
	*/
	function getSenha(){
		return $this->sSenha;
	}
	/**
	* Atribui valor ao atributo $sSenha. 
	* @param $sSenha Senha
	* @access public
	*/
	function setSenha($sSenha){
		$this->sSenha = $sSenha;
	}

	/**
	* Recupera o valor do atributo $sEmail. 
	* @return $sEmail Email
	*/
	function getEmail(){
		return $this->sEmail;
	}
	/**
	* Atribui valor ao atributo $sEmail. 
	* @param $sEmail Email
	* @access public
	*/
	function setEmail($sEmail){
		$this->sEmail = $sEmail;
	}

	/**
	* Recupera o valor do atributo $bLogado. 
	* @return $bLogado Logado
	*/
	function getLogado(){
		return $this->bLogado;
	}
	/**
	* Atribui valor ao atributo $bLogado. 
	* @param $bLogado Logado
	* @access public
	*/
	function setLogado($bLogado){
		$this->bLogado = $bLogado;
	}

	/**
	* Recupera o valor do atributo $dDtCadastro.
	* @return $dDtCadastro DtCadastro
	*/
	function getDtCadastro(){
		return $this->dDtCadastro;
	}
	/**
	* Atribui valor ao atributo $dDtCadastro.
	* @param $dDtCadastro DtCadastro
	* @access public
	*/
	function setDtCadastro($dDtCadastro){
		$this->dDtCadastro = $dDtCadastro;
	}

	/**
	* Recupera o valor do atributo $bPublicado. 
	* @return $bPublicado Publicado
	*/
	function getPublicado(){
		return $this->bPublicado;
	}
	/**
	* Atribui valor ao atributo $bPublicado. 
	* @param $bPublicado Publicado
	* @access public
	*/
	function setPublicado($bPublicado){
		$this->bPublicado = $bPublicado;
	}

	/**
	* Recupera o valor do atributo $bAtivo. 
	* @return $bAtivo Ativo
	*/
	function getAtivo(){
		return $this->bAtivo;
	}
	/**
	* Atribui valor ao atributo $bAtivo. 
	* @param $bAtivo Ativo
	* @access public
	*/
	function setAtivo($bAtivo){
		$this->bAtivo = $bAtivo;
	}

	
}
?>