<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
<script src="<?php echo base_url(); ?>/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="<?php echo base_url(); ?>/assets/vendors/js/vendor.bundle.addons.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/off-canvas.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/misc.js"></script>  
<script src="<?php echo base_url(); ?>/assets/js/settings.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/todolist.js"></script>
<script src="<?php echo base_url('assets/sweetalert2/dist/sweetalert2.js'); ?>"></script>


<script src="<?php echo base_url(); ?>/assets/vue/pagination/pagination.js"></script>

<script src="<?php echo base_url(); ?>/assets/js/select/select2.full.js"></script>


<!-- Datatables-->

<script  type="text/javascript">
    function mayuscula(e) {
        e.value = e.value.toUpperCase();
    }
</script>
<script>

    $(document).ready(function () {
        $(".select2_single").select2({
            placeholder: "Seleccionar Opción",
            allowClear: true,
            theme: "classic"
        });
        $('.select2_single:not(.normal)').each(function () {
            $(this).select2({
                dropdownParent: $(this).parent()
            });
        });


    });

</script>


<script type="text/javascript">
    // For demo to fit into DataTables site builder...
    $('#example')
            .removeClass('display')
            .addClass('table table-striped table-bordered');
</script>
<script>
    $("#cp").select2({
        placeholder: "Seleccione el Codigo Postal",
        allowClear: true,
        searchInputPlaceholder: "Buscar..."
    });
</script>
</body>

</html>