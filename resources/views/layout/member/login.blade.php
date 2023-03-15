<!DOCTYPE html>
{{--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
--}}
<html lang="en">
<!--begin::Head-->
<head>
    <base href="/">
    <meta charset="utf-8" />
    {{-- Title Section --}}
    <title>@yield('title', $page_title ?? '')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    {{-- Fonts --}}
    {{ Metronic::getGoogleFontsInclude() }}
    <link rel="shortcut icon" href="{{ asset('theme_assets/media/logos/android-chrome-192x192.png') }}" />

    {{-- begin::Page Custom Styles(used by this page) --}}
    <link href="{{ asset('theme_assets/css/pages/login/login-1.css?1') }}"" rel="stylesheet" type="text/css" />

    {{-- Global Theme Styles (used by all pages) --}}
    @foreach(config('layout.resources.css') as $style)
        <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet" type="text/css"/>
    @endforeach

    {{-- Layout Themes (used by all pages) --}}
    @foreach (Metronic::initThemes() as $theme)
        <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet" type="text/css"/>
    @endforeach

    {{-- Includable CSS --}}
    @yield('styles')

</head><!--end::Head-->
<!--begin::Body-->
<body {{ Metronic::printAttrs('body') }} class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    @yield('content')
</div>
<!--end::Main-->
{{-- Global Config (global config for global JS scripts) --}}
<script>
    var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
</script>

{{-- Global Theme JS Bundle (used by all pages)  --}}
@foreach(config('layout.resources.js') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
@endforeach

{{--cbegin::Page Scripts(used by this page) --}}
<script src="{{ asset('theme_assets/js/pages/custom/login/login-general.js?5') }}"></script>

{{-- Includable JS --}}
@yield('scripts')
</body>
</html>