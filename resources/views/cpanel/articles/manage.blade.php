@extends('layout.default')
@inject('articleTypes', 'App\Enums\ArticleTypes')
@php
    $title = !empty($article) ? __("Manage the article id: :id", ['id'=>$article->id]) : __('Add a new article');
    $page_breadcrumbs = [
            [
                'page'=> route('content.articles.list'),
                'title'=> __('List of articles')
            ],
            [
                'page'=>url()->current(),
                'title'=> $title.''
            ]
        ];
@endphp
@section('title', $title)
@section('content')
    <div class="card card-custom">
        <div class="card-header card-header-tabs-line">
            <h3 class="card-title">
                <strong>{{ $title }}</strong>
            </h3>
        </div>

        <div class="card-body">
            <div class="tab-content pt-5">
                <form class="static-page-form" method="POST" action="{{ empty($article) ? route('content.article.add') : route('content.article.edit', ['article' => $article->id]) }}" id="static-form">
                    @csrf
                    @if(!empty($article))
                        @method('PUT')
                    @endif

                    @include('pages.widgets._alert_both_success_error', [])

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="name" class="required">{{ __('Title')}} <i class="text-danger">*</i></label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="title" value="{{old('title', $article->title ?? '')}}"  placeholder=""/>
                            @if($errors->has('title'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="header" class="required">{{ __('Code unique') }} <i class="text-danger">*</i></label>
                        <div class="col-4">
                            <input type="text" maxlength="32" class="form-control" name="code_unique" value="{{old('code_unique', $article->code_unique ?? '')}}" placeholder=""/>
                            @if($errors->has('code_unique'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('code_unique') }}</div>
                            @endif
                        </div>
                        <label class="col-2 col-form-label" for="header" class="required">{{ __('Code name') }} <i class="text-danger">*</i></label>
                        <div class="col-4">
                            <input type="text" maxlength="8" class="form-control" name="code_name" value="{{old('code_name', $article->code_name ?? '')}}" placeholder=""/>
                            @if($errors->has('code_name'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('code_name') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="header" class="required">{{ __('Alias') }} <i class="text-danger">*</i></label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="slug" value="{{old('slug', $article->slug ?? '')}}" placeholder=""/>
                            @if($errors->has('slug'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('slug') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="type">{{ __('Language') }}</label>
                        <div class="col-10">
                            <select class="form-control" name="code_lang2" id="type">
                                @foreach($articleTypes::langList() as $option => $optionName)
                                    <option {{ old('code_lang2', $article->code_lang2 ?? __('Choose page language')) === $option ? 'selected' : '' }} value="{{ $option }}">{{ $optionName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="text">{{  __('Text') }} <i class="text-danger">*</i></label>
                        <div class="col-10">
                            <textarea id="textTineMCE" class="text-tine-MCE" name="text">{{old('text', $article->text ?? '')}}</textarea>
                            @if($errors->has('text'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('text') }}</div>
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-2 col-form-label"></label>
                        <div class="col-10 col-form-label">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" name="display" value="1" {{ old('display', $article->display ?? true) ? 'checked' : '' }}/>
                                    <span></span>
                                    @lang('Display')
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-8"></div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="title">{{ __('Meta title') }}</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="meta_title" value="{{old('meta_title', $article->meta_title ?? '')}}" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="keywords">{{ __('Keywords') }}</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="meta_keywords" value="{{old('meta_keywords', $article->meta_keywords ?? '')}}" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="text">{{ __('Description') }}</label>
                        <div class="col-10">
                            <textarea class="form-control" name="meta_description">{{old('meta_description', $article->meta_description ?? '')}}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn width-200 btn-primary">{{ __('Update') }}</button>
                        @if(!empty($article))
                            <button type="reset" class="btn btn-default">{{ __('Cancel') }}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if (false)
        <div class="card-body">
            <form method="POST" action="{{ empty($page) ? route('page.add') : route('page.edit', ['page' => $page->id]) }}" id="static-form">
                @csrf
                @if(!empty($page))
                    @method('PUT')
                @endif

                @if (!empty($parent_id))
                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                @endif

                @if (!empty($position))
                    <input type="hidden" name="position" value="{{ $position }}">
                @endif

                @include('pages.widgets._alert_both_success_error', [])

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="name" class="required">{{ __('Page name')}} <i class="text-danger">*</i></label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="name" value="{{old('name', $page->name ?? '')}}" id="name" placeholder="Menu name"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="header" class="required">{{ __('Page header') }} <i class="text-danger">*</i></label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="header" value="{{old('header', $page->name ?? '')}}" id="header" placeholder="H1 header"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="text">Text <i class="text-danger">*</i></label>
                    <div class="col-10">
                        <textarea id="textTineMCE" name="text">{{old('text', $page->text ?? '')}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="slug">{{ __('Page URL') }}</label>
                    <div class="col-10">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                            <input type="text" class="form-control" name="slug" value="{{old('slug', $page->slug ?? '')}}" id="slug" placeholder="Slug / Page URL"/>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="type">Type</label>
                    <div class="col-10">
                        <select class="form-control" name="type" id="type">
                            @foreach($staticPageTypes::list() as $option => $optionName)
                                <option {{ old('type', $page->type ?? __('Choose page type')) === $option ? 'selected' : '' }} value="{{ $option }}">{{ $optionName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label"></label>
                    <div class="col-10 col-form-label">
                        <div class="checkbox-list">
                            <label class="checkbox">
                                <input type="checkbox" name="display" id="display" value="1" {{ old('display', $page->display ?? true) ? 'checked' : '' }}/>
                                <span></span>
                                @lang('Show in menu')
                            </label>
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-8"></div>

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="title">{{ __('Title') }}</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="title" value="{{old('title', $page->title ?? '')}}" id="title" placeholder="META Title"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="keywords">{{ __('Keywords') }}</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="keywords" value="{{old('keywords', $page->keywords ?? '')}}" id="keywords" placeholder="META Keywords"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="text">{{ __('Description') }}</label>
                    <div class="col-10">
                        <textarea class="form-control" name="description" id="text">{{old('description', $page->description ?? '')}}</textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn width-200 btn-primary">{{ __('Update') }}</button>
                    @if(!empty($page))
                        <button type="reset" class="btn btn-default">{{ __('Cancel') }}</button>
                    @endif
                </div>
            </form>
        </div>
        @endif
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('theme_assets/plugins/custom/tinymce/tinymce.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme_assets/js/pages/crud/forms/editors/tinymce.js') }}" type="text/javascript"></script>
    <script>
        var KTTinymce = function () {
            // Private functions
            var start = function () {
                tinymce.init({
                    selector: '#textTineMCE, .text-tine-MCE',
                    plugins: 'codesample code',
                    toolbar: 'codesample code undo indent italic bold backcolor lineheight aligncenter alignjustify alignleft alignnone alignright blockquote  copy fontselect formatselect',
                    statusbar: false,
                });
            }

            return {
                // public functions
                init: function() {
                    start();
                }
            };
        }();

        // Actions
        const controlActions = function() {
            let _keepObject = null;
            const handleActions = function() {
                const ajaxRequest = function (postData, url, _method="POST") {
                };
                const ajaxSuccess = function (response) {
                };
            };

            return {
                // public functions
                init: function() {
                    handleActions();
                },
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTTinymce.init();
            controlActions.init();
        });
    </script>
@endsection