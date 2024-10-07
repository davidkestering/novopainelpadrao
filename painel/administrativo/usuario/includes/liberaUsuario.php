<?php
require_once("../../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();
$sOP = "Alterar";

if(isset($_POST['id']) && $_POST['id'] != 0 && $_POST['id'] != ""){
	if(isset($_POST['act']) && $_POST['act'] == "liberarUsuario"){
        $oUsuarioAuxiliar = $oFachadaSeguranca->recuperaUsuario($_POST['id'],BANCO);
		$oUsuario = $oFachadaSeguranca->recuperaUsuario($_POST['id'],BANCO);
		if(is_object($oUsuario)){
			$oUsuario->setLogado(0);

            $nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Usuario",$sOP,BANCO);

            // TRANSACAO
            $vObjetoModificado=array_diff_assoc((array)$oUsuario,(array)$oUsuarioAuxiliar);
            //$voCampos = get_object_vars($oUsuarioAuxiliar);
            $vObjetoAntigo = (array)$oUsuarioAuxiliar;
            $voTransacao = array();
            foreach($vObjetoModificado as $sCampo => $sValor){
                $sValorAntigo = $vObjetoAntigo[$sCampo];
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oUsuarioAuxiliar->getId(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacao,$oTransacao);
            }

			$oFachadaSeguranca->alteraUsuario($oUsuario,$voTransacao,BANCO);
			$oUsuarioAuxiliar = $oFachadaSeguranca->recuperaUsuario($oUsuario->getId(),BANCO);
			if(is_object($oUsuarioAuxiliar) && $oUsuarioAuxiliar->getLogado() == 0){
				$sConteudo = "1";
			}else{
				$sConteudo = "Não foi possível liberar o usuário!";
			}
		}else{
			$sConteudo = "Usuário não encontrado!";
		}
	}//if(isset($_POST['act']) && $_POST['act'] == "liberarUsuario"){
}else{
	$sConteudo = "Problemas na execução, tente novamente!";
}//if(isset($_POST['id']) && $_POST['id'] != 0 && $_POST['id'] != ""){
echo $sConteudo;
?>