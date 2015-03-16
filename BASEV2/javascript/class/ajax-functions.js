function ajaxLoadPage(obj, method, page, data) {

    var div_ajax_conteudo = $("div#conteudo-box div#conteudo");
    var div_ajax_loading = $("div#conteudo-box div#ajax_loader");
    var class_active_menu = "active";
    var div_menu_id = $("div#menu-box ul li");

    if(!method) { console.log('ajaxLoadPage: Method não definido.'); return; }
    if(!page) { console.log('ajaxLoadPage: Página não definida.'); return; }

    $.ajax({
        url: page,
        data: data,
        type: method,
        async: false,
        beforeSend: function() {
            div_ajax_loading.show();
            /* desativa menu */
            div_menu_id.removeClass(class_active_menu);
        },
        success: function( data ) {
            div_ajax_conteudo.html(data);
        },
        complete: function() {
            div_ajax_loading.hide();
            /* ativa menu */
            $(obj).addClass(class_active_menu);
        },
        statusCode: {
            404: function() {
                console.log("ajaxLoadPage: Pagina: "+ page +" Erro 404.");
                $.get("ajax/404.php", function(data,status) {  div_ajax_conteudo.html(data);  });

            }
        }

    });

    console.log("ajaxLoadPage: Pagina: "+page+" carregada com sucesso!");
}