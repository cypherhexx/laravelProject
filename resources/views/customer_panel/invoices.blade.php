@extends('layouts.customer.main')
@section('title', __('form.invoices'))
@section('content')


<style>
  @media (max-width: 768px) {
      .created {
        display: none;
      }

      #data_filter input {
            width: 130px!important;
        }

        #data tr > *:nth-child(3) {
                display: none;
        }

        .buttons-collection {
            flex: none!important;
        }

        .dt-buttons.btn-group {
            position: relative; 
            top: 45px;
            direction: ltr!important;
        }

        .buttons-collection {
            position: relative;
            top: 10px;
            left: 10px;
        }

        .dropdown-item span {
            text-align: left;
            color: black!important;
        }

        #data_filter:before {
            font-family: "Font Awesome 5 Free";
            content: ""!important;
            display: none;
            padding-right: -15px;
            vertical-align: middle;
            font-weight: 900;
            position: relative;
            right: 16px;
            top: 65px;
        }
  }

  td span {
    display: block;
    font-size: .9em;
    line-height: 22px;
    border: 2px solid #ccc;
    border-radius: 3px;
    background-color: #fff;
    color: #333;
    padding: 3px 5px;
    font-size: 15px;
    font-weight: lighter;
    text-align: center;
  }

  tr:nth-child(even){background-color: rgb(248,252,253);}

  .Unpaid {
    color: red;
  }

    td {
        border: none!important;
    }

    thead tr th {
        border-top: none!important;
        background: white!important;
        font-weight: bolder!important;
        border-bottom: 4px solid rgb(123,193,98)!important;
      
    }



    #data_filter input {
        width: 200px!important;
        border: none;
        height: 40px;
        background: rgb(240,240,240);
        padding-right: 40px;
        float: right;
        margin-top: 8px;
        margin-bottom: 8px;
        margin-right: 10px;
    }

    #data_filter label {
        background: linear-gradient(45deg,#0c0a0b,#0b8793);
        width: 100%!important;
    }

    .buttons-collection {
        padding-top: 8px!important;
        padding-left: 8px!important;
        color: white;
        font-size: 18px;
    }

      .dt-buttons.btn-group {
        position: relative; 
        top: 45px;
    }

    .dt-buttons.btn-group button {
        background: transparent!important;
        border: none;
    }


    #data_filter:before {
        font-family: "Font Awesome 5 Free";
        content: "\f0b0";
        display: inline-block;
        padding-right: -15px;
        vertical-align: middle;
        font-weight: 900;
        position: relative;
        right: 16px;
        top: 57px;
    }

 /* td {
    height: 40px;
    margin-top: 5px;
  }*/
</style>

<div class="main-content">

<h6>@lang('form.invoices')</h6>
<hr>

<table class="table dataTable no-footer table-list dtr-inline collapsed" width="100%" id="data">
    <thead>
        <tr>
            <th style="border-color: rgb(123,193,98)!important ">@lang("form.invoice_#")</th>
            <th style="border-color: rgb(162,210,122)!important ">@lang("form.amount")</th>
            <th style="border-color: rgb(123,193,98)!important ">@lang("form.total_tax")</th>        
            <th style="border-color: rgb(162,210,122)!important ">@lang("form.date")</th>
            <th class="created" style="border-color: rgb(123,193,98)!important ">@lang("form.due_date")</th>            
            <th style="border-color: rgb(162,210,122)!important ">@lang("form.status")</th>
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