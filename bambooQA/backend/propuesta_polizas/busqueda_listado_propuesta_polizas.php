<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
//    $sql = "SELECT informacion_adicional, estado, DATE_FORMAT(vigencia_final,'%m-%Y') as anomes_final, DATE_FORMAT(vigencia_inicial,'%m-%Y')  as anomes_inicial, tipo_poliza,poliza_renovada, moneda_poliza, deducible, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_afecta, 4, 'de_DE')) AS prima_afecta, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_exenta, 4, 'de_DE')) AS prima_exenta, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_bruta_anual, 4, 'de_DE')) AS prima_bruta_anual, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_neta, 4, 'de_DE')) AS prima_neta, compania, ramo, DATE_FORMAT(vigencia_inicial,'%d-%m-%Y') as vigencia_inicial,DATE_FORMAT(vigencia_final,'%d-%m-%Y') as vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura , CONCAT_WS(' ',b.nombre_cliente,  b.apellido_paterno, ' ', b.apellido_materno) as nom_clienteP, CONCAT_WS('-',b.rut_sin_dv, b.dv) as rut_clienteP,b.telefono as telefonoP, b.correo as correoP, CONCAT_WS(' ',c.nombre_cliente,  c.apellido_paterno,  c.apellido_materno) as nom_clienteA, CONCAT_WS('-',c.rut_sin_dv, c.dv) as rut_clienteA,c.telefono as telefonoA, c.correo as correoA, a.id as id_poliza, b.id as idP, c.id as idA,  monto_asegurado, numero_propuesta, fecha_envio_propuesta, CONCAT_WS(' ',moneda_comision,FORMAT(comision, 4, 'de_DE')) AS comision, CONCAT(FORMAT(porcentaje_comision, 4, 'de_DE'),'%') as porcentaje_comision, CONCAT_WS(' ',moneda_comision,FORMAT(comision_bruta, 4, 'de_DE')) AS comision_bruta , CONCAT_WS(' ',moneda_comision,FORMAT(comision_neta, 4, 'de_DE')) AS comision_neta, numero_boleta, boleta_negativa, CONCAT_WS(' ',moneda_comision_negativa,FORMAT(comision_negativa, 4, 'de_DE')) AS comision_negativa, DATE_FORMAT(depositado_fecha,'%d-%m-%Y') as depositado_fecha, vendedor, nombre_vendedor, forma_pago, nro_cuotas, CONCAT_WS(' ',moneda_valor_cuota,FORMAT(valor_cuota, 4, 'de_DE')) AS valor_cuota , DATE_FORMAT(fecha_primera_cuota,'%d-%m-%Y') as fecha_primera_cuota , if(a.rut_proponente=a.rut_asegurado, c.grupo, if(c.grupo=b.grupo, c.grupo, CONCAT_WS(' ',c.grupo, b.grupo))) as grupo, if(a.rut_proponente=a.rut_asegurado, c.referido, if(c.referido=b.referido, c.referido, CONCAT_WS(' ',c.referido, b.referido))) as referido, a.nombre_vendedor FROM polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null";
    $sql = "SELECT item, estado, DATE_FORMAT(vigencia_final,'%m-%Y') as anomes_final, DATE_FORMAT(vigencia_inicial,'%m-%Y')  as anomes_inicial, tipo_propuesta, moneda_poliza, deducible, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_afecta, 4, 'de_DE')) AS prima_afecta, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_exenta, 4, 'de_DE')) AS prima_exenta, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_bruta_anual, 4, 'de_DE')) AS prima_bruta_anual, CONCAT_WS(' ',moneda_poliza,FORMAT(prima_neta, 4, 'de_DE')) AS prima_neta, compania, ramo,  vigencia_inicial, vigencia_final, numero_propuesta, materia_asegurada, patente_ubicacion,cobertura , CONCAT_WS(' ',b.nombre_cliente,  b.apellido_paterno, ' ', b.apellido_materno) as nom_clienteP, CONCAT_WS('-',b.rut_sin_dv, b.dv) as rut_clienteP,b.telefono as telefonoP, b.correo as correoP, CONCAT_WS(' ',c.nombre_cliente,  c.apellido_paterno,  c.apellido_materno) as nom_clienteA, CONCAT_WS('-',c.rut_sin_dv, c.dv) as rut_clienteA,c.telefono as telefonoA, c.correo as correoA, a.id as id_propuesta, b.id as idP, c.id as idA,  monto_asegurado, numero_propuesta, fecha_envio_propuesta, if(c.grupo=b.grupo, c.grupo, CONCAT_WS(' ',c.grupo, b.grupo)) as grupo, if(a.rut_proponente=a.rut_asegurado, c.referido, if(c.referido=b.referido, c.referido, CONCAT_WS(' ',c.referido, b.referido))) as referido FROM propuesta_polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null";

$resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
  {$conta=$conta+1;
    if ($conta==1){
      $codigo.= json_encode(array(
        "ramo" =>& $row->ramo,                                  //0
        "estado" =>& $row->estado,                              //1
        "anomes_final" =>& $row->anomes_final,                  //2
        "anomes_inicial" =>& $row->anomes_inicial,              //3
        "tipo_propuesta" =>& $row->tipo_propuesta,              //4
        "moneda_poliza" =>& $row->moneda_poliza,                //5
        "vigencia_inicial" =>& $row->vigencia_inicial,          //6
        "deducible" =>& $row->deducible,                        //7
        "prima_afecta" =>& $row->prima_afecta,                  //8
        "prima_exenta" =>& $row->prima_exenta,                  //9
        "prima_neta" =>& $row->prima_neta,                      //10
        "prima_bruta_anual" =>& $row->prima_bruta_anual,        //11
        "vigencia_final"=>& $row->vigencia_final,               //12
        "compania" =>& $row->compania,                          //13
        "item"=>& $row->item,                                   //14
        "materia_asegurada"=>& $row->materia_asegurada,         //15
        "patente_ubicacion" =>& $row->patente_ubicacion,        //16
        "cobertura" =>& $row->cobertura,                        //17
        "nom_clienteP" =>& $row->nom_clienteP,                  //18
        "rut_clienteP" =>& $row->rut_clienteP,                  //19
        "telefonoP" =>& $row->telefonoP,                        //20
        "correoP" =>& $row->correoP,                            //21
        "nom_clienteA" =>& $row->nom_clienteA,                  //22
        "rut_clienteA" =>& $row->rut_clienteA,                  //23
        "telefonoA" =>& $row->telefonoA,                        //24
        "correoA" =>& $row->correoA,                            //25
        "idP" =>& $row->idP,                                    //26
        "idA" =>& $row->idA,                                    //27
        "grupo" =>& $row->grupo,                                //28
        "referido" =>& $row->referido,                          //29
        "id_propuesta"=>& $row->id_propuesta,                   //30
        "monto_asegurado" =>& $row->monto_asegurado,            //31
        "numero_propuesta" =>& $row->numero_propuesta,          //32
        "fecha_envio_propuesta" =>& $row->fecha_envio_propuesta//33
      ));
    } else {
    $codigo.= ', '.json_encode(array(
      "ramo" =>& $row->ramo, 
      "estado" =>& $row->estado,
      "anomes_final" =>& $row->anomes_final,
      "anomes_inicial" =>& $row->anomes_inicial,
      "tipo_propuesta" =>& $row->tipo_propuesta,
      "moneda_poliza" =>& $row->moneda_poliza,
      "vigencia_inicial" =>& $row->vigencia_inicial,
      "deducible" =>& $row->deducible,
      "prima_afecta" =>& $row->prima_afecta,
      "prima_exenta" =>& $row->prima_exenta,
      "prima_neta" =>& $row->prima_neta,
      "prima_bruta_anual" =>& $row->prima_bruta_anual,
      "vigencia_final"=>& $row->vigencia_final,
      "compania" =>& $row->compania,
      "item"=>& $row->item,
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
      "referido" =>& $row->referido,
      "id_propuesta"=>& $row->id_propuesta,
      "monto_asegurado" =>& $row->monto_asegurado,
      "numero_propuesta" =>& $row->numero_propuesta,
      "fecha_envio_propuesta" =>& $row->fecha_envio_propuesta
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




[1][2]-> "estado" =>& $row->estado,
[2][15]-> "numero_poliza"=>& $row->numero_poliza,
[3][13]-> "compania" =>& $row->compania,
[4][1]-> "ramo" =>& $row->ramo, 
[5][7]-> "vigencia_inicial" =>& $row->vigencia_inicial,
[6][12]-> "vigencia_final"=>& $row->vigencia_final,
[7][16]-> "materia_asegurada"=>& $row->materia_asegurada,
[8][5]-> "tipo_poliza" =>& $row->tipo_poliza,
[9][17]-> "patente_ubicacion" =>& $row->patente_ubicacion,
[10][8]-> "deducible" =>& $row->deducible,
[11][9]-> "prima_afecta" =>& $row->prima_afecta,
[12][10]-> "prima_exenta" =>& $row->prima_exenta,
[13][11]-> "prima_bruta_anual" =>& $row->prima_bruta_anual,
[14][3]-> "anomes_final" =>& $row->anomes_final,
[15][4]-> "anomes_inicial" =>& $row->anomes_inicial,
[16][6]-> "moneda_poliza" =>& $row->moneda_poliza,
[17][18]-> "cobertura" =>& $row->cobertura,
[18][19]-> "nom_clienteP" =>& $row->nom_clienteP,
[19][20]-> "rut_clienteP" =>& $row->rut_clienteP,
[20][23]-> "nom_clienteA" =>& $row->nom_clienteA,
[21][24]-> "rut_clienteA" =>& $row->rut_clienteA,
->[][14]-> "vigencia_final"=>& $row->vigencia_final,
[][21]-> "telefonoP" =>& $row->telefonoP,
[][22]-> "correoP" =>& $row->correoP,
[][25]-> "telefonoA" =>& $row->telefonoA,
[][26]-> "correoA" =>& $row->correoA,
[][27]-> "idP" =>& $row->idP,
[][28]-> "idA" =>& $row->idA,
[][29]-> "grupo" =>& $row->grupo
[][30]-> "id_poliza"=>& $row->id_poliza

agregar:
grupo,
poliza_renovada,

            {
                "data": "referido",
                title: "Referido"
            },
            {
                "data": "monto_asegurado",
                title: "Monto Asegurado"
            },
                        {
                "data": "numero_propuesta",
                title: "Propuesta"
            },
                        {
                "data": "fecha_envio_propuesta",
                title: "Fecha envío propuesto"
            },
                        {
                "data": "comision",
                title: "Comisión"
            },
                        {
                "data": "porcentaje_comision",
                title: "% Comisión"
            },
                        {
                "data": "comision_bruta",
                title: "Comisión Bruta"
            },
                        {
                "data": "comision_neta",
                title: "Comisión Neta"
            },
                        {
                "data": "numero_boleta",
                title: "Número boleta"
            },
                        {
                "data": "boleta_negativa",
                title: "Boleta negativa"
            },
                        {
                "data": "comision_negativa",
                title: "Comisión negativa"
            },
            {
                "data": "depositado_fecha",
                title: "Fecha depósito"
            },
            {
                "data": "vendedor",
                title: "Nombre vendedor"
            },
            {
                "data": "forma_pago",
                title: "Forma de pago"
            },
            {
                "data": "nro_cuotas",
                title: "Número de cuotas"
            },
            {
                "data": "valor_cuota",
                title: "Valor cuota"
            },
            {
                "data": "fecha_primera_cuota",
                title: "Fecha primera cuota"
            }
*/
?>
