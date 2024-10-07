<?php
class Validacao {
	
 function validacpf($sCPF) {
   if ( strlen($sCPF) != 11 || $sCPF == "11111111111" || $sCPF == "22222222222" 
		|| $sCPF == "33333333333" || $sCPF == "44444444444"
		|| $sCPF == "55555555555" || $sCPF == "66666666666" 
		|| $sCPF == "77777777777" || $sCPF == "88888888888" 
		|| $sCPF == "99999999999" || $sCPF == "00000000000" ) {
     return false;
   }

   $nVar1 = 0;
   for ($i = 1; $i <= 9; $i++) {
     $nVar1 = $nVar1 + (int)$sCPF[$i - 1] * (11 - $i);
   }

   $nVar2 = 11 - ($nVar1 - ((int)($nVar1 / 11) * 11));
   if ($nVar2 == 10 || $nVar2 == 11) {
     $nVar2 = 0;
   }

   if ($nVar2 != (int)$sCPF[10 - 1]) {
    return false;
    }

   $nVar1 = 0;
   for ($i = 1; $i <= 10; $i++) {
     $nVar1 = $nVar1 + (int)$sCPF[$i - 1] * (12 - $i);
   }

   $nVar2 = 11 - ($nVar1 - ((int)($nVar1 / 11) * 11));
   if ($nVar2 == 10 || $nVar2 == 11) {
     $nVar2 = 0;
   }

   if ($nVar2 != (int)$sCPF[11 - 1]) {
     return false;
	 }

	  return true;
	}
	
	function validaCGC($sCGC) {
	  $strDigControle = substr($sCGC, -2);
	  $sCGC = substr($sCGC, 0, $bytNrCaracteres - 2);	
	
	  $intAuxB = 0;
	  for ($intAuxA = 0; $intAuxA < 4; $intAuxA++) {
  	  $intAuxB += intval(substr($sCGC, $intAuxA, 1)) * (6 - $intAuxA - 1);
	  }

	  for ($intAuxA = 0; $intAuxA < 8; $intAuxA++) {
  	  $intAuxB += intval(substr($sCGC, $intAuxA + 4, 1)) * (10 - $intAuxA - 1);
	  }

	  $intAuxC = $intAuxB % 11;
	  if ($intAuxC > 0) $intAuxC = 11 - $intAuxC;
  	$strChkControle = substr(ltrim(strval($intAuxC)), -1);

	  $intAuxB = 0;
  	$strAux = $sCGC . $strChkControle;
	  for ($intAuxA = 0; $intAuxA < 5; $intAuxA++) {
	    $intAuxB += intval(substr($strAux , $intAuxA, 1)) * (7 - $intAuxA - 1);
	  }
	  for ($intAuxA = 0; $intAuxA < 8; $intAuxA++) {
	    $intAuxB += intval(substr($strAux , $intAuxA + 5, 1)) * (10 - $intAuxA - 1);
  	}

	  $intAuxC = $intAuxB % 11;
  	if ($intAuxC > 0) {
	    $intAuxC = 11 - $intAuxC;
  	}

	  $strChkControle .= substr(ltrim(strval($intAuxC)), -1);

	  if ($strDigControle != $strChkControle) {
  	  return false;
	  } else {
	    return true;
	  }
	}


	function validaRG($sRG) {
	  $sPadraoRG = "^[0-9]+$";
	  if (!ereg($sPadraoRG, $sRG)) {
  	  return false;
	  } else {
	   return true;
	  }
	}

	function validaCEP($sCEP) {
	  $sPadraoCEP = "^[0-9]{5}-[0-9]{3}$";
	  if (!ereg($sPadraoCEP, $sCEP)) {
	    return false;
	  } else {
	    return true;
	  }
	}

	function verificaObjetoVazio($oObjeto,$sChave){
		$sMsg = "";
		$sMsgFinal = "";
		$vObjeto = get_object_vars($oObjeto);
		$vChave  = explode(",",$sChave);
		foreach($vObjeto as $sAtributo => $sValor){
			if (!in_array($sAtributo,$vChave)){
				if ($this->verificaVazio($sValor)){
					$sMsg .= "$sAtributo,\n";
				}
			}
		}
		$sMsg = substr($sMsg,0,strlen($sMsg) - 2);
		if ($sMsg){
			$sMsgFinal = "O(s) seguinte(s) campo(s) precisa(m) ser preenchido(s):\n".$sMsg;
		}
		return $sMsgFinal;
	}
	
	function verificaVazio($sCampo){
		if ($sCampo == ""){
			return true;
		}
		return false;
	}


	function validaData($dData) {
	  $dData = trim($dData);
	  $sPadrao = "^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$";
	  if (!ereg($sPadrao, $dData, $vData)) {
	     return false;
	  } else {
	    $dDataValida = date("d/m/Y", mktime(0, 0, 0, $vData[2], $vData[1], $vData[3]));
	    $dData = sprintf("%02s", $vData[1]) . "/" . sprintf("%02s", $vData[2]) . "/" . $vData[3];
	    if ($dData != $dDataValida) {
	      return false;
	    } else {
	      return true;
	    }
	  }
	}
	
    function printvar($args)
    {		
        $args = func_get_args();
        $dbt = debug_backtrace();
        $linha   = $dbt[0]['line']; 
        $arquivo = $dbt[0]['file'];
        echo "<fieldset style='border:1px solid; border-color:#F00;background-color:#FFF000;legend'><b>Arquivo:</b>".$arquivo."<b><br>Linha:</b><legend><b>Debug On : printvar ( )</b></legend> $linha</fieldset>";
        
        $args = func_get_args();				
        foreach($args as $idx=> $arg)
        {
            echo "<fieldset style='background-color:#CBA; border:1px solid; border-color:#00F;'><legend><b>ARG[$idx]</b></legend>";			
			echo "<pre style='background-color:#CBA; width:100%; heigth:100%;'>";
            print_r($arg);
			echo "</pre>";
            echo "</fieldset><br>";
        }
    }
    
    function printvardie($args) {
        $args = func_get_args();
        $dbt = debug_backtrace();
        $linha   = $dbt[0]['line']; 
        $arquivo = $dbt[0]['file'];
        echo "<fieldset style='border:1px solid; border-color:#F00;background-color:#FFF000;legend'><b>Arquivo:</b>".$arquivo."<b><br>Linha:</b><legend><b>Debug On : printvardie ( )</b></legend> $linha</fieldset>";
        
        foreach($args as $idx=> $arg)
        {
            echo "<fieldset style='background-color:#CBA; border:1px solid; border-color:#00F;'><legend><b>ARG[$idx]</b></legend>";			
			echo "<pre style='background-color:#CBA; width:100%; heigth:100%;'>";
            print_r($arg);
            echo "</pre>";
            echo "</fieldset><br>";
        }
        die();
    }

    /**
     *  Mesma funcao do printvar mas não imprime com formatacao html
     * facilitando a exibicao no firebug
     * @param <type> $args
     * @since 27/05/2009
     * @author Philipe Barra
     */
    function printVarAjax($args) {
        $args = func_get_args();
        $dbt = debug_backtrace();
        $linha   = $dbt[0]['line'];
        $arquivo = $dbt[0]['file'];
        echo "=================================================================================\n";
        echo "Arquivo:".$arquivo."\nLinha:$linha\nDebug On : printvarajax ( )\n";
		echo "=================================================================================\n";
		
        foreach($args as $idx=> $arg)
        {
            echo "-----  ARG[$idx]  -----\n";
            print_r($arg);
            echo "\n \n";
        }
    }

    /**
     *  Mesma funcao do printdie mas não imprime com formatacao html
     * facilitando a exibicao no firebug
     * @param <type> $args
     * @since 25/05/2009
     * @author Philipe Barra
     */
    function printVarDieAjax($args) {
        $args = func_get_args();
        $dbt = debug_backtrace();
        $linha   = $dbt[0]['line'];
        $arquivo = $dbt[0]['file'];
        echo "=================================================================================\n";
        echo "Arquivo:".$arquivo."\nLinha:$linha\nDebug On : printvardieajax ( )\n";
		echo "=================================================================================\n";
		
        foreach($args as $idx=> $arg)
        {
            echo "-----  ARG[$idx]  -----\n";
            print_r($arg);
            echo "\n \n";
        }
        die();
    }

}
?>
