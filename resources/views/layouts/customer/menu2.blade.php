<style>
   #nextNav {
      display: none;
   }

   #disabled {
      display: none;
   }

   @media (max-width: 768px) {
      #nextNav {
         display: block;
      }

      #disabled {
         display: block;
      }

      .dropdown-menu.show {
         background: #343a40;
         border: none;
      }

      .dropdown-item {
         color: white;
         text-align: right;
      }

      #navbarsExample02 {
         background: #343a40!important;
         color: white;
         display: block;!important;
      }

      .navbar-nav.ml-auto {
         margin-top: 0px;
      }
   }
</style>

<div id="disabled">
   <div class="collapse navbar-collapse" id="navbarsExample02" style="display: flex;">
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
              <a style="color: #888888; margin-right: 10px;" class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
              <i class="fas fa-user"></i> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                 <a class="dropdown-item" href="{{ route('cp_user_profile') }}">@lang('form.profile')</a>
                 <a class="dropdown-item" href="{{ route('cp_change_password') }}">@lang('form.change_password')</a>
                 <a class="dropdown-item" href="{{ route('customer_logout') }}"> @lang('form.logout')</a>
              </div>
           </li>
            @endif
        </ul>
        <div style="color: #888888; padding-left: 10px;"><i class="fa fa-phone"></i> &nbsp;072-3994921</div>
   </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="nextNav">
   <div class="container">
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="{{ route('customer_dashboard') }}">
     <!--  @if(get_company_logo(NULL, TRUE) )
      <img src="{{ get_company_logo(NULL, TRUE) }}" class="img-fluid" alt="{{ config('constants.company_name') }}">
      @else
      {{ config('constants.company_name') }}
      @endif   -->
      <img itemprop="image" src="https://netpower-studio.com/wp-content/themes/pxlz/assets/img/logo.png" alt="Mobile Logo" style="height: 30px;">
      </a>
      <div class="collapse navbar-collapse" id="navbarsExample07">

         @if(Request::is('client*'))
            <ul class="navbar-nav mr-auto">
               @if(Auth::check() && is_current_user_a_customer())
               <li class="nav-item active">
                  <a class="nav-link" href="{{ route('customer_dashboard') }}">@lang('form.dashboard')</a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="{{ route('customer_panel_projects_list') }}">@lang('form.projects')</a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="{{ route('cp_invoice_list') }}">@lang('form.invoices')</a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="{{ route('cp_estimate_list') }}">@lang('form.estimates')</a>
               </li>
                  @if(!is_support_feature_disabled())
                  <li class="nav-item active">
                     <a class="nav-link" href="{{ route('cp_ticket_list') }}">@lang('form.support')</a>
                  </li>
                  @endif
                  <li class="nav-item active">
                  <a class="nav-link" href="{{ route('cp_customer_statement_page') }}">@lang('form.account_statement')</a>
               </li>
               @endif
            </ul>
         
            <!-- <ul class="navbar-nav ml-auto">
              
               @if(!is_knowledge_base_feature_disabled())
                  <li class="nav-item active">
                     <a class="nav-link" href="{{ route('knowledge_base_home') }}">@lang('form.knowledge_base')</a>
                  </li>
               @endif   

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
            </ul> -->
         @endif
      </div>
   </div>
</nav>
