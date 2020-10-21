<div>
    <div class="card">
        <div class="card-header">
         Your Refferal Link
         {{-- @php
             $user = get_current_user_data();
         @endphp --}}
        </div>
        <div class="card-body">

            @if($affiliateId == null)

            <h5 class="card-title">You have no refferal link</h5>
            <p class="card-text">Click the below button to generate your refferal link.</p>
          
            <a href="#" wire:click="generateAffiliateId()" class="btn btn-primary">Generate Link</a>
         
            
            @else

            <p class="card-text">Copy and share this link to invite peoples.</p>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" readonly value="{{  getRefferalLink($currentUser->ref_id) }}" id="copyText">
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="copyBtn" onclick="clickAndCopy()" >Copy</button>
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>
