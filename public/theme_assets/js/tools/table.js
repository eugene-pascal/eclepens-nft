$(function() {
    $(document).on('click', '.delete-record', function(e) {
        e.preventDefault();
        e.stopPropagation();
        let btn = $(this),
            _token = btn.parents('form').find('input[name="_token"]').val();
        if(btn.hasClass('disabled')) {
            return false;
        }
        btn.addClass('disabled');
        Swal.fire({
            title: 'Are you sure?',
            text: 'The record will be removed!',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.post(btn.attr('href'), {_method: 'delete', _token})
                    .done(function() {
                        $.notify(
                            {
                                title: '<strong>Success:</strong>',
                                message: 'The record successfully removed!'
                            },
                            {
                                type: 'success'
                            },
                        );
                        btn.parents('tr').find('td').slideUp('fast', function () {
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
        });
        btn.removeClass('disabled');
    });
});
