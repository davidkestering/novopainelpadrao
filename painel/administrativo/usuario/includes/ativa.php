<?php
require_once("../../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();
$sOP = "Desativar";

if(isset($_POST['id']) && $_POST['id'] != 0 && $_POST['id'] != ""){
    $oUsuarioAuxiliar = $oFachadaSeguranca->recuperaUsuario($_POST['id'],BANCO);
	$oUsuario = $oFachadaSeguranca->recuperaUsuario($_POST['id'],BANCO);
	if(is_object($oUsuario)){
		if($_POST['act'] == "ativarUsuario"){
			$oUsuario->setAtivo(1);
			$sTextoTransacao = "ativou";
			$sTextoFinal = "ativado";
		}else{
			$oUsuario->setAtivo(0);
			$sTextoTransacao = "desativou";
			$sTextoFinal = "desativado";
		}

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
		//$sConteudo = "Usuário ".$sTextoFinal." com sucesso!";
		$sConteudo = "1";
	}else{
		$sConteudo = "Usuário não encontrado!";
	}
}else{
	$sConteudo = "Problemas na execução, tente novamente!";
}
echo $sConteudo;
?>