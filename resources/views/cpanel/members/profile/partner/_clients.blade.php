<div class="flex-row-fluid ml-lg-8">
    <!--begin::Card-->
    <div class="card card-custom card-stretch">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    @lang('Clients of partner')
                    <div class="text-muted pt-2 font-size-sm"></div>
                </h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <!--begin::Body-->
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            <!--end: Datatable-->
        </div>
        <!--end::Body-->
    </div>
</div>
{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
@append
{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        var HOST_URL = "{{ route('ktdatatable.partner-by-id.list.members', ['member'=>$member]) }}";
        var USER_TYPE = 'user';
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
                        field: 'id',
                        title: '#',
                        sortable: 'desc',
                        width: 75,
                        type: 'number',
                        selector: false,
                        textAlign: 'center',
                    }, {
                        field: 'partner_conn.approved',
                        title: 'Approved by admin',
                        width: 75,
                        template: function(row) {
                            if (typeof row.partner_conn === 'object' && typeof row.partner_conn.approved !== 'undefined') {
                                if (row.partner_conn.approved) {
                                    return '<i class="fa fa-check text-success"></i>';
                                } else {
                                    return '<i class="fa fa-times text-danger"></i>';
                                }
                            }
                        },
                    },{
                        field: 'name',
                        title: 'Username',
                        width: 150,
                        template: function(row) {
                            return '<div class="text-dark-75 font-weight-bolder d-block font-size-sm">' + row.name + '</div>\
                            <span class="text-muted font-weight-bold text-hover-primary">' + row.fullname + '</span>';
                        },
                    }, {
                        field: 'email',
                        title: 'Email',
                        // visible: !1,
                        width: 150,
                        template: function(row) {
                            return '<span class="text-primary font-weight-normal font-size-sm">' + row.email + '</span>';
                        },
                    }, {
                        field: 'status',
                        title: 'Status',
                        width: 75,
                        template: function(row) {
                            if (typeof row.status !== 'undefined' && row.status == 1) {
                                return '<i class="fa fa-check text-success"></i>';
                            }
                            return '<i class="fa fa-times text-danger"></i>';
                        },
                    }, {
                        field: 'partner_conn.created_at',
                        title: 'Date request',
                        type: 'date',
                        format: 'MM/DD/YYYY HH:ii',
                        template: function(row) {
                            if (typeof row.partner_conn !== 'object' || typeof row.partner_conn.created_at === 'undefined') {
                                return '';
                            }
                            return '<span class="font-size-sm text-dark-50">'
                                + row.partner_conn.created_at + '</span>';
                        },
                    }, {
                        field: 'actions',
                        title: 'Actions',
                        sortable: false,
                        width: 120,
                        overflow: 'visible',
                        autoHide: false,
                        template: function(row) {
                            var _link_edit_member = '{!! route("member.profile",["member"=>':id']) !!}';
                            _link_edit_member = _link_edit_member.replace(':id', row.id);
                            var _link_del_conn = '{!! route("partner.member.profile",["member"=>':id']) !!}';
                            _link_del_conn = _link_del_conn.replace(':id', row.id);
                            return '\
                                <a href="'+ _link_del_conn +'" class="btn btn-sm btn-clean btn-icon mr-2 btn-approve-request" title="approve/decline">\
                                    <span class="svg-icon svg-icon-md">\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                                <rect x="0" y="0" width="24" height="24"/>\
                                                <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>\
                                            </g>\
                                        </svg>\
                                    </span>\
                                </a>\
                                <a href="'+ _link_edit_member +'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">\
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
                                <a href="'+ _link_del_conn +'" class="btn btn-sm btn-clean btn-icon btn-remove-request" title="Delete" data-message="Connection between partner and client will be removed !">\
                                    <span class="svg-icon svg-icon-md">\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                                <rect x="0" y="0" width="24" height="24"/>\
                                                <path d="M4.5,3 L19.5,3 C20.3284271,3 21,3.67157288 21,4.5 L21,19.5 C21,20.3284271 20.3284271,21 19.5,21 L4.5,21 C3.67157288,21 3,20.3284271 3,19.5 L3,4.5 C3,3.67157288 3.67157288,3 4.5,3 Z M8,5 C7.44771525,5 7,5.44771525 7,6 C7,6.55228475 7.44771525,7 8,7 L16,7 C16.5522847,7 17,6.55228475 17,6 C17,5.44771525 16.5522847,5 16,5 L8,5 Z M10.5857864,14 L9.17157288,15.4142136 C8.78104858,15.8047379 8.78104858,16.4379028 9.17157288,16.8284271 C9.56209717,17.2189514 10.1952621,17.2189514 10.5857864,16.8284271 L12,15.4142136 L13.4142136,16.8284271 C13.8047379,17.2189514 14.4379028,17.2189514 14.8284271,16.8284271 C15.2189514,16.4379028 15.2189514,15.8047379 14.8284271,15.4142136 L13.4142136,14 L14.8284271,12.5857864 C15.2189514,12.1952621 15.2189514,11.5620972 14.8284271,11.1715729 C14.4379028,10.7810486 13.8047379,10.7810486 13.4142136,11.1715729 L12,12.5857864 L10.5857864,11.1715729 C10.1952621,10.7810486 9.56209717,10.7810486 9.17157288,11.1715729 C8.78104858,11.5620972 8.78104858,12.1952621 9.17157288,12.5857864 L10.5857864,14 Z" fill="#000000"/>\
                                            </g>\
                                        </svg>\
                                    </span>\
                                </a>\
                            ';
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

        function actionRemoveMember() {
            let _confirmed = false;
            $(document).on('click', '.btn-approve-request', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let _btn = $(this),
                    _token = '{{ csrf_token() }}',
                    _msg = $(this).data('message'),
                    _confirmBtnName = $(this).data('btn-name');

                if(_btn.hasClass('disabled')) {
                    return false;
                }
                swal(
                    {
                        title: 'Are you sure?',
                        text: (_msg ?? 'Status will be updated !' ),
                        type: 'warning',
                        showCancelButton: true,
                        cancelButtonClass: 'btn-light',
                        confirmButtonClass: 'btn-success',
                        confirmButtonText: (_confirmBtnName ?? 'Confirm')
                    },
                    function() {
                        $.post(_btn.attr('href'), {_method: 'put', _token})
                            .done(function(response) {
                                $.notify(
                                    {
                                        title: '<strong>Success:</strong>',
                                        message: response.message ?? 'The record successfully updated'
                                    },
                                    {
                                        type: 'success'
                                    },
                                );

                                _btn.closest('tr').find('td').each(function (i) {
                                    if ($(this).data('field') === 'partner_conn.approved') {
                                        $(this).find('i.fa')
                                            .removeClass('fa-times text-danger')
                                            .removeClass('fa-check text-success')
                                            .addClass( response.approved ? 'fa-check text-success' : 'fa-times text-danger')
                                    }
                                });
                            })
                            .fail(function() {
                                $.notify(
                                    {
                                        title: '<strong>Error:</strong>',
                                        message: 'Failed during update the record'
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
                                        message: 'The record successfully updated'
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
                                        message: 'Failed during update the record'
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
            KTDatatableRemoteAjax.init();
        });
    </script>
@endsection

