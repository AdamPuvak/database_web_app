
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nobelové ceny</title>
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="shortcut icon" href="#">
</head>
<body>
<header>
    <a class='home-icon' href="../index.php"><img src="../Assets/home_icon.jpg" alt="home_icon"/></a>
    <h1 class='header-h1' style="margin-right: 250px">Detailné informácie</h1>
</header>

<?php
$isLoggedIn = isset($_COOKIE['user']);

include "../config.php";

if(isset($_GET['id']) && !empty($_GET['id'])) {

    if(isset($_GET['success']) && $_GET['success'] === '1') {
        echo "<div class='toast'>Záznam bol úspešné pridaný.</div>";
    }
    else if(isset($_GET['success']) && $_GET['success'] === '2') {
        echo "<div class='toast'>Záznam bol úspešne aktualizovaný.</div>";
    }

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
        echo "<div style='padding: 0.4em'></div>";

        if (!empty($row["year"])) echo "<p>Rok: " . $row["year"] . "</p>";
        if (!empty($row["name"])) echo "<p>Meno: " . $row["name"] . "</p>";
        if (!empty($row["surname"])) echo "<p>Priezvisko: " . $row["surname"] . "</p>";
        if (!empty($row["organisation"])) echo "<p>Organizácia: " . $row["organisation"] . "</p>";
        if (!empty($row["sex"])) echo "<p>Pohlavie: " . $row["sex"] . "</p>";
        if (!empty($row["birth"])) echo "<p>Dátum narodenia: " . $row["birth"] . "</p>";
        if (!empty($row["death"])) echo "<p>Dátum úmrtia: " . $row["death"] . "</p>";
        if (!empty($row["country"])) echo "<p>Krajina: " . $row["country"] . "</p>";
        if (!empty($row["category"])) echo "<p>Kategória: " . $row["category"] . "</p>";
        if (!empty($row["contribution_sk"])) echo "<p>Príspevok (SK): " . $row["contribution_sk"] . "</p>";
        if (!empty($row["contribution_en"])) echo "<p>Príspevok (EN): " . $row["contribution_en"] . "</p>";
        if (!empty($row["language_sk"])) echo "<p>Jazyk (SK): " . $row["language_sk"] . "</p>";
        if (!empty($row["language_en"])) echo "<p>Jazyk (EN): " . $row["language_en"] . "</p>";
        if (!empty($row["genre_sk"])) echo "<p>Žáner (SK): " . $row["genre_sk"] . "</p>";
        if (!empty($row["genre_en"])) echo "<p>Žáner (EN): " . $row["genre_en"] . "</p>";

    } else {
        echo "Osoba s ID $person_id nebola nájdená.";
    }

    echo "<a class='edit_btn' href='#' onclick='redirect();'>Upraviť</a>";


} else {
    echo "1";
}


$db->close();
?>

<script>
    function redirect() {
        <?php if ($isLoggedIn): ?>
        window.location.href = '../Edit/edit_person.php?id=<?php echo $person_id; ?>';
        <?php else: ?>
        window.location.href = '../Auth/login.php';
        <?php endif; ?>
    }
</script>

</body>
</html>



