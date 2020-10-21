<div>
    <div class="card"> 
        <div class="card-header bg-white pb-0">
          <div class="float-left" style="font-weight: 900">
             Earning statistics
          </div>  

          <div class="form-group float-right">
            <select wire:model="currentPeriod" class="form-control form-control-sm" id="">
              <option value="thismonth">This Month</option>
              <option value="previousmonth">Previous Month</option>
              <option value="thisyear">This Year</option>
            </select>
          </div>

        </div>

        @if($currentPeriod == 'thismonth')
            @livewire('earning-chart.this-month')
        @elseif($currentPeriod == 'previousmonth')
            @livewire('earning-chart.previous-month')
        @elseif($currentPeriod == 'thisyear')
            @livewire('earning-chart.this-year')
        @endif

    </div>
</div>
