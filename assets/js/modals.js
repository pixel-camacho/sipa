
// cambiar el label de input file
$('#file').change(()=>{
  let namedoc = document.getElementById('file').files[0]['name'];
   $('#lbl-text').text(namedoc); 
});

// action btn cerrar
$("#btnClose").click(() =>{
  $('#modalReparto').modal('hide');
  location.reload();
});

$('#form-reparto').submit((e)=>{
    e.preventDefault();
	var doc = $('#file').val();

	if(doc == '' ){
			 swal({
	      title:'Documento',
	      html:'Seleccione un <b>Documento</b>.',
	      type:'info',
	      confirmButtonText: 'ACEPTAR'
	    })
	}else{
		var form = $('#form-reparto').get(0);
		 $.ajax({
      dataType:"json",
      url:$("form").attr("action"),
      type:$("form").attr("method"),
      cache:false,
      contentType:false,
      processData:false,
      data: new FormData(form)
    }).done(function(data){
    // Imprimir respuesta en consola
    console.log(data);
    // Validacion de respuestas
    if (data.status == 'ok') {
      // Cerrar modal
      $('#modalReparto').modal('hide');
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
      $('#modalReparto').modal('hide');
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
      $('#modalReparto').modal('hide');
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