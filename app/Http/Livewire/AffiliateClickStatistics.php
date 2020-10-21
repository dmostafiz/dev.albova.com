<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Charts\AffiliateClickStatisticsChart;

class AffiliateClickStatistics extends Component
{


    public $chartTitle;
    public $currentChart;
    
    protected $currentMonth;
    protected $previousMonth;



    public function mount($currentMonth, $previousMonth)
    {
        $this->currentMonth = $currentMonth;
        $this->previousMonth = $previousMonth;
        
        $this->chartTitle = "This month's statistics"; 
        $this->currentChart = "current"; 
    }

    public function currentMonth()
    {
        $this->chartTitle = "This month's statistics"; 
        $this->currentChart = "current";
    }

    public function previousMonth()
    {
        $this->chartTitle = "Previous month's statistics"; 
        $this->currentChart = "previous";
    }

    public function last12months()
    {
        $this->chartTitle = "last 12 month's statistics"; 
        $this->currentChart = "last12";
    }


    public function render()
    {
        $data['currentMonth'] = $this->currentMonth;
        $data['previousMonth'] = $this->previousMonth;

        return view('livewire.affiliate-click-statistics',$data);
    } 
}
