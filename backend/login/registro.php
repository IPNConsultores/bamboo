<?php
// Include config file
require_once "/home/gestio10/public_html/backend/config.php";
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Favor ingresar usuario.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM usuarios_aplicacion WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "";
                    echo '<script type="text/javascript">alerta("El usuario ya esta utilizado." ,"warning");</script>'; 
 
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo '<script type="text/javascript">alerta("Oops! Algo salió mal. Favor intentar más tarde." ,"warning");</script>'; 
 
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
         echo '<script type="text/javascript">alerta("Favor ingresar contraseña." ,"warning");</script>'; 
 
    } elseif(strlen(trim($_POST["password"])) < 8){
  echo '<script type="text/javascript">alerta("La contraseña debe tener al menos 8 caracteres." ,"warning");</script>'; 
   
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        echo '<script type="text/javascript">alerta("Favor confirmar contraseña." ,"warning");</script>'; 
   
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
               echo '<script type="text/javascript">alerta("Ambas contraseñas no coinciden." ,"warning");</script>'; 
 
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO usuarios_aplicacion (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo '<script type="text/javascript">alerta("Usuario creado con éxito" ,"success");</script>'; 
 
                header("location: /bamboo/index.php");
            } else{
                echo '<script type="text/javascript">alerta("Oops! Algo salió mal. Favor intentar más tarde." ,"warning");</script>'; 
 
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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="/assets/js/bootstrap-notify.js"></script>
    <script src="/assets/js/bootstrap-notify.min.js"></script>
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
    <title>Registro de nuevo usuario</title>
</head>

<body>
<div id="header"><?php  require_once '/home/gestio10/public_html/bamboo/header2.php' ?></div>
    <div class="modal-dialog modal-login">
        <div class="modal-content col-lg-10">
            <div class="modal-header">
                <h4 class="modal-title">Inicio de Sesión</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                    <!--<div class="form-group ?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">-->
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <!--?php echo $username_err; ?-->
                                <i class="fa fa-user"></i>
                            </span>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Usuario"
                                value="<?php echo $username; ?>" required="required">
                        </div>
                    </div>

                    <!--div class="form-group ?php echo (!empty($password_err)) ? 'has-error' : ''; ?>"-->
                    <div class="form-group">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Contraseña" required="required" value="<?php echo $password; ?>">
                            <span class="help-block">
                                <!--?php echo $password_err; ?--></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                                placeholder="Repetir Contraseña" required="required"
                                value="<?php echo $confirm_password; ?>">
                            <span class="help-block">
                                <!--?php echo $password_err; ?--></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Crear usuario">
                    </div>
                    <p>Ya tienes una cuenta? <a href="/bamboo/backend/login/login.php">Ingresa aquí</a>.</p>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<script>
function alerta(mensaje, tipo) {
    $.notify({
        // options
        message: mensaje
    }, {
        // settings
        type: tipo
    });
}
</script>