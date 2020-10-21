<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\AffiliateRegistration;

class RegistrationHistoryComponent extends Component
{
    protected $histories;

    public function mount()
    {
        $histories = AffiliateRegistration::where('user_id', get_current_user_id())
                    ->latest()
                    ->paginate(3);
        $this->histories = $histories;

    }

    public function render()
    {
        $data['histories'] = $this->histories;
        return view('livewire.registration-history-component',$data);
    }
}
