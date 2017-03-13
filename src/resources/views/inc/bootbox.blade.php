@push('bottom_scripts')
    <script src="{{ asset('vendor/back-project') }}/js/bootbox.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("[data-action='delete']").click(function (event) {
                var link = $(this).attr("href");

                event.stopPropagation();
                event.preventDefault();

                bootbox.confirm({
                    message: "{{ trans('back-project::crud.are_you_sure') }}",
                    buttons: {
                        confirm: {
                            label: "{{ trans('back-project::crud.yes') }}",
                            className: "btn-success btn-xs"
                        },
                        cancel: {
                            label: "{{ trans('back-project::crud.no') }}",
                            className: "btn-error btn-xs"
                        },
                    },
                    callback: function (result) {
                        if (result) {
                            window.location.href = link;
                        }
                    }
                });
            });

        });
    </script>
@endpush