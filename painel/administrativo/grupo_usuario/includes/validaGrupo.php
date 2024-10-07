<?php

/* RECEIVE VALUE */
//$validateValue=$_POST['validateValue'];
//$validateId=$_POST['validateId'];
//$validateError=$_POST['validateError'];

/* RECEIVE VALUE */
$validateValue= (isset($_GET['fieldValue'])) ? $_GET['fieldValue'] : ((isset($_GET['fNome']) && $_GET['fNome'] != "") ? $_GET['fNome'] : "");
$validateId= (isset($_GET['fieldId'])) ? $_GET['fieldId'] : "fNome" ;
$nIdGrupoUsuario = (isset($_GET['fieldIdP'])) ? $_GET['fieldIdP'] : ((isset($_GET['fIdGrupoUsuario']) && $_GET['fIdGrupoUsuario'] != "" && $_GET['fIdGrupoUsuario'] != 0) ? $_GET['fIdGrupoUsuario'] : "");

$validateError= "Grupo de Usuário já existente no banco de dados, por favor escolha outro nome!";
$validateSuccess= "Grupo de Usuário disponível!";
$validateSuccess2= "O Grupo de Usuário continua sendo o mesmo!";

/* RETURN VALUE */
$arrayToJs = array();
$arrayToJs[0] = $validateId;
$arrayToJs[1] = $validateError;
	
require_once("../../../../constantes.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSegurancaAux = new FachadaSegurancaBD();

$vWhereGrupoAux = array("nm_grupo_usuario = '".$validateValue."'","ativo = 1");
$sOrderGrupoAux = "";
$voGrupoAux = $oFachadaSegurancaAux->recuperaTodosGrupoUsuario(BANCO,$vWhereGrupoAux,$sOrderGrupoAux);

$oGrupoUsuarioAux = $oFachadaSegurancaAux->recuperaGrupoUsuario($nIdGrupoUsuario,BANCO);
$sGrupoUsuario = "";
if(is_object($oGrupoUsuarioAux)){
	$sGrupoUsuario = $oGrupoUsuarioAux->getNmGrupoUsuario();
}

if(count($voGrupoAux) > 0){
	if($sGrupoUsuario == $voGrupoAux[0]->getNmGrupoUsuario()){
		$arrayToJs[2] = "true";
		$arrayToJs[1] = $validateSuccess2;
	}else{
		$arrayToJs[2] = "false";
		$arrayToJs[1] = $validateError;
	}
}else{
	$arrayToJs[2] = "true";
	$arrayToJs[1] = $validateSuccess;
}

echo '["'.$arrayToJs[0].'",'.$arrayToJs[2].',"'.$arrayToJs[1].'"]';
//echo '["'.$arrayToJs[0].'",'.$arrayToJs[2].']';


/*if($validateValue =="karnius"){		// validate??
	$arrayToJs[2] = "true";			// RETURN TRUE
	echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';			// RETURN ARRAY WITH success
}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[2] = "false";
			echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';		// RETURN ARRAY WITH ERROR
		}
	}
}*/

?>