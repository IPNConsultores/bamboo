<?php
require_once "/home/gestio10/public_html/backend/config.php";
$resultado = '';
//if (isset($_POST['rut']) && !empty($_POST['rut']))
{ 
    $busqueda=17029236;
    echo $busqueda;
    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
        //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
    $sql = "SELECT id, nombre, apellidop, apellidom FROM clientes WHERE rut_sin_dv =".$busqueda.";";
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $resultado=mysqli_query($link,$sql);
    While($row=mysqli_fetch_object($resultado))
    {
        //Mostramos los titulos de los articulos o lo que deseemos...
        $rut=$row["rut"];
        $nombre=$row["nombre"];
        $apellidop=$row["apellidop"];
        $apellidom=$row["apellidom"];
        echo $apellidom;
       
        echo json_encode(array(
            "rut" =>& $rut,
            "nombre"=>& $nombre,
            "apellidop"=>& $apellidop,
            "apellidom"=>& $apellidom
        ));
        
    }
}
?>