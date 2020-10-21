<div class="card">
    <div class="card-header bg-white">
        <div style="font-weight: 900">
            Registration History 
        </div>
    </div>
    <div class="card-body">
        <table class="table table-large mb-0 dt-responsive nowrap w-100">
          @if(count($histories) > 0)
            <thead>
              <tr>
                {{-- <th scope="col">Name</th> --}}
                <th scope="col">Email</th>
                <th scope="col">Joined Date</th>
              </tr>
            </thead>
            <tbody>
              
                @foreach ($histories as $item)
                  <tr>
                    {{-- <td>{{ $item->child->first_name }}</td> --}}
                    <td>{{ $item->child->email }}</td>
                    <td>{{ $item->created_at->format("d M, Y") }}</td>
                  </tr>
                @endforeach
    
            </tbody>

            
            @else 

            <h4 class="text-center">No data found</h4>
            
          @endif
        </table>

        {{-- {{ $histories->links() }} --}}
    </div>
    {{-- The Master doesn't talk, he acts. --}}
</div>
