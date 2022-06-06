<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $sql = "SELECT a.numero_poliza, estado, DATE_FORMAT(vigencia_final,'%m-%Y') as anomes_final, DATE_FORMAT(vigencia_inicial,'%m-%Y')  as anomes_inicial, moneda_poliza, compania, ramo,  vigencia_inicial, vigencia_final,  CONCAT_WS(' ',b.nombre_cliente,  b.apellido_paterno, ' ', b.apellido_materno) as nom_clienteP, CONCAT_WS('-',b.rut_sin_dv, b.dv) as rut_clienteP,b.telefono as telefonoP, b.correo as correoP, a.id as id_poliza, b.id as idP, fecha_envio_propuesta, b.grupo, b.referido, CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_afecta), 2, 'de_DE')) as total_prima_afecta,  CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_exenta), 2, 'de_DE')) as total_prima_exenta, CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_neta), 2, 'de_DE')) as total_prima_neta, CONCAT_WS(' ',a.moneda_poliza,FORMAT(sum(c.prima_bruta_anual), 2, 'de_DE')) as total_prima_bruta  FROM polizas_2 as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join items as c on a.numero_poliza=c.numero_poliza where a.estado not in ('Rechazado', 'Anulado', 'Cancelado')
group by a.numero_poliza, estado, DATE_FORMAT(vigencia_final,'%m-%Y') , DATE_FORMAT(vigencia_inicial,'%m-%Y') , moneda_poliza, compania, ramo,  vigencia_inicial, vigencia_final,   CONCAT_WS(' ',b.nombre_cliente,  b.apellido_paterno, ' ', b.apellido_materno) , CONCAT_WS('-',b.rut_sin_dv, b.dv) ,b.telefono , b.correo , a.id , b.id , fecha_envio_propuesta, b.grupo, b.referido  ";
  
$resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
    {   
        $conta=$conta+1;
    //$resultado contiene propuestas, a cada una de estas líneas hay que asignar un array con los ítem asociados
        //echo "primera query -> nro_propuesta: ".$row->numero_poliza."<br>";
        $resultado_contador_contactos=mysqli_query($link, "SELECT count(numero_item) as contador FROM items where numero_poliza='".$row->numero_poliza."';");
        while ($fila=mysqli_fetch_object($resultado_contador_contactos))
        {
        //echo "segunda query -> contador: ".$fila->contador."<br>";
        $contador_contactos=0;
        $items=[];
        $cant_items=$fila->contador;
        $resultado_items=mysqli_query($link, "select a.numero_poliza, a.numero_item, a.id as id_item, a.materia_asegurada, a.patente_ubicacion, a.cobertura , a.deducible, CONCAT_WS(' ',FORMAT(tasa_afecta, 2, 'de_DE'),'%') AS tasa_afecta, CONCAT_WS(' ',FORMAT(tasa_exenta, 2, 'de_DE'),'%') AS tasa_exenta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_afecta, 2, 'de_DE')) AS prima_afecta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_exenta, 2, 'de_DE')) AS prima_exenta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_bruta_anual, 2, 'de_DE')) AS prima_bruta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(prima_neta, 2, 'de_DE')) AS prima_neta, CONCAT_WS(' ',b.moneda_poliza,FORMAT(a.monto_asegurado, 2, 'de_DE')) AS monto_asegurado, if(a.venc_gtia='0000-00-00','',a.venc_gtia) as venc_gtia, CONCAT_WS(' ',c.nombre_cliente,  c.apellido_paterno,  c.apellido_materno) as nom_clienteA, CONCAT_WS('-',c.rut_sin_dv, c.dv) as rut_clienteA,c.telefono as telefonoA, c.correo as correoA from items as a left join clientes as c  on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null left join polizas_2 as b on a.numero_poliza=b.numero_poliza where a.numero_poliza='".$row->numero_poliza."';");
            $items_array=array("total_items"=>& $fila->contador);
            if (!$cant_items=="0"){
        while($indice=mysqli_fetch_object($resultado_items)){
            //echo "tercera query -> nropropuesta: ".$row->numero_poliza."- ítem nro: ".$indice->id_item."<br>";
            
            $contador_contactos=$contador_contactos+1;
            array_push($items, array(
                "numero_item" =>& $indice->numero_item,
                "materia_asegurada" =>& $indice->materia_asegurada,
                "patente_ubicacion" =>& $indice->patente_ubicacion,
                "cobertura" =>& $indice->cobertura,
                "deducible" =>& $indice->deducible,
                "tasa_afecta" =>& $indice->tasa_afecta,
                "tasa_exenta" =>& $indice->tasa_exenta,
                "prima_afecta" =>& $indice->prima_afecta,
                "prima_exenta" =>& $indice->prima_exenta,
                "prima_neta" =>& $indice->prima_neta,
                "prima_bruta" =>& $indice->prima_bruta,
                "nom_clienteA" =>& $indice->nom_clienteA,
                "rut_clienteA" =>& $indice->rut_clienteA,
                "telefonoA" =>& $indice->telefonoA,
                "correoA" =>& $indice->correoA,
                "venc_gtia" =>& $indice->venc_gtia,
                "monto_asegurado" =>& $indice->monto_asegurado
                ));
            
        }

            }
        
        }
    if ($conta==1){
      $codigo.= json_encode(array_merge(array(
        "numero_poliza" =>& $row->numero_poliza,          //1
        "estado" =>& $row->estado,                              //2
        "tipo_propuesta" =>& $row->tipo_propuesta,              //3
        "moneda_poliza" =>& $row->moneda_poliza,                //4
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
        "id_poliza"=>& $row->id_poliza,                   //21
        "anomes_final" =>& $row->anomes_final,                  //22
        "anomes_inicial" =>& $row->anomes_inicial,              //23
        "items" =>&$items                                       //24
        ),
        $items_array));
    } else {
        $codigo.= ', '.json_encode(array_merge(array(
        "numero_poliza" =>& $row->numero_poliza,          //1
        "estado" =>& $row->estado,                              //2
        "tipo_propuesta" =>& $row->tipo_propuesta,              //3
        "moneda_poliza" =>& $row->moneda_poliza,                //4
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
        "id_poliza"=>& $row->id_poliza,                   //21
        "anomes_final" =>& $row->anomes_final,                  //22
        "anomes_inicial" =>& $row->anomes_inicial,               //23
        "items" =>&$items//23
        ),
        $items_array))
        ;
        }
    }
  $codigo.=']}';
  mysqli_close($link);
  echo $codigo;

?>
