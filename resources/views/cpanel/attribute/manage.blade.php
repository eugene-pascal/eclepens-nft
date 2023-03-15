@extends('layout.default')
@inject('staticPageTypes', 'App\Enums\StaticPageTypes')
@section('title', __('Add a new attribute'))
@php
    $page_breadcrumbs = [
            [
                'page'=> route('attributes.list'),
                'title'=> __('The list of attributes')
            ],
            [
                'page'=>url()->current(),
                'title'=> __('Add a new attribute')
            ]
        ];
@endphp
@section('content')
    <div class="card card-custom">
        <div class="card-header card-header-tabs-line">
            <h3 class="card-title">
                <strong>{{__('Add a new attribute')}}</strong>
            </h3>
        </div>
        <div class="card-header card-header-tabs-line">
            <div class="card-toolbar">
                @if (!empty($langs))
                    <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-bold nav-tabs-line-3x" role="tablist">
                        @if (empty($page))
                            <li class="nav-item active text-uppercase font-weight-bold">{{ $langs[0]->lang_name }}</li>
                        @else
                            @foreach($langs as $indx=>$lang)
                                <li class="nav-item text-uppercase font-weight-bold">
                                    <a class="nav-link{{ 0 == $indx ? ' active' : '' }}" data-toggle="tab" href="#lang_{{$lang->lang_code}}">
                                        <span class="nav-text">{{$lang->lang_name}}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content pt-5">
                @if (!empty($langs))

                @endif
            </div>
        </div>
    </div>
@endsection