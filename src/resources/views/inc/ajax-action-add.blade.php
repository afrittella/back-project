@push('bottom_scripts')
<script type="text/javascript">
    $( document ) . ready( function () {
        var options = {
            success: onSuccess,
            error: onError,
            beforeSubmit: beforeSubmit,
            resetForm: true
        };
        $("form.ajax-handled").ajaxForm(options);

        function onSuccess(responseText, statusText, xhr, form) {
            location.reload();
        }

        function onError(response) {
            //console.log(response.responseJSON);
            if ("" !== response.responseText) {
                $.each(response.responseJSON, function(i, item) {
                    var field = $("[name="+i+"]");
                    field.parent("div.form-group").addClass('has-error');
                });
            }
        }

        function beforeSubmit(arr, form, options) {
            form.find('input').attr('disabled', 'disabled');
            form.find('button').attr('disabled', 'disabled');
        }
    });
</script>
@endpush