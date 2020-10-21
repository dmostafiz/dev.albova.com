<div class="card">
    <div class="card-header bg-white">
        <div style="font-weight: 900">
            Withdrawal History 
        </div>
    </div>
    <div class="card-body">
        <table class="table table-large mb-0 dt-responsive nowrap w-100">
          @if(count($histories) > 0)
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($histories as $item)
              <tr>
                <td>{{ $item->created_at->format("d M, Y") }}</td>
                <td>${{ $item->amount }}</td>
                <td>
                  @if($item->status == 'pending')
                    <span>Pending</span>
                  @elseif($item->status == 'approved')
                    <span class="text-success">Approved</span>
                  @elseif($item->status == 'declined')
                    <span class="text-danger">Declined</span>
                  @endif
                </td>
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
