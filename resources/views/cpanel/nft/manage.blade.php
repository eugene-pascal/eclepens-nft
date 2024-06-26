@extends('layout.default')
@php
    $title = !empty($nft) ? __("Manage the NFT id: :id", ['id'=>$nft->id]) : __('Add a new NFT');
    $page_breadcrumbs = [
            [
                'page'=> route('content.nft.list'),
                'title'=> __('List of NTF')
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
                <form class="static-page-form" method="POST" action="{{ empty($nft) ? route('content.nft.add') : route('content.nft.edit', ['nft' => $nft->id]) }}" id="static-form">
                    @csrf
                    @if(!empty($nft))
                        @method('PUT')
                    @endif

                    @include('pages.widgets._alert_both_success_error', [])

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="name" class="required">{{ __('Name')}} <i class="text-danger">*</i></label>
                        <div class="col-7">
                            <input type="text" class="form-control" name="name" value="{{old('name', $nft->name ?? '')}}"  placeholder=""/>
                            @if($errors->has('name'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <label class="col-1 col-form-label" for="header" class="required">{{ __('Prior') }} <i class="text-danger">*</i></label>
                        <div class="col-2">
                            <input type="number" maxlength="5" class="form-control" name="prior" value="{{old('prior', $nft->prior ?? '')}}" placeholder=""/>
                            @if($errors->has('prior'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('prior') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="header" class="required">{{ __('Standard') }} <i class="text-danger">*</i></label>
                        <div class="col-3">
                            <input type="text" maxlength="32" class="form-control" name="standard" value="{{old('standard', $nft->standard ?? '')}}" placeholder=""/>
                            @if($errors->has('standard'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('standard') }}</div>
                            @endif
                        </div>

                        <label class="col-1 col-form-label" for="header" class="required">{{ __('Author') }} <i class="text-danger">*</i></label>
                        <div class="col-3">
                            <input type="text" maxlength="8" class="form-control" name="author" value="{{old('author', $nft->author ?? '')}}" placeholder=""/>
                            @if($errors->has('author'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('author') }}</div>
                            @endif
                        </div>

                        <label class="col-1 col-form-label" for="header" class="required">{{ __('Max NFT') }} <i class="text-danger">*</i></label>
                        <div class="col-2">
                            <input type="text" maxlength="8" class="form-control" name="max_nft" value="{{old('max_nft', $nft->max_nft ?? '')}}" placeholder=""/>
                            @if($errors->has('max_nft'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('max_nft') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="header" class="required">{{ __('Alias') }} <i class="text-danger">*</i></label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="slug" value="{{old('slug', $nft->slug ?? '')}}" placeholder=""/>
                            @if($errors->has('slug'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('slug') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="header" class="required">{{ __('Url to the collection') }}</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="url_to_coll" value="{{old('url_to_coll', $nft->url_to_coll ?? '')}}" placeholder=""/>
                            @if($errors->has('url_to_coll'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('url_to_coll') }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="text">{{  __('Description') }} <i class="text-danger">*</i></label>
                        <div class="col-10">
                            <textarea id="textTineMCE" class="text-tine-MCE" name="descr">{{old('descr', $nft->descr ?? '')}}</textarea>
                            @if($errors->has('descr'))
                                <div class="error text-danger font-size-sm">{{ $errors->first('descr') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label"></label>
                        <div class="col-10 col-form-label">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" name="display" value="1" {{ old('display', $nft->display ?? true) ? 'checked' : '' }}/>
                                    <span></span>
                                    @lang('Display')
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-8"></div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">{{  __('Tags') }}</label>
                        <div class="col-10">
                            <input id="kt_tagify" type="text"  class="form-control tagify" name="tags_names" placeholder="type..." value="{{!empty($nft) ? $nft->allTagsIntoStr() : '' }}" autofocus="" data-blacklist="" />
                            <div class="mt-3">
                                <a href="javascript:;" id="kt_tagify_remove" class="btn btn-sm btn-light-primary font-weight-bold">{{  __('Remove tags') }}</a>
                            </div>
                        </div>
                    </div>


                @if (!empty($nft))
                        <div class="separator separator-dashed my-8"></div>
                        <div id="image_container" class="form-group row">
                            @if($nft->getMedia(\App\Models\Nft::_MEDIA_COLLECTION_NAME)->count()>0)
                                @foreach($nft->getMedia(\App\Models\Nft::_MEDIA_COLLECTION_NAME) as $media)
                                    <div class="block-image col-md-4 col-xxl-3 col-lg-3">
                                        <div class="card-body p-0">
                                            <!--begin::Image-->
                                            <div class="overlay">
                                                <div class="overlay-wrapper rounded bg-light text-center">
                                                    <img src="{{ $media->getUrl('thumb300x300') }}" alt="" class="mw-100 w-200px" />
                                                </div>
                                                <div class="overlay-layer">
                                                    <a href="{{ $media->getUrl() }}" class="image-copy-link btn font-weight-bolder btn-sm btn-primary mr-2">Copy link</a>
                                                    <a href="{{ route('content.nft.delete.media', ['nft' => $nft->id, 'media'=>$media->id])  }}" class="image-remove-link btn font-weight-bolder btn-sm btn-light-primary">Delete</a>
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
                        @if(!empty($nft))
                            <button type="reset" class="btn btn-default">{{ __('Cancel') }}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@if (!empty($nft))
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



    @if (!empty($nft))
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js" type="text/javascript"></script>
    {{-- <script src="{{ asset('theme_assets/js/pages/crud/file-upload/dropzonejs.js') }}" type="text/javascript"></script> --}}
    <script>
        // file type validation
        $('#kt_dropzone').dropzone({
            url: "{{ route('content.nft.upload.media', ['nft' => $nft->id]) }}", // Set the url for your upload script location
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

                        let _link_del = '{!! route("content.nft.delete.media",["nft"=>$nft->id, "media"=>':id']) !!}';
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

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        jQuery(document).ready(function() {
            const input = document.getElementById('kt_tagify');
            let tagify = new Tagify(input);
            document.getElementById('kt_tagify_remove').addEventListener('click', tagify.removeAllTags.bind(tagify));
        });
    </script>
@endsection