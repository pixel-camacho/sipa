
$("#btnCerrar").on('click', function(){
  $('#modalUp').modal('hide');
  location.reload();
});

// Accion para el Submit del Modal
$("#form-document").on('submit',function(e) {
	e.preventDefault();

  var archivo = $("#mi_file").val();
  
  // Validacion de datos
  
   if(archivo == ''){
    swal({
      title:'Archivo',
      html:'Seleccione un <b>Archivo</b>.',
      type:'info',
      confirmButtonText: 'ACEPTAR'
    })

  } else {
    $.ajax({
      dataType:"json",
      url:$("form").attr("action"),
      type:$("form").attr("method"),
      cache:false,
      contentType:false,
      processData:false,
      data: new FormData(this)
    }).done(function(data){
    // Imprimir respuesta en consola
    console.log(data);
    // Validacion de respuestas
    if (data.status == 'ok') {
      // Cerrar modal
      $('#modalUp').modal('hide');
      // Mostrar SweetAlert
      swal({
        title:'Documento',
        text:'Documento subido exitosamente.',
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
    }else if(data.status == 'wrongFile'){
      // Cerrar modal
      $('#modalUp').modal('hide');
            // Mostrar SweetAlert
            swal({
              title:'Archivo',
              text:'El tipo de archivo seleccionado no es valido.',
              type:'warning',
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
      $('#modalUp').modal('hide');
      // Mostrar SweetAlert
      swal({
        title:'Error',
        text:'Hubo un error al subir el archivo.',
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
  }
});


