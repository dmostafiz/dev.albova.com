<?php

namespace App\Http\Livewire\Customer;

use App\Models\Coupon;
use Livewire\Component;
use App\AffiliateEarning;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class GenerateCouponComponent extends Component
{

    public $availableBalance;
    public $availableAmount;
    public $permission = true;
    public $message;
    public $done = false;
    public $code;

    public function mount()
    {
        $earning = AffiliateEarning::where('user_id', get_current_user_id())->first();

        if($earning)
        {
            $this->availableAmount = $earning->available_payout;
            $this->availableBalance = $earning->available_payout;

            if($this->availableAmount > $earning->available_payout || $this->availableAmount < 1)
            {
                 $this->permission = false;
                 $this->message = "You can't exide your available balance";
            }
        }
        else 
        {
            $this->availableAmount = 0;
            $this->permission = false;
            $this->message = "No records found";
        }
    }

    public function generateCoupon()
    {

        $earning = AffiliateEarning::where('user_id', get_current_user_id())->first();

        if($this->availableAmount > $earning->available_payout|| $this->availableAmount < 1)
        {
             $this->permission = false;
             $this->message = "You can't exide your available balance";
        }
        else
        {
            $earning->available_payout = $earning->available_payout - $this->availableAmount; 
            $earning->save();

            // $code = Str::random();
            $endDate =  time() + 160356699;

            $this->code = Str::random();

            $coupon = new Coupon();
            $coupon->timestamps = false;
            $coupon->coupon_code = $this->code;
            $coupon->coupon_description = "Customer Affiliate earning coupon";
            $coupon->start_time = time();
            $coupon->end_time = $endDate;
            $coupon->coupon_price = $this->availableAmount;
            $coupon->price_type = 'fixed';
            $coupon->author = get_current_user_id();
            $coupon->status = 'on';
            $coupon->save();

            $this->done = true;

        }


    }

    public function thatsGreat()
    {
        return redirect('/dashboard/affiliate-program');
    }

    public function render()
    {
            $earning = AffiliateEarning::where('user_id', get_current_user_id())->first();

            if($earning)
            {
                if($this->availableAmount > $earning->available_payout|| $this->availableAmount < 1)
                {
                     $this->permission = false;
                     $this->message = "You can't exide your available balance";
                }
                else
                {
                    $this->permission = true;
                }
            }

        return view('livewire.customer.generate-coupon-component');
    }
}
