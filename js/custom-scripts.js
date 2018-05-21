jQuery( document ).ready(function() {


  // Making sure scripts are working right
  console.log("%c THIS IS MARBLE LDN", "font-size:22px;color:#226C80");



  var box_id = "";
  var box_num = "";

  var clearout = '<div class="marble-service-clearout"></div>';

  // CLOSE BUTTON
  jQuery("body").on("click", ".marble-service-main-content-close", function () {
    jQuery(this).parent().parent().slideUp();
    //console.log("close button pressed");
  });


  // NEXT BUTTON
  jQuery("body").on("click", ".marble-service-main-content-next", function () {

    var next_title = "";
    // get current box
    //console.log("box num: " + box_num);
    if (box_num == "") {
      box_num = parseInt(box_id.charAt(3));
    }
    if (box_num == 6) {
      box_num = 1;
    } else {
      box_num = box_num + 1;
    }
    //console.log("box num: " + box_num);
    next_title = box_num + 1
    //console.log("next title: " + next_title);
    if (box_num == 6) {
      next_title = 1;
    }
    // get next box content
    var service_main_content = jQuery("#box" + box_num).html();
    var service_next_title = jQuery("#box" + next_title).attr("next-title");
    //console.log(service_next_title);
    jQuery(this).parent().parent().hide().html(clearout + service_main_content).fadeIn(500);
    jQuery(".marble-service-main-content-next-title").html(service_next_title);
    // check if next box is nr6, if yes go to box 1
  });




  // MARBLE SERVICE BOX
  jQuery(".marble-service .marble-button").click(function (event) {
    event.preventDefault();
    var next_title = "";
    jQuery(".marble-service-content-hook").hide();
    var service_main_content = jQuery(this).parent().parent().next().html();
    box_id = jQuery(this).parent().parent().next().attr("id");
    box_num = parseInt(box_id.charAt(3));

    next_title = parseInt(box_id.charAt(3)) + 1;

    if (next_title == 7) {
      next_title = 1;
    }

    // get next box content
    var service_next_title = jQuery("#box" + next_title).attr("next-title");

    // for mobile
    if (jQuery(window).width() < 920) {
      jQuery(this).parent().parent().parent().parent().next().addClass("clear").html(clearout + service_main_content).slideDown();
      jQuery(".marble-service-main-content-next-title").html(service_next_title);
    }


    // for tablet (dump 1and2 into 2nd, 3and4 into 4th and 5and6 into 6th)
    if (jQuery(window).width() < 1200 && jQuery(window).width() > 919) {
      if (box_id == "box1" || box_id == "box2") {
        //console.log("dump after box2");
        jQuery(".marble-service-content-hook.box2").addClass("clear").html(clearout + service_main_content).slideDown();
        jQuery(".marble-service-main-content-next-title").html(service_next_title);
      }
      if (box_id == "box3" || box_id == "box4") {
        //console.log("dump after box 4");
        jQuery(".marble-service-content-hook.box4").addClass("clear").html(clearout + service_main_content).slideDown();
        jQuery(".marble-service-main-content-next-title").html(service_next_title);
      }
      if (box_id == "box5" || box_id == "box6") {
        //console.log("dump after box 6");
        jQuery(".marble-service-content-hook.box6").addClass("clear").html(clearout + service_main_content).slideDown();
        jQuery(".marble-service-main-content-next-title").html(service_next_title);
      }
    }


    // for desktop (dump 1and2and3 into 3d, 4and5and6 into 6th)
    if (jQuery(window).width() > 1199) {

      if (box_id == "box1" || box_id == "box2" || box_id == "box3") {
        //console.log("dump after box3");
        jQuery(".marble-service-content-hook.box3").addClass("clear").html(clearout + service_main_content).slideDown();
        jQuery(".marble-service-main-content-next-title").html(service_next_title);
      }

      if (box_id == "box4" || box_id == "box5" || box_id == "box6") {
        //console.log("dump after box6");
        jQuery(".marble-service-content-hook.box6").addClass("clear").html(clearout + service_main_content).slideDown();
        jQuery(".marble-service-main-content-next-title").html(service_next_title);
      }

    }

  });

  
  // Do the boxes on the grid nice and squere
  var mmi = jQuery(".marble-grid-item").width();
  jQuery(".marble-grid-item").height(mmi);


  function resizedw() {
    var mmi = jQuery(".marble-grid-item").width();
    jQuery(".marble-grid-item").height(mmi);
    jQuery('.marble-service-content-hook').hide();

    // GALLERY ITEMS
    var csm = jQuery(".case-study-gallery-row .square.one").outerWidth();
    var vsm = jQuery(".case-study-gallery .square.one").outerWidth();
    if (jQuery('body').width() < 1024) {
      var csm = jQuery(".case-study-gallery-row .square.one").outerWidth() / 2;
      var vsm = jQuery(".case-study-gallery .square.one").outerWidth() / 2;
    }


    jQuery(".case-study-gallery-row .square").height(csm);
    jQuery(".case-study-gallery-row .rectangle").height(csm);
    jQuery(".case-study-gallery-row .video-item").height(csm);
    jQuery(".case-study-gallery .square").height(vsm);
    jQuery(".case-study-gallery.video-row .video-item").height(vsm * 2);
    //console.log(vsm);
    if (jQuery('body').width() < 1024) {

      jQuery(".case-study-gallery .video-large").css('height', 'auto');
      jQuery(".case-study-gallery-row .square").height(csm * 2);
      jQuery(".case-study-gallery-row .rectangle").height(csm * 2);


    }


  }

  var doit;
  window.onresize = function () {
    clearTimeout(doit);
    doit = setTimeout(resizedw, 100);
  };




  // OUR WORK (CASE STUDY) GALLERY
  jQuery(function () {

    jQuery(".case-study-gallery").append('<img src="" id="preview" style="position:absolute;z-index:99999" width="800" height="600"/>');
    var $preview = jQuery("#preview");


    jQuery(".case-study-gallery .gallery-item").hover(function () {
      if (jQuery(window).width() > 1024) {
        $preview.attr("src", jQuery(this).attr("data-thumbnail-src")).show();
      }
    }, function () {
      $preview.attr("src", "").hide();
    });

  });

  var $mouseX = 0, $mouseY = 0;
  var $xp = 0, $yp = 0;

  jQuery(".case-study-gallery .gallery-item").mousemove(function (e) {
    // top right
    if ((jQuery(window).width() - e.pageX < jQuery(window).width() / 2) && (jQuery(window).height() - e.pageY < jQuery(window).height() / 2)) {
      $mouseX = e.pageX - 850;
      $mouseY = e.pageY - 450;
      //console.log('bottom right');
      // bottom right
    } else if ((jQuery(window).width() - e.pageX > jQuery(window).width() / 2) && (jQuery(window).height() - e.pageY > jQuery(window).height() / 2)) {
      $mouseX = e.pageX + 50;
      $mouseY = e.pageY + 50;
      //console.log('top left');
    } else if ((jQuery(window).width() - e.pageX < jQuery(window).width() / 2) && (jQuery(window).height() - e.pageY > jQuery(window).height() / 2)) {
      $mouseX = e.pageX - 850;
      $mouseY = e.pageY + 50;
      //console.log('top right');
    } else if ((jQuery(window).width() - e.pageX > jQuery(window).width() / 2) && (jQuery(window).height() - e.pageY < jQuery(window).height() / 2)) {
      $mouseX = e.pageX + 50;
      $mouseY = e.pageY - 450;
      //console.log('bottom left');
    }

  });

  var $loop = setInterval(function () {
    // change 12 to alter damping higher is slower
    $xp += (($mouseX - $xp) / 12);
    $yp += (($mouseY - $yp) / 12);
    jQuery("#preview").css({ left: $xp + "px", top: $yp + "px" });
  }, 5);


  // GALLERY VIDEO PLAY BUTTON
  jQuery('.gallery-video-play-button').click(function () {
    if (jQuery(".case-study-gallery .video-item video").get(0).paused == false) {
      jQuery(".case-study-gallery .video-item video").get(0).pause();
    } else {
      jQuery(".case-study-gallery .video-item video").get(0).play();
      jQuery('.gallery-video-play-button').fadeOut();
    }
  });

  // PAUSE VIDEO ON CLICK
  jQuery('.case-study-gallery .video-item video').click(function () {
    jQuery(".case-study-gallery .video-item video").get(0).pause();
    jQuery('.gallery-video-play-button').fadeIn();
  });

  // DETECT WHEN VIDEO FINISHED PLAYING AND DISPLAY PLAY BUTTON
  jQuery('.case-study-gallery .video-item video').on('ended', function () {
    jQuery('.gallery-video-play-button').fadeIn();
  });



  // CLOSE THE GRID DROPDOWN ON MOBILE AFTER SELECTION

  jQuery('.tg-grid-area-top1').click(function (event) {
    if (jQuery(window).width() < 1250) {
      event.stopPropagation();
      jQuery(".tg-filters-holder").css("visibility", "visible");
      console.log('filter clicked');
    }
  });

  jQuery(".tg-filters-holder").on("click", function (event) {
    if (jQuery(window).width() < 1250) {
      event.stopPropagation();
      jQuery(".tg-filters-holder").css("visibility", "hidden");
    }
  });


  jQuery(document).on("click", function () {
    if (jQuery(window).width() < 1250) {
      jQuery(".tg-filters-holder").css("visibility", "hidden");
    }
  });





 });