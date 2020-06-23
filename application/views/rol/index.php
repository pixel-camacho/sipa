<!-- partial -->
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-12 grid-margin">
            <div class="card">
               <div class="card-body">
                  <div id="app">
                     <div class="container">
                        <div class="row">
                           <transition
                              enter-active-class="animated fadeInLeft"
                              leave-active-class="animated fadeOutRight">
                              <div class="notification is-success text-center px-5 top-middle" v-if="successMSG" @click="successMSG = false">{{successMSG}}</div>
                           </transition>
                           <div class="col-md-12">
                             <h3>Administrar Roles</h3> 
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary btn-fw" @click="addModal= true">Nuevo Rol</button>
                                       <a  href="<?= base_url('/user/index') ?>" class="btn btn-secondary btn-fw">Usuarios</a>
                                         <a  href="<?= base_url('/permiso/index') ?>" class="btn btn-secondary btn-fw">Permisos</a>
                                       
                                </div>
                                <div class="col-md-6"></div>
                             </div>
                              <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <input placeholder="Buscar" type="search" class="form-control" v-model="search.text" @keyup="searchUser" name="search">
                                </div>
                             </div>
                             <br>
                              <table class="table is-bordered is-hoverable">
                                 <thead class="text-white bg-dark" >
                                    <th class="text-white">Rol</th>
                                    
                                    <th class="text-center text-white">Action</th>
                                 </thead>
                                 <tbody class="table-light">
                                    <tr v-for="rol in roles" class="table-default">
                                       <td>{{rol.rol}}</td> 
                                       <td align="right">
                                        <button type="button" class="btn btn-icons btn-rounded btn-success" @click="editModal = true; selectRol(rol)" title="Modificar Datos">
                                                 <i class="fa  fa-edit"></i>
                                                </button>
                                       
                                                <a v-bind:href="'rolpermisos/'+ rol.id" class="btn btn-icons btn-rounded btn-info"><i class="fa fa-eye"></i></a>
                                       
                                    
                                    </td>
                                    </tr>
                                    <tr v-if="emptyResult">
                                       <td colspan="9" rowspan="4" class="text-center h1">No Record Found</td>
                                    </tr>
                                 </tbody>
                                  <tfoot>
                                      <tr>
                                          <td colspan="5" align="right">
                                               <pagination
                                                         :current_page="currentPage"
                                                         :row_count_page="rowCountPage"
                                                         @page-update="pageUpdate"
                                                         :total_users="totalRoles"
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
                     <?php include 'modal.php';?>
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
 <script src="<?php echo base_url();?>/assets/vue/appvue/approl.js"></script> 