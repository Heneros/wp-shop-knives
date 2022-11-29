

jQuery(function ($) {
  AOS.init({});
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



  $('.filter-style').styler();
  $(".filter__item-drop").on('click', function () {
    $(this).toggleClass('filter__item-drop--active');
    $(this).next().slideToggle(200);
  });


  const slider__heading = document.querySelectorAll(".slider-homepage__title");

  slider__heading.forEach(element => {
    let text = element.innerHTML.split(' ');
    const results = text.filter(el => {
      return el !== '';
    });
    let first = results.splice(0, 3);
    element.innerHTML = `${first.join(' ')} <br><span>${results.join(' ')}</span>`;
  });



  const header__logo = document.querySelector('.header__logo');

  const body = document.querySelector('body');
  const pageHeader = document.querySelector(".page-header");
  const header__search = document.querySelector('.header__search-field');
  // const toggleMenu = document.querySelector(".toggle-menu");
  const toggleMenu = document.querySelector(".hamburger");
  const menuWrapper = document.querySelector(".menu-wrapper");
  const level1Links = document.querySelectorAll(".level-1 > li > a");
  const listWrapper2 = document.querySelector(".list-wrapper:nth-child(2)");
  const listWrapper3 = document.querySelector(".list-wrapper:nth-child(3)");
  const subMenuWrapper2 = listWrapper2.querySelector(".sub-menu-wrapper");
  const subMenuWrapper3 = listWrapper3.querySelector(".sub-menu-wrapper");
  const backOneLevelBtns = document.querySelectorAll(".back-one-level");
  const isVisibleClass = "is-visible";
  const isActiveClass = "is-active";

  toggleMenu.addEventListener("click", function () {

    menuWrapper.classList.toggle(isVisibleClass);
    toggleMenu.classList.toggle(isActiveClass);
    header__logo.classList.toggle('hidden');
    header__search.classList.toggle('visible');
    body.classList.toggle('noOverflow');


    if (!this.classList.contains(isVisibleClass)) {
      listWrapper2.classList.remove(isVisibleClass);
      listWrapper3.classList.remove(isVisibleClass);
      const menuLinks = menuWrapper.querySelectorAll("a");
      for (const menuLink of menuLinks) {
        menuLink.classList.remove(isActiveClass);
      }
    }
  });

  for (const level1Link of level1Links) {
    level1Link.addEventListener("click", function (e) {
      const siblingList = level1Link.nextElementSibling;
      if (siblingList) {
        e.preventDefault();
        this.classList.add(isActiveClass);
        const cloneSiblingList = siblingList.cloneNode(true);
        subMenuWrapper2.innerHTML = "";
        subMenuWrapper2.append(cloneSiblingList);
        listWrapper2.classList.add(isVisibleClass);

      }
    });
  }

  listWrapper2.addEventListener("click", function (e) {
    const target = e.target;
    if (target.tagName.toLowerCase() === "a" && target.nextElementSibling) {
      const siblingList = target.nextElementSibling;
      e.preventDefault();
      target.classList.add(isActiveClass);
      const cloneSiblingList = siblingList.cloneNode(true);
      subMenuWrapper3.innerHTML = "";
      subMenuWrapper3.append(cloneSiblingList);
      listWrapper3.classList.add(isVisibleClass);
    }
  });

  for (const backOneLevelBtn of backOneLevelBtns) {
    backOneLevelBtn.addEventListener("click", function () {
      const parent = this.closest(".list-wrapper");
      parent.classList.remove(isVisibleClass);
      parent.previousElementSibling
        .querySelector(".is-active")
        .classList.remove(isActiveClass);
    });
  }
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

  // var slider__heading = document.querySelectorAll(".slider-homepage__title");
  // slider__heading.forEach(function (element) {
  //   var text = element.innerHTML.split(' ');
  //   var first = text.splice(0, 2);
  //   element.innerHTML = " ".concat(first.join(' '), " <br><span>").concat(text.join(' '), "</span>");
  // });


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

  function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() { }; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

  function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

  function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



  /////menu



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
  });

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
var bodyy = document.querySelector("body");
var blank = document.querySelector(".blank");

var close = function close() {
  shopCatalogFilters.classList.remove("activeLeft");
  shopCatalogLeft.classList.remove("blur");
  bodyy.classList.remove("overflowHidden");
};

if (btnFilter != null) {
  btnFilter.addEventListener("click", function (e) {
    shopCatalogFilters.classList.add("activeLeft");
    shopCatalogLeft.classList.add("blur");
    bodyy.classList.add("overflowHidden");
  });
}

if (blank != null) {
  blank.addEventListener("click", function (e) {
    close();
  });
}

