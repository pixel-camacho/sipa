 Vue.config.devtools = true
 var v = new Vue({
     el: '#app',
    
     data: {
         url: 'http://190.9.53.22:8484/sipa/',
         loading: false,
         mostrar: true,
         solicitudid: 0,
         detallepoliza: false,
         solicitudes: [],
         periodos: [],
         bancos: [],
         tipostarjetas: [],
         errors: [],
         search: {
             text: ''
         },
          newCable:{
            solicitudid:'',
            tarjeta:'',
            titular:'',
            bancoid:'',
            tipotarjetaid:''},

//Variables para modificar numero de tarjeta
            pbancoid:0,
            ptipotarjeta:0,
            pnumerotarjeta:0,
            ptitulartarjeta:'',


         scorePlayer: data_score,
         chooseSolicitud: {}, 
         currentPage: 0,
         rowCountPage: 5,
         totalSolicitudes: 0,
         pageRange: 2
     },
     created() {
         //console.log(this.scorePlayer)
         this.allBanco();
         this.allTipoTarjeta();
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
					 console.log(response.data.solicitudes);
                     v.getData(response.data.solicitudes);

                 }
             })

         },
         allBanco(){ 
                   axios.get("http://190.9.53.22:8484/appsipaapi/banco.php")
                  .then(response => (this.bancos = response.data))

                },
         allTipoTarjeta(){ 
                   axios.get("http://190.9.53.22:8484/appsipaapi/tipotarjeta.php")
                  .then(response => (this.tipostarjetas = response.data))

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

         abrirPoliza(solicitudid) {
             this.solicitudid = solicitudid
             this.mostrar = false;
             this.detallepoliza = true;
         },


         formData(obj) {
             var formData = new FormData();
             for (var key in obj) {
                 formData.append(key, obj[key]);
             }
             return formData;
         }, 
           addDomiciliacion: function(e) {
             this.errors = [];

             if (this.$refs.banco.value == "") {
                 this.errors.push('Banco requerido.');
             } else if (this.$refs.tipotarjeta.value == "") {
                 this.errors.push('Tipo de tarjeta requerido.');
             } else if (this.$refs.numerotajeta.value == "") {
                 this.errors.push('Número de tajeta requerido.');
             } else if (this.$refs.titular.value == "") {
                 this.errors.push('Titular requerido.');
             } else if (!this.soloNumero(this.$refs.numerotajeta.value)) {
                this.errors.push('Tarjeta/Clabe solo número.');
              } else {
                 this.pbancoid = this.$refs.banco.value;
                 this.ptipotarjeta = this.$refs.tipotarjeta.value;
                 this.pnumerotarjeta = this.$refs.numerotajeta.value;
                 this.ptitulartarjeta = this.$refs.titular.value;
                
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
                     confirmButtonText: 'Si, Cambiar!',
                     cancelButtonText: 'No, Cancelar!',
                     reverseButtons: true
                 }).then((result) => {
                     if (result.value) {

                         var dataclabe = new FormData();
                         dataclabe.append('id', this.solicitudid);
                         dataclabe.append('banco', this.pbancoid);
                         dataclabe.append('tipotarjeta', this.ptipotarjeta);
                         dataclabe.append('tarjeta', this.pnumerotarjeta);
                         dataclabe.append('titular', this.ptitulartarjeta); 
                         /*for (var value of dataabono.values()) {
                              console.log(value); 
                           }*/
                         axios.post(this.url + "clabe/agregarClabe", dataclabe)
                             .then(function(response) {
                                 if (response.data.error) {
                                     //          console.log(response.data.error)          //v.formValidate = response.data.msg;
                                 } else {
                                     //v.successMSG = response.data.msg;
                                     //v.clearAll();
                                     //v.clearMSG();
                                 }
                             })


                         axios.get('http://190.9.53.22:8484/appsipaapi/modificarclabe.php', {
                             params: {
                                 id: this.solicitudid,
                                 banco: this.pbancoid,
                                 tipotarjeta: this.ptipotarjeta,
                                 tarjeta: this.pnumerotarjeta,
                                 titular: this.ptitulartarjeta
                             }
                         }).then(function(response) {
                             // handle success
                             v.abrirPoliza(v.solicitudid);
                             //console.log(response);
                         }) 

                         swalWithBootstrapButtons(
                             'Clabe!',
                             'Fue Modificado con Exito.',
                             'success'
                         )
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
            }
     }
 })