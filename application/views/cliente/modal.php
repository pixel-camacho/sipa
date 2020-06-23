<!--add modal-->
 
<modal v-if="addModal" @close="clearAll()" >
    <h3 slot="head" >Agregar Cliente</h3>
    <div slot="body" class="row" id="myModal">
        <div class="col-sm-4">
            <div class="form-group">
                <label><font color="red">*</font> Nombre(s):</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="idusuario" v-model="nuevocliente.nombre" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.nombre"> </div>
            </div>
            <div class="form-group">
                <label><font color="red">*</font> RFC:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.rfc}" name="rfc" v-model="nuevocliente.rfc" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.rfc"> </div>
            </div>
            <div class="form-group">
                <label><font color="red">*</font> Estado:</label>  
                <select v-model="nuevocliente.estado"    v-on:change="changeMunicipio($event)" :class="{'is-invalid': formValidate.estado}" class="form-control">
                        <option value="">Seleccionar...</option>
                    <option   v-for="option in estados" v-bind:value="option.cveEstado">
                        {{ option.edoDescr }}
                    </option>

                </select>
                <div class="text-danger" v-html="formValidate.estado"></div>
            </div>
            <div class="form-group">
                <label><font color="red">*</font> Calle:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.calle}" name="calle" v-model="nuevocliente.calle" autcomplete="off" >
                       <div class="text-danger" v-html="formValidate.calle"></div>
            </div>
            <div class="form-group">
                <label>Curp:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.curp}" name="curp" v-model="nuevocliente.curp" autcomplete="off" >
                       <div class="text-danger" v-html="formValidate.curp"></div>
            </div>
            <div class="form-group">
                <label>Estado Civil:</label>
                <select v-model="nuevocliente.estadocivil"    :class="{'is-invalid': formValidate.estadocivil}"class="form-control">
                        <option value="">Seleccionar...</option>
                    <option   v-for="option in estadocivil" v-bind:value="option.edoCivilId">
                        {{ option.edoCivilDescr }}
                    </option>

                </select> 
                <div class="text-danger" v-html="formValidate.estadocivil"></div>
            </div>
            <div class="form-group">
                <label><font color="red">*</font> Contratante:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.contratante}" name="contratante" v-model="nuevocliente.contratante" autcomplete="off" >
                       <div class="text-danger" v-html="formValidate.contratante"></div>
            </div>
            <div class="form-group">
                <label><font color="red">*</font> Tipo Nomina:</label>
                <select v-model="nuevocliente.tiponomina"    :class="{'is-invalid': formValidate.tiponomina}"class="form-control">
                        <option value="" >Seleccionar...</option>
                    <option   v-for="option in tiponominas"  v-bind:value="option.value">
                        {{ option.text }}
                    </option>

                </select> 
                <div class="text-danger" v-html="formValidate.tiponomina"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label><font color="red">*</font> A. Paterno:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.aparterno}" name="aparterno" v-model="nuevocliente.aparterno" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.aparterno"> </div>
            </div> 
            <div class="form-group">
                <label><font color="red">*</font> Sexo: </label><br><br>
                <label class="radio-inline">
                    <input type="radio" name="status" v-model="nuevocliente.sexo" value="1" > Masculino
                </label>
                <label class="radio-inline">
                    <input type="radio" name="status" v-model="nuevocliente.sexo" value="0"> Femenino
                </label> 
                <div class="text-danger" v-html="formValidate.sexo"></div>
            </div>
            <div class="form-group">
                <label><font color="red">*</font> Municipio:</label>
                <select v-model="nuevocliente.municipio"   v-on:change="changeColonia($event)" :class="{'is-invalid': formValidate.municipio}"class="form-control">
                        <option value="">Seleccionar...</option>
                    <option   v-for="option in municipios" v-bind:value="option.cveMunicipio">
                        {{ option.mpoDescripcion }}
                    </option> 
                </select>
                <div class="text-danger" v-html="formValidate.municipio"> </div>
            </div> 
            <div class="form-group">
                <label><font color="red">*</font> No. Exterior:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.numeroexterior}" name="numeroexterior" v-model="nuevocliente.numeroexterior" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.numeroexterior"> </div>
            </div> 
            <div class="form-group">
                <label><font color="red">*</font> Lugar de Nacimiento:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.lugarnacimiento}" name="lugarnacimiento" v-model="nuevocliente.lugarnacimiento" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.lugarnacimiento"> </div>
            </div> 
            <div class="form-group">
                <label><font color="red">*</font> Fecha Nacimiento:</label>
                <input type="date" class="form-control" :class="{'is-invalid': formValidate.fechanacimiento}" name="fechanacimiento" v-model="nuevocliente.fechanacimiento" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.fechanacimiento"> </div>
            </div> 
            <div class="form-group">
                <label><font color="red">*</font> Centro de Trabajo:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="nuevocliente.usuario" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.usuario"> </div>
            </div> 
            <div class="form-group">
                <label><font color="red">*</font> Dir. Centro trabajo:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="nuevocliente.usuario" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.usuario"> </div>
            </div> 
            <div class="form-group">
                <label><font color="red">*</font> Factura:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="checkbox" class="form-check-input" id="exampleCheck1">

                <div class="text-danger" v-html="formValidate.usuario"> </div>
            </div> 
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>A. Materno:</label>
                <input type="password" class="form-control" :class="{'is-invalid': formValidate.password2}" name="password2" v-model="nuevocliente.password2" autcomplete="off" >
                       <div class="text-danger" v-html="formValidate.password2"></div>
            </div>
            <div class="form-group">
                <label>Correo Electrinico:</label>
                <input type="password" class="form-control" :class="{'is-invalid': formValidate.password2}" name="password2" v-model="nuevocliente.password2" autcomplete="off" >
                       <div class="text-danger" v-html="formValidate.password2"></div>
            </div>
            <div class="form-group">
                <label><font color="red">*</font> Colonia;</label>
                <select v-model="nuevocliente.colonia"   :class="{'is-invalid': formValidate.colonia}"class="form-control">
                        <option value="">Seleccionar...</option>
                    <option   v-for="option in colonias" v-bind:value="option.cveColonia">
                        {{ option.coloniaDescr }}
                    </option> 
                </select>
                <div class="text-danger" v-html="formValidate.usuario"> </div>

            </div> 

            <div class="form-group">
                <label><font color="red">*</font> Código Postal:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.cp}" name="usuario" v-model="codigopostal" autcomplete="off" value="{{codigopostal}}">
                       <div class="text-danger" v-html="formValidate.cp"> </div> 

            </div>
            <div class="form-group">
                <label><font color="red">*</font> Ocupación:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.ocupacion}" name="ocupacion" v-model="nuevocliente.ocupacion" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.ocupacion"> </div> 
            </div>
            <div class="form-group">
                <label> Edad:</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="nuevocliente.usuario" autcomplete="off">
                       <div class="text-danger" v-html="formValidate.usuario"> </div >
            </div>

        </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger" @click="clearAll">Cancelar</button> 
    </div>
</modal>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--update modal-->
<!--<modal v-if="editModal" @close="clearAll()">
   <h3 slot="head" >Editar usuario</h3>
   <div slot="body" class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label>SIP</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.idusuario}" name="idusuario" v-model="chooseUser.idusuario">
            <div class="text-danger" v-html="formValidate.idusuario"> </div>
         </div>
         <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.name}" name="name" v-model="chooseUser.name">
            <div class="text-danger" v-html="formValidate.name"> </div>
         </div>

           <div class="form-group">
            <label>Rol</label> 
              <select class="form-control" v-model="chooseUser.idrol" >
                  <option v-for="option in roles"  :selected="option.id == chooseUser.idrol ? 'selected' : ''" :value="option.id" >
                      {{ option.rol }}
                  </option>
             </select>
         </div>
        
        
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label>Usuario</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="chooseUser.usuario">
            <div class="text-danger" v-html="formValidate.usuario"></div>
         </div>
          <div class="form-group">
            <label for="">Estatus</label><br>
            <label class="radio-inline"> <input type="radio" name="status" v-model="chooseUser.activo" value="1" :checked="chooseUser.activo==1"> Activo </label>
            <label class="radio-inline">  <input type="radio" name="status" v-model="chooseUser.activo" value="0" :checked="chooseUser.activo==0"> Inactivo </label>
         </div>
        
      </div>
   </div>
   <div slot="foot">  
      <button class="btn btn-danger" @click="clearAll">Cancelar</button>
      <button class="btn btn-primary" @click="updateUser">Modificar</button>
   </div>
</modal>-->
<!--Modificar passeord model--> 
 