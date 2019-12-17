[{assign var=display value=$display|default:true}]
<div class="modal fade" id="rs_cookie_manager_popup" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-left">
                <h2 class="modal-title">[{oxmultilang ident="rs_cookie_manager_popup_title"}]</h2>
            </div>
            <div class="modal-body">
                <p class="text-left">
                    [{oxmultilang ident="rs_cookie_manager_popup_description"}]
                </p>
                <div class="text-left">
                    <form id="rs_cookie_manager_popup_form" action="" method="post">
                        [{$oViewConf->getHiddenSid()}]
                        [{$oViewConf->getNavFormParams()}]
                        <input type="hidden" name="fnc" value="accept">
                        <input type="hidden" name="cl" value="rs_cookie_manager_widget">
                  
                    [{assign var=aList value=$oViewConf->rs_cookiemanager_getPopupContent()}]
                    [{foreach from=$aList item=aItems}]
                        [{foreach from=$aItems item=oItem name=listitems}]
                            [{assign var=oGroup value=$oItem->getGroup()}]
                            [{if $smarty.foreach.listitems.first}]
                                <div class="rs_cookie_manager_group" data-group-id="[{$oGroup->getId()}]">
                                    <div class="form-check form-check-inline checkbox-inline">
                                        <input type="hidden" name="rs_cookie_groups[[{$oGroup->getId()}]]" value="[{if $oGroup->rs_cookie_manager_group__rsrequired->value}]1[{else}]0[{/if}]">
                                        <input class="form-check-input" name="rs_cookie_groups[[{$oGroup->getId()}]]" type="checkbox" id="group[{$oGroup->getId()}]" value="1" [{if $oGroup->rs_cookie_manager_group__rsrequired->value}] checked disabled [{/if}]>
                                        <label class="form-check-label" for="group[{$oGroup->getId()}]">
                                            [{$oGroup->rs_cookie_manager_group__rstitle->value}]
                                        </label>
                                    </div>
                                    <div>[{$oGroup->rs_cookie_manager_group__rsdescription->value|nl2br}]</div>
                                </div>
                                <div class="text-left">
                                    <a href="#" class="rs_cookie_manager_group_more" data-group-id="[{$oGroup->getId()}]" class="text-link">
                                        [{oxmultilang ident="rs_cookie_manager_popup_more"}]&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                                    </a>
                                    <div class="collapse" data-group-id="[{$oGroup->getId()}]">
                            [{/if}]
                                        <div class="rs_cookie_manager_item" data-item-group-id="[{$oGroup->getId()}]" data-item-id="[{$oItem->getId()}]">
                                            <b>[{$oItem->rs_cookie_manager__rstitle->value}]</b>
                                            <div>[{$oItem->rs_cookie_manager__rsdescription->value|nl2br}]</div>
                                        </div>
                            [{if $smarty.foreach.listitems.last}]
                                    </div>
                                </div>
                                <hr>
                            [{/if}]
                        [{/foreach}]
                    [{/foreach}]
                    </form>
                </div>
                <div class="text-left mb-2 mb-lg-0">
                    [{oxifcontent ident="oxsecurityinfo" object="oCont_secu"}]
                        <a id="securitypop" class="et-cmsbtns mr-2" rel="nofollow" href="[{$oCont_secu->getLink()}]" onclick="window.open('[{$oCont_secu->getLink()|oxaddparams:"plain=1"}]', 'securityinfo_popup', 'resizable=yes,status=no,scrollbars=yes,menubar=no,width=700,height=500');return false;">[{$oCont_secu->oxcontents__oxtitle->value}]</a>
                    [{/oxifcontent}]
                    [{oxifcontent ident="oximpressum" object="oCont_imprint"}]
                        <a id="imprintpop" class="et-cmsbtns" rel="nofollow" href="[{$oCont_imprint->getLink()}]" onclick="window.open('[{$oCont_imprint->getLink()|oxaddparams:"plain=1"}]', 'imprint_popup', 'resizable=yes,status=no,scrollbars=yes,menubar=no,width=700,height=500');return false;">[{$oCont_imprint->oxcontents__oxtitle->value}]</a>
                    [{/oxifcontent}]
                </div>
                <div class="text-right text-lg-right">
                    <a rel="nofollow" id="rs_cookie_manager_accept" href="" class="mt-2 btn btn-outline-success btn-default">[{oxmultilang ident="rs_cookie_manager_popup_button_accept"}]</a>
                    <a rel="nofollow" id="rs_cookie_manager_accept_all" href="" class="mt-2 ml-2 btn btn-success">[{oxmultilang ident="rs_cookie_manager_popup_button_accept_all"}]</a>
                </div>
            </div>
        </div>
    </div>
</div>
[{capture}]<script>[{/capture}]
[{capture name="rsscript"}]
    
    
    [{if $display}]
        rs_cookie_manager_popup_open();
    [{/if}]
    
    function rs_cookie_manager_popup_open()
    {
        $('#rs_cookie_manager_popup').modal('show');
        return false;
    }
    
    function rs_cookie_manager_popup_close()
    {
        setTimeout("$('#rs_cookie_manager_popup').modal('hide')", 500);
    }
    
    $('#rs_cookie_manager_accept_all').click(function() {
        
        /* check all */
        $('#rs_cookie_manager_popup input[type="checkbox"]').each(function(index) {
            $(this)[0].checked = true;
        });
        
        return rs_cookie_manager_accept();
    });
    $('#rs_cookie_manager_accept').click(function() {
        return rs_cookie_manager_accept();
    });
    function rs_cookie_manager_accept()
    {
        /* sync ajax request */
        var data = $('#rs_cookie_manager_popup_form').serialize();
        $.ajax({
            async:false,
            method: "POST",
            url: "[{$oViewConf->getSslSelfLink()}]",
            data: data
        }).done(function( msg ) {
            /* nothing */
        }).always(function() {
            /* nothing */
        });
        
        rs_cookie_manager_popup_close();
        return true;
    }
    

$('.rs_cookie_manager_group_more').click(function() {
    let id = $(this).attr('data-group-id');
    $(this).next().toggleClass('show');
            if($(this).next().hasClass('show')){
                 $(this).find('i').attr('style','transform: rotate(180deg)');
            }else{
                $(this).find('i').removeAttr('style');
            }
});


[{/capture}]
[{capture}]<script>[{/capture}]
[{oxscript add=$smarty.capture.rsscript}]