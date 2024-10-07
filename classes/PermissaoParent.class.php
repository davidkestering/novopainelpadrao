<?php
//á
class PermissaoParent {

/**
* nIdTipoTransacao
* @access private
*/
var $nIdTipoTransacao;
/**
* nIdGrupoUsuario
* @access private
*/
var $nIdGrupoUsuario;
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
	* Construtor de Permissao
	* @param $nIdTipoTransacao IdTipoTransacao
	* @param $nIdGrupoUsuario IdGrupoUsuario
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	
	/*
	function Permissao($nIdTipoTransacao,$nIdGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setIdTipoTransacao($nIdTipoTransacao);
		$this->setIdGrupoUsuario($nIdGrupoUsuario);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	*/
	
	/**
	* Recupera o valor do atributo $nIdTipoTransacao. 
	* @return $nIdTipoTransacao IdTipoTransacao
	*/
	function getIdTipoTransacao(){
		return $this->nIdTipoTransacao;
	}
	/**
	* Atribui valor ao atributo $nIdTipoTransacao. 
	* @param $nIdTipoTransacao IdTipoTransacao
	* @access public
	*/
	function setIdTipoTransacao($nIdTipoTransacao){
		$this->nIdTipoTransacao = $nIdTipoTransacao;
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