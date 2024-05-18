@extends('layout.nerko')
@section('title', __('NFT collection 814'))
@section('content')
    <!-- Hero start -->
    <div id="uni_hero" class="uni-hero uk-section uk-section-xlarge uk-padding-remove-bottom uk-panel">
        <div class="uk-position-top uk-position-z-index-negative uk-overflow-hidden uk-blend-overlay" data-uk-height-viewport="">
            <img class="uk-position-top-left uk-position-fixed uk-blur-large" style="left: -4%; top: -4%" width="500" src="{{ asset('skin/nerko/assets/images/gradient-circle.svg') }}" alt="Circle">
            <img class="uk-position-bottom-right uk-position-fixed uk-blur-large" style="right: -4%; bottom: -4%" width="500" src="{{ asset('skin/nerko/assets/images/gradient-circle.svg') }}" alt="Circle">
        </div>
        <div class="uk-position-top uk-position-z-index-negative" data-uk-height-viewport="">
            <div class="uk-position-cover uk-background-cover uk-opacity-10 dark:uk-hidden" data-src="{{ asset('skin/nerko/assets/images/gradient-01.png') }}" data-uk-img></div>
            <div class="uk-position-cover uk-background-cover uk-opacity-20 uk-hidden dark:uk-visible" data-src="{{ asset('skin/nerko/assets/images/gradient-01.png') }}" data-uk-img></div>
        </div>
        <div class="uk-panel uk-position-z-index">
            <div class="uk-container">
                <div class="uk-panel">
                    <div class="uk-grid uk-grid-2xlarge uk-flex-middle uk-flex-between" data-uk-grid data-uk-height-viewport="offset-top: true; offset-bottom: 20;">
                        <div class="uk-width-5-12@m">
                            <div class="uk-panel uk-position-z-index uk-text-center uk-text-left@m" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
                                <img class="uk-position-top-left" width="44" src="{{ asset('skin/nerko/assets/images/objects/ethereum-01.png') }}" alt="object" style="top: -20%; left: 50%" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 400;">
                                <img class="uk-position-left" width="16" src="{{ asset('skin/nerko/assets/images/objects/circle-01.png') }}" alt="object" style="top: 16%; left: -16%" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 420;">
                                <img class="uk-position-bottom-left" width="24" src="{{ asset('skin/nerko/assets/images/objects/circle-03.png') }}" alt="object" style="bottom: -16%; left: 16%" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 440;">
                                <h2 class="uk-h2 uk-heading-d3@m uk-margin-small uk-margin@m">Unique NFT of Eclépens Winery</h2>
                                <p class="uk-text-xlarge uk-width-xlarge@m uk-text-muted">Discover our NFT collections, ownership of which grants you exclusive benefits</p>
                                <a href="#" class="uk-button uk-button-medium@m uk-button-gradient uk-margin-small-top">
                                    <span>View in Magic Eden</span>
                                    <i class="uk-icon-small unicon-arrow-right uk-text-bold"></i>
                                </a>
                            </div>
                        </div>
                        <div class="uk-width-6-12@m uk-flex-center">
                            <div class="uk-panel" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 200;">
                                <img class="uk-position-left uk-text-primary" width="44" src="{{ asset('skin/nerko/assets/images/objects/bitcoin-01.png') }}" alt="object" style="top: 75%; left: -20%" data-uk-svg="" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 460;">
                                <img class="uk-position-right" width="28" src="{{ asset('skin/nerko/assets/images/objects/x.png') }}" alt="object" style="top: -4%; right: 16%" data-uk-svg="" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 480;">
                                <img class="uk-position-right uk-opacity-10" width="300" src="{{ asset('skin/nerko/assets/images/blob-dashed.svg') }}" alt="Blog dashed" style="top: -10%; right: 16%; fill: transparent" data-uk-svg="">
                                <svg style="top: -20%" class="uk-position-right uk-opacity-30" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#F796FF" d="M47.5,-67.2C55.9,-59.3,53.2,-37.9,56.7,-20.1C60.2,-2.3,69.9,11.8,70.8,27.3C71.7,42.9,63.8,59.9,50.6,64.4C37.3,68.9,18.6,60.8,-0.3,61.2C-19.3,61.6,-38.6,70.7,-53.5,66.7C-68.4,62.8,-78.9,45.9,-78.8,29.5C-78.7,13.2,-67.9,-2.7,-59.8,-16.8C-51.6,-31,-46,-43.3,-36.5,-50.9C-27,-58.4,-13.5,-61.1,3,-65.2C19.6,-69.4,39.1,-75.1,47.5,-67.2Z" transform="translate(100 100)">
                                </svg>
                                <div class="uk-grid uk-grid-xsmall uk-child-width-1-2" data-uk-grid="masonry: true;">
                                    @foreach($queryOnNft->orderBy('prior', 'desc')->limit(2)->get() as $indx=>$nft)
                                        @if($nft->getMedia(\App\Models\Nft::_MEDIA_COLLECTION_NAME)->count()>0)
                                        <div{!!(1 == $indx ? ' class="uk-margin-large-top"' : '') !!}>
                                            <div class="uni-item uk-card uk-overflow-hidden uk-radius uk-radius-large@m uk-box-shadow-hover-medium uk-visible-toggle uk-transition-toggle uk-box-shadow-medium uk-background-white dark:uk-background-white-5">
                                                <div class="uni-item-featured-image uk-panel uk-flex-middle uk-flex-center">
                                                    <div class="uk-panel uk-image-middle">
                                                        <img src="{{$nft->getMedia(\App\Models\Nft::_MEDIA_COLLECTION_NAME)->first()->getUrl('thumb') }}" alt="" class="uk-radius-small uk-radius-large@m">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                <a class="uni-circle-text uk-background-white dark:uk-background-gray-80 uk-box-shadow-large uk-visible@m" href="#">
                                    <svg class="uni-circle-text-path uk-text-secondary uni-animation-spin" viewBox="0 0 100 100" width="120" height="120">
                                        <defs>
                                            <path id="circle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0">
                                        </defs>
                                        <text font-size="11.75">
                                            <textPath xlink:href="#circle">view the NFT in Magic Eden • SOLANA •</textPath>
                                        </text>
                                    </svg>
                                    <i class="uk-position-center uk-text-secondary uk-icon-medium@m unicon-arrow-up-right uk-text-bold"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero end -->

    <!-- brands start -->
{{--    @include('nerko.index.brands', [])--}}
    <!-- brands end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 100;">

    <!-- how to mint start -->
    @include('nerko.index.how_to_mint', [])
    <!-- how to mint end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- about start -->
    @include('nerko.index.about', [])
    <!-- about end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- collection start -->
    @include('nerko.index.collection', [])
    <!-- collection end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- F.A.Q. start -->
    @include('nerko.index.faq', [])
    <!-- F.A.Q. end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- cta start -->
    @include('nerko.index.cta', [])

    <!-- cta end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
@endsection