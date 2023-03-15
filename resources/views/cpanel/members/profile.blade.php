@extends('layout.default')
@section('title', __('Member profile page'))
@php
    $title = __('Member profile page ID:').' '.$member->id;
    $page_breadcrumbs = [
            [
                'page'=> route('members.list'),
                'title'=> __('The list of members')
            ],
            [
                'page'=>url()->current(),
                'title'=> $title
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
                                    <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ $member->getFullName() }}</a>
                                </div>
                            </div>
                            <!--end::User-->
                            <!--begin::Contact-->
                            <div class="py-9">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold mr-2">Email:</span>
                                    <a href="#" class="text-muted text-hover-primary">{{ $member->email }}</a>
                                </div>
                            </div>
                            <!--end::Contact-->
                            <!--begin::Nav-->
                            <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                                <div class="navi-item mb-2">
                                    <a href="{{ route('member.profile',['member'=>$member, 'tab'=>'personal']) }}" class="navi-link py-4 {{ !app('request')->tab || app('request')->tab ==='personal' ? 'active' : '' }}">
                                    <span class="navi-icon mr-2">
                                        {{ Metronic::getSVG("media/svg/icons/General/User.svg", "svg-icon-md") }}
                                    </span>
                                        <span class="navi-text font-size-lg">{{ __('Personal Info') }}</span>
                                    </a>
                                </div>
                                <div class="navi-item mb-2">
                                    <a href="{{ route('member.profile',['member'=>$member, 'tab'=>'password']) }}" class="navi-link py-4 {{ app('request')->tab ==='password' ? 'active' : '' }}">
                                    <span class="navi-icon mr-2">
                                        {{ Metronic::getSVG("media/svg/icons/General/Shield-check.svg", "svg-icon-md") }}
                                    </span>
                                        <span class="navi-text font-size-lg">{{ __('Change Password') }}</span>
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
                    @includeIf('cpanel.members.profile._personal', [])
                @else
                    @includeIf('cpanel.members.profile._'.strtolower(app('request')->tab), [])
                @endif
            <!--end::Content-->
            </div>
            <!--end::Profile Overview-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
{{-- Scripts Section --}}
@section('scripts')
    <script>
        jQuery(document).ready(function() {
            $('#validity_datepicker').datetimepicker({
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-arrow-up',
                    down: 'fa fa-arrow-down',
                    previous: 'fa fa-arrow-left',
                    next: 'fa fa-arrow-right',
                },
                format: 'YYYY-MM-DD',
            });
            $('#start_datepicker').datetimepicker({
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-arrow-up',
                    down: 'fa fa-arrow-down',
                    previous: 'fa fa-arrow-left',
                    next: 'fa fa-arrow-right',
                },
                format: 'YYYY-MM-DD',
            });
        });
    </script>
@append