<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "nobel_prizes";

$db = new mysqli($servername, $username, $password, $database);

if ($db->connect_error) {
    die("Chyba pripojenia k databáze: " . $db->connect_error);
}

?>

