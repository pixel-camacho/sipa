
      $(document).ready( ()=> {

        $('#cargando').hide();
      
        let card = $('#aseguradoGmm').hide();
        let name  = $('#name').val();
        let poliza = $('#poliza').val();
        let estatus = document.getElementById('estatus');
        let img = document.getElementById('imgGmm');
        let beneficiarios =  document.getElementById('beneficiarios');
         

        if(name == '' && poliza == '')
        {
          return;
        }else
        {

          $.ajax({
          type: 'POST',
          url: 'http://190.9.53.22:8484/apiSIPA/gmm/buscarPolizas',
          data: `asegurado=${name}&noPoliza${poliza}`,
          dataType: 'json',

          beforeSend: ()=> $('#cargando').show(),
          complete: ()=> $('#cargando').hide(),

          success: (response)=>
          {
            $('#form-search').hide();

             let poliza = response.polizas[0];

             document.getElementById('asegurado').innerHTML = '<strong> Asegurado: </strong>'+poliza.asegurado;
             document.getElementById('noPoliza').innerHTML = '<strong>Poliza: </strong>'+poliza.noPoliza;
             //document.getElementById('certificado').innerHTML = 'Certificado: '+poliza.certificado;
             if(poliza.clasificacion  == 'Transferido')
             {
              estatus.innerHTML = `<span class="badge badge-primary" style="font-size: 14px; ">Transferido</span>`;
             }else if(poliza.clasificacion == 'Activo')
             {
            estatus.innerHTML =  `<span class="badge badge-success" style="font-size: 14px;">Activo</span>`;
             }else{
              estatus.innerHTML = `<span class="badge badge-danger" style="font-size: 14px;"> No transferido</span>`;
             }
             if(poliza.clasificacion == 'Transferido')
             {
              img.src = "../images/latino.png";                              
             }else{
              img.src = "<?php echo base_url('assets/images/sisnova.png'); ?>";
             }
             if(poliza.beneficiario === null){
              beneficiarios.innerHTML = '<strong> No cuenta con beneficiarios</strong>';
             }else{
              beneficiarios.innerHTML = poliza.beneficiario;
             }

             card.show();

          }
        });
  
        }

         });
