<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$resultado =$codigo=$conta='';
require_once "/home/gestio10/public_html/backend/config.php";
    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
    $codigo='{
      "data": [';
    $conta=0;
    //$resul_tareas=mysqli_query($link, "SELECT a.id, DATE_FORMAT(fecha_ingreso, '%d-%m-%Y') as fecha_ingreso ,DATE_FORMAT(fecha_vencimiento, '%d-%m-%Y') as fecha_vencimiento, tarea, estado, prioridad, procedimiento, count(b.id) as relaciones, sum(CASE WHEN base ='polizas' THEN 1 ELSE 0 END) as polizas, sum(CASE WHEN base ='clientes' THEN 1 ELSE 0 END) as clientes FROM tareas as a left join tareas_relaciones as b on a.id=b.id_tarea WHERE estado not in ('Cerrado', 'Eliminado') group by a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad, procedimiento");
    $resul_tareas=mysqli_query($link, "SELECT a.id, fecha_ingreso ,fecha_vencimiento, tarea, estado, prioridad, procedimiento, count(b.id) as relaciones, sum(CASE WHEN base ='polizas' THEN 1 ELSE 0 END) as polizas, sum(CASE WHEN base ='clientes' THEN 1 ELSE 0 END) as clientes,sum(CASE WHEN base ='propuestas' THEN 1 ELSE 0 END) as propuestas FROM tareas as a left join tareas_relaciones as b on a.id=b.id_tarea WHERE estado not in ('Cerrado', 'Eliminado') group by a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad, procedimiento");

    While($tareas=mysqli_fetch_object($resul_tareas))
  {$conta=$conta+1;
    $relaciones=array("relaciones" =>& $tareas->relaciones, "clientes" =>& $tareas->clientes , "polizas" =>& $tareas->polizas, "propuestas" =>& $tareas->propuestas);
    if (!$tareas->relaciones=="0"){
        $contador_clientes=$contador_polizas=0;
        $result_relaciones=mysqli_query($link, "SELECT base, id_relacion FROM tareas_relaciones where id_tarea='".$tareas->id."';");
        $ramo=$estado_alerta=$estado=$vigencia_inicial=$vigencia_final=$compania=$numero_poliza=$materia_asegurada=$patente_ubicacion=$cobertura=$nom_clienteP=$rut_clienteP=$telefonoP=$correoP=$nom_clienteA=$rut_clienteA=$telefonoA=$correoA=$id_proponente=$id_asegurado=$id_poliza=$numero_propuesta=array();
        $id_cliente=$nombre=$telefono=$correo=array();
        while ($rel_tareas=mysqli_fetch_object($result_relaciones))
        {
            switch($rel_tareas->base){
                case "polizas":{
                    $resul_rel=mysqli_query($link, "SELECT a.id as id_poliza, estado , DATE_FORMAT(vigencia_inicial, '%d-%m-%Y') as vigencia_inicial, DATE_FORMAT(vigencia_final, '%d-%m-%Y') as vigencia_final, numero_poliza FROM polizas_2 as a where a.id='".$rel_tareas->id_relacion."' order by estado, vigencia_final asc");

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
                        array_push($estado, $list_polizas->estado);
                        array_push($estado_alerta, $estado_pol);
                        array_push($vigencia_inicial, $list_polizas->vigencia_inicial);
                        array_push($vigencia_final, $list_polizas->vigencia_final);
                        array_push($numero_poliza, $list_polizas->numero_poliza);
                        array_push($id_poliza, $list_polizas->id_poliza);
                    }
                        $relaciones=array_merge($relaciones, array(
                            "estado_poliza" =>& $estado,
                            "estado_poliza_alerta" =>& $estado_alerta, 
                            "vigencia_inicial" =>& $vigencia_inicial,
                            "vigencia_final" =>& $vigencia_final,
                            "numero_poliza" =>& $numero_poliza,
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
                case "propuestas":{
                    $resul_rel=mysqli_query($link, "SELECT estado , DATE_FORMAT(vigencia_inicial, '%d-%m-%Y') as vigencia_inicial, DATE_FORMAT(vigencia_final, '%d-%m-%Y') as vigencia_final, numero_propuesta FROM propuesta_polizas_2 as a  where a.id='".$rel_tareas->id_relacion."' order by estado, vigencia_final asc");

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
                        array_push($estado, $list_polizas->estado);
                        array_push($estado_alerta, $estado_pol);
                        array_push($vigencia_inicial, $list_polizas->vigencia_inicial);
                        array_push($vigencia_final, $list_polizas->vigencia_final);
                        array_push($numero_propuesta, $list_polizas->numero_propuesta);
                    }
                        $relaciones=array_merge($relaciones, array(
                            "estado_propuesta" =>& $estado,
                            "estado_propuesta_alerta" =>& $estado_alerta, 
                            "vigencia_inicial" =>& $vigencia_inicial,
                            "vigencia_final" =>& $vigencia_final,
                            "numero_propuesta" =>& $numero_propuesta
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