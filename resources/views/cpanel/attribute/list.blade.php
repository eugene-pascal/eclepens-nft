@extends('layout.default')
@section('title', __('The list of attributes'))
@php
    $page_breadcrumbs = [
            [
                'page'=>url()->current(),
                'title'=> __('The list of attributes')
            ]
        ];
@endphp
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    @lang('Attributes')
                    <div class="text-muted pt-2 font-size-sm"></div>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('attribute.add') }}" class="btn btn-light-primary font-weight-normal">
                    {{ Metronic::getSVG("media/svg/icons/Design/Flatten.svg", "svg-icon-md") }}
                    @lang('Add a new attribute')
                </a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            @include('pages.widgets._alert_both_success_error', [])

        </div>
    </div>
@endsection
