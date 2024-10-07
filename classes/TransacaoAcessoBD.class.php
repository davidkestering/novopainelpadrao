<?php
//á
require_once("TransacaoAcessoBDParent.class.php");

class TransacaoAcessoBD extends TransacaoAcessoBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}

} 
?>