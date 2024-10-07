<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/Data.class.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Template.class.php");

$nIdCategoriaTipoTransacao = (isset($_GET['nIdCategoriaTipoTransacao']) && $_GET['nIdCategoriaTipoTransacao'] != "" && $_GET['nIdCategoriaTipoTransacao'] != 0) ? $_GET['nIdCategoriaTipoTransacao'] : ((isset($_POST['fIdCategoriaTipoTransacao'][0]) && $_POST['fIdCategoriaTipoTransacao'][0] != "" && $_POST['fIdCategoriaTipoTransacao'][0] != 0) ? $_POST['fIdCategoriaTipoTransacao'][0] : "");
$sOP = ($nIdCategoriaTipoTransacao) ? "Alterar" : "Cadastrar";

// VERIFICA AS PERMISSÕES
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Transacao",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Transacao",$sOP,BANCO);
$oFachadaSeguranca = new FachadaSegurancaBD();
if(!$bPermissao) {
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Transacao",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."painel/index.php?bErro=1");
    exit();
}else{
    $sObjetoAcesso = ACESSO_PERMITIDO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
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
  $tpl->SUBMENUTRANSACOESATIVO = "active";
  $tpl->PAGINAATUAL = "Cadastro de Transações";

  //RODAPE
  require_once(PATH."painel/includes/rodape.php");
}

$tpl->ACAO = $sOP;

$nContador = 0;
$vIdPermissao = array();
$vWherePermissao = array("id_grupo_usuario = ".GRUPO_ADMINISTRADOR);
$voPermissao = $oFachadaSeguranca->recuperaTodosPermissao(BANCO,$vWherePermissao);

if(isset($voPermissao) && count($voPermissao) > 0){
  foreach($voPermissao as $oPermissao){
    if(isset($oPermissao) && is_object($oPermissao)){
      if(!in_array($oPermissao->getIdTipoTransacao(),$vIdPermissao))
        array_push($vIdPermissao,$oPermissao->getIdTipoTransacao());
    }
  }
}

if(isset($nIdCategoriaTipoTransacao) && $nIdCategoriaTipoTransacao != "" && $nIdCategoriaTipoTransacao != 0) {
  $oCategoriaTipoTransacao = $oFachadaSeguranca->recuperaCategoriaTipoTransacao($nIdCategoriaTipoTransacao,BANCO);
  //print_r($oCategoriaTipoTransacao);
  if(isset($oCategoriaTipoTransacao) && is_object($oCategoriaTipoTransacao)){
    $vWhereTipoTransacao = array("id_categoria_tipo_transacao = ".$nIdCategoriaTipoTransacao);
    $sOrderTipoTransacao = "transacao asc";
    $voTipoTransacao = $oFachadaSeguranca->recuperaTodosTipoTransacao(BANCO,$vWhereTipoTransacao,$sOrderTipoTransacao);
    
    $tpl->IDCATEGORIATIPOTRANSACAO = $oCategoriaTipoTransacao->getId();
    $tpl->CATEGORIATIPOTRANSACAO = $oCategoriaTipoTransacao->getDescricao();
    $tpl->SELECTEDTIPOTRANSACAO = "";
    if(isset($voTipoTransacao) && count($voTipoTransacao) > 0){
      foreach($voTipoTransacao as $oTipoTransacao){
        if(isset($oTipoTransacao) && is_object($oTipoTransacao)){
          $nContador++;
          $tpl->CONTADORTIPOTRANSACAO = $nContador;
          $tpl->TIPOTRANSACAO = $oTipoTransacao->getTransacao();
          
          $tpl->SELECTEDTIPOTRANSACAO = "";
          if(in_array($oTipoTransacao->getId(),$vIdPermissao))
            $tpl->SELECTEDTIPOTRANSACAO = "checked";
            
          $tpl->block("BLOCO_TIPO_TRANSACAO");
        }
      }
    }
    $tpl->TOTALCONTADORTIPOTRANSACAO = $nContador;
    
    if($nContador > 0){
      for($i=1;$i<=4;$i++){
        $tpl->QTD_NOVA_TRANSACAO = $i;
        $tpl->block("BLOCO_QTD_NOVA_TRANSACAO");
      }
    }

    $tpl->DATACADASTRO = $oCategoriaTipoTransacao->getDtCadastro();
  }
}else{
  $tpl->IDCATEGORIATIPOTRANSACAO = 0;
  $tpl->TOTALCONTADORTIPOTRANSACAO = $nContador;
  $tpl->block("BLOCO_BASICO_CADASTRO");
  for($i=1;$i<=4;$i++){
    $tpl->QTD_NOVA_TRANSACAO = $i;
    $tpl->block("BLOCO_QTD_NOVA_TRANSACAO");
  }
  $tpl->DATACADASTRO = date("Y-m-d H:i:s");
}

$tpl->CAMINHO = CAMINHO;

if(isset($_SESSION['oCategoriaTipoTransacao']))
  unset($_SESSION['oCategoriaTipoTransacao']);
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