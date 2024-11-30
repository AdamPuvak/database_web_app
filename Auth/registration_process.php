<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $check_email_query = "SELECT * FROM users WHERE email='$email'";
    $check_email_result = $db->query($check_email_query);
    if ($check_email_result->num_rows > 0) {
        echo "E-mail je už použitý na registráciu.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_query = "INSERT INTO users (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$hashed_password')";
    if ($db->query($insert_query) === TRUE) {

        $verification_code = mt_rand(100000 , 999999);

        try {
            /* mail sender config */

            $mail->isHTML(true);
            $mail->Subject = '2FA code';
            $mail->Body = 'Váš autentifikačný kód je: ' . $verification_code;

            $mail->send();
        } catch (Exception $e) {
            echo "Nastala chyba pri odosielaní e-mailu: {$mail->ErrorInfo}";
        }

        header("Location: code_verification.php?verification_code=$verification_code&name=$name");
        exit();
    } else {
        echo "Chyba pri registrácii: " . $db->error;
    }
}

$db->close();
?>
