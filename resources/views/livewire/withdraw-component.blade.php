<div>

    @if(!$withdraw)

        <h5 class="text-muted mb-3">Once you have confirm the withdraw, it will be waiting for admin approval. it may take some time.</h5>
        <table class="table table-bordered">
            <tr>
                <td>Amount</td>
                <td>{{ current_currency('symbol') }}{{ convert_price($amount, false) }}</td>
            </tr>
        </table>  

        @if($permission)
            <h5 class="text-muted mb-3">Are you sure to withdraw this amount?</h5>

            <button class="btn btn-success float-right" wire:click="withdrawNow()" title="Confirm the withdraw">
                Sure Please!
            </button>
                
            <button type="button" class="btn btn-secondary float-right mr-2" data-dismiss="modal">Cancel</button>

        @else 
            <h5 class="text-warning mb-3">Sorry! Your balance is lower than the minimum witdrawal amount. 
            you can withdraw at least {{ current_currency('symbol') }}{{ convert_price($minimum, false) }}</h5>

        @endif

    @else 
        <h5 class="text-muted mb-3">Awesome! Your amount is on the way..</h5>
  
        <button class="btn btn-outline-success float-right" wire:click="thatsGreat()" title="Withdraw Confirmed">
            Thats Great!
        </button>
    @endif

</div>
