<?php
$resultado =$codigo=$conta='';
require_once "/home/gestio10/public_html/backend/config.php";
    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $codigo='{
      "data": [';
    $conta=0;
    $resul_tareas=mysqli_query($link, "SELECT a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad, count(b.id) as relaciones, sum(CASE WHEN base ='polizas' THEN 1 ELSE 0 END) as polizas, sum(CASE WHEN base ='clientes' THEN 1 ELSE 0 END) as clientes FROM tareas as a left join tareas_relaciones as b on a.id=b.id_tarea group by a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad");
  While($tareas=mysqli_fetch_object($resul_tareas))
  {$conta=$conta+1;
    $relaciones=array("relaciones" =>& $tareas->relaciones, "clientes" =>& $tareas->clientes , "polizas" =>& $tareas->polizas);
    if (!$tareas->relaciones=="0"){
                    $contador_clientes=$contador_polizas=0;
        $result_relaciones=mysqli_query($link, "SELECT base, id_relacion FROM tareas_relaciones where id_tarea='".$tareas->id."';");
        while ($rel_tareas=mysqli_fetch_object($result_relaciones))
        {
            switch($rel_tareas->base){
                case "polizas":{
                    $resul_rel=mysqli_query($link, "SELECT  estado , compania, ramo, vigencia_inicial, vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura , CONCAT(b.nombre_cliente, ' ', b.apellido_paterno, ' ', b.apellido_materno) as nom_clienteP, CONCAT(b.rut_sin_dv, '-',b.dv) as rut_clienteP,b.telefono as telefonoP, b.correo as correoP, CONCAT(c.nombre_cliente, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nom_clienteA, CONCAT(c.rut_sin_dv, '-',c.dv) as rut_clienteA,c.telefono as telefonoA, c.correo as correoA, a.id as id_poliza, b.id as idP, c.id as idA FROM polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null where a.id='".$rel_tareas->id_relacion."' order by estado, vigencia_final asc;");
                    while($list_polizas=mysqli_fetch_object($resul_rel))
                    {
                        $contador_polizas=$contador_polizas+1;
                        $relaciones=array_merge($relaciones, array(
                            "ramo".$contador_polizas =>& $list_polizas->ramo,
                            "estado".$contador_polizas =>& $list_polizas->estado, 
                            "tipo_poliza".$contador_polizas =>& $list_polizas->tipo_poliza,
                            "vigencia_inicial".$contador_polizas =>& $list_polizas->vigencia_inicial,
                            "vigencia_final".$contador_polizas =>& $list_polizas->vigencia_final,
                            "compania".$contador_polizas =>& $list_polizas->compania,
                            "vigencia_final".$contador_polizas =>& $list_polizas->vigencia_final,
                            "numero_poliza".$contador_polizas =>& $list_polizas->numero_poliza,
                            "materia_asegurada".$contador_polizas =>& $list_polizas->materia_asegurada,
                            "patente_ubicacion".$contador_polizas =>& $list_polizas->patente_ubicacion,
                            "cobertura".$contador_polizas =>& $list_polizas->cobertura,
                            "nom_clienteP".$contador_polizas =>& $list_polizas->nom_clienteP,
                            "rut_clienteP".$contador_polizas =>& $list_polizas->rut_clienteP,
                            "telefonoP".$contador_polizas =>& $list_polizas->telefonoP,
                            "correoP".$contador_polizas =>& $list_polizas->correoP,
                            "nom_clienteA".$contador_polizas =>& $list_polizas->nom_clienteA,
                            "rut_clienteA" =>& $list_polizas->rut_clienteA,
                            "telefonoA".$contador_polizas =>& $list_polizas->telefonoA,
                            "correoA".$contador_polizas =>& $list_polizas->correoA,
                            "id_proponente".$contador_polizas =>& $list_polizas->idP,
                            "id_asegurado".$contador_polizas =>& $list_polizas->idA,
                            "id_poliza".$contador_polizas =>& $list_polizas->id_poliza
                            ));
                    }
                    break;
                }
                case "clientes":{
                    $resul_clientes=mysqli_query($link, "SELECT id, concat(nombre_cliente,' ', apellido_paterno, ' ', apellido_materno) as nombre, telefono, correo  FROM clientes where id='".$rel_tareas->id_relacion."';");
                  while($list_clientes=mysqli_fetch_object($resul_clientes)){
                      $contador_clientes=$contador_clientes+1;
                      $relaciones=array_merge($relaciones, array(
                        "id_cliente".$contador_clientes =>& $list_clientes->id,
                          "nombre".$contador_clientes =>& $list_clientes->nombre,
                          "telefono".$contador_clientes =>& $list_clientes->telefono,
                          "correo".$contador_clientes =>& $list_clientes->correo 
                          ));
                  }
                    break;
                }
            } 
        } 
    }
        if ($conta==1){
      $codigo.= json_encode(array_merge(array(
        "id_tarea" =>& $tareas->id,
        "fecingreso" =>& $tareas->fecha_ingreso,
        "fecvencimiento" =>& $tareas->fecha_vencimiento, 
        "tarea" =>& $tareas->tarea, 
        "estado" =>& $tareas->estado, 
        "prioridad" =>& $tareas->prioridad), 
        $relaciones));
    } else {
    $codigo.= ', '.json_encode(array_merge(array(
        "id_tarea" =>& $tareas->id,
        "fecingreso" =>& $tareas->fecha_ingreso,
        "fecvencimiento" =>& $tareas->fecha_vencimiento, 
        "tarea" =>& $tareas->tarea, 
        "estado" =>& $tareas->estado, 
        "prioridad" =>& $tareas->prioridad), 
        $relaciones)
    );}
  }
  $codigo.=']}';
  echo $codigo;
?>