<style type="text/css">
    td {text-align: right; direction: rtl;} 
    .col-md-3 {
        text-align: right!important;
        direction: rtl;
    }
</style>

<div class="row">

    <div class="col-md-7">
        <h6>@lang('form.overview')</h6>
        <hr style="margin-top: 23px">
        <div class="row">
            <div class="col-md-5" style="background: white;padding-left: 0px!important; padding-right: 0px!important; border: 1px solid rgba(0,0,0,.125); ">
            
                  <div class="card-header" style="text-align: center;">
                    <h3 class="card-title">@lang('form.details')</h3>
                </div>
                <div style="padding: 30px;">
                <table class="table project-overview-table" style="">
                    <tbody>
                    <tr class="project-overview-customer">
                        <td><a href="{{ route('view_customer_page', $rec->customer_id) }}">{{ $rec->customer->name }}</a>
                        </td>
                        <td class="bold">@lang('form.customer')</td>
                    </tr>
                    <tr class="project-overview-billing">
                        <td>{{ $rec->billing_type->name }}</td>
                        <td class="bold">@lang('form.billing_type')</td>
                    </tr>
                    @if($rec->billing_type_id != BILLING_TYPE_TASK_HOURS)
                        <tr>
                            <td>{{ format_currency($rec->billing_rate, true) }}</td>
                            <td class="bold">{{ ($rec->billing_type_id == BILLING_TYPE_FIXED_RATE) ? __('form.total_rate') : __('form.rate_per_hour') }}</td>
                        </tr>
                    @endif    
                    <tr class="project-overview-status">
                        <td>{{ $rec->status->name }}</td>
                        <td class="bold">@lang('form.status')</td>
                    </tr>
                    <tr class="project-overview-date-created">
                        <td>{{ sql2date($rec->created_at) }}</td>
                        <td class="bold">@lang('form.date_created')</td>
                    </tr>
                    <tr class="project-overview-start-date">
                        <td>{{ sql2date($rec->start_date) }}</td>
                        <td class="bold">@lang('form.start_date')</td>
                    </tr>
                    <tr class="project-overview-deadline">
                        <td>{{ ($rec->dead_line) ? sql2date($rec->dead_line) : '' }}</td>
                        <td class="bold">@lang('form.dead_line')</td>
                    </tr>
                    
                    </tbody>
                </table>
                </div>
            </div>

            <div class="col-md-7">
                <h3 class="text-center">@lang('form.project_progress')</h3>
                <!-- <canvas width="100%" height="100%" id="project_progress"></canvas> -->
                <div class="ro" id="chart" style="margin-top: 60px;width: 300px; height: 300px;">
                </div>
            </div>
        </div>
        

        <hr>
        <div id="description" class="row">
            <div class="col-md-6">
            <h6>@lang('form.description')</h6>
            <div style="font-size: 13px;"><?php echo nl2br($rec->description); ?></div>
            </div>
            <div class="col-md-6">
            @if(check_customer_project_permission($rec->settings->permissions, 'view_team_members')) 
            <div id="members">
                <h6>@lang('form.members')</h6>
                <?php $members = $rec->members; ?>
                @if(count($members) > 0)
                    <ul class="list-unstyled" style="font-size: 13px;">
                    @foreach($members as $member)
                        <li class="media">
                        <img class="staff-profile-image-small mr-2" src="{{ asset('images/user-placeholder.jpg') }}" alt="Generic placeholder image">
                        <div class="media-body">
                          <div class="mt-0 mb-1">
                            <a href="{{ route('member_profile', $member->id )}}">
                                {{ $member->first_name . " ". $member->last_name }}
                            </a>
                        </div>
                          
                        </div>
                        <br>
                      </li>

                    @endforeach
                    </ul>
                @endif
            </div>
            <hr>
        @endif
        </div>

        </div>

        


    </div>

    <div class="col-md-5" style="border-left: 1px solid #eee;">
        <div class="row">
            <div class="{{ (isset($rec->start_date) && isset($rec->dead_line)) ? 'col-md-6' : 'col-md-12' }}">
                <h6 style="font-weight: bold">
                    {{ count($rec->open_tasks) }} / {{ count($rec->tasks) }} {{ strtoupper(__('form.open_tasks')) }}
                   <i class="fas fa-check-circle float-md-right" style="color: #eee; font-size: 24px; padding-right: 10px;padding-left: 10px;"></i>
                </h6>
            </div>
            <div class="col-md-6">
                @if(isset($rec->start_date) && isset($rec->dead_line))
                    <?php
                    $now        = \Carbon\Carbon::now();
                    $start      = \Carbon\Carbon::parse($rec->start_date);
                    $end        = \Carbon\Carbon::parse($rec->dead_line);                    
                    $total_days = $end->diffInDays($start);
                    $days_left  = $now->diffInDays($end, false);


                    ?>
                    <h6 style="font-weight: bold">
                        {{ $days_left }} / {{ $total_days }} {{ strtoupper(__('form.days_left')) }}
                       <i  class="far fa-calendar-check float-md-right" style="color: #eee; font-size: 24px; padding-right: 10px; padding-left: 10px;"></i>
                    </h6>


                @endif



            </div>
        </div>
        <hr>
        @if(check_customer_project_permission($rec->settings->permissions, 'view_task_total_logged_time')) 
            
            @if($rec->billing_type_id != BILLING_TYPE_FIXED_RATE)  
                @include('project.partials.overview.timesheet_overview')
                <hr>
            @endif 
        @endif 

        @if(check_customer_project_permission($rec->settings->permissions, 'view_finance_overview')) 
            @include('project.partials.overview.expenses_overview')        
            <hr>
        @endif
        
       <!--  @if(check_customer_project_permission($rec->settings->permissions, 'view_team_members')) 
            <div id="members">
                <h6>@lang('form.members')</h6>
                <?php $members = $rec->members; ?>
                @if(count($members) > 0)
                    <ul class="list-unstyled" style="font-size: 13px;">
                    @foreach($members as $member)
                        <li class="media">
                        <img class="staff-profile-image-small mr-2" src="{{ asset('images/user-placeholder.jpg') }}" alt="Generic placeholder image">
                        <div class="media-body">
                          <div class="mt-0 mb-1">
                            <a href="{{ route('member_profile', $member->id )}}">
                                {{ $member->first_name . " ". $member->last_name }}
                            </a>
                        </div>
                          
                        </div>
                        <br>
                      </li>

                    @endforeach
                    </ul>
                @endif
            </div>
            <hr>
        @endif -->

          
        <div id="tags">
            <h6>@lang('form.tags')</h6>
            <?php echo $rec->get_tags_as_badges(); ?>
        </div>

    </div>
</div>
<!-- <div style="background: white;width: 220px;">
<div id="piechart_3d" style="width: 200px; height: 200px; background: transparent!important;"></div>
<h5>@lang('form.project_progress') :{{ $rec->progress_percentage() }}% </h5>
</div> -->




@section('innerPageJS')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
    
    var percentCompleted = "{{ $rec->progress_percentage() }}";
    var done =  parseInt(percentCompleted);
    var options = {
      series: [(done), (100 - done)],
      chart: {
      type: 'donut',
    },
      colors: [ '#ff0000','#546E7A'],
    labels: ["done", "left"],
    responsive: [{
      breakpoint: 700,
      options: {
        chart: {
          width: 300
        },
        legend: {
          position: 'bottom'
        }
      }
    },{
      breakpoint: 1700,
      options: {
        chart: {
          width: 330
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
      
</script>


    @endsection