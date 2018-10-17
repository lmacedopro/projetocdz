/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */    
$(document).ready(function(){
    
    //Pega o valor da url da pagina
    var protocol = window.location.protocol.toString();
    var host = window.location.host.toString();
    var pathname = window.location.pathname.toString();
    var pathpart = pathname.split('/');

    var base_url = protocol+"//"+host+"/"+pathpart[1]+"/"+pathpart[2]+"/"; //URL de BASE DO SITE
    var base_path = protocol+"//"+host+"/"+pathpart[1]+"/"; //PATH de BASE DO SITE 

    //Pega o valor do id do botao e mostra o avatar 
    if($('#hdnAvatar').val() === ""){ //verifica se o campo oculto esta com valor para exibir a imagem
        $('#showavatar').html("<img src='"+base_path+"/public/img/avatar/01.png' alt=''>");
        $('#hdnAvatar').val('01');
        
        $('#01').removeClass("btn-warning");
        $('#01').addClass("btn-success");
    }else{
        var opt = $('#hdnAvatar').val();
        $('#showavatar').html("<img src='"+base_path+"/public/img/avatar/"+opt+".png' alt=''>");
        
        $('#'+opt).removeClass("btn-warning");
        $('#'+opt).addClass("btn-success");
    }
    
    $('#btavatar').on('click', function(event) {
        //recupera o valor do id do botao selecionado
        var opt = $(event.target).attr("id");
        
        //atribui o valor a caixa de texto oculta
        $('#hdnAvatar').val(opt);
        
        //altera a cor do botao selecionado
        $('#btavatar').children().removeClass("btn-success");
        $('#btavatar').children().addClass("btn-warning");
        
        $('#'+opt).removeClass("btn-warning");
        $('#'+opt).addClass("btn-success");
        
        //atribui a figura do avatar selecionado
        $('#showavatar').html("<img src='"+base_path+"/public/img/avatar/"+opt+".png' alt=''>");

    });
    
    //Pega o valor da caixa de selecao e exibe a imagem do cavaleiro inicial
    var opt = $('#selCavini').val();
    if(opt !== ""){
        $('#showcavini').html("<img src='"+base_path+"/public/img/cavs/"+opt+".png' alt='' width='60%'>");
    }
    
    $('#selCavini').change(function(){
        //alert('teste');
        var opt = $(this).val();
        
        if(opt !== ""){
            $('#showcavini').html("<img src='"+base_path+"/public/img/cavs/"+opt+".png' alt='' width='80%'>");
        }
    });
	
	
	//Mostra as compras do usuario na tela
    var arrcompra = new Array(); //array de compras do usuario
	$('select[name^="selQtd"]').change(function(){

		//var arrcompra = [];
        
		var qtd = $(this).find(":selected").val();
		var valor = $(this).attr('data-preco');
		var itmid = $(this).attr('data-item');

        //pega as qtd e valores dos outros selects
        var key = itmid+":"+qtd+":"+valor;

        if(arrcompra.length < 1){

            arrcompra.push(key);

        }else{

            var flagsub = 0;
            //percorre o vetor verificando se tem algum item inserido e deleta do vetor
            for (i in arrcompra) {

                var strcompra = arrcompra[i].split(':');
                if(itmid === strcompra[0]){

                    arrcompra[i] = strcompra[0]+":"+qtd+":"+strcompra[2];
                    flagsub = 1;
                }

            }

            if(flagsub === 0){

                arrcompra.push(key);
            }
        }
        

        //atualiza o valor da compra somando os itens
        var totcomp = 0;
        for (i in arrcompra) {

            var strcompra = arrcompra[i].split(':'); 
            var totpar = parseInt(strcompra[1])*parseInt(strcompra[2]);
            
            totcomp = totcomp + totpar;
        }

		$('em[name="totalcompra"]').html(totcomp);
		$('input[name="hdnTotalcompra"]').attr('value',totcomp);
	});
	
	//Abre o modal de itens na tela de batalha
	$('#btItemuse').click(function(){
		$("#modal-itens").modal();
	});

    //Abre o modal de opcoes extra da tela de gerencia de cavaleiros
    $(".btcav").click(function(){

        var cvuid = $(this).attr("value");

        $("#cavcont").load(base_url+"dash/equipe/info?cvuid="+cvuid);
        $("#modal-cavextra").modal();
    });

    //Abre o modal de opcoes extra preenchendo com formulado de alteracao de ordem de lineup
    $("#btMudar").click(function(){

        var cvuid = $(this).attr("value");

        $("#cavcont").load(base_url+"dash/equipe/mudar");
        $("#modal-cavextra").modal();
    });


    //Atribui funcao click para alteracao de tecnica em cada slot
    $('a[name^="Slot"]').click(function(){

        var slot = $(this).attr('value');
        var cvu = $(this).attr('data-cvu');

        //mostra o modal para alteracao da tecnica vinculada ao slot
        $("#cvuteccont").load(base_url+"dash/equipe/personalize/slottec/?slt="+slot+"&cvu="+cvu);
        $("#modal-cvutec").modal();
    });

    //Controle de requisicao em batalha
    $(".bttec").click(function(){

        $(this).prop("disabled","disabled");
        //alert($(this).prop("disabled"));
    });

    //Controle de requisicao em batalha
    $(".btitens").click(function(){

        $(this).prop("disabled","disabled");
        //alert($(this).prop("disabled"));
    });

    $('#btnseltroca').click(function(){

        var cvuid = $(this).attr('value');
        var clsid = $(this).attr('data-cls');

        $("#cvuseltroca").load(base_url+"troca/novatroca/?cvuid="+cvuid+"&clsid="+clsid);
        $("#modal-formtroca").modal();
    });

    $('button[name^="btnaccoferta"]').click(function(){

        var trcid = $(this).attr('value');

        $("#cvuseltroca").load(base_url+"troca/accoferta/?trcid="+trcid);
        $("#modal-accoferta").modal();
    });

});


