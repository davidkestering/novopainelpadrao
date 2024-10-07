<?php
//á
require_once("ErrosMysql.class.php");
/**
* Classe responsável pelas interações com o banco de dados da entidade ErrosMysql
*/
class ErrosMysqlBDParent {

var $oConexao;

	/**
	* Método responsável por construir ErrosMysql
	* @param $oConexao Conexão com o banco de dados. 
	* @access public
	*/
	/*
	function ErrosMysqlBD($sBanco){
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
	* Método responsável por recuperar ErrosMysql
	* @param $nId nId
	
	* @access public
	* @return object ErrosMysql
	*/
	function recupera($nId) {
		$oConexao = $this->getConexao();
		$sSql = "select *						 
				 from   seg_erros_mysql
		  		 where  id = '$nId'";
		$oConexao->execute($sSql);
		$oReg = $oConexao->fetchObject();
		if ($oReg) {
			$oErrosMysql = new ErrosMysql($oReg->id,$oConexao->unescapeString($oReg->erro),$oReg->id_usuario,$oConexao->unescapeString($oReg->ip),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			return $oErrosMysql;
		}
		return false;
	}


	/**
	* Método responsável por verificar presença de ErrosMysql
	* @param $nId nId
	
	* @access public
	* @return boolean Indicando presença ou ausência de ErrosMysql
	*/
	function presente($nId){

		$oConexao = $this->getConexao();
		$sSql = "select id
				 from   seg_erros_mysql
				 where  id = '$nId'
				";
		$oConexao->execute($sSql);
		if ($oConexao->getConsulta())
			return ($oConexao->recordCount() > 0);		
		return 0;
		
	}


	/**
	* Método responsável por inserir ErrosMysql
	* @param object $oErrosMysql Objeto a ser inserido.
	* @access public
	* @return boolean Indicando sucesso ou não da operação;
	*/
	function insere($oErrosMysql) {
		$oConexao = $this->getConexao();
		$sSql = "insert into seg_erros_mysql (erro,id_usuario,ip,dt_cadastro,publicado,ativo) 
				 values ('".$oConexao->escapeString($oErrosMysql->getErro())."','".$oErrosMysql->getIdUsuario()."','".$oConexao->escapeString($oErrosMysql->getIp())."','".$oErrosMysql->getDtCadastro()."','".$oErrosMysql->getPublicado()."','".$oErrosMysql->getAtivo()."')";
		$oConexao->execute($sSql);		
		$nId = $oConexao->getLastId();
		if ($nId)
			return $nId;
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por alterar ErrosMysql
	* @param object $oErrosMysql Objeto a ser alterado.
	* @access public
	* @return boolean Indicando presença ou ausência de ErrosMysql
	*/
	function altera($oErrosMysql) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_erros_mysql 
				 set    erro = '".$oConexao->escapeString($oErrosMysql->getErro())."',
						id_usuario = '".$oErrosMysql->getIdUsuario()."',
						ip = '".$oConexao->escapeString($oErrosMysql->getIp())."',
						dt_cadastro = '".$oErrosMysql->getDtCadastro()."',
						publicado = '".$oErrosMysql->getPublicado()."',
						ativo = '".$oErrosMysql->getAtivo()."'
				 where  id = '".$oErrosMysql->getId()."' ";	
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por recuperar todos os representantes da entidade ErrosMysql
	* @access public
	* @return array $voObjeto Vetor de objetos com os representantes de ErrosMysql
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
				 FROM seg_erros_mysql
				 WHERE
				 ";
				 $sSql = substr($sSql.$sSql2,0,-5);
			}else{
				$sSql = "SELECT * 
				 FROM seg_erros_mysql ";
			}
		}
		else {
			$sSql = "SELECT * 
				 FROM seg_erros_mysql ";
		}

		if ($sOrder) {
			$sSql .= " ORDER BY ".$sOrder;
		}

		$oConexao->execute($sSql);
		$voObjeto = array();
		while ($oReg = $oConexao->fetchObject()) {
			$oErrosMysql = new ErrosMysql($oReg->id,$oConexao->unescapeString($oReg->erro),$oReg->id_usuario,$oConexao->unescapeString($oReg->ip),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			$voObjeto[] = $oErrosMysql;
			unset($oErrosMysql);
		}
		return $voObjeto;
	}


	/**
	* Método responsável por excluir ErrosMysql
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function exclui($nId) {
		$oConexao = $this->getConexao();
		$sSql = "delete from seg_erros_mysql
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por desativar um registro da ErrosMysql
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativa($nId) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_erros_mysql
		 		 set ativo = '0'
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

}
?>