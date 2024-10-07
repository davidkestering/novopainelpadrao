<?php

/* RECEIVE VALUE */
//$validateValue=$_POST['validateValue'];
//$validateId=$_POST['validateId'];
//$validateError=$_POST['validateError'];

/* RECEIVE VALUE */
$validateValue= (isset($_GET['fieldValue'])) ? $_GET['fieldValue'] : ((isset($_GET['fLogin']) && $_GET['fLogin'] != "") ? $_GET['fLogin'] : "") ;
$validateId= (isset($_GET['fieldId'])) ? $_GET['fieldId'] : "fLogin" ;
$nIdUsuario = (isset($_GET['fieldIdP'])) ? $_GET['fieldIdP'] : ((isset($_GET['fIdUsuario']) && $_GET['fIdUsuario'] != "" && $_GET['fIdUsuario'] != 0) ? $_GET['fIdUsuario'] : "");

$validateError= "Login de usuário já existente no banco de dados, por favor escolha outro!";
$validateSuccess= "Login disponível!";
$validateSuccess2= "O Login continua sendo o mesmo!";

/* RETURN VALUE */
$arrayToJs = array();
$arrayToJs[0] = $validateId;
$arrayToJs[1] = $validateError;
	
require_once("../../../../constantes.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSegurancaAux = new FachadaSegurancaBD();

$vWhereUsuarioAux = array("login = '".$validateValue."'","ativo = 1");
$sOrderUsuarioAux = "";
$voUsuarioAux = $oFachadaSegurancaAux->recuperaTodosUsuario(BANCO,$vWhereUsuarioAux,$sOrderUsuarioAux);

$oUsuarioAux = $oFachadaSegurancaAux->recuperaUsuario($nIdUsuario,BANCO);
$sLoginAux = "";
if(is_object($oUsuarioAux)){
	$sLoginAux = $oUsuarioAux->getLogin();
}

if(count($voUsuarioAux) > 0){
	if($sLoginAux == $voUsuarioAux[0]->getLogin()){
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

//echo '{"jsonValidateReturn":["'.$arrayToJs[0].'","'.$arrayToJs[1].'","'.$arrayToJs[2].'"]}';
echo '["'.$arrayToJs[0].'",'.$arrayToJs[2].',"'.$arrayToJs[1].'"]';


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