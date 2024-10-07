<?php
require_once("../../constantes.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();

if(isset($_POST['fIdUsuario']) && $_POST['fIdUsuario'] != 0 && $_POST['fIdUsuario'] != ""){
	$oUsuario = $oFachadaSeguranca->recuperaUsuario($_POST['fIdUsuario'],BANCO);
	if(is_object($oUsuario)){
		$oUsuario->setLogado(0);
		$nIdTipoTransacaoLogado = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Usuario","Alterar",BANCO);
		$sObjetoLogado = "Usuário ".$oUsuario->getNmUsuario()." liberou a disponibilidade de novo login para o usuário: ".$oUsuario->getLogin();
		$oTransacaoLogado = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoLogado,$oUsuario->getId(),$sObjetoLogado,"","","",IP_USUARIO,DATAHORA,1,1);
		$oFachadaSeguranca->alteraUsuario($oUsuario,$oTransacaoLogado,BANCO);
		$oUsuarioAuxiliar = $oFachadaSeguranca->recuperaUsuario($oUsuario->getId(),BANCO);
		if(is_object($oUsuarioAuxiliar) && $oUsuarioAuxiliar->getLogado() == 0){
			$sConteudo = "Usuário liberado com sucesso!";
		}else{
			$sConteudo = "Não foi possível liberar o usuário!";
		}
	}else{
		$sConteudo = "Usuário não encontrado!";
	}
}else{
	$sConteudo = "Problemas na execução, tente novamente!";
}
echo $sConteudo;
?>