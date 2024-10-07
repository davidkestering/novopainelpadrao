<?php
//á
require_once("UsuarioParent.class.php");

class Usuario extends UsuarioParent {
	
	/**
	* Construtor de Usuario
	* @param $nId Id
	* @param $nIdGrupoUsuario IdGrupoUsuario
	* @param $sNmUsuario NmUsuario
	* @param $sLogin Login
	* @param $sSenha Senha
	* @param $sEmail Email
	* @param $bLogado Logado
	* @param $dDtCadastro DtCadastro
	* @param $bPublicado Publicado
	* @param $bAtivo Ativo
	*/
	function __construct($nId,$nIdGrupoUsuario,$sNmUsuario,$sLogin,$sSenha,$sEmail,$bLogado,$dDtCadastro,$bPublicado,$bAtivo){
		$this->setId($nId);
		$this->setIdGrupoUsuario($nIdGrupoUsuario);
		$this->setNmUsuario($sNmUsuario);
		$this->setLogin($sLogin);
		$this->setSenha($sSenha);
		$this->setEmail($sEmail);
		$this->setLogado($bLogado);
		$this->setDtCadastro($dDtCadastro);
		$this->setPublicado($bPublicado);
		$this->setAtivo($bAtivo);
		
	}
	
}
?>