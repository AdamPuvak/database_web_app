<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitajte</title>
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
</head>
<body id="welcome-body">
<div id="welcome-message">
    <?php
    $meno = isset($_COOKIE['user']) ? $_COOKIE['user'] : "Neznámy používateľ";
    echo "<h1>Vitaj $meno</h1>";
    ?>
</div>
<?php
header("refresh:3;url=../index.php");
?>
</body>
</html>