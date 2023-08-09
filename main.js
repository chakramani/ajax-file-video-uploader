jQuery("#form").submit(function (e) {
    e.preventDefault();

    var fd = new FormData();
    var file = jQuery(document).find('input[type="file"]');
    console.log(file);
    var individual_file = file[0].files[0];
    fd.append("file", individual_file);
    fd.append("action", "uploading_videos_landing_page");

    jQuery.ajax({
      type: "POST",
      url: exporterajax.ajaxurl,
      data: fd,
      contentType: false,
      processData: false,
      success: function (response) {
        jQuery(':input[type="submit"]').prop("disabled", true);
        jQuery(':input[type="submit"]').addClass("hover-not-allowed");
        console.log(response);
      },
    });
  });