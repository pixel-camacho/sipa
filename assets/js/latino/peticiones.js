$(document).ready(function()
{
    $('#loading').hide();

    $('#listaseguro').attr('disabled','disabled');
    $('#listamarca').attr('disabled','disabled');
    $('#listasubmarca').attr('disabled','disabled');
    $('#listyear').attr('disabled','disabled');
    $('#listdescripcion').attr('disabled','disabled');

    $('#listpackage').change(()=>{
       $('#listyear').removeAttr('disabled');
    });

     $('#listyear').change(function()
     {
       let seguro = $('#listaseguro').val();
       let modelo = $('#listyear').find("option:selected").val();
       let paquete = $('#listpackage').find("option:selected").val();
       let data = `params=${seguro}&modelo=${modelo}&paquete=${paquete}`;
       callLatino('listamarca','http://190.9.53.22:8484/sipa/latino/getMarca','* Selecionar Marca',data);
     
     });

     $('#listamarca').change(()=>
     {
       let seguro  = $('#listaseguro').val();
       let modelo  = $('#listyear').find('option:selected').val();
       let marca   = $('#listamarca').find('option:selected').val();
       let paquete = $('#listpackage').find('option:selected').val();
       let data = `params=${seguro}&modelo=${modelo}&marca=${marca}&paquete=${paquete}`;
       callLatino('listasubmarca','http://190.9.53.22:8484/sipa/latino/getSubmarca','* Seleccionar Modelo',data);
      

     });

     $('#listasubmarca').change(()=>
     {
      let seguro   = $('#listaseguro').val();
      let modelo   = $('#listyear').find('option:selected').val();
      let marca    = $('#listamarca').find('option:selected').val();
      let paquete  = $('#listpackage').find('option:selected').val();
      let submarca = $('#listasubmarca').find('option:selected').val();
      let data = `params=${seguro}&modelo=${modelo}&marca=${marca}&paquete=${paquete}&submarca=${submarca}`;
      callLatino('listdescripcion','http://190.9.53.22:8484/sipa/latino/getDescripcion1','* Descripcion del vehiculo',data);
        
     });

    //  $('#listdescripcion').change(()=>
    //  {
    //   let seguro   = $('#listaseguro').val();
    //   let modelo   = $('#listyear').find('option:selected').val();
    //   let marca    = $('#listamarca').find('option:selected').val();
    //   let paquete  = $('#listpackage').find('option:selected').val();
    //   let submarca = $('#listasubmarca').find('option:selected').val();
    //   let estado = 3;
    //   let descripcion = $('#listdescripcion').find('option:selected').val();
    //   let data = `params=${seguro}&modelo=${modelo}&marca=${marca}&paquete=${paquete}&submarca=${submarca}&estado=${estado}&descripcion=${descripcion}`;
    //   testCall('http://190.9.53.22:8484/sipa/latino/getCoverage',data);

    //  });

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
        dataType: 'html',

        beforeSend: ()=> $('#loading').show(),
        complete: ()=> $('#loading').hide(),
        success: (response)=>{
            console.log(response);
        }
      });

    }