<div class="card">
    <div class="card-header bg-white">
        <div style="font-weight: 900">
            Withdrawal Requests 
        </div>
    </div>
    <div class="card-body">
        <table class="table table-large mb-0 dt-responsive nowrap w-100">
          @if(count($withdraws) > 0)
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">User Email</th>
                <th scope="col">User Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($withdraws as $item)
              <tr>
                <td>{{ $item->created_at->format("d M, Y") }}</td>
                <td>{{ $item->user->email }}</td>
                <td>{{ get_user_role($item->user->id)->name }}</td>
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
                <td>
                    <button wire:click="approve({{ $item->id }})" class="btn btn-success btn-sm shadow">approve</button> 
                    <button wire:click="decline({{ $item->id }})" class="btn btn-danger btn-sm shadow">decline</button> 
                </td>
              </tr>
              @endforeach
            </tbody>
            @else 

            <h4 class="text-center">No data found</h4>
            
          @endif
        </table>

        @if($loadMore)
        <div class="text-center pt-2">
            <button wire:click="loadMore()" class="btn btn-info btn-sm shadow-sm">Load More</button> 
        </div>
        @endif

    </div>
    {{-- The Master doesn't talk, he acts. --}}
</div>