<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">   
    <link rel="stylesheet" href="{{  url(mix('css/vendor.css')) }}">
    <link rel="stylesheet" href="{{  url(mix('css/app.css')) }}">
    {{ load_extended_files('customer_css') }}
</head>
<style type="text/css">
  #content_customer {
    margin-right: auto;
    margin-left: auto;
  }


  .col-md-3 {
    text-align: right!important;
  }

  .col-md-6 {
    text-align: right!important;
  }

   .col-md-2 {
    text-align: right!important;
  }

  th {
    text-align: right;
  }
  td {
    text-align: right;
  }

   @media (max-width: 1700px) {
      #content_customer {
        margin-right: 50px;
      }
   }

   @media (max-width: 768px) {
      .sidebar {
         display: none;
      }

      #sidebar.active {
        display: block!important;
        position: absolute;
        right: 0px;
        top: 70px;
        bottom: 0px;
        transition:.5s;
      }

      #content_customer {
        padding-left: 0px !important;
        margin-right: auto!important;
      }

   }

</style>
<body>

<nav class="navbar navbar-expand navbar-dark bg-dark flex-md-nowrap">
   <a class="navbar-brand navbar-brand col-sm-3 col-md-2 mr-0 d-none d-sm-block" href="#">
      <div>
        @if(get_company_logo(NULL, TRUE))
          <img src="{{ get_company_logo(NULL, TRUE) }}" class="img-fluid" alt="{{ config('constants.company_name') }}">  
         @else 
            <h5>Netpower</h5>
          {{ get_company_logo(NULL, TRUE) }}
         @endif
      </div>
   </a>

   <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav">
         <li class="nav-item active">
            <a href="#" id="sidebarCollapse"><i class="fa fa-bars"></i></a>
         </li>
      </ul>

      <ul class="navbar-nav ml-auto">
              

           @if(!Auth::check() || is_current_user_a_team_member() )                  

              @if(!is_customer_registration_feature_disabled())
                 <li class="nav-item active">
                    <a class="nav-link" href="{{ route('customer_registration_page') }}">@lang('form.register')</a>
                 </li>
              @endif   
           <li class="nav-item active">
              <a class="nav-link" href="{{ route('customer_login_page') }}">@lang('form.login')</a>
           </li>
           @endif
           @if(Auth::check() && is_current_user_a_customer())
           <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
              <i class="fas fa-user"></i> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                 <a class="dropdown-item" href="{{ route('cp_user_profile') }}">@lang('form.profile')</a>
                 <a class="dropdown-item" href="{{ route('cp_change_password') }}">@lang('form.change_password')</a>
                 <a class="dropdown-item" href="{{ route('customer_logout') }}"> @lang('form.logout')</a>
              </div>
           </li>
            @endif
        </ul>
   </div>
</nav>

<div class="wrapper">
    @include('layouts.customer.menu')
    <div id="content_customer" style="width: 1600px; padding-left: 30px; ">
    <br>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    global_config = {
        csrf_token                          : "{{ csrf_token() }}",
        url_get_unread_notifications        : "", 
        lang_no_record_found                : "",
        url_global_search                   : "",

        url_upload_attachment               : "{{ route('cp_upload_attachment') }}",
        url_delete_temporary_attachment     : "{{ route('cp_delete_temporary_attachment')}}",
        txt_delete_confirm_title            : "{{ __('form.delete_confirm_title') }}",
        txt_delete_confirm_text             : "{{ __('form.delete_confirm_text') }}",
        txt_btn_cancel                      : "{{ __('form.btn_cancel') }}",
        txt_yes                             : "{{ __('form.yes') }}",        
        is_pusher_enable                    : false

    };
</script>

<script type="text/javascript" src="{{  url(mix('js/app.js')) }}"></script>
<script  type="text/javascript" src="{{  url(mix('js/vendor.js')) }}"></script>
<script  type="text/javascript" src="{{  url(mix('js/main.js')) }}"></script>
<script  type="text/javascript" src="{{ asset('vendor/gantt-chart/js/modified_jquery.fn.gantt.min.js') }}"></script>
{{ load_extended_files('customer_js') }}
<script type="text/javascript">
  accounting.settings = <?php echo json_encode(config('constants.money_format')) ?>;

    $(function(){

         <?php if($flash = session('message')) {?>
            $.jGrowl("<?php echo $flash; ?>", { position: 'bottom-right'});
        <?php } ?>
    });

</script>

<script  src="{{  url(mix('js/tinymce.js')) }}"></script>
@yield('onPageJs')

</body>

</html>
