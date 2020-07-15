@extends('layouts.customer.main')
@section('title', __('form.dashboard'))
@section('content')
<style type="text/css">
   h5 {
      text-align: right!important;
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
<div class="row" style="font-size: 13px;">
   <!-- <div class="col-md-6">
      <div class="main-content">
         <h5>@lang('form.projects')</h5>
         <hr>
         <div class="row">
            <div class="col-md-4 bd-highlight">
               <h5>{{ $data['project_stat']['not_started'] }}</h5>
               <div>@lang('form.not_started')</div>
            </div>
            <div class="col-md-4 bd-highlight">
               <h5>{{ $data['project_stat']['in_progress'] }}</h5>
               <div class="text-success">@lang('form.in_progress')</div>
            </div>
            <div class="col-md-4 bd-highlight">
               <h5>{{ $data['project_stat']['on_hold'] }}</h5>
               <div class="text-danger">@lang('form.on_hold')</div>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-4 bd-highlight">
               <h5>{{ $data['project_stat']['cancelled'] }}</h5>
               <div class="text-primary">@lang('form.cancelled')</div>
            </div>
            <div class="col-md-4 bd-highlight">
               <h5>{{ $data['project_stat']['finished'] }}</h5>
               <div class="text-danger">@lang('form.finished')</div>
            </div>
         </div>
      </div>
   </div> -->

   <div class="col-md-6">
      <div class="main-content">
         <h5>@lang('form.projects')</h5>
         <hr>
         <div class="row btn-filters">
            <div class="col-md-4 bd-highlight" style="margin-top: 10px">
             <button  class="btn btn-raised open" type="button">
                <span _ngcontent-vbs-c23="" class="badge badge-light">{{ $data['project_stat']['not_started'] }}</span>
                <p _ngcontent-vbs-c23="">@lang('form.not_started')</p>   
            </button>
           </div>
           <div class="col-md-4 bd-highlight" style="margin-top: 10px">
               <button _ngcontent-ibf-c20="" class="btn btn-raised in_progress" type="button">
                   <span _ngcontent-ibf-c20="" class="badge badge-light">{{ $data['project_stat']['in_progress'] }}</span>
                   <p _ngcontent-ibf-c20="">@lang('form.in_progress')</p>
               </button>
           </div>
           <div class="col-md-4 bd-highlight" style="margin-top: 10px">
               <button _ngcontent-hjp-c20="" class="btn btn-raised on_hold" type="button">
                   <span _ngcontent-hjp-c20="" class="badge badge-light">{{ $data['project_stat']['on_hold'] }}</span>
                   <p _ngcontent-hjp-c20="">@lang('form.on_hold')</p>
               </button>
           </div>
         </div>
         <hr>
         <div class="row btn-filters">
             <div class="col-md-4 bd-highlight" style="margin-top: 10px">
               <button _ngcontent-hjp-c20="" class="btn btn-raised cancel" type="button">
                   <span _ngcontent-hjp-c20="" class="badge badge-light">{{ $data['project_stat']['cancelled'] }}</span>
                   <p _ngcontent-hjp-c20="">@lang('form.cancelled')</p>
               </button>
           </div>
           <div class="col-md-4 bd-highlight" style="margin-top: 10px">
               <button _ngcontent-hjp-c20="" class="btn btn-raised completed" type="button">
                   <span _ngcontent-hjp-c20="" class="badge badge-light">{{ $data['project_stat']['finished'] }}</span>
                   <p _ngcontent-hjp-c20="">@lang('form.finished')</p>
               </button>
           </div>
         </div>
      </div>
   </div>

   <div class="col-md-6">
      <?php 
         $stat 	= $data['stat_unpaid_invoices'];
         $total = $data['stat_total_unpaid_invoices'];
         ?>
      <div class="main-content">
         <h5>@lang('form.invoices')</h5>
         <hr>
         <div class="row" style="margin-bottom: 30px; padding-top: 10px;">
            <div class="col-md-6">
               @lang('form.unpaid') : {{ $stat[INVOICE_STATUS_UNPAID]['number'] }} / {{ $total }}
               <?php gen_progress_bar('bg-danger', $stat[INVOICE_STATUS_UNPAID]['percent']) ;?>
            </div>
            <div class="col-md-6">
               @lang('form.partially_paid') : {{ $stat[INVOICE_STATUS_PARTIALLY_PAID]['number'] }} / {{ $total }}
               <?php gen_progress_bar('bg-warning', $stat[INVOICE_STATUS_PARTIALLY_PAID]['percent'] ) ;?>
            </div>
         </div>
         <hr>
         <div class="row" style="padding-top: 10px">
            <div class="col-md-6">
               @lang('form.over_due') : {{ $stat[INVOICE_STATUS_OVER_DUE]['number'] }} / {{ $total }}
               <?php gen_progress_bar('bg-info', $stat[INVOICE_STATUS_OVER_DUE]['percent'] ) ;?>
            </div>
            <div class="col-md-6">
               @lang('form.draft') : {{ $stat[INVOICE_STATUS_DRAFT]['number'] }} / {{ $total }}
               <?php gen_progress_bar('bg-secondary', $stat[INVOICE_STATUS_DRAFT]['percent'] ) ;?>
            </div>
         </div>
         <a href="{{ route('cp_customer_statement_page') }}">@lang('form.view_account_statement')</a>
      </div>
   </div>
</div>
@endsection