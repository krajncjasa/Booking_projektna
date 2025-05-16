<?php

include 'baza.php';
include 'seja.php';

$sql = "SELECT * FROM apartmaji_uporabniki ap JOIN apartmaji a ON ap.apartma_id = a.id  WHERE ap.uporabnik_id = '".$_SESSION['idu']."'";
$result = mysqli_query($link, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include 'glava.php'; ?>
    <h1>Moj profil</h1>
    <h2>Oddajanja</h2>
    <table border="1">
    <form action="#" method="POST">
        <?php
        echo   
            '<tr>
                <th>slika</th>
                <th>ime</th>
                <th>naslov</th>
                <th>cena odraslega</th>
                <th>cena otroka</th>
            </tr>';
        while ($row = mysqli_fetch_array($result)) {
            echo    "<tr>";
            echo    '<td><a href="dodaj_sliko.php?ida=' . $row['id'] . '">Dodaj sliko apartmaja</a></td>';
            echo    "<td>" . $row['ime'] . "</td>";
            echo    "<td>" . $row['naslov'] . "</td>";
            echo    "<td>" . $row['cena_odraslega'] . "</td>";
            echo    "<td>" . $row['cena_otroka'] . "</td>";
            echo    "</tr>";
        }
        ?>
    </form>
    </table>
    
</body>
</html>