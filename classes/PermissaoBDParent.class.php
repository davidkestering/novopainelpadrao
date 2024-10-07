<?php
//á
require_once("Permissao.class.php");
/**
* Classe responsável pelas interações com o banco de dados da entidade Permissao
*/
class PermissaoBDParent {

var $oConexao;

	/**
	* Método responsável por construir Permissao
	* @param $oConexao Conexão com o banco de dados. 
	* @access public
	*/
	/*
	function PermissaoBD($sBanco){
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
	* Método responsável por recuperar Permissao
	* @param $nIdTipoTransacao nIdTipoTransacao
	* @param $nIdGrupoUsuario nIdGrupoUsuario
	
	* @access public
	* @return object Permissao
	*/
	function recupera($nIdTipoTransacao,$nIdGrupoUsuario) {
		$oConexao = $this->getConexao();
		$sSql = "select *						 
				 from   seg_permissao
		  		 where  id_tipo_transacao = '$nIdTipoTransacao'
				 and 	id_grupo_usuario = '$nIdGrupoUsuario'";
		$oConexao->execute($sSql);
		$oReg = $oConexao->fetchObject();
		if ($oReg) {
			$oPermissao = new Permissao($oReg->id_tipo_transacao,$oReg->id_grupo_usuario,$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			return $oPermissao;
		}
		return false;
	}


	/**
	* Método responsável por verificar presença de Permissao
	* @param $nIdTipoTransacao nIdTipoTransacao
	* @param $nIdGrupoUsuario nIdGrupoUsuario
	
	* @access public
	* @return boolean Indicando presença ou ausência de Permissao
	*/
	function presente($nIdTipoTransacao,$nIdGrupoUsuario){

		$oConexao = $this->getConexao();
		$sSql = "select id_tipo_transacao,id_grupo_usuario
				 from   seg_permissao
				 where  id_tipo_transacao = '$nIdTipoTransacao'
				 and 	id_grupo_usuario = '$nIdGrupoUsuario'
				";
		$oConexao->execute($sSql);
		if ($oConexao->getConsulta())
			return ($oConexao->recordCount() > 0);		
		return 0;
		
	}


	/**
	* Método responsável por inserir Permissao
	* @param object $oPermissao Objeto a ser inserido.
	* @access public
	* @return boolean Indicando sucesso ou não da operação;
	*/
	function insere($oPermissao) {
		$oConexao = $this->getConexao();
		$sSql = "insert into seg_permissao (id_tipo_transacao,id_grupo_usuario,dt_cadastro,publicado,ativo) 
				 values ('".$oPermissao->getIdTipoTransacao()."','".$oPermissao->getIdGrupoUsuario()."','".$oPermissao->getDtCadastro()."','".$oPermissao->getPublicado()."','".$oPermissao->getAtivo()."')";
		$oConexao->execute($sSql);		
		$nId = $oConexao->getLastId();
		if ($nId)
			return $nId;
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por alterar Permissao
	* @param object $oPermissao Objeto a ser alterado.
	* @access public
	* @return boolean Indicando presença ou ausência de Permissao
	*/
	function altera($oPermissao) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_permissao 
				 set    dt_cadastro = '".$oPermissao->getDtCadastro()."',
						publicado = '".$oPermissao->getPublicado()."',
						ativo = '".$oPermissao->getAtivo()."'
				 where  id_tipo_transacao = '".$oPermissao->getIdTipoTransacao()."'
				 and 	id_grupo_usuario = '".$oPermissao->getIdGrupoUsuario()."' ";	
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por recuperar todos os representantes da entidade Permissao
	* @access public
	* @return array $voObjeto Vetor de objetos com os representantes de Permissao
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
				 FROM seg_permissao
				 WHERE
				 ";
				 $sSql = substr($sSql.$sSql2,0,-5);
			}else{
				$sSql = "SELECT * 
				 FROM seg_permissao ";
			}
		}
		else {
			$sSql = "SELECT * 
				 FROM seg_permissao ";
		}

		if ($sOrder) {
			$sSql .= " ORDER BY ".$sOrder;
		}

		$oConexao->execute($sSql);
		$voObjeto = array();
		while ($oReg = $oConexao->fetchObject()) {
			$oPermissao = new Permissao($oReg->id_tipo_transacao,$oReg->id_grupo_usuario,$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			$voObjeto[] = $oPermissao;
			unset($oPermissao);
		}
		return $voObjeto;
	}


	/**
	* Método responsável por excluir Permissao
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function exclui($nIdTipoTransacao,$nIdGrupoUsuario) {
		$oConexao = $this->getConexao();
		$sSql = "delete from seg_permissao
				 where  id_tipo_transacao = '$nIdTipoTransacao'
				 and 	id_grupo_usuario = '$nIdGrupoUsuario' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por desativar um registro da Permissao
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativa($nIdTipoTransacao,$nIdGrupoUsuario) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_permissao
		 		 set ativo = '0'
				 where  id_tipo_transacao = '$nIdTipoTransacao'
				 and 	id_grupo_usuario = '$nIdGrupoUsuario' ";					
		$oConexao->execute($sSql);
		return $oConexao->getConsulta();
	}

}
?>