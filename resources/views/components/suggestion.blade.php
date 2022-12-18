<div class="my-2 shadow  text-white bg-dark p-1" id="">
  @foreach($users as $user)
  <div class="d-flex justify-content-between my-1">
      <div class="bg-dark">
        <p class="text-white">{{ $user->name }} - {{ $user->email }}</p>
      </div>
      <button id="create_request_btn_" class="btn btn-primary me-1" onclick="sendRequest(this, {{ $user->id }})">Connect</button>
  </div>
  @endforeach
</div>
