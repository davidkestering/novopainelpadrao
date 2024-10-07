<?php
//á
require_once("GrupoUsuarioParent.class.php");

class GrupoUsuario extends GrupoUsuarioParent {
	
	/**
	* Construtor de GrupoUsuario
	* @param $nId Id
	* @param $sNmGrupoUsuario NmGrupoUsuario
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	function __construct($nId,$sNmGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setNmGrupoUsuario($sNmGrupoUsuario);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	
}
?>