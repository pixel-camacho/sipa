
new Vue ({
    el:'#liquidacion',
    data:
    {
        recibo: [],
        estado: false,
        scorePlayer: solicitudId
    },
    mounted()
    {

        axios.get('http://190.9.53.22:8484/appsipaapi/reciboLiquidacion.php',{

            params:
            {
                solicitudId: this.scorePlayer
            }
        }).then(response =>
        {

            this.recibo = response.data
            console.log(this.recibo);
        }).catch(error => console.log(error));
    }
});


new Vue({
    el: '#movimientoNomina',
    data:
    {
        cuenta: [],
        scorePlayer: solicitudId
    },
    mounted()
    {
        axios.get('http://190.9.53.22:8484/appsipaapi/obtenerEstadoCuenta.php',{
            params:
            {
                solicitudId : this.scorePlayer
            }
        }).then(response =>
        {
            this.cuenta = response.data
            console.log(this.cuenta);
        }).catch(error => console.log(error));
    }
});

new Vue ({
    el:'#estadoCuenta',
    data:
    {
        estado: false,
        estados: [],
        estadosC:[],
        scorePlayer: solicitudId
    },
    mounted()
    {

      var url  = 'http://190.9.53.22:8484/appsipaapi/estadosdeCuentaXpoliza.php?solicitudId='+solicitudId;
      var url1 =  'http://190.9.53.22:8484/appsipaapi/estadosdeCuentaXpoliza2.php?solicitudId='+solicitudId;

    axios.all([axios.get(url),axios.get(url1)]
        ).then(response => 
        {
           this.estados = response[0].data
           this.estadosC = response[1].data


        }).catch(error =>console.log(error));
    },
    created()
    {
        document.getElementById('checkbox').cheked = false;
      //document.getElementById('pagar').style.display = 'none';
    },
      methods:
      {
        enlace(periodo)
        {

          var row = document.querySelectorAll('.registro');
          var direccion = 'http://190.9.53.22:8484/sipa/cliente/recibo/'+this.scorePlayer+'/'+periodo;
          var hipervinculo = document.querySelectorAll('.url');
           
       
          for(var i = 0; i < row.length; i++)
          {

            if(row[i].cells[2].innerHTML == periodo){

              for(var a = 0 ; a < hipervinculo.length ; a++)
              {
                hipervinculo[a].href = direccion;
              }

            }
          }     
        },

        obtenerParametros(){

        function periodos()
  {

  var row =  document.querySelectorAll('.linea');
  var checkbox = document.querySelectorAll('.value');
  var periodos = [];

    for(var i = 0 ; i < checkbox.length ; i++)
    { 
          if(checkbox[i].checked)
          {
            periodos.push(row[i].cells[2].innerHTML);
          }
    }
    return periodos;
  }
   var periodo = periodos().toString();

        document.getElementById('tituloModal').innerHTML = 'Pago del periodo '+periodo;
        document.getElementById('valor').value = periodo;
        document.getElementById('nombre').value = vendedor;

 
          
        }
  
  }
   

});

/*
 new Vue({
    el:'#estadosCuenta',
    data:
    {
        estadosCuenta: [],
        scorePlayer: solicitudId
    },
    mounted()
    {
        axios.get('http://190.9.53.22:8484/appsipaapi/estadosdeCuentaXpoliza2.php',{ 
          params: { solicitudId: this.scorePlayer}
           }).then( response => 
           {
            this.estadosCuenta = response.data
            console.log(this.estadosCuenta);
           }).catch( error => console.log(error));
    }
}); */

 new Vue ({
    el:'#Documentacion',
    data:
    {
        documentos: [],
        scorePlayer: solicitudId,
        documento: [],
        id: ''
    },
    mounted()
    {
        axios.get('http://190.9.53.22:8484//appsipaapi/documentoSolicitados.php',{
            params:
            {
                solicitudId : this.scorePlayer
            }
        }).then(response =>{
            this.documentos = response.data
            console.log(this.documentos);
        }).catch(error => console.log(error));
    },
    methods:
    {
        obtenerDocumento(documentoId,titulo)
        {
            this.Documento = documentoId;


            axios.get('http://190.9.53.22:8484/appsipaapi/cliente/documentosCliente.php',
            {
                params:
                {
                    solicitudId: this.scorePlayer,
                    documentoId: documentoId
                }
            }).then( response =>
            {
                this.documentoArray = response.data.documentos


/*function hexToBytes(hex) {
    for (var bytes = [], c = 0; c < hex.length; c += 2)
    bytes.push(parseInt(hex.substr(c, 2), 16));
    return bytes;
}
       var bin = hexToBytes(hexadecimal)
      
    //var base64 = String.fromCharCode.apply(this , hexadecimal.replace(/\r|\n/g, "").
       //             replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" "));


}*/      
function hexToString (hex) {
    var string = '';
    for (var i = 0; i < hex.length; i += 2) {
      string += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    }
    return string;
}

               var image = this.documentoArray[0]['contenido'];

                 if(image.length > 150)
                 {
                     function hexdec(hexString) {
               
             hexString = (hexString + '').replace(/[^a-f0-9]/gi, '')
               return parseInt(hexString, 16)
              }

              function hex2bin(hexSource) {  
                   var bin = '';
              for (var i=0;i<hexSource.length;i=i+2) 
              {
                bin += String.fromCharCode(hexdec(hexSource.substr(i,2)));
              }
                return bin;
              }


              var hexadecimal = this.documentoArray[0]['contenido'];
              var titulo = this.documentoArray[0]['titulo']; 
              var hexa1 = hex2bin(hexadecimal);
              var base64 =  btoa(hexa1);
                    
                     
               var link = document.createElement('a');
               link.download = titulo;
               link.href = 'data:application/octet-stream;base64,' +  base64;
               link.click();
                   
                    return;
                 }
                 else
                 {
                   var ruta = this.documentoArray[0]['titulo'];
                   var nombre = this.documentoArray[0]['nombre'];
                    

                   var btn = document.createElement('a');
                   btn.download = nombre;
                   btn.href = ruta;
                   btn.click();
      
                      return;
                 }
                    

            
               
            }).catch( error => console.log(error));
        },
        EnviarDato()
        {    
           var element = event.target;
           var id = element.getAttribute('data-id');
           var datos = document.getElementById('documentoId').value= id;
        } 
        
    }


     });

 new Vue({
    el:'#beneficiario',
    data:
    {
        beneficiante: [],
        id: solicitudId
    },mounted()
    {
        axios.get('http://190.9.53.22:8484/appsipaapi/cliente/beneficiarioPoliza.php',
        {
            params:
            {
                solicitudId: this.id
            }
        }).then( response =>
        {
            this.beneficiante = response.data
            


            console.log(this.beneficiante)

        }).catch(error => console.log(error));
    }
 });
 

new Vue({
    el:'#pendientes',
    data:
    {
        solicitudId: solicitudId,
        pendientes: []
    },
    created:
    function(){
        this.solicitudId = solicitudId;

        axios.get('http://190.9.53.22:8484/appsipaapi/cliente/listaPendientes.php',
        {
            params:
            {
                solicitudId: this.solicitudId
            }
        }).then(response => {
  
                    this.pendientes = response.data
                    console.log(this.pendientes);

        }).catch(error => console.log(error));
    }
});




