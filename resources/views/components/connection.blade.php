<div class="my-2 shadow text-white bg-dark p-1" id="">
  @foreach($users as $user)
    <div class="d-flex justify-content-between my-1">
      <div class="bg-dark">
        <p class="text-white">{{ $user->name }} - {{ $user->email }}</p>
      </div>
      <button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary" type="button"
        onclick="getConnectionsInCommon('{{ $user->id }}')"
        data-bs-toggle="collapse" data-bs-target="#collapse_{{ $user->id }}" aria-expanded="false" aria-controls="collapseExample">
        Connections in common (  )
      </button>
      <button id="create_request_btn_" class="btn btn-danger me-1" onclick="removeConnection(this, {{ $user->id }})">Remove Connection</button>
    </div>

    </div>
    <div class="collapse" id="collapse_{{ $user->id }}">
      <div id="content_{{ $user->id }}" class="p-2">
        {{-- Display data here --}}
        
      </div>
      <div id="connections_in_common_skeletons_">
        {{-- Paste the loading skeletons here via Jquery before the ajax to get the connections in common --}}
      </div>
      <div class="d-flex justify-content-center w-100 py-2">
        <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_{{ $user->id }}">Load
          more</button>
      </div>
    </div>
  @endforeach
</div>
