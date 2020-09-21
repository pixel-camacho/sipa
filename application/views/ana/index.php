<!-- partial -->
<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
</script>
<style>
    ul#stepForm, ul#stepForm li {
        margin: 0;
        padding: 0;
    }
    ul#stepForm li {
        list-style: none outside none;
    } 
    label{margin-top: 10px;}
    .help-inline-error{color:red;}
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div id="app">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3><strong>Emitir pólizas RC  ANA</strong></h3> 
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <form name="basicform" id="basicform" method="post" action="<?= base_url('EmitirANA/emitir') ?>" enctype="multipart/form-data">

                                        <div id="sf1" class="frm">
                                            <fieldset>
                                                <legend ><div  align="right" style="font-size: 16px; font-weight: bold;text-decoration: underline black;">Paso  1 de 3</div></legend> 
                                                    <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select  class="form-control select" id="listayear" name="year" required="required">
                                                                <option value="" >* Año</option>
                                                                <?php
                                                                for ($i = 2019; $i >= 1998; $i--) {
                                                                    # code...
                                                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                                                }
                                                                ?>
                                                            </select>  
                                                            <span id="loading1"  style="color:#20b034">Cargando...</span>
                                                            <span style="color:red;"><?php echo form_error('year'); ?></span>
                                                        </div>
                                                    </div> 
                                                     <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select  class="form-control select"  name="tipopoliza" required="required">
                                                                <option value="" >* Paquete</option>
                                                                <option value="1">Anual</option>
                                                                <option value="0">Semestral</option>
                                                            </select>  
                                                        </div>
                                                    </div> 
                                                      <div class="col-sm-4">
                                                        <div class="form-group"> 
                                                            <input class="form-control" id="date" name="finicio" onkeypress="return false;"  placeholder="Inicio vigencia" type="text"/>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12" >
                                                        <div class="form-group">
                                                            <select  class="form-control select" id="listamarca" name="marca" required="required">
                                                                <option selected="" default selected>* Seleccionar Marca</option>
                                                            </select>
                                                            <span id="loading2"  style="color:#20b034">Cargando...</span>
                                                            <span style="color:red;"><?php echo form_error('marca'); ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12" >
                                                        <div class="form-group">
                                                            <select  class="form-control select" name="modelo" id="listamodelo" required="required">
                                                                <option selected="" default selected>* Seleccionar Modelo</option>
                                                            </select>
                                                            <span id="loading3"  style="color:#20b034">Cargando...</span>
                                                            <span style="color:red;"><?php echo form_error('modelo'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12" >
                                                        <div class="form-group">
                                                            <select  class="form-control select" id="listadescripcion" required="required" name="descripcion">
                                                                <option selected="" default selected>* Seleccionar Descripción</option>
                                                            </select>
                                                            <span style="color:red;"><?php echo form_error('descripcion'); ?></span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <select id="cp" name="cp" class="form-control">
                                                                <option value=""></option>
                                                                <?php
                                                                foreach ($datacolonias as $value) {
                                                                    echo "<option value='.$value->idcolonia.'>$value->cp $value->nombrecolonia</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <span style="color:red;"><?php echo form_error('cp'); ?></span> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-lg-10 col-lg-offset-2">
                                                        <button class="btn btn-success open1" type="button">Siguiente <span class="fa fa-arrow-right"></span></button> 
                                                    </div>
                                                </div>

                                            </fieldset>
                                        </div>

                                        <div id="sf2" class="frm" style="display: none;">
                                            <fieldset>
                                                <legend><div  align="right" style="font-size: 16px; font-weight: bold;text-decoration: underline black;">Paso  2 de 3</div></legend>  
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5><i class="fa fa-car" aria-hidden="true"></i> Datos del vehículo</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="* Número de serie" name="serie" value="<?php echo set_value('serie'); ?>" autocomplete="off" tabindex="1" >
                                                            <span style="color: red" ><?php echo form_error('serie'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" autocomplete="off" placeholder="Placas" name="placas" value="<?php echo set_value('placas'); ?>"
                                                                   tabindex="2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <select class="form-control select" name="color"  tabindex="3">
                                                                <option value="">* COLOR DEL VEHICULO</option>
                                                                <?php foreach ($datacolores as $value) { ?>
                                                                    <option value="<?php echo $value["ID"] ?>"><?php echo $value["content"] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span style="color: red" ><?php echo form_error('color'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                         <div class="form-group">
                                                        <select class="form-control select" name="recargo"  tabindex="4">
                                                            <option value="">RECARGO</option>
                                                            <option value="0">$0</option>
                                                            <option value="35">$35</option>
                                                            <option value="100">$100</option>
                                                            <option value="200">$200</option>
                                                        </select>
                                                         </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                         <div class="form-group">
                                                        <label>Fronterizo? </label>
                                                        <label class="radio-inline"><input type="radio" name="fronterizo" value="0" checked onclick="show1();" > <strong>NO</strong></label>
                                                        <label class="radio-inline"><input type="radio" name="fronterizo" value="1" onclick="show2();" > <strong>SI</strong></label> 
                                                    </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                         <div class="form-group">
                                                         <label>Tipo véhiculo? </label>
                                                         <label class="radio-inline"><input type="radio" name="tipovehiculo" value="0" checked  > <strong>Auto</strong></label>
                                                        <label class="radio-inline"><input type="radio" name="tipovehiculo" value="1" > <strong>Pick-up</strong></label> 
                                                     </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row"  >
                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <input type="text" name="descripcionfronterizo"  id="descripcion" tabindex="5"  style="display: none;" class="form-control" placeholder="* Descripción del vehiculo.">
                                                         </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                         <div class="form-group">
                                                            <input type="text" name="numeromotor"   id="motor" tabindex="6" style="display: none;" class="form-control" placeholder="* Número de motor.">
                                                         </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                         <div class="form-group">
                                                             <input type="text" name="modelovehiculo"   id="modelovehiculo" tabindex="6" style="display: none;" class="form-control" placeholder="* Modelo.">
                                                         </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5><i class="fa fa-user" aria-hidden="true"></i> Datos del Asegurado</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="* Nombre" required="required" name="nombre" value="<?php echo set_value('nombre'); ?>" autocomplete="off" tabindex="7">
                                                            <span style="color: red" ><?php echo form_error('nombre'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="* Apellido Paterno" required="required" name="apellidop" value="<?php echo set_value('apellidop'); ?>" autocomplete="off" tabindex="8">
                                                            <span style="color: red" ><?php echo form_error('apellidop'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Apellido Materno"   name="apellidom" value="<?php echo set_value('apellidom'); ?>" autocomplete="off" tabindex="9">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"> 
                                                        <div class="form-group">
                                                            <input type="date" class="form-control"  placeholder="* Fecha de Nacimiento" required="required" name="fechanacimiento" autocomplete="off"  value="<?php echo set_value('fechanacimiento'); ?>" autocomplete="off" tabindex="10">
                                                            <span style="color: red" ><?php echo form_error('fechanacimiento'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="* RFC" required="required" name="rfc" value="<?php echo set_value('rfc'); ?>" autocomplete="off" tabindex="11">
                                                            <span style="color: red" ><?php echo form_error('rfc'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select  class="form-control select" name="genero" required="" tabindex="12">
                                                                <option value="">* GENERO</option>
                                                                <option>Hombre</option>
                                                                <option>Mujer</option>
                                                            </select>
                                                            <span style="color: red" ><?php echo form_error('genero'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select  class="form-control select" name="ocupacion" required="" tabindex="13" >
                                                                <option value="">* OCUPACI&Oacute;N</option>
                                                                <?php foreach ($dataocupaciones as $value) { ?>
                                                                    <option value="<?php echo $value["ID"] ?>"><?php echo $value["content"] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span style="color: red" ><?php echo form_error('ocupacion'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder=" Correo"  value="" name="correo" required tabindex="14" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="* Telefono" value="" name="telefono" required tabindex="15">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5><i class="fa fa-map-marker" aria-hidden="true"></i> Dirección del Asegurado</h5>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" name="calle" placeholder="* Calle" class="form-control" required="" value="<?php echo set_value('calle'); ?>" autocomplete="off" tabindex="16">
                                                            <span style="color: red" ><?php echo form_error('calle'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" name="numeroexterior" placeholder="* Número" class="form-control" required="" value="<?php echo set_value('numeroexterior'); ?>" autocomplete="off" tabindex="17">
                                                            <span style="color: red" ><?php echo form_error('numeroexterior'); ?></span>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" tabindex="18" class="form-control" name="codigopostal" id="idcolonia" placeholder="Código Postal"  required  />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <select class="form-control select" name="colonia" id="colonia" tabindex="19" required>
                                                                <option value="">* COLONIA</option>

                                                            </select>
                                                            <div class="resultado" style="color:#20b034" >Cargando...</div>
                                                            <span style="color: red" ><?php echo form_error('colonia'); ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row"  >
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-control " name="municipio" tabindex="20" readonly="readonly"  id="municipio" required >
                                                            </select>
                                                            <div class="resultado" style="color:#20b034" >Cargando...</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-control" name="estado" tabindex="21" readonly="readonly" id="estado" required >
                                                            </select>
                                                            <div class="resultado" style="color:#20b034" >Cargando...</div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <div class="col-lg-10 col-lg-offset-2">
                                                        <button class="btn btn-warning back2" type="button"><span class="fa fa-arrow-left"></span> Atras</button> 
                                                        <button class="btn btn-success open2" type="button">Siguiente <span class="fa fa-arrow-right"></span></button> 
                                                    </div>
                                                </div>

                                            </fieldset>
                                        </div>

                                        <div id="sf3" class="frm" style="display: none;">
                                            <fieldset>
                                                <legend><div  align="right" style="font-size: 16px; font-weight: bold;text-decoration: underline black;">Paso  3 de 3</div></legend>
                                                <div class="form-group">
                                                   <a href="" id="link" target="_blank">Descargar Póliza</a>
                                                </div>
                                                <div class="form-group">
                                                    <p>
                                                        <label><strong>Confirme la emisión de la póliza?</strong></label>
                                                    </p>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-10">
                                                        <button class="btn btn-warning back3" type="button"><span class="fa fa-arrow-left"></span> Atras</button> 
                                                        <button class="btn btn-success" type="button" id="btnaceptar" name="submit"><i class="fa fa-check" aria-hidden="true"></i> Aceptar </button> 
                                                        <img src="<?php echo base_url('assets/images/30.gif'); ?>" alt="" id="loader" style="display: none">
                                                    </div>
                                                    <div class="col-lg-2" align="right">
                                                        <a href="<?= base_url('/emitirana/') ?>" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</a>
                                                    </div>
                                                </div>

                                            </fieldset>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> 


                    </div>
                </div> 
            </div>
        </div>
    </div>  
    <script src="<?php echo base_url(); ?>/assets/cotizador/cotizar.js"></script> 
    <script src="<?php echo base_url(); ?>/assets/cotizador/loading.js"></script> 
    <!-- <script src="<?php echo base_url(); ?>/assets/js/validar/validarcotizacion.js"></script>  -->
    <script type="text/javascript">

    jQuery().ready(function () {

        // validate form on keyup and submit
        var v = jQuery("#basicform").validate({
            rules: {

                marca: "required",
                modelo: "required",
                descripcion: "required",
                year: "required",
                serie: "required",
                color: "required",
                nombre: "required",
                apellidop: "required",
                fechanacimiento: "required",
                genero: "required",
                ocupacion: "required",
                calle: "required",
                numeroexterior: "required",
                colonia: "required",
                municipio: "required",
                estado: "required",
                descripcionfronterizo: "required",
                recargo:"required",
                numeromotor:"required",
                tipopoliza:"required",
                 modelovehiculo: {
                    required: true,
                    digits: true,
                    maxlength: 4,
                    minlength: 4
                },
                finicio:{
                    required:true
                },
                codigopostal: {
                    required: true,
                    digits: true,
                    maxlength: 5,
                    minlength: 5
                },
                rfc: {
                    required: true,
                    maxlength: 13,
                    minlength: 13
                },
                correo: {
                    required: true,
                    email: true
                },
                telefono: {
                    required: true,
                    digits: true,
                    maxlength: 10,
                    minlength: 10
                }

            },
            messages: {
                marca: "Campo requerido.",
                modelo: "Campo requerido.",
                descripcion: "Campo requerido.",
                year: "Campo requerido.",
                serie: "Campo requerido.",
                color: "Campo requerido.",
                nombre: "Campo requerido.",
                apellidop: "Campo requerido.",
                fechanacimiento: "Campo requerido.",
                genero: "Campo requerido.",
                ocupacion: "Campo requerido.",
                calle: "Campo requerido.",
                numeroexterior: "Campo requerido.",
                colonia: "Campo requerido.",
                municipio: "Campo requerido.",
                estado: "Campo requerido.",
                descripcionfronterizo:"Campo requerido.",
                recargo:"Campo requerido.",
                numeromotor:"Campo requerido.",
                tipopoliza:"Campo requerido.",
                modelovehiculo: {
                    required: "Campo requerido.",
                    digits: "Solo números enteros.",
                    maxlength: "4 caracteres.",
                    minlength: "4 caracteres."
                },
                finicio:{
                    required: "Campo requerido.", 
                },
                codigopostal: {
                    required: "Campo requerido.",
                    digits: "Solo números enteros.",
                    maxlength: "5 caracteres.",
                    minlength: "5 caracteres."
                },
                rfc: {
                    required: "Campo requerido.",
                    maxlength: "13 caracteres.",
                    minlength: "13 caracteres."
                },
                correo: {
                    required: "Campo requerido.",
                    email: "Correo invalido."
                },
                telefono: {
                    required: "Campo requerido.",
                    digits: "Solo números enteros.",
                    maxlength: "10 caracteres.",
                    minlength: "10 caracteres."
                }
            },
            errorElement: "span",
            errorClass: "help-inline-error",
        });

        $(".open1").click(function () {
            if (v.form()) {
                $(".frm").hide("fast");
                $("#sf2").show("slow");
            }
        });

        $(".open2").click(function () {
            if (v.form()) {
                $(".frm").hide("fast");
                $("#sf3").show("slow");
            }
        });

        $(".open3").click(function () {
            if (v.form()) {
                $("#loader").show();
                //setTimeout(function () {
                //    $("#basicform").html('<h2>Thanks for your time.</h2>');
                //}, 1000);
                //return false;
            }
        });

        $(".back2").click(function () {
            $(".frm").hide("fast");
            $("#sf1").show("slow");
        });

        $(".back3").click(function () {
            $(".frm").hide("fast");
            $("#sf2").show("slow");
        });

    });

    $(document).ready(function () {
        $(".resultado").hide(true);
         $('#link').hide(true);
        $("#idcolonia").keyup(function (e) {
            var dat = $("#idcolonia").val();
            if (dat.length === 5) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('EmitirANA/coloniaxcp') ?>",
                    data: "b=" + dat,
                    dataType: "html",
                    beforeSend: function () {
                        //imagen de carga
                        $(".resultado").show();
                    },
                    error: function () {
                        alert("error petición ajax");
                    },

                    complete: function () {
                        // Hide image container
                        $(".resultado").hide(true);
                    },
                    success: function (response) { 
                        $("#resultado").hide(true);
                        $("#colonia").empty();
                        $("#colonia").append(response);
                    }

                })
            }
        });
        $("#idcolonia").keyup(function (e) {
            var dat = $("#idcolonia").val();
            if (dat.length === 5) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('EmitirANA/municipioxcp') ?>",
                    data: "b=" + dat,
                    dataType: "html",
                    beforeSend: function () {
                        //imagen de carga
                        $(".resultado").show();
                    },
                    error: function () {
                        alert("error petición ajax");
                    },

                    complete: function () {
                        // Hide image container
                        $(".resultado").hide(true);
                    },
                    success: function (data) {
                        //console.log(data);
                        $("#resultado").hide(true);
                        $("#municipio").empty();
                        $("#municipio").append(data);
                    }
                })
            }
        });
        
        $("#idcolonia").keyup(function (e) {
            var dat = $("#idcolonia").val();
            if (dat.length === 5) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('EmitirANA/estadoxcp') ?>",
                    data: "b=" + dat,
                    dataType: "html",
                    beforeSend: function () {
                        //imagen de carga
                        $(".resultado").show();
                    },
                    error: function () {
                        alert("error petición ajax");
                    },

                    complete: function () {
                        // Hide image container
                        $(".resultado").hide(true);
                    },
                    success: function (data) {
                        //console.log(data);
                        $("#resultado").hide(true);
                        $("#estado").empty();
                        $("#estado").append(data);
                    }
                })
            }

        });

//loader

        $('#btnaceptar').on('click', function () { 
        $("#btnaceptar").prop("disabled", true);
                  var  form = $("#basicform").serialize();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('EmitirANA/emitir'); ?>",
                        data: form, 
                         beforeSend: function () {
                        //imagen de carga
                        //console.log('xml');
                        $("#loader").show();
                    },
                    error: function () {
                        alert("error petición ajax");
                    },

                    complete: function () {
                        // Hide image container
                        $("#loader").hide(true);
                    },
                        success: function (data) {
                            $("#btnaceptar").prop("disabled", false);
                           
                           console.log(data);
                          var json = jQuery.parseJSON(data);
                            //alert( json.msgerror ); 
                            if(json.error===1){
                                  Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: data
                                  });
                                  if(json.fronterizo==="1"){
                                        document.getElementById('descripcion').style.display = 'block';
                                        document.getElementById('motor').style.display = 'block';
                                          document.getElementById('modelovehiculo').style.display = 'block';
                                  }else{
                                        document.getElementById('descripcion').style.display ='none';
                                        document.getElementById('motor').style.display ='none';
                                        document.getElementById('modelovehiculo').style.display ='none';
                                  }
                            }else{
                                $('#link').show();
                                $('#link').attr('href',json.descarga);
                                console.log(data);
                                Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Exito!!!',
                                text: data,
                                showConfirmButton: false,
                                timer: 1800
                              })
                            }
                            //location.reload(); 
                        } 
                    });
                    //event.preventDefault();
                    return false;  //stop the actual form post !important! 
        }); 

    }); 
    </script>
    <script type="text/javascript">
     function show1(){
      document.getElementById('descripcion').style.display ='none';
      document.getElementById('motor').style.display ='none';
    document.getElementById('modelovehiculo').style.display ='none';
    }
    function show2(){
      document.getElementById('descripcion').style.display = 'block';
      document.getElementById('motor').style.display = 'block';
      document.getElementById('modelovehiculo').style.display = 'block';
    }
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
         
            $('#date').datepicker({
                  dateFormat: "dd/mm/yy",
                  minDate: 0,
                  maxDate: "+15D",
                   language: 'es'
                  //maxDate: "+1M +2D"

            });
        
    </script>