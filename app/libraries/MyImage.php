<?php

class MyImage {

    public $image;
    public $imageType;
    public $dataType;
    public $imageHeight;
    public $imageWidth;

    public function __construct($filename) {
        $image_info = getimagesize($filename);

        $this->imageWidth = $image_info[0];
        $this->imageHeight = $image_info[1];
        $this->imageType = $image_info[2];

        if( $this->imageType == IMAGETYPE_JPEG ) {
            $this->image = imagecreatefromjpeg($filename);
            $this->dataType = 'image/jpeg';
        }elseif( $this->imageType == IMAGETYPE_GIF ) {
            $this->image = imagecreatefromgif($filename);
            $this->dataType = 'image/gif';
        }elseif( $this->imageType == IMAGETYPE_PNG ){
            $this->image = imagecreatefrompng($filename);
            $this->dataType = 'image/png';
        }
    }

    public function output() {
        if( $this->imageType == IMAGETYPE_JPEG ) {
            header('Content-Type: image/jpeg');
            imagejpeg($this->image);
        } elseif( $this->imageType == IMAGETYPE_GIF ) {
            header('Content-Type: image/gif');
            imagegif($this->image);
        } elseif( $this->imageType == IMAGETYPE_PNG ) {
            header('Content-Type: image/png');
            imagepng($this->image);
        }
    }

    public function thumbnailbox($box_w, $box_h) {
        // Bild der übergebenen Größe erstellen
        $new = imagecreatetruecolor($box_w, $box_h);
        if($new === false) {
            //creation failed -- probably not enough memory
            return null;
        }

        // Bild mit weiß füllen
        $fill = imagecolorallocate($new, 255, 255, 255);
        imagefill($new, 0, 0, $fill);

        // Resize Verhältnis ermitteln
        $hratio = $box_h / $this->imageHeight;
        $wratio = $box_w / $this->imageWidth;
        $ratio = min($hratio, $wratio);

        // übergebenes Bild ist kleiner als Thumbnail
        if($ratio > 1.0)
            $ratio = 1.0;

        // Größen ermitteln
        $sy = floor($this->imageHeight * $ratio);
        $sx = floor($this->imageWidth * $ratio);

        // margins ermitteln, Außenabstand wenn Bild kleiner als Thumbnail
        $m_y = floor(($box_h - $sy) / 2);
        $m_x = floor(($box_w - $sx) / 2);

        // neues Bild kopieren
        if(!imagecopyresampled($new, $this->image,
            $m_x, $m_y, //dest x, y (margins)
            0, 0, //src x, y (0,0 means top left)
            $sx, $sy,//dest w, h (resample to this size (computed above)
            $this->imageWidth, $this->imageHeight) //src w, h (the full size of the original)
        ) {
            //copy failed
            imagedestroy($new);
            return null;
        }

        // neues Bild zuweisen
        $this->image = $new;

        // Neues Bild ausgeben
        $this->output();
    }

    public function __destruct(){
        imagedestroy($this->image);
    }
} 