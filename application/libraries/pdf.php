
<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf 
{

protected $ci;

    public function __construct(){
        
        $this->ci = get_instance();
    }

    public function generarPdf($view, $data = array(), $archivo = 'documento', $tamaño = 'A4',$orientacion = 'portrait')
    {
       
        $miPdf =  new Dompdf();
    	$html = $this->ci->load->view($view,$data, TRUE);
    	$miPdf->loadHtml($html);
    	$miPdf->setPaper($tamaño,$orientacion);

    	$miPdf->render();
    	$miPdf->stream($archivo.".pdf", array("Attachment" => 0));


    }

    public function generarCard($view, $data = array(), $archivo = 'Tarjeta',$orientacion = 'landscape')
    {
        $domPdf =  new Dompdf();
        $html = $this->ci->load->view($view,$data, TRUE);
        $domPdf->loadHtml($html);
        $sizeCard = array(0,0,510,870);
        $domPdf->setPaper($sizeCard,$orientacion);

        $domPdf->render();
        $domPdf->stream($archivo.".pdf", array("Attachment" => 0));
    }
}
?>