<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nobelové ceny</title>
    <link rel="stylesheet" type="text/css" href="CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="shortcut icon" href="#">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
<!-- Cookie banner -->
<?php
$isLoggedIn = isset($_COOKIE['user']);

if(!isset($_COOKIE['cookieConsent']) || $_COOKIE['cookieConsent'] !== 'true') {
    echo '<div id="cookie-banner" style="background-color: #333; color: white; text-align: center; padding: 10px;">
            Táto stránka používa cookies na zlepšenie užívateľského zážitku. Kliknutím na tlačidlo súhlasíte s používaním cookies.
            <button onclick="acceptCookies()" style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">Súhlasím</button>
          </div>';
}

if(isset($_GET['success']) && $_GET['success'] === 'true') {
    echo "<div class='toast'>Záznam bol úspešné odstránený.</div>";
}
?>

<header>
    <h1 class="h1-1">Nobelové ceny</h1>
    <?php
    if($isLoggedIn) {
        echo "<p id='user-greeting'>Prihlásený: " . $_COOKIE['user'] . "</p>";
        echo "<a class='login-link' href='Auth/logout.php'>Odhlásiť sa</a>";
    } else {
        echo "<a class='login-link' href='Auth/login.php'>Prihlásiť</a>";
    }
    ?>
</header>

<!-- Filter container -->
<div class="filter-container">
    <div class="filter">
        <label for="filterYear">Filtrovať podľa roku:</label>
        <select id="filterYear">
            <option value="">Všetky</option>
            <?php
            include "config.php";

            $sql = "SELECT DISTINCT year FROM prizes ORDER BY year DESC";
            $result = $db->query($sql);
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['year']."'>".$row['year']."</option>";
            }
            $db->close();
            ?>
        </select>
    </div>
    <div class="filter">
        <label for="filterCategory">Filtrovať podľa kategórie:</label>
        <select id="filterCategory">
            <option value="">Všetky</option>
            <?php
            include "config.php";

            $sql = "SELECT DISTINCT category FROM prizes ORDER BY category";
            $result = $db->query($sql);
            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['category']."'>".$row['category']."</option>";
            }
            $db->close();
            ?>
        </select>
    </div>

    <a class='add_btn' href='#' onclick='redirect2();'>Pridať záznam</a>
</div>

<!-- Nobel prizes table -->
<?php
include "config.php";

$sql = "SELECT people.id, people.name, people.surname, people.organisation, people.sex, people.birth, people.death,
               countries.country, prizes.year, prizes.category, prizes.contribution_en, prizes.contribution_sk,
               prize_details.language_en, prize_details.language_sk, prize_details.genre_en, prize_details.genre_sk   
        FROM people 
        JOIN prizes ON people.id = prizes.person_id
        JOIN prize_details ON prizes.prize_details_id = prize_details.id            
        JOIN countries ON people.country_id = countries.id";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    echo "<table id='nobelTable' class='display'>";
    echo "<thead><tr><th>Meno</th><th>Priezvisko</th><th>Rok</th><th>Krajina</th><th>Kategória</th><th></th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        $display_name = !empty($row["name"]) ? $row["name"] : $row["organisation"];
        echo "<tr><td><a id='table-line' href='Pages/person_detail.php?id=".$row["id"]."'>".$display_name."</a></td><td>".$row["surname"]."</td><td>".$row["year"]."</td><td>".$row["country"]."</td><td>".$row["category"]."</td><td><button class='delete-btn' data-id='".$row["id"]."'>X</button></td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "<div class='spacer'></div>";
} else {
    echo "Žiadne výsledky na zobrazenie.";
}

$db->close();
?>

<script>

    $(document).ready(function() {
        var table = $('#nobelTable').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [0, 3, 5] }
            ],
            "autoWidth": false,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Všetky"]]
        });

        $('#filterYear').on('change', function () {
            table.column(2).search(this.value).draw();
            if (this.value !== '') {
                table.columns(2).visible(false);
            } else {
                table.columns(2).visible(true);
            }
        });

        $('#filterCategory').on('change', function () {
            table.column(4).search(this.value).draw();
            if (this.value !== '') {
                table.columns(4).visible(false);
            } else {
                table.columns(4).visible(true);
            }
        });
    });

    function acceptCookies() {
        document.cookie = "cookieConsent=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
        document.getElementById('cookie-banner').style.display = 'none';
    }

    $(document).on('click', '.delete-btn', function() {
        <?php if (!$isLoggedIn): ?>
        window.location.href = 'Auth/login.php';
        <?php else: ?>
        var row = $(this).closest('tr');
        var personId = $(this).data('id');
        window.location.href = 'Edit/delete_person.php?personId=' + personId;

        var urlParams = new URLSearchParams(window.location.search);
        var success = urlParams.get('success');
        if (success === 'true') {
            row.remove();
        } else {
            console.log('Chyba pri vymazávaní záznamu.');
        }
        <?php endif; ?>
    });

    function redirect2() {
        <?php if ($isLoggedIn): ?>
        window.location.href = 'Edit/add_person.php';
        <?php else: ?>
        window.location.href = 'Auth/login.php';
        <?php endif; ?>
    }

</script>

</body>
</html>