<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .card{
            margin: 0 auto;
        }
        #error{
            color: red;
            display: none;
        }
        #error1{
            color: red;
            display: none;
        }
        .btn{
            width:50%;
            margin: 0 auto;
        }
        #loading{
            display: none;
        }
    </style>
</head>
<body>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h3> <strong>Bienvenido</strong></h3>
                            <hr>
                            <div class="row text-center">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Cargar Archivo Excel</h5>
                                        <form action="http://190.9.53.22:8484/apiSIPA/gmm/boom" enctype="multipart/form-data" method="POST" id="frm">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">Cargar</span>
                                                </div>
                                                <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="mi_file" name="mi_file" aria-describedby="inputGroupFileAddon01">
                                                <label  class="custom-file-label" for="mi_file" id=label>Buscar Documento</label>
                                                </div>
                                            </div>
                                            <span id="error">Favor de cargar documento</span>
                                            <span id="error1">Extension no valida</span></span>
                                        </div>
                                            <input type="button" class="btn btn-danger btn-rounded" value="Cancelar" id="cancelar">
                                            <input type="submit" class="btn btn-success btn-rounded my-4" value="Editar" id="enviar"/>
                                            <span><img src="<?php echo base_url('assets/images/load/35.gif') ?>" alt="load" id="loading"></span>
                                          </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
       document.getElementById('enviar').addEventListener('click',validar);
       document.getElementById('mi_file').addEventListener('change',getName);
       document.getElementById('cancelar').addEventListener('click',reset);

        function getName()
        {
            let error = document.getElementById('error');
            let archivo = document.getElementById('mi_file').files[0].name;
            let formato = document.getElementById('error1');

            document.getElementById('label').innerHTML = archivo;
            error.style.display = 'none';
            formato.style.display = 'none';


        }

        function reset()
        {
            document.getElementById('frm').reset();
            document.getElementById('label').innerHTML = "Buscar Documento";
        }

        function validar(e)
        {
            let excel = document.getElementById('mi_file').value;
            let error = document.getElementById('error');
            let error1 = document.getElementById('error1');
            let extensionesValidas = /(.xls|.xlsx)$/i;
            var valor = 'hola';

              if(excel == "")
              {
                error.style.display = 'block';
                e.preventDefault();

              }else if(! extensionesValidas.exec(excel))
              {
                 error1.style.display = 'block';
                 e.preventDefault();
              }else
              {
                error1.style.display = 'none';
              }
        }

        $("#frm").submit((e)=>
        {
            e.preventDefault();

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
    });
        });

 
        
    </script>
    
</body>
</html>