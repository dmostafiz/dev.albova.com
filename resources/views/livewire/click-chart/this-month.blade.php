<div>
    <style>
        span.clicks-count{
            font-size:90px;
            font-weight: 450;
            color: #00CBB7;
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
            <span class="clicks-count">{{$clickCount}}</span><span class="couunt-label">Clicks</span>
        </div>
    </div>
</div>
