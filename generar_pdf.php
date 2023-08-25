<?php
    include('tcpdf/tcpdf.php');

    // Crear instancia de TCPDF masna!
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Catálogo de Productos');
    $pdf->SetAuthor('La Alta Rebaja');
    $pdf->SetTitle('Catálogo de Productos');
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->setPrintHeader(false);
    $PDF_HEADER_TITLE = "LA ALTA REBAJA";
    $PDF_HEADER_STRING = "";
    $PDF_HEADER_LOGO = 'logo.png';
    $pdf->setHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    $pdf->AddPage();

    $cards_por_fila  = 2;
    $cards_por_col = 2;
    $card_width = 80; 
    $card_height = 120; 
    $espacio = 10;

    $x_inicial = ($pdf->getPageWidth() - ($cards_por_fila  * ($card_width + $espacio) - $espacio)) / 2;
    $y_inicial = 10;

    foreach ($productos as $key => $producto) {
        $row = floor($key / $cards_por_fila ) % $cards_por_col;
        $col = $key % $cards_por_fila ;

        $x = $x_inicial + ($col * ($card_width + $espacio));
        $y = $y_inicial + ($row * ($card_height + $espacio));

        
        $resto_espacio = $pdf->getPageHeight() - $y;
        if ($resto_espacio < $card_height) {
            $pdf->AddPage();
            $y = $y_inicial;
        }

        $pdf->SetFillColor(255, 255, 255); 
        $pdf->Rect($x, $y, $card_width, $card_height, 'F');

        
        $pdf->Image(__DIR__ . '/images/superfaraon.jpg', $x + ($card_width - 60) / 2, $y + 10, 60, 60, 'JPG', false);

        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetXY($x, $y + 80); 
        $pdf->Cell($card_width, 10, $producto['titulo'], 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetX($x); 
        $pdf->MultiCell($card_width, 10, $producto['descripcion'], 0, 'C'); 

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetX($x); 
        $pdf->Cell($card_width, 10, 'Precio: S/ ' . $producto['precio'], 0, 1, 'C');

        if (($key + 1) % ($cards_por_fila  * $cards_por_col) == 0) {
            $pdf->AddPage();
            $y = $y_inicial; 
        }
    }
    $pdf->Output('productos.pdf', 'I');
?>
