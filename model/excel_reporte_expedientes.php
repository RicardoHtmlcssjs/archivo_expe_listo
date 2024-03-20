<?php
    require 'PHPExcel-1.8/Classes/PHPExcel.php';
    include("lib/conexion.php");

    $fecha = new DateTime();
    $fec_act =  $fecha->format('Y-m-d');
    $conexion = new Conexion();
    $query = $conexion->consulta("s","SELECT solicitante.snombres, solicitante.piso, tblunidad.unombre, controle.cedula, controle.id_controle, personal.nombres, cargos.desc_cargo, controle.fentrega, controle.eanalista, controle.observacion FROM controle INNER JOIN solicitante ON controle.id_solicita = solicitante.idsolicita INNER JOIN tblunidad ON solicitante.idunidad = tblunidad.idunidad INNER JOIN personal ON controle.cedula = personal.cedula LEFT JOIN cargos ON personal.cargo =  cargos.id_cargo WHERE ranalista ISNULL AND fentrega = '".$fec_act."'ORDER BY id_controle ASC");

    $fecha = new DateTime();
    $f_tit =  $fecha->format('d-m-Y');
    
    // Crea un objeto PHPExcel
$objPHPExcel = new PHPExcel();
// este metodo se llamo para unir celdas
$worksheet = $objPHPExcel->getActiveSheet();
$worksheet->mergeCells('A1:I1')->setCellValue('A1', $f_tit.' - Reporte de expedientes solicitados');

$objPHPExcel->getProperties()->setCreator('ricardo')->setTitle('titulo')->setDescription('descripcion')->setKeywords('llaves')->setCategory('ejemplos');
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Expedientes solicitados');

// TITULOS DE LAS COLUMNAS
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'SOLICITANTE');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PISO');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'UNIDAD SOLICITANTE');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'CEDULA EXPEDIENTE');
$objPHPExcel->getActiveSheet()->getColumnDimension('d')->setWidth(25);
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'NOMBRE EXPEDIENTE');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'CARGO');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'FECHA DE ENTREGA');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'ENTREGADO POR');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'OBSERVACION');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);

$fila = 3;
foreach ($query as $key) {
    $query2 = $conexion->consulta("s","SELECT snombres from solicitante where idsolicita = '".$key['eanalista']."'");
    foreach ($query2 as $key2) {
        $ana_entre = $key2["snombres"];
    }
    $objPHPExcel->getActiveSheet()->setCellValue("A" . $fila, $key["snombres"]);
    $objPHPExcel->getActiveSheet()->setCellValue("B" . $fila, $key["piso"]);
    $objPHPExcel->getActiveSheet()->setCellValue("C" . $fila, $key["unombre"]);
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $fila, $key["cedula"]);
    $objPHPExcel->getActiveSheet()->setCellValue("E" . $fila, $key["nombres"]);
    $objPHPExcel->getActiveSheet()->setCellValue("F" . $fila, $key["desc_cargo"]);
    $objPHPExcel->getActiveSheet()->setCellValue("G" . $fila, $key["fentrega"]);
    $objPHPExcel->getActiveSheet()->setCellValue("H" . $fila, $ana_entre);
    $objPHPExcel->getActiveSheet()->setCellValue("I" . $fila, $key["observacion"]);
    $fila = $fila + 1;
}

    // color de fondo de celda verde
    $styleArray = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '006400'
            )
        )
    );
    //ESTABLECER COLOR DE LETRA DE COLOR BLANCO
    $style_color_letra = array(
        'font' => array(
            'color' => array(
                'rgb' => 'FFFFFF'
            )
        )
    );
    // unir celdas de a1 hasta m1
    // $objPHPExcel->mergeCells('A1:B1');
    // celdas a utilizar
    $celdas = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
    // establecer color de fondo verde, tamaño de fuente y centrar texto de celda
    for ($i = 0; $i < count($celdas); $i++) {
        // echo "El elemento " . $i . " es " . $mi_array[$i] . "<br>";
        $objPHPExcel->getActiveSheet()->getStyle($celdas[$i].'2')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle($celdas[$i].'2')->applyFromArray($style_color_letra);
        // cambiar tamaño de fuente
        $objPHPExcel->getActiveSheet()->getStyle($celdas[$i].'2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle($celdas[$i].'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }

     // cambiar tamaño de fuente
     $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

    // centrar texto de columnas
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $to = $f_tit."_expedientes_solicitados.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$to.'"');
header('Cache-Control: max-age=0');

$objPHPExcel = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objPHPExcel->save('php://output');
?>