<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\AffiliateEarning;
use App\AffiliateWithdraw;

class WithdrawHistoryComponent extends Component
{
    public $perPage = 3;
    public $shouldLoad = 1;
    public $loadMore = true;
    public $total;

    protected $listeners = [
        'withdraw-updated' => '$refresh'
    ];

    public function mount()
    {
        $this->total = AffiliateWithdraw::where('status','!=' ,'pending')->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->shouldLoad;


        $this->total = AffiliateWithdraw::where('status','!=' ,'pending')->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }

        // $this->emit('load-more');
    }



    public function delete($id)
    {
        // dd($id);
        $wt =  AffiliateWithdraw::where('id', $id)->first();
        $wt->delete();

        $earning = AffiliateEarning::where('user_id', $wt->user_id)->first();
        $earning->available_payout = $earning->available_payout + $wt->amount;
        $earning->save();

        $this->total = AffiliateWithdraw::where('status','!=' ,'pending')->get()->count();
        
        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }


    }
    public function render()
    {
        $data['withdraws'] = AffiliateWithdraw::where('status','!=' ,'pending')->latest()->paginate($this->perPage);
        // $this->emit('');
        return view('livewire.admin.withdraw-history-component', $data);
    }
}
