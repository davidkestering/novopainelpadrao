<?php

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
    $tpl->LINKMENUUSUARIOS = "{CAMINHO}painel/administrativo/usuario/index.php";
    $tpl->block("BLOCK_MENU_USUARIOS");
}

if(isset($bPermissaoAlterarSenha) && $bPermissaoAlterarSenha == 1){
    $tpl->LINKMENUALTERASENHA = "{CAMINHO}painel/administrativo/alterar_senha/index.php";
    $tpl->block("BLOCK_MENU_ALTERA_SENHA");
}

if(isset($bPermissaoVisualizarGrupoUsuario) && $bPermissaoVisualizarGrupoUsuario == 1){
    $tpl->LINKMENUGRUPOUSUARIOS = "{CAMINHO}painel/administrativo/grupo_usuario/index.php";
    $tpl->block("BLOCK_MENU_GRUPO_USUARIOS");
}

if(isset($bPermissaoVisualizarTransacao) && $bPermissaoVisualizarTransacao == 1){
    $tpl->LINKMENUTRANSACOES = "{CAMINHO}painel/administrativo/transacao/index.php";
    $tpl->block("BLOCK_MENU_TRANSACOES");
}

if(isset($bPermissaoVerLogTransacao) && $bPermissaoVerLogTransacao == 1){
    $tpl->LINKMENULOG = "{CAMINHO}painel/administrativo/transacao/log_transacoes.php";
    $tpl->block("BLOCK_MENU_LOG");
}

if(isset($bPermissaoVerErroTransacao) && $bPermissaoVerErroTransacao == 1){
    $tpl->LINKMENUERROS = "{CAMINHO}painel/administrativo/transacao/log_acessos.php";
    $tpl->block("BLOCK_MENU_ERROS");
}

if(isset($bPermissaoVerErrosMySQLTransacao) && $bPermissaoVerErrosMySQLTransacao == 1){
    $tpl->LINKMENUERROSMYSQL = "{CAMINHO}painel/administrativo/transacao/log_erro_mysql.php";
    $tpl->block("BLOCK_MENU_ERROS_MYSQL");
}

$tpl->block("BLOCK_MENU_ADMINISTRATIVO");

?>