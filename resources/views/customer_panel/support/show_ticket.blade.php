@extends('layouts.customer.main2')
@section('title', __('form.tickets'))
@section('content')


<style type="text/css">
  video {
    width: 250px!important;
    height: 250px!important;
  }
</style>

<div style="margin-bottom: 20%;">
   <div class="row">
      <div class="col-md-4">
         <div class="card">
            <div class="card-header">@lang('form.ticket_information')</div>
            <div class="card-body">
               <table class="table table-borderless table-sm">
                  <tr>
                     <td>@lang('form.department')</td>
                     <td>{{ $rec->department->name }}</td>
                  </tr>
                  <tr>
                     <td>@lang('form.priority')</td>
                     <td>{{ $rec->priority->name }}</td>
                  </tr>
                  <tr>
                     <td>@lang('form.status')</td>
                     <td>{{ $rec->status->name }}</td>
                  </tr>
                  <tr>
                     <td>@lang('form.submitted')</td>
                     <td>{{ $rec->created_at->format('d-M-Y h:i:s a') }}</td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-8">
         <div class="main-content" style="margin-bottom: 10px !important">
            <h5 class="card-title">{{ ($rec->number) }} : {{ $rec->subject }}</h5>
            <hr>
            <form id="ticketForm" action="{{ route('cp_ticket_add_reply', $rec->id) }}" method="POST" autocomplete="off">
               {{ csrf_field()  }}
               <input type="hidden" name="id" value="{{ $rec->id }}">
               <div class="form-group">
                  <label style="font-size: 18px;">@lang('form.add_reply_to_this_ticket')</label>
                  <textarea  name="details" id="summernote" rows="6" class="form-control form-control-sm">{{ old_set('details', NULL,$rec) }}</textarea>

               


                  <div class="invalid-feedback d-block">{{ showError($errors, 'details') }}</div>
               </div>
               <?php upload_button('ticketForm'); ?>
               <input type="submit" class="btn btn-primary btn-sm" name="submit" value="@lang('form.add_reply')">
            </form>
         </div>
         @include('customer_panel.support.partials.comment_thread')    
      </div>
   </div>
</div>


  @endsection


@section('onPageJs')

   <script>
      $('#summernote').summernote({
        placeholder: '',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    </script>
    <script>
        $(function () {

<?php if(Request::query('jumpto')) {?>
             $('html, body').animate({
                    scrollTop: $("#{{ Request::query('jumpto') }}").offset().top
                }, 1000);
             <?php } ?>

        });
    </script>

@endsection