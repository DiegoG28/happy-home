<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
	<link href="https://kendo.cdn.telerik.com/2022.2.802/styles/kendo.default-main.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
	<script src="https://kendo.cdn.telerik.com/2022.2.802/js/kendo.all.min.js"></script>
	<script src="https://kit.fontawesome.com/8706ea8c3b.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="styles/index.css">
	<link rel="stylesheet" href="styles/global.css">
	<title>Happy Home</title>
</head>

<body>
	<?php
	include_once("connection.php");
	//Se ejecuta el procedimiento almacenado para mostrar la información necesaria de las casas
	$sql = "EXEC p_house_information";
	$stmt = sqlsrv_prepare($conn, $sql);
	if (!$stmt) {
		die(print_r(sqlsrv_errors(), true));
	}
	if (!sqlsrv_execute($stmt)) {
		die(print_r(sqlsrv_errors(), true));
	}
	?>

	<main>
		<div class="add-btn-container">
			<a href="add.php" class="generic-btn add-btn main-text">Añade tu anuncio</a>
		</div>
		<!-- Por cada registro en la base de datos se guardan los valores de cada columna para mostrarlos en HTML -->
		<?php while ($row = sqlsrv_fetch_array($stmt)) : ?>
			<?php $houseId = $row['house_pk']; ?>
			<?php $houseName = $row['house_title']; ?>
			<?php $houseDescription = $row['house_description']; ?>
			<?php $housePrice = $row['house_price']; ?>
			<?php $houseRooms = $row['house_rooms']; ?>
			<?php $houseBeds = $row['house_beds']; ?>
			<?php $houseCapacity = $row['house_capacity']; ?>
			<?php $ownerName = $row['owner_first_name']; ?>
			<?php $ownerLastName = $row['owner_last_name']; ?>
			<?php $ownerPhone = $row['owner_phone']; ?>
			<?php $ownerEmail = $row['owner_email']; ?>
			<?php $status = $row['status_name']; ?>
			<div class="card">
				<div class="house-image-info">
					<div class="house-image">
						<img src="https://picsum.photos/400/200" alt="">
					</div>
					<div class="house-info">
						<div>
							<h1 class="house-title"><?php echo $houseName ?></h1>
							<p class="house-status main-text"><?php echo $status ?></p>
						</div>
						<div class="house-owner-price">
							<p class="house-owner main-text">Por <?php echo $ownerName . " " . $ownerLastName ?></p>
							<div>
								<h2 class="house-price">$<?php echo $housePrice ?> Mensual</h2>
								<button class="contact-button main-text">Contactar propietario</button>
							</div>
						</div>
					</div>
				</div>

				<div class="details">
					<div class="tabstrip-left">
						<ul>
							<li class="k-active">
								Descripción
							</li>
							<li>
								Servicios
							</li>
							<li>
								Galería
							</li>
							<li>
								Contacto y ubicación
							</li>
						</ul>

						<div>
							<h3 class="tab-title">Descripción</h3>
							<p class="description secondary-text"><?php echo $houseDescription ?>
							</p>

							<div class="features">
								<h3 class="tab-title">Características</h3>
								<div class="feature">
									<i class="fa-solid fa-people-roof fa-xl"></i>
									<p class="feature-text secondary-text"><?php echo $houseRooms ?> habitaciones</p>
								</div>

								<div class="feature">
									<i class="fa-solid fa-bed fa-xl"></i>
									<p class="feature-text secondary-text"><?php echo $houseBeds ?> camas</p>
								</div>

								<div class="feature">
									<i class="fa-solid fa-user fa-xl fa-fw"></i>
									<p class="feature-text secondary-text"><?php echo $houseCapacity ?> capacidad</p>
								</div>
							</div>
						</div>

						<div class="services">
							<?php
							//Se ejecuta el procedimiento almacenado para obtener los servicios de una casa
							$sql2 = "EXEC p_house_services " . $houseId;
							$stmt2 = sqlsrv_prepare($conn, $sql2);
							if (!$stmt2) {
								die(print_r(sqlsrv_errors(), true));
							}
							if (!sqlsrv_execute($stmt2)) {
								die(print_r(sqlsrv_errors(), true));
							}
							?>
							<h3 class="tab-title">Servicios disponibles</h3>
							<div class="services-wrapper">
								<?php while ($row2 = sqlsrv_fetch_array($stmt2)) : ?>
									<?php $serviceName = $row2['service_name']; ?>
									<?php $serviceIcon = $row2['service_icon']; ?>
									<div class="service">
										<?php echo "<i class='fa-solid " . $serviceIcon . " fa-2xl fa-fw'></i>" ?>
										<p class="service-text secondary-text"><?php echo $serviceName ?></p>
									</div>
								<?php endwhile; ?>
							</div>
						</div>

						<div class="gallery">
							<h3 class="tab-title">Imágenes del hogar</h3>
							<img src="https://picsum.photos/id/237/400/300" alt="">
							<img src="https://picsum.photos/id/237/400/300" alt="">
							<img src="https://picsum.photos/id/237/400/300" alt="">
							<img src="https://picsum.photos/id/237/400/300" alt="">
						</div>

						<div class="contacts">
							<h3 class="tab-title">Datos de contacto</h3>
							<div class="contact">
								<i class="fa-solid fa-phone fa-xl"></i>
								<p class="contact-text secondary-text"><?php echo $ownerPhone ?></p>
							</div>
							<div class="contact">
								<i class="fa-solid fa-envelope fa-xl"></i>
								<p class="contact-text secondary-text"><?php echo $ownerEmail ?></p>
							</div>

							<div class="map">
								<h3 class="tab-title">Ubicación</h3>
								<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d930.1736337540189!2d-86.82617289650378!3d21.164551340813507!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f4c2d16a4747bff%3A0x2a426a6d140a789c!2sTerminal%20Urban%20Express%20a%20Playa%20del%20Carmen!5e0!3m2!1sen!2sus!4v1661554415443!5m2!1sen!2sus" width="600" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
							</div>
						</div>
					</div>

				</div>
			</div>
		<?php endwhile; ?>
	</main>

	<script>
		$(document).ready(function() {
			$('.details').kendoExpansionPanel({
				subTitle: 'Ver detalles',
				expanded: false
			});

			$(".tabstrip-left").kendoTabStrip({
				tabPosition: "left",
				animation: {
					open: {
						effects: "fadeIn"
					}
				}
			});
		});
	</script>
</body>

</html>