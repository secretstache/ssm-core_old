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

          if ( origWidth > origHeight ) {
              orientation = 'landscape';
              console.log(orientation);
          } else {
              orientation = 'portrait';
              console.log(orientation);
          }

          if ( orientation == 'landscape' && origWidth >= 230 ) {
              w = 230;
              width = w.toString() + 'px';
              h = width * (origHeight / origWidth);
              height = h.toString() + 'px';
              //console.log('landscape > 230');
          } else if ( orientation == 'landscape' && origWidth < 230 ) {
              width = origWidth.toString() + 'px';
              height = origHeight.toString() + 'px';
              console.log('landscape < 230');
          } else if ( orientation == 'portrait' && origWidth >= 50 ) {
              w = 50;
              width = w.toString() + 'px';
              h = w * (origHeight / origWidth);
              height = h.toString() + 'px';
              // console.log( 'portrait > 50' );
              // console.log( 'Original Height: ' + origHeight );
              // console.log( 'Original Width: ' + origWidth );
              // console.log( 'New Height: ' + height )
          } else if ( orientation == 'portrait' && origWidth < 50 ) {
              width = origWidth.toString() + 'px';
              height = origHeight.toString() + 'px';
              console.log('portrait < 50');
          }

          $('#ssm-core-login-logo').attr('value', url);
          $('#logo-preview').attr('src', url);
          $('#logo-preview').css({'width': width, 'height': height});
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
      $('#logo-preview').css({'width': '230px', 'height': 'auto'});
      $('#ssm-core-login-logo-width').attr('value', '');
      $('#ssm-core-login-logo-height').attr('value', '');
    }
    return false;
  });

})( jQuery );