<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

// VERIFICA AS PERMISSÕES
$sOP = "Visualizar";
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Grupos",$sOP,BANCO);
$bPermissaoVisualizar = $_SESSION['oLoginAdm']->verificaPermissao("Grupos",$sOP,BANCO);
$oFachadaSeguranca = new FachadaSegurancaBD();
if(!$bPermissaoVisualizar) {
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Grupos",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
	header("location: ".SITE."sistema/index.php?bErro=1");
	exit();
}else{
    $sObjetoAcesso = ACESSO_PERMITIDO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
}

$vWhereGrupoUsuario = array("ativo = 1");
$voGrupoUsuario = $oFachadaSeguranca->recuperaTodosGrupoUsuario(BANCO,$vWhereGrupoUsuario);

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
	$tpl->SUBMENUGRUPOUSUARIOSATIVO = "active";
	$tpl->PAGINAATUAL = "Gerência de Grupos de Usuários";

	//RODAPE
	require_once(PATH."painel/includes/rodape.php");
}

if(isset($voGrupoUsuario) && count($voGrupoUsuario) > 0){
	foreach($voGrupoUsuario as $oGrupoUsuario){
		if(isset($oGrupoUsuario) && is_object($oGrupoUsuario)){
			$oDataCriacao = new Data(substr($oGrupoUsuario->getDtCadastro(),0,10),"Y-m-d");
			$oDataCriacao->setFormato("d/m/Y");
			$dDataCriacao = $oDataCriacao->getData()." às ".substr($oGrupoUsuario->getDtCadastro(),10);
			
			$tpl->IDGRUPOUSUARIO = $oGrupoUsuario->getId();
			$tpl->GRUPO = $oGrupoUsuario->getNmGrupoUsuario();
			$tpl->DATA_CRIACAO = $dDataCriacao;
			$tpl->PUBLICADO = ($oGrupoUsuario->getPublicado() == 1) ? "<img id='".$oGrupoUsuario->getId()."' class='publicar' src='{CAMINHO}images/publicar.gif'>" : "<img id='".$oGrupoUsuario->getId()."' class='despublicar' src='{CAMINHO}images/despublicar.gif'>";
			$tpl->ATIVO = ($oGrupoUsuario->getAtivo() == 1) ? "<img id='".$oGrupoUsuario->getId()."' class='ativar' src='{CAMINHO}images/publicar.gif'>" : "<img id='".$oGrupoUsuario->getId()."' class='desativar' src='{CAMINHO}images/despublicar.gif'>";
			
			$tpl->block("BLOCO_GRUPO_USUARIOS");
			
		}//if(isset($oUsuario) && is_object($oUsuario)){
	}//foreach($voUsuario as $oUsuario){
}//if(isset($voUsuario) && count($voUsuario) > 0){
	
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