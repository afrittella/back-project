@push('after_styles')
<link href="{{ asset('vendor/back-project/') }}/css/dropzone.min.css" rel="stylesheet">
@endpush

@push('bottom_scripts')
<script src="{{ asset('vendor/back-project/js/dropzone.min.js') }}"></script>

<script type="text/javascript">
$( document ).ready(function() {
    Dropzone.autoDiscover = false;

    var dropz = $("form.dropzone").dropzone({
        dictDefaultMessage: "{{ trans('back-project::base.file_upload') }}",
        paramName: 'attachment',
        init: function() {
        this.on("success", function() {
        location.reload();
    });

    this.on("error", function(file, message) {
        alert(message);
    });

    this.on("complete", function(file) {
        console.log(arguments);
        var img = this;

        setTimeout(function() {
        img.removeFile(file)
        }, 2000);
    });
    }
    });
});
</script>
@endpush