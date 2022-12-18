<div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card shadow text-white bg-dark">
      <div class="card-header">Coding Challenge - Network connections</div>
      <div class="card-body">
        <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="request" id="suggestion" autocomplete="off" checked>
          <label class="btn btn-outline-primary" for="suggestion" id="get_suggestions_btn">Suggestions ({{ $suggestedRequests }})</label>

          <input type="radio" class="btn-check" name="request" id="sent" autocomplete="off">
          <label class="btn btn-outline-primary" for="sent" id="get_sent_requests_btn">Sent Requests ({{ $sentRequests }})</label>

          <input type="radio" class="btn-check" name="request" id="received" autocomplete="off">
          <label class="btn btn-outline-primary" for="received" id="get_received_requests_btn">Received
            Requests({{ $receivedRequests }})</label>
            
          <input type="radio" class="btn-check" name="request" id="connections" autocomplete="off">
          <label class="btn btn-outline-primary" for="connections" id="get_connections_btn">Connections ({{ $connections }})</label>
        </div>
        <hr>

        <div id="content">

        </div>

      <div id="skeleton">
          @for ($i = 0; $i < 10; $i++)
            <x-skeleton />
          @endfor
        </div>

        <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
          <button class="btn btn-primary" onclick="loadMore()" id="load_more_btn">Load more</button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Remove this when you start working, just to show you the different components --}}

<div id="connections_in_common_skeleton" class="d-none">
  <br>
  <span class="fw-bold text-white">Loading Skeletons</span>
  <div class="px-2">
    @for ($i = 0; $i < 10; $i++)
      <x-skeleton />
    @endfor
  </div>
</div>
