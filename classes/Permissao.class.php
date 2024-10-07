<?php
//á
require_once("PermissaoParent.class.php");

class Permissao extends PermissaoParent {
	
	/**
	* Construtor de Permissao
	* @param $nIdTipoTransacao IdTipoTransacao
	* @param $nIdGrupoUsuario IdGrupoUsuario
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	function __construct($nIdTipoTransacao,$nIdGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setIdTipoTransacao($nIdTipoTransacao);
		$this->setIdGrupoUsuario($nIdGrupoUsuario);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	
}
?>