



document.getElementById('btnPagar').addEventListener('click',pagarRecibo,false);
document.getElementById('tipopago').addEventListener('change',tipoPago,false);
//document.getElementById('checkbox').addEventListener('change',seleccion,false);
document.getElementById('enviarInformacion').addEventListener('click',pay,false);



function seleccion ()
{
	 // var icono = document.getElementById('pagar');
    var checkbox  = document.querySelectorAll('.value');
    var row = document.querySelectorAll('.linea'); 

    for(var i = 0 ; i < checkbox.length; i++)
    {
      
        if(checkbox[i].checked)
        {
          //icono.style.display = 'block';

          for(var a = 0; a < row.length; a++)
          {
            row[i].style.backgroundColor = 'yellow';
          }
        
       }else 
        { 
          
          for(var a = 0; a < row.length; a++)
          {
            row[i].style.background = 'white';
          }


        }
     }

}


function pay(e)
{
 var pago = document.getElementById('tipopago').selectedIndex;
 var numeroAutorizacion =  document.getElementById('autorizacion').value;
 var fichaDeposito = document.getElementById('ficha').value;
 var form = document.getElementById('form-pay').action = 'http://190.9.53.22:8484/sipa/cliente/pagar/'+solicitudId;


   if(pago == null || pago == 0)
   {
     e.preventDefault(); 
     
   }
   else if( pago == 2)
   {
      if(numeroAutorizacion  == null || numeroAutorizacion == '')
      {
        e.preventDefault();
      }
      else
      {
        
        form;
      
      }
       
   }
   else if(pago == 3)
   {
      if(fichaDeposito == null || fichaDeposito == '')
      {
        e.preventDefault();
      }
      else
      {
       form;
      }

   }
   else if( pago == 4 )
   {
    if (numeroAutorizacion == null || numeroAutorizacion == '') 
    {
      e.preventDefault();
    }
    else
    {
      form;
    }

   } 

   form;
}


function pagarRecibo(e)
{


  function periodos()
  {

  var row =  document.querySelectorAll('.linea');
  var checkbox = document.querySelectorAll('.value');
  var periodos = [];
  

    for(var i = 0 ; i < checkbox.length ; i++)
    { 
          if(checkbox[i].checked)
          {
            periodos.push(row[i].cells[2].innerHTML);
          }
    }
    return periodos;
  }

 var periodos = periodos();

      if(periodos.length > 0)
      {
        //btn.href = direccion;
        e.preventDefault();
          $('#exec').modal('show');
        
      }else
      {
        Swal.fire({
          type: 'error',
          title: 'Ooops',
          text: 'Favor de seleccionar periodo a pagar'
        });
        e.preventDefault();
      }

}


 function periodos()
  {

  var row =  document.querySelectorAll('.linea');
  var checkbox = document.querySelectorAll('.value');
  var periodos = [];

    for(var i = 0 ; i < checkbox.length ; i++)
    { 
          if(checkbox[i].checked)
          {
            periodos.push(row[i].cells[2].innerHTML);
          }
    }
    return periodos;
  }



function tipoPago()
{

 
  var numeroAutorizacion = document.getElementById('numero');
  var fichaDeposito =  document.getElementById('deposito');
  var option = document.getElementById('tipopago').value;

  if(option == 0)
  {
    numeroAutorizacion.style.display =  'none';
    fichaDeposito.style.display = 'none';
  }else if(option == 1)
  {
    numeroAutorizacion.style.display = 'none';
    fichaDeposito.style.display = 'none';
  }else if(option == 2)
  {
    numeroAutorizacion.style.display = 'block';
    fichaDeposito.style.display = 'none';
    numeroAutorizacion.value = '';
  }else if(option == 3)
  {
    numeroAutorizacion.style.display = 'none';
    fichaDeposito.style.display = 'block';
  }
  else if(option == 4)
  {
    numeroAutorizacion.style.display = 'block';
    fichaDeposito.style.display = 'none';
    numeroAutorizacion.value = '';
  }

}






