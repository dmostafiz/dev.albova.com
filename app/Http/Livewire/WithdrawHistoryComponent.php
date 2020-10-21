<?php

namespace App\Http\Livewire;

use App\AffiliateWithdraw;
use Livewire\Component;

class WithdrawHistoryComponent extends Component
{
    protected $histories;

    public function mount()
    {
        $histories = AffiliateWithdraw::where('user_id', get_current_user_id())
                    ->latest()
                    ->paginate(3);
        $this->histories = $histories;

    }

    public function render()
    {
        $data['histories'] = $this->histories;
        return view('livewire.withdraw-history-component', $data);
    }
}
