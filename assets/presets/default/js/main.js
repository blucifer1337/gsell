  /*============== Main Js Start ========*/

(function ($) {
  "use strict";

  /*============== Header Hide Click On Body Js ========*/
  $('.navbar-toggler.header-button').on('click', function() {
    if($('.body-overlay').hasClass('show')){
      $('.body-overlay').removeClass('show');
    }else{
      $('.body-overlay').addClass('show');
    }
  });
  $('.body-overlay').on('click', function() {
    $('.header-button').trigger('click');
  });



  /* ==========================================
  *     Start Document Ready function
  ==========================================*/
  $(document).ready(function () {
    "use strict";
    if ($(".odometer").length) {
      var odo = $(".odometer");
      odo.each(function () {
        $(this).appear(function () {
          var countNumber = $(this).attr("data-count");
          $(this).html(countNumber);
        });
      });
    }
    
    /*================== Password Show Hide Js ==========*/
    $(".toggle-password").on('click', function() {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
      input.attr("type", "text");
      } else {
      input.attr("type", "password");
      }
    });

    /*================== Show Login Toggle Js ==========*/
    $('#showlogin').on('click', function () {
      $('#checkout-login').slideToggle(700);
    });

    /*================== Show Coupon Toggle Js ==========*/
    $('#showcupon').on('click', function () {
      $('#coupon-checkout').slideToggle(400);
    });



   
    

    /* ========================= Latest Slider Js Start ===============*/


  /*======================= Mouse hover Js Start ============*/
    $('.mousehover-item').on('mouseover', function() {
      $('.mousehover-item').removeClass('active')
      $(this).addClass('active')
    }); 

    /*================== Sidebar Menu Js Start =============== */
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").on('click', function(e) {
      e.preventDefault();
      var $submenu = $(this).next(".sidebar-submenu");
      var $parent = $(this).parent();
      if ($submenu.css("display") === "block") {
        $submenu.slideUp(200);
        $parent.removeClass("active");
      } else {
        $(".sidebar-submenu").not($submenu).slideUp(200);
        $(".has-dropdown.active").removeClass("active");
        $parent.addClass("active");
        $submenu.slideDown(200);
      }
    });

    /*==================== Sidebar Icon & Overlay js ===============*/
      $(".dashboard-body__bar-icon").on("click", function() {
        $(".sidebar-menu").addClass('show-sidebar'); 
        $(".sidebar-overlay").addClass('show'); 
      });
      $(".sidebar-menu__close, .sidebar-overlay").on("click", function() {
        $(".sidebar-menu").removeClass('show-sidebar'); 
        $(".sidebar-overlay").removeClass('show'); 
      });
  
    /*=================== Nice Select Start Js ==================*/
    // $('select').niceSelect();
  
    /*================= Increament & Decreament Js Start ======*/
      const productQty = $(".product-qty");
      productQty.each(function () {
        const qtyIncrement = $(this).find(".product-qty__increment");
        const qtyDecrement = $(this).find(".product-qty__decrement");
        let qtyValue = $(this).find(".product-qty__value");
        qtyIncrement.on("click", function () {
          var oldValue = parseFloat(qtyValue.val());
          var newVal = oldValue + 1;
          qtyValue.val(newVal).trigger("change");
        });
        qtyDecrement.on("click", function () {
          var oldValue = parseFloat(qtyValue.val());
          if (oldValue <= 0) {
            var newVal = oldValue;
          } else {
            var newVal = oldValue - 1;
          }
          qtyValue.val(newVal).trigger("change");
        });
      });

    /*======================= Event Details Like Js Start =======*/
    $('.hit-like').each(function() {
      $(this).on(click(function() {
        $(this).toggleClass('liked')
      }));
    });

    /* ========================= Odometer Counter Js Start ========== */
      $(".counterup-item").each(function () {
        $(this).isInViewport(function (status) {
          if (status === "entered") {
            for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
              var el = document.querySelectorAll('.odometer')[i];
              el.innerHTML = el.getAttribute("data-odometer-final");
            }
          }
        });
      });

    /*============** Number Increment Decrement **============*/
      $(".add").on("click", function () {
        if ($(this).prev().val() < 999) {
          $(this)
            .prev()
            .val(+$(this).prev().val() + 1);
        }
      });
      $(".sub").on("click", function () {
        if ($(this).next().val() > 1) {
          if ($(this).next().val() > 1)
            $(this)
            .next()
            .val(+$(this).next().val() - 1);
        }
      });

    /* =================== User Profile Upload Photo Js Start ========== */
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#imagePreview').css('background-image', 'url('+e.target.result +')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
          }
          reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").change(function() {
      readURL(this);
    });

  });
    /*==========================================
    *      End Document Ready function
    // ==========================================*/

    /*========================= Preloader Js Start =====================*/
       
        $(window).on("load", function(){
        $("#loading").fadeOut();
        })

    /*========================= Header Sticky Js Start ==============*/
    $(window).on('scroll', function() {
      if ($(window).scrollTop() >= 60) {
        $('.header').addClass('fixed-header');
      }
      else {
          $('.header').removeClass('fixed-header');
      }
    }); 
    
    /*============================ Scroll To Top Icon Js Start =========*/
    var btn = $('.scroll-top');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');

    });

    /*============================ Header Search =========*/

    $('.header-search-icon').on('click', function() {
        $('.header-search-hide-show').addClass('show');
        $('.header-search-icon').hide();
        $('.close-hide-show').addClass('show');
    });

    $('.close-hide-show').on('click', function() {
        $('.close-hide-show').removeClass('show');
        $('.header-search-hide-show').removeClass('show');
        $('.header-search-icon').show();
    });



    /*============================ header menu show hide =========*/
    $('.sidebar-menu-show-hide').on('click', function() {
        $('.sidebar-menu-wrapper').addClass('show');
        $(".sidebar-overlay").addClass('show'); 
    });

    $('.sidebar-overlay, .close-hide-show').on('click', function() {
        $('.sidebar-menu-wrapper').removeClass('show');
        $(".sidebar-overlay").removeClass('show'); 
    });
    
    
      /*---------- 05. Scroll To Top ----------*/
    // progressAvtivation
    if($('.scroll-top').length > 0) {
      var scrollTopbtn = document.querySelector('.scroll-top');
      var progressPath = document.querySelector('.scroll-top path');
      var pathLength = progressPath.getTotalLength();
      progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
      progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
      progressPath.style.strokeDashoffset = pathLength;
      progressPath.getBoundingClientRect();
      progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';      
      var updateProgress = function () {
          var scroll = $(window).scrollTop();
          var height = $(document).height() - $(window).height();
          var progress = pathLength - (scroll * pathLength / height);
          progressPath.style.strokeDashoffset = progress;
      }
      updateProgress();
      $(window).scroll(updateProgress);   
      var offset = 50;
      var duration = 800;
      jQuery(window).on('scroll', function() {
          if (jQuery(this).scrollTop() > offset) {
              jQuery(scrollTopbtn).addClass('show');
          } else {
              jQuery(scrollTopbtn).removeClass('show');
          }
      });             
      jQuery(scrollTopbtn).on('click', function(event) {
          event.preventDefault();
          jQuery('html, body').animate({scrollTop: 0}, duration);
          return false;
      })





// slick
$('.testimonial-slider').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 3,
  pauseOnHover: false,
  slidesToScroll: 1,
  arrows: false,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 1100,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 780,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

}



$(".toggle-password-change").on('click', function() {
  var targetId = $(this).data("target");
  var target = $("#" + targetId);
  var icon = $(this);
  if (target.attr("type") === "password") {
      target.attr("type", "text");
      icon.removeClass("fa-eye-slash");
      icon.addClass("fa-eye");
  } else {
      target.attr("type", "password");
      icon.removeClass("fa-eye");
      icon.addClass("fa-eye-slash");
  }
});
// wow js
new WOW().init();


// add to favorite btn

  $('.add-fav-btn').on('click', function() {
    $(this).toggleClass('active-fav');
    var icon = $(this).find('i');
    if (icon.hasClass('fa-solid')) {
      icon.removeClass('fa-solid').addClass('fa-regular');
    } else {
      icon.removeClass('fa-regular').addClass('fa-solid');
    }
  });





// disable right click option premium content
$('.premium').on('contextmenu', function(event) {
  event.preventDefault();
});


 /*============** Mgnific Popup **============*/
 $(".image-popup").magnificPopup({
  type: "image",
  gallery: {
      enabled: true,
  },
});

$('.popup_video').magnificPopup({
    type: 'iframe',
});


// scroll up and down
$(document).ready(function() {
  "use strict";
  let lastScrollTop = 0; // Initial scroll position
  const element = $('.header-wrapper'); // Change to your element's ID

  $(window).scroll(function() {
    const scrollTop = $(window).scrollTop();

    if (scrollTop > lastScrollTop) {
      // Scrolling down
      element.addClass('scrolled');
    } else {
      // Scrolling up
      element.removeClass('scrolled');
    }

    lastScrollTop = scrollTop;
  });
});

// mobile-search option
$('.mobile-search-btn').on('click', function() {
  $('.input-wrap,.header-menu-wrapper').toggleClass('input-show');
});


})(jQuery);
