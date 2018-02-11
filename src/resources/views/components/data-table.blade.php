<table id="{{ $id or 'table' }}" class="table {{$table_class or "table-striped table-bordered" }}" cellspacing="0" width="100%">
    <thead>
    <tr>
        @foreach ($head['columns'] as $column)
            <th>{{ $column }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($body as $row)
        <tr>
            @foreach ($row['columns'] as $column)
                <td>
                    @if (false === $column['content'])
                        @if (!isset($column['icon']))
                            @each('back-project::components.data-table-action', $column['actions'], 'action')
                        @else
                            {!! icon($column['icon']) !!}
                        @endif
                    @else
                        {!!  $column['content'] !!}
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

@push('after_styles')
    <link href="{{ asset('vendor/adminlte/') }}/bower_components/datatables.net/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush

@push('bottom_scripts')
    <script src="{{ asset('vendor/adminlte/') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/adminlte/') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $( document ).ready(function () {
            var table = $('.table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "pagingType": "full_numbers",
                "columnDefs": [{
                    "targets": -1,
                    "orderable" : false
                }],
                language: {
                    "sEmptyTable":     "Nessun dato presente nella tabella",
                    "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
                    "sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
                    "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ".",
                    "sLengthMenu":     "Visualizza _MENU_ elementi",
                    "sLoadingRecords": "Caricamento...",
                    "sProcessing":     "Elaborazione...",
                    "sSearch":         "Cerca:",
                    "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
                    "oPaginate": {
                        "sFirst":      "Inizio",
                        "sPrevious":   "Precedente",
                        "sNext":       "Successivo",
                        "sLast":       "Fine"
                    },
                    "oAria": {
                        "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
                        "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
                    }
                }
            });
        });
    </script>
@endpush
