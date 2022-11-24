<?php

require "/home/gestio10/public_html/vendor/autoload.php";
require_once "/home/gestio10/public_html/backend/config.php";

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
mysqli_query($link, "SET @rownum=0;");
$query= "select @rownum := @rownum + 1 AS fila,
    a.id,
    fecha_prorroga,
    numero_endoso,
    comentario_endoso, 
    tipo_endoso, 
    compania,
    fecha_ingreso_endoso, 
    ramo, 
    vigencia_inicial, 
    vigencia_final, 
    numero_poliza, 
    numero_propuesta_endoso, 
    CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(iva, 2, 'de_DE')) as iva, 
    CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_neta_exenta, 2, 'de_DE')) as prima_neta_exenta, 
    CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_neta_afecta, 2, 'de_DE')) as prima_neta_afecta,
    CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_neta, 2, 'de_DE')) as prima_neta,
    CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_total, 2, 'de_DE')) as prima_total, 
    dice, 
    debe_decir, 
    descripcion_endoso,
    CONCAT_WS('-',rut_proponente,dv_proponente) AS rut_proponente,
    nombre_proponente
    FROM endosos as a";
$resultado=mysqli_query($link, $query);
$excel= new Spreadsheet();
$hojaActiva=$excel->getActiveSheet();
$hojaActiva->setCellValue('A2', 'Fila');
$hojaActiva->setCellValue('B2', 'Numero Endoso');
$hojaActiva->setCellValue('C2', 'Numero Propuesta Endoso');
$hojaActiva->setCellValue('D2', 'Tipo Endoso');
$hojaActiva->setCellValue('E2', 'Rut Proponente');
$hojaActiva->setCellValue('F2', 'Proponente');
$hojaActiva->setCellValue('G2', 'Numero Poliza');
$hojaActiva->setCellValue('H2', 'Fecha Ingreso');
$hojaActiva->setCellValue('I2', 'Inicio Vigencia');
$hojaActiva->setCellValue('J2', 'Fin Vigencia');
$hojaActiva->setCellValue('K2', 'Fecha Prorroga');
$hojaActiva->setCellValue('L2', 'Total Prima Afecta');
$hojaActiva->setCellValue('M2', 'Total Prima Exenta');
$hojaActiva->setCellValue('N2', 'Total Prima Neta Anual');
$hojaActiva->setCellValue('O2', 'Total Prima Bruta Anual');
$hojaActiva->setCellValue('P2', 'Descripción Endoso');
$hojaActiva->setCellValue('Q2', 'Dice');
$hojaActiva->setCellValue('R2', 'Debe Decir');
$hojaActiva->setCellValue('S2', 'Comentario');
$hojaActiva->setCellValue('T2', 'Compañia');

$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
        'wrapText' => true,
    ],
];
$hojaActiva->freezePane('A3');

$hojaActiva->getStyle('A2:AZ2')->applyFromArray($styleArray);
$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva->getColumnDimension('C')->setWidth(10);
$hojaActiva->getColumnDimension('D')->setWidth(30);
$hojaActiva->getColumnDimension('E')->setWidth(10);
$hojaActiva->getColumnDimension('F')->setWidth(20);
$hojaActiva->getColumnDimension('G')->setWidth(10);
$hojaActiva->getColumnDimension('H')->setWidth(10);
$hojaActiva->getColumnDimension('I')->setWidth(10);
$hojaActiva->getColumnDimension('J')->setWidth(10);
$hojaActiva->getColumnDimension('K')->setWidth(10);
$hojaActiva->getColumnDimension('L')->setWidth(10);
$hojaActiva->getColumnDimension('M')->setWidth(10);
$hojaActiva->getColumnDimension('N')->setWidth(10);
$hojaActiva->getColumnDimension('O')->setWidth(10);
$hojaActiva->getColumnDimension('P')->setWidth(40);
$hojaActiva->getColumnDimension('Q')->setWidth(40);
$hojaActiva->getColumnDimension('R')->setWidth(40);
$hojaActiva->getColumnDimension('S')->setWidth(30);
$hojaActiva->getColumnDimension('T')->setWidth(15);
$fila=3;

while ($rows = mysqli_fetch_object($resultado))
{
    $hojaActiva->setCellValue('A'.$fila, $rows->fila);
    $hojaActiva->setCellValue('B'.$fila, $rows->numero_endoso);
    $hojaActiva->setCellValue('C'.$fila, $rows->numero_propuesta_endoso);
    $hojaActiva->setCellValue('D'.$fila, $rows->tipo_endoso);
    $hojaActiva->setCellValue('E'.$fila, $rows->rut_proponente);
    $hojaActiva->setCellValue('F'.$fila, $rows->nombre_proponente);
    $hojaActiva->setCellValue('G'.$fila, $rows->numero_poliza);
    $hojaActiva->setCellValue('H'.$fila, $rows->fecha_ingreso_endoso);
    $hojaActiva->setCellValue('I'.$fila, $rows->vigencia_inicial);
    $hojaActiva->setCellValue('J'.$fila, $rows->vigencia_final);
    $hojaActiva->setCellValue('K'.$fila, $rows->fecha_prorroga);
    $hojaActiva->setCellValue('L'.$fila, $rows->prima_neta_afecta);
    $hojaActiva->setCellValue('M'.$fila, $rows->prima_neta_exenta);
    $hojaActiva->setCellValue('N'.$fila, $rows->prima_neta);
    $hojaActiva->setCellValue('O'.$fila, $rows->prima_total);
    $hojaActiva->setCellValue('P'.$fila, $rows->descripcion_endoso);
    $hojaActiva->setCellValue('Q'.$fila, $rows->dice);
    $hojaActiva->setCellValue('R'.$fila, $rows->debe_decir);
    $hojaActiva->setCellValue('S'.$fila, $rows->comentario_endoso);
    $hojaActiva->setCellValue('T'.$fila, $rows->compania);
    $fila++;
}
$fecha = new DateTime(date("Y-m-d H:i:sP"), new DateTimeZone('America/Santiago') );
date_timezone_set($fecha, timezone_open('America/Santiago'));
$hojaActiva->setAutoFilter('A2:T'.($fila-1));
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Listado_endosos '.date_format($fecha, 'd-m-Y H:i:s').'.xlsx"');
header('Cache-Control: max-age=0');
mysqli_close($link);
$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');
exit;
?>