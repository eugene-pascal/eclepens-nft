@extends('layout.nerko')
@section('title', __('Check your NFT on validity by your wallet address'))
@section('content')

    <div class="uni-contact uk-section uk-section-large@m uk-panel uk-overflow-hidden uk-border-top">
        <!-- Page header -->
        <header class="uni-page-header">
            <div class="uk-container">
                <h1 class="heading uk-h3 uk-h1@m uk-text-uppercase uk-text-center">Check your NFT</h1>
            </div>
        </header>
        <div class="uk-margin-top uk-margin-large-top@m">
            <div class="uk-container uk-container-xsmall">
                <div class="uk-grid uk-child-width-1-1 uk-grid-stack" data-uk-grid="">
                    <div class="uk-grid-margin uk-first-column">
                        <div class="uk-card uk-card-small uk-card-large@m">
                            <div class="uk-grid" data-uk-grid="">
                                <div class="uk-panel uk-first-column">
                                    <h2 class="uk-h5 uk-h4@m">Wallet address</h2>
                                    <p>Enter your wallet address where you had minted our NFT in order to check if our preferences are available to you</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-first-column">
                        <div class="uk-card uk-card-small uk-card-large@m uk-card-default uk-card-border uk-radius-medium uk-radius-large@m uk-position-z-index dark:uk-background-white-5">
                            <form action="" class="uk-grid uk-grid-xsmall uk-child-width-1-1" data-uk-grid="">
                                <div class="uk-form-controls uk-grid-margin uk-first-column">
                                    <input class="uk-input uk-form-medium uk-text-bold" type="text" placeholder="Wallet address">
                                </div>
                                <div class="uk-form-controls uk-flex-center uk-grid-margin uk-first-column">
                                    <button type="submit" class="uk-button uk-button-gradient uk-width-small@m uk-margin-auto">Check</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection