<?php

namespace App\Http\Livewire\RegistrationChart;

use Carbon\Carbon;
use App\AffiliateClick;
use Livewire\Component;
use App\AffiliateRegistration;

class PreviousMonth extends Component
{
    
    public $clickCount;
    public $monthName;

    public function mount()
    {
        $this->monthName = Carbon::now()->subMonth()->format('F');
        $this->clickCount = AffiliateRegistration::where('user_id', get_current_user_id())
                          ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                          ->get()->count();
    }


    public function render()
    {
        return view('livewire.registration-chart.previous-month');
    }
}
