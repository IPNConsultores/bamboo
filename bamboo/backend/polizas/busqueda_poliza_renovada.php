<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$id_renovada=$_POST[ "renovar" ];
    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
    $sql = "select id, numero_poliza from polizas where id_poliza_renovada=".$id_renovada;
    $resultado=mysqli_query($link, $sql);
    While($row=mysqli_fetch_object($resultado))
  {
      
  }
?>