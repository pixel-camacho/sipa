<!-- partial -->
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <?php if(isset($_SESSION['err'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <h4 class="alert-heading">Acceso Denegado!</h4>
               <p>Usted no tiene permiso para realizar esta acción.</p>
               <hr>
               <p class="mb-0">Si requiere permiso, comuniquese con el Administrador.</p>

                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>

            </div>
            <?php endif ?>
         </div> 
      </div>


               <div class="row">
            <div class="col-lg-9 grid-margin stretch-card">
              <!--weather card-->
              <div class="card ">
                <div class="card-body">
                   <h3><strong>Agenda</strong></h3>
                     <p class="card-description">
                        Administracion de agenda, permite agregar notas, recordatorio, etc. en el calendario.
                     <ul>
						<li> Agregar: Dar click en el dia de calendario.
						</li>
						<li>Modificar: Dar click en el eventento del calendario.</li>
					 </ul>
					 </p>
                   <div id='calendar'></div>
                </div>
                 
              </div>
              <!--weather card ends-->
            </div>
            <div class="col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title text-primary mb-5">Meta de ventas</h2>
                  <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                      <p class="mb-2">Ventas</p>
                      <p class="display-3 mb-4 font-weight-light">+53.0%</p>
                    </div>
                    <div class="side-right">
                      <small class="text-muted">2018</small>
                    </div>
                  </div>
                  
                  <div class="wrapper">
                    <div class="d-flex justify-content-between">
                      <p class="mb-2">Ventas</p>
                      <p class="mb-2 text-primary">53%</p>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 53%" aria-valuenow="53"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div> 
                </div>
              </div>
            </div>
          </div>


   </div>
   <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header"> 
               <h4 class="modal-title" id="myModalLabel">Agregar al calendario</h4>
            </div>
            <form method="POST" action="<?= base_url('login/add_event') ?>">
               <div class="modal-body">
                  <div class="container-fluid">
                     <div class="form-group">
                        <label >Nombre de nota</label>
                        <input type="text" class="form-control" placeholder="Puede ser una nota o evento para agregar." name="name" required="required">
                     </div>
                     <div class="form-group">
                        <label >Descripción</label>
                        <input type="text" class="form-control" placeholder="Breve descripción." name="description" required="required">
                     </div>
                     <div class="form-group">
                        <label >Fecha inicio</label>
                        <input type="date" class="form-control"  name="start_date" required="required">
                     </div>
                     <div class="form-group">
                        <label >Fecha fin</label>
                        <input type="date" class="form-control" name="end_date"  required="required">
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <input type="submit" class="btn btn-primary" value="Agregar">
            </form>
            </div>
         </div>
      </div>


   </div>

      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header"> 
                  <h4 class="modal-title" id="myModalLabel">Modificar</h4>
               </div>
                 <form method="POST" action="<?= base_url('login/edit_event') ?>">
               <div class="modal-body">
                    <div class="container-fluid">
                     <div class="form-group">
                        <label >Nombre de nota</label>
                        <input type="text" class="form-control" placeholder="Puede ser una nota o evento para agregar." name="name" id="name">
                     </div>
                     <div class="form-group">
                        <label >Descripción</label>
                        <input type="text" class="form-control" placeholder="Breve descripción." name="description" id="description">
                     </div>
                     <div class="form-group">
                        <label >Fecha inicio</label>
                        <input type="date" class="form-control"  name="start_date" id="start_date">
                     </div>
                     <div class="form-group">
                        <label >Fecha fin</label>
                        <input type="date" class="form-control" name="end_date"  id="end_date">
                     </div>
                      <input type="hidden" name="eventid" id="event_id" />
                  </div>
                  
                 
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <input type="submit" class="btn btn-primary" value="Modificar">
                    </form>
               </div>
            </div>
         </div>
      </div>
      <pre><?php var_dump($_SESSION['__ci_last_regenerate']);?></pre>
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
<script>
   $(function() { 
     var date_last_clicked = null;
     $('#calendar').fullCalendar({
       locale: 'es',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      }, 
       
           eventSources: [
          {
              events: function(start, end, timezone, callback) {
                  $.ajax({
                  url: '<?php echo base_url() ?>login/get_events',
                  dataType: 'json',
                  data: {
                  // our hypothetical feed requires UNIX timestamps
                  start: start.unix(),
                  end: end.unix()
                  },
                  success: function(msg) {
                      var events = msg.events;
                      callback(events);
                  }
                  });
              }
          },
      ],
     dayClick: function(date, jsEvent, view) {
         date_last_clicked = $(this);
         //$(this).css('background-color', '#bed7f3');
         $('#addModal').modal();
     },
     eventClick: function(event, jsEvent, view) { 
           $('#name').val(event.title);
           $('#description').val(event.description);
          $('#start_date').val(moment(event.start).format('YYYY-MM-DD'));
           if(event.end) {
             $('#end_date').val(moment(event.end).format('YYYY-MM-DD'));
           } else {
             $('#end_date').val(moment(event.start).format('YYYY-MM-DD'));
           }
          $('#event_id').val(event.ID); 
           $('#editModal').modal(); 
   }
   
   
     });
   
   });
   
</script>
 