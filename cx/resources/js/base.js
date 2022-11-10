$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.lazySizesConfig = {
    addClasses: true
    //,threshold: 80 //default is 160
};

/**
 * Felhasználói felület késleltetése
 */

var uiTimeout = null;

function clearUITimeout() {
    clearTimeout(uiTimeout);
}

function UITimeout(callback) {
    clearUITimeout();

    const timeout = 500;
    uiTimeout = setTimeout(callback, timeout);
}

/**
 * Segédfüggvények
 */

//Mikrotime lekérdezése
function getMicrotime() {
    var date = new Date();
    return date.getTime();
}

//Oldal scoroll-ra hívódik meg
function scroll() {
    var scroll = $(window).scrollTop();

    if (scroll < 1) {
        $(".header-nav-wrapper").addClass("lock");
    } else {
        if ($("main").attr('data-locked') == "inactive") {
            $(".header-nav-wrapper").removeClass("lock");
        }
    }
}

/**
 * Főmenü
 */

function catGet(catID) {
    if (typeof catID == "undefined") {
        return "data-category-id";
    } else {
        return "[" + catGet() + "='" + catID + "']";
    }
}

function dataLock(type, obj) {
    var attr = "data-locked";
    var active = "active"
    var inactive = "inactive"

    switch (type) {
        case 0:
            $(obj).attr(attr, inactive);
            break;
        case 1:
            $(obj).attr(attr, active);
            break;
    }
}

function dataState(type, obj) {
    var attr = "data-state";
    var active = "[" + attr + "='active']"
    var inactive = "[" + attr + "='inactive']"
    switch (type) {
        case -1:
            return active;
            break;
        case 0:
            $(obj).filter(active).attr(attr, "inactive");
            break;
        case 1:
            $(obj).filter(inactive).attr(attr, "active");
            break;
        default:
            return $(obj).attr(attr);
    }
}

// function closeAllNav(e) { // close all navigation elements
//     // close all navigation elements when not hitting target
//     if (typeof e != "undefined") {
//         var container = $("*" + dataState(-1));
//         if (!container.is(e.target) && container.has(e.target).length === 0) {
//             closeAllNav();
//         }
//         return false;
//     }
//     //used for top navigation
//     dataState(0, "*");
//     $(".subnav .right").find("h2").html("");
//     fillNav();
//     //used for filter tags
//     $("[data-clear]").remove();
//
// }

// function closeSearchNav(e) { // close search field
// 	window.search.$refs.main_search.close();
// }

// function clickNav(e, obj) { // open, close navigation
//     if (dataState(null, e.currentTarget) == "inactive") {
//         closeAllNav();
//         //closeSearchNav(e);
//         dataLock(0, "main");
//         var catID = $(e.currentTarget).attr(catGet());
//         var sel = obj + catGet(catID);
//         dataState(1, sel);
//         dataState(1, e.currentTarget);
//     } else {
//         closeAllNav();
//     }
// }

// function fillNav(e) { // fill  or clear second level of subnav
//     var obj = $(".subnav .right");
//     if (typeof e == "undefined") {
//         obj.hide();
//     } else {
//         var c = $(e.target).html();
//         var h = $(e.target).attr("href");
//         var catID = $(e.target).attr(catGet());
//         obj.find(".title a").attr("href", h);
//         obj.find(".cat").removeAttr("data-state");
//         obj.find(".cat" + catGet(catID)).attr("data-state", "active");
//         obj.show();
//     }
//     ;
//     obj.find(".title h2").html(c);
// }

/**
 * Telepítői ár ki és bekapcsolása
 * @param value
 */
function setInstallerPrice(value) {
    $('input[name="installer_price"]').prop('checked', value);
    if (value) {
        $('.telepitoi-ar').addClass('block').removeClass('hidden');
    } else {
        $('.telepitoi-ar').addClass('hidden').removeClass('block');
    }
    $.ajax({
        url: $('meta[name="installer_price_save"]').attr('content'),
        data: {
            value: value,
        },
        type: 'post',
        success: function (d) {
            $('input[name="installer_price"]').prop('checked', d.value);
            if (d.value) {
                $('.telepitoi-ar').addClass('block').removeClass('hidden');
            } else {
                $('.telepitoi-ar').addClass('hidden').removeClass('block');
            }
        }
    });
}

/**
 * Typewrite JS
 */

var TxtType = function (el, toRotate, period, mode) {
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 2000;
    this.txt = '';
    if (mode = "fulltext") this.fulltext();
    else this.tick();
    this.isDeleting = false;

};

TxtType.prototype.fulltext = function () {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];

    var that = this;
    var delta = this.period;
    this.loopNum++;

    this.txt = fullTxt;
    this.el.children[0].innerHTML = this.txt;
    this.el.children[0].classList.remove("noshow");

    setTimeout(function () {
        that.el.children[0].classList.add("noshow");
        setTimeout(function () {
            that.fulltext();
        }, 1000);
    }, delta);


}

TxtType.prototype.tick = function () {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];

    if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
    } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    this.el.innerHTML = '<span class="wrap nowrap cursor">' + this.txt + '</span>';

    var that = this;
    var delta = 200 - Math.random() * 200;

    if (this.isDeleting) {
        delta /= 2;
    }

    if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
    } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
    }

    setTimeout(function () {
        that.tick();
    }, delta);
};


// When the user clicks on the button, scroll to the top of the document
function goToTop() {
    $('html, body').animate({
        scrollTop: 0
    }, 800);
}

$(document).ready(function () {


    var toTopButton = document.getElementById("to-top-button");

    // When the user scrolls down 200px from the top of the document, show the button
    window.onscroll = function () {
        if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
            toTopButton.classList.remove("hidden");
        } else {
            toTopButton.classList.add("hidden");
        }

    }


    /**
     * Oldal görgetése
     */
    $(window).scroll(function (e) {
        scroll(e);
    });
    scroll();


    $('input[name="installer_price"]').click(function () {
        setInstallerPrice($(this).is(':checked'));
    });

    $('#settings-form input').click(function () {

        var form = $(this).closest('form');
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function (data) {
                alert(data);
            }
        });
    });

    $('.close-site-message').click(function () {
        $.ajax({
            type: "POST",
            url: '/close-site-message',
            success: function () {
                $('.site-message-box').remove();
            }
        });
    });

    $(".matrix td:not(:first-of-type):not(.title):not(.legend)").mouseover(function (e) {
        index = $(this).index();
        index++;
        $(".matrix th:nth-child(" + index + ")").addClass("selected");
        $(this).parent().parent().children("tr").children("td:nth-child(" + index + "):not(.title):not(.legend)").addClass("selected");
        $(this).parent().children("td").addClass("selected");
        $(this).addClass("current");
    });

    $(".matrix td").mouseout(function (e) {
        index = $(this).index();
        index++;
        $(".matrix th:nth-child(" + index + ")").removeClass("selected");
        $(this).parent().parent().children("tr").children("td:nth-child(" + index + ")").removeClass("selected");
        $(this).parent().children("td").removeClass("selected");
        $(this).removeClass("current");
    });

});


function scrollTo(id) {
    $('html, body').animate({
        scrollTop: $('#' + id).offset().top
    }, 1000);
}

function closeModal() {
    var modalContainer = $('.modal-container');
    var body = $('body');
    modalContainer.animate({
        opacity: 0
    }, 300);
    setTimeout(() => {
        modalContainer.css("display", "none");
    }, 300)
    body.removeClass('no-scroll');
}
