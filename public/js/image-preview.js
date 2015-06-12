var ImagePreview = {

    // Initialisiert die Scores
    init: function(){
        this.preview = $('#preview');
        this.control = $('#file');
        this.imageAdd = $('#image-add'); // Default Image Preview Hintergrund
        this.imageDelete = $('#delete-image'); // Delete Element
        this.imageError = $('#image-error');

        this.maxFileSizeMb = 7;

        this.imageDelete.on('click', this.deleteImage); // Setup Delete Function

        // Wenn Datei hochgeladen wird
        this.control.change(ImagePreview.fileChange);
    },

    deleteImage: function(){
        ImagePreview.preview.attr('src', '#').hide(); // Bild entfernen
        $(this).hide(); // Remove Button verstecken

        $('#image_deleted').val('true');
        ImagePreview.imageAdd.show();

        ImagePreview.clearFileInput();
    },

    clearFileInput: function(){
        this.control.replaceWith( this.control = this.control.clone( true ) );
    },

    isImage: function(){
        var ext = this.file['name'].split('.').pop().toLowerCase();
        return $.inArray(ext, ['gif','png','jpg','jpeg', 'bmp']) != -1;
    },

    fileSizeIsValid: function(){
        var fileSizeMb = Math.ceil(this.file.size / 1024 / 1024);
        return fileSizeMb <= this.maxFileSizeMb;
    },

    setImageDimensions: function(img){
        var maxWidth = 100; // Max width for the image
        var maxHeight = 100;    // Max height for the image
        var ratio = 0;  // Used for aspect ratio
        var width = img.width;    // Current image width
        var height = img.height;  // Current image height

        // Check if the current width is larger than the max
        if(width > maxWidth){
            ratio = maxWidth / width;   // get ratio for scaling image
            this.preview.css("width", maxWidth); // Set new width
            this.preview.css("height", height * ratio);  // Scale height based on ratio
            height = height * ratio;    // Reset height to match scaled image
            width = width * ratio;    // Reset width to match scaled image
        }

        // Check if current height is larger than max
        if(height > maxHeight){
            ratio = maxHeight / height; // get ratio for scaling image
            this.preview.css("height", maxHeight);   // Set new height
            this.preview.css("width", width * ratio);    // Scale width based on ratio
            width = width * ratio;    // Reset width to match scaled image
            height = height * ratio;    // Reset height to match scaled image
        }
    },

    fileChange: function(){
        // Support For File API
        if ( window.FileReader && window.File && window.FileList && window.Blob )
        {
            // alte Meldung entfernen
            if(ImagePreview.imageError.length > 0){
                ImagePreview.imageError.remove();
            }

            var input = this;
            ImagePreview.file = input.files[0];
            if (input.files && ImagePreview.file) {
                var reader = new FileReader();

                reader.onload = function (e) {

                    var isImg = ImagePreview.isImage();
                    var fileSizeValid = ImagePreview.fileSizeIsValid();

                    // Wenn Datei ein Bild ist und die maximale Dateigröße nicht überschritten wird
                    if(isImg && fileSizeValid) {
                        var img = new Image;

                        img.onload = function(){
                            ImagePreview.setImageDimensions(this);
                        };

                        img.src = reader.result;

                        ImagePreview.imageAdd.hide();
                        ImagePreview.preview.attr('src', e.target.result).show();
                        ImagePreview.imageDelete.show();
                    }else{
                        // File Input leeren
                        ImagePreview.clearFileInput();

                        // Message unter Bild anzeigen: File must be an image
                        if(!isImg) ImagePreview.preview.after('<div style="color: #ff0000" id="image-error">The file must be an image</div>');
                        if(!fileSizeValid) ImagePreview.preview.after('<div style="color: #ff0000" id="image-error">The file may not be greater than 7MB</div>');
                        ImagePreview.imageError = $('#image-error');
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    }
};