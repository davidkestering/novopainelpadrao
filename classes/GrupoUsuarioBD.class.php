<?php
//á
require_once("GrupoUsuarioBDParent.class.php");

class GrupoUsuarioBD extends GrupoUsuarioBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}

} 
?>