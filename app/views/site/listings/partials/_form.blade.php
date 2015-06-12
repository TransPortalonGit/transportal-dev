<?php if(! Session::has('errors') && Session::has('preuploadedFile')){
    Session::forget('preuploadedFile');
} ?>

    <div class="form-group required {{ $errors->first('is_offer')? 'has-error':''; }}">
          {{ Form::label('is_offer', 'Listing Type', ['class' => 'col-lg-2 control-label']) }}
          <div class="col-sm-4">
            <span class="radio-inline">
                {{ Form::radio('is_offer', '1', false, ['class' => $errors->first('is_offer', 'error')]) }} Offer
            </span>
            <span class="radio-inline">
                {{ Form::radio('is_offer', '0', false, ['class' => $errors->first('is_offer', 'error')]) }} Need
            </span>
            {{ $errors->first('is_offer', '<span class="label label-danger">:message</span>') }}
          </div>
    </div>

    <div class="form-group required {{ $errors->first('is_service')? 'has-error':''; }}">
        {{ Form::label('is_service', 'Type of Service', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-sm-5">
            <span class="radio-inline">
                {{ Form::radio('is_service', '0', false, ['class' => $errors->first('type-of-service', 'error')]) }} Material
            </span>
            <span class="radio-inline">
                {{ Form::radio('is_service', '1', false, ['class' => $errors->first('type-of-service', 'error')]) }} Service
            </span>
            {{ $errors->first('is_service', '<span class="label label-danger">:message</span>') }}
        </div>
    </div>

    <div class="form-group required {{ $errors->first('title')? 'has-error':''; }}">
        {{ Form::label('title', 'Title', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-sm-5">
            {{ Form::text('title', null, ['size' => '60', 'maxlength' => '60', 'class' => 'form-control input-sm']) }}
            <span class="info-box">(max. 60 characters)</span>
            {{ $errors->first('title', '<span class="label label-danger">:message</span>') }}
        </div>

    </div>

    <div class="form-group required {{ $errors->first('description')? 'has-error':''; }}">
        {{ Form::label('description', 'Description', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-sm-5">
            {{ Form::textarea('description', null, ['cols' => '62', 'rows' => '3', 'maxlength' => '1023', 'class' => 'form-control input-sm']) }}
            <span class="info-box">(max. 1023 characters)</span>
            {{ $errors->first('description', '<span class="label label-danger">:message</span>') }}
        </div>
    </div>

    <div class="form-group required {{ $errors->first('duration')? 'has-error':''; }}">
        {{ Form::label('duration', 'Duration', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-sm-5">
            {{ Form::select('duration', ['3' => '3 Days', '5' => '5 Days', '7' => '7 Days', '10' => '10 Days', '30' => '30 Days']) }}
            {{ $errors->first('duration', '<span class="label label-danger">:message</span>') }}
        </div>
    </div>

    <div class="form-group {{ $errors->first('file')? 'has-error':''; }}">
      {{ Form::label('file', 'Image:', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-sm-5">
            <?php
                $imgExists = false;
                if((isset($edit) || isset($relist)) && $imgExists = $listing->hasImage()){
                    $imgPath = $listing->getImagePath();
                }

                if(Session::has('preuploadedFile')){
                    $imgPath = '/' . Listing::$temporaryImagePath . Session::get('preuploadedFile');
                    $imgExists = true;
                }

                // Bild mit PHP in den Thumbnail Bereich skalieren
                if($imgExists){
                    ob_start();
                    $myImg = new MyImage(public_path() . $imgPath);
                    $i = $myImg->thumbnailbox(100, 100);
                    $imgSrc = 'data:' . $myImg->dataType . ';base64,' . base64_encode(ob_get_clean());
                }
            ?>
            <div id="delete-image" style="cursor:pointer; <?php if(!$imgExists) echo 'display: none;' ?>"><i class="fa fa-trash-o"></i> Remove</div>

            <div id="image-add" class="{{ $errors->first('file', 'error') }}" style="<?php if($imgExists) echo 'display: none;' ?>position: relative; border: 1px solid #000000; width: 80px; height: 80px; text-align: center;">
                <label for="file" style="width: 80px; height: 80px; cursor: pointer">
                    <div style="position: absolute; top: 10px; left: 12px">
                        <div>
                            <i class="fa fa-file-image-o fa-4x"></i>
                        </div>
                        <div style="margin-top: -20px; margin-right: -40px;">
                            <i class="fa fa-plus-square fa-2x" style="color: #34a26a; background-color: #ffffff"></i>
                        </div>
                    </div>
                </label>
            </div>

            <div>
                <img id="preview" style="<?php if(!$imgExists) echo 'display:none;' ?>" src="{{ ($imgExists) ? $imgSrc : '#' }}" alt="Image Preview">
            </div>

            {{ Form::label('file', 'Upload Image', ['class' => 'btn btn-default', 'style' => 'margin-top: 10px']) }}

            {{ Form::file('file', ['style' => 'display:none', 'class' => $errors->first('file', 'error')]) }}

            <input type="hidden" name="image_deleted" value="false" id="image_deleted">
        </div>
    </div>

    <div class="form-group {{ $errors->first('tags')? 'has-error':''; }}">
        {{ Form::label('tags', 'Tags', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-sm-5">
            @include('site.partials._tags-element')
        </div>
    </div>

    <div class="col-sm-7" style="text-align: right">
        {{ Form::submit($buttonText, ['class' => 'btn btn-success']) }}
    </div>


    <script>
        (function(){
            initializeCharacterCounter();
            ImagePreview.init();
        })();
    </script>
