
<?php

include "../config.php";

if (isset($_GET['personId'])) {
    $personId = $_GET['personId'];
} else {
    die("Chyba: Chýbajúce ID osoby v požiadavke.");
}
$success = true;

$sql_prizes = "DELETE FROM prizes WHERE person_id = $personId";
if (!$db->query($sql_prizes)) {
    $success = false;
} else {
    $sql_people = "DELETE FROM people WHERE id = $personId";
    if (!$db->query($sql_people)) {
        $success = false;
    }
}

if ($success) {
    echo "<script>window.location.href = '../index.php?success=true';</script>";
} else {
    echo "<script>window.location.href = '../index.php?success=false';</script>";
}


$db->close();
?>

