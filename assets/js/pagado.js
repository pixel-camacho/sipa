 if (data.status == 'ok') {
      // Cerrar modal
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
    }