"use strict";

jQuery(function ($) {
  $(document.body).on("click", ".js-open-cart", function () {
    $(".cart-products").toggleClass("active"); // alert(123);
  });
  $(document.body).on("click", function (e) {
    if (!$(e.target).closest(".cart-products").length && !$(e.target).closest(".js-open-cart").length) {
      $(".cart-products").removeClass("active");
    }

    e.stopPropagation();
  });
  setTimeout(function () {
    $('.loader-screen').animate({
      height: '100%',
      top: '-100vh'
    }, 1000, function () {
      $(".loader-screen").css("display", 'none');
    });
  }, 200);
});
"use strict";

var findMyState = function findMyState() {
  var status = document.querySelector('.location');

  var success = function success(position) {
    // console.log(position);
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude; // console.log('latitude ' + latitude + ' longitude ' + longitude);

    var geoApiUrl = "https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=".concat(latitude, "&longitude==").concat(longitude, "&localityLanguage=en");
    fetch(geoApiUrl).then(function (res) {
      return res.json();
    }).then(function (data) {
      // console.log(data);
      status.textContent = data.principalSubdivision;
    });
  };

  var error = function error() {
    status.textContent = "Odessa";
  };

  navigator.geolocation.getCurrentPosition(success, error);
};

findMyState();
"use strict";

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() { }; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/////menu
AOS.init({
  easing: 'ease-out-back',
  duration: 2700
});
var intervalId;
document.querySelectorAll('.js-select').forEach(function (e) {
  e.addEventListener('click', function (e) {
    var menu = e.currentTarget.dataset.path;
    document.querySelectorAll('.select-header__main').forEach(function (e) {
      if (!document.querySelector("[data-target=".concat(menu, "]")).classList.contains('open')) {
        e.classList.remove('select-header__visible');
        e.classList.remove('open');
        document.querySelector("[data-target=".concat(menu, "]")).classList.add('select-header__visible');
        intervalId = setTimeout(function () {
          document.querySelector("[data-target=".concat(menu, "]")).classList.add('open');
        }, 0);
      }

      if (document.querySelector("[data-target=".concat(menu, "]")).classList.contains('open')) {
        clearTimeout(intervalId);
        document.querySelector("[data-target=".concat(menu, "]")).classList.remove('select-header__visible');
        intervalId = setTimeout(function () {
          document.querySelector("[data-target=".concat(menu, "]")).classList.remove('open');
        }, 0);
      }

      window.onclick = function (e) {
        if (e.target == document.querySelector("[data-target=".concat(menu, "]")) || e.target == document.querySelector("[data-path=".concat(menu, "]") || e.target == document.querySelector('select-header__main'))) {
          return;
        } else {
          document.querySelector("[data-target=".concat(menu, "]")).classList.remove('select-header__visible');
          document.querySelector("[data-target=".concat(menu, "]")).classList.remove('open');
        }
      };
    });
  });
});
window.addEventListener('scroll', function () {
  var header = document.querySelector('.header');

  if (window.scrollY > 135) {
    header.classList.add("sticky");
  } else if (window.scrollY < 50) {
    header.classList.remove("sticky");
  }
}); // console.log(window.scrollY);
// window.addEventListener('scroll', function () {
//     var header = document.querySelector('.header');
//     if (window.scrollY > 35) {
//         header.classList.add("sticky");
//     } else if (window.scrollY < 50) {
//         header.classList.remove("sticky");
//     }
// })
///mobile burger menu
// const menu_btn = document.querySelector('.hamburger');
// const mobile_menu = document.querySelector('.mobile-nav');
// const header__cart = document.querySelector('.header__cart-link');
// const header__favorites = document.querySelector('.header-mobile__favorites');
// const header__mobileCall = document.querySelector('.header-mobile__call');
// const header__mobileAccount = document.querySelector('.header-mobile__account');
// // const heade__FirstLine = document.querySelector('.header__first-line');
// const header__logoWhite = document.querySelector('.header__logo-white');
// menu_btn.addEventListener('click', function () {
//     menu_btn.classList.toggle('is-active');
//     mobile_menu.classList.toggle('is-active');
//     header__logo.classList.toggle('hidden');
//     header__search.classList.toggle('visible');
//     header__cart.classList.toggle('hidden');
//     header__favorites.classList.toggle('hidden');
//     header__mobileCall.classList.toggle('hidden');
//     header__mobileAccount.classList.toggle('hidden');
//     header__logoWhite.classList.toggle('visible');
//     // heade__FirstLine.classList.toggle('visible');
// });

var header__logo = document.querySelector('.header__logo');
var body = document.querySelector('body');
var pageHeader = document.querySelector(".page-header");
var header__search = document.querySelector('.header__search-field'); // const toggleMenu = document.querySelector(".toggle-menu");

var toggleMenu = document.querySelector(".hamburger");
var menuWrapper = document.querySelector(".menu-wrapper");
var level1Links = document.querySelectorAll(".level-1 > li > a");
var listWrapper2 = document.querySelector(".list-wrapper:nth-child(2)");
var listWrapper3 = document.querySelector(".list-wrapper:nth-child(3)");
var subMenuWrapper2 = listWrapper2.querySelector(".sub-menu-wrapper");
var subMenuWrapper3 = listWrapper3.querySelector(".sub-menu-wrapper");
var backOneLevelBtns = document.querySelectorAll(".back-one-level");
var isVisibleClass = "is-visible";
var isActiveClass = "is-active";
toggleMenu.addEventListener("click", function () {
  menuWrapper.classList.toggle(isVisibleClass);
  toggleMenu.classList.toggle(isActiveClass);
  header__logo.classList.toggle('hidden');
  header__search.classList.toggle('visible');
  body.classList.toggle('noOverflow');

  if (!this.classList.contains(isVisibleClass)) {
    listWrapper2.classList.remove(isVisibleClass);
    listWrapper3.classList.remove(isVisibleClass);
    var menuLinks = menuWrapper.querySelectorAll("a");

    var _iterator = _createForOfIteratorHelper(menuLinks),
      _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var menuLink = _step.value;
        menuLink.classList.remove(isActiveClass);
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
  }
});

var _iterator2 = _createForOfIteratorHelper(level1Links),
  _step2;

try {
  var _loop = function _loop() {
    var level1Link = _step2.value;
    level1Link.addEventListener("click", function (e) {
      var siblingList = level1Link.nextElementSibling;

      if (siblingList) {
        e.preventDefault();
        this.classList.add(isActiveClass);
        var cloneSiblingList = siblingList.cloneNode(true);
        subMenuWrapper2.innerHTML = "";
        subMenuWrapper2.append(cloneSiblingList);
        listWrapper2.classList.add(isVisibleClass);
      }
    });
  };

  for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
    _loop();
  }
} catch (err) {
  _iterator2.e(err);
} finally {
  _iterator2.f();
}

listWrapper2.addEventListener("click", function (e) {
  var target = e.target;

  if (target.tagName.toLowerCase() === "a" && target.nextElementSibling) {
    var siblingList = target.nextElementSibling;
    e.preventDefault();
    target.classList.add(isActiveClass);
    var cloneSiblingList = siblingList.cloneNode(true);
    subMenuWrapper3.innerHTML = "";
    subMenuWrapper3.append(cloneSiblingList);
    listWrapper3.classList.add(isVisibleClass);
  }
});

var _iterator3 = _createForOfIteratorHelper(backOneLevelBtns),
  _step3;

try {
  for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
    var backOneLevelBtn = _step3.value;
    backOneLevelBtn.addEventListener("click", function () {
      var parent = this.closest(".list-wrapper");
      parent.classList.remove(isVisibleClass);
      parent.previousElementSibling.querySelector(".is-active").classList.remove(isActiveClass);
    });
  }
} catch (err) {
  _iterator3.e(err);
} finally {
  _iterator3.f();
}
"use strict";

jQuery(function ($) {
  //Increment quantity products
  $(document).on("click", '.js-quantity-plus', function () {
    var btn = $(this);
    var block = btn.closest('.js-quantity');
    var kol = block.find('.js-quantity-input').val(); //If bigger than 100. you need to stop

    if (kol <= 1000) {
      kol++;
    }

    block.find('.js-quantity-input').val(kol);
    block.find('.js-quantity-input').trigger('change');
  }); //Decreament quantity products

  $(document).on("click", '.js-quantity-minus', function () {
    var btn = $(this);
    var block = btn.closest('.js-quantity');
    var kol = block.find('.js-quantity-input').val();

    if (kol > 1) {
      kol--;
    }

    block.find('.js-quantity-input').val(kol);
    block.find('.js-quantity-input').trigger('change');
  }); ///Tabs

  $(".js-tabs-head-item").on('click', function () {
    if (!$(this).hasClass('active')) {
      var btns = $(this).closest(".js-tabs").find(".js-tabs-head-item");
      var count;
      $(btns).each(function () {
        $(this).removeClass("active");
      });
      $(this).addClass("active");
      $(btns).each(function (index) {
        if ($(this).hasClass("active")) {
          count = index;
        }
      });
      var blocks = $(".js-tabs-body").find(".js-tabs-body-item");
      $(blocks).each(function (index) {
        if (index == count) {
          $(this).addClass("active");
        } else {
          $(this).removeClass("active");
        }
      });
    }
  });
});
var prodSlider1 = new Swiper('.mySwiperGallery1', {
  spaceBetween: 7,
  slidesPerView: 4,
  freeMode: true,
  watchSlidesProgress: true
});
var prodSlider2 = new Swiper('.mySwiperGallery2', {
  slidesPerView: 1,
  thumbs: {
    swiper: prodSlider1
  }
});
"use strict";

jQuery(document).ready(function ($) {
  $('.filter-style').styler();
  $(".filter__item-drop").on('click', function () {
    $(this).toggleClass('filter__item-drop--active');
    $(this).next().slideToggle(200);
  });
  var rangeSlider = document.getElementById('range-slider');

  if (rangeSlider != null) {
    noUiSlider.create(rangeSlider, {
      start: [500, 5000],
      connect: true,
      step: 1,
      range: {
        'min': [500],
        'max': [5000]
      }
    });

    var _input = document.getElementById('input-0');

    var _input2 = document.getElementById('input-1');

    var _inputs = [_input, _input2];
    rangeSlider.noUiSlider.on('update', function (values, handle) {
      _inputs[handle].value = Math.round(values[handle]);
    });

    var setRangeSlider = function setRangeSlider(i, value) {
      var arr = [null, null];
      arr[i] = value;
      rangeSlider.noUiSlider.set(arr);
    };

    _inputs.forEach(function (el, index) {
      el.addEventListener('change', function (e) {
        setRangeSlider(index, e.currentTarget.value);
      });
    });
  }

  var stepsSlider = document.getElementById('steps-slider');
  var input0 = document.getElementById('input-with-keypress-0');
  var input1 = document.getElementById('input-with-keypress-1');
  var inputs = [input0, input1];

  if (stepsSlider != null) {
    noUiSlider.create(stepsSlider, {
      start: [100, 500],
      connect: true,
      range: {
        'min': [100],
        'max': [500]
      }
    });
    stepsSlider.noUiSlider.on('update', function (values, handle) {
      inputs[handle].value = Math.round(values[handle]);
    });
    inputs.forEach(function (input, handle) {
      input.addEventListener('change', function () {
        stepsSlider.noUiSlider.setHandle(handle, this.value);
      });
      input.addEventListener('keydown', function (e) {
        var values = stepsSlider.noUiSlider.get();
      });
    });
  }

  var stepsSlider = document.getElementById('length-slider');
  var input0Length = document.getElementById('input-length-0');
  var input1Length = document.getElementById('input-length-1');
  var inputsTotalLength = [input0Length, input1Length];

  if (stepsSlider != null) {
    noUiSlider.create(stepsSlider, {
      start: [5, 10],
      connect: true,
      range: {
        'min': [5],
        'max': [100]
      }
    });
    stepsSlider.noUiSlider.on('update', function (values, handle) {
      inputsTotalLength[handle].value = Math.round(values[handle]);
    });
    inputsTotalLength.forEach(function (input, handle) {
      input.addEventListener('change', function () {
        stepsSlider.noUiSlider.setHandle(handle, this.value);
      });
      input.addEventListener('keydown', function (e) {
        var values = stepsSlider.noUiSlider.get();
      });
    });
  }

  var widthSlider = document.getElementById('width-total-slider');
  var input0Width = document.getElementById('input-width-0');
  var input1Width = document.getElementById('input-width-1');
  var inputsTotalWidth = [input0Width, input1Width];

  if (widthSlider != null) {
    noUiSlider.create(widthSlider, {
      start: [5, 10],
      connect: true,
      range: {
        'min': [5],
        'max': [100]
      }
    });
    widthSlider.noUiSlider.on('update', function (values, handle) {
      inputsTotalWidth[handle].value = Math.round(values[handle]);
    });
    inputsTotalWidth.forEach(function (input, handle) {
      input.addEventListener('change', function () {
        widthSlider.noUiSlider.setHandle(handle, this.value);
      });
      input.addEventListener('keydown', function (e) {
        var values = widthSlider.noUiSlider.get();
      });
    });
  } ////adaptive filters


  var btnFilter = document.querySelector("#btn-filters");
  var shopCatalogLeft = document.querySelector(".shop-catalog__left");
  var shopCatalogFilters = document.querySelector(".shop-catalog__filters");
  var body = document.querySelector("body");
  var blank = document.querySelector(".blank");

  var close = function close() {
    shopCatalogFilters.classList.remove("activeLeft");
    shopCatalogLeft.classList.remove("blur");
    body.classList.remove("overflowHidden");
  };

  if (btnFilter != null) {
    btnFilter.addEventListener("click", function (e) {
      shopCatalogFilters.classList.add("activeLeft");
      shopCatalogLeft.classList.add("blur");
      body.classList.add("overflowHidden");
    });
  }

  if (blank != null) {
    blank.addEventListener("click", function (e) {
      close();
    });
  }
});
"use strict";

///slider
var swiper = new Swiper('.slider-homepage__swiper', {
  speed: 800,
  spaceBetween: 100,
  pagination: {
    el: '.swiper-pagination',
    type: 'custom',
    renderCustom: function renderCustom(swiper, current, total, curClas) {
      var indT = total >= 10 ? total : "0".concat(total);
      var indC = current >= 10 ? current : "0".concat(current);
      return "<b>".concat(indC, "</b><span></span> ").concat(indT);
    }
  },
  scrollbar: {
    el: '.slider-homepage__scrollbar',
    draggable: true
  },
  breakpoints: {}
}); ///Add span

var slider__heading = document.querySelectorAll(".slider-homepage__title");
slider__heading.forEach(function (element) {
  var text = element.innerHTML.split(' ');
  var first = text.splice(0, 2);
  element.innerHTML = " ".concat(first.join(' '), " <br><span>").concat(text.join(' '), "</span>");
});
"use strict";

var noveltySlider = new Swiper('.novelty-slider', {
  slidesPerView: 1,
  spaceBetween: 20,
  pagination: {
    el: '.novelty__pagination'
  },
  breakpoints: {
    1160: {
      slidesPerView: 3
    },
    756: {
      slidesPerView: 2
    }
  }
});
"use strict";

var ProductsSlider = new Swiper('.bestsellers-products-swiper', {
  speed: 800,
  // spaceBetween: 20,
  // slidesPerView: 4,
  slidesPerView: 1,
  spaceBetween: 30,
  pagination: {
    el: '.bestsellers-products__pagination'
  },
  breakpoints: {
    650: {
      slidesPerView: 2
    },
    991: {
      slidesPerView: 3
    },
    1500: {
      slidesPerView: 4,
      spaceBetween: 30
    }
  }
});