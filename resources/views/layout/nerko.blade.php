<!DOCTYPE html>
<html lang="zxx" class="uk-background-white dark:uk-background-gray-100 dark:uk-text-gray-20 uk-dark__">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $page_title ?? '') | {{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="theme-color" content="#741ff5">

    <!-- preload head styles -->
    <link rel="preload" href="{{ asset('skin/nerko/assets/fonts/brand-icons/brand-icons.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('skin/nerko/assets/fonts/unicons/Unicons.woff?lkolxg') }}" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@8.3.2/swiper-bundle.min.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/uikit@3.15.1/dist/css/uikit.min.css" as="style">

    <!-- preload footer scripts -->
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/libs/uikit.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/uikit-components.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/libs/jquery.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/libs/swiper-bundle.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/libs/feather.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/libs/typed.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/libs/anime.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/app.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/helpers/data-attr-helper.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/helpers/swiper-helper.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/helpers/typed-helper.js') }}" as="script">
    <link rel="preload" href="{{ asset('skin/nerko/assets/js/helpers/anime-helper.js') }}" as="script">

    @livewireStyles

    <!-- include styles -->
    <script src="{{ asset('skin/nerko/assets/js/app-head.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('skin/nerko/assets/css/theme/main.min.css') }}">

    <!-- include scripts -->
    <script src="{{ asset('skin/nerko/assets/js/libs/uikit.min.js') }}"></script>
    <script src="{{ asset('skin/nerko/assets/js/uikit-components.js') }}"></script>

    {{-- Includable CSS --}}
    @yield('styles')
</head>
<body class="uni-body">

<!-- Dark/Light toggle -->
<div class="darkmode-trigger uk-position-bottom-right uk-position-small uk-position-fixed uk-box-shadow-large uk-radius-circle" data-darkmode-toggle="">
    <label class="switch">
        <span class="sr-only">Dark mode toggle</span>
        <input type="checkbox">
        <span class="slider"></span>
    </label>
</div>

<!-- Menu modal -->
<div id="uni_mobile_menu" class="uni-mobile-menu uk-offcanvas" data-uk-offcanvas="mode: push; overlay: true; flip: true; selPanel: .uk-offcanvas-bar-panel;">
    <div class="uk-offcanvas-bar-panel uk-panel dark:uk-background-gray-100">
        <div class="uni-mobile-menu-wrap uk-flex-column uk-flex-between" data-uk-height-viewport="offset-bottom: true;">
            <div class="uni-mobile-menu-content">
                <header class="uk-card uk-card-2xsmall uk-flex-middle uk-flex-between">
                    <div class="uk-flex-1">
                        <button aria-label="Close Menu" class="uk-offcanvas-close uk-button uk-button-small uk-button-icon uk-button-default uk-button-outline uk-radius-circle" type="button">
                            <i class="uk-icon-small" data-feather="arrow-left"></i>
                        </button>
                    </div>
                    <div>
                        <h5 class="uk-h5 uk-text-uppercase uk-margin-remove">Navigation</h5>
                    </div>
                    <div class="uk-flex-1"></div>
                </header>
                <hr class="uk-margin-remove">
                <div class="uk-card uk-card-small">
                    <div class="uk-panel">
                        <ul class="uk-nav uk-nav-default">
                            <li class="uk-nav-header"><a href="{{ route('home') }}#uni_minting">Minting</a></li>
                            <li class="uk-nav-header"><a href="{{ route('home') }}#uni_about">About</a></li>
                            <li class="uk-nav-header"><a href="{{ route('home') }}#uni_collection">Collection</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Connect wallet modal -->
@if (false)
<div id="uni_connect_wallet" class="uk-modal-full" data-uk-modal>
    <div class="uk-modal-dialog">
        <div class="uk-position-top uk-position-z-index-negative" data-uk-height-viewport="">
            <div class="uk-position-cover uk-background-cover uk-opacity-10 dark:uk-hidden" data-src="{{ asset('skin/nerko/assets/images/gradient-01.png') }}" data-uk-img></div>
            <div class="uk-position-cover uk-background-cover uk-opacity-20 uk-hidden dark:uk-visible" data-src="{{ asset('skin/nerko/assets/images/gradient-01.png') }}" data-uk-img></div>
        </div>
        <button class="uk-modal-close-full uk-close-large uk-position-small" type="button" data-uk-close></button>
        <div class="uk-container">
            <div class="uk-grid uk-flex-center uk-flex-middle uk-child-width-1-2@m uk-section" data-uk-grid data-uk-height-viewport>
                <div>
                    <div class="uk-panel uk-text-center">
                        <h2 class="uk-h5 uk-h3@s uk-h2@l uk-margin-remove">Connect your wallet</h2>
                        <div class="uk-grid uk-grid-xsmall uk-grid-small@m uk-child-width-1-2@m uk-margin-medium-top uk-margin-large-top@m" data-uk-grid="">
                            <div>
                                <div class="uk-panel uk-card uk-card-small uk-card-medium@m uk-card-border uk-radius-medium uk-radius-large@m uk-box-shadow-hover-small hover:uk-border-primary">
                                    <a href="#metamask" class="uk-position-cover"></a>
                                    <img src="{{ asset('skin/nerko/assets/images/icon-metamask.svg') }}" alt="metamask">
                                    <h4 class="uk-text-bold uk-h5@m uk-margin-small-top uk-margin-medium-top@m">Metamask</h4>
                                </div>
                            </div>
                            <div>
                                <div class="uk-panel uk-card uk-card-small uk-card-medium@m uk-card-border uk-radius-medium uk-radius-large@m uk-box-shadow-hover-small hover:uk-border-primary">
                                    <a href="#bitgo" class="uk-position-cover"></a>
                                    <img src="{{ asset('skin/nerko/assets/images/icon-bitgo.svg') }}" alt="bitgo">
                                    <h4 class="uk-text-bold uk-h5@m uk-margin-small-top uk-margin-medium-top@m">BitGo</h4>
                                </div>
                            </div>
                            <div>
                                <div class="uk-panel uk-card uk-card-small uk-card-medium@m uk-card-border uk-radius-medium uk-radius-large@m uk-box-shadow-hover-small hover:uk-border-primary">
                                    <a href="#trustwallet" class="uk-position-cover"></a>
                                    <img src="{{ asset('skin/nerko/assets/images/icon-trustwallet.svg') }}" alt="trustwallet">
                                    <h4 class="uk-text-bold uk-h5@m uk-margin-small-top uk-margin-medium-top@m">Trust Wallet</h4>
                                </div>
                            </div>
                            <div>
                                <div class="uk-panel uk-card uk-card-small uk-card-medium@m uk-card-border uk-radius-medium uk-radius-large@m uk-box-shadow-hover-small hover:uk-border-primary">
                                    <a href="#coinbase" class="uk-position-cover"></a>
                                    <img src="{{ asset('skin/nerko/assets/images/icon-coinbase.svg') }}" alt="coinbase">
                                    <h4 class="uk-text-bold uk-h5@m uk-margin-small-top uk-margin-medium-top@m">Coinbase</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Wrapper start -->
<div class="wrap">

    <!-- Header start -->
    <header class="uni-header {!!(Route::is('home') ? 'uk-position-top' : '' ) !!}">
        <div class="uni-header-navbar" data-uk-sticky="top: 70; show-on-up: false; animation: uk-animation-slide-top" data-anime="opacity:[0, 1]; translateY:[-24, 0]; onview: true; delay: 0;">
            <div class="uk-container">
                <nav class="uk-navbar uk-navbar-container uk-navbar-transparent" data-uk-navbar>
                    <div class="uk-navbar-top">
                        <div class="uk-navbar-left">
                            <a class="uk-logo uk-navbar-item uk-h4 uk-h3@m uk-margin-remove" href="/">
                                <img class="uk-visible dark:uk-hidden" width="170" src="{{ asset('skin/nerko/assets/images/logo-eclepens-noir.png') }}" alt="" loading="lazy">
                                <img class="uk-hidden dark:uk-visible" width="170" src="{{ asset('skin/nerko/assets/images/logo-eclepens-blanc.png') }}" alt="" loading="lazy"> </a>
                        </div>

                        <div class="uk-navbar-right uk-flex-1 uk-flex-right">
                            <ul class="uk-navbar-nav dark:uk-text-gray-10 uk-visible@m" data-uk-scrollspy-nav="closest: li; scroll: true; offset: 80" data-uk-navbar-bound>
                                <li><a href="{{ route('home') }}#uni_minting">Minting</a></li>
                                <li><a href="{{ route('home') }}#uni_about">About</a></li>
                                <li><a href="{{ route('home') }}#uni_collection">Collection</a></li>
                            </ul>
                            <div class="uk-navbar-item">
                                <ul class="uk-subnav uk-subnav-small uk-visible@m">
                                    <li>
                                        <a href="https://twitter.com/ChateauEclepens" target="_blank"><i class="uk-icon uk-icon-medium unicon-logo-twitter"></i></a>
                                    </li>
                                </ul>
{{--                                <!-- header: call to actions -->--}}
{{--                                <a href="#uni_connect_wallet" class="uk-button uk-button-medium@m uk-button-default uk-button-outline uk-margin-left uk-visible@l" data-uk-toggle="">--}}
{{--                                    <span>Connect wallet</span>--}}
{{--                                </a>--}}
                            </div>

                            <div class="uk-navbar-item uk-hidden@m">
{{--                                <a href="#uni_connect_wallet" class="uk-button uk-button-medium@m uk-button-icon uk-hidden@m uk-margin-small-right" data-uk-toggle="">--}}
{{--                                    <i class="uk-icon unicon-wallet"></i>--}}
{{--                                </a>--}}
                                <a href="#uni_mobile_menu" data-uk-toggle>
                                    <span class="uk-icon uk-icon-medium material-icons">menu</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- Header end -->

    @yield('content')
</div>

<!-- Wrapper end -->

<!-- Wrapper end -->

<!-- Footer start -->
<footer class="uni-footer uk-section uk-section-xlarge@m">
    <div class="uk-container">
        <div class="uk-panel">
            @if (Route::is('home'))
            <img class="uk-position-top-left" width="32" src="{{ asset('skin/nerko/assets/images/objects/ethereum-01.png') }}" alt="object" style="top: 32%; left: 16%">
            <img class="uk-position-top-right" width="16" src="{{ asset('skin/nerko/assets/images/objects/x.png') }}" alt="object" style="top: 8%; right: 16%">
            <img class="uk-position-bottom-right" width="16" src="{{ asset('skin/nerko/assets/images/objects/circle-01.png') }}" alt="object" style="bottom: 24%; right: 40%">
            <img class="uk-position-bottom-left" width="24" src="{{ asset('skin/nerko/assets/images/objects/circle-03.png') }}" alt="object" style="bottom: -8%; left: 30%">
            <div class="uk-grid uk-flex-center uk-text-center" data-uk-grid>
                <div class="uk-width-large@m">
                    <div class="uk-panel">
                        <a href="/" class="uk-logo">
{{--                            <img width="200" src="{{ asset('skin/nerko/assets/images/nerko.svg') }}" alt="Nerko">--}}
                        </a>
                        <p class="uk-text-xlarge@m uk-margin-medium-top@m">We make it easy to discover, invest in, and manage our NFTs to reap numerous benefits.</p>
                        <ul class="uk-subnav uk-subnav-small uk-flex-center uk-text-gray-40 uk-margin-top uk-margin-medium-top@m">
                            <li>
                                <a href="https://x.com/ChateauEclepens"><span class="uk-icon uk-icon-medium@m unicon-logo-twitter"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            <hr class="uk-margin-medium uk-margin-3xlarge-top@m">
            <div class="uk-panel uk-text-small">
                <div class="uk-grid uk-child-width-auto@m uk-flex-center uk-flex-between@m uk-text-center uk-text-left@m" data-uk-grid>
                    <div>
                        <ul class="uk-subnav uk-subnav-small uk-text-muted uk-flex-center">
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="{{ route('inquiry') }}">Check your NFT</a></li>
                            <li><a href="https://www.chateau-eclepens.ch/" target="_blank">Official site</a></li>
                            <li class="uk-margin-small-left">
                                <a href="#" data-uk-totop="" data-uk-scroll><i class="uk-icon uk-icon-small unicon-chevron-up"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="uk-flex-first@m uk-flex-center">
                        <p class="uk-text-muted">© 2024 CHÂTEAU D’ECLÉPENS. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Footer end -->

<!-- include scripts -->
<script defer src="{{ asset('skin/nerko/assets/js/libs/jquery.min.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/libs/swiper-bundle.min.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/libs/feather.min.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/libs/typed.min.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/libs/anime.min.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/app.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/helpers/data-attr-helper.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/helpers/swiper-helper.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/helpers/typed-helper.js') }}"></script>
<script defer src="{{ asset('skin/nerko/assets/js/helpers/anime-helper.js') }}"></script>

<!-- <script defer src="{{ asset('skin/nerko/assets/js/helpers/anime-helper-defined-timelines.js') }}"></script> -->
<script>
    // Schema toggle via URL
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const getSchema = urlParams.get("schema");
    if (getSchema === "dark") {
        document.documentElement.classList.add("uk-dark");
        localStorage.setItem("darkMode", "1");
    } else if (getSchema === "light") {
        document.documentElement.classList.remove("uk-dark");
        localStorage.setItem("darkMode", "0");
    }
</script>
@livewireScripts
{{-- Includable JS --}}
@yield('scripts')
</body>
</html>
