<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/bamboo/js/bootstrap-notify.js"></script>
    <script src="/bamboo/js/bootstrap-notify.min.js"></script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
    <!-- Javascript -->


    <!-- HTML -->
    <div id="result" class="well left-col"></div>
    <div class="right-col">
        <div id="retriever"></div>
		<div id="button">
        <input type="button" id="btnSend" value="Trigger AJAX" class="btn btn-primary btn-small">
    </div>
        <div id="button">
            <button type="button" class="fas fa-search"></button>
            <button type="button" class="fas fa-edit"></button>
            <button type="button" class="fas fa-trash-alt"></button>
            <button id="btnSend" type="button" class="fas fa-clipboard-list"></button>
        </div>

        <a class="fas fa-edit" name="boton-modificar" ></a>
        <a class="fas fa-trash-alt" name="boton-elimina-cliente" ></a>
        <br>
        <button class="fas fa-edit" name="boton-modificar" ></button>
        <button class="btn btn-primary" name="boton-elimina-cliente" ><i class="fas fa-trash-alt"></i></button>
        <br>
        <i type="button" class="fas fa-edit" name="boton-modificar" ></i>
        <i type="button" class="btn btn-primary" name="boton-elimina-cliente" ></i>
    </div>
</body>

</html>