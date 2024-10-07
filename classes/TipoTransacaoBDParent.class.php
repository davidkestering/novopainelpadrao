<?php
//á
require_once("TipoTransacao.class.php");
/**
* Classe responsável pelas interações com o banco de dados da entidade TipoTransacao
*/
class TipoTransacaoBDParent {

var $oConexao;

	/**
	* Método responsável por construir TipoTransacao
	* @param $oConexao Conexão com o banco de dados. 
	* @access public
	*/
	/*
	function TipoTransacaoBD($sBanco){
		$this->oConexao = new Conexao($sBanco);
	}
	*/
	
	
	/**
	* Método responsável por atribuir valor ao atributo $oConexao
	* @param object $oConexao Conexão com o banco de dados.
	* @access public	
	*/
	function setConexao($oConexao){
		$this->oConexao = $oConexao;
	}
	
	
	/**
	* Método responsável recuperar o atributo $oConexao
	* @access public	
	* @return object $oConexao Conexão com o banco de dados.
	*/	
	function getConexao(){
		return $this->oConexao;
	}
	
	
	/**
	* Método responsável por recuperar TipoTransacao
	* @param $nId nId
	
	* @access public
	* @return object TipoTransacao
	*/
	function recupera($nId) {
		$oConexao = $this->getConexao();
		$sSql = "select *						 
				 from   seg_tipo_transacao
		  		 where  id = '$nId'";
		$oConexao->execute($sSql);
		$oReg = $oConexao->fetchObject();
		if ($oReg) {
			$oTipoTransacao = new TipoTransacao($oReg->id,$oReg->id_categoria_tipo_transacao,$oConexao->unescapeString($oReg->transacao),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			return $oTipoTransacao;
		}
		return false;
	}


	/**
	* Método responsável por verificar presença de TipoTransacao
	* @param $nId nId
	
	* @access public
	* @return boolean Indicando presença ou ausência de TipoTransacao
	*/
	function presente($nId){

		$oConexao = $this->getConexao();
		$sSql = "select id
				 from   seg_tipo_transacao
				 where  id = '$nId'
				";
		$oConexao->execute($sSql);
		if ($oConexao->getConsulta())
			return ($oConexao->recordCount() > 0);		
		return 0;
		
	}


	/**
	* Método responsável por inserir TipoTransacao
	* @param object $oTipoTransacao Objeto a ser inserido.
	* @access public
	* @return boolean Indicando sucesso ou não da operação;
	*/
	function insere($oTipoTransacao) {
		$oConexao = $this->getConexao();
		$sSql = "insert into seg_tipo_transacao (id_categoria_tipo_transacao,transacao,dt_cadastro,publicado,ativo) 
				 values ('".$oTipoTransacao->getIdCategoriaTipoTransacao()."','".$oConexao->escapeString($oTipoTransacao->getTransacao())."','".$oTipoTransacao->getDtCadastro()."','".$oTipoTransacao->getPublicado()."','".$oTipoTransacao->getAtivo()."')";
		$oConexao->execute($sSql);		
		$nId = $oConexao->getLastId();
		if ($nId)
			return $nId;
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por alterar TipoTransacao
	* @param object $oTipoTransacao Objeto a ser alterado.
	* @access public
	* @return boolean Indicando presença ou ausência de TipoTransacao
	*/
	function altera($oTipoTransacao) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_tipo_transacao 
				 set    id_categoria_tipo_transacao = '".$oTipoTransacao->getIdCategoriaTipoTransacao()."',
						transacao = '".$oConexao->escapeString($oTipoTransacao->getTransacao())."',
						dt_cadastro = '".$oTipoTransacao->getDtCadastro()."',
						publicado = '".$oTipoTransacao->getPublicado()."',
						ativo = '".$oTipoTransacao->getAtivo()."'
				 where  id = '".$oTipoTransacao->getId()."' ";	
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por recuperar todos os representantes da entidade TipoTransacao
	* @access public
	* @return array $voObjeto Vetor de objetos com os representantes de TipoTransacao
	*/
	function recuperaTodos($vWhere,$sOrder) {
		$oConexao = $this->getConexao();
		
		
		if (count($vWhere) > 0) {
			$sSql2 = "";
			foreach ($vWhere as $sWhere) {
				if($sWhere != "")
					$sSql2 .= $sWhere . " AND ";
			}
			if($sSql2 != ""){
				$sSql = "SELECT * 
				 FROM seg_tipo_transacao
				 WHERE
				 ";
				 $sSql = substr($sSql.$sSql2,0,-5);
			}else{
				$sSql = "SELECT * 
				 FROM seg_tipo_transacao ";
			}
		}
		else {
			$sSql = "SELECT * 
				 FROM seg_tipo_transacao ";
		}

		if ($sOrder) {
			$sSql .= " ORDER BY ".$sOrder;
		}

		$oConexao->execute($sSql);
		$voObjeto = array();
		while ($oReg = $oConexao->fetchObject()) {
			$oTipoTransacao = new TipoTransacao($oReg->id,$oReg->id_categoria_tipo_transacao,$oConexao->unescapeString($oReg->transacao),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			$voObjeto[] = $oTipoTransacao;
			unset($oTipoTransacao);
		}
		return $voObjeto;
	}


	/**
	* Método responsável por excluir TipoTransacao
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function exclui($nId) {
		$oConexao = $this->getConexao();
		$sSql = "delete from seg_tipo_transacao
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por desativar um registro da TipoTransacao
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativa($nId) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_tipo_transacao
		 		 set ativo = '0'
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

}
?>