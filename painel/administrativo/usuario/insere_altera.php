<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

$nIdUsuario = (isset($_GET['nIdUsuario']) && $_GET['nIdUsuario'] != "" && $_GET['nIdUsuario'] != 0) ? $_GET['nIdUsuario'] : ((isset($_POST['fIdUsuario'][0]) && $_POST['fIdUsuario'][0] != "" && $_POST['fIdUsuario'][0] != 0) ? $_POST['fIdUsuario'][0] : "");
$sOP = ($nIdUsuario != "") ? "Alterar" : "Cadastrar"; 
$oFachadaSeguranca = new FachadaSegurancaBD();

$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Usuario",$sOP,BANCO);
if(!$bPermissao) {
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdUsuario,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."painel/index.php?bErro=1");
    exit();
}else{
    $sObjetoAcesso = ACESSO_PERMITIDO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdUsuario,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
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
	$tpl->SUBMENUUSUARIOSATIVO = "active";
	$tpl->PAGINAATUAL = "Cadastro de Usuários";

	//RODAPE
	require_once(PATH."painel/includes/rodape.php");
}

$voGrupoUsuario = $oFachadaSeguranca->recuperaTodosGrupoUsuario(BANCO);

$tpl->ACAO = $sOP;
if(isset($nIdUsuario) && $nIdUsuario != "" && $nIdUsuario != 0){
	$oUsuarioDetalhe = $oFachadaSeguranca->recuperaUsuario($nIdUsuario,BANCO);
	if(isset($oUsuarioDetalhe) && is_object($oUsuarioDetalhe)){
		$tpl->LOGADO = $oUsuarioDetalhe->getLogado();
		$tpl->DATACADASTRO = $oUsuarioDetalhe->getDtCadastro();
		$tpl->IDUSUARIO = $oUsuarioDetalhe->getId();
		$tpl->NOME = $oUsuarioDetalhe->getNmUsuario();
		$tpl->EMAIL = $oUsuarioDetalhe->getEmail();
		
		if(isset($voGrupoUsuario) && count($voGrupoUsuario) > 0){
			foreach($voGrupoUsuario as $oGrupoUsuario){
				if(isset($oGrupoUsuario) && is_object($oGrupoUsuario)){
					$tpl->IDGRUPOUSUARIO = $oGrupoUsuario->getId();
					$tpl->GRUPOUSUARIO = $oGrupoUsuario->getNmGrupoUsuario();
					$tpl->SELECTEDGRUPOUSUARIO = "";
					if($oGrupoUsuario->getId() == $oUsuarioDetalhe->getIdGrupoUsuario())
						$tpl->SELECTEDGRUPOUSUARIO = "selected";
					$tpl->block("BLOCO_GRUPO_USUARIOS");
				}
			}
		}
		
		$tpl->LOGIN = $oUsuarioDetalhe->getLogin();
		$tpl->CHECKEDPUBLICADO = ($oUsuarioDetalhe->getPublicado() == 1) ? "checked" : "";
		$tpl->CHECKEDATIVO = ($oUsuarioDetalhe->getAtivo() == 1) ? "checked" : "";
	}//if(isset($oUsuarioDetalhe) && is_object($oUsuarioDetalhe)){
}else{
	$tpl->VALIDASENHA = "validate[required]";
	$tpl->DATACADASTRO = date("Y-m-d H:i:s");
	if(isset($voGrupoUsuario) && count($voGrupoUsuario) > 0){
		foreach($voGrupoUsuario as $oGrupoUsuario){
			if(isset($oGrupoUsuario) && is_object($oGrupoUsuario)){
				$tpl->IDGRUPOUSUARIO = $oGrupoUsuario->getId();
				$tpl->GRUPOUSUARIO = $oGrupoUsuario->getNmGrupoUsuario();
				$tpl->SELECTEDGRUPOUSUARIO = "";
				$tpl->block("BLOCO_GRUPO_USUARIOS");
			}
		}
	}
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