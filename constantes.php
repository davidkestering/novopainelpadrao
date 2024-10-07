<?php
//CONTROLE DE SISTEMA
ob_start();
ignore_user_abort(true);
error_reporting(E_ALL); //mostrará todos os erros exceto os Notices
ini_set('default_charset', 'UTF-8'); // Define todos os caracteres em UTF8
ini_set('display_errors', true); //Habilita a exibição de erros
ini_set("memory_limit","512M"); //Altera a memória limite para post e gets
ini_set('post_max_size', '512M'); //Altera a memória limite para envio de posts
ini_set('max_file_uploads', '25'); //Altera o limite de arquivos disponíveis para upload
ini_set('upload_max_filesize', '512M'); //Altera o tamanho limite para envio de arquivos
ini_set("max_execution_time", "900000"); //Altera o tempo de execucao de scripts
date_default_timezone_set('America/Belem');

//CONTROLE DE CACHE
// Data no passado
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// Sempre modificado
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");

#CONSTANTES BANCO
//DADOS BASICOS DO SISTEMA
define("PATH",dirname(__FILE__)."/");
define("BANCO","LOCAL");
//define("BANCO","BANCO");
define("ACESSO_NEGADO","Você não tem permissão para acessar esta área.");
define("ACESSO_NEGADO_TRANSACAO","ACESSO NEGADO");
define("ACESSO_PERMITIDO_TRANSACAO","ACESSO PERMITIDO");
define("ACESSO_TENTATIVA","TENTATIVA NAO REALIZADA");
define("IP_USUARIO",$_SERVER['REMOTE_ADDR']);
define("IP_SERVIDOR",((isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != "") ? $_SERVER['SERVER_ADDR'] : ((isset($_SERVER['LOCAL_ADDR']) && $_SERVER['LOCAL_ADDR'] != "") ? $_SERVER['LOCAL_ADDR'] : "SEM IP")));
define("DATAHORA",date("Y-m-d H:i:s"));

//LOCAL
//define("CAMINHO",'../../../../../novopainel/');
define("CAMINHO",'../../../../../');
define("SITE",'../../../../../novopainel/');
//define("CAMINHO",'../../../../../NovoPainelPadraoComNovoLog/');
//define("SITE",'../../../../../NovoPainelPadraoComNovoLog/');


//ONLINE
//define("CAMINHO",'../../../../');

//IDS PADROES DO SISTEMA
define("ID_USUARIO_SISTEMA",0);
define("GRUPO_ADMINISTRADOR",1);
define("ALTERAR_SENHA",11);
define("ACESSO_LOGIN",2);
define("ACESSO_LOGOUT",3);
define("ID_USUARIO",((isset($_SESSION['oUsuario']) && $_SESSION['oUsuario']->getIdUsuario() != "") ? $_SESSION['oUsuario']->getIdUsuario() : 0));

?>