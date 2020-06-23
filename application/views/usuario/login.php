<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SIPA - Sistema Integral Proteges Abonos</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.base.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.addons.css');?>">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css');?>">
   <link rel="stylesheet" href="<?php echo base_url('assets/sweetalert2/dist/sweetalert2.css');?>"> 

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.7/dist/sweetalert2.all.min.js"></script> 

    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css --> 

  <!-- endinject -->

    
</head>

<body>
 <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper auth p-0 theme-two">
          <div class="row d-flex align-items-stretch">
            <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
              <div class="slide-content bg-1"> </div>
            </div>
            <div class="col-12 col-md-8 h-100 bg-white">
              <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
                <div class="nav-get-started">
				 
                  <?php if(isset($_SESSION['err'])): ?>
                    <script>
                         swal({
                            type: 'error',
                            title: 'Oops...',
                            text: '<?= $this->session->userdata('err'); ?>',
                            footer: ''
                          })

                               </script>

                  <?php endif ?>
                </div>
               <form action="<?= base_url('login/index') ?>" method="POST">
                  <h3 class="mr-auto">Hola! bienvenido al SIPA</h3>
                  <p class="mb-5 mr-auto">Ingrese sus datos.</p>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="mdi mdi-account-outline"></i>
                        </span>
                      </div>
                      <input type="text" name="usuario" class="form-control" placeholder="Usuario" required="required"> </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock-outline"></i>
                        </span>
                      </div>
                      <input type="password" name="password" class="form-control" placeholder="Contraseña" required="required"> </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn" type="submit" >Entrar</button>
                  </div>
                  <div class="wrapper mt-5 text-gray">
                    <p class="footer-text">Copyright © <?php echo date("Y"); ?> Proteges. Todos los derechos reservados.</p> 
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
 

  <script src="<?php echo base_url();?>/assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo base_url();?>/assets/vendors/js/vendor.bundle.addons.js"></script>
  <script src="<?php echo base_url();?>/assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url();?>/assets/js/off-canvas.js"></script>
  <script src="<?php echo base_url();?>/assets/js/misc.js"></script>  
  <script src="<?php echo base_url();?>/assets/js/settings.js"></script>
  <script src="<?php echo base_url();?>/assets/js/todolist.js"></script>
  
</body>

</html>