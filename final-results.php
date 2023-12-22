<?php
// Include Dompdf library
require 'autoload.inc.php'; // Adjust the path accordingly

// Use the namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// Create an instance of the Dompdf class
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', TRUE);

$dompdf = new Dompdf($options);

// Load PHP file content
ob_start(); // Start output buffering
include 'show-results.php'; // Replace 'your_php_file.php' with the path to your PHP file
$html = ob_get_clean(); // Get the buffered content and store it in $html

// Load HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size
$dompdf->setPaper('A4', 'portrait');

// Render PDF (first pass to get total pages)
$dompdf->render();

$pdfContent = $dompdf->output();

// Output the PDF as a file (force download)
$dompdf->stream('output.pdf', array('Attachment' => 0));

// Output a success message (optional)
echo 'PDF generated successfully.';
?>
