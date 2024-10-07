<?php
require_once("Conexao.class.php");
require_once("CategoriaTipoTransacao.class.php");
require_once("CategoriaTipoTransacaoBD.class.php");
require_once("ErrosMysql.class.php");
require_once("ErrosMysqlBD.class.php");
require_once("GrupoUsuario.class.php");
require_once("GrupoUsuarioBD.class.php");
require_once("Permissao.class.php");
require_once("PermissaoBD.class.php");
require_once("TipoTransacao.class.php");
require_once("TipoTransacaoBD.class.php");
require_once("Transacao.class.php");
require_once("TransacaoBD.class.php");
require_once("TransacaoAcesso.class.php");
require_once("TransacaoAcessoBD.class.php");
require_once("Usuario.class.php");
require_once("UsuarioBD.class.php");
require_once("FachadaSegurancaBD.class.php");

/**
* Classe responsável por todas as interações com o BD do sistema.
*/
class FachadaSegurancaBDParent {

	/**
	* Método responsável por criar a Conexão.
	* @param $sBanco Nome do Banco de Dados
	* @return object $oConexao Conexão com o banco de dados especificado.
	*/
	function inicializaConexao($sBanco = ""){
		$oConexao = new Conexao($sBanco);
		return $oConexao;
	}
	
	
	/***á
	* Método responsável por instanciar um objeto de CategoriaTipoTransacao
	* @access public
	* @return object $oCategoriaTipoTransacao CategoriaTipoTransacao
	*/	
	function inicializaCategoriaTipoTransacao($nId,$sDescricao,$dDtCadastro,$bPublicado,$bAtivo) {
		$oCategoriaTipoTransacao = new CategoriaTipoTransacao($nId,$sDescricao,$dDtCadastro,$bPublicado,$bAtivo);
		return $oCategoriaTipoTransacao;
	}


	/**
	* Método responsável por instanciar um objeto de CategoriaTipoTransacaoBD
	* @access public
	* @return object $oCategoriaTipoTransacaoBD CategoriaTipoTransacaoBD
	*/	
	function inicializaCategoriaTipoTransacaoBD($sBanco) {
		$oCategoriaTipoTransacaoBD = new CategoriaTipoTransacaoBD($sBanco);
		return $oCategoriaTipoTransacaoBD;
	}


	/** 
	* Método responsável por recuperar CategoriaTipoTransacao
	* @param $nId nId
	* @access public
	* @return object $oCategoriaTipoTransacao CategoriaTipoTransacao
	*/
	function recuperaCategoriaTipoTransacao($nId,$sBanco) {
		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
 		$oCategoriaTipoTransacao = $oCategoriaTipoTransacaoBD->recupera($nId);
		return $oCategoriaTipoTransacao;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade CategoriaTipoTransacao
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de CategoriaTipoTransacao
	*/
	function recuperaTodosCategoriaTipoTransacao($sBanco,$vWhere=null,$vOrder=null) {
		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oCategoriaTipoTransacaoBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de CategoriaTipoTransacao
	* @param $nId nId
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de CategoriaTipoTransacao
	*/
	function presenteCategoriaTipoTransacao($nId,$sBanco){
		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
 		$bResultado = $oCategoriaTipoTransacaoBD->presente($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir CategoriaTipoTransacao
	* @param object $oCategoriaTipoTransacao Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function insereCategoriaTipoTransacao($oCategoriaTipoTransacao,$voTransacao,$sBanco) {
		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
 		$nId = $oCategoriaTipoTransacaoBD->insere($oCategoriaTipoTransacao);
        // INSERE TRANSAÇÃO
        if($nId && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $nId;
	}


	/** 
	* Método responsável por alterar CategoriaTipoTransacao
	* @param object $oCategoriaTipoTransacao Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de CategoriaTipoTransacao
	*/
	function alteraCategoriaTipoTransacao($oCategoriaTipoTransacao,$voTransacao,$sBanco) {
		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
 		$bResultado = $oCategoriaTipoTransacaoBD->altera($oCategoriaTipoTransacao);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por excluir CategoriaTipoTransacao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiCategoriaTipoTransacao($nId,$voTransacao,$sBanco) {
		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
 		$bResultado = $oCategoriaTipoTransacaoBD->exclui($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro CategoriaTipoTransacao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaCategoriaTipoTransacao($nId,$voTransacao,$sBanco) {
		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
 		$bResultado = $oCategoriaTipoTransacaoBD->desativa($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}

	/***á
	* Método responsável por instanciar um objeto de ErrosMysql
	* @access public
	* @return object $oErrosMysql ErrosMysql
	*/	
	function inicializaErrosMysql($nId,$sErro,$nIdUsuario,$sIp,$dDtCadastro,$bPublicado,$bAtivo) {
		$oErrosMysql = new ErrosMysql($nId,$sErro,$nIdUsuario,$sIp,$dDtCadastro,$bPublicado,$bAtivo);
		return $oErrosMysql;
	}


	/**
	* Método responsável por instanciar um objeto de ErrosMysqlBD
	* @access public
	* @return object $oErrosMysqlBD ErrosMysqlBD
	*/	
	function inicializaErrosMysqlBD($sBanco) {
		$oErrosMysqlBD = new ErrosMysqlBD($sBanco);
		return $oErrosMysqlBD;
	}


	/** 
	* Método responsável por recuperar ErrosMysql
	* @param $nId nId
	* @access public
	* @return object $oErrosMysql ErrosMysql
	*/
	function recuperaErrosMysql($nId,$sBanco) {
		$oErrosMysqlBD = $this->inicializaErrosMysqlBD($sBanco);
 		$oErrosMysql = $oErrosMysqlBD->recupera($nId);
		return $oErrosMysql;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade ErrosMysql
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de ErrosMysql
	*/
	function recuperaTodosErrosMysql($sBanco,$vWhere=null,$vOrder=null) {
		$oErrosMysqlBD = $this->inicializaErrosMysqlBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oErrosMysqlBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de ErrosMysql
	* @param $nId nId
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de ErrosMysql
	*/
	function presenteErrosMysql($nId,$sBanco){
		$oErrosMysqlBD = $this->inicializaErrosMysqlBD($sBanco);
 		$bResultado = $oErrosMysqlBD->presente($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir ErrosMysql
	* @param object $oErrosMysql Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function insereErrosMysql($oErrosMysql,$voTransacao,$sBanco) {
		$oErrosMysqlBD = $this->inicializaErrosMysqlBD($sBanco);
 		$nId = $oErrosMysqlBD->insere($oErrosMysql);
        // INSERE TRANSAÇÃO
        if($nId && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $nId;
	}


	/** 
	* Método responsável por alterar ErrosMysql
	* @param object $oErrosMysql Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de ErrosMysql
	*/
	function alteraErrosMysql($oErrosMysql,$voTransacao,$sBanco) {
		$oErrosMysqlBD = $this->inicializaErrosMysqlBD($sBanco);
 		$bResultado = $oErrosMysqlBD->altera($oErrosMysql);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por excluir ErrosMysql
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiErrosMysql($nId,$voTransacao,$sBanco) {
		$oErrosMysqlBD = $this->inicializaErrosMysqlBD($sBanco);
 		$bResultado = $oErrosMysqlBD->exclui($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro ErrosMysql
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaErrosMysql($nId,$voTransacao,$sBanco) {
		$oErrosMysqlBD = $this->inicializaErrosMysqlBD($sBanco);
 		$bResultado = $oErrosMysqlBD->desativa($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}

	
	/***á
	* Método responsável por instanciar um objeto de GrupoUsuario
	* @access public
	* @return object $oGrupoUsuario GrupoUsuario
	*/	
	function inicializaGrupoUsuario($nId,$sNmGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo) {
		$oGrupoUsuario = new GrupoUsuario($nId,$sNmGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo);
		return $oGrupoUsuario;
	}


	/**
	* Método responsável por instanciar um objeto de GrupoUsuarioBD
	* @access public
	* @return object $oGrupoUsuarioBD GrupoUsuarioBD
	*/	
	function inicializaGrupoUsuarioBD($sBanco) {
		$oGrupoUsuarioBD = new GrupoUsuarioBD($sBanco);
		return $oGrupoUsuarioBD;
	}


	/** 
	* Método responsável por recuperar GrupoUsuario
	* @param $nId nId
	* @access public
	* @return object $oGrupoUsuario GrupoUsuario
	*/
	function recuperaGrupoUsuario($nId,$sBanco) {
		$oGrupoUsuarioBD = $this->inicializaGrupoUsuarioBD($sBanco);
 		$oGrupoUsuario = $oGrupoUsuarioBD->recupera($nId);
		return $oGrupoUsuario;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade GrupoUsuario
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de GrupoUsuario
	*/
	function recuperaTodosGrupoUsuario($sBanco,$vWhere=null,$vOrder=null) {
		$oGrupoUsuarioBD = $this->inicializaGrupoUsuarioBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oGrupoUsuarioBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de GrupoUsuario
	* @param $nId nId
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de GrupoUsuario
	*/
	function presenteGrupoUsuario($nId,$sBanco){
		$oGrupoUsuarioBD = $this->inicializaGrupoUsuarioBD($sBanco);
 		$bResultado = $oGrupoUsuarioBD->presente($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir GrupoUsuario
	* @param object $oGrupoUsuario Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function insereGrupoUsuario($oGrupoUsuario,$voTransacao,$sBanco) {
		$oGrupoUsuarioBD = $this->inicializaGrupoUsuarioBD($sBanco);
 		$nId = $oGrupoUsuarioBD->insere($oGrupoUsuario);
        // INSERE TRANSAÇÃO
        if($nId && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $nId;
	}


	/** 
	* Método responsável por alterar GrupoUsuario
	* @param object $oGrupoUsuario Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de GrupoUsuario
	*/
	function alteraGrupoUsuario($oGrupoUsuario,$voTransacao,$sBanco) {
		$oGrupoUsuarioBD = $this->inicializaGrupoUsuarioBD($sBanco);
 		$bResultado = $oGrupoUsuarioBD->altera($oGrupoUsuario);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por excluir GrupoUsuario
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiGrupoUsuario($nId,$voTransacao,$sBanco) {
		$oGrupoUsuarioBD = $this->inicializaGrupoUsuarioBD($sBanco);
 		$bResultado = $oGrupoUsuarioBD->exclui($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro GrupoUsuario
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaGrupoUsuario($nId,$voTransacao,$sBanco) {
		$oGrupoUsuarioBD = $this->inicializaGrupoUsuarioBD($sBanco);
 		$bResultado = $oGrupoUsuarioBD->desativa($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}

	
	/***á
	* Método responsável por instanciar um objeto de Permissao
	* @access public
	* @return object $oPermissao Permissao
	*/	
	function inicializaPermissao($nIdTipoTransacao,$nIdGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo) {
		$oPermissao = new Permissao($nIdTipoTransacao,$nIdGrupoUsuario,$dDtCadastro,$bPublicado,$bAtivo);
		return $oPermissao;
	}


	/**
	* Método responsável por instanciar um objeto de PermissaoBD
	* @access public
	* @return object $oPermissaoBD PermissaoBD
	*/	
	function inicializaPermissaoBD($sBanco) {
		$oPermissaoBD = new PermissaoBD($sBanco);
		return $oPermissaoBD;
	}


	/** 
	* Método responsável por recuperar Permissao
	* @param $nIdTipoTransacao nIdTipoTransacao
	* @param $nIdGrupoUsuario nIdGrupoUsuario
	* @access public
	* @return object $oPermissao Permissao
	*/
	function recuperaPermissao($nIdTipoTransacao,$nIdGrupoUsuario,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
 		$oPermissao = $oPermissaoBD->recupera($nIdTipoTransacao,$nIdGrupoUsuario);
		return $oPermissao;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade Permissao
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de Permissao
	*/
	function recuperaTodosPermissao($sBanco,$vWhere=null,$vOrder=null) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oPermissaoBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de Permissao
	* @param $nIdTipoTransacao nIdTipoTransacao
	* @param $nIdGrupoUsuario nIdGrupoUsuario
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de Permissao
	*/
	function presentePermissao($nIdTipoTransacao,$nIdGrupoUsuario,$sBanco){
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
 		$bResultado = $oPermissaoBD->presente($nIdTipoTransacao,$nIdGrupoUsuario);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir Permissao
	* @param object $oPermissao Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function inserePermissao($oPermissao,$voTransacao,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
 		$nId = $oPermissaoBD->insere($oPermissao);
        // INSERE TRANSAÇÃO
        if($nId && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $nId;
	}


	/** 
	* Método responsável por alterar Permissao
	* @param object $oPermissao Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de Permissao
	*/
	function alteraPermissao($oPermissao,$voTransacao,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
 		$bResultado = $oPermissaoBD->altera($oPermissao);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por excluir Permissao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiPermissao($nIdTipoTransacao,$nIdGrupoUsuario,$voTransacao,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
 		$bResultado = $oPermissaoBD->exclui($nIdTipoTransacao,$nIdGrupoUsuario);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro Permissao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaPermissao($nIdTipoTransacao,$nIdGrupoUsuario,$voTransacao,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
 		$bResultado = $oPermissaoBD->desativa($nIdTipoTransacao,$nIdGrupoUsuario);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}

	
	/***á
	* Método responsável por instanciar um objeto de TipoTransacao
	* @access public
	* @return object $oTipoTransacao TipoTransacao
	*/	
	function inicializaTipoTransacao($nId,$nIdCategoriaTipoTransacao,$sTransacao,$dDtCadastro,$bPublicado,$bAtivo) {
		$oTipoTransacao = new TipoTransacao($nId,$nIdCategoriaTipoTransacao,$sTransacao,$dDtCadastro,$bPublicado,$bAtivo);
		return $oTipoTransacao;
	}


	/**
	* Método responsável por instanciar um objeto de TipoTransacaoBD
	* @access public
	* @return object $oTipoTransacaoBD TipoTransacaoBD
	*/	
	function inicializaTipoTransacaoBD($sBanco) {
		$oTipoTransacaoBD = new TipoTransacaoBD($sBanco);
		return $oTipoTransacaoBD;
	}


	/** 
	* Método responsável por recuperar TipoTransacao
	* @param $nId nId
	* @access public
	* @return object $oTipoTransacao TipoTransacao
	*/
	function recuperaTipoTransacao($nId,$sBanco) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
 		$oTipoTransacao = $oTipoTransacaoBD->recupera($nId);
		return $oTipoTransacao;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade TipoTransacao
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de TipoTransacao
	*/
	function recuperaTodosTipoTransacao($sBanco,$vWhere=null,$vOrder=null) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oTipoTransacaoBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de TipoTransacao
	* @param $nId nId
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de TipoTransacao
	*/
	function presenteTipoTransacao($nId,$sBanco){
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
 		$bResultado = $oTipoTransacaoBD->presente($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir TipoTransacao
	* @param object $oTipoTransacao Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function insereTipoTransacao($oTipoTransacao,$voTransacao,$sBanco) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
 		$nId = $oTipoTransacaoBD->insere($oTipoTransacao);
        // INSERE TRANSAÇÃO
        if($nId && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $nId;
	}


	/** 
	* Método responsável por alterar TipoTransacao
	* @param object $oTipoTransacao Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de TipoTransacao
	*/
	function alteraTipoTransacao($oTipoTransacao,$voTransacao,$sBanco) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
 		$bResultado = $oTipoTransacaoBD->altera($oTipoTransacao);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por excluir TipoTransacao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiTipoTransacao($nId,$voTransacao,$sBanco) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
 		$bResultado = $oTipoTransacaoBD->exclui($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro TipoTransacao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaTipoTransacao($nId,$voTransacao,$sBanco) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
 		$bResultado = $oTipoTransacaoBD->desativa($nId);
        // INSERE TRANSAÇÃO
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}

	
	/***á
	* Método responsável por instanciar um objeto de Transacao
	* @access public
	* @return object $oTransacao Transacao
	*/
    function inicializaTransacao($nId,$nIdTipoTransacao,$nIdUsuario,$sIdObjeto,$sCampo,$sValorAntigo,$sValorNovo,$sIp,$dDtCadastro,$bPublicado,$bAtivo) {
        $oTransacao = new Transacao($nId,$nIdTipoTransacao,$nIdUsuario,$sIdObjeto,$sCampo,$sValorAntigo,$sValorNovo,$sIp,$dDtCadastro,$bPublicado,$bAtivo);
        return $oTransacao;
    }


	/**
	* Método responsável por instanciar um objeto de TransacaoBD
	* @access public
	* @return object $oTransacaoBD TransacaoBD
	*/	
	function inicializaTransacaoBD($sBanco) {
		$oTransacaoBD = new TransacaoBD($sBanco);
		return $oTransacaoBD;
	}


	/** 
	* Método responsável por recuperar Transacao
	* @param $nId nId
	* @access public
	* @return object $oTransacao Transacao
	*/
	function recuperaTransacao($nId,$sBanco) {
		$oTransacaoBD = $this->inicializaTransacaoBD($sBanco);
 		$oTransacao = $oTransacaoBD->recupera($nId);
		return $oTransacao;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade Transacao
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de Transacao
	*/
	function recuperaTodosTransacao($sBanco,$vWhere=null,$vOrder=null) {
		$oTransacaoBD = $this->inicializaTransacaoBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oTransacaoBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de Transacao
	* @param $nId nId
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de Transacao
	*/
	function presenteTransacao($nId,$sBanco){
		$oTransacaoBD = $this->inicializaTransacaoBD($sBanco);
 		$bResultado = $oTransacaoBD->presente($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir Transacao
	* @param object $oTransacao Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function insereTransacao($oTransacao,$sBanco) {
		$oTransacaoBD = $this->inicializaTransacaoBD($sBanco);
 		$nId = $oTransacaoBD->insere($oTransacao);
		return $nId;
	}


	/** 
	* Método responsável por alterar Transacao
	* @param object $oTransacao Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de Transacao
	*/
	function alteraTransacao($oTransacao,$sBanco) {
		$oTransacaoBD = $this->inicializaTransacaoBD($sBanco);
 		$bResultado = $oTransacaoBD->altera($oTransacao);
		return $bResultado;
	}


	/** 
	* Método responsável por excluir Transacao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiTransacao($nId,$sBanco) {
		$oTransacaoBD = $this->inicializaTransacaoBD($sBanco);
 		$bResultado = $oTransacaoBD->exclui($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro Transacao
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaTransacao($nId,$sBanco) {
		$oTransacaoBD = $this->inicializaTransacaoBD($sBanco);
 		$bResultado = $oTransacaoBD->desativa($nId);
		return $bResultado;
	}
	
	/***á
	* Método responsável por instanciar um objeto de TransacaoAcesso
	* @access public
	* @return object $oTransacaoAcesso TransacaoAcesso
	*/
    function inicializaTransacaoAcesso($nId,$nIdTipoTransacao,$nIdUsuario,$sIdObjeto,$sObjeto,$sCampo,$sValorAntigo,$sValorNovo,$sIp,$dDtCadastro,$bPublicado,$bAtivo) {
        $oTransacaoAcesso = new TransacaoAcesso($nId,$nIdTipoTransacao,$nIdUsuario,$sIdObjeto,$sObjeto,$sCampo,$sValorAntigo,$sValorNovo,$sIp,$dDtCadastro,$bPublicado,$bAtivo);
        return $oTransacaoAcesso;
    }


	/**
	* Método responsável por instanciar um objeto de TransacaoAcessoBD
	* @access public
	* @return object $oTransacaoAcessoBD TransacaoAcessoBD
	*/	
	function inicializaTransacaoAcessoBD($sBanco) {
		$oTransacaoAcessoBD = new TransacaoAcessoBD($sBanco);
		return $oTransacaoAcessoBD;
	}


	/** 
	* Método responsável por recuperar TransacaoAcesso
	* @param $nId nId
	* @access public
	* @return object $oTransacaoAcesso TransacaoAcesso
	*/
	function recuperaTransacaoAcesso($nId,$sBanco) {
		$oTransacaoAcessoBD = $this->inicializaTransacaoAcessoBD($sBanco);
 		$oTransacaoAcesso = $oTransacaoAcessoBD->recupera($nId);
		return $oTransacaoAcesso;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade TransacaoAcesso
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de TransacaoAcesso
	*/
	function recuperaTodosTransacaoAcesso($sBanco,$vWhere=null,$vOrder=null) {
		$oTransacaoAcessoBD = $this->inicializaTransacaoAcessoBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oTransacaoAcessoBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de TransacaoAcesso
	* @param $nId nId
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de TransacaoAcesso
	*/
	function presenteTransacaoAcesso($nId,$sBanco){
		$oTransacaoAcessoBD = $this->inicializaTransacaoAcessoBD($sBanco);
 		$bResultado = $oTransacaoAcessoBD->presente($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir TransacaoAcesso
	* @param object $oTransacaoAcesso Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function insereTransacaoAcesso($oTransacaoAcesso,$sBanco) {
		$oTransacaoAcessoBD = $this->inicializaTransacaoAcessoBD($sBanco);
 		$nId = $oTransacaoAcessoBD->insere($oTransacaoAcesso);
		return $nId;
	}


	/** 
	* Método responsável por alterar TransacaoAcesso
	* @param object $oTransacaoAcesso Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de TransacaoAcesso
	*/
	function alteraTransacaoAcesso($oTransacaoAcesso,$sBanco) {
		$oTransacaoAcessoBD = $this->inicializaTransacaoAcessoBD($sBanco);
 		$bResultado = $oTransacaoAcessoBD->altera($oTransacaoAcesso);
		return $bResultado;
	}


	/** 
	* Método responsável por excluir TransacaoAcesso
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiTransacaoAcesso($nId,$sBanco) {
		$oTransacaoAcessoBD = $this->inicializaTransacaoAcessoBD($sBanco);
 		$bResultado = $oTransacaoAcessoBD->exclui($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro TransacaoAcesso
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaTransacaoAcesso($nId,$sBanco) {
		$oTransacaoAcessoBD = $this->inicializaTransacaoAcessoBD($sBanco);
 		$bResultado = $oTransacaoAcessoBD->desativa($nId);
		return $bResultado;
	}

	
	/***á
	* Método responsável por instanciar um objeto de Usuario
	* @access public
	* @return object $oUsuario Usuario
	*/	
	function inicializaUsuario($nId,$nIdGrupoUsuario,$sNmUsuario,$sLogin,$sSenha,$sEmail,$bLogado,$dDtCadastro,$bPublicado,$bAtivo) {
		$oUsuario = new Usuario($nId,$nIdGrupoUsuario,$sNmUsuario,$sLogin,$sSenha,$sEmail,$bLogado,$dDtCadastro,$bPublicado,$bAtivo);
		return $oUsuario;
	}


	/**
	* Método responsável por instanciar um objeto de UsuarioBD
	* @access public
	* @return object $oUsuarioBD UsuarioBD
	*/	
	function inicializaUsuarioBD($sBanco) {
		$oUsuarioBD = new UsuarioBD($sBanco);
		return $oUsuarioBD;
	}


	/** 
	* Método responsável por recuperar Usuario
	* @param $nId nId
	* @access public
	* @return object $oUsuario Usuario
	*/
	function recuperaUsuario($nId,$sBanco) {
		$oUsuarioBD = $this->inicializaUsuarioBD($sBanco);
 		$oUsuario = $oUsuarioBD->recupera($nId);
		return $oUsuario;
	}


	/** 
	* Método responsável por recuperar todos os representantes da entidade Usuario
	* @access public
	* @return array $aObjeto Vetor de objetos com os representantes de Usuario
	*/
	function recuperaTodosUsuario($sBanco,$vWhere=null,$vOrder=null) {
		$oUsuarioBD = $this->inicializaUsuarioBD($sBanco);
		$voObjeto = array();
		$voObjeto = $oUsuarioBD->recuperaTodos($vWhere,$vOrder);
		return $voObjeto;
	}


	/** 
	* Método responsável por verificar presença de Usuario
	* @param $nId nId
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de Usuario
	*/
	function presenteUsuario($nId,$sBanco){
		$oUsuarioBD = $this->inicializaUsuarioBD($sBanco);
 		$bResultado = $oUsuarioBD->presente($nId);
		return $bResultado;
	}


	/** 
	* Método responsável por inserir Usuario
	* @param object $oUsuario Objeto a ser inserido.
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação;
	*/
	function insereUsuario($oUsuario,$voTransacao,$sBanco) {
		$oUsuarioBD = $this->inicializaUsuarioBD($sBanco);
 		$nId = $oUsuarioBD->insere($oUsuario);
		// INSERE TRANSAÇÃO 
		if($nId && is_array($voTransacao) && count($voTransacao) > 0) {
			$oFachadaSeguranca = new FachadaSegurancaBD();
			foreach ($voTransacao as $oTransacao){
			    if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
		}
		
		return $nId;
	}


	/** 
	* Método responsável por alterar Usuario
	* @param object $oUsuario Objeto a ser alterado.
	* @access public
	* @return boolean $bResultado Indicando presença ou ausência de Usuario
	*/
	function alteraUsuario($oUsuario,$voTransacao,$sBanco) {
		$oUsuarioBD = $this->inicializaUsuarioBD($sBanco);
 		$bResultado = $oUsuarioBD->altera($oUsuario);
		// INSERE TRANSAÇÃO 
		if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
			$oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
		}
		
		return $bResultado;
	}


	/** 
	* Método responsável por excluir Usuario
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function excluiUsuario($nId,$voTransacao,$sBanco) {
		$oUsuarioBD = $this->inicializaUsuarioBD($sBanco);
 		$bResultado = $oUsuarioBD->exclui($nId);
		// INSERE TRANSAÇÃO 
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}


	/** 
	* Método responsável por desativar um resgistro Usuario
	* @access public
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaUsuario($nId,$voTransacao,$sBanco) {
		$oUsuarioBD = $this->inicializaUsuarioBD($sBanco);
 		$bResultado = $oUsuarioBD->desativa($nId);
		// INSERE TRANSAÇÃO 
        if($bResultado && is_array($voTransacao) && count($voTransacao) > 0) {
            $oFachadaSeguranca = new FachadaSegurancaBD();
            foreach ($voTransacao as $oTransacao){
                if(isset($oTransacao) && is_object($oTransacao)){
                    if(!$oFachadaSeguranca->insereTransacao($oTransacao,$sBanco))
                        return false;
                }
            }
        }
		
		return $bResultado;
	}

}
?>