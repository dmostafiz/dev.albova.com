<div>
    <style>
        span.clicks-count-register{
            font-size:90px;
            font-weight: 450;
            color: #FF4E70;
        }
        div.count-area{
            padding-top: 50px;
            text-align: center;
        }
        span.couunt-label{
            font-size: 18px;
            margin-left: 10px;
        }
    </style>
    <div class="card-body">
        <div>
            <h5 class="card-title float-left">This month</h5>
            <span class="float-right">{{ $monthName }} 2020</span>
        </div>
        <div class="count-area">
            <span class="clicks-count-register">{{$clickCount}}</span><span class="couunt-label">Registers</span>
        </div>
    </div>
</div>
