<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

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

        // $this->emit('idGenerated');


    }
    public function render()
    {

        return view('livewire.affiliate-link');
    }
}
