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
        span.month{
            float:left;
        }
        span.count{
            float:right;
        }
        .list-group-item {
            padding: 6px 35px;
        }
   
    </style>
    <div class="card-body">
        <div>
            <h5 class="card-title float-left">This year</h5>
            <span class="float-right">{{ $year }}</span>
        </div>
        <div class="count-area">
            <span class="clicks-count-register">{{ $clickCount }}</span><span class="couunt-label">Registers</span>
        </div>
        <div class="months">
            <ul class="list-group">
                @foreach ($months as $item)
                <li class="list-group-item">
                    <span class="month">{{ $item['month'] }}</span> <span class="count">{{ $item['count'] }} registers</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
