<?php
$verification_code = $_GET['verification_code'];
$name = $_GET['name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_code = $_POST['user_code'];

    if ($user_code == $verification_code) {
        setcookie('user', $name, time() + (86400 * 30), "/");
        header("Location: welcome_page.php");
        exit();
    } else {
        $error = "Zadaný kód nie je platný.";
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <title>Overenie kódu</title>
</head>
<body>
<header>
    <a class='home-icon' href="../index.php"><img src="../Assets/home_icon.jpg" alt="home_icon"/></a>
    <h1 class='header-h1'>Zadanie 1 - Nobelové ceny</h1>
</header>
<h2>Zadajte 6-miestny overovací kód:</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form id="verification-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?verification_code=$verification_code&name=$name"; ?>" method="post">
    <input id="user_code" type="text" name="user_code" maxlength="6" required>
    <button id="verify-button" type="submit">Overiť</button>
</form>
</body>
</html>