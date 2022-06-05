<?php

require "/home/gestio10/public_html/vendor/autoload.php";
require_once "/home/gestio10/public_html/backend/config.php";

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_prePAP');
mysqli_query($link, "SET @rownum=0;");
$query= "select @rownum := @rownum + 1 AS fila, a.estado, a.numero_propuesta, b.numero_item, a.tipo_propuesta, a.fecha_propuesta, a.fecha_envio_propuesta, CONCAT_WS('-',a.rut_proponente, a.dv_proponente) as rut_proponente, a.compania, a.vigencia_inicial, a.vigencia_final, a.ramo, a.moneda_poliza, a.vendedor, a.forma_pago, a.moneda_valor_cuota, a.valor_cuota, a.fecha_primera_cuota, a.nro_cuotas, a.comentarios_int, a.comentarios_ext, CONCAT_WS('-',b.rut_asegurado, b.dv_asegurado) as rut_asegurado, b.materia_asegurada, b.patente_ubicacion, b.cobertura, b.deducible, CONCAT(FORMAT(b.tasa_afecta, 2, 'de_DE'),'%') as tasa_afecta, CONCAT(FORMAT(b.tasa_exenta, 2, 'de_DE'),'%') as tasa_exenta, 
CONCAT_WS(' ',a.moneda_poliza,FORMAT(b.prima_afecta, 2, 'de_DE')) as prima_afecta, 
CONCAT_WS(' ',a.moneda_poliza,FORMAT(b.prima_exenta, 2, 'de_DE')) as prima_exenta, 
CONCAT_WS(' ',a.moneda_poliza,FORMAT(b.prima_neta, 2, 'de_DE')) as prima_neta, 
CONCAT_WS(' ',a.moneda_poliza,FORMAT(b.prima_bruta_anual, 2, 'de_DE')) as prima_bruta_anual, 
b.monto_asegurado, b.venc_gtia from propuesta_polizas as a left join items as b on a.numero_propuesta=b.numero_propuesta
where b.id is not null
order by a.numero_propuesta, b.numero_item";
$resultado=mysqli_query($link, $query);
$excel= new Spreadsheet();
$hojaActiva=$excel->getActiveSheet();
$hojaActiva->setTitle("Listado Propuestas de póliza");
$hojaActiva->setCellValue('A2', 'Fila');
$hojaActiva->setCellValue('B2', 'Estado');
$hojaActiva->setCellValue('C2', 'Número propuesta');
$hojaActiva->setCellValue('D2', 'Número ítem');
$hojaActiva->setCellValue('E2', 'Tipo propuesta');
$hojaActiva->setCellValue('F2', 'Fecha propuesta');
$hojaActiva->setCellValue('G2', 'Fecha envío propuesta');
$hojaActiva->setCellValue('H2', 'Rut proponente');
$hojaActiva->setCellValue('I2', 'Companía');
$hojaActiva->setCellValue('J2', 'Ramo');
$hojaActiva->setCellValue('K2', 'Vigencia inicial');
$hojaActiva->setCellValue('L2', 'Vigencia final');
$hojaActiva->setCellValue('M2', 'Moneda póliza');
$hojaActiva->setCellValue('N2', 'Forma pago');
$hojaActiva->setCellValue('O2', 'Moneda valor cuota');
$hojaActiva->setCellValue('P2', 'Valor cuota');
$hojaActiva->setCellValue('Q2', 'Fecha primera cuota');
$hojaActiva->setCellValue('R2', 'Nro cuotas');
$hojaActiva->setCellValue('S2', 'Comentarios internos');
$hojaActiva->setCellValue('T2', 'Comentarios externos');
$hojaActiva->setCellValue('U2', 'Rut asegurado');
$hojaActiva->setCellValue('V2', 'Materia asegurada');
$hojaActiva->setCellValue('W2', 'Patente ubicacion');
$hojaActiva->setCellValue('X2', 'Cobertura');
$hojaActiva->setCellValue('Y2', 'Deducible');
$hojaActiva->setCellValue('Z2', 'Tasa afecta');
$hojaActiva->setCellValue('AA2', 'Tasa exenta');
$hojaActiva->setCellValue('AB2', 'Prima afecta');
$hojaActiva->setCellValue('AC2', 'Prima exenta');
$hojaActiva->setCellValue('AD2', 'Prima neta');
$hojaActiva->setCellValue('AE2', 'Prima bruta anual');
$hojaActiva->setCellValue('AF2', 'Monto asegurado');
$hojaActiva->setCellValue('AG2', 'Vencimiento garantía');

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

$hojaActiva->getStyle('A2:AG2')->applyFromArray($styleArray);
$hojaActiva->getColumnDimension('A')->setWidth(5);
$hojaActiva->getColumnDimension('D')->setWidth(8);
$hojaActiva->getColumnDimension('E')->setWidth(8);
$hojaActiva->getColumnDimension('M')->setWidth(8);
$hojaActiva->getColumnDimension('N')->setWidth(8);
$hojaActiva->getColumnDimension('O')->setWidth(8);
$hojaActiva->getColumnDimension('P')->setWidth(8);
$hojaActiva->getColumnDimension('R')->setWidth(8);
$hojaActiva->getColumnDimension('Z')->setWidth(8);
$hojaActiva->getColumnDimension('AA')->setWidth(8);
$hojaActiva->getColumnDimension('AB')->setWidth(8);
$hojaActiva->getColumnDimension('AC')->setWidth(8);
$hojaActiva->getColumnDimension('AD')->setWidth(8);
$hojaActiva->getColumnDimension('AE')->setWidth(8);
$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva->getColumnDimension('C')->setWidth(10);
$hojaActiva->getColumnDimension('F')->setWidth(10);
$hojaActiva->getColumnDimension('G')->setWidth(10);
$hojaActiva->getColumnDimension('K')->setWidth(10);
$hojaActiva->getColumnDimension('L')->setWidth(10);
$hojaActiva->getColumnDimension('Q')->setWidth(10);
$hojaActiva->getColumnDimension('X')->setWidth(10);
$hojaActiva->getColumnDimension('AG')->setWidth(10);
$hojaActiva->getColumnDimension('H')->setWidth(15);
$hojaActiva->getColumnDimension('U')->setWidth(15);
$hojaActiva->getColumnDimension('Y')->setWidth(15);
$hojaActiva->getColumnDimension('AF')->setWidth(15);
$hojaActiva->getColumnDimension('S')->setWidth(20);
$hojaActiva->getColumnDimension('T')->setWidth(20);
$hojaActiva->getColumnDimension('W')->setWidth(20);
$hojaActiva->getColumnDimension('I')->setWidth(30);
$hojaActiva->getColumnDimension('J')->setWidth(30);
$hojaActiva->getColumnDimension('V')->setWidth(30);
/*
listado original
$hojaActiva->setCellValue('A2', 'fila');
$hojaActiva->setCellValue('B2', 'estado');
$hojaActiva->setCellValue('C2', 'numero_propuesta');
$hojaActiva->setCellValue('D2', 'numero_item');
$hojaActiva->setCellValue('E2', 'tipo_propuesta');
$hojaActiva->setCellValue('F2', 'fecha_propuesta');
$hojaActiva->setCellValue('G2', 'fecha_envio_propuesta');
$hojaActiva->setCellValue('H2', 'rut_proponente');
$hojaActiva->setCellValue('I2', 'compania');
$hojaActiva->setCellValue('J2', 'ramo');
$hojaActiva->setCellValue('K2', 'vigencia_inicial');
$hojaActiva->setCellValue('L2', 'vigencia_final');
$hojaActiva->setCellValue('M2', 'moneda_poliza');
$hojaActiva->setCellValue('N2', 'forma_pago');
$hojaActiva->setCellValue('O2', 'moneda_valor_cuota');
$hojaActiva->setCellValue('P2', 'valor_cuota');
$hojaActiva->setCellValue('Q2', 'fecha_primera_cuota');
$hojaActiva->setCellValue('R2', 'nro_cuotas');
$hojaActiva->setCellValue('S2', 'comentarios_int');
$hojaActiva->setCellValue('T2', 'comentarios_ext');
$hojaActiva->setCellValue('U2', 'rut_asegurado');
$hojaActiva->setCellValue('V2', 'materia_asegurada');
$hojaActiva->setCellValue('W2', 'patente_ubicacion');
$hojaActiva->setCellValue('X2', 'cobertura');
$hojaActiva->setCellValue('Y2', 'deducible');
$hojaActiva->setCellValue('Z2', 'tasa_afecta');
$hojaActiva->setCellValue('AA2', 'tasa_exenta');
$hojaActiva->setCellValue('AB2', 'prima_afecta');
$hojaActiva->setCellValue('AC2', 'prima_exenta');
$hojaActiva->setCellValue('AD2', 'prima_neta');
$hojaActiva->setCellValue('AE2', 'prima_bruta_anual');
$hojaActiva->setCellValue('AF2', 'monto_asegurado');
$hojaActiva->setCellValue('AG2', 'venc_gtia');

$hojaActiva->getColumnDimension('A')->setWidth(3);
$hojaActiva->getColumnDimension('B')->setWidth(20);
$hojaActiva->getColumnDimension('C')->setWidth(15);
$hojaActiva->getColumnDimension('D')->setWidth(20);
*/
$fila=3;

while ($rows = mysqli_fetch_object($resultado))
{
    $hojaActiva->setCellValue('A'.$fila, $rows->fila);
    $hojaActiva->setCellValue('B'.$fila, $rows->estado);
    $hojaActiva->setCellValue('C'.$fila, $rows->numero_propuesta);
    $hojaActiva->setCellValue('D'.$fila, $rows->numero_item);
    $hojaActiva->setCellValue('E'.$fila, $rows->tipo_propuesta);
    $hojaActiva->setCellValue('F'.$fila, $rows->fecha_propuesta);
    $hojaActiva->setCellValue('G'.$fila, $rows->fecha_envio_propuesta);
    $hojaActiva->setCellValue('H'.$fila, $rows->rut_proponente);
    $hojaActiva->setCellValue('I'.$fila, $rows->compania);
    $hojaActiva->setCellValue('J'.$fila, $rows->ramo);
    $hojaActiva->setCellValue('K'.$fila, $rows->vigencia_inicial);
    $hojaActiva->setCellValue('L'.$fila, $rows->vigencia_final);
    $hojaActiva->setCellValue('M'.$fila, $rows->moneda_poliza);
    $hojaActiva->setCellValue('N'.$fila, $rows->forma_pago);
    $hojaActiva->setCellValue('O'.$fila, $rows->moneda_valor_cuota);
    $hojaActiva->setCellValue('P'.$fila, $rows->valor_cuota);
    $hojaActiva->setCellValue('Q'.$fila, $rows->fecha_primera_cuota);
    $hojaActiva->setCellValue('R'.$fila, $rows->nro_cuotas);
    $hojaActiva->setCellValue('S'.$fila, $rows->comentarios_int);
    $hojaActiva->setCellValue('T'.$fila, $rows->comentarios_ext);
    $hojaActiva->setCellValue('U'.$fila, $rows->rut_asegurado);
    $hojaActiva->setCellValue('V'.$fila, $rows->materia_asegurada);
    $hojaActiva->setCellValue('W'.$fila, $rows->patente_ubicacion);
    $hojaActiva->setCellValue('X'.$fila, $rows->cobertura);
    $hojaActiva->setCellValue('Y'.$fila, $rows->deducible);
    $hojaActiva->setCellValue('Z'.$fila, $rows->tasa_afecta);
    $hojaActiva->setCellValue('AA'.$fila, $rows->tasa_exenta);
    $hojaActiva->setCellValue('AB'.$fila, $rows->prima_afecta);
    $hojaActiva->setCellValue('AC'.$fila, $rows->prima_exenta);
    $hojaActiva->setCellValue('AD'.$fila, $rows->prima_neta);
    $hojaActiva->setCellValue('AE'.$fila, $rows->prima_bruta_anual);
    $hojaActiva->setCellValue('AF'.$fila, $rows->monto_asegurado);
    $hojaActiva->setCellValue('AG'.$fila, $rows->venc_gtia);

    $fila++;
}
$fecha = new DateTime(date("Y-m-d H:i:sP"), new DateTimeZone('America/Santiago') );
date_timezone_set($fecha, timezone_open('America/Santiago'));
$hojaActiva->setAutoFilter('A2:AG'.($fila-1));
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Listado_propuestas '.date_format($fecha, 'd-m-Y H:i:s').'.xlsx"');
header('Cache-Control: max-age=0');
mysqli_close($link);
$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');
exit;
?>