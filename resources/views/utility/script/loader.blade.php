const showLoader = () => {
  $('body').append('<div style="" class="loader-wrapper" id="loadingDiv"><div class="loader">Loading...</div></div>');
}

const hideLoader = () => {
  $( "#loadingDiv" ).fadeOut(500, function() {
    $( "#loadingDiv" ).remove();
  });
}