<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
    <!-- Javascript -->
    <script>
    $(document).ready(function() {
        $("#btnSend").click(function() {

            $.ajax({
                type: "POST",
                url: "/backend/clientes/clientes_duplicados.php",
                data: {
                    rut: '17029236'
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.blablabla);
					alert(response.blablabla);
                    // put on console what server sent back...
                }
            });

        });
    });
    </script>

    <!-- HTML -->
    <div id="result" class="well left-col"></div>
    <div class="right-col">
        <div id="retriever"></div>
		<div id="button">
        <input type="button" id="btnSend" value="Trigger AJAX" class="btn btn-primary btn-small">
    </div>

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