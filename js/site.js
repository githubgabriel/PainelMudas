function logout() {

    window.location.href='actions.php?a=logout';

}


function abreWiki(id) {
    ajaxLoadPage(null, "get", "ajax/wiki.php", "id="+id );
}