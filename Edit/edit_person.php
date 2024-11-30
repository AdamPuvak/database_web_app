<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upraviť osobu</title>
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="shortcut icon" href="#">
</head>
<body>
<header>
    <a class='home-icon' href="../index.php"><img src="../Assets/home_icon.jpg" alt="home_icon"/></a>
    <h1 class='header-h1'style="margin-right: 250px">Upraviť informácie</h1>
</header>

<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $person_id = $_POST['person_id'];
    $year = $_POST['year'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $organisation = $_POST['organisation'];
    $sex = $_POST['sex'];
    $birth = $_POST['birth'];
    $death = $_POST['death'];
    $country = $_POST['country'];
    $category = $_POST['category'];
    $contribution_sk = $_POST['contribution_sk'];
    $contribution_en = $_POST['contribution_en'];
    $language_sk = $_POST['language_sk'];
    $language_en = $_POST['language_en'];
    $genre_sk = $_POST['genre_sk'];
    $genre_en = $_POST['genre_en'];

    $year = !empty($year) ? "'$year'" : "NULL";
    $name = !empty($name) ? "'$name'" : "NULL";
    $surname = !empty($surname) ? "'$surname'" : "NULL";
    $organisation = !empty($organisation) ? "'$organisation'" : "NULL";
    $sex = !empty($sex) ? "'$sex'" : "NULL";
    $birth = !empty($birth) ? "'$birth'" : "NULL";
    $death = !empty($death) ? "'$death'" : "NULL";
    $country = !empty($country) ? "'$country'" : "NULL";
    $category = !empty($category) ? "'$category'" : "NULL";
    $contribution_sk = !empty($contribution_sk) ? "'$contribution_sk'" : "NULL";
    $contribution_en = !empty($contribution_en) ? "'$contribution_en'" : "NULL";
    $language_sk = !empty($language_sk) ? "'$language_sk'" : "NULL";
    $language_en = !empty($language_en) ? "'$language_en'" : "NULL";
    $genre_sk = !empty($genre_sk) ? "'$genre_sk'" : "NULL";
    $genre_en = !empty($genre_en) ? "'$genre_en'" : "NULL";


    $update_people_sql = "UPDATE people SET 
                  name=$name,
                  surname=$surname,
                  organisation=$organisation,
                  sex=$sex,
                  birth=$birth,
                  death=$death
                  WHERE id=$person_id";

    $update_countries_sql = "UPDATE countries AS c
                        JOIN people AS p ON c.id = p.country_id
                        SET c.country = $country
                        WHERE p.id = $person_id";

    $update_prizes_sql = "UPDATE prizes AS pr
                      JOIN people AS pe ON pr.person_id = pe.id
                      SET pr.year = $year,
                          pr.category = $category,
                          pr.contribution_sk = $contribution_sk,
                          pr.contribution_en = $contribution_en
                      WHERE pr.person_id = $person_id";

    $update_prize_details_sql = "UPDATE prize_details AS pd
                             JOIN prizes AS pr ON pd.id = pr.prize_details_id
                             JOIN people AS pe ON pr.person_id = pe.id
                             SET pd.language_sk = $language_sk,
                                 pd.language_en = $language_en,
                                 pd.genre_sk = $genre_sk,
                                 pd.genre_en = $genre_en
                             WHERE pe.id = $person_id";

    if (($db->query($update_people_sql) === TRUE) || ($db->query($update_countries_sql) === TRUE) || ($db->query($update_prizes_sql) === TRUE) || ($db->query($update_prize_details_sql) === TRUE))  {
        header("Location: ../Pages/person_detail.php?id=$person_id&success=2");
        exit;
    } else {
        echo "TERAZ-3";
        echo "Chyba při aktualizaci informací: " . $db->error;
    }
}


if(isset($_GET['id']) && !empty($_GET['id'])) {
    $person_id = $_GET['id'];
    $sql = "SELECT people.id, people.name, people.surname, people.organisation, people.sex, people.birth, people.death,
               countries.country,
               prizes.year, prizes.category, prizes.contribution_en, prizes.contribution_sk,
               prize_details.language_en, prize_details.language_sk, prize_details.genre_en, prize_details.genre_sk  
        FROM people 
        JOIN prizes ON people.id = prizes.person_id
        JOIN prize_details ON prizes.prize_details_id = prize_details.id            
        JOIN countries ON people.country_id = countries.id
        WHERE people.id = $person_id";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <form method="post" action="">
            <input type="hidden" name="person_id" value="<?php echo $person_id; ?>">
            <div style='padding: 0.4em'>
                <div class="form-row">
                    <label class="form-label" for="year">Rok:</label>
                    <input class="form-input" type="number" name="year" value="<?php echo $row["year"];?>" min="0" max="<?php echo date('Y'); ?>" required>
                </div>
                <div class="form-row">
                    <label class="form-label" for="name">Meno:</label>
                    <input class="form-input" type="text" name="name" value="<?php echo $row["name"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="surname">Priezvisko:</label>
                    <input class="form-input" type="text" name="surname" value="<?php echo $row["surname"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="sex">Organizácia:</label>
                    <input class="form-input" type="text" name="organisation" value="<?php echo $row["organisation"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="sex">Pohlavie:</label>
                    <input class="form-input" type="text" name="sex" value="<?php echo $row["sex"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="birth">Dátum narodenia:</label>
                    <input class="form-input" type="number" name="birth" value="<?php echo $row["birth"];?>" min="0" max="<?php echo date('Y'); ?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="death">Dátum úmrtia:</label>
                    <input class="form-input" type="number" name="death" value="<?php echo $row["death"];?>" min="0" max="<?php echo date('Y'); ?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="country">Krajina:</label>
                    <input class="form-input" type="text" name="country" value="<?php echo $row["country"];?>" required>
                </div>
                <div class="form-row">
                    <label class="form-label" for="category">Kategória:</label>
                    <input class="form-input" type="text" name="category" value="<?php echo $row["category"];?>" required>
                </div>
                <div class="form-row">
                    <label class="form-label" for="contribution_en">Príspevok (EN):</label>
                    <input class="form-input" type="text" name="contribution_en" value="<?php echo $row["contribution_en"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="contribution_sk">Príspevok (SK):</label>
                    <input class="form-input" type="text" name="contribution_sk" value="<?php echo $row["contribution_sk"];?>" required>
                </div>
                <div class="form-row">
                    <label class="form-label" for="language_en">Jazyk (EN):</label>
                    <input class="form-input" type="text" name="language_en" value="<?php echo $row["language_en"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="language_sk">Jazyk (SK):</label>
                    <input class="form-input" type="text" name="language_sk" value="<?php echo $row["language_sk"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="genre_en">Žáner (EN):</label>
                    <input class="form-input" type="text" name="genre_en" value="<?php echo $row["genre_en"];?>">
                </div>
                <div class="form-row">
                    <label class="form-label" for="genre_sk">Žáner (SK):</label>
                    <input class="form-input" type="text" name="genre_sk" value="<?php echo $row["genre_sk"];?>">
                </div>

                <input class="save_btn" type="submit" value="Uložiť">
            </div>
        </form>
        <?php
    } else {
        echo "Osoba s ID $person_id nebola nájdená.";
    }
} else {
    echo "Nebol poskytnutý identifikátor osoby.";
}

$db->close();
?>

</body>
</html>
