Vue.config.devtools = true
var v = new Vue({
    el: '#app',

    data: {
        url: 'http://201.159.17.216:8484/sipa/',
        loading: false,
        mostrar: true,
        solicitudid: 0,
        mostrarregistros:false,
        detallepoliza: false,
        solicitudes: [],
       
        series: [],
        errors: [],
        search: {
            text: ''
        }, 
         

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
            axios.get('http://190.9.53.22:8484/appsipaapi/serie.php', {
                params: {
                    id: this.$refs.search.value
                }
            }).then(function(response) {
                
                NProgress.done()
                v.loading=false;
                v.mostrarregistros = true;
                v.series = response.data
            }) 


        }
      
    }
})