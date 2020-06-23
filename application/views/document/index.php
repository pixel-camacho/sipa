    <script type="text/javascript">
      var data_score = '<?php echo $this->session->idusuario;?>';
    </script>    
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
         <div class="col-12 grid-margin">
          <div class="card">
           <div class="card-body">
            <div id="app">
             <div class="container">
               <div class="col-md-12">
                <h3><b>Buscar cliente</b></h3> 
                <div class="row">
                  <div class="col-md-12">
                     <p style="color: red"><label>Forma de buscar:</label> Se de debe de buscar primero por nombre(s) y despues apellidos.</p>
                  </div>
                  <div class="col-md-4">
                   
                    <input type="search" class="form-control" v-model="search.text" @keyup="searchUser" name="search" 
                    style="border:1px solid #80bdff;" placeholder="ejemplo: FELIPE PEREZ GUZMAN">
                  </div>
                  <div class="col-md-6"></div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-fw" data-toggle="modal" data-target="#modal-createClient">
                      <i class="mdi mdi-account-plus"></i>Cliente</button>
                    </div>
                  </div>
                  <br>
                  <table class="table is-bordered is-hoverable">
                   <thead class="text-white bg-dark">
                    <tr>
                      <th class="text-white">Id</th>
                      <th class="text-white">Nombre completo</th>
                      <th class="text-white text-center">Acción</th>
                    </tr>
                  </thead>
                  <tbody class="table-light">
                    <tr v-for="user in users" class="table-default">
                     <td>{{user.IdCliente}}</td>
                     <td>{{user.nombre}} {{user.apellido1}} {{user.apellido2}}</td>
                     <td style="text-align: center;">
                      <a v-bind:href="'cliente/'+ user.IdCliente" class="btn btn-icons btn-rounded btn-success">
                        <i class="fa fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                  <tr v-if="emptyResult">
                   <td colspan="9" rowspan="4" class="text-center h1">Usuario no encontrado</td>
                 </tr>
               </tbody>
               <tfoot>
                <tr>
                  <td colspan="5" align="right">
                   <pagination
                   :current_page="currentPage"
                   :row_count_page="rowCountPage"
                   @page-update="pageUpdate"
                   :total_users="totalUsers"
                   :page_range="pageRange"
                   >
                 </pagination>

               </td>
             </tr>
           </tfoot>
         </table>
       </div>
     </div> 
   </div>
 </div>
</div>
</div>
</div>
</div>

<!-- Seccion del Modal AGREGAR CLIENTE-->
<div class="modal" tabindex="-1" role="dialog" id="modal-createClient">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>NUEVO CLIENTE</b></h5>
        <button type="button btn-success" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-create-client" role="form" method="POST" action="<?php echo base_url();?>document/createClient">
          <div class="row">
            <div  class="col-md-6">
             <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" style="border-color: #80bdff;" placeholder="Ingrese su nombre">
            </div>
          </div>
          <div  class="col-md-6">
           <div class="form-group">
            <label for="ap_paterno">Apellido paterno</label>
            <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" style="border-color: #80bdff;" placeholder="Ingrese su apellido paterno">
          </div>
        </div>
      </div>
      <div class="row">
        <div  class="col-md-6">
         <div class="form-group">
          <label for="ap_materno">Apellido materno</label>
          <input type="text" class="form-control" id="ap_materno" name="ap_materno" style="border-color: #80bdff;" placeholder="Ingrese su apellido materno">
        </div>
      </div>
      <div class="col-md-6">
       <div class="form-group">
        <label for="genero">Género</label>
        <select class="form-control required" id="genero" name="genero" style="border-color: #80bdff;">
          <option value="">Seleccione una opción</option>
          <option value="F">Femenino</option>
          <option value="M">Masculino</option>
        </select>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" id="btnCancelClient" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
  <input type="submit" id="btnCreateCliente" class="btn btn-primary" value="Crear"/>
</div>
</form>
</div>
</div>
</div>
<!-- Seccion del Modal AGREGAR CLIENTE-->
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/newClient.js"></script> 
<script src="<?php echo base_url();?>/assets/vue/appvue/document.js"></script>  
