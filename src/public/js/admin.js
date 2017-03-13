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