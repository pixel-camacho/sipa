<!--add modal-->
 
<modal v-if="addModal"   @close="clearAll()">
 
   <h3 slot="head" >Agregar Periodo</h3>
   <div slot="body" class="row">
      <div class="col-md-12">
           <p v-if="errors.length">
             <b>Corregir los siguientes errores:</b>
             <ul>
               <li v-for="error in errors" class="text-danger">{{ error }}</li>
             </ul>
           </p>
         <div class="form-group">
            <label>Periodo</label>
            <input type="text" class="form-control"    name="periodo" required="" ref="periodo"> 
             <span class="help-block" id="periodoMessage" />
         </div>
      </div> 
      <div class="col-md-12">
         <div class="form-group">
            <label>Fecha</label>
            <input type="date" class="form-control" required=""  name="fecha" ref="fecha"> 
             <span class="help-block" id="fechaMessage" />
         </div>
      </div> 
   </div>
   <div slot="foot">
    <button type="button" class="btn btn-danger" @click="clearAll"  >Cancelar</button>
      <button type="submit"  class="btn btn-primary" @click="addPeriodo" >Agregar</button>
   </div>
 
</modal>
<!--update modal-->
<modal v-if="editModal" @close="clearAll()"   >
   <h3 slot="head" >Agregar Cobro</h3>
   <div slot="body" class="row">
      <div class="col-md-12">
            <p v-if="errors.length">
             <b>Corregir los siguientes errores:</b>
             <ul>
               <li v-for="error in errors"  class="text-danger">{{ error }}</li>
             </ul>
           </p>

         <div class="form-group">
            <label>Abono</label>
            <input type="text" class="form-control"  name="abono" ref="abono" > 
         </div>
         <div class="form-group">
            <label>Forma de Pago</label>
          <select class="form-control" name="formapago" ref="formapago" >
              <option disabled value="" >Seleccionar una opción</option>
              <option value="1">Efectivo</option>
              <option value="2">Terminal Bancaria</option>
              <option value="3">Cheque</option>
            </select>
         </div>
          <div class="form-group">
            <label>Ficha de Deposito</label>
            <input type="text" class="form-control"  name="fichadeposito"  ref="fichadeposito"> 
         </div>
          <div class="form-group">
            <label>Fecha</label>
            <input type="date" class="form-control"  name="fechadeposito" ref="fechadeposito" > 
            <input type="hidden" name="" v-model="choosePeriodo.periodo" ref="periodoacobrar">
         </div>
      </div>
     
   </div>
   <div slot="foot"> 
    <button type="button" class="btn btn-danger" @click="clearAll"  >Cancelar</button>
      <button class="btn btn-primary" @click="addAbono" >Abonar</button>
   </div>
</modal>


<modal v-if="editAbonoModal" @close="clearAll()">
   <h3 slot="head" >Modificar Cobro</h3>
   <div slot="body" class="row">
      <div class="col-md-12">
          <p v-if="errors.length">
             <b>Corregir los siguientes errores:</b>
             <ul>
               <li v-for="error in errors"  class="text-danger">{{ error }}</li>
             </ul>
           </p>
           
         <div class="form-group">
            <label>Nuevo abono</label>
            <input type="text" class="form-control"  name="abono"  ref="modabonoperiod" > 
         </div>
         <div class="form-group">
            <label>Forma de Pago</label>
           <select class="form-control" name="formapago" ref="modformapago" >
              <option disabled value="" >Seleccionar una opción</option>
              <option value="1">Efectivo</option>
              <option value="2">Terminal Bancaria</option>
              <option value="3">Cheque</option>
            </select>
         </div>
          <div class="form-group">
            <label>Ficha de Deposito</label>
            <input type="text" class="form-control"  name="fechadeposito"   ref="modfichadeposito"> 
         </div>
          <div class="form-group">
            <label>Fecha</label>
            <input type="date" class="form-control"  name="fechadeposito"   ref="modfechadeposito"> 
            <input type="hidden" name="" v-model="chooseModificarCobro.cuentaid" >
         </div>
      </div>
     
   </div>
   <div slot="foot"> 
    <button type="button" class="btn btn-danger" @click="clearAll"  >Cancelar</button>
      <button class="btn btn-primary" @click="updateAbono" >Modificar</button>
   </div>
</modal>
  