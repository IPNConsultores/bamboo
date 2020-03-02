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
$(document).ready(function () {
	$("#btnSend").click(function () {
        alert("test")
        
		$.ajax({
			type: "GET",
			url: "/backend/clientes/clientes_duplicados.php",
			success: function () {
				alert("exito");
			}
			fail: function () {
				alert("fail");
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
		<i type="button" id="btnSend" value="Trigger AJAX" class="fas fa-search"></i>
		<i type="button" id="btnSend" value="Trigger AJAX" class="fas fa-edit"></i>
		<i type="button" id="btnSend" value="Trigger AJAX" class="fas fa-trash-alt"></i>
		<i class="fas fa-clipboard-list"></i>
		<button type="button" class="fas fa-search"></button>
		<button type="button"><i class="fas fa-clipboard-list"></i> </button>
    </div>
</div>
</body>
</html>