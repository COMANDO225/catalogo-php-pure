<?php
    include('db.php');
    include('get_products.php');
    include('generar_pdf.php');
    include('close_db.php');
    $pdf->Output('productos.pdf', 'I');
?>