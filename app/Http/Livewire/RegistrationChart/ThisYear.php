<?php

namespace App\Http\Livewire\RegistrationChart;

use App\AffiliateClick;
use Livewire\Component;
use App\AffiliateRegistration;
use Illuminate\Support\Facades\DB;

class ThisYear extends Component
{

    public $year;
    public $clickCount;
    public $months = [];

    public function mount()
    {
        $this->year = date('Y');
        $this->clickCount = AffiliateRegistration::where('user_id', get_current_user_id())
                            ->whereYear('created_at', date('Y'))
                            ->get()->count();

        $this->months = AffiliateRegistration::where('user_id', get_current_user_id())
        ->selectRaw("COUNT('*') as count")
        ->selectRaw("MONTHNAME(created_at) as month") 
        ->selectRaw("MONTH(created_at) as m") 
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('m', 'ASC')
        ->get()->toArray();
    }

    public function render()
    {
        return view('livewire.registration-chart.this-year');
    }
}
