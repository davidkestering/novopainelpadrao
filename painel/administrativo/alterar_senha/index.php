<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

$nIdUsuario = (isset($_SESSION['oLoginAdm']) && $_SESSION['oLoginAdm']->getIdUsuario() != "") ? $_SESSION['oLoginAdm']->getIdUsuario() : "";
$sOP = ($nIdUsuario != "") ? "AlterarSenha" : "";
$oFachadaSeguranca = new FachadaSegurancaBD();

$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Usuario",$sOP,BANCO);

if(!$bPermissao) {
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),$_SESSION['oLoginAdm']->getIdUsuario(),$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."painel/index.php?bErro=1");
    exit();
}else{
    $sObjetoAcesso = ACESSO_PERMITIDO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$_SESSION['oLoginAdm']->getIdUsuario(),$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
}//if(!$bPermissao) {


if(isset($nIdUsuario) && $nIdUsuario != "" && $nIdUsuario != 0) {
	$oUsuarioAcesso = $oFachadaSeguranca->recuperaUsuario($nIdUsuario,BANCO);
	if(is_object($oUsuarioAcesso)){
		$sNmUsuarioAcesso = $oUsuarioAcesso->getNmUsuario();
	}//if(is_object($oUsuarioAcesso)){
}//if(isset($nIdUsuario) && $nIdUsuario != "" && $nIdUsuario != 0) {


$tpl = new Template('tpl/index.html');

$tpl->addFile('HEAD','../../includes/head.html');
$tpl->addFile('TOPO_PAINEL','../../includes/topo_painel.html');
$tpl->addFile('MENU_LATERAL','../../includes/menu_lateral.html');
$tpl->addFile('SCRIPTJS','../../includes/scriptsjs.html');
$tpl->addFile('RODAPE','../../includes/rodape.html');
$tpl->USUARIOLOGADO = $_SESSION['oLoginAdm']->getUsuario()->getNmUsuario();

if(is_object($_SESSION['oLoginAdm']->oUsuario)){
    $tpl->MENSAGEM = "";
    $tpl->TIPOALERTAMENSAGEM = "";
    $tpl->TIPOALERTALOGO = "";
    if(isset($_SESSION['sMsgPermissao']) && $_SESSION['sMsgPermissao'] != ""){
        $tpl->TIPOALERTAMENSAGEM = "danger"; //danger info warning success
        $tpl->TIPOALERTALOGO = "fa-ban";
        $tpl->MENSAGEM = $_SESSION['sMsgPermissao'];
        $tpl->block("BLOCO_MENSAGEM");
    }

    if(isset($_SESSION['sMsg']) && $_SESSION['sMsg'] != ""){
        $tpl->TIPOALERTAMENSAGEM = "success";
        $tpl->TIPOALERTALOGO = "fa-check";
        if(isset($_GET['bErro']) && $_GET['bErro'] == 1){
            $tpl->TIPOALERTAMENSAGEM = "danger";
            $tpl->TIPOALERTALOGO = "fa-ban";
        }
        $tpl->MENSAGEM = $_SESSION['sMsg'];
        $tpl->block("BLOCO_MENSAGEM");
    }
	
	//MENU
	require_once(PATH."painel/includes/menu_lateral.php");
	$tpl->MENUADMATIVO = "active";
	$tpl->SUBMENUALTERASENHAATIVO = "active";
	$tpl->PAGINAATUAL = "Alterar Senha";

	//RODAPE
	require_once(PATH."painel/includes/rodape.php");
}

$voGrupoUsuario = $oFachadaSeguranca->recuperaTodosGrupoUsuario(BANCO);

$tpl->ACAO = $sOP;
if(isset($nIdUsuario) && $nIdUsuario != "" && $nIdUsuario != 0){
	$oUsuarioDetalhe = $oFachadaSeguranca->recuperaUsuario($nIdUsuario,BANCO);
	if(isset($oUsuarioDetalhe) && is_object($oUsuarioDetalhe)){
		$tpl->IDUSUARIO = $oUsuarioDetalhe->getId();
		$tpl->NOME = $oUsuarioDetalhe->getNmUsuario();
		$tpl->EMAIL = $oUsuarioDetalhe->getEmail();
		$tpl->GRUPOUSUARIO = "";
		$oGrupoUsuario = $oFachadaSeguranca->recuperaGrupoUsuario($oUsuarioDetalhe->getIdGrupoUsuario(),BANCO);
		if(isset($oGrupoUsuario) && is_object($oGrupoUsuario))
			$tpl->GRUPOUSUARIO = $oGrupoUsuario->getNmGrupoUsuario();
		$tpl->LOGIN = $oUsuarioDetalhe->getLogin();
	}//if(isset($oUsuarioDetalhe) && is_object($oUsuarioDetalhe)){
}else{
	$_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
	header("location: ".SITE."painel/index.php?bErro=1");
	exit();
}

$tpl->CAMINHO = CAMINHO;

if(isset($_SESSION['oUsuario']))
	unset($_SESSION['oUsuario']);
unset($_POST);
if(isset($_SESSION['sMsg'])){
	$_SESSION['sMsg'] = "";
	unset($_SESSION['sMsg']);
}
if(isset($_SESSION['sMsgPermissao'])){
	$_SESSION['sMsgPermissao'] = "";
	unset($_SESSION['sMsgPermissao']);
}

$tpl->show();
?>