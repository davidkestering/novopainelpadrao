(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"* Este campo é obrigatório!",
                    "alertTextCheckboxMultiple":"* Por favor escolha uma opção!",
                    "alertTextCheckboxe":"* Este checkbox é obrigatório!"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Mínimo ",
                    "alertText2": " carateres permitidos"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* Máximo ",
                    "alertText2": " carateres permitidos"
                },
                "groupRequired": {
                    "regex": "none",
                    "alertText": "* You must fill one of the following fields"
                },
                "min": {
                    "regex": "none",
                    "alertText": "* O valor mínimo é "
                },
                "max": {
                    "regex": "none",
                    "alertText": "* O valor máximo é "
                },
                "past": {
                    "regex": "none",
                    "alertText": "* Data anterior a "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* Data posterior a "
                },
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Foi ultrapassado o número máximo de escolhas"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Selecione no mínimo ",
                    "alertText2": " opção(ões)"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* Os campos não correspondem"
                },
                "creditCard": {
                    "regex": "none",
                    "alertText": "* Inválido número de cartão de crédito"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    //"regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "regex": /^[0-9\-\(\)\ ]+$/,
                    "alertText": "* Número de telefone inválido"
                },
                "email": {
                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
                    //"regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
                    "regex": /^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/,
                    //"regex": /^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,3}$/,
                    "alertText": "* Endereço de email inválido"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* Não é um número inteiro"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Não é um número decimal"
                },
                "date": {
                    //"regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/,
                    //"alertText": "* Data inválida, o formato deve de ser AAAA-MM-DD"
                    "regex": /^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/,
                    "alertText":"* Data inválida, deve ser no formato DD/MM/AAAA!"
                },
                "ipv4": {
                    "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Número IP inválido"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "alertText": "* URL inválido"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Só é permitido números"
                },
                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Só é permitido letras"
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* Só é permitido letras e números"
                },
                // --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertText": "* Nome de utilizador não disponível",
                    "alertTextLoad": "* A validar, por favor aguarde"
                },
                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "* Nome não disponível",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* Nome disponível",
                    // speaks by itself
                    "alertTextLoad": "* A validar, por favor aguarde"
                },
                "validate2fields": {
                    "alertText": "* Escreva HELLO"
                },
                "numericoObrigatorio":{
                    "regex": /^[0-9\.\,\-\/]+$/,
                    "alertText":"* Apenas números!"
                },
                "numericoObrigatorioSimples":{
                    "regex": /^[0-9]+$/,
                    "alertText":"* Apenas números!"
                },
                "noSpecialCaracters":{
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText":"* Nenhum caractere especial é permitido!"
                },
                "ajaxLider":{
                    "url":"includes/validaLider.php",
                    "extraData": "",
                    "alertText":"* Nome do Lider já existente no banco de dados, por favor escolha outro!",
                    "alertTextOk":"* Nome do Lider disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxSupervisor":{
                    "url":"includes/validaSupervisor.php",
                    "extraData": "",
                    "alertText":"* Nome do Supervisor já existente no banco de dados, por favor escolha outro!",
                    "alertTextOk":"* Nome do Supervisor disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxRede":{
                    "url":"includes/validaRede.php",
                    "extraData": "",
                    "alertText":"* Nome da Rede já existente no banco de dados, por favor escolha outro!",
                    "alertTextOk":"* Nome da Rede disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCelula":{
                    "url":"includes/validaCelula.php",
                    "extraData": "",
                    "alertText":"* Nome da Célula já existente no banco de dados, por favor escolha outro!",
                    "alertTextOk":"* Nome da Célula disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxStatusRelacionamento":{
                    "url":"includes/validaStatusRelacionamento.php",
                    "extraData": "",
                    "alertText":"* Nome do Status de Relacionamento já existente no banco de dados, por favor escolha outro!",
                    "alertTextOk":"* Nome do Status de Relacionamento disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxInscricao":{
                    "url":"includes/validaInscricao.php",
                    "extraData": "",
                    "alertText":"* Nome do Inscrito já existente no banco de dados, por favor escolha outro!",
                    "alertTextOk":"* Nome do Inscrito disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxUser":{
                    "url":"includes/validaUsuario.php",
                    "extraData": "",
                    "alertText":"* Este Login já existe em nossa base de dados, por favor escolha outro login!",
                    "alertTextOk":"* Este Login está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCategoriaCase":{
                    "url":"includes/validaCategoriaCase.php",
                    "extraData": "",
                    "alertText":"* Este nome de categoria já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de categoria está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxClienteCase":{
                    "url":"includes/validaClienteCase.php",
                    "extraData": "",
                    "alertText":"* Este nome de cliente_case já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de cliente_case está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxEventoCase":{
                    "url":"includes/validaEventoCase.php",
                    "extraData": "",
                    "alertText":"* Este nome de evento já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de evento está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCase":{
                    "url":"includes/validaCase.php",
                    "extraData": "",
                    "alertText":"* Este nome de case já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de case está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxName":{
                    "url":"includes/validaUsuario.php",
                    "extraData":"",
                    "alertText":"* Este usuário já existe em nossa base de dados, por favor escolha outro nome de usuário!",
                    "alertTextOk":"* Este usuário está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCategoria":{
                    "url":"includes/validaCategoria.php",
                    "extraData":"",
                    "alertText":"* Este nome de categoria já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de categoria está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxTransacao":{
                    "url":"includes/validaTransacao.php",
                    "extraData":"",
                    "alertText":"* Este nome de transação já existe para esta categoria, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de transação está disponível para esta categoria!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCategorias":{
                    "url":"includes/validaCATEGORIAS.php",
                    "extraData":"",
                    "alertText":"* Este nome de categoria já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de categoria está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxGrupo":{
                    "url":"includes/validaGrupo.php",
                    "extraData":"",
                    "alertText":"* Este nome de grupo de usuário já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de grupo de usuário está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxConta":{
                    "url":"includes/validaCONTA.php",
                    "extraData":"",
                    "alertText":"* Este nome de conta já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este nome de conta está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCliente":{
                    "url":"includes/validaCliente.php",
                    "extraData":"",
                    "alertText":"* Este cliente_case já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este cliente_case está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxPerfil":{
                    "url":"includes/validaPERFIL.php",
                    "extraData":"",
                    "alertText":"* Este nome de Perfil já existe em nossa base de dados, por favor escolha outro nome de perfil!",
                    "alertTextOk":"* Este nome de Perfil está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxEnquete":{
                    "url":"includes/validaENQUETE.php",
                    "extraData":"",
                    "alertText":"* Este título de enquete já existe em nossa base de dados, por favor escolha outro título para esta enquete!",
                    "alertTextOk":"* Este título de enquete está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxAlternativa":{
                    "url":"includes/validaALTERNATIVA.php",
                    "extraData":"",
                    "extraDataDynamic": ['#fIdEnquete'],
                    "alertText":"* Este título de enquete já existe em nossa base de dados, por favor escolha outro título para esta enquete!",
                    "alertTextOk":"* Este título de enquete está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxVoto":{
                    "url":"includes/validaVOTO.php",
                    "extraData":"",
                    "alertText":"* Este cpf já consta em nosso banco de dados como um cpf que já votou!",
                    "alertTextOk":"* CPF válido para votar!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxProduto":{
                    "url":"includes/validaPRODUTO.php",
                    "extraData":"",
                    "alertText":"* Este nome de Produto já existe em nossa base de dados, por favor escolha outro nome para este produto!",
                    "alertTextOk":"* Este nome de Produto está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxEstado":{
                    "url":"includes/validaEstado.php",
                    "extraData":"",
                    "alertText":"* Este Estado já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este Estado está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxSiglaEstado":{
                    "url":"includes/validaSiglaEstado.php",
                    "extraData":"",
                    "alertText":"* Esta sigla de Estado já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Esta sigla de Estado está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxTipoRede":{
                    "url":"includes/validaTipoRede.php",
                    "extraData":"",
                    "alertText":"* Este tipo de rede social já existe, por favor escolha outro nome!",
                    "alertTextOk":"* Este tipo de rede social está disponível!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "letraObrigatorio":{
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText":"* Apenas letras!"
                },
                "CPF":{
                    "regex": /^[0-9]{11}$/,
                    "alertText":"* CPF inv&aacute;lido, use apenas números, em um total de 11 dígitos!"
                },
                "CNPJ":{
                    "regex": /^[0-9]{14}$/,
                    "alertText":"* CNPJ inv&aacute;lido, use apenas números, em um total de 14 dígitos!"
                },
                "ajaxCPF":{
                    "regex": /^[0-9]{11}$/,
                    "url":"includes/validaCPF.php",
                    "extraData":"",
                    "alertText":"* CPF inv&aacute;lido, use apenas números, em um total de 11 dígitos!",
                    "alertTextOk":"* Este CPF está v&aacute;lido!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCNPJ":{
                    "regex": /^[0-9]{14}$/,
                    "url":"includes/validaCNPJ.php",
                    "extraData":"",
                    "alertText":"* CNPJ inv&aacute;lido, use apenas números, em um total de 14 dígitos!",
                    "alertTextOk":"* Este CNPJ está v&aacute;lido!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                },
                "ajaxCPFCNPJ":{
                    "regex": /^[0-9]{11,14}$/,
                    "url":"includes/validaCPFCNPJ.php",
                    "extraData":"",
                    "alertText":"* CPF/CNPJ inv&aacute;lido, use apenas números, em um total de 11 a 14 dígitos!",
                    "alertTextOk":"* Este CPF/CNPJ está v&aacute;lido!",
                    "alertTextLoad":"* Processando, por favor aguarde!"
                }
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);