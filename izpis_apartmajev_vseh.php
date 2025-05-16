<?php
require_once 'baza.php';

    if (isset($_POST['subm'])) {
        $dodatki = $_POST['dodatki'];
        print_r($dodatki);
        $min_cena = $_POST['min_cena'];
        $max_cena = $_POST['max_cena'];
        $sql = "
            SELECT DISTINCT
                a.id, a.ime, a.naslov, a.cena_odraslega, a.cena_otroka, a.st_kopalnic, 
                a.opis, k.ime as kraj_ime, s.max_ljudi_vsobi, s.st_postelj
            FROM apartmaji a
            JOIN sobe s ON 
                a.soba_id = s.id
            JOIN kraji k ON
                a.kraj_id = k.id 
            JOIN apartmaji_dodatki ad ON 
                a.id = ad.apartma_id
            WHERE 1=1
        ";
        if (!empty($dodatki)) {
            foreach($dodatki as $dodatek) {
                $sql .= " AND (ad.dodatek_id = '$dodatek')"; //AND ad.dodatek_id = '1' AND ad.dodatek_id = '2'
            }
        }
        if (!empty($min_cena) && !empty($max_cena)) {
            $sql .= "AND a.cena_odraslega BETWEEN '$min_cena' AND '$max_cena'";
        }
        $result = mysqli_query($link, $sql);
    } else {
        $sql = "SELECT a.id, a.ime, a.naslov, a.cena_odraslega, a.cena_otroka, a.st_kopalnic, a.opis, k.ime as kraj_ime, s.max_ljudi_vsobi, s.st_postelj
        FROM apartmaji a
        JOIN sobe s ON a.soba_id = s.id JOIN kraji k ON a.kraj_id = k.id";
        $result = mysqli_query($link, $sql);
    }
    if(isset($_POST['reset'])) {
        $dodatki = isset($_POST['dodatki']) ? $_POST['dodatki'] : [];
        $min_cena = $_POST['min_cena'];
        $max_cena = $_POST['max_cena'];
        
    }
    
?>
<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="UTF-8">
        <title>Izpis apartmajev</title>
        <style>
            #obrazec{
                width: 900px;
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