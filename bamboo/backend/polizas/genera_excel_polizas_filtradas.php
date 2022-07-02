<?php

require "/home/gestio10/public_html/vendor/autoload.php";
require_once "/home/gestio10/public_html/backend/config.php";
$dias=$_GET["filtro_dias"];
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
mysqli_query($link, "SET @rownum=0;");
$query= "select @rownum := @rownum + 1 AS fila, a.estado, a.numero_poliza, b.numero_item, a.numero_propuesta, a.tipo_propuesta, a.fecha_propuesta, a.fecha_envio_propuesta, CONCAT_WS('-',a.rut_proponente, a.dv_proponente) as rut_proponente, a.compania, a.vigencia_inicial, a.vigencia_final, a.ramo, a.moneda_poliza, a.vendedor, a.forma_pago, a.moneda_valor_cuota, a.valor_cuota, a.fecha_primera_cuota, a.nro_cuotas, a.comentarios_int, a.comentarios_ext, CONCAT_WS('-',b.rut_asegurado, b.dv_asegurado) as rut_asegurado, b.materia_asegurada, b.patente_ubicacion, b.cobertura, b.deducible, CONCAT(FORMAT(b.tasa_afecta, 2, 'de_DE'),'%') as tasa_afecta, CONCAT(FORMAT(b.tasa_exenta, 2, 'de_DE'),'%') as tasa_exenta, 
FORMAT(b.prima_afecta, 2)+0.0 as prima_afecta, 
FORMAT(b.prima_exenta, 2)+0.0 as prima_exenta, 
FORMAT(b.prima_neta, 2)+0.0 as prima_neta, 
FORMAT(b.prima_bruta_anual, 2)+0.0 as prima_bruta_anual, 
b.monto_asegurado, b.venc_gtia, c.nombre_cliente as proponente, d.nombre_cliente as asegurado, c.grupo as grupo_proponente, d.grupo as grupo_asegurado, a.comision, a.porcentaje_comision, a.comision_bruta, a.comision_neta, a.comision_neta,a.numero_boleta, a.comision_negativa, a.boleta_negativa, a.depositado_fecha, a.vendedor, a.poliza_renovada, a.fech_cancela as fecha_cancelacion, a.motivo_cancela as motivo_cancelacion,
concat_ws('-',SUBSTRING(a.vigencia_inicial, 6,2),SUBSTRING(a.vigencia_inicial, 1,4)) as mesano_vigencia_inicial,
concat_ws('-',SUBSTRING(a.vigencia_final, 6,2),SUBSTRING(a.vigencia_final, 1,4)) as mesano_vigencia_final

from polizas_2 as a 
left join items as b 
on a.numero_poliza=b.numero_poliza
left join clientes as c
on a.rut_proponente=c.rut_sin_dv
left join clientes as d 
on b.rut_asegurado=d.rut_sin_dv
where b.id is not null and DATEDIFF(a.vigencia_final, CURRENT_DATE) + 1  between 0 and ".$dias.";";
$resultado=mysqli_query($link, $query);
$excel= new Spreadsheet();
$hojaActiva=$excel->getActiveSheet();
$hojaActiva->setCellValue('A2', 'Fila');
$hojaActiva->setCellValue('B2', 'Estado');
$hojaActiva->setCellValue('C2', 'Numero poliza');
$hojaActiva->setCellValue('D2', 'Número Ítem');
$hojaActiva->setCellValue('E2', 'Número propuesta');
$hojaActiva->setCellValue('F2', 'Proponente');
$hojaActiva->setCellValue('G2', 'Rut proponente');
$hojaActiva->setCellValue('H2', 'Asegurado');
$hojaActiva->setCellValue('I2', 'Rut asegurado');
$hojaActiva->setCellValue('J2', 'Grupo proponente');
$hojaActiva->setCellValue('K2', 'Grupo asegurado');
$hojaActiva->setCellValue('L2', 'Tipo propuesta');
$hojaActiva->setCellValue('M2', 'Fecha propuesta');
$hojaActiva->setCellValue('N2', 'Fecha envío propuesta');
$hojaActiva->setCellValue('O2', 'Compañía');
$hojaActiva->setCellValue('P2', 'Vigencia inicial');
$hojaActiva->setCellValue('Q2', 'Vigencia final');
$hojaActiva->setCellValue('R2', 'Ramo');
$hojaActiva->setCellValue('S2', 'vendedor');
$hojaActiva->setCellValue('T2', 'Forma pago');
$hojaActiva->setCellValue('U2', 'Moneda valor cuota');
$hojaActiva->setCellValue('V2', 'Valor cuota');
$hojaActiva->setCellValue('W2', 'Fecha primera cuota');
$hojaActiva->setCellValue('X2', 'Nro cuotas');
$hojaActiva->setCellValue('Y2', 'Comentarios internos');
$hojaActiva->setCellValue('Z2', 'Comentarios externos');
$hojaActiva->setCellValue('AA2', 'Materia asegurada');
$hojaActiva->setCellValue('AB2', 'Patente ubicacion');
$hojaActiva->setCellValue('AC2', 'Cobertura');
$hojaActiva->setCellValue('AD2', 'Deducible');
$hojaActiva->setCellValue('AE2', 'Tasa afecta');
$hojaActiva->setCellValue('AF2', 'Tasa exenta');
$hojaActiva->setCellValue('AG2', 'Moneda póliza');
$hojaActiva->setCellValue('AH2', 'Prima afecta');
$hojaActiva->setCellValue('AI2', 'Prima exenta');
$hojaActiva->setCellValue('AJ2', 'Prima neta');
$hojaActiva->setCellValue('AK2', 'Prima bruta anual');
$hojaActiva->setCellValue('AL2', 'Monto asegurado');
$hojaActiva->setCellValue('AM2', 'Vencimiento garantÍa');
$hojaActiva->setCellValue('AN2', 'comision');
$hojaActiva->setCellValue('AO2', '%comision');
$hojaActiva->setCellValue('AP2', 'Comision bruta');
$hojaActiva->setCellValue('AQ2', 'Comision Neta');
$hojaActiva->setCellValue('AR2', 'Numero boleta');
$hojaActiva->setCellValue('AS2', 'Comision negativa');
$hojaActiva->setCellValue('AT2', 'Boleta negativa');
$hojaActiva->setCellValue('AU2', 'Fecha depostio');
$hojaActiva->setCellValue('AV2', 'Poliza renovada');
$hojaActiva->setCellValue('AW2', 'Fecha cancelacion');
$hojaActiva->setCellValue('AX2', 'Motivo cancelacion');
$hojaActiva->setCellValue('AY2', 'Vigencia inicial (mes-año)');
$hojaActiva->setCellValue('AZ2', 'Vigencia final (mes-año)');


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
$hojaActiva->getColumnDimension('C')->setWidth(20);
$hojaActiva->getColumnDimension('D')->setWidth(10);
$hojaActiva->getColumnDimension('E')->setWidth(10);
$hojaActiva->getColumnDimension('F')->setWidth(30);
$hojaActiva->getColumnDimension('G')->setWidth(10);
$hojaActiva->getColumnDimension('H')->setWidth(30);
$hojaActiva->getColumnDimension('I')->setWidth(10);
$hojaActiva->getColumnDimension('J')->setWidth(10);
$hojaActiva->getColumnDimension('K')->setWidth(10);
$hojaActiva->getColumnDimension('L')->setWidth(15);
$hojaActiva->getColumnDimension('M')->setWidth(10);
$hojaActiva->getColumnDimension('N')->setWidth(10);
$hojaActiva->getColumnDimension('O')->setWidth(25);
$hojaActiva->getColumnDimension('P')->setWidth(10);
$hojaActiva->getColumnDimension('Q')->setWidth(10);
$hojaActiva->getColumnDimension('R')->setWidth(25);
$hojaActiva->getColumnDimension('S')->setWidth(15);
$hojaActiva->getColumnDimension('T')->setWidth(10);
$hojaActiva->getColumnDimension('U')->setWidth(10);
$hojaActiva->getColumnDimension('V')->setWidth(10);
$hojaActiva->getColumnDimension('W')->setWidth(10);
$hojaActiva->getColumnDimension('X')->setWidth(10);
$hojaActiva->getColumnDimension('Y')->setWidth(30);
$hojaActiva->getColumnDimension('Z')->setWidth(30);
$hojaActiva->getColumnDimension('AA')->setWidth(25);
$hojaActiva->getColumnDimension('AB')->setWidth(20);
$hojaActiva->getColumnDimension('AC')->setWidth(15);
$hojaActiva->getColumnDimension('AD')->setWidth(15);
$hojaActiva->getColumnDimension('AE')->setWidth(10);
$hojaActiva->getColumnDimension('AF')->setWidth(10);
$hojaActiva->getColumnDimension('AG')->setWidth(10);
$hojaActiva->getColumnDimension('AH')->setWidth(10);
$hojaActiva->getColumnDimension('AI')->setWidth(10);
$hojaActiva->getColumnDimension('AJ')->setWidth(10);
$hojaActiva->getColumnDimension('AK')->setWidth(10);
$hojaActiva->getColumnDimension('AL')->setWidth(10);
$hojaActiva->getColumnDimension('AM')->setWidth(10);
$hojaActiva->getColumnDimension('AN')->setWidth(10);
$hojaActiva->getColumnDimension('AO')->setWidth(10);
$hojaActiva->getColumnDimension('AP')->setWidth(10);
$hojaActiva->getColumnDimension('AQ')->setWidth(10);
$hojaActiva->getColumnDimension('AR')->setWidth(10);
$hojaActiva->getColumnDimension('AS')->setWidth(10);
$hojaActiva->getColumnDimension('AT')->setWidth(10);
$hojaActiva->getColumnDimension('AU')->setWidth(10);
$hojaActiva->getColumnDimension('AV')->setWidth(10);
$hojaActiva->getColumnDimension('AW')->setWidth(10);
$hojaActiva->getColumnDimension('AX')->setWidth(10);
$hojaActiva->getColumnDimension('AY')->setWidth(10);
$hojaActiva->getColumnDimension('AZ')->setWidth(10);
$fila=3;

while ($rows = mysqli_fetch_object($resultado))
{
    $hojaActiva->setCellValue('A'.$fila, $rows->fila);
    $hojaActiva->setCellValue('B'.$fila, $rows->estado);
    $hojaActiva->setCellValue('C'.$fila, $rows->numero_poliza);
    $hojaActiva->setCellValue('D'.$fila, $rows->numero_item);
    $hojaActiva->setCellValue('E'.$fila, $rows->numero_propuesta);
    $hojaActiva->setCellValue('F'.$fila, $rows->proponente);
    $hojaActiva->setCellValue('G'.$fila, $rows->rut_proponente);
    $hojaActiva->setCellValue('H'.$fila, $rows->asegurado);
    $hojaActiva->setCellValue('I'.$fila, $rows->rut_asegurado);
    $hojaActiva->setCellValue('J'.$fila, $rows->grupo_proponente);
    $hojaActiva->setCellValue('K'.$fila, $rows->grupo_asegurado);
    $hojaActiva->setCellValue('L'.$fila, $rows->tipo_propuesta);
    $hojaActiva->setCellValue('M'.$fila, $rows->fecha_propuesta);
    $hojaActiva->setCellValue('N'.$fila, $rows->fecha_envio_propuesta);
    $hojaActiva->setCellValue('O'.$fila, $rows->compania);
    $hojaActiva->setCellValue('P'.$fila, $rows->vigencia_inicial);
    $hojaActiva->setCellValue('Q'.$fila, $rows->vigencia_final);
    $hojaActiva->setCellValue('R'.$fila, $rows->ramo);
    $hojaActiva->setCellValue('S'.$fila, $rows->vendedor);
    $hojaActiva->setCellValue('T'.$fila, $rows->forma_pago);
    $hojaActiva->setCellValue('U'.$fila, $rows->moneda_valor_cuota);
    $hojaActiva->setCellValue('V'.$fila, $rows->valor_cuota);
    $hojaActiva->setCellValue('W'.$fila, $rows->fecha_primera_cuota);
    $hojaActiva->setCellValue('X'.$fila, $rows->nro_cuotas);
    $hojaActiva->setCellValue('Y'.$fila, $rows->comentarios_int);
    $hojaActiva->setCellValue('Z'.$fila, $rows->comentarios_ext);
    $hojaActiva->setCellValue('AA'.$fila, $rows->materia_asegurada);
    $hojaActiva->setCellValue('AB'.$fila, $rows->patente_ubicacion);
    $hojaActiva->setCellValue('AC'.$fila, $rows->cobertura);
    $hojaActiva->setCellValue('AD'.$fila, $rows->deducible);
    $hojaActiva->setCellValue('AE'.$fila, $rows->tasa_afecta);
    $hojaActiva->setCellValue('AF'.$fila, $rows->tasa_exenta);
    $hojaActiva->setCellValue('AG'.$fila, $rows->moneda_poliza);
    $hojaActiva->setCellValue('AH'.$fila, $rows->prima_afecta);
    $hojaActiva->setCellValue('AI'.$fila, $rows->prima_exenta);
    $hojaActiva->setCellValue('AJ'.$fila, $rows->prima_neta);
    $hojaActiva->setCellValue('AK'.$fila, $rows->prima_bruta_anual);
    $hojaActiva->setCellValue('AL'.$fila, $rows->monto_asegurado);
    $hojaActiva->setCellValue('AM'.$fila, $rows->venc_gtia);
    $hojaActiva->setCellValue('AN'.$fila, $rows->comision);
    $hojaActiva->setCellValue('AO'.$fila, $rows->porcentaje_comision);
    $hojaActiva->setCellValue('AP'.$fila, $rows->comision_bruta);
    $hojaActiva->setCellValue('AQ'.$fila, $rows->comision_neta);
    $hojaActiva->setCellValue('AR'.$fila, $rows->numero_boleta);
    $hojaActiva->setCellValue('AS'.$fila, $rows->comision_negativa);
    $hojaActiva->setCellValue('AT'.$fila, $rows->boleta_negativa);
    $hojaActiva->setCellValue('AU'.$fila, $rows->depositado_fecha);
    $hojaActiva->setCellValue('AV'.$fila, $rows->poliza_renovada);
    $hojaActiva->setCellValue('AW'.$fila, $rows->fecha_cancelacion);
    $hojaActiva->setCellValue('AX'.$fila, $rows->motivo_cancelacion);
    $hojaActiva->setCellValue('AY'.$fila, $rows->mesano_vigencia_inicial);
    $hojaActiva->setCellValue('AZ'.$fila, $rows->mesano_vigencia_final);
    $fila++;
}
$fecha = new DateTime(date("Y-m-d H:i:sP"), new DateTimeZone('America/Santiago') );
date_timezone_set($fecha, timezone_open('America/Santiago'));
$hojaActiva->setAutoFilter('A2:AZ'.($fila-1));
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Listado_pólizas '.date_format($fecha, 'd-m-Y H:i:s').'.xlsx"');
header('Cache-Control: max-age=0');
mysqli_close($link);
$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');
exit;
?>