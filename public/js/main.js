var skeletonId = '#skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;
var currentPageId = 'suggestion';

function getRequests(mode) {
  var form = ajaxForm([
    ['mode', mode],
    ['limit', takeAmount],
  ]);
  ajax('/request', 'POST', function(response){
    if(takeAmount >= response.total){
      $('#load_more_btn_parent').addClass('d-none');
    }
    $(`#${contentId}`).html(response.view);
  }, form)
}

function getMoreRequests(mode) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnections() {
  var form = ajaxForm([
    ['limit', takeAmount],
  ]);
  ajax('/connections', 'POST', function(response){
    if(takeAmount >= response.total){
      $('#load_more_btn_parent').addClass('d-none');
    }
    $(`#${contentId}`).html(response.view);
  }, form)
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnectionsInCommon(connectionId) {
  var form = ajaxForm([
    ['limit', takeAmount],
    ['connection_id', connectionId]
  ]);
  ajax('/connections-in-common', 'POST', function(response){
    if(takeAmount >= response.total){
      $(`#load_more_connections_in_common_${ connectionId }`).addClass('d-none');
    }
    $(`#content_${connectionId}`).html(response.view);
  }, form)
}

function getMoreConnectionsInCommon(userId, connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getSuggestions() {
  var form = ajaxForm([
    ['limit', takeAmount],
  ]);
  ajax('/suggestions', 'POST', function(response){
    if(takeAmount >= response.total){
      $('#load_more_btn_parent').addClass('d-none');
    }
    $(`#${contentId}`).html(response.view);
  }, form)
}

function getMoreSuggestions() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function sendRequest(event, suggestionId) {
  var form = ajaxForm([
    ['connection_id', suggestionId],
  ]);
  ajax('/send-request', 'POST', function(response){
    $(event).parent().remove()
  },form)
}

function deleteRequest(event, requestId) {
  // your code here...
  var form = ajaxForm([
    ['connection_id', requestId],
  ]);
  ajax('/decline-request', 'POST', function(response){
    $(event).parent().remove()
  },form)
}

function acceptRequest(event, requestId) {
    // your code here...
    var form = ajaxForm([
      ['connection_id', requestId],
    ]);
    ajax('/accept-request', 'POST', function(response){
      $(event).parent().remove()
    },form)
}

function removeConnection(event, connectionId) {
  var form = ajaxForm([
    ['connection_id', connectionId],
  ]);
  ajax('/remove-request', 'POST', function(response){
    $(event).parent().remove()
  },form)

}

function loadMore(){
  takeAmount += 10;
  console.log(currentPageId)
  switch(currentPageId){
    case 'suggestion':
      getSuggestions()
      break;
    case 'sent':
      getRequests('sent');
      break;
    case 'received':
      getRequests('received');
      break;
    case 'connections':
      getConnections();
      break;
  }
}

function allRequest(loadMore){
  $('input[name="request"]').off('click').on('click', function (e) {
    currentPageId = e.target.id
    takeAmount = 10;
    $('#load_more_btn_parent').removeClass('d-none');
    switch(e.target.id){
      case 'suggestion':
        getSuggestions()
        break;
      case 'sent':
        getRequests('sent');
        break;
      case 'received':
        getRequests('received');
        break;
      case 'connections':
        getConnections();
        break;
    }
  }, );
  getSuggestions();
}


$(async function () {
  allRequest();
});

jQuery(function ($){
  $(document).ajaxStop(function(){
    $(skeletonId).addClass('d-none')
  });
  $(document).ajaxStart(function(){
    $(skeletonId).removeClass('d-none')
  });    
});    