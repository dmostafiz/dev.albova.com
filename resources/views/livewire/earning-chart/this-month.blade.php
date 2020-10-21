<div>
    <style>
        span.earning-count{
            font-size:90px;
            font-weight: 450;
            color: #1C263D;
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
            <span class="earning-count">{{ $earningCount }}</span><span class="couunt-label">USD</span>
        </div>
    </div>
</div>
