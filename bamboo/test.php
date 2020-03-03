<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script src="/bamboo/js/bootstrap-notify.js"></script>
    <script src="/bamboo/js/bootstrap-notify.min.js"></script>
    <!-- Javascript -->


    <!-- HTML -->
    <div id="result" class="well left-col"></div>
    <div class="right-col">
        <div id="retriever"></div>
		<div id="button">
        <input type="button" id="btnSend" value="Trigger AJAX" class="btn btn-primary btn-small">
    </div>
<script>
function notifica(){
    $.notify({
	title: '<strong>Heads up!</strong>',
	message: 'You can use any of bootstraps other alert styles as well by default.'
},{
	type: 'success'
});
}
</script>
		<br>
		<br>
		<br>
		<br>
        <div id="button">
            <button type="button" class="fas fa-search"></button>
            <button type="button" class="fas fa-edit"></button>
            <button type="button" class="fas fa-trash-alt"></button>
            <button id="btnSend" type="button" class="fas fa-clipboard-list"></button>
        </div>

        <a class="fas fa-edit" name="boton-modificar" href="#"></a>
        <a class="fas fa-trash-alt" name="boton-elimina-cliente" href="#"></a>
        <br>
        <button class="fas fa-edit" name="boton-modificar" href="#"></button>
        <button class="fas fa-trash-alt" name="boton-elimina-cliente" href="#"></button>
        <br>
        <i type="button" class="fas fa-edit" name="boton-modificar" href="#"></i>
        <i type="button" class="fas fa-trash-alt" name="boton-elimina-cliente" href="#"></i>
    </div>
</body>

</html>