 Vue.config.devtools = true
 Vue.component('modal', { //modal
     template: `
   <transition name="modal">
      <div class="modal-mask" >
        <div class="modal-wrapper">
          <div class="modal-dialog">
          <div class="modal-content"   >
            

            <div class="modal-header">
                <h5 class="modal-title"> <slot name="head"></slot></h5> 
                <i class="fa fa-window-close  icon-md text-danger" @click="$emit('close')"></i>
              </div>

            <div class="modal-body" style="background-color:#fff;">
               <slot name="body"></slot>
            </div>
            <div class="modal-footer">

               <slot name="foot"></slot>
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
         mostrar: true,
         solicitudid: 0,
         detallepoliza: false,
         solicitudes: [],
         periodos: [],
         errors: [],
         search: {
             text: ''
         },


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
                     parametotext: this.$refs.search.value
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
         addPeriodo() {
             console.log(v.solicitudid)
             const swalWithBootstrapButtons = swal.mixin({
                 confirmButtonClass: 'btn btn-success',
                 cancelButtonClass: 'btn btn-danger',
                 buttonsStyling: false,
             })

             swalWithBootstrapButtons({
                 title: 'Está seguro?',
                 text: "Quiere agregar el recibo!",
                 type: 'warning',
                 showCancelButton: true,
                 confirmButtonText: 'Si, agregar recibo!',
                 cancelButtonText: 'No, cancelar!',
                 reverseButtons: true
             }).then((result) => {
                 if (result.value) {
                    axios.get('http://190.9.53.22:8484/appsipaapi/primerperiodo.php', {
                            params: {
                                id: v.solicitudid
                            }
                        }).then(function(response) {})

                     swalWithBootstrapButtons(
                         'Agregado!',
                         'Fue agregado con exito!',
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
     }
 })