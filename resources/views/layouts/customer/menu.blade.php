<style>

   li a{
      float: right;
   }
   .new_nav:hover{
      background: rgb(255,255,255,0.2)!important;
      border: 1px solid rgb(255,255,255,0.2);
      border-radius: 10px!important;
   }

   .new_nav a:hover{
      background: rgb(0,0,0,0)!important;
   }

   .actived a:hover{
      background: rgb(255,255,255,0.2)!important;
      border: 1px solid rgb(255,255,255,0.2);
      border-radius: 10px!important;
   }

   .actived {
      background: rgb(255,255,255,0.2)!important;
      border: 1px solid rgb(255,255,255,0.2);
      border-radius: 10px!important;
      margin-top: 2px;
      margin-left: 10px !important;
   }

   .new_nav {
      margin-top: 2px;
      margin-left: 10px !important;
      border-radius: 10px !important;
   }

   .sidebar.active {
      display: none!important;
   }

   ul {
      margin-top: 10px;
      padding-right: 3px;
   }


</style>
<nav id="sidebar" class="sidebar">
   
      <!-- <a class="navbar-brand" href="{{ route('customer_dashboard') }}">
      @if(get_company_logo(NULL, TRUE) )
      <img src="{{ get_company_logo(NULL, TRUE) }}" class="img-fluid" alt="{{ config('constants.company_name') }}">
      @else
      {{ config('constants.company_name') }}
      @endif  
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button> -->
      <div class="sidebar-sticky" style="width: 240px;background-image: linear-gradient(45deg,#360033,#0b8793);height: calc(100vh - 0px)!important;
    background-repeat: repeat-x;">

         @if(Request::is('client*'))
            <ul class="navbar-nav mr-auto">
               @if(Auth::check() && is_current_user_a_customer())
               @if((isset($nameSpace))&&($nameSpace == "dashboard"))
               <li class="nav-item actived">
                  <a class="nav-link" href="{{ route('customer_dashboard') }}" style="color: white; font-weight: lighter;"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> &nbsp; @lang('form.dashboard')</a>
               </li>
               @else
                <li class="nav-item new_nav">
                  <a class="nav-link" href="{{ route('customer_dashboard') }}" style="color: white; font-weight: lighter;"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> &nbsp; @lang('form.dashboard')</a>
               </li>
               @endif
               @if((isset($nameSpace))&&($nameSpace == "project"))
               <li class="nav-item actived">
                  <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('customer_panel_projects_list') }}"><i class="fas fa-tasks" aria-hidden="true"></i> &nbsp;@lang('form.projects')</a>
               </li>
               @else
               <li class="nav-item new_nav">
                  <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('customer_panel_projects_list') }}"><i class="fas fa-tasks" aria-hidden="true"></i> &nbsp;@lang('form.projects')</a>
               </li>
               @endif
               @if((isset($nameSpace))&&($nameSpace == "invoices"))
               <li class="nav-item actived">
                  <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('cp_invoice_list') }}"><i class="far fa-file-alt menu-icon"></i> &nbsp;@lang('form.invoices')</a>
               </li>
               @else
               <li class="nav-item new_nav">
                  <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('cp_invoice_list') }}"><i class="far fa-file-alt menu-icon"></i> &nbsp;@lang('form.invoices')</a>
               </li>
               @endif
               @if((isset($nameSpace))&&($nameSpace == "estimates"))
               <li class="nav-item actived">
                  <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('cp_estimate_list') }}"><i class="fa fa-calculator"></i> &nbsp;@lang('form.estimates')</a>
               </li>
               @else
               <li class="nav-item new_nav">
                  <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('cp_estimate_list') }}"><i class="fa fa-calculator"></i> &nbsp;@lang('form.estimates')</a>
               </li>
               @endif
                  @if(!is_support_feature_disabled())
                  @if((isset($nameSpace))&&($nameSpace == "support"))
                  <li class="nav-item actived">
                     <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('cp_ticket_list') }}"><i class="fas fa-headset menu-icon"></i> &nbsp;@lang('form.support')</a>
                  </li>
                  @else
                  <li class="nav-item new_nav">
                     <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('cp_ticket_list') }}"><i class="fas fa-headset menu-icon"></i> &nbsp;@lang('form.support')</a>
                  </li>
                  @endif
                  @endif
                  @if((isset($nameSpace))&&($nameSpace == "statement"))
                  <li class="nav-item actived">
                  <a class="nav-link"  style="color: white; font-weight: lighter;" href="{{ route('cp_customer_statement_page') }}"><i class="fas fa-address-card"></i> &nbsp;@lang('form.account_statement')</a>
               </li>
               @else
               <li class="nav-item new_nav">
                  <a class="nav-link"  style="color: white; font-weight: lighter;" href="{{ route('cp_customer_statement_page') }}"><i class="fas fa-address-card"></i> &nbsp;@lang('form.account_statement')</a>
               </li>
               @endif
               @endif

               @if(!is_knowledge_base_feature_disabled())
                  @if((isset($nameSpace))&&($nameSpace == "knowledge_base"))
                  <li class="nav-item actived">
                     <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('knowledge_base_home') }}"><i class="far fa-folder-open menu-icon"></i> &nbsp;@lang('form.knowledge_base')</a>
                  </li>
                  @else
                  <li class="nav-item new_nav">
                     <a class="nav-link" style="color: white; font-weight: lighter;" href="{{ route('knowledge_base_home') }}"><i class="far fa-folder-open menu-icon"></i> &nbsp;@lang('form.knowledge_base')</a>
                  </li>
                  @endif
               @endif 
            </ul>
         
         @endif
      </div>
   
</nav>
