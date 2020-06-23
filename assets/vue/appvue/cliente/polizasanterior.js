/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var v = new Vue({
    el: '#apppolizaanterior',
    data: {
        url: 'http://localhost:8383/sipa/',
        addModal: false,
        editModal: false,
        passwordModal: false,
        //deleteModal:false, 
        polizas: [],

        search: {text: ''},
        emptyResult: false, 
        choosePoliza: {},
        formValidate: [],
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 5,
        totalPolizas: 0,
        pageRange: 2,
        
        scorePlayer: idcliente,
    },
created() {
     this.searchSolicitud();
           
          
     },
     methods: {
         searchSolicitud() {
             
             axios.get('http://190.9.53.22:8484/apiSIPA/cliente/polizasAnteriorCliente', {
                 params: {
                     idcliente:  this.scorePlayer
                 }
             }).then(function(response) {
                 if (response.data.polizas === null) {
                    
                     v.noResult()

                 } else {
                     console.log(response.data.polizas);
                     v.getData(response.data.polizas);

                 }
             })

         },

         getData(polizas) {
              
             v.emptyResult = false; // become false if has a record
             v.totalPolizas = polizas.length //get total of user
             v.polizas = polizas.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

             // if the record is empty, go back a page
             if (v.polizas.length == 0 && v.currentPage > 0) {
                 v.pageUpdate(v.currentPage - 1)
                 //v.clearAll();  
             }
         },
         noResult() { 
             v.emptyResult = true; // become true if the record is empty, print 'No Record Found'
             v.polizas = null
             v.totalPolizas = 0 //remove current page if is empty

         },
         pageUpdate(pageNumber) {
             v.currentPage = pageNumber; //receive currentPage number came from pagination template
             v.refresh()
         },
         selectPoliza(poliza) {
             v.choosePoliza = poliza;
         }, 
         clearAll() { 
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
         } 
     }
 });

        new Vue ({
     el: '#movimientosNomina',
     data (){
        return{
            movimientosNomina: [],
            scorePlayer: idcliente
        }
        
     },
     mounted(){
            axios.get('http://190.9.53.22:8484/appsipaapi/movimientosDeNomina.php',{
                params:
                {
                  idcliente: this.scorePlayer
                }
               }).then(response =>{

                this.movimientosNomina = response.data.movimientos
                console.log(this.movimientosNomina

                    );
               }).catch(error => console.log(error));       
     }
})



    



 