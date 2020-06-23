// Accion para el boton de cancelar
$("#btnCancelClient").on('click', function(){
  // Cerrar modal
  $('#modal-createClient').modal('hide');
  location.reload();
});

// Accion para el Submit del Modal
$("#form-create-client").on('submit',function(e) {
	e.preventDefault();

  var dataString = $('#form-create-client').serialize();
  console.log(dataString);
  //Validacion del formulario
  var nombre = $("#nombre").val();
  var ap_paterno = $("#ap_paterno").val();
  var ap_materno = $("#ap_materno").val();
  var genero = $("#genero").val();

  if (nombre == '') {
    swal({
      title:'Nombre',
      html:'El campo <b>Nombre</b> no puede estar vacio.',
      type:'info',
      confirmButtonText: 'ACEPTAR'
    })

  }else if(ap_materno == ''){
    swal({
      title:'Apellido paterno',
      html:'El campo <b>Apellido paterno</b> no puede estar vacio.',
      type:'info',
      confirmButtonText: 'ACEPTAR'
    })

  }else if(ap_materno == ''){
    swal({
      title:'Apellido materno',
      html:'El campo <b>Apellido materno</b> no puede estar vacio.',
      type:'info',
      confirmButtonText: 'ACEPTAR'
    })

  }else if(genero == ''){
    swal({
      title:'Genero',
      text:'Seleccione un genero.',
      type:'info',
      confirmButtonText: 'ACEPTAR'
    })

  } else {
    // Inicia AJAX
    $.ajax({
      dataType:"json",
      url:$("form").attr("action"),
      type:$("form").attr("method"),
      data: dataString
    }).done(function(data){
    // Mostrar dato en consola
    console.log(data);
    if (data.status == true) {
      // Cerrar modal
      $('#modal-createClient').modal('hide');
      // Mostrar SweetAlert
      swal({
        title:'Cliente',
        text:'Cliente creado exitosamente.',
        type:'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ACEPTAR'
      }).then((result) => {
        if (result.value) {
              // Refrescar pagina
              location.reload();
            }
          })
    }else{
      // Cerrar modal
      $('#modal-createClient').modal('hide');
      // Mostrar SweetAlert
      swal({
        title:'Error',
        text:'Hubo un error al crear el cliente.',
        type:'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ACEPTAR'
      }).then((result) => {
        if (result.value) {
              // Refrescar pagina
              location.reload();
            }
          })
    }        
  });
  // Finaliza AJAX
}
});
