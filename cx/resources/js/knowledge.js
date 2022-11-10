$(document).ready(function () {
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: '/knowledge/ajax/view',
            data: {
                slug: window.location.href.split("/").pop(),
            },
            success: function() {}
        });
    }, 10000);

});
