<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie</title>
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">

    <script src="https://www.gstatic.com/firebasejs/9.6.2/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.2/firebase-auth-compat.js"></script>

    <script>
        const firebaseConfig = {
            /* firebase config */
        };

        firebase.initializeApp(firebaseConfig);

        function loginWithGoogle() {
            const provider = new firebase.auth.GoogleAuthProvider();
            firebase.auth().signInWithPopup(provider)
                .then((result) => {
                    const user = result.user;
                    console.log("Používateľ úspešne prihlásený:", user.displayName);
                    document.cookie = "user=" + user.displayName + "; expires=" + new Date(new Date().getTime() + (30 * 24 * 60 * 60 * 1000)).toUTCString() + "; path=/";
                    window.location.href = "welcome_page.php";
                })
                .catch((error) => {
                    console.error("Chyba pri prihlásení:", error);
                });
        }
    </script>
</head>
<body>
<header>
    <a class='home-icon' href="../index.php"><img src="../Assets/home_icon.jpg" alt="home_icon"/></a>
    <h1 class='header-h1' style="margin-right: 250px">Prihlásenie</h1>
</header>

<div class="container">
    <form action="login_process.php" method="post">
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Heslo:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Prihlásiť sa</button>
    </form>
    <button class="google-login-button" onclick="loginWithGoogle()">Prihlásiť sa cez Google</button>
    <p style="text-align: center;">Nemáte účet? <a id="register-link" href="registration.php">Zaregistrovať sa</a></p>
</div>

</body>
</html>