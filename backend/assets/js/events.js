$(function () {
    $("#deactivateMatchmaker").click(function (e) {
        $.ajax({
            type: "GET",
            url: '../matchmaker/set-alive?alive=0'
        });
    });
    $("#activateMatchmaker").click(function (e) {
        $.ajax({
            type: "GET",
            url: '../matchmaker/set-alive?alive=1'
        });
    })


});