$(document).ready(function(){
	$('#btnSair').click(function(){
		if(confirm('Deseja realmente sair do sistema?')){
			
			$.ajax({
				type: "POST",
				//LOCAL
				//url: window.location.origin+"/NovoPainelPadraoComNovoLog/painel/administrativo/login/processa.php",
				//ONLINE
				url: window.location.origin+"/painel/administrativo/login/processa.php",
				data: {sOP:"Logoff"},
				success: function(resp){
					if(resp == 1){
						//LOCAL
						//window.open(window.location.origin+'/NovoPainelPadraoComNovoLog/painel/index.php','_self');
						//ONLINE
						window.open(window.location.origin+'/painel/index.php','_self');
					}
				}
			});
		}
		return false;
	});

	$.extend($.gritter.options, {
	    //class_name: 'gritter-light', // for light notifications (can be added directly to $.gritter.add too)
	    position: 'top-right', // possibilities: bottom-left, bottom-right, top-left, top-right
            fade_in_speed: 1000, // how fast notifications fade in (string or int)
            fade_out_speed: 3000, // how fast the notices fade out
            time: 6000 // hang on the screen for...
	});

});

function crud(id,paginaAtual,opcao,funcao,paginaProcessa,sTexto){
	switch(opcao){
		case 'excluir': 
			if(confirm('Deseja realmente excluir?')){
				$.post(paginaProcessa,{act: funcao,id: id},function(resp){
					if(resp == '1'){
						alert('Excluído com sucesso!');
						window.open(paginaAtual,'_self');
					} else {
						alert('Ocorreu um erro ao excluir. Por favor, tente novamente.');
					}
				});
			}
			break;
		case 'liberar':
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Liberando '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' liberado para novo login com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao liberar. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000
					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
				
			break;
			
		case 'publicar':
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Publicando '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' publicado com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao publicar. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000
					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
				
			break;
		
		case 'despublicar':
			//$('body').mask('Despublicando, aguarde...');
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Despublicando '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' despublicado com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao despublicar. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000

					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
		break;
		case 'ativar':
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Ativando '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' ativado com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao ativar. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000

					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
			break;
		
		case 'desativar':
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Desativando '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' desativado com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao desativar. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000

					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
                    //var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
			break;

		case 'destacar':
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Destacando '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' destacado(a) com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao destacar. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
					//var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000

					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
					//var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
		break;

		case 'desdestacar':
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Removendo o destaque do(a) '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' teve seu destaque removido com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao remover o destaque. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
					//var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000

					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
					//var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
			break;

		case 'ordenacao':
			$.gritter.removeAll();
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Ordenando '+sTexto+'...</div>',
				// (string | mandatory) the text inside the notification
				//text: 'The callback is...',
				//class_name: 'gritter-light',
				// Stickeh!
				sticky: false,
				// (string | optional) the image to display on the left
				//image: '../../../../sistema/images/Spinner-1s-200px.svg',
				// (function | optional) function called before it opens
				before_open: function(){
					//alert('I am called before it opens');
				},
				// (function | optional) function called after it opens
				after_open: function(e){
					//alert("I am called after it opens: \nI am passed the jQuery object for the created Gritter element...\n" + e);
					$.post(paginaProcessa,{act: funcao, id: id}).done(function(resp){
						if(resp == 1){
							//alert('Publicado com sucesso!');
							//$.gritter.remove(1,'time: 1');
							$.gritter.add({
								title: '<div class="alert alert-success alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-check"></i> '+sTexto+' tiveram sua ordenação realizada com sucesso!</div>',
								time: 1000
							});

						} else {
							$.gritter.add({
								title: '<div class="alert alert-danger alert-dismissible" style="margin-top:14px;"><i class="icon fa fa-ban"></i> Ocorreu um erro ao ordenar. Por favor, tente novamente mais tarde.</div>',
								time: 1000
							});
						}
					});
				},
				// (function | optional) function called before it closes
				before_close: function(e, manual_close){
					//var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert("I am called before it closes: I am passed the jQuery object for the Gritter element... \n" + manually);
					$.gritter.add({
						title: '<div class="alert alert-info alert-dismissible" style="margin-top:14px;"><i class="fa fa-refresh fa-spin"></i> Recarregando a página, por favor aguarde!</div>',
						time: 1000

					});
				},
				// (function | optional) function called after it closes
				after_close: function(e, manual_close){
					//var manually = (manual_close) ? 'The "X" was clicked to close me!' : '';
					//alert('I am called after it closes. ' + manually);
					window.open(paginaAtual,'_self');
				},
				// (int | optional) the time you want it to be alive for before fading out
				time: 3000
			});
			break;

	}
}