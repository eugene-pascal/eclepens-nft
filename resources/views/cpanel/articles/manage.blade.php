@extends('layout.default')
@inject('constant', 'App\Enums\ArticleTypes')
@php
    $title = !empty($article) ? __('Manage the article id: {id}', ['id'=>$article->id]) : __('Add a new article');
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
                @if (!empty($langs))
                    @if (empty($page))
                        <div class="tab-pane active">
                            @include('cpanel.static._page_form', ['currLang'=>$langs[0]])
                        </div>
                    @else
                        @foreach($langs as $indx=>$lang)
                            <div class="tab-pane{{ 0 == $indx ? ' active' : '' }}" id="lang_{{$lang->lang_code}}" role="tabpanel">
                                @include('cpanel.static._page_form', ['currLang'=>$lang, 'local'=> $page->staticPageLocalization()->where('language_id',$lang->id)->first()] )
                            </div>
                        @endforeach
                    @endif
                @endif
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
                    if (typeof postData['_token'] === 'undefined') {
                        postData["_token"] = "<?php echo e(csrf_token()); ?>";
                    }
                    $.ajax({
                        url: url,
                        data: postData,
                        success: ajaxSuccess,
                        dataType: "json",
                        type: _method,
                        error: function(data) {
                            const response = data.responseJSON;
                            if (typeof response.errors !== 'undefined' && typeof response.errors !== 'undefined') {
                                let _errorMessage = '';
                                for (let key in response.errors) {
                                    _errorMessage = response.errors[key][0];
                                }
                                $.notify({
                                    title: '<strong>' + response.message + '</strong>',
                                    message: '<strong>' + _errorMessage + '</strong>'
                                }, {
                                    type:  'danger'
                                });
                            } else {
                                $.notify({
                                    title: '<strong>Error:</strong>',
                                    message: 'An error occurred'
                                }, {
                                    type: 'warning'
                                })
                            }
                            _keepObject.find('input[type=text]').attr('disabled',false);
                            _keepObject.find('textarea').attr('disabled',false);
                            _keepObject.find('button[type=submit]')
                                .attr('disabled',false)
                                .removeClass('spinner spinner-white spinner-right pr-15 disabled')
                                .html('Save');
                        }
                    });
                };
                const ajaxSuccess = function (response) {
                    if (typeof response.status !== 'undefined' && response.status === 'success' && typeof response.page_id !== 'undefined') {
                        if (typeof response.action !== 'undefined' && response.action === 'update') {
                            $.notify({
                                title: '<strong>Saved</strong>',
                                message: 'Page was saved'
                            }, {
                                type: 'success'
                            })
                            _keepObject.find('input[type=text]').attr('disabled',false);
                            _keepObject.find('textarea').attr('disabled',false);
                            _keepObject.find('button[type=submit]')
                                .attr('disabled',false)
                                .removeClass('spinner spinner-white spinner-right pr-15 disabled')
                                .html('Save');
                        } else {
                            let _link = '{!! route("page.edit",["page"=>':id']) !!}';
                            _link = _link.replace(':id', response.page_id);
                            $(location).attr('href', _link);
                        }
                    }
                };

                $(document).on('submit', 'form.static-page-form', function(e) {
                    e.preventDefault();
                    let _this = $(this);
                    let _url = _this.attr('action');
                    let _data = _this.serialize();

                    _this.find('input[type=text]').attr('disabled',true);
                    _this.find('textarea').attr('disabled',true);
                    _this.find('button[type=submit]')
                        .attr('disabled',true)
                        .removeClass('spinner spinner-white spinner-right pr-15 disabled')
                        .addClass('spinner spinner-white spinner-right pr-15 disabled')
                        .html('Saving');

                    _keepObject = _this;
                    ajaxRequest(_data, _url)
                });
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