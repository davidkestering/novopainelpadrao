<?php 
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();
$sOP = "Alterar";

// VERIFICA AS PERMISSÕES
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Permissao",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Permissao",$sOP,BANCO);
$oFachadaSeguranca = new FachadaSegurancaBD();
if(!$bPermissao){
    // TRANSACAO
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Grupos",$sOP,BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoAcesso,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sObjetoAcesso,"","","",IP_USUARIO,DATAHORA,1,1);
    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
    $_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
    header("location: ".SITE."painel/index.php?bErro=1");
    exit();
}//if(!$bPermissao){

$oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($_POST['fIdGrupoUsuario'],BANCO);
if(is_object($oGrupoUsuarioAuxiliar))
	$sGrupoUsuarioAuxiliar = $oGrupoUsuarioAuxiliar->getNmGrupoUsuario();

$bResultado = true;
if(isset($_POST['fIdTipoTransacao']) && count($_POST['fIdTipoTransacao']) > 0){
	$vIdTipoTransacao = $_POST['fIdTipoTransacao'];
	
	//DESATIVANDO TODAS AS PERMISSOES
	$oFachadaSeguranca->desativaPermissaoPorGrupoUsuario($_POST['fIdGrupoUsuario'],BANCO);
	
	foreach($vIdTipoTransacao as $nIdTipoTransacao){
		$sTipoTransacaoAuxiliar = "";
		$sCategoriaTipoTransacaoAuxiliar = "";
		$oTipoTransacaoAuxiliar = $oFachadaSeguranca->recuperaTipoTransacao($nIdTipoTransacao,BANCO);
		if(isset($oTipoTransacaoAuxiliar) && is_object($oTipoTransacaoAuxiliar)){
			$sTipoTransacaoAuxiliar = $oTipoTransacaoAuxiliar->getTransacao();
			$oCategoriaTipoTransacaoAuxiliar = $oFachadaSeguranca->recuperaCategoriaTipoTransacao($oTipoTransacaoAuxiliar->getIdCategoriaTipoTransacao(),BANCO);
			if(is_object($oCategoriaTipoTransacaoAuxiliar))
				$sCategoriaTipoTransacaoAuxiliar = $oCategoriaTipoTransacaoAuxiliar->getDescricao();
		}
		
		$vWherePermissao = array("id_tipo_transacao = ".$nIdTipoTransacao,"id_grupo_usuario = ".$_POST['fIdGrupoUsuario']);
		$voPermissaoAuxiliar = $oFachadaSeguranca->recuperaTodosPermissao(BANCO,$vWherePermissao);
		if(count($voPermissaoAuxiliar) > 0){
			foreach($voPermissaoAuxiliar as $oPermissaoAuxiliar){
				if(isset($oPermissaoAuxiliar) && is_object($oPermissaoAuxiliar)){
				    $oPermissao = $oFachadaSeguranca->recuperaPermissao($oPermissaoAuxiliar->getIdTipoTransacao(),$oPermissaoAuxiliar->getIdGrupoUsuario(),BANCO);
					$oPermissaoAuxiliar->setPublicado(1);
					$oPermissaoAuxiliar->setAtivo(1);

                    $vObjetoModificado=array_diff_assoc((array)$oPermissao,(array)$oPermissaoAuxiliar);
                    $vObjetoAntigo = (array)$oPermissao;
                    $voTransacao = array();
                    foreach($vObjetoModificado as $sCampo => $sValor){
                        $sValorAntigo = $vObjetoAntigo[$sCampo];
                        $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oPermissaoAuxiliar->getIdTipoTransacao()."_".$oPermissaoAuxiliar->getIdGrupoUsuario(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                        if($sCampo != "sSenha"){
                            array_push($voTransacao,$oTransacao);
                        }else{
                            if(!is_null($sValor) && $sValor != ""){
                                array_push($voTransacao,$oTransacao);
                            }
                        }
                    }

					$bResultado &= $oFachadaSeguranca->alteraPermissao($oPermissaoAuxiliar,$voTransacao,BANCO);
				}//if(is_object($oPermissaoAuxiliar)){
			}//foreach($voPermissaoAuxiliar as $oPermissaoAuxiliar){
		}else{
			$oPermissao = $oFachadaSeguranca->inicializaPermissao($nIdTipoTransacao,$_POST['fIdGrupoUsuario'],date("Y-m-d H:i:s"),1,1);

            // TRANSACAO
            $voObjetoNovo = get_object_vars($oPermissao);
            $voTransacao = array();
            foreach($voObjetoNovo as $sCampo => $sValor){
                if($sCampo != "nId"){
                    $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdTipoTransacao."_".$_POST['fIdGrupoUsuario'],$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                    array_push($voTransacao,$oTransacao);
                }
            }

			$bResultado &= $oFachadaSeguranca->inserePermissao($oPermissao,$voTransacao,BANCO);
		}//if(count($voPermissaoAuxiliar) > 0){
	}
}else{
	$oFachadaSeguranca->desativaPermissaoPorGrupoUsuario($_POST['fIdGrupoUsuario'],BANCO);
	$sObjeto = "Usuário ".$_SESSION['oLoginAdm']->getUsuario()->getNmUsuario()." iniciou alteração de permissões para o Grupo de Usuários ".$sGrupoUsuarioAuxiliar.", entretanto não foram encontradas novas permissões para serem adicionadas, por isso, todas as permissões deste grupo estão desativadas!";
	$oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$_POST['fIdGrupoUsuario'],$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
	$oFachadaSeguranca->insereTransacao($oTransacao,BANCO);
}

if (!$bResultado){
	$sObjetoAcesso = "VERIFICAR: Usuário ".$_SESSION['oLoginAdm']->getUsuario()->getNmUsuario()." tentou alterar as permissões para o Grupo de Usuários ".$sGrupoUsuarioAuxiliar.", porém ocorreu um erro na alteração!";
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$_POST['fIdGrupoUsuario'],$sObjeto,"","","",IP_USUARIO,DATAHORA,1,1);
	$oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
	
	$_SESSION['sMsg'] = "Não foi possível alterar a permissão!";
	$sHeader = "permissao/insere_altera.php?bErro=1&nIdGrupoUsuario=".$_POST['fIdGrupoUsuario'];
} else {
	$_SESSION['sMsg'] = "Permissão alterada com sucesso!";
	$sHeader = "grupo_usuario/index.php?bErro=0";
}//if (!$bResultado){

header("Location: ".SITE."painel/administrativo/".$sHeader);
?>