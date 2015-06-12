$( document ).ready(function() {

    $( ".open-btn" ).click(function(event) {
        event.preventDefault();


        if( $(this).parent().hasClass("single-question-full") ) {
            $(this).children().removeClass("animate-rotate");
            $(this).parent().removeClass("single-question-full");
        } else {
            $(this).children().addClass("animate-rotate");
            $(this).parent().addClass("single-question-full");
        }
        /*
        if($(this).parent().parent().nextAll(".answer").first().is(":hidden") ){
            $(this).children().addClass("rotate");
            $(this).parent().parent().nextAll(".answer").first().show();
        } else {
            $(this).children().removeClass("rotate");
            $(this).parent().parent().nextAll(".answer").first().hide();
        }
        */


    });

});



