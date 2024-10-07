<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

// VERIFICA AS PERMISSÕES
$sOP = "VerErrosMySQL";
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Transacao",$sOP,BANCO);
$bPermissaoVisualizar = $_SESSION['oLoginAdm']->verificaPermissao("Transacao",$sOP,BANCO);
$oFachadaSeguranca = new FachadaSegurancaBD();
if(!$bPermissaoVisualizar) {
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Transacao",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."painel/index.php?bErro=1");
    exit();
}else{
    $sObjetoAcesso = ACESSO_PERMITIDO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
}

$tpl = new Template('tpl/log_erro_mysql.html');

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
	$tpl->SUBMENUERROSMYSQLATIVO = "active";
	$tpl->PAGINAATUAL = "Log de Erros de MySQL";

	//RODAPE
	require_once(PATH."painel/includes/rodape.php");
}

$sUsuario = "SISTEMA";
$dDataHora = "";

$vWhereLogErroMysql = array("");
$sOrderLogErroMysql = "dt_cadastro desc, id asc";
$voLogErroMysql = $oFachadaSeguranca->recuperaTodosErrosMysql(BANCO,$vWhereLogErroMysql,$sOrderLogErroMysql);
if(isset($voLogErroMysql) && count($voLogErroMysql) > 0){
	foreach($voLogErroMysql as $oLogErroMysql){
		if(isset($oLogErroMysql) && is_object($oLogErroMysql)){
			if($oLogErroMysql->getIdUsuario() != "" && $oLogErroMysql->getIdUsuario() != "0"){
				$oUsuario = $oFachadaSeguranca->recuperaUsuario($oLogErroMysql->getIdUsuario(),BANCO);
				if(isset($oUsuario) && is_object($oUsuario))
					$sUsuario = $oUsuario->getNmUsuario();
			}
			
			$oDataHora = new Data(substr($oLogErroMysql->getDtCadastro(),0,10),"Y-m-d");
			$oDataHora->setFormato("d/m/Y");
			$dDataHora = $oDataHora->getData()." às ".substr($oLogErroMysql->getDtCadastro(),10);
			
			$tpl->IDLOGERROMYSQL = $oLogErroMysql->getId();
			$tpl->ERROMYSQL = $oLogErroMysql->getErro();
			$tpl->USUARIO = $sUsuario;
			$tpl->IP = $oLogErroMysql->getIp();
			$tpl->DATAHORA_ERROMYSQL = $dDataHora;
			$tpl->block("BLOCO_LOG_ERRO_MYSQL");
		}
	}
}

$tpl->CAMINHO = CAMINHO;

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