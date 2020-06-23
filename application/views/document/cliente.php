    <script type="text/javascript">
      var data_score = '<?php echo $this->session->idusuario;?>';
    </script>    
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
         <div class="col-12 grid-margin">
          <div class="card">
           <div class="card-body">
            <!--Inicia el contenedor -->
            <div class="container">
             <div class="col-md-12">
              <h3><b>Información del cliente</b></h3> 
              <?php 
              if (!empty($clientInfo)) { 
                foreach ($clientInfo as $value) { ?>
                 <div class="row">
                  <div class="col-sm-3 text-center">
                    <label><b>Id usuario</b></label>
                    <p><?php echo $value->IdCliente;?></p>
                  </div>
                  <div class="col-sm-3 text-center">
                    <label><b>Nombre completo</b></label>
                    <p><?php echo $value->nombre." ".$value->apellido1." ".$value->apellido2;?></p>
                  </div>
                  <div class="col-sm-3 text-center">
                    <label><b>Género</b></label>
                    <?php
                    if (!empty($value->genero)) {
                     if ($value->genero == 'F') {
                       echo "<p>FEMENINO</p>";
                     } else {
                       echo "<p>MASCULINO</p>";
                     }
                   }
                   ?>
                 </div>
                 <div class="col-sm-3 text-center">
                  <label><b>Estado</b></label>
                  <?php if ($value->status == 'A') {
                   echo "<p>ACTIVO</p>";
                  }?>
               </div>
             </div>
           <?php }
         }?>
         <br/>
         <br/>
         <br/>
         <div class="row">
          <div class="col-md-5"> <h3><b>Listado de documentos</b></h3></div>
          <div class="col-md-5"></div>
          <div class="col-md-2">
           <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-uploadFile">
            <i class="mdi mdi-upload"></i>Documento</button>
          </div>
        </div>
        <br>
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap">
         <thead>
          <tr style="text-align: center;">
            <th>Nombre del documento</th>
            <th>Tipo de documento</th>
            <th>Tipo de producto</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody >
          <?php
          if(!empty($documentInfo)) {
            foreach($documentInfo as $document) { ?>
              <tr class="table-default">
               <td align="center"><?php echo $document->nombre_doc; ?></td>
               <td align="center"><?php echo $document->tipo_documento; ?></td>
               <td align="center"><?php echo $document->tipo_producto; ?></td>
               <td align="center">
                <?php 
                $file="./assets/IMGS/".$document->nombre_doc;
                if(file_exists($file)){?>
                  <a href="<?php echo base_url().'document/download/'.$document->nombre_doc; ?>" class="btn btn-icons btn-rounded btn-primary" style="padding: inherit;" >
                    <i class="mdi mdi-download"></i>
                  </a>
                  <!--<a href="javascript:void(0);" onclick="PrintImage('<?php echo base_url().'document/download/'.$document->nombre_doc; ?>')" class="btn btn-icons btn-rounded btn-success" style="padding: inherit;" >
                    <i class="mdi mdi-printer"></i>
                  </a>-->
                  <?php
                }else{?>
                  <button type="button" class="btn btn-icons btn-rounded btn-secondary"  style="padding: inherit;">
                    <i class="mdi mdi-window-close"></i></button>
                <?php }?>
              </td>
            </tr>
          <?php }
        }else{?>
          <tr>
           <td colspan="9" rowspan="4" class="text-center h1">No cuenta con documentos</td>
         </tr>
       <?php } ?>
     </tbody>
   </table>
</div>
</div> 
<!--Termina el contenedor -->
</div>

<!-- Seccion del Modal EDITAR USUARIO-->
<div class="modal" tabindex="-1" role="dialog" id="modal-uploadFile">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>SUBIR DOCUMENTO</b></h5>
        <button type="button btn-success" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-document" role="form" method="POST" action="<?php echo base_url();?>document/uploadDocument" enctype="multipart/form-data">
          <div class="row">
            <div  class="col-md-12">
             <div class="form-group">
              <label for="tipo_documento">Tipo de documento</label>
              <select class="form-control required" id="tipo_documento" name="tipo_documento" style="border-color:#80bdff;" >
                <option value="">Seleccione una opción</option>
                <?php
                if(!empty($tipos_documentos)) {
                  foreach ($tipos_documentos as $documento) { ?>
                    <option value="<?php echo $documento->iddocumento ?>"><?php echo $documento->descripcion ?></option>
                    <?php
                  }
                }
                ?>
              </select>
              <input type="hidden" name="IdCliente" id="IdCliente" value="<?php echo $Idcliente;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
           <div class="form-group">
            <label for="tipo_producto">Tipo de producto</label>
            <select class="form-control required" id="tipo_producto" name="tipo_producto" style="border-color:#80bdff;">
              <option value="">Seleccione una opción</option>
              <?php
              if(!empty($tipos_productos)) {
                foreach ($tipos_productos as $producto) { ?>
                  <option value="<?php echo $producto->idproducto ?>"><?php echo $producto->descripcion ?></option>
                  <?php
                }
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
           <input type="file" class="form-control" id="image" name="image" >
         </div>
       </div>
     </div>
   </div>
   <div class="modal-footer">
    <button type="button" id="btnCancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    <input type="submit" id="upload" class="btn btn-primary" value="Subir"/>
  </div>
</form>
</div>
</div>
</div>
<!-- Seccion del Modal EDITAR USUARIO-->
</div>
</div>
</div>
</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="container-fluid clearfix">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php echo date('Y') ?>
    <a href="http://www.proteges.mx" target="_blank">Proteges</a>. Todos los derechos reservados.</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Departamento de Sistemas
      <i class="fa fa-code text-danger"></i>
    </span>
  </div>
</footer>
<!-- partial -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/uploadDocument.js"></script> 

<script type="text/javascript">
  $(document).ready(function() {
    //Configuracion de opciones DataTable
    $('#example').DataTable({
      "searching": true,
      /*"pageLength": 50,*/
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      }
    });
  } );

    //Funcion para imprimir la imagen(No admite imagenes TIF)
    /*function PrintImage(imagePath) {
      var width = $(window).width() * 0.9;
      var height = $(window).height() * 0.9;
      var content = '<!DOCTYPE html>' + 
      '<html>' +
      '<head><title></title></head>' +
      '<body onload="window.focus(); window.print(); window.close();">' + 
      '<img src="' + imagePath + '" style="width: 100%;" />' +
      '</body>' +
      '</html>';
      var options = "toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,width=" + width + ",height=" + height;
      var printWindow = window.open('', 'print', options);
      printWindow.document.open();
      printWindow.document.write(content);
      printWindow.document.close();
      printWindow.focus();
    }*/
  </script>