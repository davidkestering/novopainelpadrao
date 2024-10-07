<?php
//á
require_once("CategoriaTipoTransacaoBDParent.class.php");

class CategoriaTipoTransacaoBD extends CategoriaTipoTransacaoBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}
} 
?>