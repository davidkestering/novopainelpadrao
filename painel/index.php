<?php
require_once("../constantes.php");
require_once(PATH."/classes/Login.class.php");
require_once(PATH."/classes/Template.class.php");
session_start();

//print_r($_SESSION['oLoginAdm']);

if(isset($_SESSION['oLoginAdm'])){
	//unset($_SESSION['oLoginAdm']);
	$tpl = new Template('tpl/index.html');
	$tpl->addFile('HEAD','includes/head.html');
        $tpl->addFile('TOPO_PAINEL','includes/topo_painel.html');
        $tpl->addFile('MENU_LATERAL','includes/menu_lateral.html');
        $tpl->addFile('SCRIPTJS','includes/scriptsjs.html');
        $tpl->addFile('RODAPE','includes/rodape.html');
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

        //RODAPE
        require_once(PATH."painel/includes/rodape.php");
    }

    $tpl->PAGINAATUAL = "Painel Administrativo";

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

    //CELULA
    $bPermissaoVisualizarLider = $_SESSION['oLoginAdm']->verificaPermissao("Lider","Visualizar",BANCO);
    $bPermissaoVisualizarSupervisor = $_SESSION['oLoginAdm']->verificaPermissao("Supervisor","Visualizar",BANCO);
    $bPermissaoVisualizarRede = $_SESSION['oLoginAdm']->verificaPermissao("Rede","Visualizar",BANCO);
    $bPermissaoVisualizarCelula = $_SESSION['oLoginAdm']->verificaPermissao("Celula","Visualizar",BANCO);

    //SEMINARIO
    $bPermissaoVisualizarStatusRelacionamento = $_SESSION['oLoginAdm']->verificaPermissao("StatusRelacionamento","Visualizar",BANCO);
    $bPermissaoVisualizarInscricao = $_SESSION['oLoginAdm']->verificaPermissao("Inscricao","Visualizar",BANCO);

    if(isset($bPermissaoVisualizarUsuario) && $bPermissaoVisualizarUsuario == 1){
        $tpl->LINKMENUPUSUARIOS = "{CAMINHO}painel/administrativo/usuario/index.php";
        $tpl->block("BLOCK_MENUP_USUARIOS");
    }

    if(isset($bPermissaoAlterarSenha) && $bPermissaoAlterarSenha == 1){
        $tpl->LINKMENUPALTERASENHA = "{CAMINHO}painel/administrativo/alterar_senha/index.php";
        $tpl->block("BLOCK_MENUP_ALTERA_SENHA");
    }

    if(isset($bPermissaoVisualizarGrupoUsuario) && $bPermissaoVisualizarGrupoUsuario == 1){
        $tpl->LINKMENUPGRUPOUSUARIOS = "{CAMINHO}painel/administrativo/grupo_usuario/index.php";
        $tpl->block("BLOCK_MENUP_GRUPO_USUARIOS");
    }

    if(isset($bPermissaoVisualizarTransacao) && $bPermissaoVisualizarTransacao == 1){
        $tpl->LINKMENUPTRANSACOES = "{CAMINHO}painel/administrativo/transacao/index.php";
        $tpl->block("BLOCK_MENUP_TRANSACOES");
    }

    if(isset($bPermissaoVerLogTransacao) && $bPermissaoVerLogTransacao == 1){
        $tpl->LINKMENUPLOG = "{CAMINHO}painel/administrativo/transacao/log_transacoes.php";
        $tpl->block("BLOCK_MENUP_LOG");
    }

    if(isset($bPermissaoVerErroTransacao) && $bPermissaoVerErroTransacao == 1){
        $tpl->LINKMENUPERROS = "{CAMINHO}painel/administrativo/transacao/log_acessos.php";
        $tpl->block("BLOCK_MENUP_ERROS");
    }

    if(isset($bPermissaoVerErrosMySQLTransacao) && $bPermissaoVerErrosMySQLTransacao == 1){
        $tpl->LINKMENUPERROSMYSQL = "{CAMINHO}painel/administrativo/transacao/log_erro_mysql.php";
        $tpl->block("BLOCK_MENUP_ERROS_MYSQL");
    }

    $tpl->block("BLOCK_MENUP_ADMINISTRATIVO");

    //CELULA
    if((isset($bPermissaoVisualizarLider) && $bPermissaoVisualizarLider == 1)
        || (isset($bPermissaoVisualizarSupervisor) && $bPermissaoVisualizarSupervisor == 1)
        || (isset($bPermissaoVisualizarRede) && $bPermissaoVisualizarRede == 1)
        || (isset($bPermissaoVisualizarCelula) && $bPermissaoVisualizarCelula == 1)){

        if(isset($bPermissaoVisualizarLider) && $bPermissaoVisualizarLider == 1){
            $tpl->LINKMENUPLIDER = "{CAMINHO}painel/celula/lider/index.php";
            $tpl->block("BLOCK_MENUP_LIDER");
        }

        if(isset($bPermissaoVisualizarSupervisor) && $bPermissaoVisualizarSupervisor == 1){
            $tpl->LINKMENUPSUPERVISOR = "{CAMINHO}painel/celula/supervisor/index.php";
            $tpl->block("BLOCK_MENUP_SUPERVISOR");
        }

        if(isset($bPermissaoVisualizarRede) && $bPermissaoVisualizarRede == 1){
            $tpl->LINKMENUPREDE = "{CAMINHO}painel/celula/rede/index.php";
            $tpl->block("BLOCK_MENUP_REDE");
        }

        if(isset($bPermissaoVisualizarCelula) && $bPermissaoVisualizarCelula == 1){
            $tpl->LINKMENUPCELULA = "{CAMINHO}painel/celula/celula/index.php";
            $tpl->block("BLOCK_MENUP_CELULA");
        }

        $tpl->block("BLOCK_MENUP_CELULAS");
    }

    //SEMINARIO
    if((isset($bPermissaoVisualizarStatusRelacionamento) && $bPermissaoVisualizarStatusRelacionamento == 1)
        || (isset($bPermissaoVisualizarInscricao) && $bPermissaoVisualizarInscricao == 1)){

        if(isset($bPermissaoVisualizarStatusRelacionamento) && $bPermissaoVisualizarStatusRelacionamento == 1){
            $tpl->LINKMENUPSTATUSRELACIONAMENTO = "{CAMINHO}painel/seminario/statusrelacionamento/index.php";
            $tpl->block("BLOCK_MENUP_STATUSRELACIONAMENTO");
        }

        if(isset($bPermissaoVisualizarInscricao) && $bPermissaoVisualizarInscricao == 1){
            $tpl->LINKMENUPINSCRICAO = "{CAMINHO}painel/seminario/inscricao/index.php";
            $tpl->LINKMENUPESTATISTICAS = "{CAMINHO}painel/seminario/estatisticas/index.php";
            $tpl->block("BLOCK_MENUP_INSCRICAO");
        }

        $tpl->block("BLOCK_MENUP_SEMINARIO");
    }


}else{
	$tpl = new Template('tpl/login.html');
	$tpl->addFile('HEAD','includes/head.html');
	$tpl->addFile('SCRIPTJS','includes/scriptsjs.html');
	$tpl->CLASSEMENSAGEM = "esconder";
	$tpl->MENSAGEM = "";
	if(isset($_SESSION['sMsgPermissao']) && $_SESSION['sMsgPermissao'] != ""){
		$tpl->MENSAGEM = $_SESSION['sMsgPermissao'];
		$tpl->CLASSEMENSAGEM = "mostrar";
		$_SESSION['sMsgPermissao'] = "";
		unset($_SESSION['sMsgPermissao']);
	}
}

$tpl->CAMINHO = CAMINHO;

$tpl->show();
?>