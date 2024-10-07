<?php
//á
include_once("FachadaSegurancaBDParent.class.php");

class FachadaSegurancaBD extends FachadaSegurancaBDParent{

	function __construct(){
	}
	
	function recuperaTipoTransacaoPorDescricaoCategoria($sDescricao,$sTransacao,$sBanco) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
 		$oCategoriaTipoTransacaoBD = $this->inicializaCategoriaTipoTransacaoBD($sBanco);
		$oFachadaSeguranca = new FachadaSegurancaBD();
		$vWhereCategoriaTipoTransacao = array("descricao = '".$sDescricao."'");
		$voCategoriaTipoTransacao = $oFachadaSeguranca->recuperaTodosCategoriaTipoTransacao($sBanco,$vWhereCategoriaTipoTransacao);
		if(count($voCategoriaTipoTransacao) == 1){
			$oCategoriaTipoTransacao = $voCategoriaTipoTransacao[0];
			if(is_object($oCategoriaTipoTransacao)){
				$vWhereTipoTransacao = array("id_categoria_tipo_transacao = ".$oCategoriaTipoTransacao->getId(),"transacao = '".$sTransacao."'");
				$sOrderTipoTransacao = "";
				$voTipoTransacao = $oTipoTransacaoBD->recuperaTodos($vWhereTipoTransacao,$sOrderTipoTransacao);
				if(count($voTipoTransacao) == 1){
					$oTipoTransacao = $voTipoTransacao[0];
					return $oTipoTransacao->getId();
				}//if(count($voTipoTransacao) == 1){
			}//if(is_object($oCategoriaTipoTransacao)){
		}//if(count($voCategoriaTipoTransacao) == 1){
		return false;
	}
	
	/** 
	* Método responsável por excluir Permissao por Grupo Usuário
	* @access private
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaPermissaoPorGrupoUsuario($nIdGrupoUsuario,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
		$bResultado = $oPermissaoBD->desativaPorGrupoUsuario($nIdGrupoUsuario);
		return $bResultado;
	}
	
	/** 
	* Método responsável por excluir Permissao por TipoTransacao
	* @access private
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaPermissaoPorTipoTransacao($nIdTipoTransacao,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
		$bResultado = $oPermissaoBD->desativaPorTipoTransacao($nIdTipoTransacao);
		return $bResultado;
	}
	
	/** 
	* Método responsável por verificar a Permissao para um determinado TipoTransação
	* @param $nIdTipoTransacao nIdTipoTransacao
	* @param $vPermissao vPermissao	
	* @access private
	* @return object $oPermissao Permissao
	*/
	function verificaPermissao($nIdTipoTransacao,$vPermissao,$sBanco) {
		$oPermissaoBD = $this->inicializaPermissaoBD($sBanco);
		$bResultado = false;
		if(count($vPermissao)){
			foreach($vPermissao as $oPermissao){
				if($oPermissao->getIdTipoTransacao() == $nIdTipoTransacao)
					$bResultado = true;
			}
			return $bResultado;
		}
		return false;
	}
	
	/** 
	* Método responsável por excluir TipoTransacao por IdCategoriaTipoTransacao
	* @access private
	* @return boolean $bResultado Indicando sucesso ou não da operação
	*/
	function desativaTipoTransacaoPorCategoria($nIdCategoria,$sBanco) {
		$oTipoTransacaoBD = $this->inicializaTipoTransacaoBD($sBanco);
		$bResultado = $oTipoTransacaoBD->desativaPorCategoria($nIdCategoria);
		return $bResultado;
	}
	
}
?>