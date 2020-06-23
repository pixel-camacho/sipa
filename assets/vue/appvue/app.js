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
        url:'http://190.9.53.22:8484/sipa/',
        addModal: false,
        editModal:false,
        passwordModal:false,
        //deleteModal:false, 
        users:[],
        roles:[],
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
        rowCountPage:5,
        totalUsers:0,
        pageRange:2
    },
     created(){
      this.showAll();   
      this.allRol();   
    },
    methods:{
         showAll(){ axios.get(this.url+"user/showAll").then(function(response){
                 if(response.data.users == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.users);
                    }
            })
        },
        allRol(){ 
           axios.get(this.url+"rol/todosRoles")
          .then(response => (this.roles = response.data))

        },
          searchUser(){
            var formData = v.formData(v.search);
              axios.post(this.url+"user/searchUser", formData).then(function(response){
                  if(response.data.users == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.users);
                    
                    }  
            })
        },
          addUser(){   
            var formData = v.formData(v.newUser);
              axios.post(this.url+"user/addUser", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                }else{
                    swal({
					  position: 'center',
					  type: 'success',
					  title: 'Exito!',
					  showConfirmButton: false,
					  timer: 1500
					});

                    v.clearAll();
                    v.clearMSG();
                }
               })
        },
        updateUser(){
            var formData = v.formData(v.chooseUser); axios.post(this.url+"user/updateUser", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                }else{
                    //v.successMSG = response.data.success;
                      swal({
                            position: 'center',
                            type: 'success',
                            title: 'Modificado!',
                            showConfirmButton: false,
                            timer: 1500
                          });
                    v.clearAll();
                    v.clearMSG();
                
                }
            })
        },
          passwordupdateUser(){
            var formData = v.formData(v.chooseUser); axios.post(this.url+"user/passwordupdateUser", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                }else{
                  
                      swal({
                            position: 'center',
                            type: 'success',
                            title: 'Modificado!',
                            showConfirmButton: false,
                            timer: 1800
                          });
                    v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();
                
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
        getData(users){
            v.emptyResult = false; // become false if has a record
            v.totalUsers = users.length //get total of user
            v.users = users.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination
            
             // if the record is empty, go back a page
            if(v.users.length == 0 && v.currentPage > 0){ 
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
                      v.users = null 
                     v.totalUsers = 0 //remove current page if is empty
            
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