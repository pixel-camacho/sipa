
v = new Vue({
	el:'#app',
	data:
	{

	currentPage: 0,
    rowCountPage: 10,
    totalPolizas: 0,
    pageRange: 2,	
	loading: false,
	mostrar:true,
	polizas: [],
	buscarp: {
            text: ''
            }
 

	},methods:
	{
		buscar()
		{

			loading = true;
			NProgress.start()
			mostrar = true;

			axios.get('http://190.9.53.22:8484/apiSIPA/gmm/buscarPolizas',
			{
				params:
				{
					asegurado: this.$refs.asegurado.value,
					certificado: this.$refs.certificado.value,
					noPoliza: this.$refs.noPoliza.value
				}
			}).then(function(response){

				if(response.data.polizas === null)
				{
					NProgress.done()
					v.noResult()
				
				}else
				{
					NProgress.done()
					v.getData(response.data.polizas);
				}

			})

		
		},getData(polizas) {
            this.loading = false;
            v.emptyResult = false; // become false if has a record
            v.totalPolizas = polizas.length; //get total of user
            v.polizas = polizas.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.polizas.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                //v.clearAll();  
            }
        },
        noResult() {
            this.loading = false;
            v.emptyResult = true; // become true if the record is empty, print 'No Record Found'
            v.polizas = null
            v.totalPolizas = 0 //remove current page if is empty

        },
        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh()
        },
          refresh(){
             v.buscarp.text ? v.buscar() : v.buscar();

       }
	}
})