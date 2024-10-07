<?php
//á
require_once("CategoriaTipoTransacao.class.php");
/**
* Classe responsável pelas interações com o banco de dados da entidade CategoriaTipoTransacao
*/
class CategoriaTipoTransacaoBDParent {

var $oConexao;

	/**
	* Método responsável por construir CategoriaTipoTransacao
	* @param $oConexao Conexão com o banco de dados. 
	* @access public
	*/
	/*
	function CategoriaTipoTransacaoBD($sBanco){
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
	* Método responsável por recuperar CategoriaTipoTransacao
	* @param $nId nId
	
	* @access public
	* @return object CategoriaTipoTransacao
	*/
	function recupera($nId) {
		$oConexao = $this->getConexao();
		$sSql = "select *						 
				 from   seg_categoria_tipo_transacao
		  		 where  id = '$nId'";
		$oConexao->execute($sSql);
		$oReg = $oConexao->fetchObject();
		if ($oReg) {
			$oCategoriaTipoTransacao = new CategoriaTipoTransacao($oReg->id,$oConexao->unescapeString($oReg->descricao),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			return $oCategoriaTipoTransacao;
		}
		return false;
	}


	/**
	* Método responsável por verificar presença de CategoriaTipoTransacao
	* @param $nId nId
	
	* @access public
	* @return boolean Indicando presença ou ausência de CategoriaTipoTransacao
	*/
	function presente($nId){

		$oConexao = $this->getConexao();
		$sSql = "select id
				 from   seg_categoria_tipo_transacao
				 where  id = '$nId'
				";
		$oConexao->execute($sSql);
		if ($oConexao->getConsulta())
			return ($oConexao->recordCount() > 0);		
		return 0;
		
	}


	/**
	* Método responsável por inserir CategoriaTipoTransacao
	* @param object $oCategoriaTipoTransacao Objeto a ser inserido.
	* @access public
	* @return boolean Indicando sucesso ou não da operação;
	*/
	function insere($oCategoriaTipoTransacao) {
		$oConexao = $this->getConexao();
		$sSql = "insert into seg_categoria_tipo_transacao (descricao,dt_cadastro,publicado,ativo) 
				 values ('".$oConexao->escapeString($oCategoriaTipoTransacao->getDescricao())."','".$oCategoriaTipoTransacao->getDtCadastro()."','".$oCategoriaTipoTransacao->getPublicado()."','".$oCategoriaTipoTransacao->getAtivo()."')";
		$oConexao->execute($sSql);		
		$nId = $oConexao->getLastId();
		if ($nId)
			return $nId;
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por alterar CategoriaTipoTransacao
	* @param object $oCategoriaTipoTransacao Objeto a ser alterado.
	* @access public
	* @return boolean Indicando presença ou ausência de CategoriaTipoTransacao
	*/
	function altera($oCategoriaTipoTransacao) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_categoria_tipo_transacao 
				 set    descricao = '".$oConexao->escapeString($oCategoriaTipoTransacao->getDescricao())."',
						dt_cadastro = '".$oCategoriaTipoTransacao->getDtCadastro()."',
						publicado = '".$oCategoriaTipoTransacao->getPublicado()."',
						ativo = '".$oCategoriaTipoTransacao->getAtivo()."'
				 where  id = '".$oCategoriaTipoTransacao->getId()."' ";	
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por recuperar todos os representantes da entidade CategoriaTipoTransacao
	* @access public
	* @return array $voObjeto Vetor de objetos com os representantes de CategoriaTipoTransacao
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
				 FROM seg_categoria_tipo_transacao
				 WHERE
				 ";
				 $sSql = substr($sSql.$sSql2,0,-5);
			}else{
				$sSql = "SELECT * 
				 FROM seg_categoria_tipo_transacao ";
			}
		}
		else {
			$sSql = "SELECT * 
				 FROM seg_categoria_tipo_transacao ";
		}

		if ($sOrder) {
			$sSql .= " ORDER BY ".$sOrder;
		}

		$oConexao->execute($sSql);
		$voObjeto = array();
		while ($oReg = $oConexao->fetchObject()) {
			$oCategoriaTipoTransacao = new CategoriaTipoTransacao($oReg->id,$oConexao->unescapeString($oReg->descricao),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			$voObjeto[] = $oCategoriaTipoTransacao;
			unset($oCategoriaTipoTransacao);
		}
		return $voObjeto;
	}


	/**
	* Método responsável por excluir CategoriaTipoTransacao
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function exclui($nId) {
		$oConexao = $this->getConexao();
		$sSql = "delete from seg_categoria_tipo_transacao
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por desativar um registro da CategoriaTipoTransacao
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativa($nId) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_categoria_tipo_transacao
		 		 set ativo = '0'
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

}
?>