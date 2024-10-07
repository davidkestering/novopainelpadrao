<?php
//á
require_once("GrupoUsuario.class.php");
/**
* Classe responsável pelas interações com o banco de dados da entidade GrupoUsuario
*/
class GrupoUsuarioBDParent {

var $oConexao;

	/**
	* Método responsável por construir GrupoUsuario
	* @param $oConexao Conexão com o banco de dados. 
	* @access public
	*/
	/*
	function GrupoUsuarioBD($sBanco){
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
	* Método responsável por recuperar GrupoUsuario
	* @param $nId nId
	
	* @access public
	* @return object GrupoUsuario
	*/
	function recupera($nId) {
		$oConexao = $this->getConexao();
		$sSql = "select *						 
				 from   seg_grupo_usuario
		  		 where  id = '$nId'";
		$oConexao->execute($sSql);
		$oReg = $oConexao->fetchObject();
		if ($oReg) {
			$oGrupoUsuario = new GrupoUsuario($oReg->id,$oConexao->unescapeString($oReg->nm_grupo_usuario),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			return $oGrupoUsuario;
		}
		return false;
	}


	/**
	* Método responsável por verificar presença de GrupoUsuario
	* @param $nId nId
	
	* @access public
	* @return boolean Indicando presença ou ausência de GrupoUsuario
	*/
	function presente($nId){

		$oConexao = $this->getConexao();
		$sSql = "select id
				 from   seg_grupo_usuario
				 where  id = '$nId'
				";
		$oConexao->execute($sSql);
		if ($oConexao->getConsulta())
			return ($oConexao->recordCount() > 0);		
		return 0;
		
	}


	/**
	* Método responsável por inserir GrupoUsuario
	* @param object $oGrupoUsuario Objeto a ser inserido.
	* @access public
	* @return boolean Indicando sucesso ou não da operação;
	*/
	function insere($oGrupoUsuario) {
		$oConexao = $this->getConexao();
		$sSql = "insert into seg_grupo_usuario (nm_grupo_usuario,dt_cadastro,publicado,ativo) 
				 values ('".$oConexao->escapeString($oGrupoUsuario->getNmGrupoUsuario())."','".$oGrupoUsuario->getDtCadastro()."','".$oGrupoUsuario->getPublicado()."','".$oGrupoUsuario->getAtivo()."')";
		$oConexao->execute($sSql);		
		$nId = $oConexao->getLastId();
		if ($nId)
			return $nId;
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por alterar GrupoUsuario
	* @param object $oGrupoUsuario Objeto a ser alterado.
	* @access public
	* @return boolean Indicando presença ou ausência de GrupoUsuario
	*/
	function altera($oGrupoUsuario) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_grupo_usuario 
				 set    nm_grupo_usuario = '".$oConexao->escapeString($oGrupoUsuario->getNmGrupoUsuario())."',
						dt_cadastro = '".$oGrupoUsuario->getDtCadastro()."',
						publicado = '".$oGrupoUsuario->getPublicado()."',
						ativo = '".$oGrupoUsuario->getAtivo()."'
				 where  id = '".$oGrupoUsuario->getId()."' ";	
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por recuperar todos os representantes da entidade GrupoUsuario
	* @access public
	* @return array $voObjeto Vetor de objetos com os representantes de GrupoUsuario
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
				 FROM seg_grupo_usuario
				 WHERE
				 ";
				 $sSql = substr($sSql.$sSql2,0,-5);
			}else{
				$sSql = "SELECT * 
				 FROM seg_grupo_usuario ";
			}
		}
		else {
			$sSql = "SELECT * 
				 FROM seg_grupo_usuario ";
		}

		if ($sOrder) {
			$sSql .= " ORDER BY ".$sOrder;
		}

		$oConexao->execute($sSql);
		$voObjeto = array();
		while ($oReg = $oConexao->fetchObject()) {
			$oGrupoUsuario = new GrupoUsuario($oReg->id,$oConexao->unescapeString($oReg->nm_grupo_usuario),$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			$voObjeto[] = $oGrupoUsuario;
			unset($oGrupoUsuario);
		}
		return $voObjeto;
	}


	/**
	* Método responsável por excluir GrupoUsuario
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function exclui($nId) {
		$oConexao = $this->getConexao();
		$sSql = "delete from seg_grupo_usuario
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por desativar um registro da GrupoUsuario
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativa($nId) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_grupo_usuario
		 		 set ativo = '0'
				 where  id = '$nId' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

}
?>