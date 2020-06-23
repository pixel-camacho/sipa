$(document).ready(function () {
    $('#loadingeffects').hide();
    $("#payment-form").validate({
        rules: {
            
            marca: "required",
            modelo: "required",
            descripcion: "required",
            year: "required", 
            cp: {
                required: true,
                digits: true,
                rangelength: [5, 5]
            }
        },
        messages: {
            marca: "Campo requerido.",
            modelo: "Campo requerido.",
            descripcion: "Campo requerido.",
            year: "Campo requerido.",  
            cp: {
                required: "Campo requerido.",
                digits: "Solo número.",
                rangelength: "Entre 5 dígitos."
            }
        }

    });
    $('#siguiente').on('click', function (event) {
        if ($("#payment-form").valid())
        {
            $('#siguiente').hide();
            $('#loadingeffects').show();
        } else
        {
            return false;
        }
    });
});