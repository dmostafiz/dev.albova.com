@include('dashboard.components.header')

@push('affiliateStatistis')
    <style>
        span.clicks-count{
            font-siz:20px;
        }
    </style>
@endpush

<div id="wrapper">
    @include('dashboard.components.top-bar')
    @include('dashboard.components.nav')
    <div class="content-page">
        <div class="content">
            @include('dashboard.components.breadcrumb', ['heading' => __('Affiliate Program')])
            {{--Start Content--}}
            @php
                $earning = \App\Controllers\EarningController::get_inst()->getEarning(get_current_user_id());
            @endphp

            <div class="row">

                <div class="col-md-6">
                    @livewire('affiliate-link')
                </div>

                <div class="col-md-6">
                    <div class="card-box card-payout">
                        <button class="btn btn-success float-right"
                           data-placement="bottom" title="" data-original-title="The total of withdrawals">Withdraw</button>
                        <h4 class="mt-0 font-16">{{__('Available Payouts')}}</h4>
                        <h2 class="my-3 text-center">
                            {{ current_currency('symbol') }}
                            <span data-plugin="counterup">{{ convert_price($earning['payout'], false) }}</span>
                        </h2>
                    </div>

                </div>

            </div>

            <div class="row">
                
                <div class="col-md-4">
                    @livewire('click-statistics-component')
                </div>

                <div class="col-md-4">
                    @livewire('registration-statistics-component')
                </div>

                <div class="col-md-4">
                    @livewire('earning-statistics-component')
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    @livewire('withdraw-history-component')
                </div>
                <div class="col-md-6">
                    {{-- earning-section --}}
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-box card-balance">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="You can make payout with this balance"></i>
                                    <h4 class="mt-0 font-16">{{__('Total Earnings')}}</h4>
                                    <h2 class="my-3 text-center">
                                        {{ current_currency('symbol') }}
                                        <span data-plugin="counterup">{{ convert_price($earning['balance'], false) }}</span>
                                    </h2>
                                </div>
                            </div>
        
                            <div class="col-md-6">
                                <div class="card-box card-net-earning">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="Total amount of owner after minus all the fees (commission) for administrator"></i>
                                    <h4 class="mt-0 font-16">{{__('Last Month')}}</h4>
                                    <h2 class="my-3 text-center">
                                        {{ current_currency('symbol') }}
                                        <span data-plugin="counterup">{{ convert_price($earning['net_amount'], false) }}</span>
                                    </h2>
                                </div>
                            </div>
        
                            <div class="col-md-6">
                                <div class="card-box card-earning">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="Your total amount"></i>
                                    <h4 class="mt-0 font-16">{{__('Payout')}}</h4>
                                    <h2 class="my-3 text-center">
                                        {{ current_currency('symbol') }}
                                        <span data-plugin="counterup">{{ convert_price($earning['amount'], false) }}</span>
                                    </h2>
                                </div>
                            </div>
        
                            <div class="col-md-6">
                                <div class="card-box card-payout">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title="" data-original-title="The total of withdrawals"></i>
                                    <h4 class="mt-0 font-16">{{__('Total refferals')}}</h4>
                                    <h2 class="my-3 text-center">
                                        {{ current_currency('symbol') }}
                                        <span data-plugin="counterup">{{ convert_price($earning['payout'], false) }}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    @livewire('registration-history-component')
                </div>

                <div class="col-md-7">
                    @livewire('earning-history-component')
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

