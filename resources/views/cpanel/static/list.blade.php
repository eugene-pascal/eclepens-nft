@extends('layout.default')
@section('title', __('The list of static Page'))
@php
    $page_breadcrumbs = [
            [
                'page'=>url()->current(),
                'title'=> __('The list of static Page')
            ]
        ];
@endphp
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    {{ __('The list of static Page') }}
                    <div class="text-muted pt-2 font-size-sm">@lang('Manage static pages')</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('page.add') }}" class="btn btn-light-primary font-weight-normal">
                    {{ Metronic::getSVG("media/svg/icons/Design/Flatten.svg", "svg-icon-md") }}
                    @lang('Add a new page')
                </a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            @include('pages.widgets._alert_both_success_error', [])

            <form id="formStaticPages" action="{{ route('pages.sort') }}">
                @csrf
                @method('PUT')
                <table class="table table-hover nowrap draggable-zone" id="kt_datatable_static_pages">
                    <thead>
                    <tr>
                        <th style="width:5%;"></th>
                        <th style="width:20%;" class="text-uppercase text-dark font-weight-light">{{ __('Name') }}</th>
                        <th style="width:20%;" class="text-uppercase text-dark font-weight-light">{{ __('Header') }}</th>
                        <th style="width:15%;" class="text-uppercase text-dark font-weight-light">{{ __('Show in menu') }}</th>
                        <th style="width:15%;" class="text-uppercase text-dark font-weight-light">{{ __('Last update') }}</th>
                        <th style="width:20%;" class="text-uppercase text-dark font-weight-light">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $item)
                        <tr class="draggable">
                            <input type="hidden" name="order[]" value="{{ $item->id }}"/>
                            <td>
                                @if ($item->isLeaf())
                                    <i class="fas fa-leaf text-muted"></i>
                                @else
                                    <a href="{{ route('page.descendants', ['page'=>$item]) }}" class="child-switch" data-parent-id="{{ $item->id }}">
                                        <i class="fas fa-plus text-primary"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if (($localizationItem = $item->staticPageLocalization()->whereHas('language', function ($query) {
                                        $query->where('languages.sort',1);
                                    })->first()) && isset($localizationItem))
                                    <span class="text-dark-75 font-weight-normal font-size-sm">{{ $localizationItem->name }}</span>
                                @else
                                    <span class="text-dark-75 font-weight-normal font-size-sm">{{ $item->name ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($localizationItem))
                                    <span class="text-dark-75 font-weight-normal font-size-sm">{{ $localizationItem->header }}</span>
                                @else
                                    <span class="text-dark-75 font-weight-normal font-size-sm">{{ $item->header ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                @if (is_null($item->display))
                                    <i class="flaticon-cancel text-danger font-size-sm"></i>
                                @else
                                    <i class="flaticon2-checkmark text-success font-size-sm"></i>
                                @endif
                            </td>
                            <td><span class="text-dark-75 font-weight-bold font-size-xs">{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</span></td>
                            <td>
                                <a href="{{ route('page.edit', ['page' => $item->id]) }}" class="btn btn-sm btn-icon btn-outline-success mr-1 mb-1" data-toggle="tooltip" title="@lang('Edit the page')" data-theme="dark">
                                    <i class="flaticon-edit"></i>
                                </a>
                                <a href="{{ route('page.delete', ['page' => $item->id]) }}" class="btn btn-sm  btn-icon btn-outline-danger delete-record mr-1 mb-1" data-toggle="tooltip" title="@lang('Remove the page')" data-theme="dark">
                                    <i class="flaticon2-trash"></i>
                                </a>
                                <a href="{{ route('page.add', ['parent_id' => $item->id, 'position'=>'after']) }}" class="btn btn-sm btn-icon btn-outline-primary mr-1 mb-1" data-toggle="tooltip" title="@lang('Add a new page after')" data-theme="dark">
                                    <i class="flaticon-add"></i>
                                </a>
                                <a href="{{ route('page.add', ['parent_id' => $item->id, 'position'=>'child']) }}" class="btn btn-sm btn-icon btn-outline-warning mr-1 mb-1" data-toggle="tooltip" title="@lang('Add a new page as a child')" data-theme="dark">
                                    <i class="flaticon-map"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary draggable-handle">
                                    <i class="ki ki-menu"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>

    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme_assets/plugins/custom/draggable/draggable.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('theme_assets/js/tools/table.js?new2') }}" type="text/javascript"></script>

    <script>
        var KTCardDraggable = function () {
            return {
                //main function to initiate the module
                init: function () {
                    var containers = document.querySelectorAll('table.draggable-zone tbody');

                    if (containers.length === 0) {
                        return false;
                    }

                    var swappable = new Sortable.default(containers, {
                        draggable: 'tr.draggable',
                        handle: 'tr.draggable .draggable-handle',
                        mirror: {
                            appendTo: 'body',
                            constrainDimensions: true
                        }
                    });

                    swappable.on('sortable:stop', function(event){
                        if (event.newIndex != event.oldIndex) {
                            var form = $('#formStaticPages');

                            setTimeout(function() {
                                // console.log( form.serialize() + '&newIndex=' + event.newIndex + '&oldIndex=' + event.oldIndex);
                                $.post(form.attr('action'), form.serialize() + '&newIndex=' + event.newIndex + '&oldIndex=' + event.oldIndex)
                                    .done(function() {
                                        $.notify(
                                            {
                                                title: '<strong>Success:</strong>',
                                                message: 'Page updated successfully'
                                            },
                                            {
                                                type: 'success'
                                            },
                                        )
                                    })
                                    .fail(function() {
                                        $.notify(
                                            {
                                                title: '<strong>Error:</strong>',
                                                message: 'Failed to save your changes'
                                            },
                                            {
                                                type: 'danger'
                                            },
                                        )
                                    });
                            }, 500);
                        }
                    });
                }
            };
        }();

        $(function() {
            $(document).on('click', '.child-switch', function(e) {
                e.preventDefault();
                var _this = $(this);
                var _parrentTR = _this.closest('tr');
                var _i = _this.find('i').eq(0);

                if (_i.hasClass('fa-plus')) {
                    _i.removeClass('fa-plus').addClass('fa-minus');
                    $.get(_this.attr('href'))
                        .done(function(response) {
                            var childMainTR = $('<tr>', {'class':'child-items'});
                            var childMainTD = $('<td>', {'colspan':6, 'style':'padding:0px;'}).appendTo(childMainTR);
                            var childTable = $('<table>',{
                                    'class':'table table-hover nowrap draggable-zone-child',
                                    'style': 'border-top:'
                                    //'width': $('#kt_datatable_static_pages').width()
                                }).appendTo(childMainTD);

                            $.each(response.descendants, function (key, item) {
                                let _TR = $('<tr>', {
                                    class: 'draggable-child',
                                    "data-item-id": item.id
                                });

                                $('<td>', {
                                    style: 'width:5%;',
                                    html: ''
                                }).appendTo(_TR);

                                $('<td>', {
                                    style: 'width:20%;',
                                    html: '<span class="text-dark-50 font-weight-normal font-size-xs">' + item.name + '</span>'
                                }).appendTo(_TR);

                                $('<td>', {
                                    style: 'width:20%;',
                                    html: '<span class="text-dark-50 font-weight-normal font-size-xs">' + item.header + '</span>'
                                }).appendTo(_TR);

                                $('<td>', {
                                    style: 'width:15%;',
                                    html: (item.display ? '<i class="flaticon2-checkmark text-success font-size-xs"></i>' : '<i class="flaticon-cancel text-danger font-size-xs"></i>' )
                                }).appendTo(_TR);

                                $('<td>', {
                                    style: 'width:15%;',
                                    html: '<span class="text-dark-50 font-weight-bold font-size-xs">' + item.created_at.split('T')[0] + ' ' + (item.created_at.split('T')[1]).split('.')[0] + '</span>'
                                }).appendTo(_TR);

                                $('<td>', {
                                    style: 'width:20%;',
                                    html: '<a href="'+ item.linkBtnEdit +'" class="btn btn-icon btn-sm btn-outline-success mr-1 mb-1" data-toggle="tooltip" title="Edit page" data-theme="dark"><i class="flaticon-edit"></i></a>' +
                                        '<a href="'+ item.linkBtnDelete +'" class="btn btn-icon btn-sm btn-outline-danger delete-record mr-1 mb-1" data-toggle="tooltip" title="Remove page" data-theme="dark"><i class="flaticon2-trash"></i></a>' +
                                        '<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary draggable-handle-child" data-toggle="tooltip" title="Drag&Drop" data-theme="light"><i class="ki ki-menu"></i></a>'

                                }).appendTo(_TR);

                                childTable.append(_TR)
                                _parrentTR.after(childMainTR);
                            });

                            let containersChild = document.querySelectorAll('table.draggable-zone-child');

                            if (containersChild.length === 0) {
                                return false;
                            }

                            let swappableChild = new Sortable.default(containersChild, {
                                draggable: 'tr.draggable-child',
                                handle: 'tr.draggable-child .draggable-handle-child',
                                mirror: {
                                    appendTo: 'body',
                                    constrainDimensions: true
                                }
                            });

                            swappableChild.on('sortable:stop', function(event) {
                                if (event.newIndex != event.oldIndex) {
                                    var form = $('#formStaticPages');


                                    // setTimeout(function() {
                                    //     let _params = {};
                                    //     _params['order'] = [];
                                    //     childTable.closest('tr.child-items').find('tr.draggable-child').each(function() {
                                    //         _params['order'].push($(this).data('item-id'));
                                    //     });
                                    //     _params['newIndex'] = event.newIndex;
                                    //     _params['oldIndex'] = event.oldIndex;
                                    //
                                    //
                                    //     console.log( _params );
                                    // }, 500);

                                    setTimeout(function() {
                                        let _params = {};
                                        _params['order'] = [];
                                        childTable.closest('tr.child-items').find('tr.draggable-child').each(function() {
                                            _params['order'].push($(this).data('item-id'));
                                        });
                                        _params['newIndex'] = event.newIndex;
                                        _params['oldIndex'] = event.oldIndex;
                                        _params["_token"] = "{{ csrf_token() }}";
                                        _params["_method"] = "PUT";

                                        $.post(form.attr('action'), _params)
                                            .done(function() {
                                                $.notify(
                                                    {
                                                        title: '<strong>Success:</strong>',
                                                        message: 'Page updated successfully'
                                                    },
                                                    {
                                                        type: 'success'
                                                    },
                                                )
                                            })
                                            .fail(function() {
                                                $.notify(
                                                    {
                                                        title: '<strong>Error:</strong>',
                                                        message: 'Failed to save your changes'
                                                    },
                                                    {
                                                        type: 'danger'
                                                    },
                                                )
                                            });
                                    }, 500);
                                }
                            });
                        })
                        .fail(function() {

                        });
                } else
                if (_i.hasClass('fa-minus')) {
                    _i.removeClass('fa-minus').addClass('fa-plus');

                    var _next = _parrentTR.next();
                    do {
                        if (_next.hasClass('child-items')) {
                            let _linkToCurrent = _next;
                            _next = _next.next();
                            _linkToCurrent.remove();
                        }
                    } while (_next.hasClass('child-items'));
                }
            });

            KTCardDraggable.init();
        });
    </script>
@endsection
