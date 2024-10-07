<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

$nIdGrupoUsuario = (isset($_GET['nIdGrupoUsuario']) && $_GET['nIdGrupoUsuario'] != "" && $_GET['nIdGrupoUsuario'] != 0) ? $_GET['nIdGrupoUsuario'] : ((isset($_POST['fIdGrupoUsuario'][0]) && $_POST['fIdGrupoUsuario'][0] != "" && $_POST['fIdGrupoUsuario'][0] != 0) ? $_POST['fIdGrupoUsuario'][0] : "");
$sOP = ($nIdGrupoUsuario) ? "Alterar" : "Cadastrar";

$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Grupos",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Grupos",$sOP,BANCO);
$oFachadaSeguranca = new FachadaSegurancaBD();
if(!$bPermissao) {
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Grupos",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdGrupoUsuario,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."sistema/index.php?bErro=1");
    exit();
}else{
    $sObjetoAcesso = ACESSO_PERMITIDO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdGrupoUsuario,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
}//if(!$bPermissao) {

$tpl = new Template('tpl/insere_altera.html');

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
	$tpl->SUBMENUGRUPOUSUARIOSATIVO = "active";
	$tpl->PAGINAATUAL = "Cadastro de Usuários";

	//RODAPE
	require_once(PATH."painel/includes/rodape.php");
}

$tpl->ACAO = $sOP;
$tpl->DATACADASTRO = date("Y-m-d H:i:s");
if(isset($nIdGrupoUsuario) && $nIdGrupoUsuario != "" && $nIdGrupoUsuario != 0){
	$oGrupoUsuario = $oFachadaSeguranca->recuperaGrupoUsuario($nIdGrupoUsuario,BANCO);
	if(isset($oGrupoUsuario) && is_object($oGrupoUsuario)){
		$tpl->DATACADASTRO = $oGrupoUsuario->getDtCadastro();
		$tpl->IDGRUPOUSUARIO = $oGrupoUsuario->getId();
		$tpl->GRUPO = $oGrupoUsuario->getNmGrupoUsuario();
		$tpl->CHECKEDPUBLICADO = ($oGrupoUsuario->getPublicado() == 1) ? "checked" : "";
		$tpl->CHECKEDATIVO = ($oGrupoUsuario->getAtivo() == 1) ? "checked" : "";
	}//if(isset($oGrupoUsuario) && is_object($oGrupoUsuario)){
}

$tpl->CAMINHO = CAMINHO;

if(isset($_SESSION['oGrupoUsuario']))
	unset($_SESSION['oGrupoUsuario']);
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