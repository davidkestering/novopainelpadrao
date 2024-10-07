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
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Grupos",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Grupos",$sOP,BANCO);
$nIdGrupoUsuario = (isset($_POST['fIdGrupoUsuario']) && $_POST['fIdGrupoUsuario'] != "" && $_POST['fIdGrupoUsuario'] != 0) ? $_POST['fIdGrupoUsuario'] : 0;

if(!$bPermissao){
    //TRANSACAO
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Grupos", $sOP, BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("", $nIdTipoTransacaoAcesso, $_SESSION['oLoginAdm']->getIdUsuario(),$nIdGrupoUsuario, $sObjetoAcesso, "", "", "", IP_USUARIO, DATAHORA, 1, 1);
	$oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
	$_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
	header("location: ".SITE."painel/index.php?bErro=1");
	exit();
}//if(!$bPermissao){

if (isset($sOP) && $sOP != "Excluir"){
	$bPublicado = (isset($_POST['fPublicado']) && $_POST['fPublicado'] == 1) ? "1" : "0";
	$bAtivo = (isset($_POST['fAtivo']) && $_POST['fAtivo'] == 1) ? "1" : "0";
	
	$oGrupoUsuario = $oFachadaSeguranca->inicializaGrupoUsuario($_POST['fIdGrupoUsuario'], $_POST['fNome'],$_POST['fDataCadastro'],$bPublicado,$bAtivo);
	$_SESSION['oGrupoUsuario'] = $oGrupoUsuario;
	
	$sAtributosChave = "nId,bPublicado,bAtivo";
	$_SESSION['sMsg'] = $oValidacao->verificaObjetoVazio($oGrupoUsuario,$sAtributosChave);
	if ($_SESSION['sMsg']){
		header("Location: ".SITE."painel/administrativo/grupo_usuario/insere_altera.php?sOP=$sOP&bErro=1&nIdGrupoUsuario=".$_POST['fIdGrupoUsuario']);
		exit();
	}
}

switch($sOP){
	case "Cadastrar":
        // TRANSACAO
        $voObjetoNovo = get_object_vars($oGrupoUsuario);
        $voTransacao = array();
        foreach($voObjetoNovo as $sCampo => $sValor){
            if($sCampo != "nId"){
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacao,$oTransacao);
            }
        }

        $nIdGrupoUsuario = $oFachadaSeguranca->insereGrupoUsuario($oGrupoUsuario,$voTransacao,BANCO);

		if (!$nIdGrupoUsuario){
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
			$_SESSION['sMsg'] = "Não foi possível inserir o Grupo de Usuários!";
			$sHeader = "insere_altera.php?sOP=$sOP&bErro=1";
		} else {
			//INSERINDO AUTOMATICAMENTE A OPCAO DE LOGIN PARA O NOVO GRUPO
			$oPermissaoLogin = $oFachadaSeguranca->inicializaPermissao(ACESSO_LOGIN,$nIdGrupoUsuario,date("Y-m-d H:i:s"),1,1);
			//TRANSACAO
			$sObjeto = "Habilitando Permissão de Login para o Grupo de Usuários ".$_POST['fNome']." de id: ".$nIdGrupoUsuario;
			$voTransacaoLogin = array();
			$oTransacaoLogin = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdGrupoUsuario,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
			array_push($voTransacaoLogin,$oTransacaoLogin);
			$oFachadaSeguranca->inserePermissao($oPermissaoLogin,$voTransacaoLogin,BANCO);
			
			//INSERINDO AUTOMATICAMENTE A OPCAO DE LOGOUT PARA O NOVO GRUPO
			$oPermissaoLogout = $oFachadaSeguranca->inicializaPermissao(ACESSO_LOGOUT,$nIdGrupoUsuario,date("Y-m-d H:i:s"),1,1);
			//TRANSACAO
			$sObjeto = "Habilitando Permissão de Logout para o Grupo de Usuários ".$_POST['fNome']." de id: ".$nIdGrupoUsuario;
            $voTransacaoLogout = array();
            $oTransacaoLogout = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdGrupoUsuario,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
            array_push($voTransacaoLogout,$oTransacaoLogout);
			$oFachadaSeguranca->inserePermissao($oPermissaoLogout,$voTransacaoLogout,BANCO);
			
			//INSERINDO AUTOMATICAMENTE A OPCAO DE ALTERAR SENHA PARA O NOVO GRUPO
			$oPermissaoAlteraSenha = $oFachadaSeguranca->inicializaPermissao(ALTERAR_SENHA,$nIdGrupoUsuario,date("Y-m-d H:i:s"),1,1);
			//TRANSACAO
			$sObjeto = "Habilitando Permissão de Alteração de Senha para o Grupo de Usuários ".$_POST['fNome']." de id: ".$nIdGrupoUsuario;
            $voTransacaoAlterarSenha = array();
            $oTransacaoAlterarSenha = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdGrupoUsuario,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
            array_push($voTransacaoAlterarSenha,$oTransacaoAlterarSenha);
			$oFachadaSeguranca->inserePermissao($oPermissaoAlteraSenha,$voTransacaoAlterarSenha,BANCO);
			
			$_SESSION['sMsg'] = "Grupo de Usuários inserido com sucesso!";
			$sHeader = "index.php?bErro=0";			
			$_SESSION['oGrupoUsuario'] = "";
			unset($_SESSION['oGrupoUsuario']);
			unset($_POST);
		}//if ($oFachadaSeguranca->insereGrupoUsuario($oGrupoUsuario))
	break;
	case "Alterar":
		$sHeader = "insere_altera.php?sOP=$sOP&bErro=1&nIdGrupoUsuario=".$_POST['fIdGrupoUsuario'];
		$oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($_POST['fIdGrupoUsuario'],BANCO);
		if(is_object($oGrupoUsuarioAuxiliar)){
            // TRANSACAO
            $vObjetoModificado=array_diff_assoc((array)$oGrupoUsuario,(array)$oGrupoUsuarioAuxiliar);
            //$voCampos = get_object_vars($oGrupoUsuarioAuxiliar);
            $vObjetoAntigo = (array)$oGrupoUsuarioAuxiliar;
            $voTransacao = array();
            foreach($vObjetoModificado as $sCampo => $sValor){
                $sValorAntigo = $vObjetoAntigo[$sCampo];
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oGrupoUsuarioAuxiliar->getId(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                if($sCampo != "sSenha"){
                    array_push($voTransacao,$oTransacao);
                }else{
                    if(!is_null($sValor) && $sValor != ""){
                        array_push($voTransacao,$oTransacao);
                    }
                }
            }

			if (!$oFachadaSeguranca->alteraGrupoUsuario($oGrupoUsuario,$voTransacao,BANCO)){
                //TRANSACAO
                $sObjetoAcesso = ACESSO_TENTATIVA;
                $voTransacaoAcesso = array();
                foreach($vObjetoModificado as $sCampo => $sValor){
                    $sValorAntigo = $vObjetoAntigo[$sCampo];
                    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oGrupoUsuarioAuxiliar->getId(),$sObjetoAcesso,$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                    array_push($voTransacaoAcesso,$oTransacaoAcesso);
                }

                foreach ($voTransacaoAcesso as $oTransacaoAcesso){
                    if(isset($oTransacaoAcesso) && is_object($oTransacaoAcesso)){
                        $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
                    }
                }
				$_SESSION['sMsg'] = "Não foi possível alterar o Grupo de Usuários!";
				$sHeader = "insere_altera.php?sOP=$sOP&bErro=1&nIdGrupoUsuario=".$_POST['fIdGrupoUsuario'];
			} else {
				$_SESSION['sMsg'] = "Grupo de Usuários alterado com sucesso!";
				$sHeader = "index.php?bErro=0";
				$_SESSION['oGrupoUsuario'] = "";
				unset($_SESSION['oGrupoUsuario']);
				unset($_POST);
			}//if ($oFachadaSeguranca->insereGrupoUsuario($oGrupoUsuario))
		} else {
			$_SESSION['sMsg'] = "Grupo de Usuários não encontrado no sistema!";
		}
	break;
	case "Excluir":		
		$bResultado = true;
		foreach($_POST['fIdGrupoUsuario'] as $nIdGrupoUsuario) {
			$oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($nIdGrupoUsuario,BANCO);
			if(isset($oGrupoUsuarioAuxiliar) && is_object($oGrupoUsuarioAuxiliar)){
                // TRANSACAO
                $voTransacao = array();
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdGrupoUsuario,"","","",IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacao,$oTransacao);

                $bResultado &= $oFachadaSeguranca->desativaGrupoUsuario($nIdGrupoUsuario,$voTransacao,BANCO);
				if($bResultado == true)
					$oFachadaSeguranca->desativaPermissaoPorGrupoUsuario($nIdGrupoUsuario,BANCO);
			} else 
				$bResultado &= false;
		} //foreach($_POST['fIdGrupoUsuario'] as $nIdGrupoUsuario)
		
		if($bResultado){
			$_SESSION['sMsg'] = "Grupo de Usuários excluído com sucesso!";			
			$sHeader = "index.php?bErro=0";
		} else {
			$_SESSION['sMsg'] = "Não foi possível excluir o Grupo de Usuários";
			$sHeader = "index.php?bErro=1";
		}//if($bResultado){
	break;
	
}	

header("Location: ".SITE."painel/administrativo/grupo_usuario/".$sHeader);

?>