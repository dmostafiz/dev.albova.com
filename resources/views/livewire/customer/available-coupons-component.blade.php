<div class="card">
    <div class="card-header bg-white">
        <div style="font-weight: 900">
           Your available coupons 
        </div>
    </div>
    <div class="card-body">
        <table class="table table-large mb-0 dt-responsive nowrap w-100">
          @if(count($coupons) > 0)
            <thead>
              <tr>
                  <th>Amount</th>
                  <th scope="col">Expire date</th>
                  <th width="50%" scope="col">Coupon Code</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($coupons as $item)
                <tr>
                    <td>${{ $item->coupon_price }}</td>
                    <td> {{ date(hh_date_format(), $item->end_time) }} </td>
                    <td >
                        <div class="input-group pt-0 pb-0 p-0">
                            <input type="text" class="form-control  form-control-sm" readonly value="{{ $item->coupon_code }}" id="couponText{{ $item->coupon_id }}"  style="height: 28px !important; width:30px">
                            <div class="input-group-append">
                            <button class="btn btn-dark p-0 pl-1 pr-1" type="button" id="couponBtn{{ $item->coupon_id }}" onclick="copyTheCoupon({{ $item->coupon_id }})"  style="height: 28px !important; font-size:10px !important">Copy</button>
                            </div>
                        </div>
                    </td>
                </tr>
              @endforeach
            </tbody>
            @else 

            <h4 class="text-center">No coupons found</h4>
            
          @endif
        </table>
    </div>
    {{-- The Master doesn't talk, he acts. --}}
</div>