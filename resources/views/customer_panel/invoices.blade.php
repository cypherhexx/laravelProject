@extends('layouts.customer.main')
@section('title', __('form.invoices'))
@section('content')


<style>
  @media (max-width: 768px) {
      .created {
        display: none;
      }
  }
</style>

<div class="main-content">

<h6>@lang('form.invoices')</h6>
<hr>

<table class="table dataTable no-footer dtr-inline collapsed" width="100%" id="data">
    <thead>
        <tr>
            <th>@lang("form.invoice_#")</th>
            <th>@lang("form.amount")</th>
            <th>@lang("form.total_tax")</th>        
            <th>@lang("form.date")</th>
            <th class="created">@lang("form.due_date")</th>            
            <th>@lang("form.status")</th>
        </tr>
    </thead>
</table>


@endsection

@section('onPageJs')

<script>

        $(function () {

           $('#data').DataTable({

                dom: 'Bfrtip',
                buttons: [

                    {
                        init: function(api, node, config) {
                            $(node).removeClass('btn-secondary')
                        },
                        className: "btn-light btn-sm",
                        extend: 'collection',
                          text: 'יְצוּא ',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ]
                    }
                ],
                "language": {
                    "lengthMenu": '_MENU_ ',
                    "search": '',
                    "searchPlaceholder": "{{ __('form.search') }}"
                    // "paginate": {
                    //     "previous": '<i class="fa fa-angle-left"></i>',
                    //     "next": '<i class="fa fa-angle-right"></i>'
                    // }
                }

                ,

                pageResize: true,
                responsive: true,
                processing: true,
                serverSide: true,
                // iDisplayLength: 5,
                pageLength: {{ data_table_page_length() }},
                ordering: false,
                "columnDefs": [
                    { className: "text-right", "targets": [1,2] }
                    // { className: "text-center", "targets": [5] }
                ],
                "ajax": {
                    "url": '{!! route("cp_datatable_invoices") !!}',
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });


        });

       </script> 
@endsection