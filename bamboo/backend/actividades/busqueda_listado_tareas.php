<?php
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
    $sql = "select prioridad, estado, tarea, fecha_vencimiento, id_poliza as poliza, CONCAT(nombre_cliente, ' ', apellido_paterno, ' ', apellido_materno) as nom_cliente, CONCAT(rut_sin_dv, '-',dv) as rut_cliente, telefono, correo, a.id as id_tarea from tareas as a left join clientes as b on a.id_cliente=b.rut_sin_dv and b.rut_sin_dv is not null";
    $resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
  {$conta=$conta+1;
    if ($conta==1){
      $codigo.= json_encode(array(
        "prioridad" =>& $row->prioridad,
        "estado"=>& $row->estado,
        "tarea"=>& $row->tarea,
        "fecha_vencimiento"=>& $row->fecha_vencimiento,
        "poliza" =>& $row->poliza,
        "nom_cliente" =>& $row->nom_cliente,
        "rut_cliente" =>& $row->rut_cliente,
        "telefono" =>& $row->telefono,
        "correo" =>& $row->correo,
        "id_tarea" =>& $row->id_tarea));
    } else {
    $codigo.= ', '.json_encode(array(
      "prioridad" =>& $row->prioridad,
      "estado"=>& $row->estado,
      "tarea"=>& $row->tarea,
      "fecha_vencimiento"=>& $row->fecha_vencimiento,
      "poliza" =>& $row->poliza,
      "nom_cliente" =>& $row->nom_cliente,
      "rut_cliente" =>& $row->rut_cliente,
      "telefono" =>& $row->telefono,
      "correo" =>& $row->correo,
      "id_tarea" =>& $row->id_tarea
    ));}
  }
  $codigo.=']}';
  echo $codigo;
?>