/* Back To Top */
$(document).ready(function() {
    var height = $(window).height();
    $(window).scroll(function() {
        if ($(window).scrollTop() > height) {
            $(".back-to-top").fadeIn(500);
        } else {
            $(".back-to-top").fadeOut(500);
        }
    });
    $('.back-to-top').click(function() {
        $('body,html').animate({
            scrollTop: '0px'
        }, 900);
    });
});

/* Nav Slide */
function navResponsive() {
    var windowWidth = $(window).width();
    if (windowWidth > 768) {
        var isSpread = false;
        $(window).off('.navChange');
        $("nav").show();
        $(".spread").on("click", function() {
            if (isSpread == false) {
                $("ul").addClass("spread-true");
                $("ul").removeClass("spread-false");
                $(".spread").text('<');
                isSpread = true;
            } else {
                $("ul").addClass("spread-false");
                $("ul").removeClass("spread-true");
                 $(".spread").text('>');
                isSpread = false;
            }
        });
    } else {
        var height = 280;
        $("nav").hide();
        $(window).on('scroll.navChange', function() {
            if ($(window).scrollTop() > height) {
                $("nav").fadeIn(500);
            } else {
                $("nav").fadeOut(500);
            }
        });
    }
}

$(document).ready(function() {
    navResponsive();
});

$(window).resize(function() {
    navResponsive();
});

/* Pjax */

$(function () {
    $(document).pjax("a", '.container', {
        fragment: '.container',
        timeout: 6000
    });
});