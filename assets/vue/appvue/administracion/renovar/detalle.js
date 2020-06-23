var this_js_script = $('script[src*=detalle]');
var my_var_1 = this_js_script.attr('data-my_var_1');
var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}
Vue.config.devtools = true

var v = new Vue({
    el: '#app',
    data: {
        url: 'http://localhost:8383/sipa/', 
        //deleteModal:false, 
        search: {text: ''},
        emptyResult: false,
        nuevoRegistro: {
            idtipotramite: '',
            idmedioconocimiento: '',
            observacion: '',
            fechasolicitud: '',
            tipoproducto: '',
            asegurado: ''
        },
       
      
        chooseClienteSolicitud: {},
        formValidate: [],
        successMSG: '',
        //pagination
        currentPage: 0,
        rowCountPage: 5,
        totalSolicitudes: 0,
        pageRange: 2,
        rfccliente: '',
        idproducto: '',
        idusuariosip: my_var_1,
        idsolicitud: my_var_2,

    },
    created() {
        this.detalleSolicitud();
        console.log(this.chooseClienteSolicitud);
    },
    methods: {
        detalleSolicitud() {

            axios.get("http://201.159.17.216:8484/apirestfull/renovacion/detalleclientesolicitud", {
                params: {
                    idsolicitud: this.idsolicitud
                }
            })
                    .then(response => (this.chooseClienteSolicitud = response.data));
        },

//        hideModal() {
//            $('#myModal').modal('hide');
//        },
//        hideModalVendedor() {
//            $('#myModalVendedor').modal('hide');
//        },
//        hideModalAsesor() {
//            $('#myModalAsesor').modal('hide');
//        },
//        
 

        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },

//        selectCliente(cliente) {
//            v.chooseCliente = cliente;
//            v.rfccliente = v.chooseCliente.rfc;
//            console.log(v.chooseCliente);
//        },

        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            v.nuevoRegistro = {
                idtipotramite: '',
                idmedioconocimiento: '',
                observacion: '',
                fechasolicitud: '',
                tipoproducto: '',
                asegurado: ''
            },
//                    v.chooseVendedor = "",
//                    v.chooseAsesor = "",
//                    v.chooseCliente = "",
//                    v.rfccliente = "",
//                    v.solicitudes = "",
                    v.formValidate = false;



        },

    }
})