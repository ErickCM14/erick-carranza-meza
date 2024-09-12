const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 10000,
    timerProgressBar: true,
})

$(document).on('submit', '.form-submit-event', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var error_box = $('#error_box', this);
    var submit_btn = $(this).find('.submit_btn');
    var btn_html = $(this).find('.submit_btn').html();
    var btn_val = $(this).find('.submit_btn').val();
    var button_text = (btn_html != '' || btn_html != 'undefined') ? btn_html : btn_val;

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        beforeSend: function () {
            submit_btn.attr('disabled', true);
            submit_btn.html(`<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>
            <span class="sr-only">Loading...</span>`);
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (result) {
            if (result['error'] == true) {
                error_box.addClass("rounded p-3 alert alert-danger").removeClass('d-none alert-success');
                error_box.show().delay(5000).fadeOut();
                error_box.html(result['message']);
                submit_btn.html(button_text);
                submit_btn.attr('disabled', false);
                Toast.fire({
                    icon: "error",
                    title: result['message']
                });
                $('#btn_submit_envio').addClass('d-none');
            } else {
                error_box.addClass("rounded p-3 alert alert-success").removeClass('d-none alert-danger');
                error_box.show().delay(3000).fadeOut();
                error_box.html(result['message']);
                submit_btn.html(button_text);
                submit_btn.attr('disabled', false);
                $('#data_envia').val(JSON.stringify(result.data_envia))
                Toast.fire({
                    icon: "success",
                    title: result['message']
                });
                $('#btn_submit_envio').removeClass('d-none');
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            Toast.fire({
                icon: "error",
                title: `Error: ${textStatus}. Ocurrió un error inesperado, favor de volver a intentarlo`,
            });
            setTimeout(function () { location.reload(); }, 7000);
        }
    });
});

$(document).on('submit', '.form-submit-event-generate', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var error_box = $('#error_box', this);
    var submit_btn = $(this).find('.submit_btn');
    var btn_html = $(this).find('.submit_btn').html();
    var btn_val = $(this).find('.submit_btn').val();
    var button_text = (btn_html != '' || btn_html != 'undefined') ? btn_html : btn_val;
    $('#carrier').html('');
    $('#service').html('');
    $('#trackingNumber').html('');
    $('#trackUrl').html('');
    $('#label').html('');
    $('#data_generate_envia').addClass('d-none');
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        beforeSend: function () {
            submit_btn.attr('disabled', true);
            submit_btn.html(`<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>
            <span class="sr-only">Loading...</span>`);
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (result) {
            console.log(result);
            if (result['error'] == true) {
                error_box.addClass("rounded p-3 alert alert-danger").removeClass('d-none alert-success');
                error_box.show().delay(5000).fadeOut();
                error_box.html(result['message']);
                submit_btn.html(button_text);
                submit_btn.attr('disabled', false);
                Toast.fire({
                    icon: "error",
                    title: result['message']
                });
                $('#carrier').html('');
                $('#service').html('');
                $('#trackingNumber').html('');
                $('#trackUrl').html('');
                $('#label').html('');
                $('#data_generate_envia').addClass('d-none');
            } else {
                error_box.addClass("rounded p-3 alert alert-success").removeClass('d-none alert-danger');
                error_box.show().delay(3000).fadeOut();
                error_box.html(result['message']);
                submit_btn.html(button_text);
                submit_btn.attr('disabled', false);
                Toast.fire({
                    icon: "success",
                    title: result['message']
                });
                $('#data_generate_envia').removeClass('d-none');
                $('#carrier').html('<b>Paquetería:</b> ' + result.data.data[0].carrier);
                $('#service').html('<b>Servicio:</b> ' + result.data.data[0].service);
                $('#trackingNumber').html('<b>Número de rastreo:</b> ' + result.data.data[0].trackingNumber);
                $('#trackUrl').html('<b>URL de rastreo:</b> <a href="' + result.data.data[0].trackUrl + '" target="_blank">Da clic para abrir la url</a>');
                $('#label').html('<b>Guía:</b> <a href="' + result.data.data[0].label + '" target="_blank">Da clic para abrir la guía</a>');
            }
        }, error: function (jqXHR, textStatus, errorThrown) {
            Toast.fire({
                icon: "error",
                title: `Error: ${textStatus}. Ocurrió un error inesperado, favor de volver a intentarlo`,
            });
            setTimeout(function () { location.reload(); }, 7000);
        }
    });
});

$(document).on("keypress", ".validate_number", function (e) {
    let inputValue = String.fromCharCode(e.which);
    let regex = /^[0-9]$/;
    if (!regex.test(inputValue)) {
        e.preventDefault();
        return false;
    }
});