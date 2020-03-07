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
<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /bamboo/index.php");
    exit;
}
 
// Include config file
require_once "/home/gestio10/public_html/backend/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Favor ingresa tu usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Favor ingresa tu contraseña.";
    } else{
        $password = trim($_POST["password"]);
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
                            $_SESSION["auxiliar"]="";
                            // Redirect user to welcome page
                            header("location: /bamboo/index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "La contraseña ingresada no es válida.";
                            echo '<script type="text/javascript">alerta("La contraseña ingresada no es válida." ,"warning");</script>'; 

                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
	echo '<script type="text/javascript">alerta("El usuario y contraseña no coinciden." ,"warning");</script>'; 
                }
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
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-notify.js"></script>
    <script src="/assets/js/bootstrap-notify.min.js"></script>
    <style type="text/css">
    body {
        font-family: 'Varela Round', sans-serif;
    }

    .modal-login {
        width: 350px;
    }

    .modal-login .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
    }

    .modal-login .modal-header {
        border-bottom: none;
        position: relative;
        justify-content: center;
    }

    .modal-login .close {
        position: absolute;
        top: -10px;
        right: -10px;
    }

    .modal-login h4 {
        color: #636363;
        text-align: center;
        font-size: 26px;
        margin-top: 0;
    }

    .modal-login .modal-content {
        color: #999;
        border-radius: 1px;
        margin-bottom: 15px;
        background: #fff;
        border: 1px solid #f3f3f3;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 25px;
    }

    .modal-login .form-group {
        margin-bottom: 20px;
    }

    .modal-login label {
        font-weight: normal;
        font-size: 13px;
    }

    .modal-login .form-control {
        min-height: 38px;
        padding-left: 5px;
        box-shadow: none !important;
        border-width: 0 0 1px 0;
        border-radius: 0;
    }

    .modal-login .form-control:focus {
        border-color: #ccc;
    }

    .modal-login .input-group-addon {
        max-width: 42px;
        text-align: center;
        background: none;
        border-width: 0 0 1px 0;
        padding-left: 5px;
        border-radius: 0;
    }

    .modal-login .btn {
        font-size: 16px;
        font-weight: bold;
        background: #19aa8d;
        border-radius: 3px;
        border: none;
        min-width: 140px;
        outline: none !important;
    }

    .modal-login .btn:hover,
    .modal-login .btn:focus {
        background: #179b81;
    }

    .modal-login .hint-text {
        text-align: center;
        padding-top: 5px;
        font-size: 13px;
    }

    .modal-login .modal-footer {
        color: #999;
        border-color: #dee4e7;
        text-align: center;
        margin: 0 -25px -25px;
        font-size: 13px;
        justify-content: center;
    }

    .modal-login a {
        color: #fff;
        text-decoration: underline;
    }

    .modal-login a:hover {
        text-decoration: none;
    }

    .modal-login a {
        color: #19aa8d;
        text-decoration: none;
    }

    .modal-login a:hover {
        text-decoration: underline;
    }

    .modal-login .fa {
        font-size: 21px;
    }

    .trigger-btn {
        display: inline-block;
        margin: 100px auto;
    }
    </style>
</head>

<body>
    <div class="container" style="overflow:auto;  background-color: #536656; ">
        <p class="h6" style=" color:white; text-align: center"><img src="http://www.bambooseguros.cl/img/logo-2.png"
                width="80" class="img-fluid" style="float: left; margin-bottom: 10px"></p>
        <p class="h2" style=" color:white; text-align: center">&nbsp; </p>
    </div>
    <div class="modal-dialog modal-login">
        <div class="modal-content col-lg-10">
            <div class="modal-header">
                <h4 class="modal-title">Inicio de Sesión</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                                placeholder="Contraseña" required="required">
                            <span class="help-block">
                                <!--?php echo $password_err; ?--></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" value="Login"
                            style="box-shadow: 5; overflow:auto;  background-color: #A5CCAB; color: #536656">Ingresar</button>
                    </div>
                    <p class="hint-text"><a href="#" style="color:#536656">¿Olvidaste contraseña?</a></p>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
