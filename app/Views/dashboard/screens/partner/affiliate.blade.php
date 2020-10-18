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
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                         Your Refferal Link
                         @php
                             $user = get_current_user_data();
                         @endphp
                        </div>
                        <div class="card-body">

                            @if($user->ref_id == null)

                            <h5 class="card-title">You have no refferal link</h5>
                            <p class="card-text">Click the below button to generate your refferal link.</p>
                            <form action="{{ route('reff.generate') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <button href="submit" class="btn btn-primary">Generate Link</button>
                            </form>
                            
                            @else
                            <p class="card-text">Copy and share this link to invite peoples.</p>
                                <div class="input-group">
                                    <input type="text" class="form-control" readonly value="{{  getRefferalLink($user->ref_id) }}" id="copyText">
                                    <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="copyBtn" onclick="clickAndCopy()" >Copy</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                      </div>
                </div>
            </div>


            <div class="earning-section">
                <div class="row">
                    <div class="col-md-6 col-xl-3">
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

                    <div class="col-md-6 col-xl-3">
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

                    <div class="col-md-6 col-xl-3">
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

                    <div class="col-md-6 col-xl-3">
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

            {{--End content--}}
            @include('dashboard.components.footer-content')
        </div>
    </div>
</div>

@include('dashboard.components.footer')