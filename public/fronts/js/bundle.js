$(function() {
  var buttSettings = $(".buttSettings");
  var closeMenu = $(".closeMenu");
  var menuOpen = $(".menuOpen");
  var menuLeft = $(".menuLeft");
  var menuBack = $(".menuBack");
  var itemButt = $(".itemButt");
  var submenuButton = $(".submenuButton");
  var menuCabinet = $(".menuCabinet");
  var submenu = $(".subMenu");
  var burger = $(".burger");
  var cabNav = $(".cabNav");
  var nrCountCart = $('.nrArt');
  var socialNetworks = $('.socialNetworks');
  var titleFixed = $('.titleFixed');
  var filtButton = $('.btnFilter');
  var selectCabinet = $('#selectCabinet');
  var lastX = 0;


  var promoThanks = document.getElementById("promoThanks");

    if($(promoThanks).length){
      promoThanks.onclick = function() {
        document.execCommand("copy");
        $(promoThanks).addClass('selected');
        $(promoThanks).popover('show');
      }
      promoThanks.addEventListener("copy", function(event) {
        event.preventDefault();
        if (event.clipboardData) {
          event.clipboardData.setData("text/plain", promoThanks.textContent);
          console.log(event.clipboardData.getData("text"))
        }
      });
      promoThanks.addEventListener("mouseleave", function(event) {
        $(promoThanks).popover('hide')
        setTimeout(function(){
          $(promoThanks).removeClass('selected');
        }, 150)
      });
    }

  $(document).ready(function() {
    var logoMobile = $("header").find('a.logo');
    var header = $("header");
    var distance = $("main").offset().top,
      $window = $(window);
      $('.slideHome').css('opacity', '1');
    $('.mainSlides').css('opacity', '1');

    $window.scroll(function() {
    if ($window.scrollTop() != distance) {
      $('.headerHome').addClass('fullWidthHeader');
      $('#filterWord').addClass('filterBottom')
    } else {
      $('.headerHome').removeClass('fullWidthHeader')
      $('#filterWord').removeClass('filterBottom')
    }
  });
    if(screen.width < 1024){
      $('.submenuButton').children('a').removeAttr('href');
    }
    if (screen.width < 768) {
      var buttBanner1 = $('.buttBanner2').eq(0).outerWidth();
      var buttBanner2 = $('.buttBanner2').eq(1).outerWidth();
      if( buttBanner1 < buttBanner2){
        $('.buttBanner').parent().css('width', buttBanner2 + 30 + 'px');
      } else {
        $('.buttBanner').parent().css('width', buttBanner1 + 30 + 'px');
      }
      $window.scroll(function() {
        if ($window.scrollTop() != distance) {
          $(logoMobile).css("top", "-50px");
          $(header).css("height", "50px");
          $(menuCabinet).css("top", "0px");
          $(menuLeft).css("top", "50px");
          $(submenu).css("top", "50px");
          $(menuLeft).css("height", "calc(100vh - 50px)");
          burger.css('top', '10px');
          $('.alertUser').css('top', '50px')
          $('.logoMobile').css('top', '-50px')
          titleFixed.css('top', '50px')
          filtButton.css('top', '62px')
        } else {
          $(logoMobile).css("top", "0px");
          $(header).css("height", "100px");
          $(menuCabinet).css("top", "50px");
          $(menuLeft).css("top", "100px");
          $(menuLeft).css("height", "calc(100vh - 100px)");
          burger.css('top', '60px');
          $(submenu).css("top", "100px");
          titleFixed.css('top', '100px')
          $('.alertUser').css('top', '100px')
          $('.logoMobile').css('top', '0px')
          filtButton.css('top', '112px')
        }
      });



      $(document).bind("touchstart", function(e) {
        lastX = e.originalEvent.touches[0].clientX;
      });
      $(document).bind("touchend", function(e) {
        var currentX = e.originalEvent.changedTouches[0].clientX;

         if (currentX < lastX / 1.2 && $(burger).hasClass('burgerOpen')) {
           $(burger).removeClass('burgerOpen');
           $(".headerBlock").removeClass("secondLevel");
           $(menuBack).parent().css('left', '-317px');
           $('body').removeClass('bodyHidden');
           $('.menuLeft a.logo').removeClass('animation')
        }
      });
    }
    if(screen.width > 767){
      $('#putLink').attr('href', $('#copyLink').attr('href'))
    }
  });

  if (screen.width < 768) {
    $(burger).click(function() {
      if($(this).hasClass('burgerOpen')){
        $(this).removeClass("burgerOpen");
        $(".headerBlock").removeClass("secondLevel");
        $('.subMenu').css('left', '-300px')
        $('.setList').css('left', '-300px')
      } else {
        $(this).addClass("burgerOpen");
        $(".headerBlock").addClass("secondLevel");
      }

      $('body').toggleClass('bodyHidden');
      $('.menuLeft a.logo').toggleClass('animation')
    });
    $(selectCabinet).click(function() {
      $(this).toggleClass("arrowUp");
      $(".cabNav").toggleClass("cabNavOpen");
    });

    $(menuBack).click(function() {
      $('.noClick').show();
      $(this).parent().css('left', '-317px');
      setTimeout(function(){
        $('.noClick').hide();
      }, 500)
    });
    $(itemButt).children('span').on('click doubleclick', function() {
      $('.noClick').show();
      $(this).next('ul').css('left', '0px');
      $(this).next('ul').children('.menuBack').children('span').text($(this).text());
      setTimeout(function(){
        $('.noClick').hide();
      },500)
    });
    $(submenuButton).children('a').click(function() {
      $('.noClick').show();

      $(this).next('ul').css('left', '0px');
      $(this).next('ul').children('.menuBack').children('span').text($(this).text());
      setTimeout(function(){
        $('.noClick').hide();
      }, 500)
    });
  }
  $(buttSettings).click(function(a) {
    funMenuOpen(a);
  });
  $(closeMenu).click(function(a) {
    closeMenuFunc();
  });
  function funMenuOpen(a) {
    $(menuOpen).removeClass("menuOpenDisplay");
    $(a.target)
      .next(".menuOpen")
      .addClass("menuOpenDisplay");
    $(".socialNet").removeClass("socialNetBcg");
  }
  $(document).mouseup(function(e) {
    if (
      !menuOpen.is(e.target) &&
      !menuCabinet.is(e.target) &&
      menuOpen.has(e.target).length === 0
    ) {
      $(menuOpen).removeClass("menuOpenDisplay");
      $(".socialNet").addClass("socialNetBcg");
    }
  });
});

// slides

$(function() {
  $(document).ready(function() {
    var slideNav = $(".slideSet").next();



    var nritems = $(slideNav)
      .eq(0)
      .find(".itemNav");
    if (nritems.length <= 4) {
      $(".slideNav").addClass("slideNavMin");
    }
    var nrSets = $(".setBlock");
    for (var i = 0; i <= nrSets.length; i++) {
      $(nrSets[i])
        .find(".slideNav")
        .addClass("slideNav" + i);
      $(nrSets[i])
        .find(".slideSet")
        .addClass("slideSet" + i);
      $(".slideSet" + i).slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 500,
        arrows: false,
        dots: true,
        asNavFor: ".slideNav" + i
      });
      $(".slideNav" + i).slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        arrows: false,
        dots: false,
        speed: 500,
        variableWidth: false,
        asNavFor: ".slideSet" + i,
        focusOnSelect: true,
        centerMode: true,
        vertical: true
      });
    }
    $(".slideHome").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 5000,
      centerMode: true,
      speed: 3000,
      arrows: true,
      dots: false,
      speed: 500
    });
    $(".textSlide").slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 0,
      centerMode: true,
      arrows: false,
      dots: false,
      speed: 6000,
      vertical: true,
      easing: "ease",
      cssEase: "linear"
    });
    $(".slideItems").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 5000,
      centerMode: true,
      arrows: false,
      dots: false,
      speed: 500,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
    setTimeout(function(){
      $(".topSellers").slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 5000,
        centerMode: false,
        arrows: true,
        dots: false,
        speed: 500,
        variableWidth: true,
        swipe: true,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              variableWidth: false,
              swipe: true
            }
          }
        ]
      });
    }, 1000)
  });
});

// filters

$(document).ready(function() {

  var buttonFilter = $(".btnFilter");
  var filterOpen = $(".filterOpen");
  var clsoeFilter = $(".closeFilter");
  var option = $(".opt");
  var optionOpen = $("optionFiltrOpen");
  var closeThis = $(".closeThis");

  $(buttonFilter).click(function() {
    $(filterOpen).show();
  });
  $(clsoeFilter).click(function() {
    $(filterOpen).hide();
  });
  $(closeThis).click(function() {
    $(filterOpen).hide();
  });
  $(option).click(function() {
    $(this)
      .next(optionOpen)
      .toggle();
    $(this).toggleClass("submenuBcgMinus");
  });
});

// select size

$(function() {
  $(document).ready(function() {
    var selectBox = $(".selectBox");
    var optionSelectedBox = $(".optionSelectedBox");

    function showSelectBox(e) {
      if (
        $(e.target)
          .parent()
          .hasClass("active") ||
        $(e.target) == $(".selectBox").parents()
      ) {
        $(".selectBox").removeClass("active");
        $(e.target).parents('.productDescr').css('z-index', '2')
      } else {
        $(".selectBox").removeClass("active");
        $(e.target).parents('.productDescr').css('z-index', '2')
        e.stopPropagation();
        $(e.target)
          .parent()
          .addClass("active");
          $(e.target).parents('.productDescr').css('z-index', '3')
      }
    }
    function sizeSelected(e) {
      var targetItem = e.target;


      $(targetItem)
        .parent()
        .parent()
        .parent()
        .children(".optionSelectedBox")
        .text($(targetItem).val());
      $(targetItem)
        .parent()
        .parent()
        .parent()
        .children(".optionSelectedBox")
        .addClass("valueSelected");
      $(targetItem)
        .parent()
        .parent()
        .parent()
        .removeClass("active");
        $(targetItem).parents('.productDescr').css('z-index', '2');
        $(targetItem)
          .parent()
          .parent()
          .parent().parent()
          .children(".iconCart").addClass('animated heartBeat');
          var selectBox = $(targetItem)
            .parents('.productsInSet')
            .find(".optionSelectedBox");
            var selectBoxMod = $(targetItem)
              .parents('.productsInSet')
              .find("div.optionSelectedBox.valueSelected");
            if(selectBox.length === selectBoxMod.length){
              $(targetItem)
                .parents('.productsInSet').next().find('.buttAddToCartSet').addClass('animated heartBeat')
            }
    }
    function verificationSelected(e) {
      var e = e.target;
      var localSelectBoc = $(e)
        .parent()
        .children(".selectBox")
        .children(".optionSelectedBox");
      if (
        $(localSelectBoc)
          .eq(0)
          .hasClass("valueSelected")
      ) {
        $(e).addClass("addedToCart");
      } else {
        $(e)
          .parent()
          .children(".selectBox")
          .eq(0)
          .addClass("active");
          $(e).parents('.productDescr').css('z-index', '3')
        $(e)
          .parent()
          .children(".selectBox")
          .eq(0)
          .addClass("animated shake");
        $(e)
          .parent()
          .children(".selectBox")
          .eq(1)
          .removeClass("active");
      }
    }
    function verificationSelected(e) {
      var e = e.target;
      var localSelectBoc = $(e)
        .parent()
        .children(".selectBox")
        .children(".optionSelectedBox");
      if (
        $(localSelectBoc)
          .eq(0)
          .hasClass("valueSelected")
      ) {
        $(e).addClass("addedToCart");
      } else {
        $(e)
          .parent()
          .children(".selectBox")
          .eq(0)
          .addClass("active");
        if (screen.width > 768) {
          $(e)
            .parent()
            .children(".selectBox")
            .eq(0)
            .addClass("animated shake");
        }
        $(e)
          .parent()
          .children(".selectBox")
          .eq(1)
          .removeClass("active");
      }
    }

    function verificationSelectedSetPage(e) {
      var e = e.target;
      var items = $(e)
        .parent()
        .parent()
        .parent()
        .find(".selectBox");

      var localSelectBoc = $(e)
        .parent()
        .parent()
        .parent()
        .find(".selectBox")
        .children(".optionSelectedBox");

      for (var i = 0; i < items.length; i++) {
        $(items[i]).css("z-index", items.length - i);
      }

      for (var i = 0; i < items.length; i++) {
        if (
          $(items[i])
            .children(".optionSelectedBox")
            .hasClass("valueSelected")
        ) {
          // console.log(i);

          continue;
        } else {
          $(items[i]).parent().css('z-index', '3')
          $(items[i]).addClass("active animated shake");
          break;
        }

      }
    }

    $(document).on("mouseleave", ".oneProductBlock", function() {
      $(".selectBox").removeClass("active shake");
      $('.productDescr').css('z-index', '2')
    });

    // $(".".optionSelectedBox"").on("click", showSelectBox);
    $(document).on("click", ".optionSelectedBox", function(e){
        showSelectBox(e);
    });

    $(document).mouseup(function(e) {
      if (
        !$('.options').is(e.target) &&
        $('.options').has(e.target).length === 0
      ) {
        $('.selectBox').removeClass("active");
        $('.productDescr').css('z-index', '2')
        $(".selectBox").removeClass("active shake");
      }
    });

    $(document).on("change", $('.optionSelectedBox').next().find("input"), function(e){
        sizeSelected(e);
    });

    // $('.optionSelectedBox')
    //   .next()
    //   .find("input")
    //   .on("change", sizeSelected);


$(document).on("click", ".buttAddToCart", verificationSelected);
    $(document).on("click", ".buttAddToCart", function(e){
      $(e.target).parents('.productDescr').css('z-index', '3')
    });

    $(".buttAddToCartSet").on("click", verificationSelectedSetPage);
    if (screen.width < 768) {
      $(document).mouseup(function(e) {
        if (!selectBox.is(e.target) && selectBox.has(e.target).length === 0) {
          $(".selectBox").removeClass("active");
        }
      });
    }
  });
});

// zoom image

if (screen.width > 768) {
  $(function() {
    var el;
    function listImg() {
      var mainImg = $("img.mainImg"),
        controlImg = $("#controlZoomImg");
      for (var i = 0; i < mainImg.length; i++) {
        $(controlImg).append(
          '<img src="' + $(mainImg[i]).attr("src") + '" alt="" class="mainImg">'
        );
      }
    }
    listImg();
    var mainImg = $("img.mainImg");
    var zoomImg = $("img.zoomImg");
    var juliaZoom = $(".julia-zoom");
    var bigParent = $("#cover");
    var controlsMassive = $("#controlZoomImg img.mainImg");
    var srcControl = $("#controlZoomImg img.mainImg");
    mainImg.click(function() {
      zoomImg.attr("src", $(this).attr("src"));
      el = this;
      // console.log(el);
      for (var i = 0; i < controlsMassive.length; i++) {
        if ($(srcControl[i]).attr("src") === $("img.zoomImg").attr("src")) {
          $(srcControl[i]).addClass("activeMainImg");
        } else {
          $(srcControl[i]).removeClass("activeMainImg");
        }
      }
      bigParent.css("display", "none");
      juliaZoom.show();
      return false;
    });
    juliaZoom.mousemove(function(e) {
      var ham = $(this)
        .find("img.zoomImg")
        .height();
      var vpnHeight = $(document).height();
      var y = -((ham - vpnHeight) / vpnHeight) * e.pageY;

      $(this).css("top", y + "px");
    });
    juliaZoom.click(function() {
      juliaZoom.hide();
      bigParent.css("display", "block");
      // location.reload();
      // $(".textSlide").slick("setPosition");
      el.scrollIntoView();
    });
  });
}

// cart page

$(function() {

  $(document).ready(function() {
    var edit = $(".edit");
    var cancel = $(".cancel");
    var updateThis = $(".update");
    var signinBloc = $("#signinBloc");
    var registerBloc = $("#registerBloc");
    var signinTab = $("#signinTab");
    var registerTab = $("#registerTab");
    var cartContent = $(".cartContent");
    var orderSummary = $("#orderSummary");
    var lastY = 0;
    var cart = $(".cartContent");


    $('#bootstrap-modal').find('button').addClass('animated heartBeat')
    var videoOneProduct = document.getElementById('videoOneProduct');
    var buttSoundOneProduct = document.getElementById('buttSoundOneProduct');

    $('.templateProductsOne').on('load', function(){
      $('.productsPageContent').find('video').play()
    });


    // $(document).on("click", '.closeAlert', function(){
    //     $(this).parent().hide()
    // });


    if(videoOneProduct){
      buttSoundOneProduct.addEventListener('click', function(){
        $(this).children().toggleClass('soundEnabled')
        if(videoOneProduct.muted){
          videoOneProduct.muted = false;
        }
        else{
          videoOneProduct.muted = true;
        }
      })
    }

    function muteAllVideo(){
      $('.buttSound.buttSoundCat').next('a').children('video').prop('muted', true);
      $('.buttSound.buttSoundCat').children().removeClass('soundEnabled');
    }


      $(document).on('click', '.buttSound.buttSoundCat', function(){
        var buttSoundCat = $('.buttSound.buttSoundCat')


          if($(this).next('a').children('video').prop('muted')){
            muteAllVideo();
            $(this).next('a').children('video').prop('muted', false);
            $(this).children().addClass('soundEnabled')
          }
          else{
            muteAllVideo();
            $(this).next('a').children('video').prop('muted', true);
            $(this).children().removeClass('soundEnabled')
          }

      })


      $('.step2')
        .parents('main')
        .find('.deliveryCart')
        .hide();
        $('.step2')
          .parents('main')
          .find('h3')
          .hide();
    signinTab.click(function() {
      $(signinBloc).addClass("activeBloc");
      $(registerBloc).removeClass("activeBloc");
      $(this).addClass("active");
      $(registerTab).removeClass("active");
    });
    registerTab.click(function() {
      $(registerBloc).addClass("activeBloc");
      $(signinBloc).removeClass("activeBloc");
      $(this).addClass("active");
      $(signinTab).removeClass("active");
    });
    $(document).on('click', '.edit', function() {
      $(".optionsOpen").hide();
      $('.edit').show();
      $(".saveForLater").show();
      $(this).hide();
      $(this)
        .next()
        .hide();
      $(this)
        .parent()
        .children(".optionsOpen")
        .show();
    });
    function hideSaveUpdate(e) {
      var e = e.target;
      $(e)
        .parent()
        .parent()
        .toggle();
      $(e)
        .parent()
        .parent()
        .parent()
        .children(".edit")
        .show();
      $(e)
        .parent()
        .parent()
        .parent()
        .children(".saveForLater")
        .show();
    }
    $(document).on("click", '.cancel', hideSaveUpdate);
    $(document).on("click", '.updateThis', hideSaveUpdate);
  });
});

// footer

$(function() {
  var footerTitle = $(".footerTitle");
  var footerUl = $(".footerBloc").children("ul");
  let scrollPageTop = $('#scrollPageTop');
  scrollPageTop.click(function(){
    $(window).scrollTop(0)
  })
  if (screen.width < 768) {
    $(footerTitle).addClass("bcgPlusFooter");
    footerTitle.on("click", function(e) {
      footer(e);
    });
  }

  function footer(e) {
    $(footerTitle).removeClass("bcgMinusFooter");
    $(footerTitle).addClass("bcgPlusFooter");
    $(footerUl).css("height", "0");
    $(footerUl).css("padding-bottom", "0");
    if ($(e.target).hasClass("bcgPlusFooter")) {
      $(e.target).removeClass("bcgPlusFooter");
      $(e.target).addClass("bcgMinusFooter");
      $(e.target)
        .next(footerUl)
        .css("height", "auto");
      $(e.target)
        .next(footerUl)
        .css("padding-bottom", "20px");
    } else {
      $(e.target).addClass("bcgPlusFooter");
      $(e.target).removeClass("bcgMinusFooter");
      $(e.target)
        .next(footerUl)
        .css("height", "0");
      $(e.target)
        .next(footerUl)
        .css("padding-bottom", "0");
    }
  }
});

// tab script

$(function() {
  var tabOption = $(".tabOption");
  var tabOpen = $(".tabOpen");
  var tabHeader = $(".tabHeader");
  $(tabHeader).on("click", function() {
    $(tabOpen).removeClass("active");
    for (var i = 0; i <= tabOption.length; i++) {
      if (
        $(tabOption[i])
          .children("input")
          .prop("checked") == true
      ) {
        $(tabOpen)
          .eq(i)
          .addClass("active");
        break;
      }
    }
  });
});

$(window).on('load',function(){
     $('#modalSucces').modal('show');
 });
$(window).on('load',function(){
      $('#bootstrap-modal').modal('show');
  });
$('#bootstrap-modal').modal({backdrop: false, keyboard: false})
