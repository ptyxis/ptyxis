$(document).ready(function(){

  $( '.del' ).click(function() {
      $('#delid').val( $(this).attr('id') );
      $('#delmodel').modal('show');
  });

  $('[data-toggle="tooltip"]').tooltip();

  $( "#comic-title" ).focusout(function() {

      var title = $(this).val();

      title = title.replace(/\+/g, '');
      title = title.replace(/\'/g, '');
      title = title.replace(/\"/g, '');
      title = title.replace(/\&/g, '-and-');
      title = title.replace(/\s/g, '-');
      title = title.replace(/--/g, '-');

      var slug = title.toLowerCase();

      var current_slug = $( "#comic-slug" ).val();

      if(!current_slug) {
          $( "#comic-slug" ).val(slug);
      }
  });

  $('.date-picker').datepicker({
      todayHighlight: true,
      format: 'mm/dd/yyyy'
  });

  tinymce.init({
        selector: ".content-editor"
    });


});
