
 Vue.config.devtools = true
 Vue.component('modal', { //modal
     template: `
   <transition name="modal">
      <div class="modal-mask" >
        <div class="modal-wrapper">
          <div class="modal-dialog">
          <div class="modal-content">           

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
         editAbonoModal: false,
         mostrar: true,
         solicitudid: 0,
         contratanteid: 0,
         descuentoperiodo: 0,
         detallepoliza: false,
         solicitudes: [],
         periodos: [],
         errors: [],
         search: {
             text: ''
         },
         nuevoPeriodo: {
             solicitudidperiodo: '',
             periodo: '',
             descuento: '',
             fecha: ''
         },
         agregarCobro: {
             abono: '',
             formapago: '',
             movimiento: '',
             fichadeposito: '',
             fechacobro: '',
             periodoacobrar: ''
         },

         //Modificar periodo
         estadocuentaid: 0,
         modabonoperiod: 0,
         modformapago: 0,
         modfichadeposito: 0,
         modfechadeposito: 0,
         //Fin
        formValidate:[],
        successMSG:'',

         //Variable para abonar periodo
         peridooacobrar: 0,
         cuantoabonara: 0,
         fichadeposito: '',
         fechadeposito: '',
         formapago: '',
         //Fin variables
         scorePlayer: data_score,
         chooseSolicitud: {},
         choosePeriodo: {},
         chooseModificarCobro: {},
         currentPage: 0,
         rowCountPage: 5,
         totalSolicitudes: 0,
         pageRange: 2
     },
     created() {
         //console.log(this.scorePlayer)
     },
     methods: {
         searchSolicitud() {
             this.loading = true;
             NProgress.start()
             this.mostrar = true;
             this.detallepoliza = false;
             axios.get('http://190.9.53.22:8484/appsipaapi/solicitudes.php', {
                 params: {
                     parametotext: this.$refs.search.value,
                     certificado: this.$refs.certificado.value
                 }
             }).then(function(response) {
                 if (response.data.solicitudes == null) {
                     NProgress.done()
                     v.noResult()

                 } else {
                     NProgress.done()
                     v.getData(response.data.solicitudes);

                 }
             })

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
         selectSolicitud(solicitud) {
             v.chooseSolicitud = solicitud;
         },
         selectPeriodoModificar(periodo) {
             v.choosePeriodo = periodo;

         },
         selectModificarCobro(periodo) {
             v.chooseModificarCobro = periodo;
             v.estadocuentaid = v.chooseModificarCobro.cuentaid;
         },
         abrirPoliza(solicitudid, descuento, contratanteid) {
             this.solicitudid = solicitudid
             this.descuentoperiodo = descuento
             this.contratanteid = contratanteid
             axios.get('http://190.9.53.22:8484/appsipaapi/periodos.php', {
                     params: {
                         solicitudid: solicitudid
                     }
                 })
                 .then(response => (this.periodos = response.data))
             this.mostrar = false;
             this.detallepoliza = true;
         },
         clearAll() {
             v.nuevoPeriodo = {
                 solicitudid: '',
                 periodo: '',
                 fecha: ''
             };
             v.addModal = false;
             v.editModal = false;
             v.editAbonoModal = false;

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
         updateAbono: function(e) {
             this.errors = [];

             if (this.$refs.modabonoperiod.value == "") {
                 this.errors.push('Abono requerido.');
             } else if (this.$refs.modformapago.value == "") {
                 this.errors.push('Forma de pago requerido.');
             } else if (this.$refs.modfichadeposito.value == "") {
                 this.errors.push('Ficha de pago requerido.');
             } else if (this.$refs.modfechadeposito.value == "") {
                 this.errors.push('Fecha de pago requerido.');
             }else if (!this.soloNumero(this.$refs.modabonoperiod.value)) {
                this.errors.push('Formato incorrecto del Abono.');
              }  else {
                 this.modabonoperiod = this.$refs.modabonoperiod.value;
                 this.modformapago = this.$refs.modformapago.value;
                 this.modfichadeposito = this.$refs.modfichadeposito.value;
                 this.modfechadeposito = this.$refs.modfechadeposito.value;
                 v.editAbonoModal = false;
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
                     confirmButtonText: 'Yes, Modificar!',
                     cancelButtonText: 'No, Cancelar!',
                     reverseButtons: true
                 }).then((result) => {
                     if (result.value) {

                         var dataabono = new FormData();
                         dataabono.append('id', this.estadocuentaid);
                         dataabono.append('periodo', v.chooseModificarCobro.periodo);
                         dataabono.append('abono', this.modabonoperiod);
                         dataabono.append('formapago', this.modformapago);
                         dataabono.append('fichadeposito', this.modfichadeposito);
                         dataabono.append('fechadeposito', this.modfechadeposito);
                         dataabono.append('contratante', this.contratanteid);
                         axios.post(this.url + "cobranza/modificarAbono", dataabono)
                             .then(function(response) {
                                 if (response.data.error) {
                                     //          console.log(response.data.error)          //v.formValidate = response.data.msg;
                                 } else {
                                     //v.successMSG = response.data.msg;
                                     //v.clearAll();
                                     //v.clearMSG();
                                 }
                             })


                         axios.get('http://190.9.53.22:8484/appsipaapi/modificarestadocuenta.php', {
                                  params: {
                                      id: this.estadocuentaid,
                                      fechadeposito: this.modfechadeposito,
                                      usuario: this.scorePlayer,
                                      fichadeposito: this.modfichadeposito,
                                      abono: this.modabonoperiod, 
                                      contratante: this.contratanteid
                                  }
                              }).then(function (response) {
                                 // handle success
                                  v.abrirPoliza(v.solicitudid,v.descuentoperiodo,v.contratanteid);
                                 //console.log(response);
                               })

                         swalWithBootstrapButtons(
                             'Abonado!',
                             'Fue Modificado con Exito.',
                             'success'
                         )
                     } else if (
                         // Read more about handling dismissals
                         result.dismiss === swal.DismissReason.cancel
                     ) {
                         swalWithBootstrapButtons(
                             'Cancelado',
                             'Modificacion del periodo.',
                             'error'
                         )
                     }
                 })
             }

             e.preventDefault();
         },
         addAbono: function(e) {
             this.errors = [];

             if (this.$refs.abono.value == "") {
                 this.errors.push('Abono requerido.');
             } else if (this.$refs.formapago.value == "") {
                 this.errors.push('Forma de pago requerido.');
             } else if (this.$refs.fichadeposito.value == "") {
                 this.errors.push('Ficha de pago requerido.');
             } else if (this.$refs.fechadeposito.value == "") {
                 this.errors.push('Fecha de pago requerido.');
             }else if (!this.soloNumero(this.$refs.abono.value)) {
                this.errors.push('Formato incorrecto del Abono.');
              }  else {
                 this.cuantoabonara = this.$refs.abono.value;
                 this.formapago = this.$refs.formapago.value;
                 this.fichadeposito = this.$refs.fichadeposito.value;
                 this.fechadeposito = this.$refs.fechadeposito.value;
                 v.editModal = false;
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
                     confirmButtonText: 'Yes, Abonar!',
                     cancelButtonText: 'No, Cancelar!',
                     reverseButtons: true
                 }).then((result) => {
                     if (result.value) {

                         var dataabono = new FormData();
                         dataabono.append('id', this.solicitudid);
                         dataabono.append('periodo', v.choosePeriodo.periodo);
                         dataabono.append('cargo', this.descuentoperiodo);
                         dataabono.append('abono', this.cuantoabonara);
                         dataabono.append('formapago', this.formapago);
                         dataabono.append('fichadeposito', this.fichadeposito);
                         dataabono.append('fechadeposito', this.fechadeposito);
                         dataabono.append('contratante', this.contratanteid);
                         /*for (var value of dataabono.values()) {
                              console.log(value); 
                           }*/
                         axios.post(this.url + "cobranza/agregarAbono", dataabono)
                             .then(function(response) {
                                 if (response.data.error) {
                                     //          console.log(response.data.error)          //v.formValidate = response.data.msg;
                                 } else {
                                     //v.successMSG = response.data.msg;
                                     //v.clearAll();
                                     //v.clearMSG();
                                 }
                             })


                         axios.get('http://190.9.53.22:8484/appsipaapi/abonoperiodo.php', {
                             params: {
                                 id: this.solicitudid,
                                 periodo: v.choosePeriodo.periodo,
                                 cargo: this.descuentoperiodo,
                                 abono: this.cuantoabonara,
                                 fichadeposito: this.fichadeposito,
                                 fechadeposito: this.fechadeposito,
                                 usuario: this.scorePlayer,
                                 contratante: this.contratanteid
                             }
                         }).then(function(response) {
                             // handle success
                             v.abrirPoliza(v.solicitudid, v.descuentoperiodo, v.contratanteid);
                             //console.log(response);
                         }) 

                         swalWithBootstrapButtons(
                             'Abonado!',
                             'Fue abonado con Exito.',
                             'success'
                         )
                     } else if (
                         // Read more about handling dismissals
                         result.dismiss === swal.DismissReason.cancel
                     ) {
                         swalWithBootstrapButtons(
                             'Cancelado',
                             'El abono del periodo.',
                             'error'
                         )
                     }
                 })
             }

             e.preventDefault();
         },
         addPeriodo: function(e) {


             this.errors = [];

             if (this.$refs.periodo.value == "") {
                 this.errors.push('Perido requerido.');
             } else if (this.$refs.fecha.value == "") {
                 this.errors.push('Fecha requerido.');
             }else if (!this.soloNumero(this.$refs.periodo.value)) {
                this.errors.push('Periodo solo número.');
              } else {

                 this.periodo = this.$refs.periodo.value;
                 this.fecha = this.$refs.fecha.value;
                 v.cerrarModals();
                 const swalWithBootstrapButtons = swal.mixin({
                     confirmButtonClass: 'btn btn-success',
                     cancelButtonClass: 'btn btn-danger',
                     buttonsStyling: false,
                 })

                 swalWithBootstrapButtons({
                     title: 'Esta seguro?',
                     text: "¡No podrás revertir esto!",
                     type: 'warning',
                     showCancelButton: true,
                     confirmButtonText: 'Si, Agregar periodo!',
                     cancelButtonText: 'No, Cancelar!',
                     reverseButtons: true
                 }).then((result) => {
                     if (result.value) {

                         var data = new FormData();
                         data.append('id', this.solicitudid);
                         data.append('periodo', this.periodo);
                         data.append('descuento', this.descuentoperiodo);
                         data.append('fecha', this.fecha);

                         axios.post(this.url + "cobranza/agregarPeriodo", data).then(function(response) {
                             if (response.data.error) {
                                 //v.formValidate = response.data.msg;
                             } else {
                                 v.successMSG = response.data.msg;
                                 //v.clearAll();
                                 //v.clearMSG();
                             }
                         })

                         axios.get('http://190.9.53.22:8484/appsipaapi/nuevoperiodo.php', {
                             params: {
                                 id: this.solicitudid,
                                 periodo: this.periodo,
                                 descuento: this.descuentoperiodo,
                                 fecha: this.fecha
                             }
                         }).then(function(response) {
                             // handle success
                             v.abrirPoliza(v.solicitudid, v.descuentoperiodo, v.contratanteid); 
                         }) 
                         swalWithBootstrapButtons(
                             'Agregado!',
                             'El periodo fue agregado.',
                             'success'
                         )

                     } else if (
                         // Read more about handling dismissals
                         result.dismiss === swal.DismissReason.cancel
                     ) {
                         swalWithBootstrapButtons(
                             'Cancelado',
                             'No se agrego el periodo.',
                             'error'
                         )
                     }
                 })
 
             }
             e.preventDefault();

         },
          soloNumero: function (text) { 
                var regresar=false; 
                if (isNaN(text)) {
                  regresar=false;
                } else {
                  regresar=true;
                }
              return regresar
            },
             cantidad: function (text) { 
                 var re =/^[1-9]{0,2}(,{0,1})(\d{2},)*(\d{3})*(?:\.\d{0,2})$/;
                 return re.test(text);
            }
     }
 })


 