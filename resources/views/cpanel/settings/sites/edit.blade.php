@extends('layout.default')
@section('title',  __('Manage sites'))
@php
    $title = !empty($site) ? __("Manage the site id: :id", ['id'=>$site->id]) : __('Add a new site');
    $page_breadcrumbs = [
        [
            'page'=>route('settings.sites'),
            'title'=> __('Sites')
        ],
        [
            'page'=>url()->current(),
            'title'=> $title
        ]
    ];
@endphp
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                <strong>{{ $title }}</strong>
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ empty($site) ? route('settings.site.add') : route('settings.site.edit', ['site' => $site->id]) }}">
                @csrf
                @if(!empty($site))
                    @method('PUT')
                @endif

                @include('pages.widgets._alert_both_success_error', [])

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">{{ __('Name') }}</label>
                            <div class="col-9">
                                <input type="text" maxlength="64" class="form-control form-control-lg form-control-solid" name="name" value="{{old('name', $site->name ?? '')}}" placeholder=""/>
                                @if($errors->has('name'))
                                    <div class="error text-danger font-size-sm">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">{{ __('Code') }}</label>
                            <div class="col-9">
                                <input type="text" maxlength="5" class="form-control form-control-lg form-control-solid" name="code" value="{{old('code', $site->code ?? '')}}" placeholder=""/>
                                @if($errors->has('code'))
                                    <div class="error text-danger font-size-sm">{{ $errors->first('code') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">{{ __('URL') }}</label>
                            <div class="col-9">
                                <input type="text" maxlength="64" class="form-control form-control-lg form-control-solid" name="url" value="{{old('url', $site->url ?? '')}}" placeholder=""/>
                                @if($errors->has('url'))
                                    <div class="error text-danger font-size-sm">{{ $errors->first('url') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6 col-md-6 row mb-10">
                        <label class="col-3 col-form-label text-right">Active</label>
                        <div class="col-9">
                            <span class="switch">
                                <label>
                                    <input type="checkbox" name="is_active" value="1"
                                           {{ !old('is_active', $site->is_active ?? false) ? '' : 'checked="checked"' }}>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn width-200 btn-primary">Update</button>
                    @if(!empty($site))
                        <button type="reset" class="btn btn-default">Cancel</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection