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


    // Post Form Validation
    $(".addnewpost form").submit(function() {
        var title,content,tags,excerpt ;

        title = $('.addnewpost form input[name="title"]').val();
        content = $('.addnewpost form textarea').val();
        tags = $('.addnewpost form input[name="tags"]').val();
        excerpt = $('.addnewpost form input[name="excerpt"]').val();

        if(title.length < 30 || title.length > 200 ) {
            $(".addnewpost form .title-error").fadeIn(500);
            return false;
        }else {
            $(".addnewpost form .title-error").fadeOut(500);
        }
        if(content.length < 100 || content.length > 10000 ) {
            $(".addnewpost form .content-error").fadeIn(500);
            return false;
        }else {
            $(".addnewpost form .content-error").fadeOut(500);
        }
        if(excerpt.length !== 0) {
            if(excerpt.length < 100 || excerpt.length > 500 ) {
                $(".addnewpost form .excerpt-error").fadeIn(500);
                return false;
            }else {
                $(".addnewpost form .excerpt-error").fadeOut(500);
            }
        }
        return true;
    });

    // Category Form Validation
    $(".categories form:first").submit(function(){
        var name;
        name = $(".categories form input[name='name']").val();

        if(name.length < 4 || name.length > 50) {
            $(".categories form .name-error").fadeIn(500);
            return false; 
        }else {
            $(".categories form .name-error").fadeOut(500);
        }
        return true;
    });

});