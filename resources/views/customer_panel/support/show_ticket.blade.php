@extends('layouts.customer.main')
@section('title', __('form.tickets'))
@section('content')
<link rel="stylesheet" href="{{asset('froala/css/froala_editor.css')}}">


<link rel="stylesheet" href="{{asset('froala/css/froala_editor.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/froala_style.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/code_view.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/colors.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/emoticons.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/image_manager.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/image.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/line_breaker.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/table.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/char_counter.css')}}">
<link rel="stylesheet" href="{{asset('froala/css/plugins/video.css')}}">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"> -->

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
                  <textarea style="display: none" name="details" id="details" rows="6" class="form-control form-control-sm">{{ old_set('details', NULL,$rec) }}</textarea>

                   <div id="editor">
                    <div id='edit' style="margin-top: 30px;">
                     
                    </div>
                  </div>



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

 <!--  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script> -->
  <script type="text/javascript" src="{{asset('froala/js/froala_editor.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/align.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/code_beautifier.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/code_view.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/colors.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/draggable.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/emoticons.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/font_size.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/font_family.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/image.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/image_manager.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/line_breaker.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/link.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/lists.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/paragraph_format.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/paragraph_style.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/table.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/video.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/url.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/entities.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/char_counter.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/inline_style.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('froala/js/plugins/save.min.js')}}"></script>


@section('onPageJs')

  <script>
    (function () {
      new FroalaEditor("#edit", {
        fullPage: true,
         events: {
        initialized: function () {
        
        },
        contentChanged: function () {
          const editor = this
          document.getElementById('details').innerHTML = editor.html.get()
          console.log('change detection',editor.html.get() )
        }
      }
      })
    })()
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