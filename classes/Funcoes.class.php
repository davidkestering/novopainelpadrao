<?php

function retira_acentos( $texto ){
  $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "ñ", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "Ñ", "ª", "º", "°", "`", "'","&ordm;","&deg;");
  $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "n", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "N", "", "", "", "", "","","");
  return str_replace( $array1, $array2, $texto );
}

function diminuta_acentos( $texto ){
  $array1 = array("Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "Ñ");
  $array2 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "ñ");
  return str_replace( $array1, $array2, $texto );
}

function memoria_usada() {
    return round(memory_get_usage() / 1024, 2);
}

function converteParaUtf8($string){
    // If it's not already UTF-8, convert to it
    if (mb_detect_encoding($string, 'utf-8', true) === false) {
        $string = mb_convert_encoding($string, 'utf-8', 'iso-8859-1');
    }
    return $string;
}

/**
 * Converte um texto em $string para utf8 caso a string não estejá em utf8.
 *
 * @param   string  $string    String contendo o texto
 */
function codificacao_para_utf8($string) {
    return (mb_detect_encoding($string . "x", 'UTF-8, ISO-8859-1') == "UTF-8" ? $string : utf8_encode($string));
}

/**
 * Converte um texto em $string para ISO caso a string estejá em utf8.
 *
 * @param   string  $string    String contendo o texto
 */
function codificacao_para_ISO($string) {
    return (mb_detect_encoding($string . "x", 'UTF-8, ISO-8859-1') != "UTF-8" ? $string : utf8_decode($string));
}

/**
 * Valida uma a url passada por parâmetro.
 * Retorna verdadeiro caso a url exista ou falso caso a url não seja encontrada ou não existe.
 * Esta função é válida para links diretos a ficheiros.
 *
 * @param   string  $url    A url passada por parâmetro
 */
function valida_url($url) {
    if (!stristr($url, 'http://'))
        $url = "http://" . $url;

    //abrimos o ficheiro em leitura
    $id = @fopen($url, "r");
    //fazemos as verificações
    if ($id)
        $aberto = true;
    else
        $aberto = false;
    //fechamos o ficheiro
    @fclose($id);
    //retornamos o valor
    return $aberto;
}

/**
 * Retorna um texto sem acentuação e espaços em branco.
 *
 * @param   string  $string    Texto
 */
function limpaString($string) {
    $characteres = array(
        'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
        'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f'
    );
    return strtr($string, $characteres);
}

/**
 * Retorna o metodo em string para acrescentar em URL. Ex: &a=1&b=2
 *
 * @param   Array  $metodo  Qualquer array em lista.
 */
function convert_method($metodo) {
    $valor = "";
    if (!empty($metodo)) {
        foreach ($metodo as $key => $value) {
            $valor .= "&$key=$value";
        }
    }

    return $valor;
}

function porcentagem($parcial, $totalgeral) {
    if ($totalgeral) {
        $parcial = number_format($parcial, 2, ".", "");
        $totalgeral = number_format($totalgeral, 2, ".", "");
        return number_format((($parcial * 100) / $totalgeral), 2, ",", "");
    }
    else
        return '0';
}

function converter_datetime_timestamp($datahora) {
    list($data, $hora) = explode(' ', $datahora);
    list($ano, $mes, $dia) = explode('-', $data);
    list($hora, $minuto, $segundo) = explode(':', $hora);

    $timestamp = mktime($hora, $minuto, $segundo, $mes, $dia, $ano);

    return $timestamp;
}

function remove_name_curso($curso) {
    return substr($curso, 7);
}

function request() {

    $valorvar = "";
    while (list($key, $val) = each($_REQUEST)) {
        $valorvar .= $key . "=" . $val . "&";
    }

    return $valorvar;
}

function get() {
    $valor = "";
    if (!empty($_GET)) {
        foreach ($_GET as $key => $value) {
            $valor .= "&$key=$value";
        }
    }

    return $valor;
}

function post() {

    $valorvar = "";
    while (list($key, $val) = each($_POST)) {
        $valorvar .= $key . "=" . $val . "&";
    }
    
    return $valorvar;
}

function checked($v1, $v2) {
    if (@$v1 == $v2) {
        echo "checked";
    }
}

function selected($v1, $v2) {
    if (@$v1 == $v2) {
        echo "selected";
    }
}

function br() {
    echo "<br>";
}

//DATA DO BRASIL PARA USA
function datatousa($data) {
    $a = explode("/", $data);
	$a[2] = (isset($a[2])) ? $a[2] : "";
	$a[1] = (isset($a[1])) ? $a[1] : "";
	$a[0] = (isset($a[0])) ? $a[0] : "";
    return $a[2] . "-" . $a[1] . "-" . $a[0];
}

//DATA DO EUA PARA BRASIL
function datatopor($data) {
    $a = explode("-", $data);
	$a[2] = (isset($a[2])) ? $a[2] : "";
	$a[1] = (isset($a[1])) ? $a[1] : "";
	$a[0] = (isset($a[0])) ? $a[0] : "";
    return $a[2] . "/" . $a[1] . "/" . $a[0];
}

// QUEBRA A LINHA QUANDO USADO TEXT AREA
function txttohtml($var) {
    $var = nl2br($var);
    return $var;
}

//CONVERTE STRIG DE HTML PARA TXT
function htmltotxt($var) {
    $var = htmlspecialchars($var);
    return $var;
}

// MOSTRA A DATA EM FORMATO PORTUGUES
function data() {
    $var = date("d/m/Y");
    return $var;
}

// MOSTRA O DIA DA SEMANA
function semana() {
    $var = date("D");
    switch ($var) {
        case"Sun": $var = "Domingo";
            break;
        case"Mon": $var = "Segunda-Feira";
            break;
        case"Tue": $var = "Ter�a-Feira";
            break;
        case"Wed": $var = "Quarta-Feira";
            break;
        case"Thu": $var = "Quinta-Feira";
            break;
        case"Fri": $var = "Sexta-Feira";
            break;
        case"Sat": $var = "Sábado";
            break;
    }
    return $var;
}

//MOSTRA A HORA
function hora() {
    $var = date("H:i:s");
    return $var;
}

//MOSTRA O IP
function ip() {
    $var = $_SERVER['REMOTE_ADDR'];
    return $var;
}

function navegador() {
    $var = @$_SERVER['HTTP_USER_AGENT'];
    return $var;
}

//FUN��O MID EM PHP (IGUAL NO ASP
function mid($texto, $ini, $fim) {
    $texto = Substr($texto, $ini, $fim);
    return $texto;
}

//FUN��O QUE CONVERTE PARA INTEIRO
function cint($numero) {
    $numero = (int) $numero;
    return $numero;
}

//FUN��O QUE DIZ O TAMANHO DA STRING EM CARACTERES
function len($texto) {
    $texto = Strlen($texto);
    return $texto;
}

//MOSTRA O DIA DE UMA DATA
function dia($data) {
    $a = explode("/", $data);
    return $a[0];
}

//MOSTRA O MES DE UMA DATA
function mes($data) {
    $a = explode("/", $data);
    return $a[1];
}

//MOSTRA O ANO DE UMA DATA
function ano($data) {
    $a = explode("/", $data);
    return $a[2];
}

function redirect($url) {
    $url = "<script>document.location.href='" . $url . "'</script>";
    return $url;
}

function alert($mensagem) {
    $mensagem = "<script language='JavaScript'> alert('" . $mensagem . "'); </script>";
    return $mensagem;
}

function diasemana($data) {
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);

    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

    switch ($diasemana) {
        case"0": $diasemana = "Domingo";
            break;
        case"1": $diasemana = "Segunda-Feira";
            break;
        case"2": $diasemana = "Ter�a-Feira";
            break;
        case"3": $diasemana = "Quarta-Feira";
            break;
        case"4": $diasemana = "Quinta-Feira";
            break;
        case"5": $diasemana = "Sexta-Feira";
            break;
        case"6": $diasemana = "Sábado";
            break;
    }

    return $diasemana;
}

// echo alert("http://www.uol.com.br");


function sonumeros() {

    echo "<script language=\"JavaScript\">\n";
    echo "<!--\n";
    echo "function SoNumeros()\n";
    echo "{ var carCode = event.keyCode;\n";
    echo "if ((carCode < 48) || (carCode > 57)) {\n";
    echo "	alert('Por favor digite apenas números.');\n";
    echo "	event.cancelBubble = true\n";
    echo "	event.returnValue = false;\n";
    echo "}}\n";
    echo "//-->\n";
    echo "</script>\n";
    echo " <!--EXEMPLO: onKeyPress='SoNumeros();' -->";
    echo "\n";
    echo "\n";
}

function moeda() {
    echo "<script language=\"JavaScript\">\n";
    echo "<!--\n";
    echo "function SoNumeros()\n";
    echo "{ var carCode = event.keyCode;\n";
    echo "if ((carCode < 48) || (carCode > 57)) {\n";
    echo "	alert('Por favor digite apenas n�meros.');\n";
    echo "	event.cancelBubble = true\n";
    echo "	event.returnValue = false;\n";
    echo "}}\n";
    echo "//-->\n";
    echo "</script>\n";
    echo "<script language=\"JavaScript\">\n";
    echo "<!--\n";
    echo "function FormataValor(id,tammax,teclapres) {\n";
    echo "   if(window.event) { // Internet Explorer\n";
    echo "        var tecla = teclapres.keyCode; }\n";
    echo "        else if(teclapres.which) { // Nestcape / firefox\n";
    echo "        var tecla = teclapres.which; }\n";
    echo "vr = document.getElementById(id).value;\n";
    echo "vr = vr.toString().replace( \"/\", \"\" );\n";
    echo "vr = vr.toString().replace( \"/\", \"\" );\n";
    echo "vr = vr.toString().replace( \",\", \"\" );\n";
    echo "vr = vr.toString().replace( \".\", \"\" );\n";
    echo "vr = vr.toString().replace( \".\", \"\" );\n";
    echo "vr = vr.toString().replace( \".\", \"\" );\n";
    echo "vr = vr.toString().replace( \".\", \"\" );\n";
    echo "tam = vr.length;\n";
    echo "if (tam < tammax && tecla != 8){ tam = vr.length + 1; }\n";
    echo "if (tecla == 8 ){ tam = tam - 1; }\n";
    echo "if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){\n";
    echo "if ( tam <= 2 ){\n";
    echo "document.getElementById(id).value = vr; }\n";
    echo "if ( (tam > 2) && (tam <= 5) ){\n";
    echo "document.getElementById(id).value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ); }\n";
    echo "if ( (tam >= 6) && (tam <= 8) ){\n";
    echo "document.getElementById(id).value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }\n";
    echo "if ( (tam >= 9) && (tam <= 11) ){\n";
    echo "document.getElementById(id).value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }\n";
    echo "if ( (tam >= 12) && (tam <= 14) ){\n";
    echo "document.getElementById(id).value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); }\n";
    echo "if ( (tam >= 15) && (tam <= 17) ){\n";
    echo "document.getElementById(id).value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );}\n";
    echo "}\n";
    echo "}\n";
    echo "//-->\n";
    echo "</script>\n";
    echo " <!--COMANDO NO CAMPO INPUT: onKeyPress='SoNumeros();FormataValor(this.id, 10, event);' -->";
    echo "\n";
    echo "\n";
}

// MOSTRA O RELOGIO NA TELA
function relogio() {

    echo "<script language=\"JavaScript\">\n";
    echo "function tS(){ x=new Date(); x.setTime(x.getTime()); return x; }\n";
    echo "function lZ(x){ return (x>9)?x:'0'+x; }\n";
    echo "function dT(){\n";
    echo "  if(fr==0){ fr=1;\n";
    echo "  document.write('<font size=2 face=Arial><span id=\"tP\">'+eval(oT)+'</span></font>');\n";
    echo "  	}\n";
    echo "		tP.innerText=eval(oT);\n";
    echo "		setTimeout('dT()',1000);\n";
    echo "	}\n";
    echo "var fr=0,oT=\"lZ(tS().getHours())+':'+lZ(tS().getMinutes())+':'+lZ(tS().getSeconds())+' '\";\n";
    echo "</script>\n";
    echo "<script language=\"JavaScript\">dT();</script>\n";
}

// muda a cor da linha
function tr() {

    echo " onMouseOver=javascript:style.backgroundColor='#EFFEEB'";
    echo "        onmouseout=javascript:style.backgroundColor='white'";
}

//function executa($sql) {
//
//	$result = mysql_query($sql) or die(mysql_error());
//	return $result;
//
//}
?>