<?php

namespace App\Http\Livewire\EarningChart;

use App\AffiliateEarningRecord;
use Livewire\Component;

class ThisMonth extends Component
{
    public $earningCount;
    public $monthName;

    public function mount()
    {

        $this->monthName = date('F');
        $earnings = AffiliateEarningRecord::whereMonth('created_at', date('m'))
        ->where('user_id', get_current_user_id())
        ->whereYear('created_at', date('Y'))
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
        return view('livewire.earning-chart.this-month');
    }
}
