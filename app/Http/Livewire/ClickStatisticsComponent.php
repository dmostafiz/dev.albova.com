<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ClickStatisticsComponent extends Component
{
    public $currentPeriod = 'thismonth';

    public function render()
    {
        return view('livewire.click-statistics-component');
    }
}
