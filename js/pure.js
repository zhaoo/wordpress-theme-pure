// Back To Top
$(document).ready(function () {
    $(window).scroll(function () {
        var height = $(window).height();
        var scrollTop = $(window).scrollTop();
        var scrollPercent = Math.round((scrollTop) / ($(document).height() - height) * 100);
        $("#scroll-percent").text(scrollPercent + "%");
        if (scrollTop > height) {
            $(".back-to-top").addClass("back-to-top-on");
        } else {
            $(".back-to-top").removeClass("back-to-top-on");
        }
    });
    $('.back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: '0px'
        }, 1000);
    });
});

// Navbar Slide
function navResponsive() {
    var windowWidth = $(window).width();
    if (windowWidth > 768) {
        var isSpread = false;
        $(window).off('.navChange');
        $("nav").show();
        $(".spread").on("click", function () {
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
        $(window).on('scroll.navChange', function () {
            if ($(window).scrollTop() > height) {
                $("nav").fadeIn(500);
            } else {
                $("nav").fadeOut(500);
            }
        });
    }
}

$(document).ready(function () {
    navResponsive();
});

$(window).resize(function () {
    navResponsive();
});

// Start Highlist.js
$(document).ready(function () {
    $('pre code').each(function (i, e) {
        hljs.highlightBlock(e)
    });
});

// Like
$(document).ready(function () {
    $.fn.postLike = function () {
        if ($(this).hasClass('like-done')) {
            return false;
        } else {
            $(this).addClass('like-done');
            var id = $(this).data("id"),
                action = $(this).data('action'),
                rateHolder = $(this).children('.count');
            var ajax_data = {
                action: "bigfa_like",
                um_id: id,
                um_action: action
            };
            $.post("/wp-admin/admin-ajax.php", ajax_data, function (response) {
                $(rateHolder).html(response);
            });
            return false;
        }
    };
    $(document).on("click", "#post-like", function () {
        $(this).postLike();
    });
});

// Comment Auther Load
$(document).ready(function () {
    $("#comment").on("click", function () {
        $(".comment-fields").fadeIn(300);
    });
});

// FancyBox
$(document).ready(function () {
    $(".fancybox").fancybox();
});

// Ajax Pagination
function ajaxPagination() {
    $("#pagination a").on("click", function () {
        $(this).hide();
        $(".loading").show();
        $.ajax({
            type: "POST",
            url: $(this).attr("href") + ".list",
            success: function (data) {
                result = $(data).find(".list .item");
                nextHref = $(data).find("#pagination a").attr("href");
                $(".list").append(result.fadeIn(300));
                $("#pagination a").show();
                $(".loading").hide();
                if (nextHref != undefined) {
                    $("#pagination a").attr("href", nextHref);
                } else {
                    $("#pagination").remove();
                }
            }
        });
        return false;
    });
}
ajaxPagination();