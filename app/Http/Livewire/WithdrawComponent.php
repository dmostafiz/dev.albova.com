<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\AffiliateEarning;
use App\AffiliateWithdraw;

class WithdrawComponent extends Component
{
    public $amount;
    public $withdraw = false;
    public $permission = true;
    public $minimum = 50;

    public function mount()
    {
        $earning = AffiliateEarning::where('user_id', get_current_user_id())->first();

        if($earning)
        {
            $this->amount = $earning->available_payout;

            if($earning->available_payout < $this->minimum)
            {
                 $this->permission = false;
            }
        }
        else 
        {
            $this->amount = 0;
            $this->permission = false;
        }



    }

    public function withdrawNow()
    {
        $earning = AffiliateEarning::where('user_id', get_current_user_id())->first();

        if($earning)
        {
            $earning->available_payout = 0;
            $earning->save();
        }

        $withdraw = new AffiliateWithdraw();
        $withdraw->user_id = get_current_user_id();
        $withdraw->amount = $this->amount;
        $withdraw->status = "pending";
        $withdraw->save();

        $this->withdraw = true;

    }

    public function thatsGreat()
    {
        return redirect('/dashboard/affiliate-program');
    }

    public function render()
    {
        return view('livewire.withdraw-component');
    }
}
