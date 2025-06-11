<?php
require_once 'baza.php';
?>
<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="UTF-8">
        <title>Izpis apartmajev</title>
        <link rel="stylesheet" href="style.css">
        <style>
            #obrazec2{
                margin-right: 30px;
            }
        </style>
    </head>
    <body>
        <?php include 'glava.php'; ?>
        <?php include 'filter.php'; ?>
        <div id="obrazec2">
            <h1>Izpis apertmajev</h1>

            <table border="1">
                <?php
                echo   
                    '<tr>
                        <th>ime</th>
                        <th>naslov</th>
                        <th>cena odraslega</th>
                        <th>cena otroka</th>
                        <th>število kopalnic</th>
                        <th>opis</th>
                        <th>kraj</th>
                        <th>št. postelj</th>
                        <th>max. ljudi v sobi</th>
                        <th>Cena (na noč enega odraslega)</th>
                        <th>rezerviraj</th>
                    </tr>';
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        //echo "<td><img src='uploads/" . $row['pot'] . "' alt='apartma slika' width='100' height='100'></td>";
                        echo "<td>" . $row['ime'] . "</td>";
                        echo "<td>" . $row['naslov'] . "</td>";
                        echo "<td>" . $row['cena_odraslega'] . "</td>";
                        echo "<td>" . $row['cena_otroka'] . "</td>";
                        echo "<td>" . $row['st_kopalnic'] . "</td>";
                        echo "<td>" . $row['opis'] . "</td>";
                        echo "<td>" . $row['kraj_ime'] . "</td>";
                        echo "<td>" . $row['st_postelj'] . "</td>";
                        echo "<td>" . $row['max_ljudi_vsobi'] . "</td>";
                        echo "<td>" . $row['cena_odraslega'] . "</td>";
                        echo '<td><a href="rezervacija.php?ida=' . $row['id'] . '&ido=' .$row['max_ljudi_vsobi']. '">Rezerviraj</a></td>';
                        echo "</tr>";
                    }
                    
                ?>
            </table>
        </div>
    </body>
</html>