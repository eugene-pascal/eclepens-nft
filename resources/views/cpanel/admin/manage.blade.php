@extends('layout.default')
@section('title', __('Manage admin account'))
@php
    $title = !empty($employee) ? __('Manage admin account') : __('Add a new admin account');
    $page_breadcrumbs = [
            [
                'page'=>route('employees.list'),
                'title'=> __('The list of administrators')
            ],
            [
                'page'=>url()->current(),
                'title'=>  $title
            ]
        ];
@endphp
@section('content')
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Profile Overview-->
        <div class="d-flex flex-row">
            <!--begin::Aside-->
            <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
                <!--begin::Profile Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::User-->
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label" style="background-image:url('')"></div>
                            </div>
                            <div>
                                <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ $employee->getFullName() }}</a>
                            </div>
                        </div>
                        <!--end::User-->
                        <!--begin::Contact-->
                        <div class="py-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">Email:</span>
                                <a href="#" class="text-muted text-hover-primary">{{ $employee->email }}</a>
                            </div>
                        </div>
                        <!--end::Contact-->
                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">

                            <div class="navi-item mb-2">
                                <a href="{{ route('employees.manage',['employee'=>$employee]) }}" class="navi-link py-4 {{ !app('request')->tab ? 'active' : '' }}">
                                    <span class="navi-icon mr-2">
                                        {{ Metronic::getSVG("media/svg/icons/Clothes/Shirt.svg", "svg-icon-md") }}
                                    </span>
                                    <span class="navi-text font-size-lg">Profile Overview</span>
                                </a>
                            </div>

                            <div class="navi-item mb-2">
                                <a href="{{ route('employees.manage',['employee'=>$employee, 'tab'=>'personal']) }}" class="navi-link py-4 {{app('request')->tab ==='personal' ? 'active' : '' }}">
                                    <span class="navi-icon mr-2">
                                        {{ Metronic::getSVG("media/svg/icons/General/User.svg", "svg-icon-md") }}
                                    </span>
                                    <span class="navi-text font-size-lg">Personal Info</span>
                                </a>
                            </div>

                            <div class="navi-item mb-2">
                                <a href="{{ route('employees.manage',['employee'=>$employee, 'tab'=>'password']) }}" class="navi-link py-4 {{ app('request')->tab ==='password' ? 'active' : '' }}">
                                    <span class="navi-icon mr-2">
                                        {{ Metronic::getSVG("media/svg/icons/General/Shield-check.svg", "svg-icon-md") }}
                                    </span>
                                    <span class="navi-text font-size-lg">Change Password</span>
                                </a>
                            </div>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Profile Card-->
            </div>
            <!--end::Aside-->
            <!--begin::Content-->
            @if (!app('request')->tab)
                @includeIf('cpanel.admin.manage._overview', [])
            @else
                @includeIf('cpanel.admin.manage._'.strtolower(app('request')->tab), [])
            @endif
            <!--end::Content-->
        </div>
        <!--end::Profile Overview-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
@endsection
