@extends('layouts.customer.main')
@section('title', __('form.new_ticket')   )
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

<style>
.select2-container--bootstrap .select2-results__option--highlighted[aria-selected] {
    background-color: #eee !important;
    color: inherit !important;
}
</style>



<form id="ticketForm" method="post" action="{{ (isset($rec->id)) ? route( 'patch_ticket', $rec->id) : route('cp_post_ticket') }}">
<div class="main-content" style="">
   
    <h5>@lang('form.new_ticket')</h5>
    <hr>
    
      {{ csrf_field()  }}
      @if(isset($rec->id))
      {{ method_field('PATCH') }}
      @endif      

 <div class="form-group">
               <label>@lang('form.subject') <span class="required">*</span> </label>
               <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'subject') }}" name="subject" value="{{ old_set('subject', NULL,$rec) }}">
               <div class="invalid-feedback">{{ showError($errors, 'subject') }}</div>
            </div>


        
         <div class="form-row">

           

                <div class="form-group col-md-4">
                      <label>@lang('form.department') <span class="required">*</span></label>
                      <?php
                         echo form_dropdown('department_id', $data['department_id_list'] , old_set('department_id', NULL,$rec), "class='form-control selectPickerWithoutSearch'");
                         
                         ?>
                      <div class="invalid-feedback d-block">{{ showError($errors, 'department_id') }}</div>
                   </div>


                    <div class="form-group col-md-4">
                      <label>@lang('form.priority') <span class="required">*</span></label>
                      <?php
                         echo form_dropdown('ticket_priority_id', $data['ticket_priority_id_list'] , old_set('ticket_priority_id', NULL,$rec), "class='form-control selectPickerWithoutSearch'");
                         
                         ?>
                      <div class="invalid-feedback d-block">{{ showError($errors, 'ticket_priority_id') }}</div>
                   </div>


                    <div class="form-group col-md-4">
                  <label>@lang('form.project') <span class="required">*</span></label>
                  <?php
                     echo form_dropdown('project_id', $data['project_id_list'] , old_set('project_id', NULL,$rec), "class='form-control selectPickerWithoutSearch'");
                     
                     ?>
                  <div class="invalid-feedback d-block">{{ showError($errors, 'project_id') }}</div>
               </div>

       


                </div>



            

     
     <div class="form-group">
  <label>@lang('form.details') <span class="required">*</span></label>
  <textarea style="display: none" name="details" id="details" rows="10" class="form-control form-control-sm">{{ old_set('details', NULL,$rec) }}</textarea>
  <input name="image" style="display: none" value="how to do image procession">
   <div id="editor">
    <div id='edit' style="margin-top: 30px;">
     
    </div>
  </div>
  <div class="invalid-feedback d-block">{{ showError($errors, 'details') }}</div>
</div>   

<?php upload_button('ticketForm'); ?>

      <div style="text-align: right;">
                    <input type="submit" class="btn btn-primary" value="@lang('form.submit_ticket')"/>

                </div>
</div>



   </form>   


@section('innerPageJs')
   <script type="text/javascript">
     
     $(function(){

        


     });
   </script>

   @endsection

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


@yield('innerPageJs')
@endsection