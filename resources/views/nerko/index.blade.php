@extends('layout.nerko')
@section('title', __('NFT'))
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
                                <h2 class="uk-h2 uk-heading-d3@m uk-margin-small uk-margin@m">Supercharge your NFT Adventure</h2>
                                <p class="uk-text-xlarge uk-width-xlarge@m uk-text-muted">Find the right NFT collections to buy within the platform.</p>
                                <a href="#" class="uk-button uk-button-medium@m uk-button-gradient uk-margin-small-top">
                                    <span>View in OPENSEA</span>
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
                                <a class="uni-circle-text uk-background-white dark:uk-background-gray-80 uk-box-shadow-large uk-visible@m" href="#view_in_opensea">
                                    <svg class="uni-circle-text-path uk-text-secondary uni-animation-spin" viewBox="0 0 100 100" width="120" height="120">
                                        <defs>
                                            <path id="circle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0">
                                        </defs>
                                        <text font-size="11.75">
                                            <textPath xlink:href="#circle">view in opensea • view in opensea •</textPath>
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
    <div class="uni-brands uk-padding-3xlarge-top uk-padding-medium-bottom uk-padding-remove-top@m uk-padding-xlarge-bottom@m uk-panel uk-overflow-hidden" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 300;">
        <div class="uk-container uk-container-small">
            <div class="uk-panel uk-text-center dark:uk-text-white">
                <header class="uk-panel uk-flex-center uk-flex-middle uk-text-center">
                    <span class="uk-text-overline uk-text-bold uk-text-muted">Powered by amazing investors:</span>
                </header>
                <div class="uk-grid uk-grid-xlarge@m uk-child-width-1-2 uk-child-width-expand@m uk-flex-middle uk-flex-center uk-grid uk-margin-medium-top" data-uk-grid>
                    <div><img class="uk-width-xsmall" src="{{ asset('skin/nerko/assets/images/wallets/wallet-01.svg') }}" alt="Metamask" data-uk-svg></div>
                    <div><img class="uk-width-xsmall" src="{{ asset('skin/nerko/assets/images/wallets/wallet-02.svg') }}" alt="BitGo" data-uk-svg></div>
                    <div><img class="uk-width-xsmall" src="{{ asset('skin/nerko/assets/images/wallets/wallet-03.svg') }}" alt="Coinbase" data-uk-svg></div>
                    <div><img class="uk-width-xsmall" src="{{ asset('skin/nerko/assets/images/wallets/wallet-04.svg') }}" alt="Trust Wallet" data-uk-svg></div>
                    <div><img class="uk-width-xsmall" src="{{ asset('skin/nerko/assets/images/wallets/wallet-05.svg') }}" alt="Exodus" data-uk-svg></div>
                </div>
            </div>
        </div>
    </div>

    <!-- brands end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 100;">

    <!-- how to mint start -->
    <div id="uni_minting" class="uni-minting uk-section uk-section-xlarge@m uk-panel">
        <div class="uk-container uk-container-small">
            <header class="uk-grid-xsmall uk-flex-center uk-flex-middle uk-grid" data-uk-grid data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 200;">
                <div class="uk-panel uk-text-center">
                    <h2 class="uk-h3 uk-h1@m">How to mint</h2>
                </div>
            </header>
            <div class="uk-panel uk-margin-medium-top uk-margin-2xlarge-top@m" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 300;">
                <img class="uk-position-top-left uk-text-secondary" width="16" src="{{ asset('skin/nerko/assets/images/objects/circle-01.png') }}" alt="Object" style="top: -16%; left: 8%">
                <img class="uk-position-bottom-right uk-text-primary" width="24" src="{{ asset('skin/nerko/assets/images/objects/circle-02.png') }}" alt="Object" style="bottom: 16%; right: -8%">
                <img class="uk-position-bottom-left uk-text-muted" width="28" src="{{ asset('skin/nerko/assets/images/objects/x.png') }}" alt="Object" style="bottom: 16%; left: -8%">
                <div class="uk-grid uk-child-width-1-2@s uk-grid-match" data-uk-grid="" data-anime="targets: > *; opacity:[0, 1]; translateY:[24, 0]; onview: -250; delay: anime.stagger(100);">
                    <div>
                        <div class="uk-panel uk-card uk-card-small uk-padding-large-horizontal uk-radius-medium uk-radius-large@m uk-box-shadow-xsmall dark:uk-background-white-5">
                            <div class="uk-grid uk-grid-medium@m" data-uk-grid="">
                                <div class="uk-width-1-3 uk-width-1-4@m">
                                    <img src="{{ asset('skin/nerko/assets/images/icon-01.png') }}" alt="Icon">
                                </div>
                                <div class="uk-panel uk-width-expand">
                                    <h3 class="uk-h5 uk-h4@m">Connect your wallet</h3>
                                    <p>Use Trust Wallet, Metamask or any wallet to connect to the app.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-panel uk-card uk-card-small uk-padding-large-horizontal uk-radius-medium uk-radius-large@m uk-box-shadow-xsmall dark:uk-background-white-5">
                            <div class="uk-grid uk-grid-medium@m" data-uk-grid="">
                                <div class="uk-width-1-3 uk-width-1-4@m">
                                    <img src="{{ asset('skin/nerko/assets/images/icon-02.png') }}" alt="Icon">
                                    <div hidden class="uk-card uk-card-xsmall uk-radius-medium uk-background-gradient uk-flex-middle uk-flex-center uk-margin-medium-bottom@m">
                                        <i class="uk-icon-medium uk-icon-medium@m unicon-select-window"></i>
                                    </div>
                                </div>
                                <div class="uk-panel uk-width-expand">
                                    <h3 class="uk-h5 uk-h4@m">Select your quantity</h3>
                                    <p>Upload your NFTs and set a title, description and price.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-panel uk-card uk-card-small uk-padding-large-horizontal uk-radius-medium uk-radius-large@m uk-box-shadow-xsmall dark:uk-background-white-5">
                            <div class="uk-grid uk-grid-medium@m" data-uk-grid="">
                                <div class="uk-width-1-3 uk-width-1-4@m">
                                    <img src="{{ asset('skin/nerko/assets/images/icon-03.png') }}" alt="Icon">
                                    <div hidden class="uk-card uk-card-xsmall uk-radius-medium uk-background-gradient uk-flex-middle uk-flex-center uk-margin-medium-bottom@m">
                                        <i class="uk-icon-medium uk-icon-medium@m unicon-select-window"></i>
                                    </div>
                                </div>
                                <div class="uk-panel uk-width-expand">
                                    <h3 class="uk-h5 uk-h4@m">Confirm transaction</h3>
                                    <p>Earn ETH and BIT for all your NFTs that you sell on our marketplace.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-panel uk-card uk-card-small uk-padding-large-horizontal uk-radius-medium uk-radius-large@m uk-box-shadow-xsmall dark:uk-background-white-5">
                            <div class="uk-grid uk-grid-medium@m" data-uk-grid="">
                                <div class="uk-width-1-3 uk-width-1-4@m">
                                    <img src="{{ asset('skin/nerko/assets/images/icon-04.png') }}" alt="Icon">
                                    <div hidden class="uk-card uk-card-xsmall uk-radius-medium uk-background-gradient uk-flex-middle uk-flex-center uk-margin-medium-bottom@m">
                                        <i class="uk-icon-medium uk-icon-medium@m unicon-select-window"></i>
                                    </div>
                                </div>
                                <div class="uk-panel uk-width-expand">
                                    <h3 class="uk-h5 uk-h4@m">Receive your NFTs</h3>
                                    <p>Latin professor at Hampden-Sydney College in Virginia.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- how to mint end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- about start -->
    <div id="uni_about" class="uni-about uk-section uk-section-xlarge@m uk-panel">
        <div class="uk-container">
            <header class="uk-grid-xsmall uk-flex-center uk-flex-middle uk-grid" data-uk-grid data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
                <div class="uk-panel uk-text-center">
                    <h2 class="uk-h3 uk-h1@m">About the platform</h2>
                </div>
            </header>
            <div class="uk-panel uk-margin-medium-top uk-margin-2xlarge-top@m">
                <div class="uk-grid uk-grid-2xlarge uk-grid-3xlarge@m uk-child-width-1-1" data-uk-grid="">
                    <div>
                        <div class="uk-panel">
                            <div class="uk-grid uk-grid-3xlarge@m uk-flex-middle uk-child-width-1-2@m" data-uk-grid="">
                                <div>
                                    <div class="uk-panel uk-image-middle uk-overflow-hidden uk-radius uk-radius-large@m" data-anime="opacity:[0, 1]; translateX:[-24, 0]; onview: -250; delay: 200;">
                                        <img src="{{ asset('skin/nerko/assets/images/features-03.png') }}" alt="Create your own NFT">
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-panel" data-anime="opacity:[0, 1]; translateX:[24, 0]; onview: -250; delay: 300;">
                                        <span class="uk-text-overline uk-text-gradient">Create and Invest</span>
                                        <h3 class="uk-h3 uk-h1@m">Create your own NFT</h3>
                                        <p class="uk-text-large@m">Multiple Chains, One Home. Stack up all your NFTs from across blockchains.</p>
                                        <div class="uk-grid uk-grid-large@m uk-grid-match uk-child-width-1-2 uk-margin-large-top@m" data-uk-grid="">
                                            <div>
                                                <div class="uk-panel">
                                                    <h5 class="uk-h4 uk-h2@m uk-margin-xsmall">4,500+</h5>
                                                    <span class="uk-text-small@m"
                                                    >Collections Indexed <br>
                                                                every 5mins.</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-panel">
                                                    <h5 class="uk-h4 uk-h2@m uk-margin-xsmall">2.5x</h5>
                                                    <span class="uk-text-small@m">Difference in Floor & Estimated Value</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-panel">
                            <div class="uk-grid uk-grid-3xlarge@m uk-flex-middle uk-child-width-1-2@m" data-uk-grid="">
                                <div>
                                    <div class="uk-panel uk-image-middle uk-overflow-hidden uk-radius uk-radius-large@m" data-anime="opacity:[0, 1]; translateX:[24, 0]; onview: -250; delay: 300;">
                                        <img src="{{ asset('skin/nerko/assets/images/features-02.png') }}" alt="Create your own NFT">
                                    </div>
                                </div>
                                <div class="uk-flex-first@m">
                                    <div class="uk-panel" data-anime="opacity:[0, 1]; translateX:[-24, 0]; onview: -250; delay: 400;">
                                        <span class="uk-text-overline uk-text-gradient">Sync and Track</span>
                                        <h3 class="uk-h3 uk-h1@m">Multiple Chains, One Home</h3>
                                        <p class="uk-text-large@m">We make it easy to discover, Invest and manage all your NFTs at one place, looked up one of the more obscure.Find the right NFT collections to buy within the platform.</p>
                                        <div class="uk-grid uk-grid-large@m uk-grid-match uk-child-width-1-2@m uk-margin-medium-top uk-margin-large-top@m" data-uk-grid="">
                                            <div>
                                                <div class="uk-panel">
                                                    <div class="uk-grid uk-grid-xsmall uk-grid-small@m" data-uk-grid="">
                                                        <div>
                                                            <div class="uk-card uk-card-xsmall uk-radius-medium uk-radius-large@m uk-background-gradient uk-flex-middle uk-flex-center">
                                                                <i class="uk-icon-small uk-icon-medium@m unicon-select-02 uk-text-white"></i>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <span class="uk-text-small@m">Collections Indexed <br>every 5mins.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-panel">
                                                    <div class="uk-grid uk-grid-xsmall uk-grid-small@m" data-uk-grid="">
                                                        <div>
                                                            <div class="uk-card uk-card-xsmall uk-radius-medium uk-radius-large@m uk-background-gradient uk-flex-middle uk-flex-center">
                                                                <i class="uk-icon-small uk-icon-medium@m unicon-select-window uk-text-white"></i>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-expand">
                                                            <span class="uk-text-small@m">Difference in Floor & <br>Estimated Value</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- collection start -->
    <div id="uni_collection" class="uni-collection uk-section uk-section-large@m uk-panel uk-overflow-hidden uk-padding-2xlarge-bottom@m swiper-parent">
        <div class="uk-container">
            <header class="uk-grid-xsmall uk-flex-center uk-flex-middle uk-text-center uk-child-width-auto@m uk-grid" data-uk-grid data-anime="opacity:[0, 1]; translateY:[-24, 0]; onview: true; delay: 200;">
                <div class="uk-panel">
                    <h2 class="uk-h3 uk-h1@m">Latest artworks</h2>
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

    <!-- collection end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- faq start -->
    <div id="uni_faq" class="uni-faq uk-section uk-section-large@m uk-panel uk-overflow-hidden uk-padding-2xlarge-bottom@m">
        <div class="uk-container">
            <header class="uk-grid-xsmall uk-flex-center uk-flex-middle uk-text-center uk-child-width-auto@m uk-grid" data-uk-grid data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
                <div class="uk-panel">
                    <h2 class="uk-h3 uk-h1@m">FAQ</h2>
                </div>
            </header>
            <div class="uk-panel uk-margin-medium-top uk-margin-2xlarge-top@m">
                <ul class="uk-card uk-card-small uk-card-large@m uk-radius uk-radius-large@m uk-width-2xlarge@m uk-margin-auto uk-box-shadow-xsmall dark:uk-background-white-5" data-uk-accordion="collapsible: false" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
                    <li>
                        <a class="uk-accordion-title uk-h5@m" href="#">What is Nerko's NFT Collection?</a>
                        <div class="uk-accordion-content uk-padding-small-bottom">
                            <p class="uk-text-small uk-text-large@m uk-text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
                            <p class="uk-text-small uk-text-large@m uk-text-muted">Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
                        </div>
                    </li>
                    <li>
                        <a class="uk-accordion-title uk-h5@m" href="#">How we can buy and invest NFT?</a>
                        <div class="uk-accordion-content uk-padding-small-bottom">
                            <p class="uk-text-small uk-text-large@m uk-text-muted">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
                        </div>
                    </li>
                    <li>
                        <a class="uk-accordion-title uk-h5@m" href="#">Why we should choose Nerko's NFT?</a>
                        <div class="uk-accordion-content uk-padding-small-bottom">
                            <p class="uk-text-small uk-text-large@m uk-text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
                        </div>
                    </li>
                    <li>
                        <a class="uk-accordion-title uk-h5@m" href="#">Where we can buy and sell NFts?</a>
                        <div class="uk-accordion-content uk-padding-small-bottom">
                            <p class="uk-text-small uk-text-large@m uk-text-muted">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
                        </div>
                    </li>
                    <li>
                        <a class="uk-accordion-title uk-h5@m" href="#">How secure is this token?</a>
                        <div class="uk-accordion-content uk-padding-small-bottom">
                            <p class="uk-text-small uk-text-large@m uk-text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
                        </div>
                    </li>
                    <li>
                        <a class="uk-accordion-title uk-h5@m" href="#">What is your contract address?</a>
                        <div class="uk-accordion-content uk-padding-small-bottom">
                            <p class="uk-text-small uk-text-large@m uk-text-muted">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- faq end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- cta start -->
    <div class="uni-cta uk-section uk-section-2xlarge@m uk-panel uk-overflow-hidden">
        <img class="uk-cover uk-opacity-10" data-uk-cover src="{{ asset('skin/nerko/assets/images/collection-cta.png') }}" alt="arrow">
        <div class="uk-container">
            <div class="uk-card uk-flex-center uk-text-center">
                <div class="uk-panel uk-width-xlarge@m uk-position-z-index" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
                    <img class="uk-position-top-left" width="24" src="{{ asset('skin/nerko/assets/images/objects/circle-01.png') }}" alt="Object" style="top: 0%; left: -16%">
                    <img class="uk-position-bottom-right" width="24" src="{{ asset('skin/nerko/assets/images/objects/x.png') }}" alt="Object" style="bottom: 16%; right: -8%">
                    <img class="uk-position-top-right" width="40" src="{{ asset('skin/nerko/assets/images/objects/ethereum-02.png') }}" alt="Object" style="top: 0%; right: -16%">
                    <img class="uk-position-bottom-left" width="48" src="{{ asset('skin/nerko/assets/images/objects/bitcoin-01.png') }}" alt="Object" style="bottom: 16%; left: -8%">
                    <h2 class="uk-h3 uk-heading-d1@m">Let's start minting</h2>
                    <a href="#" class="uk-button uk-button-small uk-button-large@m uk-button-gradient uk-margin-small-top uk-margin-large-top@m">Join community</a>
                </div>
            </div>
        </div>
    </div>

    <!-- cta end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
@endsection