<!DOCTYPE html>
<html>
<head>
	<title>Routing</title>
	<link rel="stylesheet" href="http://localhost/georeferencia/asset/bootstrap.min.css" />
	<script src="http://localhost/georeferencia/asset/jquery.min.js"></script>
</head>
<body>
   <div class="container">
		<br />
		<h3 align="center">IMPORTACION DE DIRECCIONES</h3>
		<div class="row">
	    
			    <div class="col-md-6">
							<form method="post" id="import_form" enctype="multipart/form-data">
								<p><label>Selecciona un archivo excel</label>
								<input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
								<br />
								<input type="submit" name="import" value="Importar Excel" class="btn btn-info" />
							</form>
				</div>

				<div class="col-md-6">
							<form method="post" id="ruteo_form" action="http://localhost/georeferencia/index.php/Demo/texturl" enctype="multipart/form-data">
								<label>Rutear caminos</label>
								<input type="submit" name="import" value="Rutear" class="btn btn-primary" />
							</form>
				</div>

		</div>
		<br />
		                                     <!-- LISTADO DE LA TABLA -->
		<div class="table-responsive" id="customer_data">

		</div>
	</div>

</body>

</html>

<script>
$(document).ready(function(){

	load_data();
	function load_data()
	{
		$.ajax({
			url:"http://localhost/georeferencia/index.php/Direccion/fetch",
			method:"POST",
			success:function(data){
				$('#customer_data').html(data);
			}
		})
	}
	$('#import_form').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url:"http://localhost/georeferencia/index.php/Direccion/import",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success:function(data){
				$('#file').val('');
				load_data();
				alert(data);

			}
		})
	});
});
</script>
