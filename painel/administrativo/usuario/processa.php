<?php
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Validacao.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();
$oValidacao = new Validacao();

//print_r($_POST);
//die()

// VERIFICA AS PERMISSÕES
$sOP = (isset($_POST['sOP'])) ? $_POST['sOP'] : "";
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Usuario",$sOP,BANCO);
$nIdUsuario = (isset($_POST['fIdUsuario']) && $_POST['fIdUsuario'] != "" && $_POST['fIdUsuario'] != 0) ? $_POST['fIdUsuario'] : 0;

if(!$bPermissao) {
    //TRANSACAO
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Usuario", $sOP, BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("", $nIdTipoTransacaoAcesso, $_SESSION['oLoginAdm']->getIdUsuario(),$nIdUsuario, $sObjetoAcesso, "", "", "", IP_USUARIO, DATAHORA, 1, 1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso, BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: " . SITE . "painel/index.php?bErro=1");
    exit();
}

// REGISTRANDO NA SESSÃO
if (isset($sOP) && $sOP != "Excluir"){
	$bLogado = (isset($_POST['fLogado']) && $_POST['fLogado'] == 1) ? "1" : "0";
	$bPublicado = (isset($_POST['fPublicado']) && $_POST['fPublicado'] == 1) ? "1" : "0";
	$bAtivo = (isset($_POST['fAtivo']) && $_POST['fAtivo'] == 1) ? "1" : "0";
	
	$oUsuario = $oFachadaSeguranca->inicializaUsuario($_POST['fIdUsuario'],$_POST['fIdGrupoUsuario'], $_POST['fNome'],$_POST['fLogin'],$_POST['fSenha'],$_POST['fEmail'],$bLogado,$_POST['fDataCadastro'],$bPublicado,$bAtivo);
	//print_r($oUsuario);
	//die();
	$_SESSION['oUsuario'] = $oUsuario;
	
	$sAtributosChave = "nId,bLogado,sEmail,sSenha,bPublicado,bAtivo";
	$_SESSION['sMsg'] = $oValidacao->verificaObjetoVazio($oUsuario,$sAtributosChave);
	if ($_SESSION['sMsg']){
		header("Location: ".SITE."painel/administrativo/usuario/insere_altera.php?sOP=$sOP&bErro=1&nIdUsuario=".$_POST['fIdUsuario']);
		exit();
	}//if ($_SESSION['sMsg']){
	
	if (isset($_POST['fSenha']) && $_POST['fSenha'] != "") {
		if ($_POST['fSenha'] != $_POST['fSenhaConfirmacao']) {
			$_SESSION['sMsg'] = "A senha precisa ser igual a confirmação. Tente novamente!";
			header("Location:insere_altera.php?sOP=$sOP&bErro=1&nIdUsuario=".$_POST['fIdUsuario']);
			exit();
		}//if ($_POST['fSenha'] != $_POST['fSenhaConfirmacao']) {
	}//if (isset($_POST['fSenha']) && $_POST['fSenha'] != "") {
}//if (isset($sOP) && $sOP != "Excluir"){

switch($sOP){
	case "Cadastrar":
        // TRANSACAO
        $voObjetoNovo = get_object_vars($oUsuario);
        $voTransacao = array();
        foreach($voObjetoNovo as $sCampo => $sValor){
            if($sCampo != "nId"){
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacao,$oTransacao);
            }
        }
		if (!$oFachadaSeguranca->insereUsuario($oUsuario,$voTransacao,BANCO)){
            //TRANSACAO
            $sObjetoAcesso = ACESSO_TENTATIVA;
            $voTransacaoAcesso = array();
            foreach($voObjetoNovo as $sCampo => $sValor){
                if($sCampo != "nId"){
                    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sObjetoAcesso,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                    array_push($voTransacaoAcesso,$oTransacaoAcesso);
                }
            }

            foreach ($voTransacaoAcesso as $oTransacaoAcesso){
                if(isset($oTransacaoAcesso) && is_object($oTransacaoAcesso)){
                    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
                }
            }

			$_SESSION['sMsg'] = "Não foi possível inserir o usuário!";
			$sHeader = "insere_altera.php?sOP=$sOP&bErro=1";
		} else {
			$_SESSION['sMsg'] = "Usuário inserido com sucesso!";
			$sHeader = "index.php?bErro=0";
			$_SESSION['oUsuario'] = "";
			unset($_SESSION['oUsuario']);
			unset($_POST);
		}//if (!$nId){
	break;
	case "Alterar":
		$sHeader = "insere_altera.php?sOP=$sOP&bErro=1&nIdUsuario=".$_POST['fIdUsuario'];
		$oUsuarioAuxiliar = $oFachadaSeguranca->recuperaUsuario($_POST['fIdUsuario'],BANCO);
		if(isset($oUsuarioAuxiliar) && is_object($oUsuarioAuxiliar)){
			// CASO NÃO SEJA INFORMADO UMA NOVA SENHA DEVE SETAR A QUE ESTÁ NO BANCO
			if(trim($_POST['fSenha']) == "")
				$oUsuario->setSenha($oUsuarioAuxiliar->getSenha());

            // TRANSACAO
            $vObjetoModificado=array_diff_assoc((array)$oUsuario,(array)$oUsuarioAuxiliar);
            //$voCampos = get_object_vars($oUsuarioAuxiliar);
            $vObjetoAntigo = (array)$oUsuarioAuxiliar;
            $voTransacao = array();
            foreach($vObjetoModificado as $sCampo => $sValor){
                $sValorAntigo = $vObjetoAntigo[$sCampo];
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oUsuarioAuxiliar->getId(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                if($sCampo != "sSenha"){
                    array_push($voTransacao,$oTransacao);
                }else{
                    if(!is_null($sValor) && $sValor != ""){
                        array_push($voTransacao,$oTransacao);
                    }
                }
            }

			if (!$oFachadaSeguranca->alteraUsuario($oUsuario,$voTransacao,BANCO)){
                //TRANSACAO
                $sObjetoAcesso = ACESSO_TENTATIVA;
                $voTransacaoAcesso = array();
                foreach($vObjetoModificado as $sCampo => $sValor){
                    $sValorAntigo = $vObjetoAntigo[$sCampo];
                    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oUsuarioAuxiliar->getId(),$sObjetoAcesso,$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                    array_push($voTransacaoAcesso,$oTransacaoAcesso);
                }

                foreach ($voTransacaoAcesso as $oTransacaoAcesso){
                    if(isset($oTransacaoAcesso) && is_object($oTransacaoAcesso)){
                        $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
                    }
                }
				$_SESSION['sMsg'] = "Não foi possível alterar o usuário!";
				$sHeader = "insere_altera.php?sOP=$sOP&bErro=1&nIdUsuario=".$_POST['fIdUsuario'];
			} else {
				$_SESSION['sMsg'] = "Usuário alterado com sucesso!";
				$sHeader = "index.php?bErro=0";
				$_SESSION['oUsuario'] = "";
				unset($_SESSION['oUsuario']);
				unset($_POST);		
			}//if ($oFachadaSeguranca->insereUsuario($oUsuario))
		} else {
			$_SESSION['sMsg'] = "Usuário não encontrado no sistema!";
		}//if(is_object($oUsuarioAuxiliar)){
	break;
	case "Excluir":
		$bResultado = true;
		foreach($_POST['fIdUsuario'] as $nIdUsuario) {
			if ($oFachadaSeguranca->presenteUsuario($nIdUsuario,BANCO)){
				// TRANSACAO
				$oUsuarioAuxiliar = $oFachadaSeguranca->recuperaUsuario($nIdUsuario,BANCO);
                $voTransacao = array();
				$oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdUsuario,"","","",IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacao,$oTransacao);

				$bResultado &= $oFachadaSeguranca->desativaUsuario($nIdUsuario,$voTransacao,BANCO);
			} else {
                //TRANSACAO
                $sObjetoAcesso = ACESSO_TENTATIVA;
                $voTransacaoAcesso = array();
                $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdUsuario,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacaoAcesso,$oTransacaoAcesso);

                foreach ($voTransacaoAcesso as $oTransacaoAcesso){
                    if(isset($oTransacaoAcesso) && is_object($oTransacaoAcesso)){
                        $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
                    }
                }

				$bResultado &= false;
			}//if ($oFachadaSeguranca->presenteUsuario($nIdUsuario,BANCO)){
		} //foreach($_POST['fIdUsuario'] as $nIdUsuario)
		
		if($bResultado){
			$_SESSION['sMsg'] = "Usuário excluído com sucesso!";			
			$sHeader = "index.php?bErro=0";
		} else {
			$_SESSION['sMsg'] = "Não foi possível excluir o Usuário";
			$sHeader = "index.php?bErro=1";
		}//if($bResultado){
	break;
}	
header("Location: ".SITE."painel/administrativo/usuario/".$sHeader);
?>