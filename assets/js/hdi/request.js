$(document).ready( function(){

$('#loading').hide();
$('#error').hide();

$('#listBrand').attr('disabled', 'disabled');
$('#listSubBrand').attr('disabled', 'disabled');
$('#listVersion').attr('disabled', 'disabled');
$('#listTransmision').attr('disabled', 'disabled');
$('#listUsos').attr('disabled', 'disabled');
$('#listCiudad').attr('disabled', 'disabled');
$('#listPago').attr('disabled', 'disabled');
$('#listTipoPago').attr('disabled', 'disabled');
$('#listServicios').attr('disabled', 'disabled');


callHDI('typeCar','http://190.9.53.22:8484/sipa/Hdi/getTypeCar','* Tipo de vehiculo');
callHDI('listEstado','http://190.9.53.22:8484/sipa/Hdi/getEstado','* Selecionar Estado');

$('#typeCar').change(function(){
    $('#listYear').removeAttr('disabled');
})

$('#listYear').change(()=>{
 
 let tipo = $('#typeCar').find('option:selected').val();
 let year = $('#listYear').find('option:selected').val();
 let data = `tipo=${tipo}&year=${year}`;

callHDI('listBrand','http://190.9.53.22:8484/sipa/Hdi/getBrand','* Marcas de vehiculo',data);
});

$('#listBrand').change(()=>{

 let tipo  = $('#typeCar').find('option:selected').val();
 let year  = $('#listYear').find('option:selected').val();
 let marca = $('#listBrand').find('option:selected').val();
 let data = `tipo=${tipo}&year=${year}&marca=${marca}`;

 callHDI('listSubBrand','http://190.9.53.22:8484/sipa/Hdi/getSubBrand','* Seleccion SubMarca',data);
});

$('#listSubBrand').change(()=>{

 let tipo     = $('#typeCar').find('option:selected').val();
 let year     = $('#listYear').find('option:selected').val();
 let marca    = $('#listBrand').find('option:selected').val();
 let submarca = $('#listSubBrand').find('option:selected').val();
 let data = `tipo=${tipo}&year=${year}&marca=${marca}&submarca=${submarca}`;

 callHDI('listVersion','http://190.9.53.22:8484/sipa/Hdi/getVersion','* Version de vehiculo', data); 
});

$('#listVersion').change(()=>{

 let tipo     = $('#typeCar').find('option:selected').val();
 let year     = $('#listYear').find('option:selected').val();
 let marca    = $('#listBrand').find('option:selected').val();
 let submarca = $('#listSubBrand').find('option:selected').val();
 let version  = $('#listVersion').find('option:selected').val();
 let data = `tipo=${tipo}&year=${year}&marca=${marca}&submarca=${submarca}&version=${version}`;

 callHDI('listTransmision','http://190.9.53.22:8484/sipa/Hdi/getTransmision','* Transmision',data);
});


$('#listTransmision').change(()=>{

	let tipo = $('#typeCar').find('option:selected').val();
	let data = `tipo=${tipo}`;

	callHDI('listUsos','http://190.9.53.22:8484/sipa/Hdi/getUse','* Tipo de uso',data);
});

    $('#listUsos').change(()=>{

 let url      = 'http://190.9.53.22:8484/sipa/Hdi/getDescripcion';
 let tipo     = $('#typeCar').find('option:selected').val();
 let marca    = $('#listBrand').find('option:selected').val();
 let submarca = $('#listSubBrand').find('option:selected').val();
 let version  = $('#listVersion').find('option:selected').val();
 let transmision = $('#listTransmision').find('option:selected').val();
 let modelo   = $('#listYear').find('option:selected').val();

 let data = `tipo=${tipo}&marca=${marca}&submarca=${submarca}&version=${version}&transmision=${transmision}&modelo=${modelo}`;

 $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'html',

        beforeSend: ()=> $('#loading').show(),
        complete: ()=> $('#loading').hide(),
        success: function (response){

             $('#detalles').val(response.trim());  
        }
      });
});

$('#listServicios').change( ()=>{

	callHDI('listConducto','http://190.9.53.22:8484/sipa/hdi/getConducto','* Forma de pago');
})


$('#listEstado').change(()=>{

	let estado  = $('#listEstado').find('option:selected').val();
	let data    = `estado=${estado}`;
	callHDI('listCiudad','http://190.9.53.22:8484/sipa/Hdi/getCiudad','* Seleciona Cuidad',data);
});

$('#listCiudad').change(()=>{
  callHDI('listPago','http://190.9.53.22:8484/sipa/Hdi/getPayMethod','* Perido de pago');
});

});

$('#listPago').change(()=>{
	callHDI('listTipoPago','http://190.9.53.22:8484/sipa/Hdi/setSumAsegurada','* Seleccionar');
});

$('#listTipoPago').change(()=>{
	callHDI('listServicios','http://190.9.53.22:8484/sipa/Hdi/getServices','* Tipo de servicio');
});

$('#listConducto').change(function(){

 $('#paquete').removeAttr('disabled');

})


$('#paquete').change(function(){
    callHDI('listOcupacion','http://190.9.53.22:8484/sipa/Hdi/getOcupacionConductor','* Ocupacion del conductor');
})


$('#nacimiento').change(function(){
    $('#listSexo').removeAttr('disabled');
})

$('#listSexo').change(()=>{
	callHDI('listCivil','http://190.9.53.22:8484/sipa/Hdi/getCivil','* Estado civil');
});

$('#listCivil').change(()=>{
	callHDI('listNacionalidad','http://190.9.53.22:8484/sipa/Hdi/getNacionalidad','* Nacionalidad');
});

$('#codigop').focusout(function(){

    callHDI('listOcupaciones','http://190.9.53.22:8484/sipa/Hdi/getOcupacion','* Ocupacion');
})

$('#listOcupaciones').change(()=>{
	callHDI('listGiros','http://190.9.53.22:8484/sipa/Hdi/getGiros','* Giro de ocupacion');
});

function testCall(url,data=null)
    {
      $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'json',

        beforeSend: ()=> $('#loading').show(),
        complete: ()=> $('#loading').hide(),
        success: (response)=>{
            console.log(response);
        }
      });

    }

    function callHDI(list,url,message,data = null)
    {
    $.ajax({
        type:'POST',
        url: url,
        data: data,
        dataType: 'html',

        beforeSend: ()=> $('#loading').show(),
        complete: ()=> $('#loading').hide(),
        success: function(response)
        {

          $('#'+list).removeAttr('disabled');
          $('option', '#'+list).remove();
          $('#'+list).find('option').remove().end().append("<option value=''>"+message+"</option>").val('');
          $('#'+list).append(response);
        }
    });

}