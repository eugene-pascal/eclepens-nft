@extends('layout.default')
@section('title',  __('Languages'))
@php
    $page_breadcrumbs = [
            [
                'page'=>url()->current(),
                'title'=> __('Languages')
            ]
        ];
@endphp
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">{{ __('Languages') }}
                    <div class="text-muted pt-2 font-size-sm">@lang('Management of the languages for static pages')</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('settings.language.add') }}" class="btn btn-primary font-weight-bolder">
                    {{ Metronic::getSVG("media/svg/icons/Design/Flatten.svg", "svg-icon-md") }}
                    @lang('Add a new language')
                </a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <div class="container">
                @include('pages.widgets._alert_both_success_error', [])
                <form id="formStaticLanguages" action="{{ route('settings.languages.sort') }}">
                    @csrf
                    @method('PUT')
                    <table class="table table-hover nowrap draggable-zone" id="kt_datatable_static_pages">
                        <thead>
                        <tr>
                            <th style="width:45%;">Name</th>
                            <th style="width:20%;">Code</th>
                            <th style="width:20%;">Active</th>
                            <th style="width:15%;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (!empty($list))
                            @foreach ($list as $item)
                            <tr class="draggable">
                                <input type="hidden" name="order[]" value="{{ $item->id }}"/>
                                <td>
                                    <span class="text-dark font-weight-bold">{{ $item->lang_name }}</span>
                                </td>
                                <td>
                                    <span class="label label-inline label-success">{{ $item->lang_code }}</span>
                                </td>
                                <td>
                                    @if (!$item->is_active)
                                        <i class="flaticon-cancel text-danger"></i>
                                    @else
                                        <i class="flaticon2-checkmark text-success"></i>
                                    @endif
                                </td>
                                <td class="text-align-right right">
                                    <a href="{{ route('settings.language.edit', ['lang' => $item->id]) }}" class="btn btn-icon btn-outline-success mr-1 mb-1" data-toggle="tooltip" title="Edit page" data-theme="dark">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                    <a href="{{ route('settings.language.delete', ['lang' => $item->id]) }}" class="btn btn-icon btn-outline-danger delete-record mr-1 mb-1" data-toggle="tooltip" title="Remove page" data-theme="dark">
                                        <i class="flaticon2-trash"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary draggable-handle">
                                        <i class="ki ki-menu"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('theme_assets/plugins/custom/draggable/draggable.bundle.js') }}" type="text/javascript"></script>

    <script src="{{ asset('theme_assets/js/tools/table.js?new') }}" type="text/javascript"></script>
    <script>
        const KTCardDraggable = function () {
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
                            var form = $('#formStaticLanguages');

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
            KTCardDraggable.init();
        });
    </script>
@append