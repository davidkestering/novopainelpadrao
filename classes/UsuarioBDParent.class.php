<?php
//á
require_once("Usuario.class.php");
/**
* Classe responsável pelas interações com o banco de dados da entidade Usuario
*/
class UsuarioBDParent {

var $oConexao;

	/**
	* Método responsável por construir Usuario
	* @param $oConexao Conexão com o banco de dados. 
	* @access public
	*/
	/*
	function UsuarioBD($sBanco){
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
	* Método responsável por recuperar Usuario
	* @param $nId nId
	
	* @access public
	* @return object Usuario
	*/
	function recupera($nId) {
		$oConexao = $this->getConexao();
		$sSql = "select *						 
				 from   seg_usuario
		  		 where  id = '$nId'";
		$oConexao->execute($sSql);
		$oReg = $oConexao->fetchObject();
		if ($oReg) {
			$oUsuario = new Usuario($oReg->id,$oReg->id_grupo_usuario,$oConexao->unescapeString($oReg->nm_usuario),$oConexao->unescapeString($oReg->login),$oConexao->unescapeString($oReg->senha),$oConexao->unescapeString($oReg->email),$oReg->logado,$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			return $oUsuario;
		}
		return false;
	}


	/**
	* Método responsável por verificar presença de Usuario
	* @param $nId nId
	
	* @access public
	* @return boolean Indicando presença ou ausência de Usuario
	*/
	function presente($nId){

		$oConexao = $this->getConexao();
		$sSql = "select id
				 from   seg_usuario
				 where  id = '$nId'
				";
		$oConexao->execute($sSql);
		if ($oConexao->getConsulta())
			return ($oConexao->recordCount() > 0);		
		return 0;
		
	}


	/**
	* Método responsável por inserir Usuario
	* @param object $oUsuario Objeto a ser inserido.
	* @access public
	* @return boolean Indicando sucesso ou não da operação;
	*/
	function insere($oUsuario) {
		$oConexao = $this->getConexao();
		$sSql = "insert into seg_usuario (id_grupo_usuario,nm_usuario,login,senha,email,logado,dt_cadastro,publicado,ativo) 
				 values ('".$oUsuario->getIdGrupoUsuario()."','".$oConexao->escapeString($oUsuario->getNmUsuario())."','".$oConexao->escapeString($oUsuario->getLogin())."','".$oConexao->escapeString($oUsuario->getSenha())."','".$oConexao->escapeString($oUsuario->getEmail())."','".$oUsuario->getLogado()."','".$oUsuario->getDtCadastro()."','".$oUsuario->getPublicado()."','".$oUsuario->getAtivo()."')";
		//print_r($sSql);
		//die();	
		$oConexao->execute($sSql);
		$nId = $oConexao->getLastId();
		if ($nId)
			return $nId;
		else{
		    $oConexao->insereErroSql($sSql);
            return false;
        }

		return $oConexao->getConsulta();
	}


	/**
	* Método responsável por alterar Usuario
	* @param object $oUsuario Objeto a ser alterado.
	* @access public
	* @return boolean Indicando presença ou ausência de Usuario
	*/
	function altera($oUsuario) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_usuario 
				 set    id_grupo_usuario = '".$oUsuario->getIdGrupoUsuario()."',
						nm_usuario = '".$oConexao->escapeString($oUsuario->getNmUsuario())."',
						login = '".$oConexao->escapeString($oUsuario->getLogin())."',
						senha = '".$oConexao->escapeString($oUsuario->getSenha())."',
						email = '".$oConexao->escapeString($oUsuario->getEmail())."',
						logado = '".$oUsuario->getLogado()."',
						dt_cadastro = '".$oUsuario->getDtCadastro()."',
						publicado = '".$oUsuario->getPublicado()."',
						ativo = '".$oUsuario->getAtivo()."'
				 where  id = '".$oUsuario->getId()."' ";
        $oConexao->execute($sSql);
        return $oConexao->getConsulta();
	}


	/**
	* Método responsável por recuperar todos os representantes da entidade Usuario
	* @access public
	* @return array $voObjeto Vetor de objetos com os representantes de Usuario
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
				 FROM seg_usuario
				 WHERE
				 ";
				 $sSql = substr($sSql.$sSql2,0,-5);
			}else{
				$sSql = "SELECT * 
				 FROM seg_usuario ";
			}
		}
		else {
			$sSql = "SELECT * 
				 FROM seg_usuario ";
		}

		if ($sOrder) {
			$sSql .= " ORDER BY ".$sOrder;
		}
		
		$oConexao->execute($sSql);
		$voObjeto = array();
		while ($oReg = $oConexao->fetchObject()) {
			$oUsuario = new Usuario($oReg->id,$oReg->id_grupo_usuario,$oConexao->unescapeString($oReg->nm_usuario),$oConexao->unescapeString($oReg->login),$oConexao->unescapeString($oReg->senha),$oConexao->unescapeString($oReg->email),$oReg->logado,$oReg->dt_cadastro,$oReg->publicado,$oReg->ativo);
			$voObjeto[] = $oUsuario;
			unset($oUsuario);
		}
		return $voObjeto;
	}


	/**
	* Método responsável por excluir Usuario
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function exclui($nId) {
		$oConexao = $this->getConexao();
		$sSql = "delete from seg_usuario
				 where  id = '$nId' ";
        $oConexao->execute($sSql);
        return $oConexao->getConsulta();
	}


	/**
	* Método responsável por desativar um registro da Usuario
	* @access public
	* @return boolean Indicando sucesso ou não da operação
	*/
	function desativa($nId) {
		$oConexao = $this->getConexao();
		$sSql = "update seg_usuario
		 		 set ativo = '0'
				 where  id = '$nId' ";
        $oConexao->execute($sSql);
        return $oConexao->getConsulta();
	}

}
?>