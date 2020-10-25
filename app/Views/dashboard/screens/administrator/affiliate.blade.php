@include('dashboard.components.header')

<div id="wrapper">
    @include('dashboard.components.top-bar')
    @include('dashboard.components.nav')
    <div class="content-page">
        <div class="content">
            @include('dashboard.components.breadcrumb', ['heading' => __('Users affiliate program')])
            {{--Start Content--}}
            {{-- @php
                $earning = \App\Controllers\EarningController::get_inst()->getEarning(get_current_user_id());
            @endphp --}}

            <div class="row">

                <div class="col-md-12">
                    @livewire('admin.withdraw-requests-component')
                </div>
                <div class="col-md-12">
                    @livewire('admin.withdraw-history-component')
                </div>

            </div>


    

            {{--End content--}}
            @include('dashboard.components.footer-content')
        </div>
    </div>
</div>
@push('pageScripts')

<script>
    function clickAndCopy() {
      var copyText = document.getElementById("copyText");
      var copyBtn = document.getElementById("copyBtn");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
      copyBtn.innerHTML = "Copied!";
    }

    

</script>
@endpush
@include('dashboard.components.footer')

