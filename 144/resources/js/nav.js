$(document).ready(function () {
    $(document).mousedown(function (e) { // mousedown for whole document
       // closeAllNav(e); //close all navigation elements
        if(!$(e.target).closest('.toggleable').length){
            $('.toggle-input').prop('checked', false);
            $('#nav-icon2').removeClass('mobile-open');
        }

    });

    $('.toggleable').click(function(){
        $('.toggle-input').not(($(this).find('.toggle-input'))).prop('checked', false);
    })

    $('#nav-icon2').click(function(){
        if($(this).hasClass('mobile-open')){
            $('.blurable').removeClass('relative blur-xs');
        }else{
            $('.blurable').addClass('relative blur-xs').append('<div class="overlay"></div>');
        }
    })


//Mobil menü megjelenítése és elrejtése
//     $(".nav-toggle").click(function (e) {
//         clickNav(e, ".nav");
//     });
//
//     $(".nav-button").click(function (e) { // show or clear subnav
//         clickNav(e, ".subnav");
//     });
//
//     $(".subnav .left .cat a").click(function (e) { // handle subnav clicks
//         var obj = $(".subnav .right");
//         var text = $(this).html();
//         if ((!$(this).hasClass("nochild")) && (obj.find("h2").html() != text)) {
//             e.preventDefault();
//             fillNav(e);
//         }
//     });
//
});


//
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
//
// function closeSearchNav(e) { // close search field
//     window.search.$refs.main_search.close();
// }
//
// function clickNav(e, obj) { // open, close navigation
//     if (dataState(null, e.currentTarget) == "inactive") {
//         closeAllNav();
//         closeSearchNav(e);
//         dataLock(0, "main");
//         var catID = $(e.currentTarget).attr(catGet());
//         var sel = obj + catGet(catID);
//         dataState(1, sel);
//         dataState(1, e.currentTarget);
//     } else {
//         closeAllNav();
//     }
// }
//
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
