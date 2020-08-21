$(document).ready( function(){

$('#loading').hide();

callHDI('typeCar','http://190.9.53.22:8484/sipa/Hdi/getTypeCar','* Selecionar Tipo');
callHDI('listEstado','http://190.9.53.22:8484/sipa/Hdi/getEstado','* Seleciona Estado');

$('#listYear').change(()=>{
 
 let tipo = $('#typeCar').find('option:selected').val();
 let year = $('#listYear').find('option:selected').val();
 let data = `tipo=${tipo}&year=${year}`;

callHDI('listBrand','http://190.9.53.22:8484/sipa/Hdi/getBrand','* Seleciona Marca',data);
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

 callHDI('listVersion','http://190.9.53.22:8484/sipa/Hdi/getVersion','* Seleciona Version', data); 
});

$('#listVersion').change(()=>{

 let tipo     = $('#typeCar').find('option:selected').val();
 let year     = $('#listYear').find('option:selected').val();
 let marca    = $('#listBrand').find('option:selected').val();
 let submarca = $('#listSubBrand').find('option:selected').val();
 let version  = $('#listVersion').find('option:selected').val();
 let data = `tipo=${tipo}&year=${year}&marca=${marca}&submarca=${submarca}&version=${version}`;

 callHDI('listTransmision','http://190.9.53.22:8484/sipa/Hdi/getTransmision','* Seleciona Transmision',data);
});

$('#listTransmision').change(()=>{ 
 let tipo     = $('#typeCar').find('option:selected').val();
 let marca    = $('#listBrand').find('option:selected').val();
 let submarca = $('#listSubBrand').find('option:selected').val();
 let version  = $('#listVersion').find('option:selected').val();
 let transmision = $('#listTransmision').find('option:selected').val();
 let data = `tipo=${tipo}&marca=${marca}&submarca=${submarca}&version=${version}&transmision=${transmision}`;

 callHDI('listModel','http://190.9.53.22:8484/sipa/Hdi/getModel','* Seleciona Modelo',data);
});


$('#listEstado').change(()=>{

	let estado  = $('#listEstado').find('option:selected').val();
	let data    = `estado=${estado}`;
	callHDI('listCiudad','http://190.9.53.22:8484/sipa/Hdi/getCiudad','* Seleciona Cuidad',data);
});

$('#listCiudad').change(()=>{
  callHDI('listPago','http://190.9.53.22:8484/sipa/Hdi/getPayMethod','* Forma de pago');
});

});

$('#listPago').change(()=>{
	callHDI('listTipoPago','http://190.9.53.22:8484/sipa/Hdi/setSumAsegurada','* Seleccionar');
});

$('#listTipoPago').change(()=>{
	callHDI('listServicios','http://190.9.53.22:8484/sipa/Hdi/getServices','* Seleccionar Servicio');
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