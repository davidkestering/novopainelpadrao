<?php
//á
require_once("TransacaoParent.class.php");

class Transacao extends TransacaoParent {
	
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
	function __construct($nId,$nIdTipoTransacao,$nIdUsuario,$sIdObjeto,$sCampo,$sValorAntigo,$sValorNovo,$sIp,$dDtCadastro,$bPublicado,$bAtivo){
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
	
}
?>