$(document).ready(function()
{
    $('#loading').hide();
    $('#write').hide();
    //$('#data').hide();
    $('#emitir').attr('disabled','disabled');


    $('#listaseguro').attr('disabled','disabled');
    $('#listamarca').attr('disabled','disabled');
    $('#listasubmarca').attr('disabled','disabled');
    $('#listastate').attr('disabled','disabled');
    $('#listdescripcion').attr('disabled','disabled');
    $('#listyear').attr('disabled','disabled');
    $('#listPago').attr('disabled', 'disabled');
    $('#listDescuento').attr('disabled', 'disabled');

    $('.next').attr('disabled','disabled');



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

     $('#listDescuento').change(()=>{
        $('.next').removeAttr('disabled');
     })


      $('#codigoPostal').focusout(function(){

        let cp = $('#codigoPostal').val();
        let data = `codigopostal=${cp}`;
        
        callLatino('colonia','http://190.9.53.22:8484/sipa/latino/getColonias','Selecciona colonia',data);  
      });



     $('#listDescuento').change(function(){

        let url         = 'http://190.9.53.22:8484/sipa/latino/getQuote';
        let modelo      = $('#listyear').find('option:selected').val();
        let marca       = $('#listamarca').find('option:selected').val();
        let submarca    = $('#listasubmarca').find('option:selected').val();
        let descripcion = $('#listdescripcion').find('option:selected').val();
        let paquete     = $('#listpackage').find('option:selected').val();
        let estado      = $('#listastate').find('option:selected').val();
        let tipoPago    = $('#listPago').find('option:selected').val();
        let descuento   = $('#listDescuento').find('option:selected').val();
        let data = `modelo=${modelo}&marca=${marca}&paquete=${paquete}&submarca=${submarca}&estado=${estado}&descripcion=${descripcion}&tipoPago=${tipoPago}&descuento=${descuento}`;
           
           if ($('#data').val() != null || $('#data').val() == '')
           {
               $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'html',
                    success: function(response)
                     {
                      $('#data').val(response.trim());
                     }
                      })
            }
});

     $('#genero').change(function(){
       
       let url        = 'http://190.9.53.22:8484/sipa/latino/saveQoute';
       let nombre     = $('#nombre').val();
       let apPaterno  = $('#apellidop').val();
       let apMaterno  = $('#apellidom').val();
       let cotizacion = $('#data').val();

       let data = `nombre=${nombre}&apPaterno=${apPaterno}&apMaterno=${apMaterno}&cotizacion=${cotizacion}`;

       $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'html',
        success: function(response)
        {
          $('#camposPoliza').val(response.trim());
        }

       })

     });

     $('#colonia').change(function(){

      let url         = 'http://190.9.53.22:8484/sipa/latino/addCliente';
      let nombre      = $('#nombre').val();
      let apPaterno   = $('#apellidop').val();
      let apMaterno   = $('#apellidom').val();
      let nacimiento  = $('#fechanacimiento').val();
      let rfc         = $('#rfc').val();
      let calle       = $('#direccion').val();
      let numero      = $('#numero').val();
      let colonia     = $('#colonia').val();
      let cp          = $('#codigoPostal').val();

      let data = `nombre=${nombre}&apPaterno=${apPaterno}&apMaterno=${apMaterno}&nacimiento=${nacimiento}&rfc=${rfc}&calle=${calle}&numero=${numero}&colonia=${colonia}&cp=${cp}`;

      $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'html',
        success: function(response){

          $('#cliente').val(response.trim());
        }
      }) 
     })


     $('.emitir').click(function(e){

       $("#btnaceptar").prop("disabled", true);
       e.preventDefault();
       var  form = $("#basicform").serialize();

       $.ajax({
        type: 'POST',
        url: "http://190.9.53.22:8484/sipa/latino/emitir",
        data: form,
        dataType: 'html',
        beforeSend: ()=> $('#write').show(),
        complete: ()=> $('#write').hide(),
        success: function(response){

          let error = response.substr(6);
          
          if(response.indexOf('error') == 0)
          {

            swal({
          title:'Error',
          text: error,
          type: 'error',
          showCancelButton: false,
            confirmButtonColor: '#3085d6',
        confirmButtonText: 'ACEPTAR'
        }).then((result) =>{
          if(result.value)
          {
            
          }
        })

          }else if(response.indexOf('ok') ==0)
          {

            swal({
          title:'Exitosa',
          text:'poliza generada',
          type:'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'ACEPTAR'
        }).then((result) =>{
          if(result.value)
          {
           
          }
        })

          }
    }

       })

     })



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
});
