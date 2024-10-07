<?php
//á
require_once("TipoTransacaoParent.class.php");

class TipoTransacao extends TipoTransacaoParent {
	
	/**
	* Construtor de TipoTransacao
	* @param $nId Id
	* @param $nIdCategoriaTipoTransacao IdCategoriaTipoTransacao
	* @param $sTransacao Transacao
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	function __construct($nId,$nIdCategoriaTipoTransacao,$sTransacao,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setIdCategoriaTipoTransacao($nIdCategoriaTipoTransacao);
		$this->setTransacao($sTransacao);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	
}
?>