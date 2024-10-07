<?php
require_once("../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

$tpl = new Template('tpl/index.html');

$tpl->addFile('HEAD','../includes/head.html');
$tpl->addFile('TOPO_PAINEL','../includes/topo_painel.html');
$tpl->addFile('MENU_LATERAL','../includes/menu_lateral.html');
$tpl->addFile('SCRIPTJS','../includes/scriptsjs.html');
$tpl->addFile('RODAPE','../includes/rodape.html');
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
    $tpl->PAGINAATUAL = "Gerência Administrativa";

    //RODAPE
    require_once(PATH."painel/includes/rodape.php");
    
    // VERIFICA AS PERMISSÕES
    $bPermissaoAlterarDados = $_SESSION['oLoginAdm']->verificaPermissao("Permissao","Alterar",BANCO);
    $bPermissaoVisualizarUsuario = $_SESSION['oLoginAdm']->verificaPermissao("Usuario","Visualizar",BANCO);
    $bPermissaoVisualizarGrupoUsuario = $_SESSION['oLoginAdm']->verificaPermissao("Grupos","Visualizar",BANCO);
    $bPermissaoVisualizarTransacao = $_SESSION['oLoginAdm']->verificaPermissao("Transacao","Visualizar",BANCO);
    $bPermissaoVerLogTransacao = $_SESSION['oLoginAdm']->verificaPermissao("Transacao","VerLog",BANCO);
    $bPermissaoVerErroTransacao = $_SESSION['oLoginAdm']->verificaPermissao("Transacao","VerErro",BANCO);
    $bPermissaoVerErrosMySQLTransacao = $_SESSION['oLoginAdm']->verificaPermissao("Transacao","VerErrosMySQL",BANCO);

    //ALTERAR SENHA
    $bPermissaoAlterarSenha = $_SESSION['oLoginAdm']->verificaPermissao("Usuario","AlterarSenha",BANCO);

    if(isset($bPermissaoVisualizarUsuario) && $bPermissaoVisualizarUsuario == 1){
        $tpl->LINKMENUPUSUARIOS = "{CAMINHO}sistema/administrativo/usuario/index.php";
        $tpl->block("BLOCK_MENUP_USUARIOS");
    }

    if(isset($bPermissaoAlterarSenha) && $bPermissaoAlterarSenha == 1){
        $tpl->LINKMENUPALTERASENHA = "{CAMINHO}sistema/administrativo/alterar_senha/index.php";
        $tpl->block("BLOCK_MENUP_ALTERA_SENHA");
    }

    if(isset($bPermissaoVisualizarGrupoUsuario) && $bPermissaoVisualizarGrupoUsuario == 1){
        $tpl->LINKMENUPGRUPOUSUARIOS = "{CAMINHO}sistema/administrativo/grupo_usuario/index.php";
        $tpl->block("BLOCK_MENUP_GRUPO_USUARIOS");
    }

    if(isset($bPermissaoVisualizarTransacao) && $bPermissaoVisualizarTransacao == 1){
        $tpl->LINKMENUPTRANSACOES = "{CAMINHO}sistema/administrativo/transacao/index.php";
        $tpl->block("BLOCK_MENUP_TRANSACOES");
    }

    if(isset($bPermissaoVerLogTransacao) && $bPermissaoVerLogTransacao == 1){
        $tpl->LINKMENUPLOG = "{CAMINHO}sistema/administrativo/transacao/log_transacoes.php";
        $tpl->block("BLOCK_MENUP_LOG");
    }

    if(isset($bPermissaoVerErroTransacao) && $bPermissaoVerErroTransacao == 1){
        $tpl->LINKMENUPERROS = "{CAMINHO}sistema/administrativo/transacao/log_acessos.php";
        $tpl->block("BLOCK_MENUP_ERROS");
    }

    if(isset($bPermissaoVerErrosMySQLTransacao) && $bPermissaoVerErrosMySQLTransacao == 1){
        $tpl->LINKMENUPERROSMYSQL = "{CAMINHO}sistema/administrativo/transacao/log_erro_mysql.php";
        $tpl->block("BLOCK_MENUP_ERROS_MYSQL");
    }

    $tpl->block("BLOCK_MENUP_ADMINISTRATIVO");
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