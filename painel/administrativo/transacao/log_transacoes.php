<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

// VERIFICA AS PERMISSÕES
$sOP = "VerLog";
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

$tpl = new Template('tpl/log_transacoes.html');

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
	$tpl->SUBMENULOGATIVO = "active";
	$tpl->PAGINAATUAL = "Log de Transações";

	//RODAPE
	require_once(PATH."painel/includes/rodape.php");
}

$sUsuario = "SISTEMA";
$sArea = "";
$sAcao = "";
$dDataHora = "";

$vWhereTransacao = array("publicado = 1","ativo = 1");
$sOrderTransacao = "dt_cadastro desc, id asc";
$voTransacao = $oFachadaSeguranca->recuperaTodosTransacao(BANCO,$vWhereTransacao,$sOrderTransacao);
if(isset($voTransacao) && count($voTransacao) > 0){
	foreach($voTransacao as $oTransacao){
		if(isset($oTransacao) && is_object($oTransacao)){
			if($oTransacao->getIdUsuario() != "" && $oTransacao->getIdUsuario() != "0"){
				$oUsuario = $oFachadaSeguranca->recuperaUsuario($oTransacao->getIdUsuario(),BANCO);
				if(isset($oUsuario) && is_object($oUsuario))
					$sUsuario = $oUsuario->getNmUsuario();
			}
				
			$oAcao = $oFachadaSeguranca->recuperaTipoTransacao($oTransacao->getIdTipoTransacao(),BANCO);
			if(isset($oAcao) && is_object($oAcao)){
				$sAcao = $oAcao->getTransacao();
				$oArea = $oFachadaSeguranca->recuperaCategoriaTipoTransacao($oAcao->getIdCategoriaTipoTransacao(),BANCO);
				if(isset($oArea) && is_object($oArea))
					$sArea = $oArea->getDescricao();
			}
			
			$oDataHora = new Data(substr($oTransacao->getDtCadastro(),0,10),"Y-m-d");
			$oDataHora->setFormato("d/m/Y");
			$dDataHora = $oDataHora->getData()." às ".substr($oTransacao->getDtCadastro(),10);
			
			$tpl->IDLOG = $oTransacao->getId();
			$tpl->USUARIO = $sUsuario;
			$tpl->AREA = $sArea;
			$tpl->ACAO = $sAcao;
			$tpl->IDOBJETO = $oTransacao->getIdObjeto();
			$tpl->CAMPO = $oTransacao->getCampo();
			$tpl->VALOR_ANTIGO = $oTransacao->getValorAntigo();
			$tpl->VALOR_NOVO = $oTransacao->getValorNovo();
			$tpl->IP = $oTransacao->getIp();
			$tpl->DATAHORA = $dDataHora;
			$tpl->block("BLOCO_LOG_TRANSACOES");
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