
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
    $(this).parent().parent().parent().parent().parent().parent().remove();
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

function addRowToContent() {
    var id   = $("#listcontent").children('div:last').attr('id');
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
    cont    += "<div class='not-dragg'><table width='100%' border='0' cellpadding='0' cellspacing='2'><tbody>";
    cont    += "<tr><td><div class='ui-field-contain'>";
    cont    += "<a id='" + col1 + "' aria-expanded='false' aria-owns='SelectItem' aria-haspopup='true' href='#SelectItem' data-rel='popup' data-position-to='window' data-transition='pop' onclick='opensearch(this);' class='btn-ficha btn-ficha-label ui-link'><span class='icon-plus'>&nbsp;</span>Adicionar</a>";
    cont    += "</div></td>";
    cont    += "<td class='acoes-col'><div class='ui-field-contain'>";
    cont    += "<a href='#' class='pull-left icon-cancel-2 link-icon del-row ui-link'></a>";
    cont    += "</div></td></tr></tbody></table>";
    cont    += "<table data-colunas='1' width='100%' border='0' cellpadding='0' cellspacing='2'><tbody><tr><td><div class='ui-field-contain'><button class='icon-cancel-2 btn-del-col ui-btn ui-shadow ui-corner-all'></button>";
    cont    += "<a id='" + col2 + "' aria-expanded='false' aria-owns='SelectItem' aria-haspopup='true' href='#SelectItem' data-rel='popup' data-position-to='window' data-transition='pop' onclick='opensearch(this);' class='btn-ficha ui-link'><span class='icon-plus'>&nbsp;</span>Adicionar</a></div></td><td class='acoes-col'><div class='ui-field-contain'><a onclick='addColumnToDesc(this);' href='#' class='pull-left icon-plus link-icon add-icon ui-link'></a></div></td></tr></tbody></table></div></li>";
    $("#listcontent").append(cont);
}

