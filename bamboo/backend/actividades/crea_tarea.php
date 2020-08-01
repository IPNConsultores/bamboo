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
    $modificar = $_POST["modificar"];
    $id_tarea = $_POST["id_tarea"];
    if($modificar=='update')
    {
        if($tarea_con_fin==1)
        {
            $fecha='\''.$_POST["fecha"].'\'';
        }
        else
        {
            $fecha='null';
        }

        if ($tarea_recurrente==0){
            $query_actualiza="update tareas set fecha_vencimiento='".$fechavencimiento."', tarea='".$tarea."', prioridad='". $prioridad . "' where id=".$id_tarea;
            mysqli_query($link, $query_actualiza);
            mysqli_query($link, "update tareas set estado='Activo' where estado='atrasado' and fecha_vencimiento>=CURRENT_DATE and id=".$id_tarea );
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza tarea', '".str_replace("'","**",$query_actualiza)."','tarea',".$id_tarea.", '".$_SERVER['PHP_SELF']."')");
        //echo "select trazabilidad('".$_SESSION["username"]."', 'Actualiza tarea', '".str_replace("'","**",$query_actualiza)."','tarea',".$id_tarea.", '".$_SERVER['PHP_SELF']."')";
        }
        else
        {
            $query_actualiza_recurrente="update tareas_recurrentes set tarea='".$tarea."', prioridad='". $prioridad . "', fecha_fin=".$fecha." ,dia_recordatorio='".$dia."' where id=".$id_tarea;
            mysqli_query($link, $query_actualiza_recurrente);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza tarea recurrente', '".str_replace("'","**",$query_actualiza_recurrente)."','tarea recurrente',".$id_tarea.", '".$_SERVER['PHP_SELF']."')");
            //echo "select trazabilidad('".$_SESSION["username"]."', 'Actualiza tarea recurrente', '".str_replace("'","**",$query_actualiza_recurrente)."','tarea recurrente',".$id_tarea.", '".$_SERVER['PHP_SELF']."')";
        }

    }
     else
     {
        if($tarea_con_fin==1)
        {
            $fecha='\''.$_POST["fecha"].'\'';
        }
        else
        {
            $fecha='null';
        }
        
        
        $obj = json_decode($relaciones, true);
        /*
        echo "prioridad-".$prioridad . "<br>";
        echo "fechavencimiento-".$fechavencimiento . "<br>";
        echo "tarea-".$tarea . "<br>";
        echo "tarea_recurrente-".$tarea_recurrente . "<br>";
        echo "tarea_con_fin-".$tarea_con_fin . "<br>";
        echo "dia-".$dia . "<br>";
        echo "fecha-".$fecha . "<br>";
        */
        $largo = 6;
        //crea token
        $token = bin2hex(random_bytes($largo));
        //crea tarea recurrente si aplica
         
    if ($tarea_recurrente==0){
        
 
    
        //crea tarea
        $query_crea_tarea='insert into tareas(procedimiento,fecha_vencimiento, tarea, prioridad, token) values (\'Manual\' ,\'' . $fechavencimiento . '\', \'' . $tarea . '\', \'' . $prioridad . '\', \'' . $token . '\');';
        mysqli_query($link, $query_crea_tarea);
    
        //rescata id
        $resultado = mysqli_query($link, 'select id from tareas where  token=\'' . $token . '\';');
    
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_tarea = $fila->id;
        }
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega tarea', '".str_replace("'","**",$query_crea_tarea)."','tarea',".$id_tarea.", '".$_SERVER['PHP_SELF']."')");
        //echo "select trazabilidad('".$_SESSION["username"]."', 'Agrega tarea', '".str_replace("'","**",$query_crea_tarea)."','tarea',".$id_tarea.", '".$_SERVER['PHP_SELF']."')";
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
        $token = bin2hex(random_bytes($largo));
        $query_crea_tarea_recurrente='insert into tareas_recurrentes( token, estado,tarea, prioridad, fecha_ingreso,recurrente,tarea_con_fecha_fin,fecha_fin,dia_recordatorio) values ( \'' . $token . '\' ,\'Activo\' , \'' . $tarea . '\', \'' . $prioridad . '\', current_date, '.$tarea_recurrente.' , '.$tarea_con_fin.' , ' .$fecha.' , '.$dia.');';
        mysqli_query($link, $query_crea_tarea_recurrente);
        $resultado = mysqli_query($link, 'select id from tareas_recurrentes where  token=\'' . $token . '\';');
    
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_tarea = $fila->id;
        }
       // echo 'insert into tareas_recurrentes(tarea, prioridad, fecha_ingreso,recurrente,tarea_con_fecha_fin,fecha_fin,dia_recordatorio) values (\'' . $tarea . '\', \'' . $prioridad . '\', current_date, '.$tarea_recurrente.' , '.$tarea_con_fin.' , ' .$fecha.' , '.$dia.');';
       mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega tarea recurrente', '".str_replace("'","**",$query_crea_tarea_recurrente)."','tarea recurrente',".$id_tarea.", '".$_SERVER['PHP_SELF']."')");
       // echo "select trazabilidad('".$_SESSION["username"]."', 'Agrega tarea recurrente', '".str_replace("'","**",$query_crea_tarea_recurrente)."','tarea recurrente',null, '".$_SERVER['PHP_SELF']."')";
 
       foreach ($obj as $key => $value)
       {
           mysqli_query($link, 'insert into tareas_relaciones (id_tarea_recurrente, base, id_relacion) values (' . $id_tarea . ', \'' . $value["base"] . '\',' . $value["id"] . ');');
       }
       //elimina token
       mysqli_query($link, 'update tareas_recurrentes set token=null where token=\'' . $token . '\';');
       
    }

}
}

function estandariza_info($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js">
    </script>
<script src="/assets/js/jquery.redirect.js">
</script>
</head>
<body>
<script >


	
var tarea_recurrente= '<?php echo $tarea_recurrente; ?>';
var id_tarea= '<?php echo $id_tarea; ?>';
var modificar = '<?php echo $modificar; ?>'
	
if(modificar =="update"){
	
	alert("Tarea Modificada Correctamente");
}
	else{
alert("Tarea Creada Correctamente");
		}
	$modificar=='update'
if (tarea_recurrente==true){
    $.redirect('/bamboo/listado_tareas_recurrentes.php', {
  'tarea': id_tarea
}, 'GET');
}
else
{
    $.redirect('/bamboo/listado_tareas.php', {
  'tarea': id_tarea
}, 'GET');
}


</script>
</body>
</html>