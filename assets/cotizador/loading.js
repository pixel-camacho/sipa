$(document).ready(function () {
     $('#siguiente').show();
     $('#cargando').hide();
     $('#frmcotizar').submit(function () {
     $('#siguiente').hide();
     $('#cargando').show();
     // return true;
     });
    $('#siguiente2').show(); 
    $('#loadingeffects2').hide();
    $('#siguiente2').click(function () {
        $('#siguiente2').hide();
        $('#loadingeffects2').show();
        // return true;
    });
});