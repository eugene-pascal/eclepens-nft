@extends('layout.default')
@section('title', __('The list of profits'))
@php
    $page_breadcrumbs = [
            [
                'page'=>url()->current(),
                'title'=> __('The list of profits')
            ]
        ];
@endphp
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    @lang('Profits')
                    <div class="text-muted pt-2 font-size-sm">
                        @lang('Data comes from API with request :url', ['url'=>'<span class="text-info">https://mamig.com/api/cryptotrading/v1/profits/</span>'])
                    </div>
                </h3>
            </div>
            <div class="card-toolbar">
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


{{-- Scripts Section --}}
@section('scripts')

    <script>
        var HOST_URL = "{{ route('ktdatatable.statistic.api.profits.list') }}";
    </script>

    <script>
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
                        pageSize: 20,
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
                        field: 'day',
                        title: 'Day',
                        width: 150,
                        overflow: 'visible',
                        autoHide: false,
                        template: function(row) {
                            return '<div class="text-dark-75 font-weight-bolder d-block font-size-sm">' + row.day + '</div>';
                        },
                    }, {
                        field: 'profit',
                        title: 'Profit',
                        // visible: !1,
                        width: 150,
                        overflow: 'visible',
                        autoHide: false,
                        template: function(row) {
                            return '<span class="text-primary font-weight-bolder font-size-sm">' + row.profit + '</span>';
                        },
                    }, {
                        field: 'strategy',
                        title: 'Strategy',
                        width: 150,
                        overflow: 'visible',
                        autoHide: false,
                        template: function(row) {
                            return '<span class="badge badge-warning badge-sm">' + row.strategy + '</span>';
                        },
                    }],
                };

                var datatable = $('#kt_datatable').KTDatatable(dtConfig);

                $('#kt_datatable_search_status').on('change', function() {
                    datatable.search($(this).val().toLowerCase(), 'verified');
                });

                datatable.on('datatable-on-init', function (event,options) {
                    // event on init datatable
                });

                $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
            };

            return {
                // public functions
                init: function() {
                    start();
                },
            };
        }();

        jQuery(document).ready(function() {
            KTDatatableRemoteAjax.init();
        });
    </script>
@endsection

