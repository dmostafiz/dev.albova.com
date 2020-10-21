<?php

namespace App\Http\Livewire\RegistrationChart;

use App\AffiliateRegistration;
use Livewire\Component;

class ThisMonth extends Component
{
    public $clickCount;
    public $monthName;

    public function mount()
    {

        $this->monthName = date('F');
        $this->clickCount = AffiliateRegistration::whereMonth('created_at', date('m'))
        ->where('user_id', get_current_user_id())
        ->whereYear('created_at', date('Y'))
        ->get()->count();
    }
    
    public function render()
    {
        return view('livewire.registration-chart.this-month');
    }
}
