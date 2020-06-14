<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $prioridad = $_POST["prioridad"];
    $fechavencimiento = $_POST["fechavencimiento"];
    $tarea = $_POST["tarea"];
    $relaciones = $_POST["relaciones"];
    
    $tarea_recurrente = $_POST["tarea_recurrente"];
    $tarea_con_fin = $_POST["tarea_con_fin"];
    $dia = $_POST["dia"];
     
    if($tarea_con_fin==1)
    {
        $fecha='\''.$_POST["fecha"].'\'';
    }
    else
    {
        $fecha='null';
    }
    
    
    $obj = json_decode($relaciones, true);
    echo "prioridad-".$prioridad . "<br>";
    echo "fechavencimiento-".$fechavencimiento . "<br>";
    echo "tarea-".$tarea . "<br>";
    echo "tarea_recurrente-".$tarea_recurrente . "<br>";
    echo "tarea_con_fin-".$tarea_con_fin . "<br>";
    echo "dia-".$dia . "<br>";
    echo "fecha-".$fecha . "<br>";
    $largo = 6;
    
    //crea tarea recurrente si aplica
     
if ($tarea_recurrente==0){
    
    //crea token
    $token = bin2hex(random_bytes($largo));

    //crea tarea
    mysqli_query($link, 'insert into tareas(fecha_vencimiento, tarea, prioridad, token) values (\'' . $fechavencimiento . '\', \'' . $tarea . '\', \'' . $prioridad . '\', \'' . $token . '\');');

    //rescata id
    $resultado = mysqli_query($link, 'select id from tareas where  token=\'' . $token . '\';');

    while ($fila = mysqli_fetch_object($resultado))
    {
        // printf ("%s (%s)\n", $fila->id);
        $id_tarea = $fila->id;
    }

    //recorre arreglo relaciones
    foreach ($obj as $key => $value)
    {
        mysqli_query($link, 'insert into tareas_relaciones (id_tarea, base, id_relacion) values (' . $id_tarea . ', \'' . $value["base"] . '\',' . $value["id"] . ');');
    }
    //elimina token
    mysqli_query($link, 'update tareas set token=null where token=\'' . $token . '\';');
    
}
else
{
    mysqli_query($link, 'insert into tareas_recurrentes(estado,tarea, prioridad, fecha_ingreso,recurrente,tarea_con_fecha_fin,fecha_fin,dia_recordatorio) values (\'Activo\' , \'' . $tarea . '\', \'' . $prioridad . '\', current_date, '.$tarea_recurrente.' , '.$tarea_con_fin.' , ' .$fecha.' , '.$dia.');');
   // echo 'insert into tareas_recurrentes(tarea, prioridad, fecha_ingreso,recurrente,tarea_con_fecha_fin,fecha_fin,dia_recordatorio) values (\'' . $tarea . '\', \'' . $prioridad . '\', current_date, '.$tarea_recurrente.' , '.$tarea_con_fin.' , ' .$fecha.' , '.$dia.');';
    
}

}
// vuelve al index
//header("location: /bamboo/index.php");

function estandariza_info($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
