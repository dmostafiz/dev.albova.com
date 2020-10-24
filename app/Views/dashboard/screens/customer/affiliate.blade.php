@include('dashboard.components.header')


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
                        <button class="btn btn-success float-right" title="withdraw your earnings" data-toggle="modal" data-target="#withdrawModel" >
                            Generate Coupon
                        </button>


                        <div class="modal fade" id="withdrawModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Generate coupon</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body"> 
                                  @livewire('customer.generate-coupon-component')
                                </div>
                                {{-- <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div> --}}
                              </div>
                            </div>
                          </div>


                        <h4 class="mt-0 font-16">{{__('Available for Purchase')}}</h4>
                        <h2 class="my-3 text-center">
                            @php
                                $available_payout = ($affiliateEarning != null) ? $affiliateEarning->available_payout : 0;
                                $total_earning = ($affiliateEarning != null) ? $affiliateEarning->total_earning : 0;
                            @endphp
                            {{ current_currency('symbol') }}<span data-plugin="counterup">{{ convert_price($available_payout, false) }}</span>
                        </h2>
                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    @livewire('customer.available-coupons-component')
                </div>
                <div class="col-md-6">
                    {{-- earning-section --}}
                    <div class="">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card-box card-earning">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="You can purchase services using this balance"></i>
                                    <h4 class="mt-0 font-16">{{__('Available Purchase')}}</h4>
                                    <h2 class="my-3 text-center">
                                        {{ current_currency('symbol') }}
                                        <span data-plugin="counterup">{{ convert_price($available_payout, false) }}</span>
                                    </h2>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card-box card-payout">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title="" data-original-title="Your total refferal users"></i>
                                    <h4 class="mt-0 font-16">{{__('Total refferals')}}</h4>
                                    <h2 class="my-3 text-center">
                                        <span data-plugin="counterup">{{ $totalRefferal }}</span>
                                    </h2>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card-box card-balance">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="Your total affilate earnings"></i>
                                    <h4 class="mt-0 font-16">{{__('Total Earnings')}}</h4>
                                    <h2 class="my-3 text-center">
                                        {{ current_currency('symbol') }}
                                        <span data-plugin="counterup">{{ convert_price($total_earning, false) }}</span>
                                    </h2>
                                </div>
                            </div>
        
                            <div class="col-md-6">
                                <div class="card-box card-net-earning">
                                    <i class="fa fa-info-circle float-right" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="The amount of last month you earned"></i>
                                    <h4 class="mt-0 font-16">{{__('Last Month')}}</h4>
                                    <h2 class="my-3 text-center">
                                        {{ current_currency('symbol') }}
                                        <span data-plugin="counterup">{{ convert_price($lastMontEarning, false) }}</span>
                                    </h2>
                                </div>
                            </div>
        
                        </div>
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

    function copyTheCoupon(id)
    {
        console.log(id);
        var couponText = document.getElementById("couponText"+id);
        var couponBtn = document.getElementById("couponBtn"+id);
        couponText.select();
        couponText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        couponBtn.innerHTML = "Copied!";
    }

    

</script>
@endpush
@include('dashboard.components.footer')