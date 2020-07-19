    <?php $expenses_stat = $rec->expenses_stat(); ?>
       <!--  <div class="row">
                <div class="col-md-3">
                    <span class="text-secondary">@lang('form.total_expenses')</span>                   
                   <div>{{ format_currency($expenses_stat['total_expenses'], TRUE)  }}</div>

                </div>
                <div class="col-md-3">
                    <span class="text-primary">@lang('form.billable_expenses')</span>
                    <div>{{ format_currency($expenses_stat['billable_expenses'], TRUE) }}</div>

                </div>
                <div class="col-md-3">
                    <span class="text-success">@lang('form.billed_expenses')</span>
                    <div>{{ format_currency($expenses_stat['billed_expenses'], TRUE) }}</div>

                </div>
                <div class="col-md-3">
                    <span class="text-danger">@lang('form.unbilled_expenses')</span>
                    <div>{{ format_currency($expenses_stat['unbilled_expenses'], TRUE) }}</div>

                </div>
         </div> -->

    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header" style="text-align: center;">
                <h3 class="card-title">@lang('form.my_balance')</h3>
            </div>
            <div class="card-body">
                <span>@lang('form.total_expenses')</span>
                <h4><span class="counter">{{ format_currency($expenses_stat['total_expenses'], TRUE)  }}</span></h4>
                
                <div class="form-group">
                    <label class="d-block">@lang('form.billable_expenses') <span class="float-right"><span class="counter">{{ format_currency($expenses_stat['billable_expenses'], TRUE) }}</span></span></label>
                    <div class="progress progress-xs">
                         @if(format_currency($expenses_stat['total_expenses'], TRUE) == 0)
                        <div class="progress-bar bg-azure" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 0%; background-color: red;"></div>
                        @else
                           <div class="progress-bar bg-azure" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="background-color: red;width: {{ format_currency($expenses_stat['billable_expenses'], TRUE) / format_currency($expenses_stat['total_expenses'], TRUE) * 100 }} %;"></div>   
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="d-block">@lang('form.billed_expenses') <span class="float-right"><span class="counter">{{ format_currency($expenses_stat['billed_expenses'], TRUE) }}</span></span></label>

                    <div class="progress progress-xs">
                          @if(format_currency($expenses_stat['total_expenses'], TRUE) == 0)
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="background-color: green;width: 0%;"></div>
                        @else
                         <div class="progress-bar bg-green" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="background-color: green;width: {{ format_currency($expenses_stat['billed_expenses'], TRUE) / format_currency($expenses_stat['total_expenses'], TRUE) * 100 }} %;"></div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="d-block">@lang('form.unbilled_expenses') <span class="float-right"><span class="counter">{{ format_currency($expenses_stat['unbilled_expenses'], TRUE) }}</span></span></label>
                    <div class="progress progress-xs">
                         @if(format_currency($expenses_stat['total_expenses'], TRUE) == 0)
                        <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        @else
                        <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: {{ format_currency($expenses_stat['unbilled_expenses'], TRUE) / format_currency($expenses_stat['total_expenses'], TRUE) * 100 }}%;"></div>
                        @endif
                    </div>
                </div>
            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 304px; height: 393px;"></div></div><div class="contract-trigger"></div></div></div>
            <div class="card-footer">
                <a href="javascript:void(0)" class="btn btn-block btn-info btn-sm">View More</a>
            </div>
        </div>
    </div>

