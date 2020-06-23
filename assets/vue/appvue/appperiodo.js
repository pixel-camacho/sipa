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
        amortizacion: [],
        errors: [],
        search: {
            text: ''
        }, 
        pclave: "",
        //Variables para modificar el primer periodo de descuento
        perimerperiodo: 0,
        //Variable para agregar el periodo
        pperiodo:0,
        pdescuento:0,
        pidperiodo:0,

        scorePlayer: data_score,
        chooseSolicitud: {},
        currentPage: 0,
        rowCountPage: 5,
        totalSolicitudes: 0,
        pageRange: 2
    },
    created() { 
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
        /* selectSolicitud(solicitud) {
             v.chooseSolicitud = solicitud;
             v.pclave = v.chooseSolicitud.claveId;
         },*/
   
        abrirPoliza(solicitudid, clave) {
            this.solicitudid = solicitudid
            this.mostrar = false;
            this.detallepoliza = true;
            this.pclave = clave;

            axios.get("http://190.9.53.22:8484/appsipaapi/periodosporclave.php", {
                    params: {
                        clave: clave
                    }
                })
                .then(response => (this.periodos = response.data))

         

            axios.get("http://190.9.53.22:8484/appsipaapi/solicitudporid.php", {
                    params: {
                        id: solicitudid
                    }
                })
                .then(response => (this.chooseSolicitud = response.data))
                
                axios.get("http://190.9.53.22:8484/appsipaapi/amortizacionsolicitud.php", {
                    params: {
                        id: solicitudid
                    }
                })
                .then(response => (this.amortizacion = response.data))

        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        deletePeriodo(id) {
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
 
                        axios.get('http://190.9.53.22:8484/appsipaapi/eliminarperiodo.php', {
                            params: {
                                id: id
                            }
                        }).then(function(response) {})

                       


                        swalWithBootstrapButtons(
                            'Periodo!',
                            'Fue Eliminado con Exito.',
                            'success',

                        )
                         this.abrirPoliza(this.solicitudid, v.pclave)
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons(
                            'Cancelado',
                            'Fue cancelado la operacion.',
                            'error'
                        )
                         this.abrirPoliza(this.solicitudid, v.pclave)
                    }
                })


           },
        modPrimerPeriodo: function(e) {
            this.errors = [];

            if (this.$refs.periodo.value == "") {
                this.errors.push('Primer periodo requerido.');
            } else {
                this.perimerperiodo = this.$refs.periodo.value;
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
 
                        axios.get('http://190.9.53.22:8484/appsipaapi/modificarprimerperiodo.php', {
                            params: {
                                solicitudid: this.solicitudid,
                                periodoid: this.perimerperiodo
                            }
                        }).then(function(response) {})

                       


                        swalWithBootstrapButtons(
                            'Primer periodo!',
                            'Fue Modificado con Exito.',
                            'success',

                        )
                         this.abrirPoliza(this.solicitudid, v.pclave)
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
     
         addPeriodo: function(e) {
            this.errors = [];

            if (this.$refs.periodoadd.value == "") {
                this.errors.push('Primer periodo requerido.');
            } else {
                this.pidperiodo = this.$refs.periodoadd.value;
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
                    confirmButtonText: 'Si, Agregar!',
                    cancelButtonText: 'No, Cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
 
                        axios.get('http://190.9.53.22:8484/appsipaapi/agregarperiodosolicitud.php', {
                            params: {
                                id: this.solicitudid,
                                periodo: this.pidperiodo
                            }
                        }).then(function(response) {
                            
                        })
                     
              

                        swalWithBootstrapButtons(
                            'Periodo!',
                            'Fue agregado el periodo con Exito.',
                            'success',

                        )
                          v.abrirPoliza(this.solicitudid, v.pclave)  
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
        }
    }
})