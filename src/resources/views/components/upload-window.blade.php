<div id="media-manager-single-upload" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $title }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => $url, 'method' => 'post', 'class' => "dropzone", 'id' => "media-manager-image-form"]) !!}
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('back-project::base.close') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('after_styles')
    <link href="{{ asset('vendor/back-project/') }}/css/dropzone.min.css" rel="stylesheet">
@endpush

@push('bottom_scripts')
    <script src="{{ asset('vendor/back-project') }}/js/dropzone.min.js"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        $( document ).ready(function() {

            $('#media-manager-single-upload').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');

                if (undefined !== url) {
                    $("#media-manager-image-form").attr('action', url);
                }

                var dropz = $("form.dropzone").dropzone({
                    dictDefaultMessage: "{{ trans('back-project::base.file_upload') }}",
                    acceptedFiles: "image/*",
                    paramName: 'attachment',
                    maxFiles: {{ $max_upload_files or "null" }},
                    maxFileSize: {{config('back-project.attachments.max_file_size')}},
                    init: function() {
                        this.on("success", function() {
                            location.reload();
                        });

                        this.on("error", function(file, message) {
                            if (message.attachment) {
                                alert(message.attachment);
                            } else {
                                alert('Error');
                            }
                        });

                        this.on("complete", function(file) {
                            //console.log(arguments);
                            var img = this;

                            setTimeout(function() {
                                img.removeFile(file)
                            }, 2000);
                        });
                    }
                });
            });


        });
    </script>
@endpush