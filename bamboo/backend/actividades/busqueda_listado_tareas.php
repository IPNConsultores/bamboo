<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$resultado =$codigo=$conta='';
require_once "/home/gestio10/public_html/backend/config.php";
    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $codigo='{
      "data": [';
    $conta=0;
    //$resul_tareas=mysqli_query($link, "SELECT a.id, DATE_FORMAT(fecha_ingreso, '%d-%m-%Y') as fecha_ingreso ,DATE_FORMAT(fecha_vencimiento, '%d-%m-%Y') as fecha_vencimiento, tarea, estado, prioridad, procedimiento, count(b.id) as relaciones, sum(CASE WHEN base ='polizas' THEN 1 ELSE 0 END) as polizas, sum(CASE WHEN base ='clientes' THEN 1 ELSE 0 END) as clientes FROM tareas as a left join tareas_relaciones as b on a.id=b.id_tarea WHERE estado not in ('Cerrado', 'Eliminado') group by a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad, procedimiento");
    $resul_tareas=mysqli_query($link, "SELECT a.id, fecha_ingreso ,fecha_vencimiento, tarea, estado, prioridad, procedimiento, count(b.id) as relaciones, sum(CASE WHEN base ='polizas' THEN 1 ELSE 0 END) as polizas, sum(CASE WHEN base ='clientes' THEN 1 ELSE 0 END) as clientes FROM tareas as a left join tareas_relaciones as b on a.id=b.id_tarea WHERE estado not in ('Cerrado', 'Eliminado') group by a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad, procedimiento");

    While($tareas=mysqli_fetch_object($resul_tareas))
  {$conta=$conta+1;
    $relaciones=array("relaciones" =>& $tareas->relaciones, "clientes" =>& $tareas->clientes , "polizas" =>& $tareas->polizas);
    if (!$tareas->relaciones=="0"){
                    $contador_clientes=$contador_polizas=0;
        $result_relaciones=mysqli_query($link, "SELECT base, id_relacion FROM tareas_relaciones where id_tarea='".$tareas->id."';");
        $ramo=$estado_alerta=$estado=$vigencia_inicial=$vigencia_final=$compania=$numero_poliza=$materia_asegurada=$patente_ubicacion=$cobertura=$nom_clienteP=$rut_clienteP=$telefonoP=$correoP=$nom_clienteA=$rut_clienteA=$telefonoA=$correoA=$id_proponente=$id_asegurado=$id_poliza=array();
 $id_cliente=$nombre=$telefono=$correo=array();
        while ($rel_tareas=mysqli_fetch_object($result_relaciones))
        {
            switch($rel_tareas->base){
                case "polizas":{
                    $resul_rel=mysqli_query($link, "SELECT estado , compania, ramo, DATE_FORMAT(vigencia_inicial, '%d-%m-%Y') as vigencia_inicial, DATE_FORMAT(vigencia_final, '%d-%m-%Y') as vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura , CONCAT_WS(' ',b.nombre_cliente, b.apellido_paterno, b.apellido_materno) as nom_clienteP, CONCAT_WS('-',b.rut_sin_dv, b.dv) as rut_clienteP,b.telefono as telefonoP, b.correo as correoP, CONCAT_WS(' ',c.nombre_cliente, c.apellido_paterno, ' ', c.apellido_materno) as nom_clienteA, CONCAT_WS('-',c.rut_sin_dv, c.dv) as rut_clienteA,c.telefono as telefonoA, c.correo as correoA, a.id as id_poliza, b.id as idP, c.id as idA FROM polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null where a.id='".$rel_tareas->id_relacion."' order by estado, vigencia_final asc;");

                    while($list_polizas=mysqli_fetch_object($resul_rel))
                    {
                      switch ($list_polizas->estado) {
                        case 'Activo':
                            $estado_pol='badge badge-primary';
                            break;
                        case 'Cerrado':
                              $estado_pol='badge badge-dark';
                              break;
                        default:
                            $estado_pol='badge badge-light';
                            break;
                    }
                        array_push($ramo, $list_polizas->ramo);
                        array_push($estado, $list_polizas->estado);
                        array_push($estado_alerta, $estado_pol);
                        array_push($vigencia_inicial, $list_polizas->vigencia_inicial);
                        array_push($vigencia_final, $list_polizas->vigencia_final);
                        array_push($compania, $list_polizas->compania);
                        array_push($numero_poliza, $list_polizas->numero_poliza);
                        array_push($materia_asegurada, $list_polizas->materia_asegurada);
                        array_push($patente_ubicacion, $list_polizas->patente_ubicacion);
                        array_push($cobertura, $list_polizas->cobertura);
                        array_push($nom_clienteP, $list_polizas->nom_clienteP);
                        array_push($rut_clienteP, $list_polizas->rut_clienteP);
                        array_push($telefonoP, $list_polizas->telefonoP);
                        array_push($correoP, $list_polizas->correoP);
                        array_push($nom_clienteA, $list_polizas->nom_clienteA);
                        array_push($rut_clienteA, $list_polizas->rut_clienteA);
                        array_push($telefonoA, $list_polizas->telefonoA);
                        array_push($correoA, $list_polizas->correoA);
                        array_push($id_proponente, $list_polizas->idP);
                        array_push($id_asegurado, $list_polizas->idA);
                        array_push($id_poliza, $list_polizas->id_poliza);
                    }
                        $relaciones=array_merge($relaciones, array(
                            "ramo" =>& $ramo,
                            "estado_poliza" =>& $estado,
                            "estado_poliza_alerta" =>& $estado_alerta, 
                            "tipo_poliza" =>& $tipo_poliza,
                            "vigencia_inicial" =>& $vigencia_inicial,
                            "vigencia_final" =>& $vigencia_final,
                            "compania" =>& $compania,
                            "numero_poliza" =>& $numero_poliza,
                            "materia_asegurada" =>& $materia_asegurada,
                            "patente_ubicacion" =>& $patente_ubicacion,
                            "cobertura" =>& $cobertura,
                            "nom_clienteP" =>& $nom_clienteP,
                            "rut_clienteP" =>& $rut_clienteP,
                            "telefonoP" =>& $telefonoP,
                            "correoP" =>& $correoP,
                            "nom_clienteA" =>& $nom_clienteA,
                            "rut_clienteA" =>& $rut_clienteA,
                            "telefonoA" =>& $telefonoA,
                            "correoA" =>& $correoA,
                            "id_proponente" =>& $id_proponente,
                            "id_asegurado" =>& $id_asegurado,
                            "id_poliza" =>& $id_poliza
                            ));
                    
                    
                    break;
                }
                case "clientes":{
                    $resul_clientes=mysqli_query($link, "SELECT id, concat_WS(' ',nombre_cliente, apellido_paterno, apellido_materno) as nombre, telefono, correo  FROM clientes where id='".$rel_tareas->id_relacion."';");


                  while($list_clientes=mysqli_fetch_object($resul_clientes)){
                                                array_push($id_cliente, $list_clientes->id);
                          array_push($nombre, $list_clientes->nombre);
                          array_push($telefono, $list_clientes->telefono);
                          array_push($correo, $list_clientes->correo );
                  }
                        $relaciones=array_merge($relaciones, array(
                        "id_cliente" =>& $id_cliente,
                          "nombre" =>& $nombre,
                          "telefono" =>& $telefono,
                          "correo" =>& $correo 
                          ));
                    break;
                }
            } 
        } 
    }
    switch ($tareas->estado) {
      case 'Pendiente':
          $estado_sw='badge badge-primary';
          break;
      case 'Completado':
              $estado_sw='badge badge-secondary';
              break;
      case 'Atrasado':
          $estado_sw='badge badge-danger';
          break;
      case 'Próximo a vencer':
          $estado_sw='badge badge-warning';
          break;
      default:
          $estado_sw='badge badge-light';
          break;
  }
        if ($conta==1){
      $codigo.= json_encode(array_merge(array(
        "id_tarea" =>& $tareas->id,
        "fecingreso" =>& $tareas->fecha_ingreso,
        "fecvencimiento" =>& $tareas->fecha_vencimiento, 
        "tarea" =>& $tareas->tarea, 
        "estado" =>& $tareas->estado, 
        "estado_alerta" =>& $estado_sw,
        "procedimiento" =>& $tareas->procedimiento,
        "prioridad" =>& $tareas->prioridad), 
        $relaciones));
    } else {
    $codigo.= ', '.json_encode(array_merge(array(
        "id_tarea" =>& $tareas->id,
        "fecingreso" =>& $tareas->fecha_ingreso,
        "fecvencimiento" =>& $tareas->fecha_vencimiento, 
        "tarea" =>& $tareas->tarea, 
        "estado" =>& $tareas->estado, 
        "estado_alerta" =>& $estado_sw,
        "procedimiento" =>& $tareas->procedimiento,
        "prioridad" =>& $tareas->prioridad), 
        $relaciones)
    );}
  }
  $codigo.=']}';
  echo $codigo;
?>