<!DOCTYPE html>
<html>
<head>

<script type="text/javascript">
	var solicitudId = '<?php echo $solicitudId; ?>';
</script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css'); ?>">

<style>

   #tab1:checked ~ #content1,
   #tab2:checked ~ #content2,
   #tab3:checked ~ #content3,
   #tab4:checked ~ #content4,
   #tab5:checked ~ #content5,
   #tab6:checked ~ #content6 {

      display:block;
   }

     input:checked + label {
        color: #555;
        border: 1px solid #ddd;
        border-top: 2px solid orange;
        border-bottom: 1px solid #fff;
    } 

     label:hover {
        color: #888;
        cursor: pointer;
    }

    label[for*='1']:before { content: '\f02c'; }
    label[for*='2']:before { content: '\f0c0'; }
    label[for*='3']:before { content: '\f2bc'; }
    label[for*='4']:before { content: '\f0ca'; }
    label[for*='5']:before { content: '\f02f'; }
    label[for*='6']:before { content: '\f1a9'; }

    label:before {
        font-family: fontawesome;
        font-weight: normal;
        margin-right: 5px;
    }

      label {
        display: inline-block;
        margin: 0 0 -1px;
        padding: 5px 10px;
        font-weight: 400;
        text-align: center;
        color: #bbb;
        border: 1px solid transparent;
    }

     input #tab1, #tab2, #tab3, #tab4, #tab1, #tab5, #tab6 {

        display: none;
    }

      section {
        display: none;
        padding: 10px 0 0;
        border-top: 1px solid #ddd;
    }

     main {
        min-width: 320px;
        max-width: 1100px;
        padding: 10px;
        margin: 0 auto;
        background: #fff;
      }

      table a{
        text-decoration: none;
        color: black;
      }

      table a:hover{
        color: black;
      }

      table button{
        border-radius: 20px;
        background-color: transparent;
      }

      #texto{
       text-decoration-line: none;
      }

      #Anterior {
        text-decoration: none;
      }
 /*     
 ul #navigation {
    position: fixed;
    margin: 0px;
    padding: 0px;
    top: 0px;
    list-style: none;
    z-index:999999;
    
}
ul#navigation li {
    width: 103px;
    display:inline;
    float:left;
}
ul#navigation li a {
    display: block;
    float: left;
    margin-top: -2px;
    width: 100px;
    height: 25px;
    background-color: #E7F2F9;
    background-repeat: no-repeat;
    background-position: 50% 10px;
    border: 1px solid #BDDCEF;
    text-decoration: none;
    text-align: center;
    padding-top: 80px;
}

ul#navigation li a {
    display: block;
    float:left;
    margin-top: -2px;
    width: 100px;
    height: 25px;
    background-color:#E7F2F9;
    background-repeat:no-repeat;
    background-position:50% 10px;
    border:1px solid #BDDCEF;
    text-decoration:none;
    text-align:center;
    padding-top:80px;
    -moz-border-radius:0px 0px 10px 10px;
    -webkit-border-bottom-right-radius: 10px;
    -webkit-border-bottom-left-radius: 10px;
    -khtml-border-bottom-right-radius: 10px;
    -khtml-border-bottom-left-radius: 10px;
    opacity: 0.7;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
}
ul#navigation li a:hover{
     background-color:#CAE3F2;
}
ul#navigation li a span{
    letter-spacing:2px;
    font-size:11px;
    color:#60ACD8;
    text-shadow: 0 -1px 1px #fff;
}

ul#navigation .print{
  background-image: url("<?php echo base_url();?>/assets/images/print.svg");
  background-position: center;
}*/
 #el{
  letter-spacing:2px;
    font-size:11px;
    color:#60ACD8;
    text-shadow: 0 -1px 1px #fff;
 }
  button{
 position: static;
 max-width:30%;
 text-align: center;
 
 }

 #demo ul{ 
  margin: 0px;
  padding: 0px;
  width: 30%;
     }
     #demo ul li{
       display: inline;
       text-decoration: none;    
     }
  a{
    text-decoration: none;
  }

  #pagar{
    float: right;
    margin: 0px;
  
  }

   #money{
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
    transition: transform 1s;

 }
 #money:hover{
  transform: scaleY(-1.1);
 }
 #modal-pagar1{
  border-radius: 20px;
 }

 .form{

  background-image: url("<?php echo base_url('assets/images/logo1.png'); ?>");
  background-repeat: no-repeat;
  background-position: center;


 }
 #btnPrint{
  background-color: #ffbf00;
 }
 #lista{
  text-decoration: none;
 }

/* #money:hover{
  transform: translate(10%,-10%);
 }*/

</style>
</head>

<body>

<div class="main-panel ">

<!-- <ul id="navigation">
   <li><a class="print"   href=" <?php echo base_url('cliente/imprimir');?>/<?php echo $solicitudId;?> "><span>Imprimir</span></a></li>
 </ul>-->
 <?php if($datospoliza['producto'] == 'GMM' && $datospoliza['paqueteId'] == 12 || $datospoliza['paqueteId'] == 13 || $datospoliza['paqueteId'] == 14 || $datospoliza['paqueteId'] == 15) :?>
  <button class="btn btn-outline" type="button" data-toggle="collapse" data-target="#demo" id="btnPrint">
    <i class="fa fa-print"></i>
    Imprimir
  </button>
  <div id="demo"class="collapse">
    <ul id="lista">
    <li><a  href="<?php echo base_url('cliente/imprimir');?>/<?php echo $solicitudId;?>">Autorizacion</a></li>
    <li><a  href="<?php echo base_url('cliente/tarjeta');?>/<?php echo $solicitudId;?>" target="_blank">Tarjeta virtual</a></li> 
    <li><a  href="<?php echo base_url('cliente/letterCard');?>/<?php  echo $solicitudId;?>" target="_blank">Tarjeta física</a></li> 
    <li><a >Formato</a></li>
    </ul>
  </div> 
<?php endif ?>


	<div class="content-wrapper">   
		    <div class ="card">
				<div class="row">
                        <div class="col-md-4">
                           <div class="card-body">
                              <h4 class="card-title text-primary">Datos de la Poliza</h4>
                              <p class="card-description"></p>
                              <div class="template-demo">
                                 <p>Estatus: <span class="font-weight-bold"><?php echo $datospoliza['estatus'];?></span> </p>
                                 <p>Compañia: <span class="font-weight-bold"><?php echo $datospoliza['compania'];?></span> </p>
                                 <p>Poliza: <span class="font-weight-bold"><?php echo $datospoliza['noPoliza'];?></span> </p>
                                 <p>Poliza Anterior: <a href="/sipa/cliente/poliza/<?php echo $datospoliza['polizaAnterior']; ?>" id="Anterior"><span class="font-weight-bold"><?php echo $datospoliza['polizaAnterior'];?></span></a></p>
                                 <p>Producto: <span class="font-weight-bold"><?php echo $datospoliza['producto']; ?></span> </p>
                                 <p>Vigencia: <span class="font-weight-bold"><?php echo $datospoliza['fechaInicio'];?><?php echo $datospoliza['fechaFin'];?></span> </p>
                                 <p></p>
                              </div>
                           </div>
                        </div>
						
                        <div class="col-md-4">
                           <div class="card-body">
                              <h4 class="card-title text-primary">Datos del Contratante</h4>
                              <p class="card-description"></p>
                              <div class="template-demo">
                                 <p>Contratante: <span class="font-weight-bold"><?php echo $datospoliza['contratante'] ?></span> </p>
                                 <p>Total: <span class="font-weight-bold"><?php echo $datospoliza['total'] ?></span> </p>
                                 <p>Tipo Pago: <span class="font-weight-bold"><?php echo $datospoliza['periodo'] ?><?php echo $datospoliza['clave'] ?></span> </p>
                                 <p>Descuento: <span class="font-weight-bold"><?php echo $datospoliza['descuento'] ?></span> </p>
                                 <p>Primer descuento: <span class="font-weight-bold"> <?php echo $datospoliza['fechaPrimer']; ?><?php echo $datospoliza['periodoinicio'];?></span> </p>
								 <P>Municipio: <span class="font-weight-bold"> <?php echo $datospoliza['municipio']; ?> </span></P>
								 <p>Paquete:<span class="font-weight-bold"><?php echo $datospoliza['paquete']; ?> </span></p>
                              </div>
                           </div>
                        </div>
						
						
                        <div class="col-md-4">
                           <div class="card-body">
                              <h4 class="card-title text-primary"> Personas Relacionadas</h4>
                              <p class="card-description"> </p>
                              <div class="template-demo">
                                 <p>Asegurado: <span class="font-weight-bold"><?php 
                                      $subString = explode('-',$datospoliza['asegurado']);

                                 echo $subString[1].'<br>'.
                                      $subString[0]; ?></span> </p>
                                 <p>Edad de asegurado: <span class="font-weight-bold"><?php echo $datospoliza['edadAsegurado'] ?></span> </p>
                                 <p>Responsable: <span class="font-weight-bold"><?php 
                                      $subString = explode('-', $datospoliza['responsable']);

                                 echo $subString[1].'<br>'.
                                      $subString[0]; ?> </span> </p>
                                 <p>Edad de responsable: <span class="font-weight-bold"> <?php echo $datospoliza['edadResponsable'];?></span> </p>
								 <p>Usuario vendedor: <span class="font-weight-bold"><?php echo "<br>"; ?> <?php echo $datospoliza['Agente']; ?> </span></p>
                              </div>
                           </div>
                        </div>
						
                     </div>
                     <main>


               <input id="tab1" type="radio" name="tabs" checked>
               <label for="tab1">Pendiente</label>

               <input id="tab2" type="radio" name="tabs">
               <label for="tab2">Beneficiarios</label>       

               <input id="tab3" type="radio" name="tabs" >
               <label for="tab3">Documentos</label>

               <input id="tab4" type="radio" name="tabs">
               <label for="tab4">Estado de Cuenta</label>

               <input id="tab5" type="radio" name="tabs">
               <label for="tab5">Movimientos de Nomina </label>

               <input id="tab6" type="radio" name="tabs">
               <label for="tab6">Liquidacíon</label>



              <section id="content1">
                <p>
                  <div id="pendientes">
                  <h4>Pendientes Y Seguimientos</h4>
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Folio</th>
                          <th>fecha</th>
                          <th>Descripcion</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="pendiente  in pendientes">
                          <td>{{pendiente.folio}}</td>
                          <td> 
                           <span class="font-weight-bold"> Inicio: </span> {{pendiente.fechaInicio}}
                            <br>
                            <span class="font-weight-bold"> Fin: </span> {{pendiente.fechaFin}} 
                            <br>
                            <span class="font-weight-bold">Retraso: </span> {{pendiente.atraso}} </td>
                          <td>{{pendiente.descripcion}}<br>
                              <strong>Estatus: </strong>{{pendiente.estatus}} 
                              <strong>Solicitante: </strong>{{pendiente.autor}}
                              <strong>Responsable: </strong> {{pendiente.responsable}}
                           </td>
                          <td><a href="#" title="Editar"><i class="menu-icon fa fa-pencil fa-2x"></i></a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                   </div>
                </p>
              </section>


              <section id="content2">
              <div id="beneficiario">
                <p>
                  <h4>Beneficiarios</h4>
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Parentesco</th>
                          <th>Porcentaje %</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in beneficiante">
                          <td>{{item.nombre}}</td>
                          <td>{{item.parentesco}}</td>
                          <td>{{item.porcentaje}}</td>
                          <td><a href="#" title="Editar"><i class="menu-icon fa fa-pencil fa-2x"></i></a></td>
                          <td><a href="#" title="Eliminar"><i class="menu-icon fa fa-close fa-2x"></i></a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </p>
              </div>
              </section>


               <section id="content3">
                <div id="Documentacion">
                  <p>
                    <h4>Documentos de la Solicitud</h4>
                    <div class="table-responsive">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th>Tipo Documento</th>
                            <th>Archivo</th>
                            <th>Fecha</th>
                            <th>Obligatorio</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item,index) in documentos" v-bind:key="item.documentoId">
                            <td>{{item.tipodocumento}}</td>
                            <td>
                              <div class="d-flex justify-content-between">
                            <p>
                            {{item.documento}}
                            </p>
                            <div v-if="item.descripcion === null " >
                            
                            <a href="#" :data-id="item.documentoId" data-toggle="modal" data-target="#modalUp" @click="EnviarDato">Subir</a>
                            </div>
                            <div v-else>
                            <a @click="obtenerDocumento(item.documentoId,item.titulo)" class="btn btn-icons btn-rounded" style="background-color: rgba(255, 153, 51,.9);" >
                              <i class="menu-icon  fa fa-download fa-2x"></i></a>
                            </div>
                            </div>
                          </td>
                            <td>{{item.fecha}}</td>
                            <td class="text-center">
                              <div v-if="item.obligatorio == 1" style="color: green;">
                                SI
                              </div>
                              <div v-else style="color: red;">
                                NO
                              </div>
                            </td>
                            <td><a href="#" title="Eliminar"><i class="menu-icon fa fa-close fa-2x"></i></a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </p>
                 
                  </div>
               </section>

               <section id="content4">
                <div id="estadoCuenta">
                  <div id="pagar">
                      <label id="title">Pagar</label><br>
                      <a id="btnPagar" href="" @click="obtenerParametros">
                       <img id="money" src="<?php echo base_url('assets/images/moneda.png'); ?>">
                       </a>
                     <!-- <li class="menu-icon fa fa-dollar fa-2x" id="money"></li> -->                      
                  </div>

                    <h4>Detalles de Movimiento</h4>
                    
                    <div class="table-responsive">
                      
                      <table class="table table-sm">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Fecha de Pago</th>
                            <th>Periodo</th>
                            <th>Movimiento</th>
                            <th>Cargo</th>
                            <th>Abono</th>
                            <th>Saldo</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="item of estados" class="registro">
                            <td><input type="checkbox" disabled="true"></td>
                            <td >{{item.fecha}}</td>
                            <td >{{item.periodo}}</td>
                            <td >{{item.movimiento}}</td>
                            <td >{{item.cargo}}</td>
                            <td >{{item.abono}}</td>
                            <td>
                               <div v-if="item.saldo < 0 && item.movimiento === 'ABONO MANUAL'" class="d-flex justify-content-between">
                                $0.00
                                <a @click="enlace(item.periodo)" class="url" href="" >
                                 <i class="menu-icon fa fa-print fa-2x" title="recibo"></i> 
                                </a>
                                <!-- <a href="<?php echo base_url('cliente/recibo');?>/<?php echo $solicitudId;?>">
                                 <i class="menu-icon fa fa-print fa-2x" title="recibo"></i> 
                              </a> -->
                              </div>
                              <div v-else  class="d-flex justify-content-between">
                                {{item.saldo}}
                              </div>
                            </td>
                            <td><a href="#" title="Limpiar"><i class="menu-icon fa fa-trash fa-2x"></i></a></td>
                          </tr>
                          <tr v-for="item of estadosC"  class="linea">
                             <td><input id="checkbox"  type="checkbox"  class="value"  onchange="seleccion()" ></td>
                             <td>{{item.fecha}}</td>
                             <td>{{item.periodo}}</td>
                             <td>{{item.movimiento}}</td>
                             <td>{{item.descuento}}</td>
                             <td>{{item.abono}}</td>
                             <td>{{item.saldo}}</td>
                             <td></td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                    </div>

                    <!--  <div id="estadosCuenta">
                        <div class="table-responsive">
                      <table class="table table-sm">
                        <tbody>
                          <tr v-for="item in estadosCuenta">
                          <td><input type="checkbox" class="form-item" :style="" ></td>
                          <td width="19%">{{item.fecha}}</td>
                          <td width="11%">{{item.periodo}}</td>
                          <td width="10%">{{item.movimiento}}</td>
                          <td>{{item.descuento}}</td>
                          <td width="12.5%">{{item.abono}}</td>
                          <td >{{item.saldo}}</td>
                          <td><td>
                          </tr>
                        </tbody>
                      </table>
                      </div>
                    </div> -->
                </section>

               <section id="content5">
                <div id="movimientoNomina">
                  <p>
                    <div class="row">
                      <div class="col-md-11">
                    <h4>Movimiento Nómina</h4>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" title="Agregar"><i class="menu-icon fa fa-plus fa-2x"></i></button>
                    </div>
                    <div class="table-responsive">
                     <table class="table table-sm">
                        <thead>
                           <tr>
                              <th>Fecha de registro</th>
                              <th>periodo</th>
                              <th>Cliente</th>
                              <th>Descuento</th>
                              <th>Tipo Movimiento</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr v-for="campo in cuenta">
                              <td>{{campo.fecha}}</td>
                              <td>{{campo.periodo}}</td>
                              <td>{{campo.cliente}}</td>
                              <td>{{campo.descuento}}</td>
                              <td>{{campo.movimiento}}</td>
                              <td><a href="#" title="Editar"><i class="menu-icon fa fa-edit fa-2x"></i></a></td>
                           </tr>
                        </tbody>
                     </table>  
                    </div> 
                  </p>
                  </div>
               </section>

               <section id="content6">
                <div id="liquidacion">
                <p>
                  <h4>Recibos para Liquidar</h4>
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Numero de Recibo</th>
                          <th>Monto</th>
                          <th>Fecha de Pago</th>
                          <th>Fecha Liquidacion</th>
                          <th>Fecha Deposito</th>
                        </tr>
                        <tbody>
                          <tr v-for="campo in recibo">
                            <td><input type="checkbox" id="select"> </td>
                            <td>{{campo.norecibo}}</td>
                            <td>{{campo.montorecibo}}</td>
                            <td>{{campo.fechalimite}}</td>
                            <td>{{campo.fechaLiquidacion}}</td> 
                            <td></td>
                          </tr>
                        </tbody>
                      </thead>
                    </table>
                  </div>
   
                </p>
                </div>
             
               </section>

               </main>
                  </div>
				  </div>
               </div>


			   </div>
            </div>	
		
	</div>
	
 </div>

<!--MODAL -->
  <div class="modal fade" id="modalUp" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title" id="exampleModalLabel">Subir Archivo</h4> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
       <!-- <div class="d-flex justify-content-center">
        <img src="<?php echo base_url('assets/images/cinta.jpg'); ?>">
         </div> -->
         <hr>
     <form  id="form-document" role="form" method="POST" action="<?php echo base_url('cliente/upload'); ?>" enctype="multipart/form-data">
         <input type="file" id="mi_file" name="mi_file"> 
         <input type="hidden" id="documentoId" name="documentoId">
         <hr>
    </div>
    <div class="modal-footer">
          <input type="submit" id="upload" class="btn btn-primary" value="Upload"/>
          <button type="button" class="btn btn-danger" id="btnCerrar" name="btnCerrar" data-dismiss="modal">Cerrar</button>
   </div>
   </form> 
  </div>
</div>
</div> 
 </div>

 <!--MODAL DE PAGO-->
 <div class="modal fade" id="exec" role="dialog" aria-hidde="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" id="modal-pagar1">
      <div class="modal-header">
        <h5 id="tituloModal">Pago del periodo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="tue">&times;</span>
        </button>
      </div>
      <div  class="modal-body form">
       <!-- <img src="<?php echo base_url('assets/images/mantenimiento.png');?>"> -->
              
      <form id="form-pay" role="form" method="POST"  > 
       
        <div class="row">

          <div class="col-sm-6" id="option">
          <strong>Metodo de pago</strong>
            <select class="form-control" id="tipopago" name="tipopago" >
              <option value="0">Seleccionar....</option>
              <option value="1">Efectivo</option>
              <option value="2">Tarjeta de Credito</option>
              <option value="3">Deposito Bancario</option>
              <option value="4">Tarjeta de Debito</option>
            </select>
          </div>

          <div class="col-sm-6" id="numero" style="display: none;">
            <strong>Num. autorizacion</strong>
            <input type="text" class="form-control" id="autorizacion" name="autorizacion">
          </div>

          <div class="col-sm-6" id="deposito" style="display: none;">
            <strong>Ficha de depososito</strong>
            <input type="text" class="form-control" id="ficha" name="ficha">
          </div>
        </div>
        <input type="hidden" id="valor" name="valor">
        <input type="hidden" id="nombre" name="nombre">
        
      </div>
      <div class="modal-footer">
        <input type="submit" name="btnPagar" id="enviarInformacion" class="btn" style="background-color: #ffbf00; "  value="Pagar"> 
        <button type="button" class="btn" style="background-color: #D2691E;" data-dismiss="modal">Cancelar</button> 
      </div>
      </form> 
    </div>
  </div>
 </div> 


<footer class="footer">
	<div class="container-fluid clearfix">
		<span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php echo date('Y') ?>
		<a href="http://www.proteges.mx" target="_blank">Proteges</a>. Todos los derechos reservados.
		</span>
		<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Departamento de Sistemas
		<i class="fa fa-code text-danger"></i>
		</span>
	</div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo base_url();?>/assets/vue/appvue/cliente/loadData.js"></script>
<script src="<?php echo base_url();?>/assets/js/operaciones.js"></script>
<script src="<?php echo base_url();?>/assets/js/event.js"></script> 
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet"/>

</body>
</html>

 