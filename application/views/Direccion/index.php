<!DOCTYPE html>
<html>
<head>
	<title>Routing</title>
	<link rel="stylesheet" href="http://localhost/georeferencia/asset/css/bootstrap.css" />
	<script src="http://localhost/georeferencia/asset/js/jquery.min.js"></script>
</head>
<body>
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
  		<a class="navbar-brand" href="#">Navbar</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav">
				      <li class="nav-item active">
				        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link" href="#">Features</a>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link" href="#">Pricing</a>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link disabled" href="#">Disabled</a>
				      </li>
		    </ul>
  </div>
</nav>

<div class="container">
		
		<h3 align="center" class="mb-5">IMPORTACION DE DIRECCIONES</h3>
        <form method="post" id="import_form" enctype="multipart/form-data">
				<div class="row p-2">
					<div class="col-md-4">
						 	
								<input type="file" name="file" id="file" required accept=".xls, .xlsx" />
								<br />
										
					</div>
					<div class="col-md-4">
								<input type="submit" name="import" value="Importar Excel" class="btn btn-success" />
		            </div>
					<div class="col-md-4"></div>
				</div>
        </form>
     	<div class="row">
	    
			    <div class="col-md-6">
							
				</div>

				<div class="col-md-6">
							<form method="post" id="ruteo_form" action="http://localhost/georeferencia/index.php/Demo/texturl" enctype="multipart/form-data">
								
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
			url:"http://localhost/georeferencia/index.php/Direccion/importExcelEnterprise",
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
