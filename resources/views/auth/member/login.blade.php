@extends('layout.member.login')
@section('title', __('Login area'))
@section('content')
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-cadetblue" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #c9f7f4;">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">

                <!--begin::Aside header-->
                <a href="#" class="text-center mb-10">
                    <img src="{{ asset('theme_assets/media/logos/logo.svg') }}" class="max-h-70px" alt="" />
                </a>
                <!--end::Aside header-->
                @if(true)
                <!--begin::Aside title-->
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg">
                    Discover Amazing
                    <br />IamAffiliate Report Platform
                    <br />with great build tools
                </h3>
                <!--end::Aside title-->
                @endif
            </div>
            <!--end::Aside Top-->
            @if(true)
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url({{ asset('theme_assets/media/bg/morgan.svg') }}); background-size:contain;"></div>
            <!--end::Aside Bottom-->
            @endif

        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signin_form"  method="POST" action="{{ route('member.login') }}">
                        @csrf
                        <input name="_member" type="hidden" value="1">
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">@lang('Account login')</h3>
                            <span class="text-dark75 font-weight-bold font-size-h4">
                                @lang('New Here?')
                                <a href="javascript:;" id="kt_login_signup" class="text-light-info text-hover-white font-weight-bolder">@lang('Create an Account')</a>
                            </span>
                            @if (true && session()->get('successOnCreate') === true)
                                <div class="alert alert-warning mt-5" role="alert">
                                    @lang('Your account has been created ! Please check inbox of your email address in order to confirm registration.')
                                </div>
                            @endif
                            @if (true && session()->get('successOnEmailValidated') === true)
                                <div class="alert alert-success mt-5" role="alert">
                                    @lang('Your email has been confirmed ! Use your email and password to login to member area below')
                                </div>
                            @endif
                            @if (true && session()->get('successOnResetPassword') === true)
                                <div class="alert alert-info mt-5" role="alert">
                                    @lang('You reset your password ! Please check your mailbox.')
                                </div>
                            @endif
                        </div>
                        <!--begin::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                            <input id="email" type="email"  class="form-control form-control-solid h-auto py-6 px-6 rounded-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="off"/>
                            @if ($errors->has('email'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">@lang('Password')</label>
                                <a href="javascript:;" class="font-size-h6 font-weight-bolder text-light-info text-hover-white pt-5" id="kt_login_forgot">@lang('Forgot Password ?')</a>
                            </div>
                            <input id="password" type="password" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required />
                            @if ($errors->has('password'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="button" id="kt_login_signin_submit" class="btn btn-info font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">@lang('Sign In')</button>
                            @if(false)
                            <button type="button" class="btn btn-light-info font-weight-bolder px-8 py-4 my-3 font-size-lg">
									<span class="svg-icon svg-icon-md">
										<!--begin::Svg Icon | path:assets/media/svg/social-icons/google.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
											<path d="M19.9895 10.1871C19.9895 9.36767 19.9214 8.76973 19.7742 8.14966H10.1992V11.848H15.8195C15.7062 12.7671 15.0943 14.1512 13.7346 15.0813L13.7155 15.2051L16.7429 17.4969L16.9527 17.5174C18.879 15.7789 19.9895 13.221 19.9895 10.1871Z" fill="#4285F4" />
											<path d="M10.1993 19.9313C12.9527 19.9313 15.2643 19.0454 16.9527 17.5174L13.7346 15.0813C12.8734 15.6682 11.7176 16.0779 10.1993 16.0779C7.50243 16.0779 5.21352 14.3395 4.39759 11.9366L4.27799 11.9466L1.13003 14.3273L1.08887 14.4391C2.76588 17.6945 6.21061 19.9313 10.1993 19.9313Z" fill="#34A853" />
											<path d="M4.39748 11.9366C4.18219 11.3166 4.05759 10.6521 4.05759 9.96565C4.05759 9.27909 4.18219 8.61473 4.38615 7.99466L4.38045 7.8626L1.19304 5.44366L1.08875 5.49214C0.397576 6.84305 0.000976562 8.36008 0.000976562 9.96565C0.000976562 11.5712 0.397576 13.0882 1.08875 14.4391L4.39748 11.9366Z" fill="#FBBC05" />
											<path d="M10.1993 3.85336C12.1142 3.85336 13.406 4.66168 14.1425 5.33717L17.0207 2.59107C15.253 0.985496 12.9527 0 10.1993 0C6.2106 0 2.76588 2.23672 1.08887 5.49214L4.38626 7.99466C5.21352 5.59183 7.50242 3.85336 10.1993 3.85336Z" fill="#EB4335" />
										</svg>
                                        <!--end::Svg Icon-->
									</span>@lang('Sign in with Google')</button>
                            @endif
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
                <!--begin::Signup-->
                <div class="login-form login-signup">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signup_form" method="POST" action="{{ route('member.create') }}">
                        @csrf
                        <input type="hidden" name="match_email_url" value="{{ route('match.member.email') }}">
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">@lang('Sign Up')</h3>
                            <p class="text-dark75 font-weight-bold font-size-h4">@lang('Enter your details to create your account')</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" type="text" placeholder="Username" name="name" autocomplete="off" />
                            @if ($errors->has('name'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6{{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="{{ old('first_name') }}"  type="text" placeholder="First name" name="first_name" autocomplete="off" />
                            @if ($errors->has('first_name'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name') }}"  type="text" placeholder="Last name" name="last_name" autocomplete="off" />
                            @if ($errors->has('last_name'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('last_name') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"  type="email" placeholder="Email" name="email" autocomplete="off" />
                            @if ($errors->has('email'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6{{ $errors->has('password') ? ' is-invalid' : '' }}"  type="password" placeholder="Password" name="password" autocomplete="off" />
                            @if ($errors->has('password'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6{{ $errors->has('cpassword') ? ' is-invalid' : '' }}"  type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            @foreach(\App\Enums\MemberTypeAccount::list() as $typeAccKey => $typeAccVal)
                                <input id="typeAccount{{ $typeAccKey }}" type="radio" name="type_account" value="{{ $typeAccKey }}" {{  $typeAccKey === 'member' ? 'checked' : '' }}>
                                <label class="font-size-h3-xxl font-weight-bolder text-white" for="typeAccount{{ $typeAccKey }}" style="margin-right: 20px;">{{ $typeAccVal }}</label>
                            @endforeach
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="checkbox mb-0">
                                <input type="checkbox" name="agree" />
                                <span></span>
                                <div class="ml-2">I Agree the
                                    <a href="#" class="text-white text-hover-white">terms and conditions</a>.</div>
                            </label>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
                            <button type="button" id="kt_login_signup_submit" class="btn btn-info font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">@lang('Submit')</button>
                            <button type="button" id="kt_login_signup_cancel" class="btn btn-light-info font-weight-bolder font-size-h6 px-8 py-4 my-3">@lang('Cancel')</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signup-->
                <!--begin::Forgot-->
                <div class="login-form login-forgot">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_forgot_form" method="POST" action="{{ route('member.forgot') }}">
                        @csrf
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">@lang('Forgotten Password ?')</h3>
                            <p class="text-dark75 font-weight-bold font-size-h4">@lang('Enter your email to reset your password')</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6{{ $errors->has('password') ? ' is-invalid' : '' }}" type="email" placeholder="Email" name="email" autocomplete="off" />
                            @if ($errors->has('email'))
                                <span class="text-danger invalid-feedback">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                            <button type="button" id="kt_login_forgot_submit" class="btn btn-info font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">@lang('Submit')</button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-info font-weight-bolder font-size-h6 px-8 py-4 my-3">@lang('Cancel')</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->
            </div>
            <!--end::Content body-->
            <!--begin::Content footer-->
            <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                <div class="text-dark-50  font-weight-bold mr-5">
                    <span class="mr-1 text-dark-75">&copy; 2022</span>
                    <span class="text-dark-75">{{ env('APP_NAME') }}</span>
                </div>
            </div>
            <!--end::Content footer-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
@endsection
{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script>
        // Class Definition
        var formsTabSwitch = function() {
            var _login;
            var _showForm = function(form) {
                var cls = 'login-' + form + '-on';
                var form = 'kt_login_' + form + '_form';

                _login.removeClass('login-forgot-on');
                _login.removeClass('login-signin-on');
                _login.removeClass('login-signup-on');

                _login.addClass(cls);

                KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
            }
            var getSearchParameters = function() {
                let prmstr = window.location.search.substr(1);
                return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
            }
            var transformToAssocArray = function(prmstr) {
                let params = {};
                let prmarr = prmstr.split("&");
                for (var i = 0; i < prmarr.length; i++) {
                    var tmparr = prmarr[i].split("=");
                    params[tmparr[0]] = tmparr[1];
                }
                return params;
            }
            var _handleAction = function() {
                let params = getSearchParameters();
                if (typeof params.tab === 'string' && ('signup' === params.tab||'forgot' === params.tab||'signin' === params.tab)) {
                    _showForm(params.tab);
                }
            }
            // Public Functions
            return {
                // public functions
                init: function() {
                    _login = $('#kt_login');
                    _handleAction();
                }
            };
        }();
        // Class Initialization
        jQuery(document).ready(function() {
            formsTabSwitch.init();
        });
    </script>
@append

