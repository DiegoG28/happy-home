<!DOCTYPE html>
<?php
include("connection.php");
?>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/global.css">
	<title>Agregar anuncio</title>
</head>

<body>
	<form action="add.php" id="form" method="POST">
		<div class="form-group">
			<label for="houseTitle">Título</label>
			<input type="text" class="form-control" id="houseTitle" name="houseTitle" maxlength="100" required>
		</div>
		<div class="form-group">
			<label for="houseDescription">Descripción</label>
			<textarea class="form-control" id="houseDescription" rows="3" name="houseDescription" required></textarea>
		</div>
		<div class="form-group">
			<label for="housePrice">Precio</label>
			<input type="number" class="form-control" id="housePrice" name="housePrice" min="1000" max="30000" required>
		</div>
		<div class="form-group">
			<label for="houseRooms">Número de habitaciones</label>
			<input type="number" class="form-control" id="houseRooms" name="houseRooms" min="1" max="10" required>
		</div>
		<div class="form-group">
			<label for="houseBeds">Cantidad de camas</label>
			<input type="number" class="form-control" id="houseBeds" name="houseBeds" min="1" max="25" required>
		</div>
		<div class="form-group">
			<label for="houseCapacity">Capacidad de personas</label>
			<input type="number" class="form-control" id="houseCapacity" name="houseCapacity" min="1" max="50" required>
		</div>
		<div class="form-group">
			<label for="ownerName">Nombre</label>
			<input type="text" class="form-control" id="ownerName" name="ownerName" maxlength="50" required>
		</div>
		<div class="form-group">
			<label for="ownerLastName">Apellido</label>
			<input type="text" class="form-control" id="ownerLastName" name="ownerLastName" maxlength="50" required>
		</div>
		<div class="form-group">
			<label for="ownerPhone">Teléfono</label>
			<input type="text" class="form-control" id="ownerPhone" name="ownerPhone" maxlength="10" required>
		</div>
		<div class="form-group">
			<label for="ownerEmail">Correo electrónico</label>
			<input type="email" class="form-control" id="ownerEmail" name="ownerEmail" maxlength="50" required>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Crear anuncio" name="submit"></button>
		</div>
	</form>

	<?php
	if (isset($_POST['submit'])) {
		$houseTitle = $_POST['houseTitle'];
		$houseDescription = $_POST['houseDescription'];
		$housePrice = $_POST['housePrice'];
		$houseRooms = $_POST['houseRooms'];
		$houseBeds = $_POST['houseBeds'];
		$houseCapacity = $_POST['houseCapacity'];
		$ownerName = $_POST['ownerName'];
		$ownerLastName = $_POST['ownerLastName'];
		$ownerPhone = $_POST['ownerPhone'];
		$ownerEmail = $_POST['ownerEmail'];

		//Creamos la sentencia para el procedimiento almacenado que permite agregar nuevas casas.
		$sql = "EXEC p_add_house @ownerName = ?, @ownerLastName = ?, @ownerPhone = ?, @ownerEmail = ?, @houseTitle = ?, @houseDescription = ?, @housePrice = ?, @houseRooms = ?, @houseBeds = ?, @houseCapacity = ?";
		//Guardamos los parámetros en un array.
		$procedure_params = [$ownerName, $ownerLastName, $ownerPhone, $ownerEmail, $houseTitle, $houseDescription, $housePrice, $houseRooms, $houseBeds, $houseCapacity];
		$stmt = sqlsrv_prepare($conn, $sql, $procedure_params);
		if (!$stmt) {
			die(print_r(sqlsrv_errors(), true));
		}
		if (!sqlsrv_execute($stmt)) {
			die(print_r(sqlsrv_errors(), true));
		}
		header('Location: index.php');
	}
	?>
</body>

</html>