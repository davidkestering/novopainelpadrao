<?php
//á
class TransacaoParent {

/**
* nId
* @access private
*/
var $nId;
/**
* nIdTipoTransacao
* @access private
*/
var $nIdTipoTransacao;
/**
* nIdUsuario
* @access private
*/
var $nIdUsuario;
/**
* sIdObjeto
* @access private
*/
var $sIdObjeto;
/**
* sCampo
* @access private
*/
var $sCampo;
/**
* sValorAntigo
* @access private
*/
var $sValorAntigo;
/**
* sValorNovo
* @access private
*/
var $sValorNovo;
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
	* Construtor de Transacao
	* @param $nId Id
	* @param $nIdTipoTransacao IdTipoTransacao
	* @param $nIdUsuario IdUsuario
	* @param $sIdObjeto IdObjeto
	* @param $sCampo Campo
	* @param $sValorAntigo ValorAntigo
	* @param $sValorNovo ValorNovo
	* @param $sIp Ip
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	
	/*
	function Transacao($nId,$nIdTipoTransacao,$nIdUsuario,$sIdObjeto,$sCampo,$sValorAntigo,$sValorNovo,$sIp,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setIdTipoTransacao($nIdTipoTransacao);
		$this->setIdUsuario($nIdUsuario);
		$this->setIdObjeto($sIdObjeto);
		$this->setCampo($sCampo);
		$this->setValorAntigo($sValorAntigo);
		$this->setValorNovo($sValorNovo);
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
	* Recupera o valor do atributo $sIdObjeto. 
	* @return $sIdObjeto IdObjeto
	*/
	function getIdObjeto(){
		return $this->sIdObjeto;
	}
	/**
	* Atribui valor ao atributo $sIdObjeto. 
	* @param $sIdObjeto IdObjeto
	* @access public
	*/
	function setIdObjeto($sIdObjeto){
		$this->sIdObjeto = $sIdObjeto;
	}

	/**
	* Recupera o valor do atributo $sCampo. 
	* @return $sCampo Campo
	*/
	function getCampo(){
		return $this->sCampo;
	}
	/**
	* Atribui valor ao atributo $sCampo. 
	* @param $sCampo Campo
	* @access public
	*/
	function setCampo($sCampo){
		$this->sCampo = $sCampo;
	}

	/**
	* Recupera o valor do atributo $sValorAntigo. 
	* @return $sValorAntigo ValorAntigo
	*/
	function getValorAntigo(){
		return $this->sValorAntigo;
	}
	/**
	* Atribui valor ao atributo $sValorAntigo. 
	* @param $sValorAntigo ValorAntigo
	* @access public
	*/
	function setValorAntigo($sValorAntigo){
		$this->sValorAntigo = $sValorAntigo;
	}

	/**
	* Recupera o valor do atributo $sValorNovo. 
	* @return $sValorNovo ValorNovo
	*/
	function getValorNovo(){
		return $this->sValorNovo;
	}
	/**
	* Atribui valor ao atributo $sValorNovo. 
	* @param $sValorNovo ValorNovo
	* @access public
	*/
	function setValorNovo($sValorNovo){
		$this->sValorNovo = $sValorNovo;
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