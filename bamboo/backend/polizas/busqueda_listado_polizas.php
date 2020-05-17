<?php
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
    $sql = "SELECT estado, year(vigencia_final)*100+month(vigencia_final) as anomes_final, year(vigencia_inicial)*100+month(vigencia_inicial) as anomes_inicial, tipo_poliza, moneda_poliza, deducible, prima_afecta, prima_exenta, prima_bruta_anual, compania, ramo, vigencia_inicial, vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura , CONCAT(b.nombre_cliente, ' ', b.apellido_paterno, ' ', b.apellido_materno) as nom_clienteP, CONCAT(b.rut_sin_dv, '-',b.dv) as rut_clienteP,b.telefono as telefonoP, b.correo as correoP, CONCAT(c.nombre_cliente, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nom_clienteA, CONCAT(c.rut_sin_dv, '-',c.dv) as rut_clienteA,c.telefono as telefonoA, c.correo as correoA, a.id as id_poliza, b.id as idP, c.id as idA, c.grupo FROM polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null";
    $resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
  {$conta=$conta+1;
    if ($conta==1){
      $codigo.= json_encode(array(
        "ramo" =>& $row->ramo,
        "estado" =>& $row->estado,
        "anomes_final" =>& $row->anomes_final,
        "anomes_inicial" =>& $row->anomes_inicial,
        "tipo_poliza" =>& $row->tipo_poliza,
        "moneda_poliza" =>& $row->moneda_poliza,
        "vigencia_inicial" =>& $row->vigencia_inicial,
        "deducible" =>& $row->deducible,
        "prima_afecta" =>& $row->prima_afecta,
        "prima_exenta" =>& $row->prima_exenta,
        "prima_bruta_anual" =>& $row->prima_bruta_anual,
        "vigencia_final"=>& $row->vigencia_final,
        "compania" =>& $row->compania,
        "numero_poliza"=>& $row->numero_poliza,
        "materia_asegurada"=>& $row->materia_asegurada,
        "patente_ubicacion" =>& $row->patente_ubicacion,
        "cobertura" =>& $row->cobertura,
        "nom_clienteP" =>& $row->nom_clienteP,
        "rut_clienteP" =>& $row->rut_clienteP,
        "telefonoP" =>& $row->telefonoP,
        "correoP" =>& $row->correoP,
        "nom_clienteA" =>& $row->nom_clienteA,
        "rut_clienteA" =>& $row->rut_clienteA,
        "telefonoA" =>& $row->telefonoA,
        "correoA" =>& $row->correoA,
        "idP" =>& $row->idP,
        "idA" =>& $row->idA,
        "grupo" =>& $row->grupo,
        "id_poliza"=>& $row->id_poliza));
    } else {
    $codigo.= ', '.json_encode(array(
      "ramo" =>& $row->ramo, 
      "estado" =>& $row->estado,
      "anomes_final" =>& $row->anomes_final,
      "anomes_inicial" =>& $row->anomes_inicial,
      "tipo_poliza" =>& $row->tipo_poliza,
      "moneda_poliza" =>& $row->moneda_poliza,
      "vigencia_inicial" =>& $row->vigencia_inicial,
      "deducible" =>& $row->deducible,
      "prima_afecta" =>& $row->prima_afecta,
      "prima_exenta" =>& $row->prima_exenta,
      "prima_bruta_anual" =>& $row->prima_bruta_anual,
      "vigencia_final"=>& $row->vigencia_final,
      "compania" =>& $row->compania,
      "numero_poliza"=>& $row->numero_poliza,
      "materia_asegurada"=>& $row->materia_asegurada,
      "patente_ubicacion" =>& $row->patente_ubicacion,
      "cobertura" =>& $row->cobertura,
      "nom_clienteP" =>& $row->nom_clienteP,
      "rut_clienteP" =>& $row->rut_clienteP,
      "telefonoP" =>& $row->telefonoP,
      "correoP" =>& $row->correoP,
      "nom_clienteA" =>& $row->nom_clienteA,
      "rut_clienteA" =>& $row->rut_clienteA,
      "telefonoA" =>& $row->telefonoA,
      "correoA" =>& $row->correoA,
      "idP" =>& $row->idP,
      "idA" =>& $row->idA,
      "grupo" =>& $row->grupo,
      "id_poliza"=>& $row->id_poliza
    ));}
  }
  $codigo.=']}';
  echo $codigo;
  /*
[4][1]-> "ramo" =>& $row->ramo, 
[1][2]-> "estado" =>& $row->estado,
[14][3]-> "anomes_final" =>& $row->anomes_final,
[15][4]-> "anomes_inicial" =>& $row->anomes_inicial,
[8][5]-> "tipo_poliza" =>& $row->tipo_poliza,
[16][6]-> "moneda_poliza" =>& $row->moneda_poliza,
[5][7]-> "vigencia_inicial" =>& $row->vigencia_inicial,
[10][8]-> "deducible" =>& $row->deducible,
[11][9]-> "prima_afecta" =>& $row->prima_afecta,
[12][10]-> "prima_exenta" =>& $row->prima_exenta,
[13][11]-> "prima_bruta_anual" =>& $row->prima_bruta_anual,
[6][12]-> "vigencia_final"=>& $row->vigencia_final,
[3][13]-> "compania" =>& $row->compania,
[][14]-> "vigencia_final"=>& $row->vigencia_final,
[2][15]-> "numero_poliza"=>& $row->numero_poliza,
[7][16]-> "materia_asegurada"=>& $row->materia_asegurada,
[9][17]-> "patente_ubicacion" =>& $row->patente_ubicacion,
[17][18]-> "cobertura" =>& $row->cobertura,
[18][19]-> "nom_clienteP" =>& $row->nom_clienteP,
[19][20]-> "rut_clienteP" =>& $row->rut_clienteP,
[][21]-> "telefonoP" =>& $row->telefonoP,
[][22]-> "correoP" =>& $row->correoP,
[20][23]-> "nom_clienteA" =>& $row->nom_clienteA,
[21][24]-> "rut_clienteA" =>& $row->rut_clienteA,
[][25]-> "telefonoA" =>& $row->telefonoA,
[][26]-> "correoA" =>& $row->correoA,
[][27]-> "idP" =>& $row->idP,
[][28]-> "idA" =>& $row->idA,
[][29]-> "grupo" =>& $row->grupo
[][30]-> "id_poliza"=>& $row->id_poliza
*/
?>
