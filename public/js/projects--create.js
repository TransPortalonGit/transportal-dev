$(document).ready(function(){
    // Event Listener für Farbauswahl
    $('input[name=color]').change(function(e) {
        e.preventDefault();
        var colorToSet = $(this).parent().find('.color-swatch').css('background-color');
        
        // Farbe setzen
        $('.bigGlyphicon').css('color', colorToSet);
        return false;
    });

});