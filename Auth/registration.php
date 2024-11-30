<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia</title>
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
</head>
<body>
<header>
    <a class='home-icon' href="../index.php"><img src="../Assets/home_icon.jpg" alt="home_icon"/></a>
    <h1 class='header-h1' style="margin-right: 250px">Registrácia</h1>
</header>

<div class="container">
    <form action="registration_process.php" method="post">
        <div class="form-group">
            <label for="name">Meno:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="surname">Priezvisko:</label>
            <input type="text" id="surname" name="surname" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Heslo:</label>
            <input type="password" id="password" name="password" pattern=".{6,}" title="Heslo musí mať aspoň 6 znakov" required>
        </div>
        <button type="submit">Registrovať sa</button>
    </form>
</div>

</body>
</html>
