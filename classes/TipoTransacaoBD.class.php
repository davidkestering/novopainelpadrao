<?php
//á
require_once("TipoTransacaoBDParent.class.php");

class TipoTransacaoBD extends TipoTransacaoBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}
	
	/**
	* Método responsável por excluir TipoTransacao
	* @access private
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativaPorCategoria($nIdCategoria) {
		$oConexao = $this->oConexao;
		$sSql = "update seg_tipo_transacao
				 set publicado = 0, ativo = 0
				 where   id_categoria_tipo_transacao = '$nIdCategoria' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

} 
?>