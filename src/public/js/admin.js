// Delete password field if empty
$(document).ready(function(){
    $("form").submit(function(){
        $("input").each(function(index, obj){
            if($(obj).val() == "" && $(obj).attr('name') == "password") {
                $(obj).remove();
            }
        });
    });
});

$(function () {
    $('[data-toggle="control-sidebar"]').controlSidebar();
    $('[data-toggle="push-menu"]').pushMenu();

    var $pushMenu       = $('[data-toggle="push-menu"]').data('lte.pushmenu');
    var $controlSidebar = $('[data-toggle="control-sidebar"]').data('lte.controlsidebar');
    var $layout         = $('body').data('lte.layout');

    $('[data-toggle="tooltip"]').tooltip();
})
