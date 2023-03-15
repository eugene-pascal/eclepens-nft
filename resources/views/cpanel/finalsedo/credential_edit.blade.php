@extends('layout.default')
@section('title',  __('Manage the credential'))
@php
    $page_breadcrumbs = [
        [
            'page'=>route('finalsedo.credentials.list'),
            'title'=> __('The list of credentials to FinalSedo accounts')
        ],
        [
            'page'=>url()->current(),
            'title'=> __('Manage the credential')
        ]
    ];
@endphp
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                <strong>{{ __('Manage the credential') }}</strong>
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ empty($credential) ? route('finalsedo.credential.add') : route('finalsedo.credential.edit', ['credential' => $credential->id]) }}">
                @csrf
                @if(!empty($credential))
                    @method('PUT')
                @endif

                @include('pages.widgets._alert_both_success_error', [])

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">Username</label>
                            <div class="col-9">
                                <input type="text" class="form-control form-control-lg form-control-solid" name="username" value="{{old('username', $credential->username ?? '')}}" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">Password</label>
                            <div class="col-9">
                                <input type="text" class="form-control form-control-lg form-control-solid" name="password" value="{{old('password', $credential->password ?? '')}}" placeholder=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">Partner ID</label>
                            <div class="col-9">
                                <input type="text" class="form-control form-control-lg form-control-solid" name="partnerid" value="{{old('partnerid', $credential->partnerid ?? '')}}" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">Sign key</label>
                            <div class="col-9">
                                <input type="text" class="form-control form-control-lg form-control-solid" name="signkey" value="{{old('signkey', $credential->signkey ?? '')}}" placeholder=""/>
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
                                           {{ !old('is_active', $credential->is_active ?? false) ? '' : 'checked="checked"' }}>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn width-200 btn-primary">Update</button>
                    @if(!empty($credential))
                        <button type="reset" class="btn btn-default">Cancel</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const controlActions = function() {
            var handleActions = function() {
                $(document).on('change', '#languageSelect', function(e) {
                    e.preventDefault();
                    let _this = $(this);
                    let _lang_name = _this.find('option:selected').text();
                    let _form = _this.closest('form');
                    let _name_field = _form.find('input[name=lang_name]');
                    if (typeof _name_field === 'object' && _name_field.val().length === 0) {
                        _name_field.val( _this.find('option:selected').text() );
                    }
                });
            };

            var setOptionSelectedByVal = function(val) {
                $('#languageSelect option').filter(function() {
                    return ($(this).val() == val);
                }).prop('selected', true);
            };
            return {
                // public functions
                init: function() {
                    handleActions();
                    @if (isset($credential->lang_code))
                    setOptionSelectedByVal('{{ $credential->lang_code }}')
                    @endif
                },
            };
        }();

        $(function() {
            controlActions.init();
        });
    </script>
    {{-- end::Page Scripts(used by this page) --}}
@append