$(document).ready(function () {
    $(".item").find("a").on("click", function () {
        $(".item").find("a").removeClass("active");
        $(this).addClass("active");
        $(".page").removeClass("show");
        $("#page-"+($(this).attr("id").substr(5, 1))).addClass("show");
    });
});