// Handle AJAX form submission
function submitForm(form) {
    let formData = new FormData(form);
    $('#ajax-loader').show();

    $.ajax({
        url: $(form).attr('action'),
        type: $(form).attr('method'),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {

            handleSuccess(response);
        },
        error: function (xhr) {

            handleError(xhr);
        }
    });
}

// Handle successful form submission
function handleSuccess(response) {
    $('#ajax-loader').hide();
    if (response.status === 'success') {
        alert(response.message);
        setTimeout(function () {
            window.location.href = response.base_url;
        }, 1000);
    } else {
        alert(response.message || 'An unexpected error occurred.');
    }
}

// Handle form validation errors
function handleError(xhr) {
    $('#ajax-loader').hide();
    var response = xhr.responseJSON;
    if (xhr.status === 422 && response.errors) {
        let errors = response.errors;
        let form = $('#create-form');
        form.find('.error-message').text('');
        form.find('.is-invalid').removeClass('is-invalid');

        $.each(errors, function (field, messages) {
            let input = form.find(`[name="${field}"]`);
            let errorSpan = form.find(`span.error-message[data-field="${field}"]`);

            if (input.length) {
                input.addClass('is-invalid');
            }

            if (errorSpan.length) {
                errorSpan.text(messages.join(' '));
            }
        });

        form.find('.is-invalid:first').focus();
    } else {
        let errorMessage = response && response.message ? response.message : 'An unexpected error occurred.';
        alert(errorMessage);
    }
}


