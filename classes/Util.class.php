<?php
class Util {
	
	var $dia = "";
	var	$mes = "";
	var	$ano = "";
	
	function Util() {
	}
	
	static function getMsg($mod) { 
		
		switch ($mod) {
			case "S" :
				$msg = "A operação foi realizada com sucesso.";
				break;
			case "E" :
				$msg = "A operação não foi realizada com sucesso!";
				break;
			case "N" :
				$msg = "Nenhum registro foi encontrado, verifique os dados informados!";
				break;
		}
		
		return $msg;
	
	}
	
	static function getDataAtual() {
		return date ( "Y-m-d" );
	}
	
	static function getHoraAtual() {
		return date ( "H:i:s" );
	}
	
	static function converteData($data) {
		//return $this->converteAmdParaDma($data);
		return Util::converteAmdParaDma ( $data );
	}
	
	static function converteDataBanco($data) {
		//return $this->converteDmaParaAmd($data);
		return Util::converteDmaParaAmd ( $data );
	}
	
	static function converteMdaParaDma(&$data) {
		$data = substr ( $data, 0, 10 );
		$vData = explode ( "-", $data );
		$data = $vData[1] . "/" . $$vData[0] . "/" . $vData[2];
		return $data;
	}
	
	static function converteDmaParaMda(&$data) {
		$data = substr ( $data, 0, 10 );
		$vData = explode ( "/", $data );
		$data = $vData[1] . "/" . $vData[0] . "/" . $vData[2];
		return $data;
	}
	
	static function converteDmaParaAmd(&$data) {
		$data = substr ( $data, 0, 10 );
		$vData = explode ( "/", $data );
		$data = $vData[2] . "-" . $vData[1] . "-" . $vData[0];
		return $data;
	}
	
	static function converteDmaParaAmdComHora(&$data) {
		$tmp = explode(" ",$data);
		$data = substr ( $data, 0, 10 );
		$vData = explode ( "/", $data );
		$data = $vData[2] . "-" . $vData[1] . "-" . $vData[0] . " " . $tmp[1];
		return $data;
	}
	
	static function converteAmdParaDma(&$data) {
		$data = substr ( $data, 0, 10 );
		$vData = explode ( "-", $data );
		$data = $vData[2] . "/" . $vData[1] . "/" . $vData[0];
		return $data;
	}
	
	static function converteAmdParaDmaComHora(&$data) {
		$tmp = explode(" ",$data);
		$data = $tmp[0];
		$data = substr ( $data, 0, 10 );
		$vData = explode ( "-", $data );
		$data = $vData[2] . "/" . $vData[1] . "/" . $vData[0];
		return $data." ".$tmp[1];
	}
	
	## funÃ§Ãµes de formataÃ§Ã£o e tratamento de strings
	static function forValorBanco($valor) {
		return str_replace ( ",", ".", $valor );
	}
	
	static function forValor($valor) {
		return str_replace ( ".", ",", $valor );
	}
	
	static function forStringBanco($str) {
		$str = addslashes ( $str );
		return $str;
	}
	
	static function forString($str) {
		$str = stripslashes ( $str );
		return $str;
	}
	
	static function encode() {
		$vetParametros = func_get_args ();
		while ( $parametro = array_shift ( $vetParametros ) ) {
			$vetEncode [] .= urlencode ( $parametro );
		}
		return implode ( "|", $vetEncode );
	}
	
	static function decode($codigo) {
		$vetVarDecode = explode ( "|", $codigo );
		while ( $varDecode = urldecode ( array_shift ( $vetVarDecode ) ) ) {
			$vetVar [] = $varDecode;
		}
		return $vetVar;
	}
	
	static function iterateMenu($vetor, $atributoLabel, $atributoValor = false, $valorPadrao = false) {
		foreach ( $vetor as $objeto ) {
			$strValor = "\$objeto->get" . (($atributoValor) ? $atributoValor : $atributoLabel) . "()";
			if (is_array ( $atributoLabel ))
				for($i = 0; $i < count ( $atributoLabel ); $i ++)
					$strLabel .= "\$objeto->get" . $atributoLabel [$i] . "()" . (($i == count ( $atributoLabel ) - 1) ? '' : '." - ".');
			else
				$strLabel = "\$objeto->get" . $atributoLabel . "()";
			
			eval ( "\$strValor = $strValor;" );
			eval ( "\$strLabel = $strLabel;" );
			print "<option value='" . $strValor . "'" . (($valorPadrao) ? (($strValor == $valorPadrao) ? "selected " : "") : '') . " >" . $strLabel . "</option>\n";
			$strLabel = '';
		}
	}
	
	static function viewAgregation($pk, $nameObject, $property) {
		if (is_array ( $pk ))
			$pk = implode ( ",", $pk );
		eval ( "\$object = Fachada::get$nameObject($pk);" );
		if ($object)
			eval ( "\$valor = \$object->get$property();" );
		return $valor;
	}
	
	static function saudacao($nome = '') {
	   date_default_timezone_set('America/Sao_Paulo');
	   $hora = date('H');
	   if( $hora >= 6 && $hora <= 12 )
		  return 'Bom dia' . (empty($nome) ? '' : ', ' . $nome);
	   else if ( $hora > 12 && $hora <=18  )
		  return 'Boa tarde' . (empty($nome) ? '' : ', ' . $nome);
	   else
		  return 'Boa noite' . (empty($nome) ? '' : ', ' . $nome);
	}
	
	static function criaIntervaloDatas($dtini,$dtfim) {
	  $aryRange=array();
	
	  $iDateFrom=mktime(1,0,0,substr($dtini,5,2),substr($dtini,8,2),substr($dtini,0,4));
	  $iDateTo=mktime(1,0,0,substr($dtfim,5,2),substr($dtfim,8,2),substr($dtfim,0,4));
	
	  if ($iDateTo>=$iDateFrom) {
		array_push($aryRange,date('Y-m-d',$iDateFrom));
	
		while ($iDateFrom<$iDateTo) {
		  $iDateFrom+=86400;
		  array_push($aryRange,date('Y-m-d',$iDateFrom));
		}
	  }
	  return $aryRange;
	}
}
?>