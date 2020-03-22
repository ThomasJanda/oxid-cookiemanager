$( document ).ready(function() {
    $('#rs_cookie_manager_accept_all').click(function() {
        $('#rs_cookie_manager_popup input[type="checkbox"]').each(function() {
            $(this)[0].checked = true;
        });
        return rs_cookie_manager_accept();
    });
    $('#rs_cookie_manager_accept').click(function() {
        return rs_cookie_manager_accept();
    });
    $('.rs_cookie_manager_group_more').click(function() {
        /* let id = $(this).attr('data-group-id'); */
        $(this).next().toggleClass('show');
        if($(this).next().hasClass('show')){
             $(this).find('i').attr('style','transform: rotate(180deg)');
        }else{
            $(this).find('i').removeAttr('style');
        }
    });
});
function rs_cookie_manager_popup_open()
{
    "use strict";
    $('#rs_cookie_manager_popup').modal('show');
    return false;
}
function rs_cookie_manager_popup_close()
{
    "use strict";
    window.setTimeout(function() {
        $('#rs_cookie_manager_popup').modal('hide');
    }, 500);
}
function rs_cookie_manager_accept()
{
    "use strict";
    $('#rs_cookie_manager_popup_form').trigger('submit');
    /* sync ajax request */
    /*
    let data = $('#rs_cookie_manager_popup_form').serialize();
    let url = $('#rs_cookie_manager_popup_form').attr('data-url');
    $.ajax({
        async:false,
        method: "POST",
        url: url,
        data: data
    }).done(function( msg ) {
    }).always(function() {
    });

    rs_cookie_manager_popup_close();
    return true;
     */
    return false;
}
