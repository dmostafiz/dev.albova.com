<?php

namespace App\Http\Livewire\EarningChart;

use Carbon\Carbon;
use Livewire\Component;
use App\AffiliateEarningRecord;

class PreviousMonth extends Component
{
    public $earningCount;
    public $monthName;

    public function mount()
    {
        $this->monthName = Carbon::now()->subMonth()->format('F');
        $earnings = AffiliateEarningRecord::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                          ->get();

        $earningCount = 0;

        foreach($earnings as $item)
        {
            $earningCount += $item->amount;
        }

        $this->earningCount = $earningCount;

    }
    
    public function render()
    {
        return view('livewire.earning-chart.previous-month');
    }
}
