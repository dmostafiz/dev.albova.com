<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\AffiliateEarning;

class AffiliateLink extends Component
{
    public $currentUser;
    public $affiliateId;
    // protected $listeners = [
    //     'idGenerated' => '$refresh'
    // ];

    public function mount()
    {
        $this->currentUser = get_current_user_data();
        $this->affiliateId = $this->currentUser->ref_id;
    }

    public function generateAffiliateId()
    {
        
        $user = User::where('id', $this->currentUser->id )->first();

        $newRefId = substr(time(), -4) . $user->id;

        $user->ref_id = $newRefId;
        $user->save();

        $this->currentUser = $user;
        $this->affiliateId = $user->ref_id;

        $earning = AffiliateEarning::where('user_id', get_current_user_id())->first();

        if(!$earning)
        {
           $earning = new AffiliateEarning();
           $earning->user_id = get_current_user_id();
           $earning->total_earning = 0;
           $earning->this_month = 0;
           $earning->available_payout = 0;
           $earning->save();

        }

        // $this->emit('idGenerated');


    }
    public function render()
    {

        return view('livewire.affiliate-link');
    }
}
