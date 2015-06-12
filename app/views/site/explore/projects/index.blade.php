@extends('layouts.master')

@section('head')

    {{ HTML::style('css/listings.css'); }}
    {{ HTML::script('js/listings.js'); }}

    @include('site/partials/_tags-head')

@stop

@section('content')

<div id="browse-header" style="margin: 30px 0px 20px">
    <h2><a href="{{ Request::url() }}">Projects</a></h2>
</div>

<div style="float:left; margin-right: 10px; width: 180px; height: 500px;" >
    <div class="panel panel-default">
        <div class="panel-heading">Filter Options</div>
        <div class="panel-body">
            {{ Form::open(['role' => 'form', 'method' => 'get']) }}

            <div class="form-group">
            {{ Form::label('listing-type', 'Listing-Type') }}
            {{ Form::select('listing-type', ['all' => 'All', 'need' => 'Only Needs', 'offer' => 'Only Offers'], Input::old('listing-type'), ['class' => 'auto-submit form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('type-of-service', 'Type of Service') }}
            {{ Form::select('type-of-service', ['all' => 'All', 'material' => 'Only Material', 'service' => 'Only Service'], Input::old('type-of-service'), ['class' => 'auto-submit form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('sorting', 'Sorting') }}
            {{ Form::select('sorting', ['ending' => 'Ending soonest', 'new' => 'Newly listed'], Input::old('sorting'), ['class' => 'auto-submit form-control']) }}
            </div>

            <div class="form-group">
                {{ Form::label('tags', 'Tags') }} <br>
                @include('site/partials/_tags-element')
            </div>

            <?php $selectedListingTags = $tagsselect['selected'] ?>

            @if(count($selectedListingTags) > 0)
                <?php
                    $selectedTags = Tag::whereIn('id', $selectedListingTags)->with('getParent')->get();

                    $tags = array();
                    $parentTags = array();

                    foreach($selectedTags as $tag){
                        $parentTagId = $tag->getParent->id;

                        // Parent Id und Tag Name in Tag-Array schreiben
                        $tags[$parentTagId][$tag->id] = $tag->tag;

                        // Wenn es den Parent noch nicht im Parenttags-Array gibt
                        if(!isset($parentTags[$parentTagId])){
                            // Parent Id und Parent Name in Parenttags-Array schreiben
                            $parentTags[$parentTagId] = $tag->getParent->tag;
                        }
                    }
                ?>

                @foreach($parentTags as $parentId => $parentName)
                    <div style="margin-bottom: 5px">
                        {{ $parentName }}
                    </div>

                    <div style="margin-bottom: 10px">
                        @foreach($tags[$parentId] as $tagId => $tagName)
                        <?php
                            $arr = $_GET;
                            if (($key = array_search($tagId, $arr['tags'])) !== false) unset($arr['tags'][$key]);
                            $queryString = http_build_query($arr);
                        ?>

                        <span style="margin-bottom: 5px" class="btn btn-info btn-xs">
                            <a style="color: #ffffff" href="{{ Request::url() . '?' . $queryString }}">
                                <i class="fa fa-times"></i>
                                {{ $tagName }}
                            </a>
                        </span>
                        @endforeach
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>

<div style="margin-left: 200px; width: 815px">
        <!-- Searchbar und Button -->
        <div class="form-group form-inline" style="height: 40px;">
            {{ Form::input('search', 'q', Input::old('q'), ['placeholder' => 'Search Projects...', 'class' => 'form-control', 'style' => 'width: 500px; height: 40px']) }}
            {{ Form::submit('Search', ['class' => 'form-control  btn btn-success', 'style' => 'width: 100px; height: 40px']) }}
            {{ Form::close() }}
        </div>

    <div class="panel panel-default">
        <div class="panel-body" style="padding-right: 0">
                @if ($listings->count())
                    <div style="margin-bottom: 10px">
                        <?php
                            $resultText =   $listings->getFrom() . '-' . $listings->getTo();
                            $resultText .=  '<span style="padding: 0 5px"> of </span>' . $listings->getTotal();
                            $resultText .=  ($listings->getTotal() == 1) ? ' Result' : ' Results';

                            if(Input::old('q') != null){
                                $resultText .= ' <span style="padding: 0 5px"> for </span> "' . htmlspecialchars(Input::old('q')) . '"';
                            }

                            echo $resultText;
                        ?>
                        <hr style="margin-right: 20px">
                    </div>

                    @include('site/listings/partials/_grid-view', ['results' => $listings])

                    <div style="text-align: center">
                        {{ $listings->appends(Input::except(array('page')))->links() }}
                    </div>

                @else
                    <p>No Listings</p>
                @endif
        </div>
    </div>

</div>

<div class="clearfix"></div>


<script>
    (function(){
        setAutoSubmit();
    })();
</script>
@stop