{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
@append
{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('theme_assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>

    <script>
        $(function() {
            var _confirmed = false;
            $('{{ $clickId }}').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let _btn = $(this),
                    _token = _btn.parents('form').find('input[name="_token"').val(),
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
                            .done(function(response) {
                                if (typeof response.status !== 'undefined' && response.status === 'error') {
                                    $.notify(
                                        {
                                            title: '<strong>Error:</strong>',
                                            message: response.message ?? 'Am error occurs'
                                        },
                                        {
                                            type: 'danger'
                                        },
                                    );
                                } else {
                                    $.notify(
                                        {
                                            title: '<strong>Success:</strong>',
                                            message: 'The record has been successfully removed !'
                                        },
                                        {
                                            type: 'success'
                                        },
                                    );

                                    let _parentId = '{{ $parentId }}';
                                    if (_parentId.charAt(0) == '#') {
                                        $(_parentId).slideUp('low', function () {
                                            $(this).remove();
                                        });
                                    } else {
                                        _btn.closest(_parentId).slideUp('low', function () {
                                            $(this).remove();
                                        });
                                    }
                                }
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
        });
    </script>

    {{-- end::Page Scripts(used by this page) --}}
@append
