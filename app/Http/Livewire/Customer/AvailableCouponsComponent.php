<?php

namespace App\Http\Livewire\Customer;

use App\Models\Coupon;
use Livewire\Component;

class AvailableCouponsComponent extends Component
{
    protected $coupons;

    public function mount()
    {
        $coupons = Coupon::where('author', get_current_user_id())
                    ->where('status','on')
                    ->orderBy('coupon_id', 'DESC')
                    ->get()
                    ->take(3);
        $this->coupons = $coupons;

    }


    public function render()
    {
        $data['coupons'] = $this->coupons;
        return view('livewire.customer.available-coupons-component', $data);
    }
}
