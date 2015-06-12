<!-- Results -->
<div class="all_projects" style="overflow:hidden">
    @foreach($results as $listing)

    <div class="thumbnail_shot col-xs-3 col-md-3">
        <a href="{{ route('fabboard.listings.show', $listing->id) }}">
            <img src="{{ $listing->getImageToDisplay() }}" alt="{{{ $listing->title }}}">
            <div id="img_ribbon"> {{{ $listing->title }}} </div>
        </a>
        <div class="caption_wrapper">
            <ul class="caption">
                <li>{{ $listing->getType() }}</li>
                <li>{{ $listing->getTypeOfService() }}</li>
                <li>{{ $listing->getTimeLeft() }}</li>
            </ul>
        </div>
    </div>

    @endforeach
</div>