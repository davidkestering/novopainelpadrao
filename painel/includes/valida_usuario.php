<?php
require_once(PATH."/classes/Login.class.php");

session_start();
//CONTROLE DE SESSAO
//PARA IMPEDIR MULTIPLOS ACESSOS, DESTROI A SESSAO DO USUARIO LOGADO CASO FECHE O NAVEGADOR OU MUDE DE PAGINA
session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"], 0);

if(!isset($_SESSION['oLoginAdm'])){
	$_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
	header("location: ".SITE."sistema/index.php?bErro=1");
	exit();
}else {
	//$dUltimoAcesso = $_SESSION["dUltimoAcesso"];
	$dUltimoAcesso = date("Y-m-d H:i:s");
	$dAgora = date("Y-m-d H:i:s");
	$nTempoTranscorrido = (strtotime($dAgora)-strtotime($dUltimoAcesso));
	
	if($nTempoTranscorrido >= 600) {
		//RESETAMOS O LOGIN DO USUARIO CASO TENHA PASSADO MAIS DE 10 MINUTOS DE INATIVIDADE
		$oFachadaSeguranca = new FachadaSegurancaBD();
		$nIdTipoTransacao = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Acesso","Logout",BANCO);
		if(isset($_SESSION['oLoginAdm']) && $_SESSION['oLoginAdm']->getIdUsuario() != "" && $_SESSION['oLoginAdm']->getIdUsuario() != 0){
			$oUsuarioLogoff = $oFachadaSeguranca->recuperaUsuario($_SESSION['oLoginAdm']->getIdUsuario(),BANCO);
			if(is_object($oUsuarioLogoff)){
				$oUsuarioLogoff->setLogado(0);
				$sObjetoLogado = "Usuário ".$_SESSION['oLoginAdm']->getUsuario()->getNmUsuario()." passou mais de 10 minutos em inatividade no sistema, liberando nova possibilidade de acesso para o login: ".$oUsuarioLogoff->getLogin();
				$oTransacaoLogado = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacao,$oUsuarioLogoff->getId(),$sObjetoLogado,IP_USUARIO,DATAHORA,1,1);
				$oFachadaSeguranca->alteraUsuario($oUsuarioLogoff,$oTransacaoLogado,BANCO);
				
				//TRANSACAO
				$sObjetoLogoff = "Logout automático efetuado por prazo de mais de 10 minutos de inatividade ocorrido. Usuario: ".$_SESSION['oLoginAdm']->getUsuario()->getNmUsuario().", Login do usuário: ".$_SESSION['oLoginAdm']->oUsuario->getLogin();
				$oTransacaoOff = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacao,$_SESSION['oLoginAdm']->getIdUsuario(),$sObjetoLogoff,IP_USUARIO,DATAHORA,1,1);
				$oFachadaSeguranca->insereTransacao($oTransacaoOff,BANCO);
			}else{
				//TRANSACAO
				$sObjetoLogoff = "VERIFICAR ERRO INATIVIDADE: Usuário ".$_SESSION['oLoginAdm']->getUsuario()->getNmUsuario()." não encontrado no sistema para logout automático!";
				$oTransacaoOff = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacao,$_SESSION['oLoginAdm']->getIdUsuario(),$sObjetoLogoff,IP_USUARIO,DATAHORA,1,1);
				$oFachadaSeguranca->insereTransacaoAcesso($oTransacaoOff,BANCO);
			}//if(is_object($oUsuarioLogoff)){
		}else{
			//TRANSACAO
			$sObjetoLogoff = "VERIFICAR ERRO SESSAO INVALIDA: Tentativa de logout automático, sem nenhuma sessão da área administrativa estar ativa!";
			$oTransacaoOff = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacao,ID_USUARIO_SISTEMA,$sObjetoLogoff,IP_USUARIO,DATAHORA,1,1);
			$oFachadaSeguranca->insereTransacao($oTransacaoOff,BANCO);
		}//if(isset($_SESSION['oLoginAdm']) && $_SESSION['oLoginAdm']->getIdUsuario() != "" && $_SESSION['oLoginAdm']->getIdUsuario() != 0){
		
		//session_destroy();
		$_SESSION['oLoginAdm'] = "";
		unset($_SESSION['oLoginAdm']);
		$_SESSION['sMsgPermissao'] = "Deslogado por ficar mais de 10 minutos ocioso!";
		header("location: ".SITE."sistema/index.php?bErro=0");
		exit();
	//senão, atualizo a data da sessão
	}else
		$_SESSION["dUltimoAcesso"] = $dAgora;
} 

$_SESSION['sMsgPermissao'] = (isset($_SESSION['sMsgPermissao'])) ? $_SESSION['sMsgPermissao'] : "";
?>