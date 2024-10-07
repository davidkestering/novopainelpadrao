<?php
//á
class GrupoUsuarioParent {

/**
* nId
* @access private
*/
var $nId;
/**
* sNmGrupoUsuario
* @access private
*/
var $sNmGrupoUsuario;
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
	* Construtor de GrupoUsuario
	* @param $nId Id
	* @param $sNmGrupoUsuario NmGrupoUsuario
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	
	/*
	function GrupoUsuario($nId,$sNmGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setNmGrupoUsuario($sNmGrupoUsuario);
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
	* Recupera o valor do atributo $sNmGrupoUsuario. 
	* @return $sNmGrupoUsuario NmGrupoUsuario
	*/
	function getNmGrupoUsuario(){
		return $this->sNmGrupoUsuario;
	}
	/**
	* Atribui valor ao atributo $sNmGrupoUsuario. 
	* @param $sNmGrupoUsuario NmGrupoUsuario
	* @access public
	*/
	function setNmGrupoUsuario($sNmGrupoUsuario){
		$this->sNmGrupoUsuario = $sNmGrupoUsuario;
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