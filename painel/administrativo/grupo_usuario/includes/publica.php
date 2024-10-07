<?php
require_once("../../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();
$sOP = "Alterar";

if(isset($_POST['id']) && $_POST['id'] != 0 && $_POST['id'] != ""){
    $oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($_POST['id'],BANCO);
	$oGrupoUsuario = $oFachadaSeguranca->recuperaGrupoUsuario($_POST['id'],BANCO);
	if(is_object($oGrupoUsuario)){
		if($_POST['act'] == "publicarGrupoUsuario"){
			$oGrupoUsuario->setPublicado(1);
			$sTextoTransacao = "publicou";
			$sTextoFinal = "publicado";
		}else{
			$oGrupoUsuario->setPublicado(0);
			$sTextoTransacao = "despublicou";
			$sTextoFinal = "despublicado";
		}

        $nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Grupos",$sOP,BANCO);

        // TRANSACAO
        $vObjetoModificado=array_diff_assoc((array)$oGrupoUsuario,(array)$oGrupoUsuarioAuxiliar);
        //$voCampos = get_object_vars($oGrupoUsuarioAuxiliar);
        $vObjetoAntigo = (array)$oGrupoUsuarioAuxiliar;
        $voTransacao = array();
        foreach($vObjetoModificado as $sCampo => $sValor){
            $sValorAntigo = $vObjetoAntigo[$sCampo];
            $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oGrupoUsuarioAuxiliar->getId(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
            array_push($voTransacao,$oTransacao);
        }

		$oFachadaSeguranca->alteraGrupoUsuario($oGrupoUsuario,$voTransacao,BANCO);
		//$sConteudo = "Grupo de Usuários ".$sTextoFinal." com sucesso!";
		$sConteudo = "1";
	}else{
		$sConteudo = "Grupo de Usuários não encontrado!";
	}
}else{
	$sConteudo = "Problemas na execução, tente novamente!";
}
echo $sConteudo;
?>