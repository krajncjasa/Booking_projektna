<?php
if(isset($_POST['subm'])){ 
    require 'baza.php';

    $k=$_POST['kraj'];

    $z=$_POST['zacetek_rez'];

    $a=$_POST['konec_rez']; 

    $o=$_POST['st_otrok'];

    $s=$_POST['st_odraslih'];
    
    $skupaj = $o + $s;

    $sql = "SELECT DISTINCT
    a.naslov, 
    a.cena_odraslega, 
    a.cena_otroka, 
    a.st_kopalnic, 
    a.opis, 
    s.st_postelj, 
    s.max_ljudi_vsobi, 
    k.ime AS kraj_ime, 
    a.ime,
    a.id
FROM 
    apartmaji a
INNER JOIN 
    sobe s ON a.soba_id = s.id
INNER JOIN 
    kraji k ON a.kraj_id = k.id
WHERE 
    k.id = $k
    AND s.max_ljudi_vsobi >= $skupaj
    AND a.vrsta = 'odobreno'
    AND NOT EXISTS (
        SELECT 1
        FROM rezervacije r
        WHERE r.apartma_id = a.id
          AND NOT (
              r.konec_rez < '$z' OR
              r.zacetek_rez > '$a'
          )
    );
    ";
    $apartmaji = mysqli_query($link, $sql);   
}
$ida = $_GET['ida'] ?? '';
$m = $_GET['ido'] ?? '';

echo $m . $ida;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            #obrazec2{
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
                        <th>Rezerviraj</th>
                    </tr>';
                while ($row = mysqli_fetch_array($apartmaji)) {
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
                               echo '<td><a href="rezervacija2.php?ida=' . $row['id'] . '&ido=' .$row['max_ljudi_vsobi']. '">Rezerviraj</a></td>';
                    echo    "</tr>";
                }
                ?>
            </table>
        </div>
</body>
</html>