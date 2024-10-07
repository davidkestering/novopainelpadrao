<?php
//á
require_once("ErrosMysqlParent.class.php");

class ErrosMysql extends ErrosMysqlParent {
	
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
	function __construct($nId,$sErro,$nIdUsuario,$sIp,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setErro($sErro);
		$this->setIdUsuario($nIdUsuario);
		$this->setIp($sIp);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	
}
?>