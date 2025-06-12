<?php

include 'baza.php';
include 'seja.php';

$sql = "SELECT ap.*, a.*, a.id AS apartma_id 
        FROM apartmaji_uporabniki ap 
        JOIN apartmaji a ON ap.apartma_id = a.id  
        WHERE ap.uporabnik_id = '".$_SESSION['idu']."'";
$result = mysqli_query($link, $sql);

if (isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM apartmaji_uporabniki WHERE apartma_id = '$id' AND uporabnik_id = '".$_SESSION['idu']."'";
    $result = mysqli_query($link, $sql);
    header("Location: moj_profil.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #obrazec{
                width: 900px;
                margin: 0 auto;
                padding: 20px;
            }
    </style>
</head>
<body>
    <?php include 'glava.php'; ?>
    <div id="obrazec">
    <h1>Moj profil</h1>
    <h2>Oddajanja</h2>
    <table border="1">
    <form action="#" method="POST">
        <?php
        echo   
            '<tr>
                <th>ime</th>
                <th>naslov</th>
                <th>cena odraslega</th>
                <th>cena otroka</th>
                <th>Izbriši</th>
                <th>Stanje</th>
                <th>Posodobi</th>
            </tr>';
        while ($row = mysqli_fetch_array($result)) {
            echo    "<tr>";
            echo    "<td>" . $row['ime'] . "</td>";
            echo    "<td>" . $row['naslov'] . "</td>";
            echo    "<td>" . $row['cena_odraslega'] . "</td>";
            echo    "<td>" . $row['cena_otroka'] . "</td>";
            echo    '<td><a href="moj_profil.php?id=' . $row['id'] . '">Izbriši</a></td>';
            echo    "<td>" . $row['vrsta'] . "</td>";
            echo    '<td><a href="posodobi_apartma.php?ida=' . $row['id'] . '">Posodobi</a></td>';
            echo    "</tr>";
        }
        ?>
    </form>
    </table>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
