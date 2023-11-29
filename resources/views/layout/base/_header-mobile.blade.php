{{-- Header Mobile --}}
<div id="kt_header_mobile" style="background: #c9f7f4 !important;" class="header-mobile {{ Metronic::printClasses('header-mobile', false) }}" {{ Metronic::printAttrs('header-mobile') }}>
    <div class="mobile-logo">
        <a href="{{ url('/') }}">

            @php
                $kt_logo_image = 'logo.png'
            @endphp

            @if (config('layout.aside.self.display') == false)

                @if (config('layout.header.self.theme') === 'light')
                    @php $kt_logo_image = 'logo.png' @endphp
                @elseif (config('layout.header.self.theme') === 'dark')
                    @php $kt_logo_image = 'logo.png' @endphp
                @endif

            @else

                @if (config('layout.brand.self.theme') === 'light')
                    @php $kt_logo_image = 'logo.png' @endphp
                @elseif (config('layout.brand.self.theme') === 'dark')
                    @php $kt_logo_image = 'logo.png' @endphp
                @endif

            @endif

            <img height="50" alt="{{ config('app.name') }}" src="{{ asset('theme_assets/media/logos/'.$kt_logo_image) }}"/>
        </a>
    </div>
    <div class="d-flex align-items-center">

        @if (config('layout.aside.self.display'))
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle"><span></span></button>
        @endif

        @if (config('layout.header.menu.self.display'))
            <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle"><span></span></button>
        @endif

        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
            {{ Metronic::getSVG('media/svg/icons/General/User.svg', 'svg-icon-xl') }}
        </button>

    </div>
</div>
