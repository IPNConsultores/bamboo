<?php
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
$sql = "SELECT CONCAT(rut_sin_dv, '-',dv) as rut, apellido_paterno, concat(nombre_cliente ,' ', apellido_paterno,' ', apellido_materno) as nombre, correo, direccion_laboral, direccion_personal, id, telefono, fecha_ingreso, referido, grupo FROM clientes";
    $resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
  {$conta=$conta+1;
    $resultado_contador_contactos=mysqli_query($link, "SELECT count(*) as contador FROM clientes_contactos where id_cliente='".$row->id."';");
    while ($fila=mysqli_fetch_object($resultado_contador_contactos))
    {
        $contador_contactos=0;
      $cant_contactos=$fila->contador;
      $resultado_contactos=mysqli_query($link, "SELECT  nombre,telefono, correo FROM clientes_contactos where id_cliente='".$row->id."';");
        $contactos_array=array("contactos"=>&$fila->contador);
        if ($cant_contactos=="7"){
      while($indice=mysqli_fetch_object($resultado_contactos)){
          $contador_contactos=$contador_contactos+1;
          $contactos_array=array_merge($contactos_array, array(
              "nombre".$contador_contactos =>& $indice->nombre,
              "telefono".$contador_contactos =>& $indice->telefono,
              "correo".$contador_contactos =>& $indice->correo 
              ));
      }}
      
    }
        if ($conta==1){
      $codigo.= json_encode(array_merge(array(
        "id" =>& $row->id,
        "nombre"=>& $row->nombre,
        "apellidop"=>& $row->apellido_paterno,
        "correo_electronico" =>& $row->correo,
        "direccionl" =>& $row->direccion_laboral,
        "direccionp" =>& $row->direccion_personal,
        "telefono" =>& $row->telefono,
        "fecingreso" =>& $row->fecha_ingreso,
        "referido" =>& $row->referido,
        "grupo" =>& $row->grupo,
        "rut" =>& $row->rut), 
        $contactos_array));
    } else {
    $codigo.= ', '.json_encode(array_merge(array(
      "id" =>& $row->id,
      "nombre"=>& $row->nombre,
      "apellidop"=>& $row->apellido_paterno,
      "correo_electronico" =>& $row->correo,
      "direccionl" =>& $row->direccion_laboral,
      "direccionp" =>& $row->direccion_personal,
      "telefono" =>& $row->telefono,
      "fecingreso" =>& $row->fecha_ingreso,
      "referido" =>& $row->referido,
      "grupo" =>& $row->grupo,
      "rut" =>& $row->rut), 
        $contactos_array)
    );}
  }
  $codigo.=']}';
  echo $codigo;
?>