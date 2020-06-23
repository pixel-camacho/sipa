<!-- partial -->
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-12 grid-margin">
            <div class="card">
               <div class="card-body">
                  <div  >
                     <div class="container">
                        <div class="row">
                          
                           <div class="col-md-12">
                              <?php if(isset($_SESSION['exito'])): ?>
                                  <script>
                                       swal({
                                           position: 'center',
                                              type: 'success',
                                              title: '<?= $this->session->userdata('exito'); ?>',
                                              showConfirmButton: false,
                                              timer: 1500

                                        })

                                             </script>

                                <?php endif ?>
                              <h3>Administrar Permisos del Rol</h3> 
                            <div class="row">
                                <div class="col-md-6">
                                    
                                       <a  href="<?= base_url('/user/index') ?>" class="btn btn-secondary btn-fw">Usuarios</a>
                                          <a  href="<?= base_url('/rol/index') ?>" class="btn btn-secondary btn-fw">Roles</a>
                                         <a  href="<?= base_url('/permiso/index') ?>" class="btn btn-secondary btn-fw">Permisos</a>
                                       
                                </div>
                                <div class="col-md-6"></div>
                             </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <form method="POST" action="<?= base_url('rol/agregarrolpermiso') ?>">
                                  <?php foreach($permisos as $permiso) { ?>
                                        <div class="form-check form-check-flat">
                                          <label class="form-check-label">
                                            <input type="checkbox" name="permiso[]" class="form-check-input" value="<?php echo $permiso["id"] ?>"  <?php if($permiso["status"]=="1"){echo "checked";} ?>> <?php   if($permiso["description"] != "") { echo $permiso["description"]."  - ".$permiso["uri"]; }else{ echo "Sin descripcion"."  - ".$permiso["uri"];} ?>
                                          </label>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="rol" value="<?php echo $permiso["rol"] ?>">
                                     <button type="submit"  class="btn btn-primary btn-fw">Guardar</button>
                                  </form>
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                             </div>
                             
                           </div>
                        </div> 
                     </div> 
                  </div>
               </div>
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