 
    $(document).ready(function() {
    //Deshabilitar Select
    $('#loading1').hide();
    $('#loading2').hide();
    $('#loading3').hide();
    $('#listamarca').attr('disabled', 'disabled');
    $('#listamodelo').attr('disabled', 'disabled');
    $('#listadescripcion').attr('disabled', 'disabled'); 
    
  $("#listayear").change(function() {
        var search = $("#listayear").val();
            $.ajax({
                type: "POST",
                url: "http://190.9.53.22:8484/sipa/EmitirANA/searchVehicleYear",
                data: "textsearch=" + search,
                dataType: "html",
                  beforeSend: function() {
                      $('#loading1').show();
                     //$('#mensajeslo').val("sss");
                  },
                  complete: function(){
                      $('#loading1').hide();
                  },
                success: function(response) {
                  //console.log(response);
                    //Habilitar Select
                   // console.log(response);
                    $('#listamarca').removeAttr('disabled');
                    $('#listamodelo').attr('disabled', 'disabled');
                    $('#listadescripcion').attr('disabled', 'disabled');
                    //$('#listadescripcion').attr('disabled', 'disabled');
                    $('option', '#listamarca').remove();

                    //$('option', '#listamodelo').remove();
                    //$('option', '#listadescripcion').remove();
                    $('#listamarca').find('option') .remove().end().append('<option value="">* Seleccionar Marca</option>').val('');
                    $('#listamodelo')
                      .find('option')
                      .remove()
                      .end()
                      .append('<option value="">* Seleccionar Modelo</option>')
                      .val('');

                        $('#listadescripcion')
                      .find('option')
                      .remove()
                      .end()
                      .append('<option value="">* Seleccionar Descripción</option>')
                      .val('');

                    $("#listamarca").append(response);

                }
            });

    });
    $("#listamarca").change(function() {
        var marca = $("#listamarca").find("option:selected").val();
        var year = $("#listayear").val();
        // alert(country);
        $.ajax({
            type: "POST",
            url: "http://190.9.53.22:8484/sipa/EmitirANA/searchModelBrand",
            data: "marca=" + marca + "&year=" + year,
            dataType: "html",
              beforeSend: function() {
                      $('#loading2').show();
                     //$('#mensajeslo').val("sss");
                  },
                  complete: function(){
                      $('#loading2').hide();
                  },
            success: function(response) {
              // console.log(response);
                //Habilitar Select
                $('#listamodelo').removeAttr('disabled');
                $('#listadescripcion').attr('disabled', 'disabled');
                $('#listamodelo').find('option') .remove().end().append('<option value="">* Seleccionar Modelo</option>').val('');
                        $('#listadescripcion')
                      .find('option')
                      .remove()
                      .end()
                      .append('<option value="">* Seleccionar Descripción</option>')
                      .val('');
                //$('option', '#listamarca').remove(); 
                $("#listamodelo").append(response);

            }
        });

    }); 

    $("#listamodelo").change(function() {
        var modelo = $("#listamodelo").find("option:selected").val();
        var year = $("#listayear").val();
        $.ajax({
            type: "POST",
            url: "http://190.9.53.22:8484/sipa/EmitirANA/searchDescriptionBrand",
            data: "modelo=" + modelo + "&year=" + year,
            dataType: "html",
               beforeSend: function() {
                      $('#loading3').show();
                     //$('#mensajeslo').val("sss");
                  },
                  complete: function(){
                      $('#loading3').hide();
                  },
            success: function(response) {
               // console.log(response);
                //Habilitar Select
                $('#listadescripcion').removeAttr('disabled');
                //$('option', '#listamodelo').remove();
                $('option', '#listadescripcion').remove();
                //$('option', '#listamarca').remove(); 
                 $('#listadescripcion').find('option') .remove().end().append('<option value="">* Seleccionar Descripción</option>').val('');
                $("#listadescripcion").append(response);

            }
        });

    }); 

});