<?php
class Paginacao {
	
	# Número da Página atual da paginação
	var $nPaginaAtual;
	
	# Número do registro inicial a ser exibido
	var $nRegistroInicial;
	
	# Número de registros a serem exibidos por página
	var $nRegistrosPorPagina;
	
	# Quantidade de Páginas de acordo com o número de registros por página.
	var $nQuantidadePaginas;
	
	# Nome do script onde os resultados da consulta estão sendo exibidos.
	var $sNomePaginaOrigem;
	
	# Nome da variável que será passada pelo método GET e conterá o número da página a ser exibida.
	var $sNomeVariavelDePaginas;
	
	var $nTotalRegistros;
	
	# Construtor da Classe
	function Paginacao($nRegistrosPorPagina){	
		if (isset($nRegistrosPorPagina) && $nRegistrosPorPagina == 0){
			die("O número de registros por página não pode ser zero!");
		} else {
			# Poderia ter sido declarado como constante.
			$this->setNomeVariavelDePaginas("p");
			$this->setPaginaAtual();
			$this->setRegistrosPorPagina($nRegistrosPorPagina);
			$this->setRegistroInicial();
			$this->setNomePaginaOrigem($_SERVER['PHP_SELF']);
		}
		
	}
	
	# Define o valor do atributo $nPaginaAtual.
	function setPaginaAtual(){
		global $_GET,$_POST;
		
		if (count($_GET) > 0){
			$vVetorLoop = $_GET;
		} else {
			if(count($_POST) > 0){
				$vVetorLoop = $_POST;
			}
		}
		
		if (isset($vVetorLoop)){
			$bAchou = false;
			foreach($vVetorLoop as $sNomeVariavel => $sValorVariavel){
				if ($sNomeVariavel == $this->sNomeVariavelDePaginas){
					$this->nPaginaAtual = $sValorVariavel;
					$bAchou = true;
					break;
				}//if ($sNomeVariavel == $this->sNomeVariavelDePaginas){			
			}//foreach($vVetorLoop as $sNomeVariavel => $sValorVariavel){
			
			if (!$bAchou){
				$this->nPaginaAtual = 1;
			}
		} else {//if ($vVetorLoop){
			$this->nPaginaAtual = 1;
		}//
	}

	# Define o valor do atributo $nRegistrosPorPagina
	function setRegistrosPorPagina($nRegistrosPorPagina){
		$this->nRegistrosPorPagina = $nRegistrosPorPagina;
	}

	# Define o valor do atributo $nRegistrosPorPagina
	function getRegistrosPorPagina(){
		return $this->nRegistrosPorPagina;
	}

	# Define o valor do atributo $nRegistrosPorPagina
	function getQuantidadePaginas(){
		return $this->nQuantidadePaginas;
	}

	# Define o valor do atributo $nRegistrosPorPagina
	function setTotalRegistros($nTotalRegistros){
		$this->nTotalRegistros = $nTotalRegistros;
	}

	# Define o valor do atributo $nTotalRegistros
	function getTotalRegistros(){
		return $this->nTotalRegistros;
	}

	# Define o valor do atributo $nRegistroInicial
	function setRegistroInicial(){
		$this->nRegistroInicial = ($this->nPaginaAtual - 1) + ($this->nRegistrosPorPagina * ($this->nPaginaAtual - 1));
		($this->nRegistroInicial > 0) ? ($this->nRegistroInicial = $this->nRegistroInicial - ($this->nPaginaAtual - 1)) : ($this->nRegistroInicial = 0);
		//($this->nRegistroInicial > 0) ? ($this->nRegistroInicial = $this->nRegistroInicial - 1) : ($this->nRegistroInicial = 0);
		
	}
	
	# Define o valor do atributo $nQuantidadeDePaginas.
	function setQuantidadeDePaginas($vResultado){
		$this->nQuantidadePaginas = (count($vResultado) > 0) ?  (ceil(count($vResultado)/$this->nRegistrosPorPagina)) : 1;
	}
	
	# Define o valor do atributo $sNomeVariavelDePaginas.
	function setNomeVariavelDePaginas($sNomeVariavel){
		$this->sNomeVariavelDePaginas = $sNomeVariavel;
	}
	
	
	# Retorna a string que deve ser passada pelo método GET para exibição de uma determinada página.
	
	/*
	Esse método verifica se a página que está exibindo os resultados da paginação foi chamada pelo 
	método POST ou GET. Depois varre o vetor referente aos parâmetros passados à página( por um dos
	métodos mencionados) e monta uma string para ser passada pelo método GET, com os parâmetros 
	necessários a realização da consulta, ou seja, todos os parâmetros passados a página, com 
	exceção do número da página ( ou seja o parâmetro "p").
	*/
	
	function retornaStringProLink(){
		global $_POST,$_GET;
		
		$bExecutaLoop = true;
		
		if (count($_POST) > 0){
		 	$vNomeVetorLoop = $_POST;
		} elseif(count($_GET) > 0) {
			$vNomeVetorLoop = $_GET;		
		} else {
			$bExecutaLoop = false;
		}
		if ($bExecutaLoop){		
			foreach($vNomeVetorLoop as $sNomeVariavel => $sValorVariavel){				
				if ($sNomeVariavel != $this->sNomeVariavelDePaginas){					
					global $$sNomeVariavel;
					if (!is_array($$sNomeVariavel)){
						$sVariaveis .= $sNomeVariavel . "=" . $sValorVariavel . "&";
					}
				}
			}
					
			$sVariaveis = substr($sVariaveis,0,strlen($sVariaveis) - 1);
			$sVariaveis = "&" . $sVariaveis;
		}
		
		return $sVariaveis;	
	}
	
	# Define o valor do atributo $sNomePaginaOrigem.
	
	function setNomePaginaOrigem($sNomePaginaOrigem){
		$vNomePaginaOrigem = explode("/",$sNomePaginaOrigem);
		$this->sNomePaginaOrigem = $vNomePaginaOrigem[count($vNomePaginaOrigem) - 1];
	}
	
    /*Monta a linha com o número das páginas disponíveis para a visualização, cada um com um link para a página
	  onde estão sendo exibidos os resultados($sNomePaginaOrigem) e os parâmetros necessários à realização da
	  consulta. Sendo que a página atual virá apenas em negrito e sem link.*/
	function retornaLinhaDeLinksAntigo(){
		global $_GET;
		$sLinhaPaginacao = (isset($sLinhaPaginacao) && $sLinhaPaginacao != "") ? $sLinhaPaginacao : "";
		for($i = 1;$i <= $this->nQuantidadePaginas;$i++){
			
			// SE FOR A PÁGINA ATUAL RETIRA O LINK
			if($i == $this->nPaginaAtual){
			
				// SE FOR A ÚLTIMA PÁGINA CALCULA O RESTANTE DE REGISTROS QUE FALTAM
				if($i == $this->nQuantidadePaginas) {
					$nRegistroRestante = ($this->getTotalRegistros() % $this->getRegistrosPorPagina() == 0) ? $this->getRegistrosPorPagina() : $this->getTotalRegistros() % $this->getRegistrosPorPagina();
					$nUltimoRegistro = $this->getRegistrosPorPagina() * ($i-1) + $nRegistroRestante;
				}else
					$nUltimoRegistro = $this->getRegistrosPorPagina() * $i;
					
				$sLinhaPaginacao .= "<b>".($this->getRegistrosPorPagina() * ($i-1) + 1)." - $nUltimoRegistro </b> ";
			} else {
				if($i == $this->nQuantidadePaginas){
					$nRegistroRestante = ($this->getTotalRegistros() % $this->getRegistrosPorPagina() == 0) ? $this->getRegistrosPorPagina() : $this->getTotalRegistros() % $this->getRegistrosPorPagina();
					$nUltimoRegistro = $this->getRegistrosPorPagina() * ($i-1) + $nRegistroRestante;
				}else
					$nUltimoRegistro = $this->getRegistrosPorPagina() * $i;

				$sLinhaPaginacao .= "<a class=\"Link\"href=\"".$this->sNomePaginaOrigem."?".$this->sNomeVariavelDePaginas."=$i".$this->retornaStringProLink()."\">".($this->getRegistrosPorPagina() * ($i-1) + 1)." - $nUltimoRegistro </a> ";
			}
			if($i != $this->nQuantidadePaginas)
				$sLinhaPaginacao .= " | ";
		}//
		if ($this->nQuantidadePaginas > 1){
			return substr($sLinhaPaginacao,0,strlen($sLinhaPaginacao) - 1);
		} else {
			return "";
		}
	}
	
	function retornaLinhaDeLinks(){
		global $_GET;
		$sLinhaPaginacao = (isset($sLinhaPaginacao) && $sLinhaPaginacao != "") ? $sLinhaPaginacao : "";
		for($i = 1;$i <= $this->nQuantidadePaginas;$i++){
			
			// SE FOR A PÁGINA ATUAL RETIRA O LINK
			if($i == $this->nPaginaAtual){
				$nPaginaAtual = $i;
			
				// SE FOR A ÚLTIMA PÁGINA CALCULA O RESTANTE DE REGISTROS QUE FALTAM
				if($i == $this->nQuantidadePaginas) {
					$nRegistroRestante = ($this->getTotalRegistros() % $this->getRegistrosPorPagina() == 0) ? $this->getRegistrosPorPagina() : $this->getTotalRegistros() % $this->getRegistrosPorPagina();
					$nUltimoRegistro = $this->getRegistrosPorPagina() * ($i-1) + $nRegistroRestante;
				}else
					$nUltimoRegistro = $this->getRegistrosPorPagina() * $i;
					
				$sLinhaPaginacao .= "Mostrando ".($this->getRegistrosPorPagina() * ($i-1) + 1)." até $nUltimoRegistro de ".$this->getTotalRegistros()." ";
			}
		}//

		if($nPaginaAtual > 1)
			$sLinhaPaginacao .= '<a href="'.$this->sNomePaginaOrigem.'?'.$this->sNomeVariavelDePaginas.'='.($nPaginaAtual-1).$this->retornaStringProLink().'"><img src="/sistema/imagens/paginacao/reg_anterior.gif" width="16" height="16" class="anterior" alt="Anterior" title="Anterior" border="0" /></a>&nbsp;';
		else	
			$sLinhaPaginacao .= '<img src="/sistema/imagens/paginacao/reg_anterior_inativo.gif" width="16" height="16" class="anterior" alt="Anterior" title="Anterior" border="0" />&nbsp;';
		
		if($nPaginaAtual < $this->nQuantidadePaginas)
			$sLinhaPaginacao .= '<a href="'.$this->sNomePaginaOrigem.'?'.$this->sNomeVariavelDePaginas.'='.($nPaginaAtual+1).$this->retornaStringProLink().'"><img src="/sistema/imagens/paginacao/reg_proximo.gif" width="16" height="16" class="proximo" alt="Pr&oacute;xima" title="Pr&oacute;xima" border="0" /></a>';
		else	
			$sLinhaPaginacao .= '<img src="/sistema/imagens/paginacao/reg_proximo_inativo.gif" width="16" height="16" class="proximo" alt="Pr&oacute;xima" title="Pr&oacute;xima" border="0" />';
				
		return $sLinhaPaginacao;
	}
	
	
	# Realiza a paginação do vetor propriamente dita.
	function paginaResultado($vResultado){
	 	if(is_array($vResultado)) {	
		
			$this->setQuantidadeDePaginas($vResultado);
			$this->setTotalRegistros(count($vResultado));
			
			if ($this->nRegistrosPorPagina > count($vResultado)){
				$this->nRegistrosPorPagina = count($vResultado);
			} 
			return array_slice($vResultado,$this->nRegistroInicial,$this->nRegistrosPorPagina);
		} else {
			return false;
		}
	}
}

/*
-> Exemplo de Uso.

$oPaginacao = new Paginacao(10); //Passa-se como parâmetro o número de registros por página desejados.
$vResultado = $oPaginacao->paginaResultado($vResultado);
foreach ($vResultado as $oResultado){
	print($oResultado->ID_RESULTADO); //Aqui viria a linha desejada, seja dentro de uma tabela, enfim.
}
print($oPaginacao->retornaLinhaDeLinks());// Imprime a linha com número de páginas e links para as mesmas.

*/
?>