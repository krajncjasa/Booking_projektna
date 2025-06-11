<?php
include 'seja.php';
include 'baza.php';

    $query = "SELECT DISTINCT a.id, a.ime, a.naslov, a.cena_odraslega, a.cena_otroka, a.st_kopalnic, 
                a.opis, k.ime as kraj_ime, s.max_ljudi_vsobi, s.st_postelj
            FROM apartmaji a
            JOIN sobe s ON 
                a.soba_id = s.id
            JOIN kraji k ON
                a.kraj_id = k.id 
            JOIN apartmaji_dodatki ad ON 
                a.id = ad.apartma_id
            WHERE (a.vrsta = 'nedoločeno')";
    $result = mysqli_query($link, $query);
    if (isset($_POST['odobri'])) {
        $id = $_POST['odobri'];
        $query = "UPDATE apartmaji SET vrsta = 'odobreno' WHERE id = '$id'";
        $result = mysqli_query($link, $query);
        header("Location: admin.php");
    }
    if (isset($_POST['odstrani'])){
        $id = $_POST['odstrani'];
        $query = "UPDATE apartmaji SET vrsta = 'zavrnjeno' WHERE id = '$id'";
        $result = mysqli_query($link, $query);
        header("Location: admin.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <?php include 'glava.php'; ?>
    <h1>Admin</h1>
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
                        <th>Odobri</th>
                        <th>Zavrni</th>
                    </tr>';
                while ($row = mysqli_fetch_array($result)) {
                    echo    "<tr>";
                        echo"   <td>" . $row['ime'] . "</td>
                                <td>" . $row['naslov'] . "</td>
                                <td>" . $row['cena_odraslega'] . "</td>
                                <td>" . $row['cena_otroka'] . "</td>
                                <td>" . $row['st_kopalnic'] . "</td>
                                <td>" . $row['opis'] . "</td>
                                <td>" . $row['kraj_ime'] . "</td>
                               <td>" . $row['st_postelj'] . "</td>
                               <td>" . $row['max_ljudi_vsobi'] . "</td>
                               <td>
                                <form method='post' action='admin.php'>
                                    <button type='submit' name='odobri' value='" . $row['id'] . "'>Odobri</button>
                                    </td>
                                    <td>
                                    <button type='submit' name='odstrani' value='" . $row['id'] . "'>Zavrni</button>
                                </form>
                            </td>";
                    echo    "</tr>";
                }
                ?>
            </table>
</body>
</html>