<?php
require_once 'baza.php';
include_once 'seja.php';
$query = "SELECT id, ime FROM kraji";
$result = mysqli_query($link, $query);

if (isset($_POST['subm'])){
    if(isset($_SESSION['log']) && $_SESSION['log'] == TRUE){
        $zacetek_rez = $_POST['zacetek_rez'];
        $konec_rez = $_POST['konec_rez'];
        $st_otrok = $_POST['st_otrok'];
        $st_odraslih = $_POST['st_odraslih'];
        $id = $_GET['ida'];
        $max_ljudi = isset($_GET['ido']) ? (int)$_GET['ido'] : 0;
        $skupno = $st_otrok + $st_odraslih;
        if($skupno <= $max_ljudi){
            $query = "INSERT INTO rezervacije (zacetek_rez, konec_rez, st_otrok, st_odraslih, apartma_id, uporabnik_id)
                    VALUES ('$zacetek_rez', '$konec_rez', '$st_otrok', '$st_odraslih', (SELECT id FROM apartmaji a WHERE id = '$id'), (SELECT id FROM uporabniki u WHERE u.id = '".$_SESSION['idu']."'))";
                    $result2 = mysqli_query($link, $query);
        }else{
            echo "<p>Presegli ste dovoljeno število oseb v apartmaju!</p>";
        }
    }else{
        header("Location: prijava.php");
        exit();
    }
}

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
                margin-top: 30px;
            }
            .forma{
                margin-left: 100px;
                width: 170px;
                height: 50px;
            }
            #od{
                margin-left: 100px;
            }
        </style>
    </head>
    <body>
    <?php include 'glava.php'; ?>
        <h1 class="pozdrav">Rezervacija apartmaja</h1>
        <form method="post" action="#">
            <span id="od">Od:<input type="date" name="zacetek_rez" class="forma" required placeholder="Vnesite datum" min="<?php echo date('Y-m-d'); ?>" id="zacetek_rez" onchange="this.form.konec_rez.min=this.value">
            Do:<input type="date" name="konec_rez" class="forma" required placeholder="Vnesite datum" id="konec_rez" min="<?php echo date('Y-m-d'); ?>">
            <input type="number" name="st_otrok" class="forma" min="0" required placeholder="Vnesite število otrok">
            <input type="number" name="st_odraslih" class="forma" min="0" required placeholder="Vnesite število odraslih"><br>
            <input type="submit" name="subm" value="Pošlji" class="forma" id="subm"></span>
        </form>
    </body>
</html>