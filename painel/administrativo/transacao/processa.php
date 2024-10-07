<?php 
require_once("../../../constantes.php");
require_once(PATH."/painel/includes/valida_usuario.php");
require_once(PATH."/classes/FachadaSegurancaBD.class.php");
require_once(PATH."/classes/Validacao.class.php");

$oFachadaSeguranca = new FachadaSegurancaBD();
$oValidacao = new Validacao();

//$oValidacao->printvardie($_POST);
//die();

// VERIFICA AS PERMISSÕES
$sOP = (isset($_POST['sOP'])) ? $_POST['sOP'] : "";
$nIdTipoTransacaoSessao = $_SESSION['oLoginAdm']->recuperaTipoTransacaoPorDescricaoCategoria("Transacao",$sOP,BANCO);
$bPermissao = $_SESSION['oLoginAdm']->verificaPermissao("Transacao",$sOP,BANCO);
$nIdCategoriaTipoTransacao = (isset($_POST['fIdCategoriaTipoTransacao']) && $_POST['fIdCategoriaTipoTransacao'] != "" && $_POST['fIdCategoriaTipoTransacao'] != 0) ? $_POST['fIdCategoriaTipoTransacao'] : 0;

if(!$bPermissao){
    //TRANSACAO
    $nIdTipoTransacaoAcesso = $oFachadaSeguranca->recuperaTipoTransacaoPorDescricaoCategoria("Transacao", $sOP, BANCO);
    $sObjetoAcesso = ACESSO_NEGADO_TRANSACAO;
    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("", $nIdTipoTransacaoAcesso, $_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao, $sObjetoAcesso, "", "", "", IP_USUARIO, DATAHORA, 1, 1);
	$oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
	$_SESSION['sMsgPermissao'] = ACESSO_NEGADO;
	header("location: ".SITE."painel/index.php?bErro=1");
	exit();
}//if(!$bPermissao){

if (isset($sOP) && $sOP != "Excluir"){
	$bPublicado = (isset($_POST['fPublicado']) && $_POST['fPublicado'] == 1) ? "1" : "0";
	$bAtivo = (isset($_POST['fAtivo']) && $_POST['fAtivo'] == 1) ? "1" : "0";
	$dDataCadastro = (isset($_POST['fDataCadastro']) && $_POST['fDataCadastro']) ? $_POST['fDataCadastro'] : date("Y-m-d H:i:s");
	
	$oCategoriaTipoTransacao = $oFachadaSeguranca->inicializaCategoriaTipoTransacao($_POST['fIdCategoriaTipoTransacao'], $_POST['fNomeCategoria'],$dDataCadastro,$bPublicado,$bAtivo);
	$_SESSION['oCategoriaTipoTransacao'] = $oCategoriaTipoTransacao;
	
	$sAtributosChave = "nId,sDescricao,bPublicado,bAtivo";
	$_SESSION['sMsgTransacao'] = $oValidacao->verificaObjetoVazio($oCategoriaTipoTransacao,$sAtributosChave);
	if ($_SESSION['sMsgTransacao']){
            header("Location: ".SITE."painel/administrativo/transacao/insere_altera.php?sOP=$sOP&bErro=1&nIdCategoriaTransacao=".$_POST['fIdCategoriaTipoTransacao']);
            exit();
	}
}

switch($sOP){
	case "Cadastrar":
        // TRANSACAO
        $voObjetoNovo = get_object_vars($oCategoriaTipoTransacao);
        $voTransacao = array();
        foreach($voObjetoNovo as $sCampo => $sValor){
            if($sCampo != "nId"){
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacao,$oTransacao);
            }
        }
		$nIdCategoriaTipoTransacao = $oFachadaSeguranca->insereCategoriaTipoTransacao($oCategoriaTipoTransacao,$voTransacao,BANCO);
		if (!$nIdCategoriaTipoTransacao){
            //TRANSACAO
            $sObjetoAcesso = ACESSO_TENTATIVA;
            $voTransacaoAcesso = array();
            foreach($voObjetoNovo as $sCampo => $sValor){
                if($sCampo != "nId"){
                    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),0,$sObjetoAcesso,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                    array_push($voTransacaoAcesso,$oTransacaoAcesso);
                }
            }

            foreach ($voTransacaoAcesso as $oTransacaoAcesso){
                if(isset($oTransacaoAcesso) && is_object($oTransacaoAcesso)){
                    $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
                }
            }
			
			$_SESSION['sMsgTransacao'] = "Não foi possível cadastrar a transação. Verifique se já existe o nome da categoria!";
			$sHeader = "insere_altera.php?sOP=$sOP&bErro=1";
		} else {
			if(count($_POST['fTipoTransacao']) > 0){
				foreach($_POST['fTipoTransacao'] as $sTipoTransacao){
					if($sTipoTransacao != ""){
						$oTipoTransacao = $oFachadaSeguranca->inicializaTipoTransacao("",$nIdCategoriaTipoTransacao, $sTipoTransacao,date("Y-m-d H:i:s"),$bPublicado,$bAtivo);
                        //TRANSACAO
                        $voObjetoNovo = get_object_vars($oTipoTransacao);
                        $voTransacao = array();
                        foreach($voObjetoNovo as $sCampo => $sValor){
                            if($sCampo != "nId"){
                                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                                array_push($voTransacao,$oTransacao);
                            }
                        }
						$nIdTipoTransacao = $oFachadaSeguranca->insereTipoTransacao($oTipoTransacao,$voTransacao,BANCO);
						
						if($nIdTipoTransacao){
							//HABILITANDO PERMISSAO PARA O GRUPO ADMINISTRADOR
							$oPermissao = $oFachadaSeguranca->inicializaPermissao($nIdTipoTransacao,GRUPO_ADMINISTRADOR,date("Y-m-d H:i:s"),1,1);
							//TRANSACAO
							$sObjeto = "Habilitado a permissão de ".$sTipoTransacao." na seção ".$_POST['fNomeCategoria']." para o Grupo de Usuários Administrador em virtude do cadastro da nova Categoria de Tipo de Transação ".$_POST['fNomeCategoria'];
							$voTransacaoP = array();
							$oTransacaoP = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdTipoTransacao."_".GRUPO_ADMINISTRADOR,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
							array_push($voTransacaoP,$oTransacaoP);
							$oFachadaSeguranca->inserePermissao($oPermissao,$voTransacaoP,BANCO);
						}//if($nIdTipoTransacao){
					}//if($sTransacao != ""){
				}//foreach($_POST['fTipoTransacao'] as $sTransacao){
			}//if(count($_POST['fTipoTransacao']) > 0){
				
			if($_POST['fQtd'] > 0){
				for($i=1;$i<=$_POST['fQtd'];$i++){
					if(isset($_POST['fTipoTransacaoNova'.$i]) && $_POST['fTipoTransacaoNova'.$i] != ""){
						$oTipoTransacao = $oFachadaSeguranca->inicializaTipoTransacao("",$nIdCategoriaTipoTransacao,$_POST['fTipoTransacaoNova'.$i],date("Y-m-d H:i:s"),$bPublicado,$bAtivo);
                        //TRANSACAO
                        $voObjetoNovo = get_object_vars($oTipoTransacao);
                        $voTransacao = array();
                        foreach($voObjetoNovo as $sCampo => $sValor){
                            if($sCampo != "nId"){
                                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                                array_push($voTransacao,$oTransacao);
                            }
                        }
						$nIdTipoTransacao = $oFachadaSeguranca->insereTipoTransacao($oTipoTransacao,$voTransacao,BANCO);
						
						if($nIdTipoTransacao){
							//HABILITANDO PERMISSAO PARA O GRUPO ADMINISTRADOR
							$oPermissao = $oFachadaSeguranca->inicializaPermissao($nIdTipoTransacao,GRUPO_ADMINISTRADOR,date("Y-m-d H:i:s"),1,1);
							//TRANSACAO
							$sObjeto = "Habilitado a permissão de ".$_POST['fTipoTransacaoNova'.$i]." na seção ".$_POST['fNomeCategoria']." para o Grupo de Usuários Administrador em virtude do cadastro da nova Categoria de Tipo de Transação ".$_POST['fNomeCategoria'];
                            $voTransacaoP = array();
                            $oTransacaoP = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdTipoTransacao."_".GRUPO_ADMINISTRADOR,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
                            array_push($voTransacaoP,$oTransacaoP);
							$oFachadaSeguranca->inserePermissao($oPermissao,$voTransacaoP,BANCO);
						}//if($nIdTipoTransacao){
					}//if($sTransacao != ""){
				}//foreach($_POST['fTipoTransacao'] as $sTransacao){
			}//if(count($_POST['fTipoTransacao']) > 0){
			
			$_SESSION['sMsgTransacao'] = "Transação cadastrada com sucesso!";
			$sHeader = "index.php?bErro=0&fIdCategoriaTransacao=".$nIdCategoriaTipoTransacao."&fConsulta=1";
			$_SESSION['oCategoriaTipoTransacao'] = "";
			unset($_SESSION['oCategoriaTipoTransacao']);
			unset($_POST);
		}//if ($oFachadaSeguranca->insereUsuario($oUsuario))
	break;
	case "Alterar":
		$sHeader = "insere_altera.php?sOP=$sOP&bErro=1&nIdCategoriaTransacao=".$_POST['fIdCategoriaTipoTransacao'];
		$oCategoriaTipoTransacaoAuxiliar = $oFachadaSeguranca->recuperaCategoriaTipoTransacao($_POST['fIdCategoriaTipoTransacao'],BANCO);
		if(is_object($oCategoriaTipoTransacaoAuxiliar)){
			$oCategoriaTipoTransacao->setPublicado(1);
			$oCategoriaTipoTransacao->setAtivo(1);
            // TRANSACAO
            $vObjetoModificado=array_diff_assoc((array)$oCategoriaTipoTransacao,(array)$oCategoriaTipoTransacaoAuxiliar);
            //$voCampos = get_object_vars($oCategoriaTipoTransacaoAuxiliar);
            $vObjetoAntigo = (array)$oCategoriaTipoTransacaoAuxiliar;
            $voTransacao = array();
            foreach($vObjetoModificado as $sCampo => $sValor){
                $sValorAntigo = $vObjetoAntigo[$sCampo];
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oCategoriaTipoTransacaoAuxiliar->getId(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                if($sCampo != "sSenha"){
                    array_push($voTransacao,$oTransacao);
                }else{
                    if(!is_null($sValor) && $sValor != ""){
                        array_push($voTransacao,$oTransacao);
                    }
                }
            }
			
			if (!$oFachadaSeguranca->alteraCategoriaTipoTransacao($oCategoriaTipoTransacao,$voTransacao,BANCO)){
                //TRANSACAO
                $sObjetoAcesso = ACESSO_TENTATIVA;
                $voTransacaoAcesso = array();
                foreach($vObjetoModificado as $sCampo => $sValor){
                    $sValorAntigo = $vObjetoAntigo[$sCampo];
                    $oTransacaoAcesso = $oFachadaSeguranca->inicializaTransacaoAcesso("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oCategoriaTipoTransacaoAuxiliar->getId(),$sObjetoAcesso,$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                    array_push($voTransacaoAcesso,$oTransacaoAcesso);
                }

                foreach ($voTransacaoAcesso as $oTransacaoAcesso){
                    if(isset($oTransacaoAcesso) && is_object($oTransacaoAcesso)){
                        $oFachadaSeguranca->insereTransacaoAcesso($oTransacaoAcesso,BANCO);
                    }
                }
				
				$_SESSION['sMsgTransacao'] = "Não foi possível alterar a transação. Verifique se já existe o nome da categoria!";
				$sHeader = "insere_altera.php?sOP=$sOP&bErro=1&nIdCategoriaTransacao=".$_POST['fIdCategoriaTipoTransacao'];
			} else {
				
				//PRIMEIRO PARA ALTERAR DESATIVAMOS TODAS AS TRANSACOES DA CATEGORIA E AS PERMISSOES EXISTENTES
				$vWhereTipoTransacao = array("id_categoria_tipo_transacao = ".$_POST['fIdCategoriaTipoTransacao']);
				$voTipoTransacao = $oFachadaSeguranca->recuperaTodosTipoTransacao(BANCO,$vWhereTipoTransacao);
				if(isset($voTipoTransacao) && count($voTipoTransacao) > 0){
					foreach($voTipoTransacao as $oTipoTransacao){
						if(isset($oTipoTransacao) && is_object($oTipoTransacao)){
						    $oTipoTransacaoAuxiliar = $oFachadaSeguranca->recuperaTipoTransacao($oTipoTransacao->getId(),BANCO);
							$oTipoTransacao->setPublicado(0);
							$oTipoTransacao->setAtivo(0);

                            // TRANSACAO
                            $vObjetoModificado=array_diff_assoc((array)$oTipoTransacaoAuxiliar,(array)$oTipoTransacao);
                            //$voCampos = get_object_vars($oTipoTransacao);
                            $vObjetoAntigo = (array)$oTipoTransacao;
                            $voTransacao = array();
                            foreach($vObjetoModificado as $sCampo => $sValor){
                                $sValorAntigo = $vObjetoAntigo[$sCampo];
                                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oTipoTransacao->getId(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                                if($sCampo != "sSenha"){
                                    array_push($voTransacao,$oTransacao);
                                }else{
                                    if(!is_null($sValor) && $sValor != ""){
                                        array_push($voTransacao,$oTransacao);
                                    }
                                }
                            }

							$oFachadaSeguranca->alteraTipoTransacao($oTipoTransacao,$voTransacao,BANCO);
							
							//DESATIVANDO AS PERMISSOES DAS TRANSACOES
							$vWherePermissao = array("id_grupo_usuario != ".GRUPO_ADMINISTRADOR,"id_tipo_transacao = ".$oTipoTransacao->getId());
							$voPermissao = $oFachadaSeguranca->recuperaTodosPermissao(BANCO,$vWherePermissao);
							if(isset($voPermissao) && count($voPermissao) > 0){
								foreach($voPermissao as $oPermissao){
									if(isset($oPermissao) && is_object($oPermissao)){
									    $oPermissaoAuxiliar = $oFachadaSeguranca->recuperaPermissao($oPermissao->getIdTipoTransacao(),$oPermissao->getIdGrupoUsuario(),BANCO);

										$sGrupoUsuarioAuxiliar = "";
										$oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($oPermissao->getIdGrupoUsuario(),BANCO);
										if(is_object($oGrupoUsuarioAuxiliar))
											$sGrupoUsuarioAuxiliar = $oGrupoUsuarioAuxiliar->getNmGrupoUsuario();
										
										$oPermissao->setPublicado(0);
										$oPermissao->setAtivo(0);


                                        // TRANSACAO
                                        $vObjetoModificado=array_diff_assoc((array)$oPermissaoAuxiliar,(array)$oPermissao);
                                        //$voCampos = get_object_vars($oPermissao);
                                        $vObjetoAntigo = (array)$oPermissao;
                                        $voTransacao = array();
                                        foreach($vObjetoModificado as $sCampo => $sValor){
                                            $sValorAntigo = $vObjetoAntigo[$sCampo];
                                            $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oPermissao->getIdTipoTransacao()."_".$oPermissao->getIdGrupoUsuario(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                                            if($sCampo != "sSenha"){
                                                array_push($voTransacao,$oTransacao);
                                            }else{
                                                if(!is_null($sValor) && $sValor != ""){
                                                    array_push($voTransacao,$oTransacao);
                                                }
                                            }
                                        }

										$oFachadaSeguranca->alteraPermissao($oPermissao,$voTransacao,BANCO);
									}//if(is_object($oPermissao)){
								}//foreach($voPermissao as $oPermissao){
							}//if(count($voPermissao) > 0){
							
						}//if(is_object($oTipoTransacao)){
					}//foreach($voTipoTransacao as $oTipoTransacao){
				}//if(count($voTipoTransacao) > 0){
				
				//ATIVANDO AS NOVAS TRANSAÇOES E PERMISSOES
				$sObjetoGeral = "Usuário ".$_SESSION['oLoginAdm']->getUsuario()->getNmUsuario()." iniciou alteração da Categoria de Tipo de Transação ".$_POST['fNomeCategoria']." o que ativa as transações e permissões que foram enviadas pelo usuário na alteração!<br />";
				if(isset($_POST['fTipoTransacao']) && count($_POST['fTipoTransacao']) > 0){
					foreach($_POST['fTipoTransacao'] as $sTipoTransacao){
						if(isset($sTipoTransacao) && $sTipoTransacao != ""){
							$vWhereTipoTransacao = array("id_categoria_tipo_transacao = ".$_POST['fIdCategoriaTipoTransacao'],"transacao = '".$sTipoTransacao."'");
							$voTipoTransacao = $oFachadaSeguranca->recuperaTodosTipoTransacao(BANCO,$vWhereTipoTransacao);
							if(isset($voTipoTransacao) && count($voTipoTransacao) > 0){
								foreach($voTipoTransacao as $oTipoTransacao){
									if(isset($oTipoTransacao) && is_object($oTipoTransacao)){
									    $oTipoTransacaoAuxiliar = $oFachadaSeguranca->recuperaTipoTransacao($oTipoTransacao->getId(),BANCO);
										$oTipoTransacao->setPublicado(1);
										$oTipoTransacao->setAtivo(1);

                                        // TRANSACAO
                                        $vObjetoModificado=array_diff_assoc((array)$oTipoTransacaoAuxiliar,(array)$oTipoTransacao);
                                        //$voCampos = get_object_vars($oTipoTransacao);
                                        $vObjetoAntigo = (array)$oTipoTransacao;
                                        $voTransacao = array();
                                        foreach($vObjetoModificado as $sCampo => $sValor){
                                            $sValorAntigo = $vObjetoAntigo[$sCampo];
                                            $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oTipoTransacao->getId(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                                            if($sCampo != "sSenha"){
                                                array_push($voTransacao,$oTransacao);
                                            }else{
                                                if(!is_null($sValor) && $sValor != ""){
                                                    array_push($voTransacao,$oTransacao);
                                                }
                                            }
                                        }

										$oFachadaSeguranca->alteraTipoTransacao($oTipoTransacao,$voTransacao,BANCO);
										
										//ATIVANDO AS PERMISSOES DAS TRANSACOES
										$vWherePermissao = array("id_grupo_usuario = ".GRUPO_ADMINISTRADOR,"id_tipo_transacao = ".$oTipoTransacao->getId());
										$voPermissao = $oFachadaSeguranca->recuperaTodosPermissao(BANCO,$vWherePermissao);
										if(isset($voPermissao) && count($voPermissao) > 0){
											foreach($voPermissao as $oPermissao){
												if(isset($oPermissao) && is_object($oPermissao)){
												    $oPermissaoAuxiliar = $oFachadaSeguranca->recuperaPermissao($oPermissao->getIdTipoTransacao(),$oPermissao->getIdGrupoUsuario(),BANCO);

													$sGrupoUsuarioAuxiliar = "";
													$oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($oPermissao->getIdGrupoUsuario(),BANCO);
													if(isset($oGrupoUsuarioAuxiliar) && is_object($oGrupoUsuarioAuxiliar))
														$sGrupoUsuarioAuxiliar = $oGrupoUsuarioAuxiliar->getNmGrupoUsuario();
													
													$oPermissao->setPublicado(1);
													$oPermissao->setAtivo(1);

                                                    // TRANSACAO
                                                    $vObjetoModificado=array_diff_assoc((array)$oPermissaoAuxiliar,(array)$oPermissao);
                                                    //$voCampos = get_object_vars($oPermissao);
                                                    $vObjetoAntigo = (array)$oPermissao;
                                                    $voTransacao = array();
                                                    foreach($vObjetoModificado as $sCampo => $sValor){
                                                        $sValorAntigo = $vObjetoAntigo[$sCampo];
                                                        $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$oPermissao->getIdTipoTransacao()."_".$oPermissao->getIdGrupoUsuario(),$sCampo,$sValorAntigo,$sValor,IP_USUARIO,DATAHORA,1,1);
                                                        if($sCampo != "sSenha"){
                                                            array_push($voTransacao,$oTransacao);
                                                        }else{
                                                            if(!is_null($sValor) && $sValor != ""){
                                                                array_push($voTransacao,$oTransacao);
                                                            }
                                                        }
                                                    }

													$oFachadaSeguranca->alteraPermissao($oPermissao,$voTransacao,BANCO);
												}//if(is_object($oPermissao)){
											}//foreach($voPermissao as $oPermissao){
										}//if(count($voPermissao) > 0){
									}//if(is_object($oTipoTransacao)){
								}//foreach($voTipoTransacao as $oTipoTransacao){
							}else{
								/*$oTipoTransacao = $oFachadaSeguranca->inicializaTipoTransacao("",$_POST['fIdCategoriaTipoTransacao'],$sTipoTransacao,date("Y-m-d H:i:s"),1,1);
								//TRANSACAO
								$sObjeto = "Usuário ".$_SESSION['oLoginAdm']->oUsuario->getNmUsuario()." alterou a Categoria de Tipo de Transação ".$_POST['fNomeCategoria']." adicionando um novo tipo de transação ".$sTipoTransacao;
								$oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoPrincipal,$_SESSION['oLoginAdm']->getIdUsuario(),$sObjeto,IP_USUARIO,DATAHORA,1,1);
								$nIdTipoTransacao = $oFachadaSeguranca->insereTipoTransacao($oTipoTransacao,$oTransacao,BANCO);
								if($nIdTipoTransacao){
									//HABILITANDO PERMISSAO PARA O GRUPO ADMINISTRADOR
									$oPermissao = $oFachadaSeguranca->inicializaPermissao($nIdTipoTransacao,GRUPO_ADMINISTRADOR,date("Y-m-d H:i:s"),1,1);
									//TRANSACAO
									$sObjeto = "Habilitado a permissão de ".$sTipoTransacao." na seção ".$_POST['fNomeCategoria']." para o Grupo de Usuários Administrador em virtude da alteração da Categoria de Tipo de Transação ".$_POST['fNomeCategoria'];
									$oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoPrincipal,$_SESSION['oLoginAdm']->getIdUsuario(),$sObjeto,IP_USUARIO,DATAHORA,1,1);
									$oFachadaSeguranca->inserePermissao($oPermissao,$oTransacao,BANCO);
								}//if($nIdTipoTransacao){*/
							}//if(count($voTipoTransacao) > 0){
						}//if($sTransacao != ""){
					}//foreach($_POST['fTipoTransacao'] as $sTipoTransacao){
				}//if(isset($_POST['fTipoTransacao']) && count($_POST['fTipoTransacao']) > 0){
				
				//É UMA NOVA TRANSACAO
				if($_POST['fQtd'] > 0){
					for($i=1;$i<=$_POST['fQtd'];$i++){
						$nTotal = count($_POST['fTipoTransacao']);
						if(isset($_POST['fTipoTransacaoNova'.($nTotal+$i)]) && $_POST['fTipoTransacaoNova'.($nTotal+$i)] != ""){
							$oTipoTransacao = $oFachadaSeguranca->inicializaTipoTransacao("",$_POST['fIdCategoriaTipoTransacao'], $_POST['fTipoTransacaoNova'.($nTotal+$i)],date("Y-m-d H:i:s"),$bPublicado,$bAtivo);

                            //TRANSACAO
                            $voObjetoNovo = get_object_vars($oTipoTransacao);
                            $voTransacao = array();
                            foreach($voObjetoNovo as $sCampo => $sValor){
                                if($sCampo != "nId"){
                                    $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,$sCampo,"",$sValor,IP_USUARIO,DATAHORA,1,1);
                                    array_push($voTransacao,$oTransacao);
                                }
                            }

							$nIdTipoTransacao = $oFachadaSeguranca->insereTipoTransacao($oTipoTransacao,$voTransacao,BANCO);
							if($nIdTipoTransacao){
								//HABILITANDO PERMISSAO PARA O GRUPO ADMINISTRADOR
								$oPermissao = $oFachadaSeguranca->inicializaPermissao($nIdTipoTransacao,GRUPO_ADMINISTRADOR,date("Y-m-d H:i:s"),1,1);
								//TRANSACAO
								$sObjeto = "Habilitado a permissão de ".$_POST['fTipoTransacaoNova'.($nTotal+$i)]." na seção ".$_POST['fNomeCategoria']." para o Grupo de Usuários Administrador em virtude da alteração da Categoria de Tipo de Transação ".$_POST['fNomeCategoria'];
                                $voTransacaoP = array();
                                $oTransacaoP = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdTipoTransacao."_".GRUPO_ADMINISTRADOR,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
                                array_push($voTransacaoP,$oTransacaoP);
								$oFachadaSeguranca->inserePermissao($oPermissao,$voTransacaoP,BANCO);
							}//if($nIdTipoTransacao){
						}//if($sTransacao != ""){
					}//foreach($_POST['fTipoTransacao'] as $sTransacao){
				}//if(count($_POST['fTipoTransacao']) > 0){
				
				$_SESSION['sMsgTransacao'] = "Transação alterada com sucesso!";
				$sHeader = "index.php?bErro=0&fIdCategoriaTransacao=".$_POST['fIdCategoriaTipoTransacao']."&fConsulta=1";
				$_SESSION['oCategoriaTipoTransacao'] = "";
				unset($_SESSION['oCategoriaTipoTransacao']);
				unset($_POST);
			}//if ($oFachadaSeguranca->insereUsuario($oUsuario))
		} else {
			$_SESSION['sMsgTransacao'] = "Transação não encontrada no sistema!";
		}
	break;
	case "Excluir":
		$bResultado = true;
		foreach($_POST['fIdCategoriaTipoTransacao'] as $nIdCategoriaTipoTransacao) {
			$oCategoriaTipoTransacaoAuxiliar = $oFachadaSeguranca->recuperaCategoriaTipoTransacao($nIdCategoriaTipoTransacao,BANCO);
			if(isset($oCategoriaTipoTransacaoAuxiliar) && is_object($oCategoriaTipoTransacaoAuxiliar)){
			    $nIdCategoriaTipoTransacao = $oCategoriaTipoTransacaoAuxiliar->getId();
                // TRANSACAO
                $voTransacao = array();
                $oTransacao = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,"","","",IP_USUARIO,DATAHORA,1,1);
                array_push($voTransacao,$oTransacao);
				$bResultado &= $oFachadaSeguranca->desativaCategoriaTipoTransacao($nIdCategoriaTipoTransacao,$voTransacao,BANCO);
				$vWhereTipoTransacaoAuxiliar = array("id_categoria_tipo_transacao = ".$oCategoriaTipoTransacaoAuxiliar->getId());
				$voTipoTransacaoAuxiliar = $oFachadaSeguranca->recuperaTodosTipoTransacao(BANCO,$vWhereTipoTransacaoAuxiliar);
				if(count($voTipoTransacaoAuxiliar) > 0){
					foreach($voTipoTransacaoAuxiliar as $oTipoTransacaoAuxiliar){
						if(isset($oTipoTransacaoAuxiliar) && is_object($oTipoTransacaoAuxiliar)){
							$oTipoTransacaoAuxiliar->setPublicado(0);
							$oTipoTransacaoAuxiliar->setAtivo(0);
							$sObjeto = "Desativando o Tipo de Transação ".$oTipoTransacaoAuxiliar->getTransacao()." da Categoria ".$oCategoriaTipoTransacaoAuxiliar->getDescricao()."!";
							$voTransacaoP = array();
							$oTransacaoP = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
							array_push($voTransacaoP,$oTransacaoP);
							$oFachadaSeguranca->alteraTipoTransacao($oTipoTransacaoAuxiliar,$voTransacaoP,BANCO);
							
							//DESATIVANDO AS PERMISSOES DAS TRANSACOES
							$vWherePermissao = array("id_grupo_usuario != ".GRUPO_ADMINISTRADOR,"id_tipo_transacao = ".$oTipoTransacaoAuxiliar->getId());
							$voPermissao = $oFachadaSeguranca->recuperaTodosPermissao(BANCO,$vWherePermissao);
							if(count($voPermissao) > 0){
								foreach($voPermissao as $oPermissao){
									if(is_object($oPermissao)){
										$sGrupoUsuarioAuxiliar = "";
										$oGrupoUsuarioAuxiliar = $oFachadaSeguranca->recuperaGrupoUsuario($oPermissao->getIdGrupoUsuario(),BANCO);
										if(is_object($oGrupoUsuarioAuxiliar))
											$sGrupoUsuarioAuxiliar = $oGrupoUsuarioAuxiliar->getNmGrupoUsuario();
										
										$oPermissao->setPublicado(0);
										$oPermissao->setAtivo(0);
										$sObjeto = "Desativando a permissão de ".$oTipoTransacaoAuxiliar->getTransacao()." da Categoria ".$oCategoriaTipoTransacaoAuxiliar->getDescricao()." para o Grupo de Usuários ".$sGrupoUsuarioAuxiliar."<br />";
										$voTransacaoPer = array();
										$oTransacaoPer = $oFachadaSeguranca->inicializaTransacao("",$nIdTipoTransacaoSessao,$_SESSION['oLoginAdm']->getIdUsuario(),$nIdCategoriaTipoTransacao,$sObjeto,"","",IP_USUARIO,DATAHORA,1,1);
										array_push($voTransacaoPer,$oTransacaoPer);
										$oFachadaSeguranca->alteraPermissao($oPermissao,$voTransacaoPer,BANCO);
									}//if(is_object($oPermissao)){
								}//foreach($voPermissao as $oPermissao){
							}//if(count($voPermissao) > 0){
							
						}//if(is_object($oTipoTransacaoAuxiliar)){
					}//foreach($voTipoTransacaoAuxiliar as $oTipoTransacaoAuxiliar){
				}//if(count($voTipoTransacaoAuxiliar) > 0){
			} else 
				$bResultado &= false;
		}//foreach($_POST['fIdCategoriaTipoTransacao'] as $nIdCategoriaTipoTransacao) {
		
		if($bResultado){
			$_SESSION['sMsgTransacao'] = "Transação excluída com sucesso!";			
			$sHeader = "index.php?bErro=0";
		} else {
			$_SESSION['sMsgTransacao'] = "Não foi possível excluir a Transação";
			$sHeader = "index.php?bErro=1";
		}//if($bResultado){
	break;
}	
header("Location: ".SITE."painel/administrativo/transacao/".$sHeader);
?>