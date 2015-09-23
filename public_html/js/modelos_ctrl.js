/**
 * Arquivo que controla todas as funções principais do link Modelos
 * Criado por: Eliel Fernandes
 */

var resultado_da_busca;
var index = 1;
/*
* Menu lateral de familia e modelo
*/
function changefamily(obj){
    loading('show');
    $('#select-native-6').prop('disabled','true');
    $('#select-native-6').find('option').remove();
    var path = location.pathname;
    var family = $(obj).val();
    $.post('/modelos/index/selectmodelos',{familia : family}, function(modelos){
        loading('hide');
        var rows = JSON.parse(modelos);
        var um   = '';
        var id   = '';
        for(var item in rows){
            var option = '<option value="' + item + '">' + rows[item] + '</option>';
            if(um == ''){
                option = '<option selected="selected" value="' + item + '">' + rows[item] + '</option>';
                um = rows[item];
                id = item;
            }
            $('#select-native-6').append(option);
        }
        $('#select-native-6').removeProp('disabled','false');
        $('#select-native-6').prev().html('•&nbsp;' + um);
        var url = path + "/?id=" + id;
        $.mobile.pageContainer.pagecontainer("change",
            url,
            {allowSamePageTransition :true,
                dataUrl : path}
        );
    });
}

function loadpg(obj){
    var family = $(obj).val();
    var path = location.pathname;
    var url = path + "/?id=" + family;
    $.mobile.pageContainer.pagecontainer("change",
        url,
        {
            allowSamePageTransition :true,
            dataUrl : path
        }
    );
}
function loadpg2(obj){
    var family = $(obj).val();
    console.log(family);
    if(typeof family === undefined || family == null){
        return;
    }else{
        var path = location.pathname;
        var url = path + "/?id=" + family;
        $.mobile.pageContainer.pagecontainer("change",
            url,
            {
                allowSamePageTransition :true,
                dataUrl : path
            }
        );
    }
}
function loadpg3(obj){
    var family = $(obj).val();
    console.log(family);
    /*if(typeof family === undefined || family == null){
        return;
    }else{
        var path = location.pathname;
        var url = path + "/?id=" + family;
        $.mobile.pageContainer.pagecontainer("change",
            url,
            {
                allowSamePageTransition :true,
                dataUrl : path
            }
        );
    }*/
}
/*
Fim do Menu lateral de família e modelo
 */

/*
POPUP QUE SELECIONA ALIAS FUNCOES
*/
function loading(ShowOrHide){
    setTimeout(function(){$.mobile.loading(ShowOrHide);},1);
}


/**
 * Função que abre o popup de alias
 * Criado por: Eliel Fernandes
 * Versão: 1.0.0
 */
function opensearch(obj){
    id = $(obj).attr('id');
    $('#SelectItem').attr('data-parent',id);
    search();
}

/**
 * Função que executa a busca de alias
 * Criado por: Eliel Fernandes
 * Atualizado em: 06/08/2015
 * Versão: 1.1.0
 */
function search(){
    loading('show');
    var tbl_resultado = $('#tbl_resultado');
    tbl_resultado.html('');
    tbl_resultado.fadeOut('fast');
    $('#tbl_resultado_header').fadeOut('fast');

    var p  = 'param_desc_alias=' + $('#param_desc_alias').val();
    p  = p + '&param_finalidade=' + $('#param_finalidade').val();
    p  = p + '&param_tipo=' + $('#param_tipo').val();
    p  = p + '&param_param_grupo=Todos';
    p  = p + '&param_clasi=Todos';
    var ur = '/modelos/fichatecnica/search?' + p;

    $.post(ur,function(data){
        var rows = JSON.parse(data);
        if(rows.length == 0){
            var si = '<tr>';
            si += '<td><p>Resultados não encontrado!</p></td>';
            si += '</tr>';
            tbl_resultado.append(si);
        }else{
            resultado_da_busca = rows;
            var f = rows.length - 1;
            if(f > 200){
                index = 200;
                f = 200; 
            }else{
                index = resultado_da_busca.length;
            }
            for(i = 0; i <= f; i++){
                var a = b = c = d = '';
                if(resultado_da_busca[i].desc_alias)
                    a = resultado_da_busca[i].desc_alias;
                if(resultado_da_busca[i].desc_grupo_classificacao)
                    b = resultado_da_busca[i].desc_grupo_classificacao;
                if(resultado_da_busca[i].desc_classificacao)
                    c = resultado_da_busca[i].desc_classificacao;
                if(resultado_da_busca[i].desc_item_vinculado)
                    d = resultado_da_busca[i].desc_item_vinculado;

                var row  = '<tr id="ln_pdc_' + resultado_da_busca[i].id_alias + '">';
                row += '<td class="acoes">';
                row += '<a href="#" data-id="' + resultado_da_busca[i].id_alias + '" data-desc="' + a + '" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-ok-3" onclick="selectalias(this);" data-toggle="tooltip" data-placement="right" data-placement="top" title="Selecionar"></a>';
                row += '<a href="#" onclick="showalias(\'' + resultado_da_busca[i].id_alias + '\',\'1\',this);" data-toggle="tooltip" title="editar" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-pencil-2"></a>';
                row += '<a href="#" onclick="showalias(\'' + resultado_da_busca[i].id_alias + '\',\'2\',this);" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-plus" data-toggle="tooltip" data-placement="top" title="Criar novo alias"></a></td>';
                row += '<td width="270px"><p>' + a + '</p></td>';
                row += '<td width="105px"><p>' + b + '</p></td>';
                row += '<td width="150px"><p>' + c + '</p></td>';
                row += '<td><p>' + d + '</p></td>';
                row += '</tr>';
                tbl_resultado.append(row);
            }
        }
        loading('hide');
        $('#tbl_resultado_header').fadeIn('fast');
        tbl_resultado.fadeIn('fast');
        $('[data-toggle="tooltip"]').tooltip();
    });
}

/**
 * Função que exibe a Aba de Alias no POPUP Alias
 * Criado por: Eliel Fernandes
 * Atualizado em: 12/08/2015
 * Versão: 2.1.1
 */
function showalias(up,tipo,obj){
    if(tipo === '2' || tipo === '1'){
        if(tipo === '1'){
            html = $(obj).parent().parent().children('td:last').html();
            if(html != '<p></p>'){
                alert('Você não pode editar um Item de Engenharia');
                return;
            }
        }
        $.post('/modelos/index/getaliasdata', {id: up}, function(data){
            var ret = JSON.parse(data);
            if(tipo === '1'){
                $('#param_id_alias').val(up);
                txt = '<p style="float:left; padding-top: 12px;">Código: <span>' + up + '</span></p>';
                $('#nrcodigo').html(txt);
            }
            fina = $('#param_finalidade').val();
            if(fina == 'valor'){
                $('#param_novo_tipo_finalidade').val('valor');
                $("input[name='label-alias']:last").prev().click();
                $("input[name='label-alias']").checkboxradio("refresh");
            }
            $('#desc_alias_new').val(ret.desc_alias);
            $('#myclassifications').select2("val", ret.id_classificacao);
            if((ret.cod_item_vinculado !== null) && (ret.desc_item_vinculado !== null)){
                $('#btn_add_item_vinculado').html(ret.desc_item_vinculado);
                $('#itemvinculado').val(ret.cod_item_vinculado);
                $('#param_novo_tipo_alias').val('item');
            }
            $('#btn-aba-alias').removeClass('hide');
            $('#btn-aba-alias').trigger('click');
        });
    }else{
        $('#btn-aba-alias').removeClass('hide');
        $('#btn-aba-alias').trigger('click');
    }
}

/**
 * Função que limpa os campos de alias ao cancelar, adicionar
 * Criado por: Eliel Fernandes
 * Atualizado em: 07/08/2015
 * Versão 2.0.0
 */
function backsearch(){
    $('#param_novo_tipo_finalidade').val('label');
    $('#param_novo_tipo_alias').val('alias');
    $('#param_id_alias').val('0');
    $('#nrcodigo').html('<p style="float:left; padding-top: 12px;">Código: <span>Novo</span></p>');
    $('#desc_alias_new').val('');
    $('#itemvinculado').val('');
    $('#myclassifications').select2("val", "");
    $('#btn_add_item_vinculado').html('<span class="icon-plus">&nbsp;</span>adicionar item engenharia');
    $("input[name='label-alias']:first").prev().click();
    $("input[name='label-alias']").checkboxradio("refresh");
    $('#btn-aba-search').trigger('click');
    $('#btn-aba-alias').addClass('hide');
}

/**
 * Função que limpa os campos de alias ao trocar de aba
 * Criado por: Eliel Fernandes
 * Criado em: 11/08/2015
 * Versão 1.0.0
 */
function closealias(){
    $('#param_novo_tipo_finalidade').val('label');
    $('#param_novo_tipo_alias').val('alias');
    $('#param_id_alias').val('0');
    $('#nrcodigo').html('<p style="float:left; padding-top: 12px;">Código: <span>Novo</span></p>');
    $('#desc_alias_new').val('');
    $('#itemvinculado').val('');
    $('#myclassifications').select2("val", "");
    $('#btn_add_item_vinculado').html('<span class="icon-plus">&nbsp;</span>adicionar item engenharia');
    $("input[name='label-alias']:first").prev().click();
    $("input[name='label-alias']").checkboxradio("refresh");
    $('#btn-aba-alias').addClass('hide');
}

/**
 * Função que salva o alias
 * Criado por: Eliel Fernandes
 * Atualizado em: 07/08/2015
 * Versão: 1.1.0
 */
function savealias(){
    //loading('show');
    if(($('#desc_alias_new').val() == '') || ($('#myclassifications').val() == null)){
        alert('Informe a descrição e a Classificação!');
        //loading('hide');
        return;
    }
    var paid = $('#param_id_alias').val();
    var fina = $('#param_novo_tipo_finalidade').val();
    var tipo = $('#param_novo_tipo_alias').val();
    var desc = $('#desc_alias_new').val();
    var vinc = $('#itemvinculado').val();
    var clas = $('#myclassifications').val();
    var vinculo = '';
    if(vinc != ''){
        vinculo = 'modelo';
    }
    console.log(paid + ',' + fina + ',' + tipo + ',' + desc + ',' + vinc + ',' + clas);
    $.post('/modelos/actions/savealias',{
        param_id_alias : paid,
        param_id_classificacao: clas,
        param_desc_alias:desc,
        param_finalidade:fina,
        param_tipo:tipo,
        param_item_vinculado:vinc,
        param_nivel_item_vinculado: vinculo
    },function(data){
        console.log(data);
        backsearch();
        search();
    });
}

function backtonormal(obj){
    $('#btn_add_item_vinculado').html($(obj).val());
    $('#param_novo_tipo_alias').val('alias');
    $('#itemvinculado').val('');
}

function selectme(obj){
    loading('show');
    var txt = $(obj).html();
    var cod = $(obj).attr('data-vinculo-id');
    $('#btn_add_item_vinculado').html(txt);
    $('#itemvinculado').val(cod);
    $(".pop-itens-engenharia").fadeOut();
    $('#param_novo_tipo_alias').val('item');
    loading('hide');
}

function selectalias(obj){
    var item  = '#' + $('#SelectItem').attr('data-parent');
    var tipo  = $('#param_finalidade').val();
    var a     = item.substr(-1);
    var label = $(obj).data('desc');
    var idlbl = $(obj).data('id');
    if(a === '0'){
        $(item).attr('data-idlabel',idlbl);
        $(item).html(label);
    }else{
        $(item).attr('data-vlr',idlbl);
        $(item).attr('data-tipo',tipo);
        $(item).html(label);
    }
    $('#SelectItem').popup('close');
}

function setEnter(e){
    var code = e.keyCode || e.which;
    if(code == 13){
        e.preventDefault();
        search();
    }
}

function validaScroll(){
    var scroller = document.getElementById('popupscroller');
    var windowhe = scroller.offsetHeight;
    var tbl = $('#tbl_resultado').outerHeight();
    var scrolled = scroller.scrollTop;
    var scrollend = tbl - (scrolled + windowhe);
    if(scrollend <= 200){
        addRowsDynamic();
    }
}

function addRowsDynamic(){
    loading('show');
    var x = parseInt((paginaatual * 100) + 1);
    var y = x + 100;
    if(x > resultado_da_busca.length){
        return;
    }else{
        if(y > resultado_da_busca.length){
            a = resultado_da_busca.length - x;
            y = a;
            console.log(a + ' | ' + y + ' | ' + resultado_da_busca.length)
        }
        for(i = x; i <= y; i++){
            var a = b = c = d = '';
            if(resultado_da_busca[i].desc_alias)
                a = resultado_da_busca[i].desc_alias;
            if(resultado_da_busca[i].desc_grupo_classificacao)
                b = resultado_da_busca[i].desc_grupo_classificacao;
            if(resultado_da_busca[i].desc_classificacao)
                c = resultado_da_busca[i].desc_classificacao;
            if(resultado_da_busca[i].desc_item_vinculado)
                d = resultado_da_busca[i].desc_item_vinculado;

            var row  = '<tr id="ln_pdc_' + resultado_da_busca[i].id_alias + '">';
            row += '<td class="acoes" style="width: 85px;">';
            row += '<a href="#" data-id="' + resultado_da_busca[i].id_alias + '" data-desc="' + a + '" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-ok-3" onclick="selectalias(this);" data-toggle="tooltip" data-placement="top" title="Selecionar alias"></a>';
            row += '<a href="#" onclick="showalias(\'' + resultado_da_busca[i].id_alias + '\');" data-toggle="tooltip" title="editar" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-pencil-2"></a>';
            row += '<a href="#" onclick="showalias(\'0\',this);" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-plus" data-toggle="tooltip" data-placement="top" title="Criar novo alias"></a></td>';
            row += '<td width="270px"><p>' + a + '</p></td>';
            row += '<td width="105px"><p>' + b + '</p></td>';
            row += '<td width="150px"><p>' + c + '</p></td>';
            row += '<td><p>' + d + '</p></td>';
            row += '</tr>';
            
            $('#tbl_resultado').append(row);
        }
        loading('hide');
        tbl = $('#tbl_resultado').outerHeight();
        paginaatual = paginaatual + 1;
    }
}

$(function() {
    $('#dvscroller').endlessScroll({
        fireOnce: false,
        insertAfter: "#dvscroller #tbl_resultado tr:last",
        data: function(i) {
            index = index + 1;// + 200;
            if(index == resultado_da_busca.length){
                console.log('chegou no final');
                index = index - 1;
                return;
            }else{
                loading('show');
                var a = b = c = d = '';
                if(resultado_da_busca[index].desc_alias)
                    a = resultado_da_busca[index].desc_alias;
                if(resultado_da_busca[index].desc_grupo_classificacao)
                    b = resultado_da_busca[index].desc_grupo_classificacao;
                if(resultado_da_busca[index].desc_classificacao)
                    c = resultado_da_busca[index].desc_classificacao;
                if(resultado_da_busca[index].desc_item_vinculado)
                    d = resultado_da_busca[index].desc_item_vinculado;
                var row  = '<tr id="ln_pdc_' + resultado_da_busca[index].id_alias + '">';
                row += '<td class="acoes" style="width: 85px;">';
                row += '<a href="#" data-id="' + resultado_da_busca[index].id_alias + '" data-desc="' + a + '" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-ok-3" onclick="selectalias(this);" data-toggle="tooltip" data-placement="top" title="Selecionar alias"></a>';
                row += '<a href="#" onclick="showalias(\'' + resultado_da_busca[index].id_alias + '\');" data-toggle="tooltip" title="editar" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-pencil-2"></a>';
                row += '<a href="#" onclick="showalias(\'0\',this);" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-plus" data-toggle="tooltip" data-placement="top" title="Criar novo alias"></a></td>';
                row += '<td width="270px"><p>' + a + '</p></td>';
                row += '<td width="105px"><p>' + b + '</p></td>';
                row += '<td width="150px"><p>' + c + '</p></td>';
                row += '<td><p>' + d + '</p></td>';
                row += '</tr>';
                loading('hide');
                return row;
            }
        }
    });
});

/**
 * No load da página ativa o arrastar das funções
 * Criada por: Eliel Fernandes
 * Criada em: 03/08/2015
 */
$(document).on('pageshow', 'div', function (event, ui) {
    $('#listcontent').sortable({
        handle: ".handlearrasta",
        cancel: '.not-dragg',
        placeholder: 'row-placeholder',
        items: "> li",
        stop: function(){
            $('.content').find('.row-cont-ficha').each(function(){
                nlinha = $(this).attr('data-linha');
            });
        }
    });
    $('#listcontent').disableSelection();
    $('.mnutipoholder').hover(function(){
        $(this).children('div:first').stop().fadeIn('fast');
    },function(){
        $(this).children('div:first').stop().fadeOut('fast');
    });
});

/**
 * Função que muda o tipo de linha (Item, Cabeçalho ou Observação)
 * Criado por: Eliel Fernandes
 * Criado em: 30/07/2015
 * Atualizada em: 03/08/2015
 * Versão 1.0.1
 */
function changetype(obj){
    nome = $(obj).html();
    $.when(
        $('#listcontent').find('.tipo-linha-title').each(function(){
            html = $(this).html();
            if(html == 'Cabeçalho' && nome == 'Cabeçalho'){
                $(this).html('Item');
            }
            /*if(html == 'Observação' && nome == 'Observação'){
                $(this).html('Item');
            }*/
        })
    ).done(function(){
        $(obj).parent().parent().children('span:first').html(nome);
    });
}





