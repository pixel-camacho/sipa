$(document).ready(function()
{
    $('#loading').hide();

    $('#listaseguro').attr('disabled','disabled');
    $('#listamarca').attr('disabled','disabled');
    $('#listasubmarca').attr('disabled','disabled');
    $('#listastate').attr('disabled','disabled');
    $('#listdescripcion').attr('disabled','disabled');
    $('#listyear').attr('disabled','disabled');
    $('#listPago').attr('disabled', 'disabled');
    $('#listDescuento').attr('disabled', 'disabled');



     $('#listpackage').change(function()
     {
       $('#listPago').removeAttr('disabled');
     });

     $('#listPago').change(function()
     {
        callLatino('listastate','http://190.9.53.22:8484/sipa/latino/getState','* Seleccionar estado');
     });

     $('#listastate').change(()=>
     { 
       let estado    = $('#listastate').find('option:selected').val(); 
       let paquete   = $('#listpackage').find('option:selected').val();
       let data = `estado=${estado}&paquete=${paquete}`;
       callLatino('listyear','http://190.9.53.22:8484/sipa/latino/getYear','* Seleccionar Año',data);
     });

     $('#listyear').change(()=>
     {
      let modelo   = $('#listyear').find('option:selected').val();
      let paquete  = $('#listpackage').find('option:selected').val();
      let data = `modelo=${modelo}&paquete=${paquete}`;
      callLatino('listamarca','http://190.9.53.22:8484/sipa/latino/getMarca','* Seleccionar Marca',data);
     });

     $('#listamarca').change(() =>
     {
       let lista = $('#listamarca').find('option:selected').val();

      if( lista != '0' && lista != ''){

      let modelo  = $('#listyear').find('option:selected').val();
      let marca  = $('#listamarca').find('option:selected').val();
      let paquete = $('#listpackage').find('option:selected').val();
      let data    = `modelo=${modelo}&marca=${marca}&paquete=${paquete}`;
      callLatino('listasubmarca','http://190.9.53.22:8484/sipa/latino/getSubmarca','* Seleccionar Modelo',data);
      }

     });

     $('#listasubmarca').change(()=>
     {
         let lista = $('#listasubmarca').find('option:selected').val();
       
       if(lista != '0' && lista != ''){

      let modelo   = $('#listyear').find('option:selected').val();
      let marca    = $('#listamarca').find('option:selected').val();
      let submarca = $('#listasubmarca').find('option:selected').val();
      let paquete  = $('#listpackage').find('option:selected').val();
      let data     = `modelo=${modelo}&marca=${marca}&submarca=${submarca}&paquete=${paquete}`;
      callLatino('listdescripcion','http://190.9.53.22:8484/sipa/latino/getDescripcion','* Seleccionar Descripcion',data);

       }
     });

     $('#listdescripcion').change(()=>{

        let estado    = $('#listastate').find('option:selected').val(); 
        let paquete   = $('#listpackage').find('option:selected').val();
        let data = `estado=${estado}&paquete=${paquete}`;
        callLatino('listDescuento','http://190.9.53.22:8484/sipa/latino/getDecuentos','Seleccionar descuento',data);

     });



   /*  $('#listdescripcion').change(()=>
     {
      let modelo      = $('#listyear').find('option:selected').val();
      let marca       = $('#listamarca').find('option:selected').val();
      let submarca    = $('#listasubmarca').find('option:selected').val();
      let descripcion = $('#listdescripcion').find('option:selected').val();
      let paquete     = $('#listpackage').find('option:selected').val();
      let estado      = $('#listastate').find('option:selected').val();
      let data        = `modelo=${modelo}&marca=${marca}&submarca=${submarca}&descripcion=${descripcion}&paquete=${paquete}$estado=${estado}`;
      testCall('http://190.9.53:22:8484/sipa/latino/getCoverage',data);
     });*/

     $('#listDescuento').change(()=>
      {
      let modelo      = $('#listyear').find('option:selected').val();
      let marca       = $('#listamarca').find('option:selected').val();
      let submarca    = $('#listasubmarca').find('option:selected').val();
      let descripcion = $('#listdescripcion').find('option:selected').val();
      let paquete     = $('#listpackage').find('option:selected').val();
      let estado      = $('#listastate').find('option:selected').val();
      let tipoPago    = $('#listPago').find('option:selected').val();
      let descuento   = $('#listDescuento').find('option:selected').val();
      let data = `modelo=${modelo}&marca=${marca}&paquete=${paquete}&submarca=${submarca}&estado=${estado}&descripcion=${descripcion}&tipoPago=${tipoPago}&descuento=${descuento}`;
       testCall('http://190.9.53.22:8484/sipa/latino/getQuote',data);
      });

});

function callLatino(list,url,message,data = null)
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