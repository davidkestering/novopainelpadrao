<?php
//á
require_once("CategoriaTipoTransacaoParent.class.php");

class CategoriaTipoTransacao extends CategoriaTipoTransacaoParent {
	
	/**
	* Construtor de CategoriaTipoTransacao
	* @param $nId Id
	* @param $sDescricao Descricao
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	function __construct($nId,$sDescricao,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setDescricao($sDescricao);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	
}
?>