<!-- partial -->
<script type="text/javascript">
    var idcliente = '<?php echo $idcliente; ?>';

</script>

<style type="text/css"> 
    main {
        min-width: 320px;
        max-width: 1100px;
        padding: 10px;
        margin: 0 auto;
        background: #fff;
    }

    section {
        display: none;
        padding: 10px 0 0;
        border-top: 1px solid #ddd;
    }

    input {
        display: none;
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

    label:before {
        font-family: fontawesome;
        font-weight: normal;
        margin-right: 5px;
    }

    label[for*='1']:before { content: '\f2bc'; }
    label[for*='2']:before { content: '\f0ca'; }
    label[for*='3']:before { content: '\f02f'; }
    label[for*='4']:before { content: '\f1a9'; }
    label[for*='5']:before { content: '\f1a9'; }
    label[for*='6']:before { content: '\f1a9'; }
    label[for*='7']:before { content: '\f1a9'; }
    label[for*='8']:before { content: '\f1a9'; }
    label[for*='9']:before { content: '\f1a9'; }

    label:hover {
        color: #888;
        cursor: pointer;
    }

    input:checked + label {
        color: #555;
        border: 1px solid #ddd;
        border-top: 2px solid orange;
        border-bottom: 1px solid #fff;
    }

    #tab1:checked ~ #content1,
    #tab2:checked ~ #content2,
    #tab3:checked ~ #content3,
    #tab4:checked ~ #content4,
    #tab5:checked ~ #content5,
    #tab6:checked ~ #content6,
    #tab7:checked ~ #content7,
    #tab8:checked ~ #content8, 
    #tab9:checked ~ #content9 {
        display: block;
    }
		
	table a:hover {	
	  text-decoration:none;
	  color:black;
	}

</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div id="app"> 
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h3><strong>Cliente</strong></h3> 

								<div class="row "  >
                                <div class="col-12" align="center" >
                                    <p class="text-center"><strong><h4><?php echo $datoscliente['nombre']; ?></h4></strong></p>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-3" style=" font-size: 14px;">
                                    <strong>RFC:</strong><?php echo $datoscliente['rfc']; ?><br>
                                    <strong>Nacionalidad:</strong> <?php echo $datoscliente['nacionalidad']; ?><br>
                                    <strong>C. Trabajo:</strong> <?php echo $datoscliente['nombrecentrotrabajo']; ?><br>
                                    <strong>Dirección:</strong> <?php echo $datoscliente['direccion'] . " " . $datoscliente['coloniadescr']; ?>

                                </div>
                                <div class="col-3" style=" font-size: 14px;">
                                    <strong>F. Nac.:</strong> <?php echo $datoscliente['fechanacimiento']; ?><br>
                                    <strong>E-mail:</strong> <?php echo $datoscliente['email']; ?><br>
                                </div>
                                <div class="col-3" style=" font-size: 14px;">
                                    <strong>Edad:</strong> <?php echo $datoscliente['edad']; ?> Años<br>
                                    <strong>Teléfonos:</strong> <?php echo $datoscliente['telefonos']; ?><br>
                                </div>
                                <div class="col-3" style=" font-size: 14px;">
                                    <strong>Sexo:</strong> <?php echo $datoscliente['sexo']; ?><br> 
                                </div>
                            </div>
                        </div>
                        <main>

                            <input id="tab1" type="radio" name="tabs" checked>
                            <label for="tab1">Polizas</label>
							
                            <input id="tab2" type="radio" name="tabs" >
                            <label for="tab2">Es. Cuenta</label>

                            <input id="tab3" type="radio" name="tabs">
                            <label for="tab3">En. de Servicio</label>

                            <input id="tab4" type="radio" name="tabs">
                            <label for="tab4">P. Anterior</label>
                            <input id="tab5" type="radio" name="tabs">
                            <label for="tab5">Pend. y Segui.</label>
                            <input id="tab6" type="radio" name="tabs">
                            <label for="tab6">SMS</label>
                            <input id="tab7" type="radio" name="tabs">
                            <label for="tab7">Notas</label>
                            <input id="tab8" type="radio" name="tabs">
                            <label for="tab8">Vis.</label>
                            <input id="tab9" type="radio" name="tabs">
                            <label for="tab9">Mov</label>

                            <section id="content1">
                                <div id="apppoliza">
                                    <div class="table-responsive ">
                                        <!--Table-->
                                        <table class="table table-striped" >
                                            <thead>
                                                <tr>
                                                    <th> No. Poliza </th>
                                                    <th>Contratante</th>
                                                    <th> Clave</th>
                                                    <th> Producto</th>
                                                    <th>Asegurado</th>
                                                    <th>Descuento</th>
                                                    <th> F. Registro</th>
                                                    <th>Estatus</th>
                                                    <th>Resp.</th>
                                                </tr>
                                            </thead>
                                            <tbody>	

                                                <tr v-for="row in polizas">
                                                    </div>
                                                    <td>	
                                                     <a  :href="'/sipa/cliente/poliza/' + row.solicitudId" >{{row.noPoliza}}</a> 	 
                                                    </td>	
                                                    <td>
                                                        {{row.contratante}}
                                                    </td>
                                                    <td>
                                                        {{row.clave}}
                                                    </td>
                                                    <td>
                                                        {{row.producto}}
                                                    </td>
                                                    <td>
                                                        {{row.nombre}}
                                                    </td>
                                                    <td>
                                                        <strong>$ {{row.descuento}}</strong>
                                                    </td>
                                                    <td> 
                                                        {{row.fecharegistro}}
                                                    </td>
                                                    <td>
                                                        {{row.estatus}}
                                                    </td>
                                                    <td>
                                                        <div v-if="row.clienteResponsableId === row.idCliente" style="color:green;">
                                                            SI

                                                        </div>
                                                        <div v-else style="color:red;">
                                                            NO 
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <section id="content2">
                                <div id="estadoCuenta">
                                <!--<a href="#next" data-toggle="collapse" role="button"><i class="menu-icon fa fa-file-text fa-2x"></i>
                                </a> Polizas
                                <div id="next" class="collapse"> -->
                                <p>
                                <h3 class="text-center text-light"><span class="badge badge-danger">Detalles de Movimientos</span></h3>
								<div class="table-responsive"> 
								<table class="table table-hover table-striped">
								<thead>
								<tr>
								<th>Solicitud</th>
								<th>Fecha de pago</th>
								<th>Período</th>
								<th>Concepto</th>
								<th>Movimiento</th>
								<th>Cargo</th>
								<th>Abono</th>
								<th>Saldo</th>
								</tr>
								</thead>
                                <tbody>
                                    <tr v-for="item in estadosDecuenta">
                                            </div>
                                        <td>******</td>
                                        <td>{{item.fecha}}</td>
                                        <td>{{item.periodo}}</td>
                                        <td>{{item.concepto}}</td>
                                        <td>{{item.movimiento}}</td>
                                        <td>{{item.cargo}}</td>
                                        <td>{{item.abono}}</td>
                                        <td>
                                            <div v-if="item.saldo < 0">
                                                $0.00
                                            </div>
                                            <div v-else>
                                        ${{item.saldo}}
                                        </div>
                                        </td>   
                                    </tr>
                                </tbody>
                                </table>
								</div>
                                </p>
                                </div> 
                            

                            </section>
							
                            <section id="content3">
                                <p>
                                    3333333333333333333
                                </p>
                            </section>

                            <section id="content4">
                                <div id="apppolizaanterior">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No. Poliza
                                                    </th>
                                                    <th>
                                                        Contratante
                                                    </th>
                                                    <th>
                                                        Clave
                                                    </th>
                                                    <th>
                                                        Producto
                                                    </th>
                                                    <th>
                                                        Estatus
                                                    </th>

                                                    <th>
                                                        F. Vigencia
                                                    </th>
                                                    <th>
                                                        Descuento
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr v-for="row in polizas">
                                                    <td>
                                                       <a :href="'/sipa/cliente/poliza/' + row.solicitudId" > {{row.noPoliza}} </a>
                                                    </td>
                                                    <td>
                                                        {{row.contratante}}
                                                    </td>
                                                    <td>
                                                        {{row.clave}}
                                                    </td>
                                                    <td>
                                                        {{row.producto}}
                                                    </td>
                                                    <td>
                                                        {{row.estatus}}

                                                    </td>

                                                    <td> 
                                                        {{row.fecharegistro}}
                                                    </td>
                                                    <td>
                                                        <strong>$ {{row.descuento}}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                            <section id="content5">
                                <p>
                                    4444444444444444444
                                </p>
                            </section>
                            <section id="content6">
                                <p>
                                    4444444444444444444
                                </p>
                            </section>
                            <section id="content7">
                                <p>
                                    4444444444444444444
                                </p>
                            </section>
                            <section id="content8">
                                <p>
                                    4444444444444444444
                                </p>
                            </section>
                            <section id="content9">
                                <div id="movimientosNomina">    
                                <p>
                                    <h3 class="text-start text-light"><span class=" badge badge-danger">Movimientos de Nomina</span></h3>
                                 <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>noPoliza</th>
                                                <th>Periodo Generado</th>
                                                <th>Periodo Enviado</th>
                                                <th>Tipo Movimiento</th>
                                                <th>Liquidez</th>
                                                <th>Descuento</th>
                                                <th>Fecha</th>
                                            </tr>
                                            <tbody>
                                                <tr v-for="item  in movimientosNomina">
                                                    <td>{{item.noPoliza}}</td>
                                                    <td>{{item.periodoInicio}}</td>
                                                    <td>{{item.periodoFin}}</td>
                                                    <td>{{item.movimiento}}</td>
                                                    <td>NO APLICA</td>
                                                    <td>{{item.descuento}}</td>
                                                    <td>{{item.fecha}}</td>
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





    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php echo date('Y') ?>
                <a href="http://www.proteges.mx" target="_blank">Proteges</a>. Todos los derechos reservados.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Departamento de Sistemas
                <i class="fa fa-code text-danger"></i>
            </span>
        </div>
    </footer>
    <!-- partial -->
</div>  
</div> 

<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet"/>
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>


<script src="<?php echo base_url(); ?>/assets/vue/appvue/cliente/polizas.js"></script> 
<script src="<?php echo base_url(); ?>/assets/vue/appvue/cliente/polizasanterior.js"></script> 
