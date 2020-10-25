<?php

namespace App\Http\Livewire\Admin;

use App\Models\Payout;
use Livewire\Component;
use App\AffiliateEarning;
use App\AffiliateWithdraw;

class WithdrawRequestsComponent extends Component
{
    // public $withhistories = [];


    public $perPage = 3;
    public $shouldLoad = 1;
    public $loadMore = true;
    public $total;

    // protected $listeners = [
    //     'load-more' => '$refresh'
    // ];

    public function mount()
    {
        $this->total = AffiliateWithdraw::where('status', 'pending')->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->shouldLoad;


        $this->total = AffiliateWithdraw::where('status', 'pending')->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }

        // $this->emit('load-more');
    }

    public function approve($id)
    {
        // dd($id);
        $wt =  AffiliateWithdraw::where('id', $id)->first();

        if ($wt) 
        {
            $user_id = $wt->user_id;
        
            $amount = (float)$wt->amount;
            $payoutID = 'PO-' . date('Ymd') . $user_id;
            $data = [
                'user_id' => $user_id,
                'payout_id' => $payoutID,
                'amount' => $amount,
                'created' => time(),
                'status' => 'pending'
            ];
            $payout_model = new Payout();
            $new_payout_id = $payout_model->insertPayout($data);

            do_action('hh_calculator_payout_each_partners', $user_id, $new_payout_id);
       
        }
        //######################


        $wt->status = 'approved';
        $wt->save();

        $this->total = AffiliateWithdraw::where('status', 'pending')->get()->count();
        
        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }
        
        $this->emit('withdraw-updated');

    }
    
    public function decline($id)
    {
        // dd($id);
        $wt =  AffiliateWithdraw::where('id', $id)->first();
        $wt->status = 'declined';
        $wt->save();

        $earning = AffiliateEarning::where('user_id', $wt->user_id)->first();
        $earning->available_payout = $earning->available_payout + $wt->amount;
        $earning->save();

        $this->total = AffiliateWithdraw::where('status', 'pending')->get()->count();
        
        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }

        $this->emit('withdraw-updated');

    }
    
    public function render()
    {
        $data['withdraws'] = AffiliateWithdraw::where('status', 'pending')->latest()->paginate($this->perPage);
        // $this->emit('');
        return view('livewire.admin.withdraw-requests-component', $data);
    }
}
