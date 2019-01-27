$(function() {
    'use strict';

    $(".posts div a.show-more").click(function(e) {
        e.preventDefault();
        $(".posts table tbody tr.hide").fadeToggle();
        if($(".posts div a.show-more").text() == "show more "){
            console.log($(".posts div a.show-more").text());
            $(".posts div a.show-more").html("show less <i class='fa fa-angle-up'></i>");
        }else {
            $(".posts div a.show-more").html("show more <i class='fa fa-angle-down'></i>");
        }
    });
    
});