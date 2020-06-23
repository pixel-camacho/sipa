var v  = new Vue ({
    el:'#app',
    data:
    {
        productos:[],
        tramites:[],
        estatus:[],
        solicitudes:[],
        apmaterno: '',
        search: {
            text: ''
        },
        loading: false,
        mostrar: true,
        currentPage: 0,
        rowCountPage: 9,
        totalSolicitudes: 0,
        emptyResult: false,
        pageRange: 3,
        select: '',
        select1: '',
        select2: ''
      
    },
    created()
    {
      this.allProductos();
      this.allTramites();
      this.allEstatus();

    },methods:
    {

      BuscarcarSolicitudes()
      {
        this.loading = true;
        NProgress.start()
        this.mostrar = true;
       

        axios.get('http://190.9.53.22:8484/apiSIPA/solicitud/buscarSolicitud',
        {
          params:
          { 
            noPoliza: this.$refs.noPoliza.value,
            certificado: this.$refs.certificado.value,
            asegurado: this.$refs.asegurado.value,
            producto: this.select,
            tramite: this.select1,
            estatus: this.select2

          }
        }).then( function(response)
        { 

          if(response.data.solicitud === null)
          {
              NProgress.done()
              v.noResult()       

          }else
          {
            NProgress.done()
            v.getData(response.data.solicitudes);

          }
           
        });

          },
    
         allProductos()
         {
           axios.get('http://190.9.53.22:8484/apiSIPA/Producto/allProducto').
                 then(response =>(this.productos = response.data));
         },
         allTramites()
         {
           axios.get('http://190.9.53.22:8484/apiSIPA/TipoTramite/allTipoTramite').
                 then(response =>(this.tramites = response.data));
         },
         allEstatus()
         {
           axios.get('http://190.9.53.22:8484/apiSIPA/Estatus/allEstatus').
                 then(response => (this.estatus = response.data));
         },
          getData(solicitudes) {
            this.loading = false;
            v.emptyResult = false; // become false if has a record
            v.totalSolicitudes = solicitudes.length; //get total of user
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
          refresh(){
             v.search.text ? v.BuscarcarSolicitudes() : v.BuscarcarSolicitudes();

       }
   

     }

})