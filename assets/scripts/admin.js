(function( $ ) {

  $('#upload-image-button').click(function() {
      var send_attachment = wp.media.editor.send.attachment;
      var button = $(this);
      wp.media.editor.send.attachment = function(props, attachment) {

          var url = attachment.url;
          var origWidth = attachment.width;
          var origHeight = attachment.height;
          var orientation;
          var defaultLogo = login_logo.url;

          if ( ( origWidth / origHeight )  >= 2 ) {
              orientation = 'landscape';
              console.log(orientation);
          } else {
              orientation = 'portrait';
              console.log(orientation);
          }

          if ( orientation == 'landscape' && origWidth > 230 ) {
              width = 230;
              height = width * origHeight / origWidth;
          } else if ( orientation == 'landscape' && origWidth < 230 ) {
              width = origWidth;
              height = origHeight;
          } else if ( orientation == 'portrait' && origWidth > 50 ) {
              width = 200;
              height = width * origHeight / origWidth;
          } else if ( orientation == 'portrait' && origWidth < 50 ) {
              width = OrigWidth;
              height = origHeight;
          }

          $('#ssm-core-login-logo').attr('value', url);
          $('#logo-preview').attr('src', url);
          $('#logo-preview').css('width', width+' px');
          $('#logo-preview').css('height', height+' px');
          $('#ssm-core-login-logo-width').attr('value', width);
          $('#ssm-core-login-logo-height').attr('value', height);

          wp.media.editor.send.attachment = send_attachment;

    };
    wp.media.editor.open(button);
    return false;
  });

  // The "Remove" button (remove the value from input type='hidden')
  $('#remove-image-button').click(function() {
    var answer = confirm('Are you sure?');
    if (answer == true) {

      var defaultLogo = login_logo.url;

      $('#ssm-core-login-logo').attr('value', '');
      $('#logo-preview').attr('src', defaultLogo);
      $('#logo-preview').css('width', '230px');
      $('#logo-preview').css('height', 'auto');
      $('#ssm-core-login-logo-width').attr('value', '');
      $('#ssm-core-login-logo-height').attr('value', '');
    }
    return false;
  });

})( jQuery );