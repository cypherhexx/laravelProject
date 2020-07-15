@extends('layouts.customer.main')
@section('title', __('form.projects'))
@section('content')


<style>
    @media (max-width: 768px) {
      .created {
            display: none;
        }

        #data tr > *:nth-child(3) {
                display: none;
        }
    }

    .btn.open {
        background: #1cbcd8;
        color: #fff;
        }

    .btn {
            padding: 0;
        border-radius: 5px;
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin: 0 10px 10px 0;
        height: 40px;
        float: left;
    }

    .btn-filters .btn p {
    margin: 0;
    padding: 0px 25px;
    font-size: 14px;
    }

    .btn-filters .btn .badge {
        position: relative;
        top: 0;
        padding: 12px 20px 11px 17px;
        font-size: 15px;
        font-weight: 500;
        letter-spacing: .3px;
        border-radius: 0 5px 5px 0;
    }

    .btn-filters .badge::after {
        border-bottom: 38px solid #f8f9fa;
        border-left: 14px solid transparent;
        height: 0;
        width: 30px;
        content: "";
        position: absolute;
        top: 0;
        left: -14px;
    }
    .btn-filters .btn.in_progress {
        background: #ffb136;
        color: #fff;
    }

    .btn-filters .btn.on_hold {
        background: #9a9a9a;
        color: #fff;
    }

    .btn-filters .btn.cancel {
        background: #ff1053;
        color: #fff;
    }

    .btn-filters .btn.completed {
        background: #2ecc71;
        color: #fff;
    }
</style>

<!-- <div class="main-content">
    <h4>@lang('form.projects')</h4>
    <hr>
    <div class="row btn-filters">
        <button  class="btn btn-raised open" type="button">
            <span _ngcontent-vbs-c23="" class="badge badge-light">1</span>
            <p _ngcontent-vbs-c23="">Open</p>   
        </button>
        <div class="col-md-2 bd-highlight">
            <h5>{{ $data['stat']['not_started'] }}</h5>
            <div>@lang('form.not_started')</div>
        </div>
        <div class="col-md-2 bd-highlight">
            <h5>{{ $data['stat']['in_progress'] }}</h5>
            <div class="text-success">@lang('form.in_progress')</div>
        </div>
        <div class="col-md-2 bd-highlight">
            <h5>{{ $data['stat']['on_hold'] }}</h5>
            <div class="text-danger">@lang('form.on_hold')</div>
        </div>
        <div class="col-md-2 bd-highlight">
            <h5>{{ $data['stat']['cancelled'] }}</h5>
            <div class="text-primary">@lang('form.cancelled')</div>
        </div>
        <div class="col-md-2 bd-highlight">
            <h5>{{ $data['stat']['finished'] }}</h5>
            <div class="text-danger">@lang('form.finished')</div>
        </div>
 
    </div>
  
    <hr>
    <table class="table dataTable no-footer dtr-inline collapsed" width="100%" id="data">
        <thead>
        <tr>
            <th>@lang("form.name")</th>    
            <th>@lang("form.start_date")</th>
            <th>@lang("form.dead_line")</th>
            <th>@lang("form.billing_type")</th>
            <th>@lang("form.status")</th>
        </tr>
        </thead>
    </table>
</div> -->

<div class="main-content">
    <h4>@lang('form.projects')</h4>
    <hr>
    <div class="row btn-filters">
        <div class="col-md-2 bd-highlight" style="margin-top: 10px">
             <button  class="btn btn-raised open" type="button">
                <span _ngcontent-vbs-c23="" class="badge badge-light">{{ $data['stat']['not_started'] }}</span>
                <p _ngcontent-vbs-c23="">@lang('form.not_started')</p>   
            </button>
        </div>
        <div class="col-md-2 bd-highlight" style="margin-top: 10px">
            <button _ngcontent-ibf-c20="" class="btn btn-raised in_progress" type="button">
                <span _ngcontent-ibf-c20="" class="badge badge-light">{{ $data['stat']['in_progress'] }}</span>
                <p _ngcontent-ibf-c20="">@lang('form.in_progress')</p>
            </button>
        </div>
        <div class="col-md-2 bd-highlight" style="margin-top: 10px">
            <button _ngcontent-hjp-c20="" class="btn btn-raised on_hold" type="button">
                <span _ngcontent-hjp-c20="" class="badge badge-light">{{ $data['stat']['on_hold'] }}</span>
                <p _ngcontent-hjp-c20="">@lang('form.on_hold')</p>
            </button>
        </div>
        <div class="col-md-2 bd-highlight" style="margin-top: 10px">
            <button _ngcontent-hjp-c20="" class="btn btn-raised cancel" type="button">
                <span _ngcontent-hjp-c20="" class="badge badge-light">{{ $data['stat']['cancelled'] }}</span>
                <p _ngcontent-hjp-c20="">@lang('form.cancelled')</p>
            </button>
        </div>
        <div class="col-md-2 bd-highlight" style="margin-top: 10px">
            <button _ngcontent-hjp-c20="" class="btn btn-raised completed" type="button">
                <span _ngcontent-hjp-c20="" class="badge badge-light">{{ $data['stat']['finished'] }}</span>
                <p _ngcontent-hjp-c20="">@lang('form.finished')</p>
            </button>
        </div>
 
    </div>
  
    <hr>
    <table class="table dataTable table-hover no-footer dtr-inline collapsed" width="100%" id="data">
        <thead>
        <tr>
            <th>@lang("form.name")</th>    
            <th>@lang("form.start_date")</th>
            <th>@lang("form.dead_line")</th>
            <th>@lang("form.billing_type")</th>
            <th>@lang("form.status")</th>
        </tr>
        </thead>
    </table>
</div>
@endsection

@section('onPageJs')
    <script>

        $(function() {

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
                responsive: true,
                processing: true,
                serverSide: true,
                //iDisplayLength: 5
                pageLength: 10,
                ordering: false,
                // "columnDefs": [
                //     { className: "text-right", "targets": [2,4] },
                //     { className: "text-center", "targets": [5] }
                //
                //
                // ],
                "ajax": {
                    "url": '{!! route("customer_panel_datatable_projects_list") !!}',
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            }).
            on('mouseover', 'tr', function() {
                jQuery(this).find('div.row-options').show();
            }).
            on('mouseout', 'tr', function() {
                jQuery(this).find('div.row-options').hide();
            });

        });


    </script>


@endsection