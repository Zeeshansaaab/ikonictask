<div class="my-2 shadow text-white bg-dark p-1" id="">
  @foreach($users as $user)
    <div class="d-flex justify-content-between my-1">
      <div class="bg-dark">
        <p class="text-white">{{ $user->name }} - {{ $user->email }}</p>
      </div>
      @if ($mode == 'sent')
        <button id="cancel_request_btn_" class="btn btn-danger me-1"
          onclick="deleteRequest(this, '{{ $user->id }}')">Withdraw Request</button>
      @else
        <button id="accept_request_btn_" class="btn btn-primary me-1"
          onclick="acceptRequest(this,'{{ $user->id }}')">Accept</button>
      @endif
    </div>
  @endforeach
</div>
