<?php

if(isset($_POST['subm'])){ 
    require 'baza.php';

    $k=$_POST['kraj'];

    $z=$_POST['zacetek_rez'];

    $a=$_POST['konec_rez']; 

    $o=$_POST['st_otrok'];

    $s=$_POST['st_odraslih'];

    $sql = "SELECT a.naslov, a.cena_odraslega, a.cena_otroka, a.st_kopalnic, a.opis, s.st_postelj, s.max_ljudi_vsobi, k.ime AS kraj_ime
        FROM apartmaji a
        JOIN sobe s ON a.soba_id = s.id JOIN kraji k ON a.kraj_id = k.id JOIN rezervacije r ON a.id = r.apartma_id
        WHERE (a.id NOT IN (SELECT apartma_id FROM rezervacije WHERE ('$z' <= zacetek_rez OR '$a' >= konec_rez))) AND (k.ime = '$k') AND (max_ljudi_vsobi >= $s + $o);";
    $result = mysqli_query($link, $sql);
    print_r($result);
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
                width: 700px;
                margin: 0 auto;
                padding: 20px;
            }
            table, th, td{
	            border:1px solid black;
            }
            td{
                height: 50px;
            }
            table{
	            border-collapse: collapse;
            }
        </style>
</head>
<body>
    <?php include 'glava.php'; ?>
    <?php include 'filter.php'; ?>
    <div id="obrazec">
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
                    </tr>';
                while ($row = mysqli_fetch_array($result)) {
                    echo $result;
                    echo    "<tr>";
                        echo"   <td>" . $row['ime'] . "</td>
                                <td>" . $row['naslov'] . "</td>
                                <td>" . $row['cena_odraslega'] . "</td>
                                <td>" . $row['cena_otroka'] . "</td>
                                <td>" . $row['st_kopalnic'] . "</td>
                                <td>" . $row['opis'] . "</td>
                                <td>" . $row['kraj_ime'] . "</td>
                               <td>" . $row['st_postelj'] . "</td>
                               <td>" . $row['max_ljudi_vsobi'] . "</td>";
                    echo    "</tr>";
                }
                ?>
            </table>
        </div>
</body>
</html>