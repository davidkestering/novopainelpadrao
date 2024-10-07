<?php
class Data{
        
	/**
	* nDia
	* @access private
	*/
	var $nDia;
	/**
	* nMes
	* @access private
	*/
	var $nMes;
	/**
	* nAno
	* @access private
	*/
	var $nAno;
	/**
	* dData
	* @access private
	*/
	var $dData;
	/**
	* sFormato
	* @access private
	*/
	var $sFormato;
	/**
	* sSeparador
	* @access private
	*/
	var $sSeparador;
	
	
	/**
	* Construtor de Data
	* @param $dData dData
	* @param $sFormato sFormato	
	*/
	function Data($dData = "",$sFormato = "d/m/Y"){		
		if($dData) {
			$this->setData($dData,$sFormato);
		}
	}
	
	/**
	* Recupera o valor do atributo $nDia. 
	* @return $nDia nDia
	*/
	function getDia(){
		return $this->nDia;
	}
	
	/**
	* Atribui valor ao atributo $nDia. 
	* @param $nDia nDia
	* @access public
	*/
	function setDia($nDia){
		$this->nDia = $nDia;
	}
	
	/**
	* Recupera o valor do atributo $nMes. 
	* @return $nMes nMes
	*/
	function getMes(){
		return $this->nMes;
	}
	
	/**
	* Atribui valor ao atributo $nMes. 
	* @param $nMes nMes
	* @access public
	*/
	function setMes($nMes){
		$this->nMes = $nMes;
	}
		
	/**
	* Recupera o valor do atributo $nAno. 
	* @return $nAno nAno
	*/
	function getAno(){
		return $this->nAno;
	}
	
	/**
	* Atribui valor ao atributo $nAno. 
	* @param $nAno nAno
	* @access public
	*/
	function setAno($nAno){
		$this->nAno = $nAno;
	}
	
	/**
	* Recupera o valor do atributo $dData. 
	* @return $dData dData
	*/
	function getData(){
		return $this->dData;
	}
	
	/**
	* Atribui valor ao atributo $dData. 
	* @param $dData dData
	* @access public
	*/
	function setData($dData = "",$sFormato = "d/m/Y"){
		if($this->validaFormato($sFormato)){					
			$vData = explode($this->getSeparador(),$dData);
			$vFormato = explode($this->getSeparador(),$sFormato);
	
			foreach($vFormato as $nIndice => $sAtributo){
				switch($sAtributo){
					case "d":
						if(isset($vData[$nIndice]))
							$this->setDia($vData[$nIndice]);
					break;
					case "m":
						if(isset($vData[$nIndice]))
							$this->setMes($vData[$nIndice]);
					break;
					case "Y":
						if(isset($vData[$nIndice]))
							$this->setAno($vData[$nIndice]);
					break;
				}
			}
			$vPadraoFormato = array("/d/","/m/","/Y/");
			$vValoresData = array($this->getDia(),$this->getMes(),$this->getAno());
			$this->dData = preg_replace($vPadraoFormato,$vValoresData,$sFormato);
			$this->setFormato($sFormato);
		}
	}
	
	/**
	* Recupera o valor do atributo $sFormato. 
	* @return $sFormato sFormato
	*/
	function getFormato(){
		return $this->sFormato;
	}
	
	/**
	* Atribui valor ao atributo $sFormato. 
	* @param $sFormato sFormato
	* @access public
	*/
	function setFormato($sFormato = "d/m/Y"){
		if($this->validaFormato($sFormato)){
			$vPadraoFormato = array("/d/","/m/","/Y/");
			$vValoresData = array($this->getDia(),$this->getMes(),$this->getAno());
			$this->dData = preg_replace($vPadraoFormato,$vValoresData,$sFormato);
			$this->sFormato = $sFormato;
		}
	}
	
	/**
	* Recupera o valor do atributo $sSeparador. 
	* @return $sSeparador sSeparador
	*/
	function getSeparador(){
		return $this->sSeparador;
	}
	
	/**
	* Atribui valor ao atributo $sSeparador. 
	* @param $sSeparador sSeparador
	* @access public
	*/
	function setSeparador($sSeparador = "/"){
		$this->sSeparador = $sSeparador;
	}

	/**
	* Recupera o valor do mês por extenso.
	* @access public
	*/
	function getMesExtenso(){
		switch($this->nMes){
			case 1:
				$sMes = "Janeiro";
			break;
			case 2:
				$sMes = "Fevereiro";
			break;
			case 3:
				$sMes = "Março";
			break;
			case 4:
				$sMes = "Abril";
			break;
			case 5:
				$sMes = "Maio";
			break;
			case 6:
				$sMes = "Junho";
			break;
			case 7:
				$sMes = "Julho";
			break;
			case 8:
				$sMes = "Agosto";
			break;
			case 9:
				$sMes = "Setembro";
			break;
			case 10:
				$sMes = "Outubro";
			break;
			case 11:
				$sMes = "Novembro";
			break;
			case 12:
				$sMes = "Dezembro";
			break;
		}
		return $sMes;
	}
	
	/**
	* Valida o atributo $sFormato. 
	* @param $sFormato sFormato
	* @access public
	*/
	function validaFormato($sFormato = "d/m/Y"){
		if(!preg_match("/^[d,m,Y]+(\W)[d,m,Y]+(\W)[d,m,Y]$/",$sFormato,$vSeparador))
			return false;
		
		if($vSeparador[1] != $vSeparador[2])
			return false;
			
		$this->setSeparador($vSeparador[1]);			
		return true;
	}

	/**
	* Valida a Data. 
	* @access public
	*/
	function validaData(){
		return checkdate((int) $this->getMes(),(int) $this->getDia(),(int) $this->getAno());
	}
	
	/**
	* Calcula a diferença entre duas datas, necessariamente em formato americano. 
	* @param $dDataInicial dDataInicial
	* @param $dDataFinal dDataFinal
	* @access public
	*/
	function calculaDiferenca($dDataInicial,$dDataFinal){
		// PEGA AS DATAS INICIAL E FINAL EM TIMESTAMP E CALCULA O NÚMERO DE SEGUNDOS ENTRE AS DATAS
		$nDataInicial = strtotime($dDataInicial);
		$nDataFinal = strtotime($dDataFinal);
		$nSegundos = $nDataFinal - $nDataInicial;
		
		// CALCULA A QUANTIDADE DE DIAS DIVIDINDO OS SEGUNDOS PELO NÚMERO DE SEGUNDOS DE UM DIA
		// COM O RESTO DOS SEGUNDOS CALCULA A QUANTIDADE DE HORAS E ASSIM SUCESSIVAMENTE
		//  ATÉ SE OBTER O NÚMERO DE SEGUNDOS
		$nAnos = round($nSegundos / 31104000);
		//$nSegundos = $nSegundos % 31104000;
		$nMeses = round($nSegundos / 2592000);
		//$nSegundos = $nSegundos % 2592000;
		$nDias    = round($nSegundos / 86400);
		//$nSegundos = $nSegundos % 86400;
		$nHoras   = round($nSegundos / 3600);
		//$nSegundos = $nSegundos % 3600;
		$nMinutos = round($nSegundos / 60);
		//$nSegundos = $nSegundos % 60;
		
		$vResultado['ANOS'] = $nAnos;
		$vResultado['MESES'] = $nMeses;
		$vResultado['DIAS'] = $nDias;
		$vResultado['HORAS'] = $nHoras;
		$vResultado['MINUTOS'] = $nMinutos;
		$vResultado['SEGUNDOS'] = $nSegundos;
		
		return $vResultado;
	}

	/**
	* Calcula a idade. 
	* @access public
	*/
	function calculaIdade(){
		$nMes = $this->getMes();
		$nDia = $this->getDia();
		$nAno = $this->getAno();
		if (checkdate($nMes,$nDia,$nAno)){
			$nDiaAtual = date("d");
			$nMesAtual = date("m");
			$nAnoAtual = date("Y");
			$nIdadeTemp = $nAnoAtual - $nAno;
			if($nMesAtual < $nMes){
				$nIdadeTemp--;
			} elseif($nMesAtual == $nMes){
				if ($nDiaAtual < $nDia){
					$nIdadeTemp--;
				}
			}
			return $nIdadeTemp;
		}
		return false;
	}

	/**
	* Avança a data de acordo com o número de dias passado como parâmetro. 
	* @param $nDias nDias
	* @access public
	*/
	function avancaMes($nMeses){
		
		// TROCA O FORMATO PARA O PADRÃO AMERICANO E SOMA OS DIAS
		$sFormatoOriginal = $this->getFormato();
		$this->setFormato("m/d/Y");
		$dDataTimestamp = strtotime($this->getData());				
		$nMeses *= (86400 * 30);
		$dDataTimestampFinal = $dDataTimestamp + $nMeses;
		
		// RETORNA PARA O FORMATO ORIGINAL E SETA O ATRIBUTO $dData
		$vPadraoFormato = array("/d/","/m/","/Y/");
		$vFormatoStrtime = array("%d","%m","%Y");
		$sFormatoStrtime = preg_replace($vPadraoFormato,$vFormatoStrtime,$sFormatoOriginal);		
		$this->setData(strftime($sFormatoStrtime,$dDataTimestampFinal),$sFormatoOriginal);
	}

	/**
	* Avança a data de acordo com o número de dias passado como parâmetro. 
	* @param $nDias nDias
	* @access public
	*/
	function avancaData($nDias){
		
		// TROCA O FORMATO PARA O PADRÃO AMERICANO E SOMA OS DIAS
		$sFormatoOriginal = $this->getFormato();
		$this->setFormato("m/d/Y");
		$dDataTimestamp = strtotime($this->getData());				
		$nDias *= 86400;
		$dDataTimestampFinal = $dDataTimestamp + $nDias;
		
		// RETORNA PARA O FORMATO ORIGINAL E SETA O ATRIBUTO $dData
		$vPadraoFormato = array("/d/","/m/","/Y/");
		$vFormatoStrtime = array("%d","%m","%Y");
		$sFormatoStrtime = preg_replace($vPadraoFormato,$vFormatoStrtime,$sFormatoOriginal);		
		$this->setData(strftime($sFormatoStrtime,$dDataTimestampFinal),$sFormatoOriginal);
	}
	
	/**
	* Avança a data de acordo com o número de dias passado como parâmetro. 
	* @param $nDias nDias
	* @access public
	*/
	function avancaHora($nHoras,$dDataHora){
		
		// TROCA O FORMATO PARA O PADRÃO AMERICANO E SOMA OS DIAS
		$sFormatoOriginal = "Y-m-d H:M:S";
		$dDataTimestamp = strtotime($dDataHora);
		$nHoras *= 86400/24;
		$dDataTimestampFinal = $dDataTimestamp + $nHoras;
		//echo $dDataTimestampFinal;

		// RETORNA PARA O FORMATO ORIGINAL E SETA O ATRIBUTO $dData
		$vPadraoFormato = array("/d/","/m/","/Y/","/H/","/M/","/S/");
		$vFormatoStrtime = array("%d","%m","%Y","%H","%M","%S");
		$sFormatoStrtime = preg_replace($vPadraoFormato,$vFormatoStrtime,$sFormatoOriginal);
		$dDataHora = (strftime($sFormatoStrtime,$dDataTimestampFinal));
		return $dDataHora;
	}
	
	//FUNCAO PARA CONVERTER MILESIMOS EM TEMPO (HORAS:MINUTOS:SEGUNDOS:MILESIMOS)
	function transforma($milesimos) {
		// cria a string de saída
		$tempo = "";
		
		// acha as horas e intval retorna o valor int da variável
		$hora = intval($milesimos / 3600000);
		
		// se hora for maior que zero concatena na variável tempo
		if ($hora > 0)
			$tempo .= str_pad($hora, 2, "0", STR_PAD_LEFT). 'h';
		
		// acha os minutos
		$minutos = intval(($milesimos / 60000) % 60);
		
		// se minutos for maior que zero concatena na variável tempo
		if ($minutos > 0)
			$tempo .= str_pad($minutos, 2, "0", STR_PAD_LEFT). 'm';
		
		// acha os segundos
		$segundos = intval(($milesimos / 1000) % 60);
		
		// se segundos for maior que zero concatena na variável tempo
		if ($segundos > 0)
			$tempo .= str_pad($segundos, 2, "0", STR_PAD_LEFT) . 's';
		
		// adiciona o resto de milésimos
		$mil = intval($milesimos % 1000);
		
		// se milesimos for maior que zero concatena na variável tempo
		if ($mil > 0)
			$tempo .= str_pad($mil, 3, "0", STR_PAD_LEFT);
		
		// saida formatada!
		return $tempo;
	}

}
?>