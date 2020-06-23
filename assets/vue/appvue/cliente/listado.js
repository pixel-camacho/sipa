/*new Vue({
	el:'#pendinetes',
	data ()
	{
		return
		{
			lista: [],
			id: solicitudId
		}
	},mounted()
	{

axios.get('http://190.9.53.22:8484/appsipaapi/cliente/listaPendientes.php',
		{
			params:
			{
				solicitudId: this.id
			}
		}).then(response => {
			this.recibo = response.data.cuentas
			console.log(this.recibo);
		}).catch(error => console.log(error));

	}

})