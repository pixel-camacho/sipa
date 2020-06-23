
$(document).ready(function () {


    $('#listamunicipio').attr('disabled', 'disabled');
    $('#listacolonia').attr('disabled', 'disabled');

    $("#listaestado").change(function () {
        var estado = $("#listaestado").find("option:selected").val();

        $.ajax({
            type: "POST",
            url: "http://localhost:8383/donfacilito/cotizador/selectMunicipios",
            data: "varestado=" + estado,
            dataType: "html",
            beforeSend: function () {
                //  $('#mensajeslo').show();
                //$('#mensajeslo').val("sss");
            },
            complete: function () {
                // $('#mensajeslo').hide();
            },
            success: function (response) {
                console.log(response); 
                $('#listamunicipio').removeAttr('disabled');
                $(".select2_municipio").empty();   
                $(".select2_colonia").empty();   
                $("#listamunicipio").append(response); 
                $('#listacolonia').attr('disabled', 'disabled');
            }
        });


    });
 
    $("#listamunicipio").change(function () {
        var municipio = $("#listamunicipio").find("option:selected").val();
        $.ajax({
            type: "POST",
            url: "http://localhost:8383/donfacilito/cotizador/selectColonias",
            data: "varmunicipio=" + municipio,
            dataType: "html",
            success: function (response) { 
                $('#listacolonia').removeAttr('disabled');
                $(".select2_colonia").empty();  
                $("#listacolonia").append(response);

            }
        });

    });
 
});