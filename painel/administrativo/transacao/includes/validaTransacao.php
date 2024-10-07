<?php

/* RECEIVE VALUE */
//$validateValue=$_POST['validateValue'];
//$validateId=$_POST['validateId'];
//$validateError=$_POST['validateError'];

//print_r($_GET);

/* RECEIVE VALUE */
$sContador = (isset($_GET['fieldIdP'])) ? $_GET['fieldIdP'] : "0_0";
if($sContador != "" && $sContador != "0_0"){
	$vDados = explode("_",$sContador);
	$nIdCategoriaTipoTransacao = $vDados[0];
	$nContador = $vDados[1];
}else{
	$arrayToJs[2] = "false";
	$arrayToJs[1] = "Erro ao passar os dados da Categoria de Tipo de Transação";
}

$validateValue= (isset($_GET['fieldValue'])) ? $_GET['fieldValue'] : ((isset($_GET['fTipoTransacaoNova'.$nContador]) && $_GET['fTipoTransacaoNova'.$nContador] != "") ? $_GET['fTipoTransacaoNova'.$nContador] : "");
$validateId= (isset($_GET['fieldId'])) ? $_GET['fieldId'] : "fTipoTransacaoNova".$nContador ;

/* RETURN VALUE */
$validateError= "Tipo de Transação já existente no banco de dados, por favor escolha outro nome!";
$validateSuccess= "Tipo de Transação disponível!";

$arrayToJs = array();
$arrayToJs[0] = $validateId;
$arrayToJs[1] = $validateError;
	
require_once("../../../../constantes.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");

$oFachadaSegurancaAux = new FachadaSegurancaBD();

$vWhereTipoTransacaoAux = array("transacao = '".$validateValue."'","id_categoria_tipo_transacao = '".$nIdCategoriaTipoTransacao."'","ativo = 1");
$sOrderTipoTransacaoAux = "";
$voTipoTransacaoAux = $oFachadaSegurancaAux->recuperaTodosTipoTransacao(BANCO,$vWhereTipoTransacaoAux,$sOrderTipoTransacaoAux);

if(count($voTipoTransacaoAux) > 0){
	$arrayToJs[2] = "false";
	$arrayToJs[1] = $validateError;
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