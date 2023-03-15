@extends('layout.default')
@section('title',  __('Manage language'))
@php
    $page_breadcrumbs = [
        [
            'page'=>route('settings.languages'),
            'title'=> __('Languages')
        ],
        [
            'page'=>url()->current(),
            'title'=> __('Manage language')
        ]
    ];
@endphp
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                <strong>{{ __('Manage language') }}</strong>
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ empty($lang) ? route('settings.language.add') : route('settings.language.edit', ['lang' => $lang->id]) }}">
                @csrf
                @if(!empty($lang))
                    @method('PUT')
                @endif

                @if (!empty($lang))
                    <input type="hidden" name="sort" value="{{ $lang->sort }}">
                @endif

                @include('pages.widgets._alert_both_success_error', [])

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control form-control-lg form-control-solid" name="lang_name" value="{{old('lang_name', $lang->lang_name ?? '')}}" id="name" placeholder="Menu name"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 row mb-10">
                            <label class="col-3 col-form-label text-right" for="name" class="required">Language</label>
                            <div class="col-9">
                                <select id="languageSelect" class="form-control form-control-lg form-control-solid is-valid" name="lang_code">
                                    <option value="">Select Language...</option>
                                    <option value="en">English</option>
                                    <option value="id">Bahasa Indonesia - Indonesian</option>
                                    <option value="msa">Bahasa Melayu - Malay</option>
                                    <option value="ca">Català - Catalan</option>
                                    <option value="cs">Čeština - Czech</option>
                                    <option value="da">Dansk - Danish</option>
                                    <option value="de">Deutsch - German</option>
                                    <option value="en-gb">English UK - British English</option>
                                    <option value="es">Español - Spanish</option>
                                    <option value="eu">Euskara - Basque (beta)</option>
                                    <option value="fil">Filipino</option>
                                    <option value="fr">Français - French</option>
                                    <option value="ga">Gaeilge - Irish (beta)</option>
                                    <option value="gl">Galego - Galician (beta)</option>
                                    <option value="hr">Hrvatski - Croatian</option>
                                    <option value="it">Italiano - Italian</option>
                                    <option value="hu">Magyar - Hungarian</option>
                                    <option value="nl">Nederlands - Dutch</option>
                                    <option value="no">Norsk - Norwegian</option>
                                    <option value="pl">Polski - Polish</option>
                                    <option value="pt">Português - Portuguese</option>
                                    <option value="ro">Română - Romanian</option>
                                    <option value="sk">Slovenčina - Slovak</option>
                                    <option value="fi">Suomi - Finnish</option>
                                    <option value="sv">Svenska - Swedish</option>
                                    <option value="vi">Tiếng Việt - Vietnamese</option>
                                    <option value="tr">Türkçe - Turkish</option>
                                    <option value="el">Ελληνικά - Greek</option>
                                    <option value="bg">Български език - Bulgarian</option>
                                    <option value="ru">Русский - Russian</option>
                                    <option value="sr">Српски - Serbian</option>
                                    <option value="uk">Українська мова - Ukrainian</option>
                                    <option value="he">עִבְרִית - Hebrew</option>
                                    <option value="ur">اردو - Urdu (beta)</option>
                                    <option value="ar">العربية - Arabic</option>
                                    <option value="fa">فارسی - Persian</option>
                                    <option value="mr">मराठी - Marathi</option>
                                    <option value="hi">हिन्दी - Hindi</option>
                                    <option value="bn">বাংলা - Bangla</option>
                                    <option value="gu">ગુજરાતી - Gujarati</option>
                                    <option value="ta">தமிழ் - Tamil</option>
                                    <option value="kn">ಕನ್ನಡ - Kannada</option>
                                    <option value="th">ภาษาไทย - Thai</option>
                                    <option value="ko">한국어 - Korean</option>
                                    <option value="ja">日本語 - Japanese</option>
                                    <option value="zh-cn">简体中文 - Simplified Chinese</option>
                                    <option value="zh-tw">繁體中文 - Traditional Chinese</option>
                                </select>
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
                                           {{ !old('is_active', $lang->is_active ?? false) ? '' : 'checked="checked"' }}>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn width-200 btn-primary">Update</button>
                    @if(!empty($lang))
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
                    @if (isset($lang->lang_code))
                    setOptionSelectedByVal('{{ $lang->lang_code }}')
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