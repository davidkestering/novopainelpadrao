<?php
//á
require_once("PermissaoBDParent.class.php");

class PermissaoBD extends PermissaoBDParent {

	public $oConexao;

	function __construct($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}
	
	/**
	* Método responsável por excluir Permissao por Grupo Usuario
	* @access private
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativaPorGrupoUsuario($nIdGrupoUsuario) {
		$oConexao = $this->oConexao;
		$sSql = "update seg_permissao
				 set publicado = 0, ativo = 0
				 where id_grupo_usuario = '$nIdGrupoUsuario' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}
	
	/**
	* Método responsável por excluir Permissao por Tipo Transacao
	* @access private
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativaPorTipoTransacao($nIdTipoTransacao) {
		$oConexao = $this->oConexao;
		$sSql = "update seg_permissao
				 set publicado = 0, ativo = 0
				 where id_tipo_transacao = '$nIdTipoTransacao' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

} 
?>