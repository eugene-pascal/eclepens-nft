@extends('layout.nerko')
@section('title', __('Check your NFT on validity by your wallet address'))
@section('content')
    <div id="uni_about" class="uni-about uk-section uk-section-xlarge@m uk-panel">
        <div class="uk-container">
            <header class="uk-grid-xsmall uk-flex-center uk-flex-middle uk-grid" data-uk-grid data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">
                <div class="uk-panel uk-text-center">
                    <img src="{{ asset('meme/tron/winetron.png') }}">
                </div>
            </header>
            <div class="uk-panel uk-margin-medium-top uk-margin-2xlarge-top@m">
                <div class="uk-grid uk-grid-2xlarge uk-grid-3xlarge@m uk-child-width-1-1" data-uk-grid="">
                    <div>
                        <div class="uk-panel">
                            <div class="uk-grid uk-grid-3xlarge@m uk-flex-middle uk-child-width-1-2@m" data-uk-grid="">
                                <div>
                                    <div class="uk-panel uk-image-middle uk-overflow-hidden uk-radius uk-radius-large@m" data-anime="opacity:[0, 1]; translateX:[-24, 0]; onview: -250; delay: 200;">
                                        <img src="{{ asset('meme/tron/1.webp') }}" alt="">
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-panel" data-anime="opacity:[0, 1]; translateX:[24, 0]; onview: -250; delay: 300;">
{{--                                        <span class="uk-text-overline uk-text-gradient">History</span>--}}
                                        <h3 class="uk-h3 uk-h1@m">About us</h3>
                                        <p class="uk-text-large@m">
                                            The idea behind the meme is to draw attention to the exquisite wines of Switzerland (Romandy). We also aim to bring a touch of elegance to the world of cryptocurrency.<br>
                                            Inspired by the Sun Pump model, we hope to create a perfect blend of tradition and innovation.
                                        </p>
                                        <div class="uk-grid uk-grid-large@m uk-grid-match uk-child-width-1-2 uk-margin-large-top@m" data-uk-grid="">
                                            <div>
                                                <div class="uk-panel">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-panel">
                                                    <h5 class="uk-h4 uk-h2@m uk-margin-xsmall">100+</h5>
                                                    <span class="uk-text-small@m">winegrowers in Switzerland Romandy</span>
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
                                        <img src="{{ asset('meme/tron/2.webp') }}" alt="">
                                    </div>
                                </div>
                                <div class="uk-flex-first@m">
                                    <div class="uk-panel" data-anime="opacity:[0, 1]; translateX:[-24, 0]; onview: -250; delay: 400;">
                                        <span class="uk-text-overline uk-text-gradient">WineMonics</span>
                                        <h3 class="uk-h3 uk-h1@m">Tokemonics</h3>
                                        <h3 class="uk-h3 uk-h3@m">SUPPLY</h3>
                                        <p class="uk-text-large@m uk-text-danger">
                                            1.000.000.000
                                        </p>
                                        <h3 class="uk-h4 uk-h4@m">CONTRACT ADDRESS</h3>
                                        <p class="uk-text-large@m">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; translateY:[24, 0]; onview: true; delay: 100;">

    <!-- brands start -->
    @include('nerko.meme.brands', [])
    <!-- brands end -->

    <img class="uk-width-2xsmall uk-flex-center uk-margin-auto uk-margin-medium uk-margin-large@m" src="{{ asset('skin/nerko/assets/images/divider-01.svg') }}" alt="Divider" data-anime="opacity:[0, 1]; scale:[0, 1]; onview: true; delay: 100;">

@endsection