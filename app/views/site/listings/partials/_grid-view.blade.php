<!-- Results -->
<div class="listings-grid clearfix">
    @foreach($results as $listing)
        <div>
            <a href="{{ route('fabboard.listings.show', $listing->id) }}">
                <div class="listings-grid-frame">
                    <?php
                        ob_start();
                        $myImg = new MyImage(public_path() . $listing->getImageToDisplay());
                        $i = $myImg->thumbnailbox(200, 150);
                        echo "<img src='data:" . $myImg->dataType . ";base64," . base64_encode(ob_get_clean())."'>";
                    ?>
                </div>
            </a>
            <a class="listings-grid-title" href="{{ route('fabboard.listings.show', $listing->id) }}">
                    {{{ (strlen($listing->title) > 25) ? substr($listing->title, 0, 24) . '...' : $listing->title }}}
            </a>
            <div class="clearfix listings-grid-caption">
                <div class="pull-left listing-grid-types">
                    {{ $listing->getType() }}
                    {{ $listing->getTypeOfService() }}
                </div>
                <div class="pull-right listings-grid-time">
                    {{ $listing->getTimeLeft() }}
                </div>
            </div>
        </div>
    @endforeach
</div>