<div>
    <div class="card ">
        <div class="card-header bg-white" style="border-bottom: 2px solid #F3F4F6 !important;">
            <div style="font-weight: 900">
                Your Invitation Link
            </div>
         {{-- @php
             $user = get_current_user_data();
         @endphp --}}
        </div>
        <div class="card-body">

            @if($affiliateId == null)

            {{-- <h5 class="card-title">You have no refferal link</h5> --}}
            <p class="card-text">Click the button to generate your refferal link.</p>
          
            <a href="#" wire:click="generateAffiliateId()" class="btn btn-primary">Generate Link</a>
         
            
            @else

                <div class="input-group pt-1 pb-2">
                    <input type="text" class="form-control border-success form-control-sm" readonly value="{{  getRefferalLink($currentUser->ref_id) }}" id="copyText">
                    <div class="input-group-append">
                    <button class="btn btn-outline-success" type="button" id="copyBtn" onclick="clickAndCopy()" >Copy</button>
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>
