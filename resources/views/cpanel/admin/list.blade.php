@extends('layout.default')
@section('title', __('The list of administrators'))
@php
    $page_breadcrumbs = [
            [
                'page'=>url()->current(),
                'title'=> __('The list of administrators')
            ]
        ];
@endphp
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    @lang('Administrators')
                    <div class="text-muted pt-2 font-size-sm"></div>
                </h3>
            </div>
            <div class="card-toolbar">
            <a href="{{ route('employees.add') }}" class="btn btn-outline-primary font-weight-bolder">
                {{ Metronic::getSVG("media/svg/icons/Communication/Add-user.svg", "svg-icon-md") }}
                {{__('Add a new admin account')}}
            </a>
        </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if ($employeesList->count())
                <form id="formListEmployees" action="#">
                    @csrf
                    <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                        <thead>
                        <tr class="text-left text-uppercase">
                            <th style="min-width: 100px"><span class="text-muted">{{__('Name')}}</span></th>
                            <th style="min-width: 100px"><span class="text-muted">{{__('Email')}}</span></th>
                            <th style="min-width: 100px"><span class="text-muted">{{__('Status')}}</span></th>
                            <th style="min-width: 100px"><span class="text-muted">{{__('Action')}}</span></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeesList->items() as $employee)
                               <tr class="row-line">
                                    <td>
                                        <span class="font-weight-bold font-size-sm text-dark mb-0">
                                            {{ $employee->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-normal font-size-sm text-primary mb-0">
                                            {{ $employee->email }}
                                        </span>
                                    </td>
                                    <td>
                                         <span class="label label-md font-weight-bold label-inline label-{{ $employee->status == $constants::ACTIVE ? 'success' : 'warning' }}">
                                            {{ $employee->status == $constants::ACTIVE ? __('Active') : __('Inactive') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('employees.manage', ['employee'=>$employee]) }}" class="btn btn-sm btn-light-success btn-sm" data-toggle="tooltip" data-theme="dark" title="edit method">
                                            <i class="flaticon-edit"></i>
                                        </a>
                                        <a href="{{ route('employees.delete', ['employee'=>$employee]) }}"
                                            data-message="employee account will be removed !" 
                                            class="btn btn-sm btn-light-danger btn-sm btn-remove-employee">
                                                <i class="flaticon2-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                @include('pages.widgets._paginator', ['paginator' => $employeesList])
                @else
                    <p class="text-dark">There is no data</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@include('pages.widgets._sweetalter-on-remove', [
        'clickId'=>'.btn-remove-employee', 
        'parentId'=>'.row-line'
    ])