<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- Javascript -->
<script>
$(document).ready(function () {
	$("#btnSend").click(function () {

		$.ajax({
			type: "GET",
			url: "/bamboo/backend/clientes/clientes_duplicados.php",
			success: function (data) {
				$("#retriever").text(data);
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
        <input type="button" id="btnSend" value="Trigger AJAX" class="btn btn-primary btn-small">
    </div>
</div>
</body>
</html>