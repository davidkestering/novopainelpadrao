<?php
//á
require_once("TransacaoBDParent.class.php");

class TransacaoBD extends TransacaoBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}

} 
?>