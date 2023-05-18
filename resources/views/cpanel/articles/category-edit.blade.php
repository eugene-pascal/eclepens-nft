@extends('layout.default')
@section('title',  __('Manage categories'))
@php
    $title = !empty($category) ? __("Manage the category id: :id", ['id'=>$category->id]) : __('Add a new category');
    $page_breadcrumbs = [
        [
            'page'=>route('content.articles.categories.list'),
            'title'=> __('Categories')
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
            <form method="POST" action="{{ empty($category) ? route('content.article.category.add') : route('content.article.category.edit', ['category' => $category->id]) }}">
                @csrf
                @if(!empty($category))
                    @method('PUT')
                @endif

                @include('pages.widgets._alert_both_success_error', [])

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">{{ __('Name') }}</label>
                            <div class="col-9">
                                <input type="text" maxlength="64" class="form-control form-control-lg form-control-solid" name="name" value="{{old('name', $category->name ?? '')}}" placeholder=""/>
                                @if($errors->has('name'))
                                    <div class="error text-danger font-size-sm">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right">Active</label>
                            <div class="col-9">
                            <span class="switch">
                                <label>
                                    <input type="checkbox" name="is_active" value="1"
                                           {{ !old('is_active', $category->is_active ?? false) ? '' : 'checked="checked"' }}>
                                    <span></span>
                                </label>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn width-200 btn-primary">Update</button>
                    @if(!empty($category))
                        <button type="reset" class="btn btn-default">Cancel</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection