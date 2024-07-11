@extends('layout.nerko')
@section('title', __('Check your NFT on validity by your wallet address'))
@section('content')

    <div class="uni-contact uk-section uk-section-large@m uk-panel uk-overflow-hidden uk-border-top">
        <!-- Page header -->
        <header class="uni-page-header">
            <div class="uk-container">
                <h1 class="heading uk-h3 uk-h1@m uk-text-uppercase uk-text-center">Loyalty Program</h1>
            </div>
        </header>
        <div class="uk-margin-top uk-margin-large-top@m">
            <div class="uk-container uk-container-xsmall">
                <p class="uk-text-small uk-text-large@m uk-text-muted">
                    Each year, NFT holders can accumulate points for holding their NFTs, which can then be redeemed for additional wines or discounts. <a href="{{ route('inquiry') }}" class="uk-text-info">Explore the exciting propositions waiting for you.</a>
                </p>
            </div>
        </div>
    </div>
@endsection