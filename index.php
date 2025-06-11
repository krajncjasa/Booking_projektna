<?php
require_once 'baza.php';
$query = "SELECT id, ime FROM kraji";
$result = mysqli_query($link, $query);

?>
<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="UTF-8">
        <title>Vnos datuma</title>
        <style>
            .pozdrav{
                margin: 100px;
                font-size: 50px;
            }
            #kraji{
                margin-left: 100px;
            }
            #subm{
                margin-left: 100px;
            }
            .forma{
                margin: 30px;
                width: 170px;
                height: 50px;
            }
        </style>
    </head>
    <body>
    <?php include 'glava.php'; ?>
    <?php
        if(isset($_SESSION['log']) && $_SESSION['log'] === TRUE) {
                echo '<h1 class="pozdrav">Pozdravljeni ' .$_SESSION['name'] . " " . $_SESSION['surname']. ', kam želite danes?</h1>';
            } else {
                echo '<h1 class="pozdrav">Poiščite naslednjo nastanitev</h1>';
            }
        ?>
        <form method="post" action="izpis_apartmajev.php">
        <select class="forma" name="kraj" required id="kraji">
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value='" .$row['id'] . "'>" .$row['ime']. "</option>";
            }
            ?>
        </select>
        Od:<input type="date" name="zacetek_rez" class="forma" required placeholder="Vnesite datum" min="<?php echo date('Y-m-d'); ?>" id="zacetek_rez" onchange="this.form.konec_rez.min=this.value">
        Do:<input type="date" name="konec_rez" class="forma" required placeholder="Vnesite datum" id="konec_rez" min="<?php echo date('Y-m-d'); ?>">
        <input type="number" name="st_otrok" class="forma" min="0" required placeholder="Vnesite število otrok">
        <input type="number" name="st_odraslih" class="forma" min="0" required placeholder="Vnesite število odraslih"><br>
        <input type="submit" name="subm" value="Pošlji" class="forma" id="subm">
        <input type="button" name="prikaz_vseh" value="Prikaz vseh nastanitev" class="forma" onclick="window.location.href='izpis_apartmajev_vseh.php'">
        </form>
    </body>
</html>