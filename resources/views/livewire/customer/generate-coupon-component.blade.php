<div>
    {{-- The Master doesn't talk, he acts. --}}
    @if($availableBalance > 1)
        @if(!$done)
            <div class="input-group mb-3 pl-5 pr-5">
                <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">$</span>
                </div>
                <input type="number" class="form-control form-control-sm" wire:model="availableAmount" placeholder="Amount">

                @if($permission)
                <button class="btn btn-success btn-sm float-right ml-2" type="button" wire:click="generateCoupon()">Generate now</button>
                @endif
                @if(!$permission)
                    <p class="text-warning mt-2">{{ $message }}</p>
                @endif
            </div>
        @else 
            <p class="text-success">New coupon generated Successfully.</p>
            <h4>{{ $code }}</h4>
            <button class="btn btn-outline-success float-right" wire:click="thatsGreat()" title="Withdraw Confirmed">
                Thats Great!
            </button>
        @endif
    @else 

    <h4 class="text-warning mt-2">You cannot generate coupons with 0 balance</h4>
        
    @endif

  
</div>
