Vue.config.devtools = true
Vue.component('modal', {//modal
    template: `
   <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
			    <div class="modal-content">
			      

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

var v2 = new Vue({
    el: '#apppoliza',
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
             
             axios.get('http://190.9.53.22:8484/apiSIPA/cliente/polizasCliente', {
                 params: {
                     idcliente:  this.scorePlayer
                 }
             }).then(function(response) {
                 if (response.data.polizas === null) {
                    
                     v2.noResult()

                 } else {
                     console.log(response.data.polizas);
                     v2.getData(response.data.polizas);

                 }
             })

         },

         getData(polizas) {
              
             v2.emptyResult = false; // become false if has a record
             v2.totalPolizas = polizas.length //get total of user
             v2.polizas = polizas.slice(v2.currentPage * v2.rowCountPage, (v2.currentPage * v2.rowCountPage) + v2.rowCountPage); //slice the result for pagination

             // if the record is empty, go back a page
             if (v2.polizas.length == 0 && v2.currentPage > 0) {
                 v2.pageUpdate(v2.currentPage - 1)
                 //v.clearAll();  
             }
         },
         noResult() { 
             v2.emptyResult = true; // become true if the record is empty, print 'No Record Found'
             v2.polizas = null
             v2.totalPolizas = 0 //remove current page if is empty

         },
         pageUpdate(pageNumber) {
             v2.currentPage = pageNumber; //receive currentPage number came from pagination template
             v2.refresh()
         },
         selectPoliza(poliza) {
             v2.choosePoliza = poliza;
         }, 
         clearAll() { 
             v2.addModal = false;
             v2.editModal = false;
             v2.editAbonoModal = false;

         },
         cerrarModals() {
             v2.addModal = false;
             v2.editModal = false;
             v2.editAbonoModal = false;
             v2.errors = false;
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
     el: '#estadoCuenta',
     data (){
        return{
            estadosDecuenta: [],
            scorePlayer: idcliente
        }
        
     },
     mounted(){
            axios.get('http://190.9.53.22:8484/appsipaapi/estadosDeCuenta.php',{
                params:
                {
                  idcliente: this.scorePlayer
                }
               }).then(response =>{
                this.estadosDecuenta = response.data
                console.log(this.estadosDecuenta);
               }).catch(error => console.log(error));       
     }
})


    

