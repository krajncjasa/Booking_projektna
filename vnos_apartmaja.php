<?php
include_once 'seja.php';
include_once 'baza.php';

$sql="SELECT * FROM kraji;";
$result1 = mysqli_query($link, $sql);

if (isset($_POST['subm'])) {

    $i = $_POST['ime'];
    $n = $_POST['naslov'];
    $s = $_POST['odrasel'];
    $o = $_POST['otrok'];
    $k = $_POST['kopalnic'];
    $t = $_POST['opis'];
    $l = $_POST['ljudi'];
    $p = $_POST['postelj'];
    $m = $_POST['kraj'];
    $dodatki = isset($_POST['dodatki']) ? $_POST['dodatki'] : [];

    // 1. Vstavi sobo
    $sobaQuery = "INSERT INTO sobe (max_ljudi_vsobi, st_postelj) VALUES ('$l', '$p')";
    $sobaResult = mysqli_query($link, $sobaQuery);
    $soba_id = mysqli_insert_id($link);

    // 2. Vstavi apartma z vgnezdenim SELECTOM za kraj_id
    $query = "
        INSERT INTO apartmaji (
            ime, 
            naslov, 
            cena_odraslega, 
            cena_otroka, 
            st_kopalnic, 
            opis, 
            soba_id, 
            kraj_id
        ) VALUES (
            '$i', 
            '$n', 
            '$s', 
            '$o', 
            '$k', 
            '$t', 
            '$soba_id', 
            '$m'
        )
    ";

    $result = mysqli_query($link, $query);
    $apartma_id = mysqli_insert_id($link);

        // 3. Povezava apartmaja z uporabnikom
    $user_id = $_SESSION['idu'];
    $povezavaQuery = "
        INSERT INTO apartmaji_uporabniki (apartma_id, uporabnik_id)
        VALUES ('$apartma_id', '$user_id')
    ";
    mysqli_query($link, $povezavaQuery);

    // 3. Dodatki (že vnaprej napolnjeni)
    foreach ($dodatki as $dodatek) {
        $query_dodatek = "
            INSERT INTO apartmaji_dodatki (apartma_id, dodatek_id)
            VALUES (
                '$apartma_id',
                (SELECT id FROM dodatki WHERE ime = '$dodatek')
            )
        ";
        mysqli_query($link, $query_dodatek);
    }

    // 4. Preusmeritev
    header("Location: vnos_datuma.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="UTF-8">
        <title>Vnos apartmaja</title>
        <style>
            #reg_obrazec{
            text-align: center;
            border: solid black 2px;
            width: 500px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -20%);
            padding: 20px;
            }
            .vnos{
                margin: 15px;
                padding: 5px;
                box-sizing: border-box;
            }
            #opis{
                width: 300px;
                height: 100px;
            }
        </style>
    </head>
    <body>
        <?php
        include 'glava.php';
        ?>
        <div id="reg_obrazec">
    <h1>Vnesite podatke</h1>
    <form action="#" method="POST"> 
        Ime: <input class="vnos" type="text" name="ime" required placeholder="Vnesite ime apartmaja"><br>
        Naslov <input class="vnos" type="text" name="naslov" required placeholder="Vnesite naslov"><br>
        Cena odraslega (V €): <input class="vnos" type="number" name="odrasel" required placeholder="Vnesite ceno odraslega"><br> 
        Cena otroka (V €): <input class="vnos" type="number" name="otrok" required placeholder="Vnesite ceno otroka"><br>
        Število kopalnic: <input class="vnos" type="number" name="kopalnic" required placeholder="Vnesite število kopalnic"><br>
        <div class="vnos">
            <label for="opis">Opis:</label><br>
            <textarea id="opis" name="opis" rows="5" required placeholder="Vnesite opis"></textarea>
        </div>
        Največje število ljudi:<input class="vnos" type="number" name="ljudi" required placeholder="Vnesite največje število ljudi"><br>
        Število postelj: <input class="vnos" type="number" name="postelj" required placeholder="Vnesite število postelj"><br>
        Dodatki (npr. bazen, wifi, itd.):<br>
        <input type="checkbox" name="dodatki[]" value="Bazen">Bazen
        <input type="checkbox" name="dodatki[]" value="Wi-Fi">Wifi<br>
        <input type="checkbox" name="dodatki[]" value="Klimatska naprava">Klimatska naprava
        <input type="checkbox" name="dodatki[]" value="Parking">Parkirišče<br>
        <input type="checkbox" name="dodatki[]" value="Kuhinja">Kuhinja
        <input type="checkbox" name="dodatki[]" value="Terasa">Terasa<br>
        <input type="checkbox" name="dodatki[]" value="Zajtrk">Zajtrk
        <input type="checkbox" name="dodatki[]" value="Kosilo">Kosilo<br>
        <input type="checkbox" name="dodatki[]" value="Vecerja">Večerja
        <input type="checkbox" name="dodatki[]" value="Savna">Savna<br>
        Kraj:<select class="vnos" name="kraj" required>
		<?php
        while ($row = mysqli_fetch_array($result1)) {
            echo "<option value='" .$row['id'] . "'>" .$row['ime']. "</option>";
        }
        ?>
        </select> <br>
        <input type="submit" name="subm" value="Pošlji">
    </form>
    </div>
    </body>
</html>