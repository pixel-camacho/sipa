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
var v =  new Vue({
  el: '#app',
  data:{
     solicitudes:[],
     loading: false
   
  },
 created(){
      this.searchSolicitud(); 
    },
  methods:{
  	  searchSolicitud(){ 
        //   var ide = this.$route.params.id;
  	   		  loading: false
              axios.get('http://190.9.53.22:8484/appsipaapi/solicitudes.php',  {
							  params: {
							    parametotext: "280480s"
							  }
					  }).then(response => {
              // JSON responses are automatically parsed.
              this.solicitudes = response.data
            })
            .catch(e => {
              this.errors.push(e)
            })


        
    
  }
}
}
)