<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
    $sql = "SELECT estado, DATE_FORMAT(vigencia_final,'%m-%Y') as anomes_final, DATE_FORMAT(vigencia_inicial,'%m-%Y')  as anomes_inicial, tipo_propuesta, moneda_poliza, compania, ramo,  vigencia_inicial, vigencia_final, a.numero_propuesta,  CONCAT_WS(' ',b.nombre_cliente,  b.apellido_paterno, ' ', b.apellido_materno) as nom_clienteP, CONCAT_WS('-',b.rut_sin_dv, b.dv) as rut_clienteP,b.telefono as telefonoP, b.correo as correoP, a.id as id_propuesta, b.id as idP, fecha_envio_propuesta, b.grupo, b.referido, CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_afecta), 4, 'de_DE')) as total_prima_afecta,  CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_exenta), 4, 'de_DE')) as total_prima_exenta, CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_neta), 4, 'de_DE')) as total_prima_neta, CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_bruta_anual), 4, 'de_DE')) as total_prima_bruta  FROM propuesta_polizas_2 as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join items as c on a.numero_propuesta=c.numero_propuesta group by estado, DATE_FORMAT(vigencia_final,'%m-%Y') , DATE_FORMAT(vigencia_inicial,'%m-%Y') , tipo_propuesta, moneda_poliza, compania, ramo,  vigencia_inicial, vigencia_final, a.numero_propuesta,  CONCAT_WS(' ',b.nombre_cliente,  b.apellido_paterno, ' ', b.apellido_materno) , CONCAT_WS('-',b.rut_sin_dv, b.dv) ,b.telefono , b.correo , a.id , b.id , fecha_envio_propuesta, b.grupo, b.referido  ";
  
$resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
    {   
        $conta=$conta+1;
    //$resultado contiene propuestas, a cada una de estas líneas hay que asignar un array con los ítem asociados
        //echo "primera query -> nro_propuesta: ".$row->numero_propuesta."<br>";
        $resultado_contador_contactos=mysqli_query($link, "SELECT count(numero_item) as contador FROM items where numero_propuesta='".$row->numero_propuesta."';");
        while ($fila=mysqli_fetch_object($resultado_contador_contactos))
        {
        //echo "segunda query -> contador: ".$fila->contador."<br>";
        $contador_contactos=0;
        $cant_items=$fila->contador;
        $resultado_items=mysqli_query($link, "select a.numero_propuesta, a.numero_item, a.id as id_item, a.materia_asegurada, a.patente_ubicacion, a.cobertura , a.deducible, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_afecta, 4, 'de_DE')) AS prima_afecta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_exenta, 4, 'de_DE')) AS prima_exenta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_bruta_anual, 4, 'de_DE')) AS prima_bruta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_neta, 4, 'de_DE')) AS prima_neta, a.monto_asegurado, a.venc_gtia, CONCAT_WS(' ',c.nombre_cliente,  c.apellido_paterno,  c.apellido_materno) as nom_clienteA, CONCAT_WS('-',c.rut_sin_dv, c.dv) as rut_clienteA,c.telefono as telefonoA, c.correo as correoA from items as a left join clientes as c  on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null left join propuesta_polizas_2 as b on a.numero_propuesta=b.numero_propuesta where a.numero_propuesta='".$row->numero_propuesta."';");
            $items_array=array("total_items"=>& $fila->contador);
            if (!$cant_items=="0"){
        while($indice=mysqli_fetch_object($resultado_items)){
            //echo "tercera query -> nropropuesta: ".$row->numero_propuesta."- ítem nro: ".$indice->id_item."<br>";
            
            $contador_contactos=$contador_contactos+1;
            $items_array=array_merge($items_array, array(
                "numero_item[".$contador_contactos."]" =>& $indice->numero_item,
                "materia_asegurada[".$contador_contactos."]" =>& $indice->materia_asegurada,
                "patente_ubicacion[".$contador_contactos."]" =>& $indice->patente_ubicacion,
                "cobertura[".$contador_contactos."]" =>& $indice->cobertura,
                "deducible[".$contador_contactos."]" =>& $indice->deducible,
                "prima_afecta[".$contador_contactos."]" =>& $indice->prima_afecta,
                "prima_exenta[".$contador_contactos."]" =>& $indice->prima_exenta,
                "prima_neta[".$contador_contactos."]" =>& $indice->prima_neta,
                "prima_bruta[".$contador_contactos."]" =>& $indice->prima_bruta,
                "nom_clienteA[".$contador_contactos."]" =>& $indice->nom_clienteA,
                "rut_clienteA[".$contador_contactos."]" =>& $indice->rut_clienteA,
                "telefonoA[".$contador_contactos."]" =>& $indice->telefonoA,
                "correoA[".$contador_contactos."]" =>& $indice->correoA,
                "venc_gtia[".$contador_contactos."]" =>& $indice->venc_gtia,
                "monto_asegurado[".$contador_contactos."]" =>& $indice->monto_asegurado
                ));
        }
                //echo var_dump($items_array);
            }
        
        }
    if ($conta==1){
      $codigo.= json_encode(array_merge(array(
        "numero_propuesta" =>& $row->numero_propuesta,          //1
        "estado" =>& $row->estado,                              //2
        "tipo_propuesta" =>& $row->tipo_propuesta,              //3
        "moneda_poliza" =>& $row->moneda_poliza,                //4
        "fecha_envio_propuesta" =>& $row->fecha_envio_propuesta,//5
        "vigencia_inicial" =>& $row->vigencia_inicial,          //6
        "vigencia_final"=>& $row->vigencia_final,               //7
        "compania" =>& $row->compania,                          //8
        "ramo" =>& $row->ramo,                                  //9
        "total_prima_afecta" =>& $row->total_prima_afecta,      //10
        "total_prima_exenta" =>& $row->total_prima_exenta,      //11
        "total_prima_neta" =>& $row->total_prima_neta,          //12
        "total_prima_bruta" =>& $row->total_prima_bruta,        //13       
        "nom_clienteP" =>& $row->nom_clienteP,                  //14
        "rut_clienteP" =>& $row->rut_clienteP,                  //15
        "telefonoP" =>& $row->telefonoP,                        //16
        "correoP" =>& $row->correoP,                            //17
        "idP" =>& $row->idP,                                    //18
        "grupo" =>& $row->grupo,                                //19
        "referido" =>& $row->referido,                          //20
        "id_propuesta"=>& $row->id_propuesta,                   //21
        "anomes_final" =>& $row->anomes_final,                  //22
        "anomes_inicial" =>& $row->anomes_inicial               //23
        ),
        $items_array));
    } else {
        $codigo.= ', '.json_encode(array_merge(array(
        "numero_propuesta" =>& $row->numero_propuesta,          //1
        "estado" =>& $row->estado,                              //2
        "tipo_propuesta" =>& $row->tipo_propuesta,              //3
        "moneda_poliza" =>& $row->moneda_poliza,                //4
        "fecha_envio_propuesta" =>& $row->fecha_envio_propuesta,//5
        "vigencia_inicial" =>& $row->vigencia_inicial,          //6
        "vigencia_final"=>& $row->vigencia_final,               //7
        "compania" =>& $row->compania,                          //8
        "ramo" =>& $row->ramo,                                  //9
        "total_prima_afecta" =>& $row->total_prima_afecta,      //10
        "total_prima_exenta" =>& $row->total_prima_exenta,      //11
        "total_prima_neta" =>& $row->total_prima_neta,          //12
        "total_prima_bruta" =>& $row->total_prima_bruta,        //13       
        "nom_clienteP" =>& $row->nom_clienteP,                  //14
        "rut_clienteP" =>& $row->rut_clienteP,                  //15
        "telefonoP" =>& $row->telefonoP,                        //16
        "correoP" =>& $row->correoP,                            //17
        "idP" =>& $row->idP,                                    //18
        "grupo" =>& $row->grupo,                                //19
        "referido" =>& $row->referido,                          //20
        "id_propuesta"=>& $row->id_propuesta,                   //21
        "anomes_final" =>& $row->anomes_final,                  //22
        "anomes_inicial" =>& $row->anomes_inicial               //23
        ),
        $items_array))
        ;
        }
    }
  $codigo.=']}';
  echo $codigo;

?>
