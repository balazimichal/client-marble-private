jQuery( document ).ready(function() {


  // Making sure scripts are working right
  console.log("%c THIS IS MARBLE LDN", "font-size:22px;color:#226C80");

  
  // Do the boxes on the grid nice and squere
  var mmi = jQuery(".marble-grid-item").width();
  jQuery(".marble-grid-item").height(mmi);


  function resizedw() {
    var mmi = jQuery(".marble-grid-item").width();
    jQuery(".marble-grid-item").height(mmi);
    jQuery('.marble-service-content-hook').hide();

    // GALLERY ITEMS
    var csm = jQuery(".case-study-gallery-row .square.three").outerWidth();
    var vsm = jQuery(".case-study-gallery .square.one").outerWidth();
    if (jQuery('body').width() < 1024) {
      var csm = jQuery(".case-study-gallery-row .square.three").outerWidth() / 2;
      var vsm = jQuery(".case-study-gallery .square.one").outerWidth() / 2;
    }


    jQuery(".case-study-gallery-row .square").height(csm);
    jQuery(".case-study-gallery-row .rectangle").height(csm);
    jQuery(".case-study-gallery-row .video-item").height(csm);
    jQuery(".case-study-gallery .square").height(vsm);
    jQuery(".case-study-gallery.video-row .video-item").height(vsm * 2);
    //console.log(vsm);
    if (jQuery('body').width() < 1024) {
      jQuery(".case-study-gallery-row .square.one").css('height', 'auto');
      jQuery(".case-study-gallery .video-large").css('height', 'auto');
      jQuery(".case-study-gallery-row .rectangle").height(csm * 2);


    }


  }

  var doit;
  window.onresize = function () {
    clearTimeout(doit);
    doit = setTimeout(resizedw, 100);
  };



 });