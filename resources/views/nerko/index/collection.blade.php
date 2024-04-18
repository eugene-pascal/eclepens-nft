<div id="uni_collection" class="uni-collection uk-section uk-section-large@m uk-panel uk-overflow-hidden uk-padding-2xlarge-bottom@m swiper-parent">
    <div class="uk-container">
        <header class="uk-grid-xsmall uk-flex-center uk-flex-middle uk-text-center uk-child-width-auto@m uk-grid" data-uk-grid data-anime="opacity:[0, 1]; translateY:[-24, 0]; onview: true; delay: 200;">
            <div class="uk-panel">
                <h2 class="uk-h3 uk-h1@m">814 collections</h2>
            </div>
        </header>
        <div class="uk-panel uk-margin-top uk-margin-xlarge-top@m">
            <div class="uk-grid-xsmall uk-grid@m uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-grid" data-uk-grid="masonry: true;" data-anime="targets: > * > *; opacity:[0, 1]; translateY:[48, 0]; onview: -400; delay: anime.stagger(100);">
                @foreach($queryOnNft->orderBy('prior', 'desc')->limit(8)->get() as $indx=>$nft)
                    @if($nft->getMedia(\App\Models\Nft::_MEDIA_COLLECTION_NAME)->count()>0)
                        <div{!!(0 == $indx % 2 ? ' class="uk-padding-medium-top@m"' : '') !!}>
                            <div class="uni-artwork uk-card uk-card-xsmall uk-text-center uk-overflow-hidden uk-radius-medium uk-radius-large@m uk-box-shadow-xsmall dark:uk-background-white-5">
                                <div class="uni-artwork-featured-image uk-panel uk-flex-middle uk-flex-center">
                                    <div class="uk-panel uk-image-middle">
                                        <img src="{{$nft->getMedia(\App\Models\Nft::_MEDIA_COLLECTION_NAME)->first()->getUrl('thumb') }}" alt="" class="uk-radius-small uk-radius-medium@m" loading="lazy">
                                        <a href="#" class="uk-position-cover" aria-label=""></a>
                                    </div>
                                </div>

                                <div class="uni-artwork-content uk-panel uk-margin-small-top uk-margin-2xsmall-bottom uk-flex-column uk-flex-middle">
                                    <h2 class="uk-h6 uk-h5@m uk-margin-remove">
                                        <a class="uk-link-reset" href="#">{{ $nft->name }}</a>
                                    </h2>
                                    <span class="uk-text-meta uk-margin-xsmall-top uk-visible@m">By {{ $nft->author }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="uni-btn uk-margin-medium-top uk-margin-2xlarge-top@m uk-flex-center" data-anime="opacity:[0, 1]; translateY:[-24, 0]; onview: true; delay: 200;">
                <a href="#view_in_opensea" class="uk-button uk-button-small uk-button-large@m uk-button-gradient">
                    <span>View more in OPENSEA</span>
                    <i class="uk-icon-small unicon-arrow-right uk-text-bold"></i>
                </a>
            </div>
        </div>
    </div>
</div>