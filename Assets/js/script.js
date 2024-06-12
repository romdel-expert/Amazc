$(document).ready(function () {

    $(".box-small-menu").hide();
    
    $(".nav").show();
    $(".content").hide();

    $("#closeSmallMenu").click(function () {
        $(".box-small-menu").hide();
    });

    $("#openSmallMenu").click(function () {
        $(".box-small-menu").show();
    });

    $(".clickAndClose").click(function () {
      $(".box-small-menu").hide();
    });


    $("#content-small-menu").hide();

    $("#btn-menu").click(function () {
        $("#content-small-menu").show();
    });

    $("#btn-close-menu").click(function () {
      $("#content-small-menu").hide();
    });
});
