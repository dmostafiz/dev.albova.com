<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RegistrationStatisticsComponent extends Component
{
    public $currentPeriod = 'thismonth';
    
    public function render()
    {
        return view('livewire.registration-statistics-component');
    }
}
