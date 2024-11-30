<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_user_query = "SELECT * FROM users WHERE email='$email'";
    $check_user_result = $db->query($check_user_query);

    if ($check_user_result->num_rows > 0) {
        $row = $check_user_result->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            $name = $row['name'];

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
            echo "Nesprávne heslo.";
        }
    } else {
        echo "Používateľ s daným e-mailom neexistuje.";
    }
}

$db->close();
?>
