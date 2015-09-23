
$(document).on("click", ".btn-del-col", function() {
    var i = 0;
    var l = $(this).closest('table').parent().attr('data-linha');
    $(this).closest('table').find('a').each(function(){
        i = i + 1;
        r = 'col_' + l + '_' + i;
        $(this).attr('id',r);
        console.log(r);
    });
    var x = $(this).closest('table').attr('data-colunas');
    x = x - 1;
    $(this).closest('table').attr('data-colunas',x);
    $(this).parent().parent().remove();
});

$(document).on("click", ".del-row", function() {
    var cn = parseInt($(this).closest('table').attr('data-colunas'));
    cn = cn - 1;
    $(this).closest('table').attr('data-colunas',cn);
    $(this).parent().parent().parent().parent().parent().parent().parent().remove();
});

function addColumnToDesc(obj) {
    var id = $(obj).closest('td').prev().children('div').children('a').attr('id');
    var cl;
    var nm;
    if(typeof id === 'undefined'){
        cl = 1;
        nm = $(obj).closest('table').parent().attr('data-linha');
    }else{
        cl = parseInt(id.substr(id.length - 1)) + 1;
        nm = id.replace('col_','');
        nm = nm.split('_');
        nm = nm[0];
    }
    
    var it = 'col_' + nm + '_' + cl;
    var content = "<td><div class='ui-field-contain'><button class='icon-cancel-2 btn-del-col ui-btn ui-shadow ui-corner-all'></button><a id='" + it + "' href='#SelectItem' data-rel='popup' data-position-to='window' data-transition='pop' onclick='opensearch(this);' class='btn-ficha ui-link'><span class='icon-plus'>&nbsp;</span>Adicionar</a></div></td>";
    $(obj).closest('.acoes-col').before(content);
    var cn = parseInt($(obj).closest('table').attr('data-colunas'));
    cn = cn + 1;
    $(obj).closest('table').attr('data-colunas',cn);
}

/**
 * Função que adiciona linha no botão adicionar
 * Criada por Eliel Fernandes
 * Atualizada em 03/08/2015
 * Versão: 1.1.0
 */
function addRowToContent() {
    var id   = $("#listcontent").children('li:last').attr('id');
    var r    = '';
    if(typeof id === 'undefined'){
        r = '1';
    }else{
        r = parseInt(id.replace('linha_','')) + 1;
    }
    
    var row  = 'linha_' + r;
    var col1 = 'col_' + r + '_0';
    var col2 = 'col_' + r + '_1';
    var cont = "<li class='row-cont-ficha' id='" + row + "' data-linha='" + r + "'>";
    cont    += '<div class="ft-list-row-title">';
    cont    += '<div class="pull-left handlearrasta"><span class="icon-resize-full-alt"></span></div>';
    cont    += '<div class="pull-left mnutipoholder">';
    cont    += '<span class="tipo-linha-title">Item</span> <span class="icon-down-dir"></span>';
    cont    += '<div class="mnutipo">';
    cont    += '<div onclick="changetype(this);" class="mnutipo-item">Item</div>';
    cont    += '<div onclick="changetype(this);" class="mnutipo-item">Cabeçalho</div>';
    cont    += '<div onclick="changetype(this);" class="mnutipo-item">Observação</div>';
    cont    += '</div>';
    cont    += '</div>';
    cont    += '</div>';
    cont    += '<div class="not-dragg" style="padding-top: 37px;"><table width="100%" border="0" cellpadding="0" cellspacing="2"><tbody>';
    cont    += "<tr><td><div class='ui-field-contain'>";
    cont    += "<a id='" + col1 + "' aria-expanded='false' aria-owns='SelectItem' aria-haspopup='true' href='#SelectItem' data-rel='popup' data-position-to='window' data-transition='pop' onclick='opensearch(this);' class='btn-ficha btn-ficha-label ui-link'><span class='icon-plus'>&nbsp;</span>Adicionar</a>";
    cont    += "</div></td>";
    cont    += "<td class='acoes-col'><div class='ui-field-contain'>";
    cont    += "<a href='#' class='pull-left icon-cancel-2 link-icon del-row ui-link'></a>";
    cont    += "</div></td></tr></tbody></table>";
    cont    += "<table data-colunas='1' width='100%' border='0' cellpadding='0' cellspacing='2'><tbody><tr><td><div class='ui-field-contain'><button class='icon-cancel-2 btn-del-col ui-btn ui-shadow ui-corner-all'></button>";
    cont    += "<a id='" + col2 + "' aria-expanded='false' aria-owns='SelectItem' aria-haspopup='true' href='#SelectItem' data-rel='popup' data-position-to='window' data-transition='pop' onclick='opensearch(this);' class='btn-ficha ui-link'><span class='icon-plus'>&nbsp;</span>Adicionar</a></div></td><td class='acoes-col'><div class='ui-field-contain'><a onclick='addColumnToDesc(this);' href='#' class='pull-left icon-plus link-icon add-icon ui-link'></a></div></td></tr></tbody></table></div></li>";
    $("#listcontent").append(cont);
    $("#listcontent").children('li:last').children('div:first').children('div.mnutipoholder').hover(function(){
        $(this).children('div:first').stop().fadeIn('fast');
    },function(){
        $(this).children('div:first').stop().fadeOut('fast');
    });
}

/**
 * Salva o conteúdo da lista
 * Criado por: Eliel Fernandes
 * Atualizada em: 03/08/2015
 * Versão: 1.1.0
 */
function saveft(pag){
    $.mobile.loading("show");
    if($('#answer').children('div').hasClass('alert-danger') || $('#answer').children('div').hasClass('alert-success')){
        $('#answer').slideUp('fast');
        $('#answer').children('div').removeClass('alert-danger');
        $('#answer').children('div').removeClass('alert-success');
    }
    var str = '';
    var post = [];
    $('.content').find('.row-cont-ficha').each(function(){
        tipo_linha = $(this).children('div:first').children('div:last').children('span:first').html();
        switch(tipo_linha){
            case 'Cabeçalho':
                tipo_linha = 'cabecalho';
                break;
            case 'Observação':
                tipo_linha = 'obs';
                break;
            default:
                tipo_linha = 'item';
                break;
        }
        pg_id = pag;
        //console.log('ID_PG ' + pg_id);
        str += $(this).attr('data-linha');
        str += ',' + pg_id;
        str += ',' + tipo_linha;
        str += ',' + $(this).children('div.not-dragg').children('table:last').attr('data-colunas');
        str += ',' + $(this).children('div.not-dragg').children('table:first').children('tbody').children('tr').children('td').children('div').children('a').attr('data-idlabel');
        $(this).children('div.not-dragg').children('table:last').children('tbody').children('tr').find('td').each(function(){
            if($(this).hasClass('acoes-col')){

            }else{
                str += ',' + $(this).children('div').children('a').attr('data-vlr');
                str += ',' + $(this).children('div').children('a').attr('data-tipo');
            }
        });
        post.push(str);
        str = '';
    });
    //console.log(post);
    $.post('/modelos/actions/saveft',{lines: post, pg:pag})
    .done(function(data){
        console.log(data);
        //var result = JSON.parse(data);
        $.mobile.loading("hide");
        $('#answer').children('div').addClass('alert-success').html('Informações atualizadas com sucesso!');
        $('#answer').slideDown().delay(5000).slideUp();
    })
    .fail(function(err){
        //var result = JSON.parse(err);
        console.log('Erro: ' + err);
        $.mobile.loading("hide");
        $('#answer').children('div').addClass('alert-danger').html('Houve um erro, tente mais tarde!');
        $('#answer').delay(5000).slideDown();
    });
}

