<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

class pdf
{
    function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
        $dompdf = new Dompdf\DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $options->set('enable_html5_parser', true);
        $dompdf->setOptions($options);
        $dompdf->render();
        if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));
        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }
}
?>
