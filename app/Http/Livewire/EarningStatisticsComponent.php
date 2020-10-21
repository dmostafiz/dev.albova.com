<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EarningStatisticsComponent extends Component
{
    public $currentPeriod = 'thismonth';
    public function render()
    {
        return view('livewire.earning-statistics-component');
    }
}
