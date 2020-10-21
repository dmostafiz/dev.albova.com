<div class="card">
    <div class="card-header bg-white">
        <div style="font-weight: 900">
            Earning History 
        </div>
    </div>
    <div class="card-body">
        <table class="table table-large mb-0 dt-responsive nowrap w-100">
          @if(count($histories) > 0)
            <thead>
              <tr>
                <th scope="col">Email</th>
                <th scope="col">Amount</th>
                <th scope="col">Type</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($histories as $item)
              <tr>
                <td>{{ $item->child->email }}</td>
                <td>${{ $item->amount }}</td>
                <td>{{ $item->earning_type }}</td>
                <td>{{ $item->created_at->format("d M, Y") }}</td>
              </tr>
              @endforeach
            </tbody>
            @else 

            <h4 class="text-center">No data found</h4>
            
          @endif
        </table>
    </div>
    {{-- The Master doesn't talk, he acts. --}}
</div>
