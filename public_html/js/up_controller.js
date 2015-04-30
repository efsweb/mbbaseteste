/*function loading(ShowOrHide){
    setTimeout(function(){$.mobile.loading(ShowOrHide);},1);
}

function opensearch(obj){
    search();
    id = $(obj).attr('id');
    $('#SelectItem').attr('data-parent',id);
}*/

/*function search(){
    loading('show');

    $('#tbl_resultado').html('');
    $('#tbl_resultado').fadeOut('fast');
    $('#tbl_resultado_header').fadeOut('fast');

    var p  = 'param_desc_alias=' + $('#param_desc_alias').val();
    p  = p + '&param_finalidade=' + $('#param_finalidade').val();
    p  = p + '&param_tipo=' + $('#param_tipo').val();
    p  = p + '&param_param_grupo=' + $('#select-native-2').val();
    p  = p + '&param_clasi=' + $('#select-classificacao').val();
    var ur = '/modelos/fichatecnica/search?' + p;
    $.post(ur,function(data){
        var rows = JSON.parse(data);
        if(rows.length == 0){
            var si = '<tr>';
            si += '<td><p>Resultados não encontrado!</p></td>';
            si += '</tr>';
            $('#tbl_resultado').append(si);
        }else{
            for(i = 0; i <= rows.length - 1; i++){
                var a = b = c = d = '';
                if(rows[i].desc_alias)
                    a = rows[i].desc_alias;
                if(rows[i].desc_grupo_classificacao)
                    b = rows[i].desc_grupo_classificacao;
                if(rows[i].desc_classificacao)
                    c = rows[i].desc_classificacao;
                if(rows[i].desc_item_vinculado)
                    d = rows[i].desc_item_vinculado;

                var row  = '<tr id="ln_pdc_' + rows[i].id_alias + '">';
                row += '<td class="acoes" style="width: 85px;">';
                row += '<a href="#" data-id="' + rows[i].id_alias + '" data-desc="' + a + '" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-ok-3" onclick="selectalias(this);" data-toggle="tooltip" data-placement="top" title="Selecionar alias"></a>';
                row += '<a href="#" onclick="showalias(\'' + rows[i].id_alias + '\');" data-toggle="tooltip" title="editar" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-pencil-2"></a>';
                row += '<a href="#" onclick="showalias(\'0\',this);" class="ui-corner-all ui-btn-b btn-acoes-ficha icon-plus" data-toggle="tooltip" data-placement="top" title="Criar novo alias"></a></td>';
                row += '<td width="270px"><p>' + a + '</p></td>';
                row += '<td width="105px"><p>' + b + '</p></td>';
                row += '<td width="150px"><p>' + c + '</p></td>';
                row += '<td><p>' + d + '</p></td>';
                row += '</tr>';
                $('#tbl_resultado').append(row);
            }
        }
        loading('hide');
        $('#tbl_resultado_header').fadeIn('fast');
        $('#tbl_resultado').fadeIn('fast');
        $('[data-toggle="tooltip"]').tooltip();
    });
}*/
