@extends('layout.default')
@section('title', __('Categories'))
@php
    $page_breadcrumbs = [
            [
                'page'=>url()->current(),
                'title'=> __('List of categories')
            ]
        ];
@endphp
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    @lang('Sites')
                    <div class="text-muted pt-2 font-size-sm"></div>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('content.article.category.add') }}" class="btn btn-light-primary font-weight-normal">
                    {{ Metronic::getSVG("media/svg/icons/Design/Flatten.svg", "svg-icon-md") }}
                    @lang('Add a new category')
                </a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">@lang('Status'):</label>
                                    <select class="form-control" id="kt_datatable_search_status">
                                        <option value="">@lang('All')</option>
                                        <option value="1">@lang('Active')</option>
                                        <option value="0">@lang('Inactive')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
    </div>
@endsection
{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
@append
{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        var HOST_URL = "{{ route('ktdatatable.content.articles.categories.list') }}";
    </script>

    <script>
        window.datatable = {};
        var KTDatatableRemoteAjax = function() {
            var pad = function(number) {
                if (number < 10) {
                    return '0' + number;
                }
                return number;
            }
            var start = function() {
                var dtConfig = {
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: HOST_URL,
                                // sample custom headers
                                headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
                                map: function(raw) {
                                    // sample data mapping
                                    var dataSet = raw;
                                    if (typeof raw.data !== 'undefined') {
                                        dataSet = raw.data;
                                    }
                                    return dataSet;
                                },
                            },
                        },
                        pageSize: 50,
                        saveState: false,
                        serverPaging: true,
                        serverFiltering: true,
                        serverSorting: true,
                    },
                    // layout definition
                    layout: {
                        scroll: false,
                        footer: false,
                    },

                    // column sorting
                    sortable: true,

                    pagination: true,

                    search: {
                        input: $('#kt_datatable_search_query'),
                        key: 'query_search'
                    },
                    // columns definition
                    columns: [{
                        field: 'prior',
                        title: 'Prior',
                        sortable: 'asc',
                        width: 75,
                        type: 'number',
                        selector: false,
                        textAlign: 'center',
                        template: function(row) {
                            return '<div class="text-dark font-weight-bolder d-block font-size-sm">' + row.prior + '</div>';
                        },
                    }, {
                        field: 'name',
                        title: 'Name',
                        width: 250,
                        template: function(row) {
                            return '<div class="text-dark-75 font-weight-bolder d-block font-size-sm">' + row.name + '</div>';
                        },
                    }, {
                        field: 'status',
                        title: 'Status',
                        width: 75,
                        template: function(row) {
                            if (typeof row.is_active !== 'undefined' && row.is_active == 1) {
                                return '<i class="fa fa-check text-success"></i>';
                            }
                            return '<i class="fa fa-times text-danger"></i>';
                        },
                    }, {
                        field: 'created_at',
                        title: 'Created',
                        type: 'date',
                        width: 75,
                        format: 'MM/DD/YYYY HH:ii',
                        template: function(row) {
                            var dt = new Date(row.created_at);
                            return '<span class="font-size-sm text-dark-75">'
                                + dt.getUTCFullYear() +
                                '-' + pad(dt.getUTCMonth() + 1) +
                                '-' + pad(dt.getUTCDate()) +
                                ' ' + pad(dt.getUTCHours()) +
                                ':' + pad(dt.getUTCMinutes()) +
                                ':' + pad(dt.getUTCSeconds()) + '</span>';
                        },
                    }, {
                        field: 'actions',
                        title: 'Actions',
                        sortable: false,
                        width: 155,
                        overflow: 'visible',
                        autoHide: false,
                        template: function(row) {
                            let _link = '{!! route("content.article.category.edit",["category"=>':id']) !!}';
                            _link = _link.replace(':id', row.id);
                            let _link_move_up = '';
                            if (row.prev !== null) {
                                _link_move_up = '{!! route("content.article.category.move",["direction"=>'up',"ids"=>":ids"]) !!}';
                                _link_move_up = _link_move_up.replace(':ids', row.prior + '-' + row.prev.prior);
                            }
                            let _link_move_down = '';
                            if (row.next !== null) {
                                _link_move_down = '{!! route("content.article.category.move",["direction"=>'down',"ids"=>":ids"]) !!}';
                                _link_move_down = _link_move_down.replace(':ids', row.prior + '-' + row.next.prior);
                            }

                            return '\
                                <a href="'+ _link +'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">\
                                    <span class="svg-icon svg-icon-md">\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                                <rect x="0" y="0" width="24" height="24"/>\
                                                <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>\
                                                <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                            </g>\
                                        </svg>\
                                    </span>\
                                </a>\
                                <a href="'+ _link +'" class="btn btn-sm btn-clean btn-icon btn-remove-request" title="Delete">\
                                    <span class="svg-icon svg-icon-md">\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                                <rect x="0" y="0" width="24" height="24"/>\
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
                                            </g>\
                                        </svg>\
                                    </span>\
                                </a>\
                                <a href="'+ _link_move_down +'" class="btn btn-sm btn-clean btn-icon btn-move-request'+ (_link_move_down === '' ? ' disabled' : '') +'" title="Move down" data-message="Category will be down !">\
                                    <span class="svg-icon svg-icon-md">\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                            <polygon points="0 0 24 0 24 24 0 24"/>\
                                            <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"/>\
                                            <path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999) "/>\
                                            </g>\
                                        </svg>\
                                    </span>\
                                </a>\
                                <a href="'+ _link_move_up +'" class="btn btn-sm btn-clean btn-icon btn-move-request'+ (_link_move_up === '' ? ' disabled' : '') +'" title="Move up" data-message="Category will be up !">\
                                    <span class="svg-icon svg-icon-md">\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                            <polygon points="0 0 24 0 24 24 0 24"/>\
                                            <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"/>\
                                            <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"/>\
                                            </g>\
                                        </svg>\
                                    </span>\
                                </a>\
                            ';
                        },
                    }],
                };

                window.datatable = $('#kt_datatable').KTDatatable(dtConfig);

                $('#kt_datatable_search_status').on('change', function() {
                    window.datatable.search($(this).val().toLowerCase(), 'display');
                });

                window.datatable.on('datatable-on-init', function (event,options) {
                    // event on init datatable
                });

                $('#kt_datatable_search_status').selectpicker();
            };

            return {
                // public functions
                init: function() {
                    start();
                },
            };
        }();

        function actionRemoveMember() {
            let _confirmed = false;
            $(document).on('click', '.btn-remove-request', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let _btn = $(this),
                    _token = '{{ csrf_token() }}',
                    _msg = $(this).data('message'),
                    _confirmBtnName = $(this).data('btn-name');

                if(_btn.hasClass('disabled')) {
                    return false;
                }
                _btn.addClass('disabled');

                swal(
                    {
                        title: 'Are you sure?',
                        text: (_msg ?? 'Item will be removed !' ),
                        type: 'warning',
                        showCancelButton: true,
                        cancelButtonClass: 'btn-light',
                        confirmButtonClass: 'btn-success',
                        confirmButtonText: (_confirmBtnName ?? 'Confirm')
                    },
                    function() {
                        $.post(_btn.attr('href'), {_method: 'delete', _token})
                            .done(function() {
                                $.notify(
                                    {
                                        title: '<strong>Success:</strong>',
                                        message: 'The record successfully removed'
                                    },
                                    {
                                        type: 'success'
                                    },
                                );

                                _btn.closest('tr').slideUp('low', function () {
                                    $(this).remove();
                                });
                            })
                            .fail(function() {
                                $.notify(
                                    {
                                        title: '<strong>Error:</strong>',
                                        message: 'Failed to remove the record'
                                    },
                                    {
                                        type: 'danger'
                                    },
                                )
                            });
                    }
                );
                _btn.removeClass('disabled');
            });
        }

        function actionMoveItems() {
            let _confirmed = false;
            $(document).on('click', '.btn-move-request', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let _btn = $(this),
                    _token = '{{ csrf_token() }}',
                    _msg = $(this).data('message'),
                    _confirmBtnName = $(this).data('btn-name');

                if(_btn.hasClass('disabled')) {
                    return false;
                }
                _btn.addClass('disabled');

                swal(
                    {
                        title: 'Are you sure?',
                        text: (_msg ?? 'Item will be moved !' ),
                        type: 'warning',
                        showCancelButton: true,
                        cancelButtonClass: 'btn-light',
                        confirmButtonClass: 'btn-success',
                        confirmButtonText: (_confirmBtnName ?? 'Confirm')
                    },
                    function() {
                        $.post(_btn.attr('href'), {_method: 'put', _token})
                            .done(function() {
                                $.notify(
                                    {
                                        title: '<strong>Success:</strong>',
                                        message: 'The category successfully moved'
                                    },
                                    {
                                        type: 'success'
                                    },
                                );

                                window.datatable.reload();
                            })
                            .fail(function() {
                                $.notify(
                                    {
                                        title: '<strong>Error:</strong>',
                                        message: 'Failed to move the record'
                                    },
                                    {
                                        type: 'danger'
                                    },
                                )
                            });
                    }
                );
                _btn.removeClass('disabled');
            });
        }

        jQuery(document).ready(function() {
            actionRemoveMember();
            actionMoveItems();
            KTDatatableRemoteAjax.init();
        });
    </script>
@endsection

