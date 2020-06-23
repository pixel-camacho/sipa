<!-- partial -->
<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
</script>

<style type="text/css">
    .table td.demo {
        max-width: 177px;
    }
    .table td.demo span {
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        white-space: nowrap;
        max-width: 100%;
    }
</style>


<div class="main-panel">
    <style type="">
        .modal-body{
            max-height: calc(100vh - 200px);
            overflow-y: auto;

        } 
        /*.select2-container .select2-selection {
              height: 34px; 
                 padding-top: -30px;
          }*/

        @media screen and (min-width: 768px) {
            .modal-dialog {
                width: 700px; /* New width for default modal */
            }
            .modal-sm {
                width: 350px; /* New width for small modal */
            }
        }
        @media screen and (min-width: 992px) {
            .modal-lg {
                width: 1140px; /* New width for large modal */
            }
        }
  
        
        .select2 {
            width:100%!important;
        }
        
    </style>
    
    <div class="content-wrapper">
        <div id="app"> 
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h3><strong><i class="fa fa-users" aria-hidden="true"></i> Catálogo de Clientes</strong></h3>
                            <hr>



                            <button class="btn" style="background-color: rgba(255, 153, 51,.9);" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"  aria-hidden="true"></i> Nuevo</button>

                            <div class="modal fade bd-example-modal-lg" role="dialog" id="myModal" aria-labelledby="myLargeModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Agregar Cliente</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>


                                        <div class="modal-body" style="background-color: #fff">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Nombre(s):</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" :class="{'is-invalid': formValidate.nombre}" name="idusuario" v-model="nuevocliente.nombre" tabindex="1" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.nombre"> </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> RFC:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="4"  :class="{'is-invalid': formValidate.rfc}" name="rfc" v-model="nuevocliente.rfc" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.rfc"> </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Estado:</label> 
                                                        <select v-model="nuevocliente.estado" class="form-control " tabindex="7"  v-on:change="changeMunicipio($event)" :class="{'is-invalid': formValidate.estado}" >
                                                                <option value="">Seleccionar...</option>
                                                            <option   v-for="option in estados" v-bind:value="option.cveEstado">
                                                                {{ option.edoDescr }}
                                                            </option>

                                                        </select>
                                                        <div class="text-danger" v-html="formValidate.estado"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Calle:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="10" :class="{'is-invalid': formValidate.calle}" name="calle" v-model="nuevocliente.calle" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.calle"></div>
                                                    </div>

                                                       <div class="form-group">
                                                        <label><font color="red">*</font> Lugar nacimiento:</label>
                                                        <input type="text" class="form-control" tabindex="13" onkeyup="mayuscula(this);"  :class="{'is-invalid': formValidate.lugarnacimiento}" name="lugarnacimiento" v-model="nuevocliente.lugarnacimiento" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.lugarnacimiento"></div>
                                                    </div> 
                                                   <!-- <div class="form-group">
                                                        <label><font color="red">*</font> Nacionalidad:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="12" :class="{'is-invalid': formValidate.nacionalidad}" name="nacionalidad" v-model="nuevocliente.nacionalidad" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.nacionalidad"></div>
                                                    </div>
                                                    
                                                  <div class="form-group">
                                                        <label>CURP:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="15" :class="{'is-invalid': formValidate.curp}" name="nacionalidad" v-model="nuevocliente.curp" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.curp"></div>
                                                    </div> -->
                                                </div>



                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> A. Paterno:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="2"  :class="{'is-invalid': formValidate.aparterno}" name="aparterno" v-model="nuevocliente.aparterno" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.aparterno"> </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Sexo: </label><br>
                                                        <div class="form-control">
                                                            <input type="radio" name="status" tabindex="5" v-model="nuevocliente.sexo" value="1" > Masculino
                                                            <input type="radio" name="status" v-model="nuevocliente.sexo" value="2"> Femenino
                                                        </div>

                                                        <div class="text-danger" v-html="formValidate.sexo"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Municipio:</label>
                                                        <select v-model="nuevocliente.municipio"  tabindex="8"  v-on:change="changeColonia($event)" :class="{'is-invalid': formValidate.municipio}"class="form-control">
                                                                <option value="">Seleccionar...</option>
                                                            <option   v-for="option in municipios" v-bind:value="option.cveMunicipio">
                                                                {{ option.mpoDescripcion }}
                                                            </option> 
                                                        </select>
                                                        <div class="text-danger" v-html="formValidate.municipio"> </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> No. Exterior:</label>
                                                        <input type="text" class="form-control" tabindex="11" onkeyup="mayuscula(this);"  :class="{'is-invalid': formValidate.numeroexterior}" name="numeroexterior" v-model="nuevocliente.numeroexterior" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.numeroexterior"> </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label>Edad:</label>
                                                        <input type="text" class="form-control"  disabled="" tabindex="13" :class="{'is-invalid': formValidate.edad}" name="nacionalidad" v-model="nuevocliente.edad" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.edad"></div>
                                                    </div> 
                                                   <!-- <div class="form-group">
                                                        <label><font color="red">*</font> Fecha nacimiento:</label>
                                                        <input type="date" class="form-control"   tabindex="16" :class="{'is-invalid': formValidate.fechanacimiento}" name="fechanacimiento" v-model="nuevocliente.fechanacimiento" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.fechanacimiento"></div>
                                                    </div> -->
                                                </div>




                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>A. Materno:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="3"  :class="{'is-invalid': formValidate.amaterno}" name="amaterno" v-model="nuevocliente.amaterno" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.amaterno"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Correo Electrinico:</label>
                                                        <input type="email" class="form-control" tabindex="6" :class="{'is-invalid': formValidate.correo}" name="correo" v-model="nuevocliente.correo" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.correo"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><font size="3" color="red">*</font> Colonia</label>

                                                        <v-select  v-model="nuevocliente.colonia"  @input="setSelectedColonia" tabindex="9" item-value="cveColonia" label="coloniaDescr" :options="colonias"></v-select>
                                                        <div class="text-danger" v-html="formValidate.colonia"> </div>

                                                    </div> 

                                                   <!-- <div class="form-group">
                                                        <label><font color="red">*</font> Código Postal:</label>
                                                        <input type="text" class="form-control" v-bind:value="codigopostal" disabled=""  :class="{'is-invalid': formValidate.cp}" name="usuario"  >
                                                  

                                                    </div> -->

                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Ocupación:</label>
                                                        <input type="text" class="form-control" tabindex="14" onkeyup="mayuscula(this);"  :class="{'is-invalid': formValidate.ocupacion}" name="ocupacion" v-model="nuevocliente.ocupacion" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.ocupacion"></div>
                                                    </div>
                                                      <!--<div class="form-group">
                                                        <label>Edad:</label>
                                                        <input type="text" class="form-control"  disabled="" tabindex="13" :class="{'is-invalid': formValidate.edad}" name="nacionalidad" v-model="nuevocliente.edad" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.edad"></div>
                                                    </div> -->
                                                </div>

                                                <div class="col-md-3">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Fecha nacimiento:</label>
                                                        <input type="date" class="form-control"   tabindex="16" :class="{'is-invalid': formValidate.fechanacimiento}" name="fechanacimiento" v-model="nuevocliente.fechanacimiento" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.fechanacimiento"></div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label>CURP:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="15" :class="{'is-invalid': formValidate.curp}" name="nacionalidad" v-model="nuevocliente.curp" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.curp"></div>
                                                    </div>

                                                       <div class="form-group">
                                                        <label><font color="red">*</font> Código Postal:</label>
                                                        <input type="text" class="form-control" v-bind:value="codigopostal" disabled=""  :class="{'is-invalid': formValidate.cp}" name="usuario"  >

                                                    </div>

                                                             <div class="form-group">
                                                        <label><font color="red">*</font> Nacionalidad:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="12" :class="{'is-invalid': formValidate.nacionalidad}" name="nacionalidad" v-model="nuevocliente.nacionalidad" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.nacionalidad"></div>
                                                    </div>
                                                    
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-md-4">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Estado Civil:</label>
                                                        <select v-model="nuevocliente.estadocivil"  tabindex="17"  :class="{'is-invalid': formValidate.estadocivil}"class="form-control">
                                                                <option value="">Seleccionar...</option>
                                                            <option   v-for="option in estadocivil" v-bind:value="option.edoCivilId">
                                                                {{ option.edoCivilDescr }}
                                                            </option>

                                                        </select> 
                                                        <div class="text-danger" v-html="formValidate.estadocivil"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Centro de Trabajo:</label>
 
                                                        <v-select  v-model="nuevocliente.centrotrabajo"  @input="setSelected" tabindex="17"   item-value="centroTrabajoId" label="nombre" :options="centrosdetrabajos"></v-select>

                                                        <div class="text-danger" v-html="formValidate.centrotrabajo"> </div>
                                                    </div> 
                                                </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Contratante:</label>
                                                        <input type="text" class="form-control" v-bind:value="contratantedescripcion" disabled=""  tabindex="18"   :class="{'is-invalid': formValidate.contratante}"  autcomplete="off" >
                                                     </div>
                                                </div>
                                                 <div class="col-md-8">
                                                     <div class="form-group">
                                                         <label><font color="red">*</font> Dirección del Centro de Trabajo:</label>

                                                         <select v-model="nuevocliente.direccioncentrotrabajo"  tabindex="16"  :class="{'is-invalid': formValidate.direccioncentrotrabajo}"class="form-control">
                                                              <option value="">Seleccionar...</option>
                                                             <option   v-for="option in direccionescentrotrabajo" v-bind:value="option.centroTrabajoDetalleId">
                                                                 {{ option.direccion }}
                                                             </option>

                                                         </select> 
                                                         <div class="text-danger" v-html="formValidate.direccioncentrotrabajo"> </div>
                                                     </div> 
                                                 </div>
                                            </div>
                                          
                                            <div class="row">
                                                <div class="col-md-4">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Tipo Nomina:</label>
                                                        <select v-model="nuevocliente.tiponomina"   tabindex="20"   :class="{'is-invalid': formValidate.tiponomina}"class="form-control">
                                                                <option value="" >Seleccionar...</option>
                                                            <option   v-for="option in tiponominas"  v-bind:value="option.value">
                                                                {{ option.text }}
                                                            </option>

                                                        </select> 
                                                        <div class="text-danger" v-html="formValidate.tiponomina"></div>
                                                    </div>
                                                </div>
                                                        <div class="col-md-4">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Factura: </label><br>
                                                        <div class="form-control">
                                                            <input type="radio" name="factura" v-model="nuevocliente.factura" value="1" > Si
                                                            <input type="radio" name="factura" v-model="nuevocliente.factura" value="0"> No
                                                        </div>

                                                        <div class="text-danger" v-html="formValidate.factura"></div>
                                                    </div>
                                                </div>
                                                 <div class="col-md-4">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Estatus: </label><br>
                                                        <div class="form-control">
                                                            <input type="radio" name="status" v-model="nuevocliente.estatus" value="1" > Activo
                                                            <input type="radio" name="status" v-model="nuevocliente.estatus" value="0"> Inactivo
                                                        </div>

                                                        <div class="text-danger" v-html="formValidate.estatus"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div v-for="(user, index) in arraytelefono">
                                                <div class="row"> 
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><font color="red">*</font> Telefono:</label>
                                                            <input type="text" class="form-control"  v-model="user.numerotelefono" autcomplete="off" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><font color="red">*</font> Extensión:</label>
                                                            <input type="text" class="form-control"  v-model="user.extension" autcomplete="off" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><font color="red">*</font> Tipo telefono:</label> 
                                                            <select v-model="user.tipotelefono" class="form-control "  >
                                                                <option value="">Seleccionar...</option>
                                                                <option   v-for="option in tipostelefonos" v-bind:value="option.tipoTelefonoId">
                                                                    {{ option.tipoTelefonoDescr }}
                                                                </option>

                                                            </select> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">

                                                        <button type="button" style="margin-top: 25px;"  @click="deleteUser(index)" class="btn btn-danger btn-fw">
                                                            <i class="mdi mdi-alert-outline"></i>Eliminar</button>
                                                    </div>
                                                </div> 
                                              
                                            </div>
                                              <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" @click="addUser" class="btn btn-success btn-fw">
                                                            <i class="mdi mdi-check"></i>Agregar telefono</button>
 
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="button"  @click="addCliente" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           <div class="modal fade  " role="dialog" id="myModalModificar" aria-labelledby="myLargeModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Modificar Cliente</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>


                                        <div class="modal-body" style="background-color: #fff">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Nombre(s):</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" :class="{'is-invalid': formValidate.nombre}" name="idusuario" v-model="chooseCliente.nombrecliente" tabindex="1" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.nombre"> </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> RFC:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="4"  :class="{'is-invalid': formValidate.rfc}" name="rfc" v-model="chooseCliente.rfc" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.rfc"> </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Estado:</label> 
                                                        <select v-model="chooseCliente.cveEstado" class="form-control " tabindex="7"  v-on:change="changeMunicipio($event)" :class="{'is-invalid': formValidate.estado}" >
                                                             <option   v-for="option in estados"    :selected="option.cveEstado == chooseCliente.cveEstado ? 'selected' : ''" :value="option.cveEstado">
                                                                {{ option.edoDescr }}
                                                            </option> 
                                                        </select>
                                                        <div class="text-danger" v-html="formValidate.estado"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Calle:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="10" :class="{'is-invalid': formValidate.calle}" name="calle" v-model="chooseCliente.direccion" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.calle"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Nacionalidad:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="12" :class="{'is-invalid': formValidate.nacionalidad}" name="nacionalidad" v-model="chooseCliente.nacionalidad" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.nacionalidad"></div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>CURP:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="15" :class="{'is-invalid': formValidate.curp}" name="nacionalidad" v-model="chooseCliente.curp" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.curp"></div>
                                                    </div>


                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> A. Paterno:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="2"  :class="{'is-invalid': formValidate.aparterno}" name="aparterno" v-model="chooseCliente.apellidopaterno" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.aparterno"> </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Sexo: </label><br>
                                                        <div class="form-control">
                                                            <input type="radio" name="sexo" tabindex="5" v-model="chooseCliente.sexo" value="1" :checked="chooseCliente.sexo==1" > Masculino
                                                            <input type="radio" name="sexo" v-model="chooseCliente.sexo" value="2" :checked="chooseCliente.sexo==2"> Femenino
                                                        </div>

                                                        <div class="text-danger" v-html="formValidate.sexo"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Municipio:</label>
                                                        <select v-model="chooseCliente.cveMunicipio"  tabindex="8"  v-on:change="changeColonia($event)" :class="{'is-invalid': formValidate.municipio}"class="form-control">
                                                                <option value="">Seleccionar...</option>
                                                            <option   v-for="option in municipios" :selected="option.cveMunicipio == chooseCliente.cveMunicipio ? 'selected' : ''" :value="option.cveMunicipio">
                                                                {{ option.mpoDescripcion }}
                                                            </option> 
                                                        </select>
                                                        <div class="text-danger" v-html="formValidate.municipio"> </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> No. Exterior:</label>
                                                        <input type="text" class="form-control" tabindex="11" onkeyup="mayuscula(this);"  :class="{'is-invalid': formValidate.numeroexterior}" name="numeroexterior" v-model="chooseCliente.noExterior" autcomplete="off">
                                                               <div class="text-danger" v-html="formValidate.numeroexterior"> </div>
                                                    </div> 

                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Lugar nacimiento:</label>
                                                        <input type="text" class="form-control" tabindex="13" onkeyup="mayuscula(this);"  :class="{'is-invalid': formValidate.lugarnacimiento}" name="lugarnacimiento" v-model="chooseCliente.lugarNacimiento" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.lugarnacimiento"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Fecha nacimiento:</label>
                                                        <input type="date" class="form-control"   tabindex="16" :class="{'is-invalid': formValidate.fechanacimiento}" name="fechanacimiento" v-model="chooseCliente.fechaNacimiento" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.fechanacimiento"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>A. Materno:</label>
                                                        <input type="text" class="form-control" onkeyup="mayuscula(this);" tabindex="3"  :class="{'is-invalid': formValidate.amaterno}" name="amaterno" v-model="chooseCliente.apellidomaterno" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.amaterno"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Correo Electrinico:</label>
                                                        <input type="email" class="form-control" tabindex="6" :class="{'is-invalid': formValidate.correo}" name="correo" v-model="chooseCliente.email" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.correo"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><font size="3" color="red">*</font> Colonia</label>
                                                        <v-select   v-model="defaultSelected"  @input="setSelectedColonia" tabindex="9"  item-value="cveColonia" label="coloniaDescr" :options="colonias"></v-select>
                                                        <div class="text-danger" v-html="formValidate.colonia"> </div>

                                                    </div> 

                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Código Postal:</label>
                                                        <input type="text" class="form-control" v-bind:value="codigopostal" disabled=""  :class="{'is-invalid': formValidate.cp}" name="usuario"  >
                                                  

                                                    </div>

                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Ocupación:</label>
                                                        <input type="text" class="form-control" tabindex="14" onkeyup="mayuscula(this);"  :class="{'is-invalid': formValidate.ocupacion}" name="ocupacion" v-model="chooseCliente.ocupacion" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.ocupacion"></div>
                                                    </div>
                                                      <div class="form-group">
                                                        <label>Edad:</label>
                                                        <input type="text" class="form-control"  disabled="" tabindex="13" :class="{'is-invalid': formValidate.edad}" name="nacionalidad" v-model="nuevocliente.edad" autcomplete="off" >
                                                               <div class="text-danger" v-html="formValidate.edad"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Estado Civil:</label>
                                                        <select v-model="chooseCliente.edoCivil"  tabindex="17"  :class="{'is-invalid': formValidate.estadocivil}"class="form-control">
                                                                <option value="">Seleccionar...</option>
                                                            <option   v-for="option in estadocivil" v-bind:value="option.edoCivilId" :selected="option.edoCivilId == chooseCliente.edoCivil ? 'selected' : ''" :value="option.edoCivilId">
                                                                {{ option.edoCivilDescr }}
                                                            </option>

                                                        </select> 
                                                        <div class="text-danger" v-html="formValidate.estadocivil"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Centro de Trabajo:</label>
 
                                                        <v-select  v-model="defaultSelectedCentroTrabajo"  @input="setSelected" tabindex="17"   item-value="centroTrabajoId" label="nombre" :options="centrosdetrabajos"></v-select>
                                                        
                                                         
                                                        <div class="text-danger" v-html="formValidate.centrotrabajo"> </div>
                                                    </div> 
                                                </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><font color="red">*</font> Contratante:</label>
                                                        <input type="text" class="form-control" v-bind:value="contratantedescripcion" disabled=""  tabindex="18"   :class="{'is-invalid': formValidate.contratante}"  autcomplete="off" >
                                                     </div>
                                                </div>
                                                 <div class="col-md-8">
                                                     <div class="form-group">
                                                         <label><font color="red">*</font> Dirección del Centro de Trabajo:</label>
                                                        <select class="form-control" v-model="chooseCliente.detalleCentroTrabajoId" > 
                                                                         <option v-for="option in direccionescentrotrabajo"  :selected="option.centroTrabajoDetalleId == chooseCliente.detalleCentroTrabajoId ? 'selected' : ''" :value="option.centroTrabajoDetalleId" >
                                                                             {{ option.direccion }}
                                                                         </option>
                                                                    </select>
                                                          

                                                         </select> 
                                                         <div class="text-danger" v-html="formValidate.direccioncentrotrabajo"> </div>
                                                     </div> 
                                                 </div>
                                            </div>
                                          
                                            <div class="row">
                                                <div class="col-md-4">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Tipo Nomina:</label>
                                                        <select v-model="chooseCliente.tipoNomina"   tabindex="20"   :class="{'is-invalid': formValidate.tiponomina}"class="form-control">
                                                                <option value="" >Seleccionar...</option>
                                                            <option   v-for="option in tiponominas"  v-bind:value="option.value"  :selected="option.value == chooseCliente.tipoNomina ? 'selected' : ''" :value="option.value">
                                                                {{ option.text }}
                                                            </option>

                                                        </select> 
                                                        <div class="text-danger" v-html="formValidate.tiponomina"></div>
                                                    </div>
                                                </div>
                                                 <div class="col-md-4">
                                                     <div class="form-group">
                                                       <label><font color="red">*</font> Factura: </label>
                                                         <div class="form-control">
                                                         <input type="radio" name="facturar" v-model="chooseCliente.facturar" value="1" :checked="chooseCliente.facturar==1"> Si
                                                         <input type="radio" name="facturar" v-model="chooseCliente.facturar" value="0" :checked="chooseCliente.facturar==0"> No
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.factura"></div>
                                                    </div> 
                                                </div>
                                                 <div class="col-md-4">
                                                     <div class="form-group">
                                                        <label><font color="red">*</font> Estatus: </label><br>
                                                        <div class="form-control">
                                                            <input type="radio" name="status" v-model="chooseCliente.estatusCliente" value="1" :checked="chooseCliente.estatusCliente==1"> Activo
                                                            <input type="radio" name="status" v-model="chooseCliente.estatusCliente" value="0" :checked="chooseCliente.estatusCliente==0"> Inactivo
                                                        </div>

                                                        <div class="text-danger" v-html="formValidate.estatus"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            
                                            <div v-for="(user, index) in arraytelefono">
                                                <div class="row"> 
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><font color="red">*</font> Telefono:</label>
                                                            <input type="text" class="form-control"  v-model="user.numerotelefono" autcomplete="off" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><font color="red">*</font> Extensión:</label>
                                                            <input type="text" class="form-control"  v-model="user.extension" autcomplete="off" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><font color="red">*</font> Tipo telefono:</label> 
                                                            <select v-model="user.tipotelefono" class="form-control "  >
                                                                <option value="">Seleccionar...</option>
                                                                <option   v-for="option in tipostelefonos" v-bind:value="option.tipoTelefonoId">
                                                                    {{ option.tipoTelefonoDescr }}
                                                                </option>

                                                            </select> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">

                                                        <button type="button" style="margin-top: 25px;"  @click="deleteUser(index)" class="btn btn-warning btn-fw">
                                                            <i class="mdi mdi-alert-outline"></i> Quitar</button>
                                                    </div>
                                                </div> 
                                              
                                            </div>
                                              <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" @click="addUser" class="btn btn-success btn-fw">
                                                            <i class="mdi mdi-check"></i>Agregar telefono</button>
 
                                                    </div>
                                                </div>
                                            <hr>
                                             
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr class="table-secondary">
                                                              
                                                                <th scope="col">Telefono</th>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr  v-for="option in telcliente" >
                                                               <td>{{option.telefono}}</td> 
                                                                <td>{{option.tipotelefonoDescr}}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-rounded btn-fw btn-sm"  @click="selectTelefonoCliente(option)"><i class="mdi mdi-delete"></i> Eliminar</button>
                                                                </td> 
                                                            </tr>
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="button"  @click="updateCliente" class="btn btn-primary">Modificar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <br> <br> 
                            <div class="row">
                                <div class="col-sm-2">
                                    <label>RFC</label>
                                    <input placeholder="RFC" type="text" id="search" class="form-control"  name="search"  ref="rfc" @keyup.enter="searchSolicitud()">
                                </div>
                                <div class="col-sm-3">
                                    <label>Apellido Paterno</label>
                                    <input placeholder="Apellido Paterno" type="text" id="search" class="form-control"  name="search"  ref="apellidop" @keyup.enter="searchSolicitud()">
                                </div>
                                <div class="col-sm-3">
                                    <label>Apellido Materno</label>
                                    <input placeholder="Apellido Materno" type="text" id="search" class="form-control"  name="search"  ref="apellidom" @keyup.enter="searchSolicitud()">
                                </div>
                                <div class="col-sm-2">
                                    <label>Nombre</label>
                                    <input placeholder="Nombre" type="text" id="certificado" class="form-control"  name="certificado"  ref="nombre" @keyup.enter="searchSolicitud()">
                                </div>
                                <div class="col-sm-2" align="left" style="padding-top: 35px;" >
                                    <button type="button" style="background-color: rgba(255, 153, 51,0.9);" @click.prevent="searchSolicitud()" class="btn btn-fw"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                                    <div v-if="loading" class="circle-loader"></div> 

                                </div>
                            </div>
                            <hr>
                            <div v-if="mostrar">  
                                <div class="container">
                       <div class="row"> 
                                 <table v-if="solicitudes.length" class="table-responsive table-striped  table-hover">
                                            <thead  >
                                                <tr>
                                                    <th class="th-sm">RFC</th> 
                                                    <th class="th-sm" style=" padding-left: 20px;">Nombre</th> 
                                                    <th class="th-sm"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="solicitud in solicitudes" class="table-default"  > 
                                                    <td> 
                                                        <a :href="'/sipa/cliente/detalle/' + solicitud.idCliente">{{solicitud.rfc}}</a>
                                                    </td> 
                                                    <td style="padding-left: 20px;" >
                                                        
                                                        {{solicitud.nombreresponsable}}<br>
                                                        <strong>Beneficiarios:</strong> {{solicitud.nombreresponsable}}<br>
                                                        <strong>Asegurados:</strong> {{solicitud.asegurados}}<br>

                                                        <strong>Pólizas:</strong> {{solicitud.polizas}}
                                                       
                                                         
                                                    </td>
                                                    <td align="right">
                                        <button type="button" class="btn btn-icons btn-rounded btn-success"  @click="showModalEdit(); selectCliente(solicitud)"  title="Modificar Datos">
                                                 <i class="fa  fa-edit"></i>
                                                </button>
                                                    </td>
                                                </tr> 
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3"  >
                                            <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalSolicitudes"
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
</div>
<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script> 

<script src="https://unpkg.com/vue-select@latest"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">

<!-- or point to a specific vue-select release -->
<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">


<script>
Vue.config.devtools = true
Vue.component('v-select', VueSelect.VueSelect)

Vue.component('modal', {//modal
    template: `
   <transition   name="modal">
      <div  class="modal-mask"  >
        <div  class="modal-wrapper " >
    
          <div  class="modal-dialog modal-lg"  >
          <div   class="modal-content"   >
            

            <div class="modal-header">
                <h5 class="modal-title"> <slot name="head"></slot></h5> 
               
              </div>

            <div class="modal-body" style="background-color:#fff;">
               <slot name="body"></slot>
            </div>
            <div class="modal-footer">

              <slot name="foot"> 
              </slot>
            </div>
          </div>
          </div>
 
        </div>
      </div>
    </transition> 
    `
})

var v = new Vue({
    el: '#app',
    data: {
        url: 'http://190.9.53.22:8484/sipa/',
        loading: false,
        addModal: false,
        editModal: false,
        mostrar: true,
        solicitudid: 0,
        contratanteid: 0,
        descuentoperiodo: 0,
        detallepoliza: false,
        solicitudes: [],
        estados: [],
        municipios: [],
        colonias: [],
        estadocivil: [],
        centrosdetrabajos: [],
        tipostelefonos: [],
        direccionescentrotrabajo:[],
        telcliente:[],
        errors: [],
        search: {
            text: ''
        },
         defaultSelected: {
          cveColonia: '',
          coloniaDescr: ''
        },
         defaultSelectedCentroTrabajo: {
          centroTrabajoId: '',
          nombre: '',
          contratante:''
        },
        nuevocliente: {
            nombre: '',
            aparterno: '',
            amaterno: '',
            rfc: '',
            sexo: '',
            correo: '',
            estado: '',
            municipio: '',
            colonia: '',
            calle: '',
            numeroexterior: '',
            cp: '',
            nacionalidad: '',
            lugarnacimiento: '',
            ocupacion: '',
            curp: '',
            fechanacimiento: '',
            edad: '',
            estadocivil: '',
            centrotrabajo: '',
            contratante: '',
            direccioncentrotrabajo: '',
            tiponomina: '',
            factura: '',
            estatus: '',
        },
        agregarCobro: {
            abono: '',
            formapago: '',
            movimiento: '',
            fichadeposito: '',
            fechacobro: '',
            periodoacobrar: ''
        },
        tiponominas: [
            {text: 'I-Activo, descuento mensual', value: 'I'},
            {text: 'J-Jubilado', value: 'J'},
            {text: 'S-Activo, CBTis o Tec.', value: 'S'},
            {text: 'D-Jubilado descentralizado.', value: 'D'},
             {text: 'NO DEFINIDO.', value: '0'}
        ],

        formValidate: [],
        successMSG: '',

        scorePlayer: data_score,
        chooseCliente: {}, 
        chooseTelefonoCliente: {}, 
        currentPage: 0,
        rowCountPage: 5,
        totalSolicitudes: 0,
        pageRange: 2,

        //Cliente
        codigopostal: '',
        contratantedescripcion:'',
        arraytelefono: [{numerotelefono: '', extension: '', tipotelefono: ''}],
        idcliente:''
       

    },
    created() {
        //console.log(this.scorePlayer)
        this.allEstados();
        this.allEstadoCivil();
        this.allCentrosTrabajos();
        this.allTiposTelefonos(); 

    },
   
    methods: {
        searchSolicitud() {
            this.loading = true;
            NProgress.start()
            this.mostrar = true;
            this.detallepoliza = false;
            axios.get('http://190.9.53.22:8484/apiSIPA/cliente/buscarCliente', {
                params: {
                    rfc: this.$refs.rfc.value,
                    nombre: this.$refs.nombre.value,
                    apellidop: this.$refs.apellidop.value,
                    apellidom: this.$refs.apellidom.value
                    
                 
                }
            }).then(function (response) {
                console.log(response.data.solicitudes);
                if (response.data.solicitudes === null) {


                    NProgress.done()
                    v.noResult()

                } else {
                    NProgress.done()
                    v.getData(response.data.solicitudes); 

                }
            });

        },
       
        addUser: function () {
            this.arraytelefono.push({numerotelefono: '', extension: '', tipotelefono: ''});
        },
        deleteUser: function (index) {
            console.log(index);
            console.log(this.finds);
            this.arraytelefono.splice(index, 1);
            if (index === 0)
                this.addUser()
        },
        allEstados() {

            axios.get("http://190.9.53.22:8484/apiSIPA/Estados/todosEstados")
                    .then(response => (this.estados = response.data));

        },
        allTiposTelefonos() {

            axios.get("http://190.9.53.22:8484/apiSIPA/tipotelefono/todosTiposTelefonos")
                    .then(response => (this.tipostelefonos = response.data));

        },
        allCentrosTrabajos() {

            axios.get("http://190.9.53.22:8484/apiSIPA/centrotrabajo/todosCentrosTrabajos")
                    .then(response => (this.centrosdetrabajos = response.data));

        },
        allEstadoCivil() {

            axios.get("http://190.9.53.22:8484/apiSIPA/estadocivil/todosEstadoCivil")
                    .then(response => (this.estadocivil = response.data));

        },
        changeMunicipio: function changeItem(event) {
            console.log(event.target.value);
            axios.get("http://190.9.53.22:8484/apiSIPA/municipio/todosMunicipio", {
                params: {
                    idmunicipio: event.target.value
                }
            })
                    .then(response => (this.municipios = response.data));
        },
        changeColonia: function changeItem(event) {
          console.log(event.target.value);
            axios.get("http://190.9.53.22:8484/apiSIPA/colonia/todasColonia", {
                params: {
                    idmunicipio: event.target.value
                }
            })
                    .then(response => (this.colonias = response.data));
            this.defaultSelected="";
        },
            setSelected(value) {
                console.log(value);
                this.contratantedescripcion  = value.contratante;
                axios.get("http://190.9.53.22:8484/apiSIPA/centrotrabajo/direccionesCentroTrabajo", {
                         params: {
                             id:value.centrotrabajoid
                         }
                     })
                             .then(response => (this.direccionescentrotrabajo = response.data));
                     
                     v.chooseCliente.detalleCentroTrabajoId="";

           },
               setSelectedColonia(value) {
               
             this.codigopostal  = value.codigoPostal;
                             
                
                   

           },
           showModalEdit() {
                $('#myModalModificar').modal('show');
              },
          hideModal() {
                this.$refs['my-modal'].hide()
              },
        getData(solicitudes) {
            this.loading = false;
            v.emptyResult = false; // become false if has a record
            v.totalSolicitudes = solicitudes.length //get total of user
            v.solicitudes = solicitudes.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.solicitudes.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                //v.clearAll();  
            }
        },
        noResult() {
            this.loading = false;
            v.emptyResult = true; // become true if the record is empty, print 'No Record Found'
            v.solicitudes = null
            v.totalSolicitudes = 0 //remove current page if is empty

        },
        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh()
        },
          refresh(){
             v.search.text ? v.searchSolicitud() : v.searchSolicitud(); //for preventing
            
        },
        selectTelefonoCliente(telefono){
            v.chooseTelefonoCliente = telefono;
             const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'Esta seguro?',
                    text: "¡No podrás revertir esto",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Eliminar!',
                    cancelButtonText: 'No, Cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.get("http://190.9.53.22:8484/apiSIPA/TelefonosCliente/eliminarTelefonoCliente", {
                         params: { id:v.chooseTelefonoCliente.idDetTel }
                            });
                        
                     
                        swalWithBootstrapButtons(
                            'Periodo!',
                            'Fue Eliminado con Exito.',
                            'success',

                        );
                         axios.get("http://190.9.53.22:8484/apiSIPA/TelefonosCliente", {
                         params: { idcliente:v.chooseTelefonoCliente.idCliente }
                            }).then(response => (  this.telcliente = response.data   )); 
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons(
                            'Cancelado',
                            'Fue cancelado la operacion.',
                            'error'
                        )
                    }
                });
             axios.get("http://190.9.53.22:8484/apiSIPA/TelefonosCliente", {
                         params: { idcliente:v.chooseTelefonoCliente.idCliente }
                            }).then(response => (  this.telcliente = response.data   )); 
             
        },
        selectCliente(cliente) {
            v.chooseCliente = cliente;
            console.log(this.chooseCliente.facturar);
            v.defaultSelected.cveColonia=v.chooseCliente.cveColonia;
            v.defaultSelected.coloniaDescr=v.chooseCliente.coloniaDescr;
            v.defaultSelectedCentroTrabajo.centroTrabajoId=v.chooseCliente.centroTrabajoId;
            v.defaultSelectedCentroTrabajo.nombre=v.chooseCliente.nombre;
             v.defaultSelectedCentroTrabajo.contratante=v.chooseCliente.contratante;
             v.codigopostal=v.chooseCliente.codigoPostal;
             v.contratantedescripcion=v.chooseCliente.contratante;
             axios.get("http://190.9.53.22:8484/apiSIPA/municipio/todosMunicipio", {
                params: {
                    idmunicipio: v.chooseCliente.cveEstado
                }
            })
                    .then(response => (this.municipios = response.data));
            axios.get("http://190.9.53.22:8484/apiSIPA/colonia/todasColonia", {
                params: {
                    idmunicipio: v.chooseCliente.cveMunicipio
                }
            })
                    .then(response => (this.colonias = response.data));
            
              
                axios.get("http://190.9.53.22:8484/apiSIPA/centrotrabajo/direccionesCentroTrabajo", {
                         params: {
                             id:v.chooseCliente.centroTrabajoId
                         }
                     })
                             .then(response => (this.direccionescentrotrabajo = response.data));
                     
                  
                axios.get("http://190.9.53.22:8484/apiSIPA/TelefonosCliente", {
                         params: {
                             idcliente:v.chooseCliente.idCliente
                         }
                     })
                             .then(response => (  this.telcliente = response.data   )); 
                     
                     
 
        },

        clearAll() {
            v. nuevocliente = {
            nombre: '',
            aparterno: '',
            amaterno: '',
            rfc: '',
            sexo: '',
            correo: '',
            estado: '',
            municipio: '',
            colonia: '',
            calle: '',
            numeroexterior: '',
            cp: '',
            nacionalidad: '',
            lugarnacimiento: '',
            ocupacion: '',
            curp: '',
            fechanacimiento: '',
            edad: '',
            estadocivil: '',
            centrotrabajo: '',
            contratante: '',
            direccioncentrotrabajo: '',
            tiponomina: '',
            factura: '',
            estatus: '',
        };
            v.refresh(),
              $('#myModal').modal('hide');

        },
        cerrarModals() {
            v.addModal = false;
            v.editModal = false;
            v.editAbonoModal = false;
            v.errors = false;
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        addCliente() {
            
            var formData = v.formData(v.nuevocliente);
                formData.append('idcentrotrabajo', v.nuevocliente.centrotrabajo.centrotrabajoid);
                formData.append('idcolonia', v.nuevocliente.colonia.cveColonia); 

 
            axios.post("http://190.9.53.22:8484/apiSIPA/cliente/insertarCliente", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                } else { 
                    v.idcliente=response.data;
                    console.log(v.idcliente);
                    if(v.arraytelefono.length > 0){
                     for(var i=0; i < v.arraytelefono.length; i++){
//                        if( this.countries[i].country_name == this.country_name){
//                          return true
//                        }
                         axios.get("http://190.9.53.22:8484/apiSIPA/telefonoscliente/agregarTelefono", {
                                params: {
                                    idcliente:v.idcliente,
                                    numerotelefono:v.arraytelefono[i].numerotelefono,
                                    extension:v.arraytelefono[i].extension,
                                    tipotelefono:v.arraytelefono[i].tipotelefono
                                }
                            });
                          }
                  }
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    v.clearAll();
                     
                }
            });
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
                updateCliente(){
                     console.log(v.defaultSelected );
               /* var formData = v.formData(v.chooseCliente); 
                console.log(v.defaultSelected.cveColonia);
                console.log(v.defaultSelectedCentroTrabajo.centroTrabajoId);
                console.log(v.chooseCliente);*/
                //v.defaultSelected.cveColonia
                console.log(v.defaultSelectedCentroTrabajo);
               var formData = v.formData(v.chooseCliente);
               if (typeof v.defaultSelectedCentroTrabajo.centroTrabajoId != 'undefined'){
                   formData.append('idcentrotrabajop', v.defaultSelectedCentroTrabajo.centroTrabajoId);
               }else{
                    formData.append('idcentrotrabajop', '');
               }
                if (typeof  v.defaultSelected.cveColonia != 'undefined'){
                   formData.append('idcoloniap',v.defaultSelected.cveColonia); 
               }else{
                    formData.append('idcoloniap', '');
               }
                
                for(var pair of formData.entries()) {
                        console.log(pair[0]+ ', '+ pair[1]); 
                     }

                    
                axios.post("http://190.9.53.22:8484/apiSIPA/cliente/modificarCliente", formData).then(function (response) {
                if(response.data.error){
                    v.formValidate = response.data.msg;
                    
                }else{
                       if(v.arraytelefono.length > 0){
                     for(var i=0; i < v.arraytelefono.length; i++){
//                        if( this.countries[i].country_name == this.country_name){
//                          return true
//                        }
                         axios.get("http://190.9.53.22:8484/apiSIPA/telefonoscliente/agregarTelefono", {
                                params: {
                                    idcliente:v.chooseCliente.idCliente,
                                    numerotelefono:v.arraytelefono[i].numerotelefono,
                                    extension:v.arraytelefono[i].extension,
                                    tipotelefono:v.arraytelefono[i].tipotelefono
                                }
                            });
                          }
                  }
                    v.successMSG = response.data.success;
                    swal({
                            position: 'center',
                            type: 'success',
                            title: 'Modificado!',
                            showConfirmButton: false,
                            timer: 1500
                          });
                    v.clearAll();
                    v.clearMSG();
                
                }
            }); 
        }
        
    }
});
</script>