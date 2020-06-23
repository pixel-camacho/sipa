var this_js_script = $('script[src*=preregistro]');
var my_var_1 = this_js_script.attr('data-my_var_1');   
if (typeof my_var_1 === "undefined" ) {
   var my_var_1 = 'some_default_value';
}
 
Vue.config.devtools = true

var v = new Vue({
    el: '#app',
    data: {
        url: 'http://localhost:8383/sipa/',
        addModal: false,
        editModal: false,
        passwordModal: false,
        //deleteModal:false, 
        users: [],
        roles: [],
        tipotramites: [],
        productos: [],
        solicitudes: [],
        mediosconocimientos:[],
        vendedores:[],
        asesores:[],
        search: {text: ''},
        emptyResult: false,
        nuevoRegistro: {
            idtipotramite: '',
            idmedioconocimiento:'',
            observacion:'',
            fechasolicitud:'',
            tipoproducto:'',
            asegurado:''
        },
        newUser: {
            idusuario: '',
            usuario: '',
            name: '',
            rol: ''},
        
        chooseCliente: {},
        chooseVendedor: {},
        chooseAsesor: {},
        formValidate: [],
        successMSG: '',
        //pagination
        currentPage: 0,
        rowCountPage: 5,
        totalSolicitudes: 0,
        pageRange: 2,
        rfccliente:'',
        idproducto:'',
        idusuariosip: my_var_1,

    },
    created() {
        
        this.allTiposTramite();
        this.allProductos();
        this.allMediosConocimientos();
       this.allVendedores(); 
    },
    methods: {
        searchSolicitud() { 
            axios.get('http://201.159.17.216:8484/apiSIPA/cliente/buscarCliente', {
                params: {
                    rfc: this.$refs.rfc.value,
                    nombre: this.$refs.nombre.value,
                    apellidop: this.$refs.apellidop.value,
                    apellidom: this.$refs.apellidom.value
                }
            }).then(function (response) {
                if (response.data.solicitudes === null) {
                    
                    v.noResult()

                } else { 
                    v.getData(response.data.solicitudes); 

                }
            });

        }, 
         hideModal() {
                $('#myModal').modal('hide');
              },
               hideModalVendedor() {
                $('#myModalVendedor').modal('hide');
              },
                       hideModalAsesor() {
                $('#myModalAsesor').modal('hide');
              },
        allTiposTramite() {

            axios.get("http://201.159.17.216:8484/apiSIPA/tipotramite/allTipoTramite")
                    .then(response => (this.tipotramites = response.data));

        },
        allProductos() {

            axios.get("http://201.159.17.216:8484/apiSIPA/producto/allProducto")
                    .then(response => (this.productos = response.data));

        },
       allVendedores() {

            axios.get("http://201.159.17.216:8484/apiSIPA/vendedor/allVendedores")
                    .then(response => (this.vendedores = response.data));

        },
         allMediosConocimientos() {

            axios.get("http://201.159.17.216:8484/apiSIPA/medioconocimiento/allMedioConocimiento")
                    .then(response => (this.mediosconocimientos = response.data));

        },
           changeTipoProducto: function changeItem(event) {
          console.log(event.target.value);
          this.idproducto=event.target.value;
             axios.get("http://201.159.17.216:8484/apiSIPA/asesor/allAsesores")
                    .then(response => (this.asesores = response.data));
            
        },

        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },

        selectCliente(cliente) {
            v.chooseCliente = cliente;
            v.rfccliente=v.chooseCliente.rfc;
            console.log(v.chooseCliente);
        },
          selectVendedor(vendedor) {
            v.chooseVendedor = vendedor;
            //v.rfccliente=v.chooseCliente.rfc;
            //console.log(v.chooseCliente);
        },
         selectAsesor(asesor) {
            v.chooseAsesor = asesor;
            //v.rfccliente=v.chooseCliente.rfc;
            //console.log(v.chooseCliente);
        },
        addSolicitud() {
            var data = new FormData();
            console.log(this.nuevoRegistro.idmedioconocimiento);
            data.append('idtipotramite', this.nuevoRegistro.idtipotramite);
            data.append('idmedioconocimiento', this.nuevoRegistro.idmedioconocimiento);
            data.append('fechasolicitud', this.nuevoRegistro.fechasolicitud);
            data.append('idusuario', this.idusuariosip);
            // data.append('tipoproducto', this.nuevoRegistro.tipoproducto);
            data.append('observacion', this.nuevoRegistro.observacion);
            //data.append('idcliente', this.chooseCliente.idCliente);
             if (typeof this.nuevoRegistro.tipoproducto != 'undefined') {
                data.append('tipoproducto', this.nuevoRegistro.tipoproducto);
            } else {
                data.append('tipoproducto', '');
            }
            if (typeof this.nuevoRegistro.asegurado != 'undefined') {
                data.append('asegurado', this.nuevoRegistro.asegurado);
            } else {
                data.append('asegurado', '');
            }
            if (typeof v.chooseCliente.idCliente != 'undefined') {
                data.append('idcliente', v.chooseCliente.idCliente);
            } else {
                data.append('idcliente', '');
            }
            if (typeof v.chooseVendedor.idUsuario != 'undefined') {
                data.append('idvendedor', v.chooseVendedor.idUsuario);
            } else {
                data.append('idvendedor', '');
            }
            if (typeof v.chooseAsesor.idUsuario != 'undefined') {
                data.append('idasesor', v.chooseAsesor.idUsuario);
            } else {
                data.append('idasesor', '');
            }
            if (typeof v.chooseAsesor.idArea != 'undefined') {
                data.append('idarea', v.chooseAsesor.idArea);
            } else {
                data.append('idarea', '');
            }
             if (typeof v.chooseAsesor.idUsurResp != 'undefined') {
                data.append('iduserresp', v.chooseAsesor.idArea);
            } else {
                data.append('iduserresp', '');
            }
             if (typeof v.chooseAsesor.areaIdPadre != 'undefined') {
                data.append('areaidpadre', v.chooseAsesor.areaIdPadre);
            } else {
                data.append('areaidpadre', '');
            }
            
            for (var pair of data.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
            }
            
            //data.append('idcentrotrabajo', v.nuevocliente.centrotrabajo.centrotrabajoid);
            //data.append('idcolonia', v.nuevocliente.colonia.cveColonia); 
       axios.post("http://201.159.17.216:8484/apirestfull/solicitud/registrarSolicitud", data).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                } else { 
                   
                   
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
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            v.nuevoRegistro ={
            idtipotramite: '',
            idmedioconocimiento:'',
            observacion:'',
            fechasolicitud:'',
            tipoproducto:'',
            asegurado:''
        },
            v.chooseVendedor="",
            v.chooseAsesor="",
            v.chooseCliente="",
            v.rfccliente="",
            v.solicitudes="",
            v.formValidate = false;
            
            v.refresh()

        },
        getData(solicitudes) {
            v.emptyResult = false; // become false if has a record
            v.totalSolicitudes = solicitudes.length //get total of user
            v.solicitudes = solicitudes.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.solicitudes.length == 0 && v2.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
        },
        noResult() {

            v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            v.solicitudes = null
            v.totalSolicitudes = 0 //remove current page if is empty

        },

        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh()
        },
        refresh() {
            v.search.text ? v.searchSolicitud() : v.searchSolicitud(); //for preventing

        }


    }
})