<?php
//á
require_once("UsuarioBDParent.class.php");

class UsuarioBD extends UsuarioBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}
	
} 
?>