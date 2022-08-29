<?php
$serverName = "DESKTOP-661T9PM";
$connectionInfo = [
	"Database" => "happy_home",
	"Uid" => "admin",
	"PWD" => "root",
	"CharacterSet" => "UTF-8"
];

$conn = sqlsrv_connect($serverName, $connectionInfo);
if ($conn) {
	//echo "Conexión realizada";
} else {
	echo "Conexión fallida: ";
	die(print_r(sqlsrv_errors(), true));
}
