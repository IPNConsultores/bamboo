<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /bamboo/backend/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bamboo Seguros</title>
<!-- Bootstrap -->
<link href="css/bootstrap-4.3.1.css" rel="stylesheet">
</head>
<body>
<!-- body code goes here -->
<div class ="container">
<div class= "clearflix shadow p-3;" style= "overflow:auto;  background-color: #536656;vertical-align: middle;" >
  <p><img src="http://www.bambooseguros.cl/img/logo-2.png" 	width="100" class="img-fluid" style="float: left;vertical-align: middle "></p>
  <p class="h2" style="color:white; text-align: left;vertical-align: middle; font-family:'Varela Round', sans-serif;margin-left: 100px;"> &nbsp;Gestión Bamboo</p>
</div>
<nav class="navbar navbar-expand-lg navbar-light shadow p-1"  style= "background-color: #A5CCAB; OVERFLOW=AUTO">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      	<li class="nav-item active">
		 <a class="nav-link" type ="button" onclick="abrir_home()">
			 Home<span class="sr-only">(current)</span>
		</a>
		</li>
      <li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
			  Clientes
		  </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" type="button" onclick="abrir_creacion_cliente()">Creación</a> 
		<a class="dropdown-item" type="button" onclick="abrir_modif_cliente()">Modificación</a>
		  </div>
    </li>
    <li class="nav-item active">
		 <a class="nav-link" type ="button" href="/bamboo/backend/logout.php">
			 Logout<span class="sr-only"></span>
		</a>
		</li>
		</ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style= "background-color:#536656;color:#A5CCAB">Search</button>
    </form>
  </div>
</nav>
</div>
<br>
<div class="needs-validation" novalidate>
  <form id="load" class="needs-validation" novalidate></form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-3.3.1.min.js"></script> 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script> 
<script type="text/javascript">	
function abrir_home() {
       $( "#load" ).empty();}	
function abrir_creacion_cliente() {
       $( "#load" ).load( "Creación_ClienteV3.html" );}
function abrir_modif_cliente() {
       $( "#load" ).load( "Modificación_Cliente.html" );}
// Example starter JavaScript for disabling form submissions if there are invalid fields

</script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap-4.3.1.js"></script> 
<script>
	(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

	</script>
</body>
</html>