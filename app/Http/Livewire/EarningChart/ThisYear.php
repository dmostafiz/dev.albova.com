<?php

namespace App\Http\Livewire\EarningChart;

use Livewire\Component;
use App\AffiliateEarningRecord;
use Illuminate\Support\Facades\DB;

class ThisYear extends Component
{
    public $year;
    public $earningCount;
    public $months = [];

    public function mount()
    {
        $this->year = date('Y');
        $earnings = AffiliateEarningRecord::where('user_id', get_current_user_id())
                            ->whereYear('created_at', date('Y'))
                            ->get();

        $earningCount = 0;

        foreach($earnings as $item)
        {
            $earningCount += $item->amount;
        }

        $this->earningCount = $earningCount;


        $this->months = AffiliateEarningRecord::where('user_id', get_current_user_id())
                                                ->selectRaw("sum(amount) as sum") 
                                                ->selectRaw("MONTHNAME(created_at) as month") 
                                                ->selectRaw("MONTH(created_at) as m") 
                                                ->whereYear('created_at', date('Y'))
                                                ->groupBy('month')
                                                ->orderBy('m', 'ASC')
                                                ->get()->toArray();

    }


    public function render()
    {
        return view('livewire.earning-chart.this-year');
    }
}
