<?php
//á
class ErrosMysqlParent {

/**
* nId
* @access private
*/
var $nId;
/**
* sErro
* @access private
*/
var $sErro;
/**
* nIdUsuario
* @access private
*/
var $nIdUsuario;
/**
* sIp
* @access private
*/
var $sIp;
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
	* Construtor de ErrosMysql
	* @param $nId Id
	* @param $sErro Erro
	* @param $nIdUsuario IdUsuario
	* @param $sIp Ip
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	
	/*
	function ErrosMysql($nId,$sErro,$nIdUsuario,$sIp,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setErro($sErro);
		$this->setIdUsuario($nIdUsuario);
		$this->setIp($sIp);
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
	* Recupera o valor do atributo $sErro. 
	* @return $sErro Erro
	*/
	function getErro(){
		return $this->sErro;
	}
	/**
	* Atribui valor ao atributo $sErro. 
	* @param $sErro Erro
	* @access public
	*/
	function setErro($sErro){
		$this->sErro = $sErro;
	}

	/**
	* Recupera o valor do atributo $nIdUsuario. 
	* @return $nIdUsuario IdUsuario
	*/
	function getIdUsuario(){
		return $this->nIdUsuario;
	}
	/**
	* Atribui valor ao atributo $nIdUsuario. 
	* @param $nIdUsuario IdUsuario
	* @access public
	*/
	function setIdUsuario($nIdUsuario){
		$this->nIdUsuario = $nIdUsuario;
	}

	/**
	* Recupera o valor do atributo $sIp. 
	* @return $sIp Ip
	*/
	function getIp(){
		return $this->sIp;
	}
	/**
	* Atribui valor ao atributo $sIp. 
	* @param $sIp Ip
	* @access public
	*/
	function setIp($sIp){
		$this->sIp = $sIp;
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