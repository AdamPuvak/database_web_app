<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pridať záznam</title>
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="shortcut icon" href="#">
</head>
<body>
<header>
    <a class='home-icon' href="../index.php"><img src="../Assets/home_icon.jpg" alt="home_icon"/></a>
    <h1 class='header-h1'style="margin-right: 250px">Pridať záznam</h1>
</header>

<div class="form-container">
    <form method="post" action=" ">
        <div style='padding: 0.4em'>
            <div class="form-row">
                <label class="form-label" for="year">Rok:</label>
                <input class="form-input" type="number" name="year" value="" min="0" max="<?php echo date('Y'); ?>" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="name">Meno:</label>
                <input class="form-input" type="text" name="name" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="surname">Priezvisko:</label>
                <input class="form-input" type="text" name="surname" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="name">Organizácia:</label>
                <input class="form-input" type="text" name="organisation" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="sex">Pohlavie:</label>
                <input class="form-input" type="text" name="sex" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="birth">Dátum narodenia:</label>
                <input class="form-input" type="number" name="birth" value="" min="0" max="<?php echo date('Y'); ?>">
            </div>
            <div class="form-row">
                <label class="form-label" for="death">Dátum úmrtia:</label>
                <input class="form-input" type="number" name="death" value="" min="0" max="<?php echo date('Y'); ?>" >
            </div>
            <div class="form-row">
                <label class="form-label" for="country">Krajina:</label>
                <input class="form-input" type="text" name="country" value="" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="category">Kategória:</label>
                <input class="form-input" type="text" name="category" value="" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="contribution_en">Príspevok (EN):</label>
                <input class="form-input" type="text" name="contribution_en" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="contribution_sk">Príspevok (SK):</label>
                <input class="form-input" type="text" name="contribution_sk" value="" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="language_en">Jazyk (EN):</label>
                <input class="form-input" type="text" name="language_en" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="language_sk">Jazyk (SK):</label>
                <input class="form-input" type="text" name="language_sk" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="genre_en">Žáner (EN):</label>
                <input class="form-input" type="text" name="genre_en" value="">
            </div>
            <div class="form-row">
                <label class="form-label" for="genre_sk">Žáner (SK):</label>
                <input class="form-input" type="text" name="genre_sk" value="">
            </div>

            <input class="save_btn" type="submit" value="Uložiť">
        </div>
    </form>
</div>

<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST["year"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $organisation = $_POST['organisation'];
    $sex = $_POST["sex"];
    $birth = $_POST["birth"];
    $death = $_POST["death"];
    $country = $_POST['country'];
    $category = $_POST['category'];
    $contribution_en = $_POST['contribution_en'];
    $contribution_sk = $_POST['contribution_sk'];
    $language_en = $_POST['language_en'];
    $language_sk = $_POST['language_sk'];
    $genre_en = $_POST['genre_en'];
    $genre_sk = $_POST['genre_sk'];


// COUNTRY
    $select_country_sql = "SELECT id FROM countries WHERE country = '$country'";
    $result = $db->query($select_country_sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $country_id = $row['id'];
    } else {
        $insert_country_sql = "INSERT INTO countries (country) VALUES ('$country')";
        if ($db->query($insert_country_sql) === TRUE) {
            $country_id = $db->insert_id;
        } else {
            echo "Chyba při vkládání země do tabulky countries: " . $db->error;
            exit;
        }
    }

// PEOPLE
    $insert_people_sql = "INSERT INTO people (name, surname, organisation, sex, birth, death, country_id) 
                      VALUES ('$name', '$surname', '$organisation', '$sex', '$birth', '$death', '$country_id')";

    if ($db->query($insert_people_sql) === TRUE) {
        $person_id = $db->insert_id;

        // PRIZE DETAILS
        $insert_prize_details_sql = "INSERT INTO prize_details (language_en, language_sk, genre_en, genre_sk) 
                                 VALUES ('$language_en', '$language_sk', '$genre_en', '$genre_sk')";

        if ($db->query($insert_prize_details_sql) === TRUE) {
            $prize_details_id = $db->insert_id;

            // PRIZES
            $insert_prizes_sql = "INSERT INTO prizes (year, category, contribution_en, contribution_sk, person_id, prize_details_id) 
                              VALUES ('$year', '$category', '$contribution_en', '$contribution_sk', '$person_id', '$prize_details_id')";

            if ($db->query($insert_prizes_sql) === TRUE) {
                header("Location: ../Pages/person_detail.php?id=$person_id&success=1");
                exit;
            } else {
                echo "Chyba při vkládání informací do tabulky prizes: " . $db->error;
            }
        } else {
            echo "Chyba při vkládání informací do tabulky prize_details: " . $db->error;
        }
    } else {
        echo "Chyba při vkládání informací do tabulky people: " . $db->error;
    }
}



$db->close();
?>

</body>
</html>