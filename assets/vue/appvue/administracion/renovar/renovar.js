/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Vue.config.devtools = true
Vue.component('modal',{ //modal
    template:`
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
var v = new Vue({
   el:'#app',
    data:{
       url: 'http://localhost:8383/sipa/',
        addModal: false,
        editModal:false,
        passwordModal:false,
        //deleteModal:false, 
        users:[],
        roles:[],
        solicitudes:[],
        search: {text: ''},
        emptyResult:false,
        newUser:{
            idusuario:'',
            usuario:'',
            name:'',
            rol:''},
        chooseUser:{},
        formValidate:[],
        successMSG:'',
        
        //pagination
        currentPage: 0,
        rowCountPage:25,
        totalSolicitudes:0,
        pageRange:2
    },
     created(){
      this.showAll();    
    },
    methods:{
         showAll(){ axios.get("http://201.159.17.216:8484/apirestfull/renovacion/allPolizas").then(function(response){
                 if(response.data.solicitudes == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.solicitudes);
                    }
            })
        },
       
          searchSolicitud(){
            var formData = v.formData(v.search);
              axios.post("http://201.159.17.216:8484/apirestfull/renovacion/searchSolicitud", formData).then(function(response){
                  if(response.data.solicitudes == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.solicitudes);
                    
                    }  
            })
        },
      
       /* deleteUser(){
             var formData = v.formData(v.chooseUser);
              axios.post(this.url+"user/deleteUser", formData).then(function(response){
                if(!response.data.error){
                     v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();
                }
            })
        },*/
         formData(obj){
			var formData = new FormData();
		      for ( var key in obj ) {
		          formData.append(key, obj[key]);
		      } 
		      return formData;
		},
        getData(solicitudes){
            v.emptyResult = false; // become false if has a record
            v.totalSolicitudes = solicitudes.length //get total of user
            v.solicitudes = solicitudes.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination
            
             // if the record is empty, go back a page
            if(v.solicitudes.length == 0 && v.currentPage > 0){ 
            v.pageUpdate(v.currentPage - 1)
            v.clearAll();  
            }
        },
            
        selectUser(user){
            v.chooseUser = user; 
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
            v.newUser = { 
            idusuario:'',
            usuario:'',
            name:''};
            v.formValidate = false;
            v.addModal= false;
            v.editModal=false;
            v.passwordModal=false;
            v.deleteModal=false;
            v.refresh()
            
        },
        noResult(){
          
               v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
                      v.solicitudes = null 
                     v.totalSolicitudes = 0 //remove current page if is empty
            
        },

       
        pageUpdate(pageNumber){
              v.currentPage = pageNumber; //receive currentPage number came from pagination template
                v.refresh()  
        },
        refresh(){
             v.search.text ? v.searchUser() : v.showAll(); //for preventing
            
        }
    }
})


