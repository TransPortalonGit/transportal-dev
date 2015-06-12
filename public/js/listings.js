    // Zeichenzähler
    function initializeCharacterCounter(){
        var infoboxes = $('.info-box');
        var items = infoboxes.prev();

        infoboxes.text('');
        infoboxes.hide();

        items.keyup(function(){
            $this = $(this); // Input, in den getippt wird

            var currentLength = $this.val().length;
            var maxLength = $this.attr('maxlength');

            $this.next().text(maxLength - currentLength + ' characters left');
        });

        items.focus(function(){
            $(this).next().show();
            $(this).trigger('keyup');
        });

        items.blur(function(){
            infoboxes.hide();
        });
    }

    // Submit Form, wenn ein Objekt der Klasse sich ändert
    function setAutoSubmit(){
        $(".auto-submit").change(function() {
            $(this).parents("form").submit();
        });
    }