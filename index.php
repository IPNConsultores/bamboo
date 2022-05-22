<?php
// Initialize the session
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
// Check if the user is logged in, if not then redirect him to login page
if ( !isset( $_SESSION[ "loggedin" ] ) || $_SESSION[ "loggedin" ] !== true ) {
  header( "location: /backend/login/login.php" );
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
    <title>Gestión IPN</title>
</head>

<body>

    <div id="contenido_index">
        <p>Index</p>
    </div>
</body>

</html>
INSERT INTO endosos(numero_endoso, id_poliza, numero_propuesta_endoso, fecha_ingreso_endoso, tipo_endoso, ramo, compania, numero_poliza, rut_proponente, dv_proponente, nombre_proponente, vigencia_inicial, vigencia_final, descripcion_endoso, dice, debe_decir, monto_asegurado_endoso, moneda_poliza_endoso, tasa_afecta_endoso, tasa_exenta_endoso, prima_neta_exenta, IVA, prima_neta_afecta, prima_total) VALUES ('','685','','2022-05-19','Endoso Aumento','RC General','CHUBB','test poliza 14 may 1346','17500772','5','Catherine Alejandra Pereira García','2022-05-04','2023-05-05','descripción modificada','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s. when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. but also the leap into electronic typesetting. remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages. and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum','debe decir modificado en creación de endoso','350.00','UF','5','5','80.00','2','58.00','140')