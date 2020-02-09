<?php
require_once "/home/asesori1/public_html/bamboo/backend/config.php";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["buscacliente"]))){
        $username_err = "Favor ingresa tu usuario.";
    } else{
        $username = trim($_POST["buscacliente"]);
    }

    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM usuarios_aplicacion WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: /bamboo/index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "La contraseña ingresada no es válida.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "El usuario y contraseña no coinciden.";
                }
            } else{
                echo "Oops! Algo salió mal. Favor intentar más tarde.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modificación Cliente</title>
<!-- Bootstrap -->
<link href="css/bootstrap-4.3.1.css" rel="stylesheet">
</head>
<body>
<!-- body code goes here -->

  <div class=  "container">
    <p> Clientes / Modificación <br>
    </p>
    <form class="needs-validation" novalidate method="POST" action="backend/busca_cliente.php">
      <h5 class="form-row">&nbsp;Buscador Cliente</h5>
      <br>
      <label for="Buscador">Rut sin DV o Nombre</label>
      <div class= "form-row; needs-validation">
        <div class= "col-md-4; form-inline">
          <input class="form-control" type="text" name="buscacliente" id="buscacliente" required>
          <button class="btn my-sm-0" style="background-color: #536656; color: white; margin-left:5px;" type="submit">Buscar</button>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco 
          </div>
        </div>
      </div>
    </form>
            <br>
    <form class="needs-validation" novalidate>
      <h5 class="form-row">&nbsp;Datos personales</h5>
      <br>
      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label for="Nombre">Nombre</label>
          <input type="text" class="form-control" id="Nombre"  required>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="ApellidoP">Apellido Paterno</label>
          <input type="text" class="form-control" id="ApellidoP" required>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="ApellidoM">Apellido Materno</label>
          <input type="text" class="form-control" id="ApellidoM" required>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="form-row">
            <div class ="col-md-8 mb-3">
              <label for="RUT">RUT</label>
              <input type="text" class="form-control" id="RUT" placeholder= "11111111" required>
              <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
            </div>
            <div class ="col-md-8 mb-3 col-xl-3">
              <label for="RUT">&nbsp;</label>
              <input type="text" class="form-control" id="DV" placeholder= "K" required>
              <div class="invalid-feedback"></div>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="validationCustomUsername">Mail</label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text" id="EMail">@</span> </div>
            <input type="email" class="form-control" id="Mail"  required>
            <div class="invalid-feedback"> Campo en blanco o sin formato mail (aaa@bbb.xxx) </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="Dirección">Dirección</label>
          <input type="text" class="form-control" id="Dirección" required>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
      </div>
      <button class="btn" type="submit" style="background-color: #536656; color: white">Modificar</button>
    </form>
  </div>
</body>
</html>