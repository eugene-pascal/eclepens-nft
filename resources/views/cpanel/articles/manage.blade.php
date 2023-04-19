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

                    @if (!empty($article))
                        <div class="separator separator-dashed my-8"></div>
                        <div id="image_container" class="form-group row">
                            @if($article->getMedia(\App\Models\Article::_MEDIA_COLLECTION_NAME)->count()>0)
                                @foreach($article->getMedia(\App\Models\Article::_MEDIA_COLLECTION_NAME) as $media)
                                    <div class="block-image col-md-4 col-xxl-3 col-lg-3">
                                        <div class="card-body p-0">
                                            <!--begin::Image-->
                                            <div class="overlay">
                                                <div class="overlay-wrapper rounded bg-light text-center">
                                                    <img src="{{ $media->getUrl('thumb300x300') }}" alt="" class="mw-100 w-200px" />
                                                </div>
                                                <div class="overlay-layer">
                                                    <a href="{{ $media->getUrl() }}" class="image-copy-link btn font-weight-bolder btn-sm btn-primary mr-2">Copy link</a>
                                                    <a href="{{ route('content.article.delete.media', ['article' => $article->id, 'media'=>$media->id])  }}" class="image-remove-link btn font-weight-bolder btn-sm btn-light-primary">Delete</a>
                                                </div>
                                            </div>
                                            <!--end::Image-->
                                            <!--begin::Details-->
                                            <div class="text-center mt-5 mb-md-0 mb-lg-5 mb-md-0 mb-lg-5 mb-lg-0 mb-5 d-flex flex-column">
                                                <span class="font-size-lg">{{ $media->name }}</span>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="separator separator-dashed my-8"></div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-right">File Type Validation</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone">
                                    <div class="dropzone-msg dz-message needsclick">
                                        <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                        <span class="dropzone-msg-desc">Only image, pdf and psd files are allowed for upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <button id="uploaded-media-btn" type="button" class="btn width-200 btn-success">{{ __('Upload') }}</button>
                            </div>
                        </div>
                    @endif

                    <div class="card-footer">
                        <button type="submit" class="btn width-200 btn-primary">{{ __('Update') }}</button>
                        @if(!empty($article))
                            <button type="reset" class="btn btn-default">{{ __('Cancel') }}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@if (!empty($article))
@section('styles')
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet">
@endsection
@endif
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


    @if (!empty($article))
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js" type="text/javascript"></script>
    {{-- <script src="{{ asset('theme_assets/js/pages/crud/file-upload/dropzonejs.js') }}" type="text/javascript"></script> --}}
    <script>
        // file type validation
        $('#kt_dropzone').dropzone({
            url: "{{ route('content.article.upload.media', ['article' => $article->id]) }}", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 5,
            maxFilesize: 10, // MB
            addRemoveLinks: false,
            acceptedFiles: "image/*",
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 5,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            // Uploaded
            accept: function(file, done) {
                done();
            },
            error: function(file, msg){
                // console.log(msg);
            },
            complete: function(file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $("#uploaded-media-btn").prop('disabled', false);
                    this.removeAllFiles();
                }
            },
            init: function() {
                const myDropzone = this;
                //now we will submit the form when the button is clicked
                $("#uploaded-media-btn").on('click',function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const form = $(this).parents('form');
                    if($(form)[0].checkValidity()) {
                        if (myDropzone.getQueuedFiles().length > 0) {
                            $(this).prop('disabled', true);
                            myDropzone.processQueue();
                        }
                    }
                });

                this.on("successmultiple", function(files, response) {
                    // Gets triggered when the files have successfully been sent.
                    // Redirect user or notify of success.
                });

                this.on("success", function (file, response) {
                    if (typeof response.status !== 'undefined' && 'success' === response.status && typeof response.result === 'object') {
                        const mainContainer = $('#image_container');
                        const countImg = mainContainer.find('.block-image').length;
                        const data = response.result;

                        console.log(countImg)
                        let divBlock =  $('<div/>',{
                            class: 'block-image col-md-4 col-xxl-3 col-lg-3'
                        }).appendTo(mainContainer);

                        let divBlock2 =  $('<div/>',{
                            class: 'card-body p-0'
                        }).prependTo(divBlock);

                        let divOverlay =  $('<div/>',{
                            class: 'overlay'
                        }).prependTo(divBlock2);

                        let file_name_url = '';
                        if (jQuery.isEmptyObject(data.generated_conversions)) {
                            file_name_url = data.original_url;
                        } else {
                            let _key = Object.keys(data.generated_conversions)[0] ?? false ;
                            if (_key) {
                                const re = /(?:\.([^.]+))?$/;
                                let ext_with_dot = '.'+re.exec(data.file_name)[1];
                                let new_file_name = data.file_name.replace(ext_with_dot,'');
                                new_file_name = 'conversions/' + new_file_name + '-' + _key + '.jpg';
                                file_name_url = data.original_url.replace(data.file_name, new_file_name);
                            } else {
                                file_name_url = data.original_url;
                            }

                        }
                        $('<div/>',{
                            class: 'verlay-wrapper rounded bg-light text-center',
                            html: '<img src="'+ file_name_url +'" alt="" class="mw-100 w-200px" />'
                        }).appendTo(divOverlay);

                        let _link_del = '{!! route("content.article.delete.media",["article"=>$article->id, "media"=>':id']) !!}';
                        _link_del = _link_del.replace(':id', data.id);

                        $('<div/>',{
                            class: 'overlay-layer',
                            html: '<a href="'+ data.original_url +'" class="image-copy-link btn font-weight-bolder btn-sm btn-primary mr-2">Copy link</a>'+
                                  '<a href="'+ _link_del +'" class="image-remove-link btn font-weight-bolder btn-sm btn-light-primary">Delete</a>'
                        }).appendTo(divOverlay);

                        $('<div/>',{
                            class: 'text-center mt-5 mb-md-0 mb-lg-5 mb-md-0 mb-lg-5 mb-lg-0 mb-5 d-flex flex-column',
                            html: '<span class="font-size-lg">'+ data.name +'</span>'
                        }).appendTo(divBlock2);
                    }
                });
            } // init end
        });
        jQuery(document).ready(function() {
            $(document).on('click', 'a.image-copy-link', function(event) {
                event.preventDefault();
                let url = $(this).attr('href');
                let temp = $("<input>");
                $("body").append(temp);
                temp.val(url).select();
                document.execCommand("copy");
                temp.remove();
            });
            $(document).on('click', 'a.image-remove-link', function(event) {
                event.preventDefault();
                if (confirm("Are you sure to remove this image?")) {
                    let url = $(this).attr('href');
                    let _token = '{{ csrf_token() }}';
                    let paramsObj = {
                        _method: 'delete', _token
                    };
                    let mainWrapper = $(this).parents('.block-image');
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: url,
                        data: paramsObj,
                        success: function (data) {
                            if (data.status === 'success') {
                                mainWrapper.remove();
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
                }
            });
        });
    </script>
    @endif
@endsection