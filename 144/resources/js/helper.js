/**
 * Segédfüggvények
 */

//Mikrotime lekérdezése
function getMicrotime() {
    var date = new Date();
    return date.getTime();
}

//Felugró üzenet
function message(message) {
    //toastr.info(message);
}

//Oldal scoroll-ra hívódik meg
function scroll() {
    var scroll = $(window).scrollTop();

    if (scroll < 1) {
        $(".header-nav-wrapper").addClass("lock");
    }
    else {
        if ($("main").attr('data-locked') == "inactive") {
            $(".header-nav-wrapper").removeClass("lock");
        }
    }
}
