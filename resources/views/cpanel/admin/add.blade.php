@extends('layout.default')
@section('title', __('Add a new admin account'))
@php
    $page_breadcrumbs = [
            [
                'page'=>route('employees.list'),
                'title'=> __('The list of administrators')
            ],
            [
                'page'=>url()->current(),
                'title'=>  __('Add a new admin account')
            ]
        ];
@endphp
@section('content')
<!--begin::Card-->
<div class="card card-custom card-transparent">
    <div class="card-body p-0">
        <!--begin::Wizard-->
        <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="true">
            <!--begin::Wizard Nav-->
            <div class="wizard-nav">
                <div class="wizard-steps">
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">1</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Profile</div>
                                <div class="wizard-desc">Account Personal Information</div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-step" data-wizard-type="step">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">2</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Password</div>
                                <div class="wizard-desc">Account credentials</div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-step" data-wizard-type="step">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">3</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Settings</div>
                                <div class="wizard-desc">Personal settings</div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-step" data-wizard-type="step">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">4</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Submission</div>
                                <div class="wizard-desc">Review and Submit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Wizard Nav-->
            <!--begin::Card-->
            <div class="card card-custom card-shadowless rounded-top-0">
                <!--begin::Body-->
                <div class="card-body p-0">
                    <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-10">
                            <!--begin::Wizard Form-->
                            <form method="post" action="{{ route('employees.add') }}" class="form" id="kt_form">
                                @csrf
                                <input type="hidden" name="match_email_url" value="{{ route('match.email') }}">
                                <div class="row justify-content-center">
                                    <div class="col-xl-9">
                                        <!--begin::Wizard Step 1-->
                                        <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                            <h5 class="text-dark font-weight-bold mb-10">{{__('Account personal information')}}</h5>
                                
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="form-control form-control-solid form-control-lg" name="name" type="text" value="" />
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-solid input-group-lg">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-at"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="email" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                        </div>
                                        <!--end::Wizard Step 1-->
                                        <!--begin::Wizard Step 2-->
                                        <div class="my-5 step" data-wizard-type="step-content">
                                            <h5 class="text-dark font-weight-bold mb-10 mt-5">{{__('Account Access Credentials')}}</h5>
                                             <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Password</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="form-control form-control-solid form-control-lg" id="password" name="password" type="password" value="" />
                                                </div>
                                            </div>
                                            <!--end::Group-->

                                             <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">{{__('Password confirmation')}}</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="form-control form-control-solid form-control-lg" name="password_confirmation" type="password" value="" />
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                        </div>
                                        <!--end::Wizard Step 2-->
                                        <!--begin::Wizard Step 3-->
                                        <div class="my-5 step" data-wizard-type="step-content">
                                            <h5 class="mb-10 font-weight-bold text-dark">{{__('Personal Settings')}}</h5>
                                            <div class="form-group row fv-plugins-icon-container">
                                                <label class="col-form-label col-xl-3 col-lg-3">Role</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <select class="form-control form-control-lg form-control-solid" name="role">
                                                        <option value="">-- choose role --</option>
                                                        <option value="administrator" selected>Admin</option>
                                                    </select>
                                                <div class="fv-plugins-message-container"></div></div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Status</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox m-0">
                                                        <input type="checkbox" name="status" checked value="1" />
                                                        <span></span>Uncheck it to make account inactive</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Wizard Step 3-->
                                        <!--begin::Wizard Step 4-->
                                        <div class="my-5 step" data-wizard-type="step-content">
                                            <h5 class="mb-10 font-weight-bold text-dark">Review your entered details and submit</h5>
                                            <!--begin::Item-->
                                            <div class="mb-5 pb-5">
                                                <div class="font-weight-bolder mb-3">Your account details:</div>
                                                <div class="line-height-xl" id="reviewFormData">
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Wizard Step 4-->
                                        <!--begin::Wizard Actions-->
                                        <div class="d-flex justify-content-between border-top pt-10 mt-15">
                                            <div class="mr-2">
                                                <button type="button" id="prev-step" class="btn btn-light-primary font-weight-bolder px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-success font-weight-bolder px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                                <button type="button" id="next-step" class="btn btn-primary font-weight-bolder px-9 py-4" data-wizard-type="action-next">Next</button>
                                            </div>
                                        </div>
                                        <!--end::Wizard Actions-->
                                    </div>
                                </div>
                            </form>
                            <!--end::Wizard Form-->
                        </div>
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Wizard-->
    </div>
</div>
<!--end::Card-->
@endsection
{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('theme_assets/css/pages/wizard/wizard-4.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('theme_assets/js/pages/custom/user/add-acc.js?0') }}" type="text/javascript"></script>
@append
