$(document).on('pageshow', 'div', function (event, ui) {
    $('#listcontent').sortable({ cancel: '.not-dragg' })
  });