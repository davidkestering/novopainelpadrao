<?php
//á
require_once("ErrosMysqlBDParent.class.php");

class ErrosMysqlBD extends ErrosMysqlBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}

} 
?>