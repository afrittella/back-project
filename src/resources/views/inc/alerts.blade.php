@push('after_styles')
<link href="{{ asset('vendor/back-project/') }}/css/animate.min.css" rel="stylesheet">
<link href="{{ asset('vendor/back-project/') }}/css/pnotify.custom.css" rel="stylesheet">
<style type="text/css">
    .ui-pnotify.stack-bar-bottom {

        bottom: 0;
        top: auto;
        left: auto;
    }
</style>
@endpush

@push('bottom_scripts')
<script src="{{ asset('vendor/back-project/js/pnotify.custom.min.js') }}"></script>

{{-- Bootstrap Notifications using Prologue Alerts --}}
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        PNotify.prototype.options.styling = "fontawesome";
        var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};

        _alert = window.alert;
        window.alert = function (message) {
            new PNotify({
                title: 'Info',
                text: message,
                icon: true,
                addclass: "stack-bar-bottom",
                stack: stack_bar_bottom,
                buttons: {
                    sticker: false,
                    closer: true,
                },
                animate: {
                    animate: true,
                    in_class: 'slideInUp',
                    out_class: 'slideOutDown'
                }
            });
        };


        @foreach (Alert::getMessages() as $type => $messages)
            @foreach ($messages as $message)
                $(function () {
                    var type = "{{  $type }}";
                    var title = "Info";
                    switch (type) {
                        case 'error':
                            title = 'Ups!';
                            break;
                        case 'success':
                            title = 'OK';
                            break;
                    }
                    new PNotify({
                        title: title,
                        text: "{{ $message }}",
                        type: "{{ $type }}",
                        icon: true,
                        addclass: "stack-bar-bottom",
                        //cornerclass: "",
                        //width: "50%",
                        stack: stack_bar_bottom,
                        buttons: {
                            sticker: false,
                            closer: true,
                        },
                        animate: {
                            animate: true,
                            in_class: 'slideInUp',
                            out_class: 'slideOutDown'
                        }
                    });
            });
        @endforeach
        @endforeach
    });
</script>
@endpush
