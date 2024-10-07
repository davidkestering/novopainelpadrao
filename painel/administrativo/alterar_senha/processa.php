<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Validacao.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();
$oValidacao = new Validacao();

//print_r($_POST);
//die();

// VERIFICA AS PERMISSÕES
$sOP = (isset($_POST['sOP'])) ? $_POST['sOP'] : "";
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Usuario",$sOP,BANCO);

if(!$bPermissao){
    //TRANSACAO
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),$_POST['fIdUsuario'],$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."painel/index.php?bErro=1");
    exit();
}//if(!$bPermissao){

//NAO PERMITE QUE O USUARIO DA SESSAO ALTERE A SENHA DE OUTRO USUARIO CASO ALTERE O HIDDEN DO IDUSUARIO
if($_SESSION['oLoginAdm']->getIdUsuario() != $_POST['fIdUsuario']){
    //TRANSACAO
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
    $sObjetoAcesso = "VERIFICAR ERRO: Tentativa de alteracao de senha, mas o ID_USUARIO da sessao eh diferente do ID_USUARIO do POST. ID_USUARIO POST: ".$_POST['fIdUsuario'];
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),$_POST['fIdUsuario'],$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."painel/index.php?bErro=1");
    exit();
}

//USUARIO AUXILIAR
$oUsuarioAuxiliar = $oFachadaSeguranca->recuperaUsuario($_POST['fIdUsuario'],BANCO);
if(isset($oUsuarioAuxiliar) && is_object($oUsuarioAuxiliar)){
    $nIdUsuario = $oUsuarioAuxiliar->getId();
    $nIdGrupoUsuario = $oUsuarioAuxiliar->getIdGrupoUsuario();
	$oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($oUsuarioAuxiliar->getIdGrupoUsuario(),BANCO);
	if(is_object($oGrupoUsuarioAuxiliar))
		$sGrupoUsuarioAuxiliar = $oGrupoUsuarioAuxiliar->getNmGrupoUsuario();
	$sNmUsuarioAuxiliar = $oUsuarioAuxiliar->getNmUsuario();
	$sLogin = $oUsuarioAuxiliar->getLogin();
	$sEmail = $oUsuarioAuxiliar->getEmail();
	$dDataCadastro = $oUsuarioAuxiliar->getDtCadastro();
	$bLogado = $oUsuarioAuxiliar->getLogado();
	$bPublicado = $oUsuarioAuxiliar->getPublicado();
	$bAtivo = $oUsuarioAuxiliar->getAtivo();
}

// REGISTRANDO NA SESSÃO
if (isset($sOP) && $sOP != "Excluir"){
	$oUsuario = $oFachadaSeguranca->inicializaUsuario($nIdUsuario,$nIdGrupoUsuario,$sNmUsuarioAuxiliar,$sLogin,$_POST['fSenha'],$sEmail,$bLogado,$dDataCadastro,$bPublicado,$bAtivo);
	//print_r($oUsuario);
	//die();
	$_SESSION['oUsuario'] = $oUsuario;
	
	$sAtributosChave = "nId,bLogado,sEmail,sSenha,bPublicado,bAtivo";
	$_SESSION['sMsg'] = $oValidacao->verificaObjetoVazio($oUsuario,$sAtributosChave);
	if ($_SESSION['sMsg']){
		header("Location: ".SITE."painel/administrativo/alterar_senha/index.php?bErro=1");
		exit();
	}//if ($_SESSION['sMsg']){
	
	if (isset($_POST['fSenha']) && $_POST['fSenha'] != "") {
		if ($_POST['fSenha'] != $_POST['fSenhaConfirmacao']) {
			$_SESSION['sMsg'] = "A senha precisa ser igual a confirmação. Tente novamente!";
			header("Location: ".SITE."painel/administrativo/alterar_senha/index.php?bErro=1");
			exit();
		}//if ($_POST['fSenha'] != $_POST['fSenhaConfirmacao']) {
	}//if (isset($_POST['fSenha']) && $_POST['fSenha'] != "") {
}//if (isset($sOP) && $sOP != "Excluir"){

switch($sOP){
	case "AlterarSenha":
		$sHeader = "insere_altera.php?sOP=$sOP&bErro=1&nIdUsuario=".$_POST['fIdUsuario'];
		if(isset($oUsuarioAuxiliar) && is_object($oUsuarioAuxiliar)){
			// TRANSACAO
            $vObjetoModificado=array_diff_assoc((array)$oUsuario,(array)$oUsuarioAuxiliar);
			//$voCampos = get_object_vars($oUsuarioAuxiliar);
            $vObjetoAntigo = (array)$oUsuarioAuxiliar;
			$voTransacao = array();
			foreach($vObjetoModificado as $sCampo => $sValor){
                $sValorAntigo = $vObjetoAntigo[$sCampo];
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$_POST['fIdUsuario'],$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                if($sCampo != "sSenha"){
                    array_push($voTransacao,$oTransacao);
                }else{
                    if(!is_null($sValor) && $sValor != ""){
                        array_push($voTransacao,$oTransacao);
                    }
                }
            }

			// CASO NÃO SEJA INFORMADO UMA NOVA SENHA DEVE SETAR A QUE ESTÁ NO BANCO
			if(trim($_POST['fSenha']) == "")
				$oUsuario->setSenha($oUsuarioAuxiliar->getSenha());

			if (!$oFachadaSeguranca->alteraUsuario($oUsuario,$voTransacao,BANCO)){
				//TRANSACAO
				$sObjetoAcesso = ACESSO_TENTATIVA;
                $voTransacaoAcesso = array();
                foreach($vObjetoModificado as $sCampo => $sValor){
                    $sValorAntigo = $vObjetoAntigo[$sCampo];
                    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$_POST['fIdUsuario'],$sObjetoAcesso,$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                    array_push($voTransacaoAcesso,$oTransacaoAcesso);
                }

                foreach ($voTransacaoAcesso as $oTransacaoAcesso){
                    if(isset($oTransacaoAcesso) && is_object($oTransacaoAcesso)){
                        $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
                    }
                }
				$_SESSION['sMsg'] = "Não foi possível alterar as informações!";
				$sHeader = "index.php?bErro=1";
			} else {
				$_SESSION['sMsg'] = "Informações alteradas com sucesso!";
				$sHeader = "index.php?bErro=0";
				$_SESSION['oUsuario'] = "";
				unset($_SESSION['oUsuario']);
				unset($_POST);		
			}//if ($oFachadaSeguranca->insereUsuario($oUsuario))
		} else {
			$_SESSION['sMsg'] = "Usuário não encontrado no sistema!";
		}//if(is_object($oUsuarioAuxiliar)){
	break;
	default:
		$_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
		header("location: ".SITE."painel/index.php?bErro=1");
		exit();
	break;
}	
header("Location: ".SITE."painel/administrativo/alterar_senha/".$sHeader);
?>