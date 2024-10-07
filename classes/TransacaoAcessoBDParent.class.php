<?php
//á
require_once("TransacaoAcesso.class.php");
/**
* Classe responsável pelas interações com o banco de dados da entidade TransacaoAcesso
*/
class TransacaoAcessoBDParent {

var $oConexao;

	/**
	* Método responsável por construir TransacaoAcesso
	* @param $oConexao Conexão com o banco de dados. 
	* @access public
	*/
	/*
	function TransacaoAcessoBD($sBanco){
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
	* Método responsável por recuperar TransacaoAcesso
	* @param $nId nId
	
	* @access public
	* @return object TransacaoAcesso
	*/
	function recupera($nId) {
		$oConexao = $this->getConexao();
		$sSql = "select *						 
				 from   seg_transacao_acesso
		  		 where  id = '$nId'";
		$oConexao->execute($sSql);
		$oReg = $oConexao->fetchObject();
		if ($oReg) {
			$oTransacaoAcesso = new TransacaoAcesso($oReg->id,$oReg->id_tipo_transacao,$oReg->id_usuario,$oConexao->unescapeString($oReg->id_objeto),$oConexao->unescapeString($oReg->objeto),$oConexao->unescapeString($oReg->campo),$oConexao->unescapeString($oReg->valor_antigo),$oConexao->unescapeString($oReg->valor_novo),$oConexao->unescapeString($oReg->ip),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			return $oTransacaoAcesso;
		}
		return false;
	}


	/**
	* Método responsável por verificar presença de TransacaoAcesso
	* @param $nId nId
	
	* @access public
	* @return boolean Indicando presença ou ausência de TransacaoAcesso
	*/
	function presente($nId){

		$oConexao = $this->getConexao();
		$sSql = "select id
				 from   seg_transacao_acesso
				 where  id = '$nId'
				";
		$oConexao->execute($sSql);
		if ($oConexao->getConsulta())
			return ($oConexao->recordCount() > 0);		
		return 0;
		
	}


	/**
	* Método responsável por inserir TransacaoAcesso
	* @param object $oTransacaoAcesso Objeto a ser inserido.
	* @access public
	* @return boolean Indicando sucesso ou não da operação;
	*/
	function insere($oTransacaoAcesso) {
		$oConexao = $this->getConexao();
		$sSql = "insert into seg_transacao_acesso (id_tipo_transacao,id_usuario,id_objeto,objeto,campo,valor_antigo,valor_novo,ip,dt_cadastro,publicado,ativo) 
				 values ('".$oTransacaoAcesso->getIdTipoTransacao()."','".$oTransacaoAcesso->getIdUsuario()."','".$oConexao->escapeString($oTransacaoAcesso->getIdObjeto())."','".$oConexao->escapeString($oTransacaoAcesso->getObjeto())."','".$oConexao->escapeString($oTransacaoAcesso->getCampo())."','".$oConexao->escapeString($oTransacaoAcesso->getValorAntigo())."','".$oConexao->escapeString($oTransacaoAcesso->getValorNovo())."','".$oConexao->escapeString($oTransacaoAcesso->getIp())."','".$oTransacaoAcesso->getDtCadastro()."','".$oTransacaoAcesso->getPublicado()."','".$oTransacaoAcesso->getAtivo()."')";		
		$oConexao->execute($sSql);		
		$nId = $oConexao->getLastId();
		if ($nId)
			return $nId;
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por alterar TransacaoAcesso
	* @param object $oTransacaoAcesso Objeto a ser alterado.
	* @access public
	* @return boolean Indicando presença ou ausência de TransacaoAcesso
	*/
	function altera($oTransacaoAcesso) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_transacao_acesso 
				 set    id_tipo_transacao = '".$oTransacaoAcesso->getIdTipoTransacao()."',
						id_usuario = '".$oTransacaoAcesso->getIdUsuario()."',
						id_objeto = '".$oConexao->escapeString($oTransacaoAcesso->getIdObjeto())."',
						objeto = '".$oConexao->escapeString($oTransacaoAcesso->getObjeto())."',
						campo = '".$oConexao->escapeString($oTransacaoAcesso->getCampo())."',
						valor_antigo = '".$oConexao->escapeString($oTransacaoAcesso->getValorAntigo())."',
						valor_novo = '".$oConexao->escapeString($oTransacaoAcesso->getValorNovo())."',
						ip = '".$oConexao->escapeString($oTransacaoAcesso->getIp())."',
						dt_cadastro = '".$oTransacaoAcesso->getDtCadastro()."',
						publicado = '".$oTransacaoAcesso->getPublicado()."',
						ativo = '".$oTransacaoAcesso->getAtivo()."'
				 where  id = '".$oTransacaoAcesso->getId()."' ";	
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por recuperar todos os representantes da entidade TransacaoAcesso
	* @access public
	* @return array $voObjeto Vetor de objetos com os representantes de TransacaoAcesso
	*/
	function recuperaTodos($vWhere,$sOrder) {
		$oConexao = $this->getConexao();
		
		
		if (is_array($vWhere) && count($vWhere) > 0) {
			$sSql2 = "";
			foreach ($vWhere as $sWhere) {
				if($sWhere != "")
					$sSql2 .= $sWhere . " AND ";
			}
			if($sSql2 != ""){
				$sSql = "SELECT * 
				 FROM seg_transacao_acesso
				 WHERE
				 ";
				 $sSql = substr($sSql.$sSql2,0,-5);
			}else{
				$sSql = "SELECT * 
				 FROM seg_transacao_acesso ";
			}
		}
		else {
			$sSql = "SELECT * 
				 FROM seg_transacao_acesso ";
		}

		if ($sOrder) {
			$sSql .= " ORDER BY ".$sOrder;
		}

		$oConexao->execute($sSql);
		$voObjeto = array();
		while ($oReg = $oConexao->fetchObject()) {
			$oTransacaoAcesso = new TransacaoAcesso($oReg->id,$oReg->id_tipo_transacao,$oReg->id_usuario,$oConexao->unescapeString($oReg->id_objeto),$oConexao->unescapeString($oReg->objeto),$oConexao->unescapeString($oReg->campo),$oConexao->unescapeString($oReg->valor_antigo),$oConexao->unescapeString($oReg->valor_novo),$oConexao->unescapeString($oReg->ip),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			$voObjeto[] = $oTransacaoAcesso;
			unset($oTransacaoAcesso);
		}
		return $voObjeto;
	}


	/**
	* Método responsável por excluir TransacaoAcesso
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function exclui($nId) {
		$oConexao = $this->getConexao();
		$sSql = "delete from seg_transacao_acesso
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por desativar um registro da TransacaoAcesso
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativa($nId) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_transacao_acesso
		 		 set ativo = '0'
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

}
?>