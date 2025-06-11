<?php
include 'baza.php';
if (isset($_POST['submi'])) {
        $min_cena = $_POST['min_cena'];
        $max_cena = $_POST['max_cena'];
        $dodatki = $_POST['dodatki'] ?? [];
        $sql = "
            SELECT DISTINCT
                a.id, a.ime, a.naslov, a.cena_odraslega, a.cena_otroka, a.st_kopalnic, a.opis,
                k.ime AS kraj_ime, s.max_ljudi_vsobi, s.st_postelj
            FROM apartmaji a
            JOIN sobe s ON 
                a.soba_id = s.id
            JOIN kraji k ON
                a.kraj_id = k.id 
            JOIN apartmaji_dodatki ad ON 
                a.id = ad.apartma_id
            WHERE (a.vrsta = 'odobreno') 
        ";
        if (!empty($dodatki)) {
            $sql .= "AND (ad.dodatek_id IN (";
            $count = count($dodatki);
            $i = 0;
            foreach($dodatki as $dodatek) {
                $i++;
                $sql .= "'$dodatek'"; //AND ad.dodatek_id = '1' AND ad.dodatek_id = '2'
                if ($i < $count) {
                    $sql .= ", ";
                }
            }
            $sql .= ")) ";

            $sql .= "GROUP BY a.id, a.ime, a.naslov, a.cena_odraslega, a.cena_otroka, a.st_kopalnic, a.opis,
            kraj_ime, s.max_ljudi_vsobi, s.st_postelj
            HAVING COUNT(DISTINCT ad.dodatek_id) = " . count($dodatki);
        }
        if (!empty($min_cena) && !empty($max_cena)) {
            $sql .= " AND a.cena_odraslega BETWEEN '$min_cena' AND '$max_cena'";
        }
        $result = mysqli_query($link, $sql);
} else {
        $sql = "SELECT a.id, a.ime, a.naslov, a.cena_odraslega, a.cena_otroka, a.st_kopalnic, a.opis, k.ime as kraj_ime, s.max_ljudi_vsobi, s.st_postelj
        FROM apartmaji a
        JOIN sobe s ON a.soba_id = s.id JOIN kraji k ON a.kraj_id = k.id
        WHERE (a.vrsta = 'odobreno')";
        $result = mysqli_query($link, $sql);
    }
if(isset($_POST['reset'])) {
    $dodatki = $_POST['dodatki'] ?? [];
    $min_cena = $_POST['min_cena'];
    $max_cena = $_POST['max_cena'];
        
}   
?>
<div id="filter">
    <h2>izberi filtre</h2>
    <div id="izbira">
        <form action="#" method="post">
            <label>Dodatki:</label><br>
            <?php
                require_once 'baza.php';
                $sqlFilter = "SELECT id, ime FROM dodatki";
                $resultFilter = mysqli_query($link, $sqlFilter);
                while ($row = mysqli_fetch_array($resultFilter)) {
                   echo '<input type="checkbox" name="dodatki[]" value="' . $row['id'] . '">' . $row['ime'] . '<br>';
                }
            ?>
            <!--<input type="checkbox" name="dodatki[]" value="Bazen">Bazen<br>
            <input type="checkbox" name="dodatki[]" value="Wi-Fi">Wifi<br>
            <input type="checkbox" name="dodatki[]" value="Klimatska naprava">Klimatska naprava<br>
            <input type="checkbox" name="dodatki[]" value="Parking">Parkirišče<br>
            <input type="checkbox" name="dodatki[]" value="Kuhinja">Kuhinja<br>
            <input type="checkbox" name="dodatki[]" value="Terasa">Terasa<br>
            <input type="checkbox" name="dodatki[]" value="Zajtrk">Zajtrk<br>
            <input type="checkbox" name="dodatki[]" value="Kosilo">Kosilo<br>
            <input type="checkbox" name="dodatki[]" value="Vecerja">Večerja<br>
            <input type="checkbox" name="dodatki[]" value="Savna">Savna<br>-->
            <label>Cena na noč</label><br>
            Minimalna cena:<input type="number" name="min_cena" value="<?php echo isset($_POST['min_cena']) ? ($_POST['min_cena']) : ''; ?>"><br>
            Maksimalna cena: <input type="number" name="max_cena" value="<?php echo isset($_POST['max_cena']) ? ($_POST['max_cena']) : ''; ?>"><br>
            <input type="submit" name="submi" value="Filtriraj"><br>
            <input type="submit" name="reset" value="Ponastavi"><br>
        </form>
    </div>
</div>
<style>
    #izbira{
        width: 310px;
        border: solid black 1px;
        padding: 10px;
    }
    label{
        font-size: 20px;
        font-weight: bold;
    }
    input{
        margin: 5px;
    }
    body{
        position: relative;
    }
    #filter{
        position: absolute;
        top: 200px;
        left: 50px;
    }
</style>