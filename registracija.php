<?php
require_once 'baza.php';
$sql="SELECT * FROM kraji;";
$result = mysqli_query($link, $sql);
if(isset($_POST['subm'])){ 
    require 'baza.php';

    $i=$_POST['ime'];

    $p=$_POST['priimek'];

    $m=$_POST['email']; 

    $g=$_POST['geslo'];

    $t=$_POST['tel'];

    $n=$_POST['naslov'];

    $k=$_POST['posta'];

    // echo "$i  $p in $m in GESLO: $g in POŠTA $k";
    $query_kraj = "SELECT id FROM kraji WHERE ime = '$k' ORDER BY ime ASC";
    $result_kraj = mysqli_query($link, $query_kraj);

    $query_mail = "SELECT email FROM uporabniki WHERE email = '$m'";
    $result_mail = mysqli_query($link, $query_mail);

    if(mysqli_num_rows($result_mail) > 0){
        echo "Uporabnik z tem e-mailom že obstaja!";
    }else{
        $query = "INSERT INTO uporabniki (ime, priimek, email, geslo, telefon, naslov, vrsta, kraj_id) VALUES ('$i', '$p', '$m', '$g', '$t', '$n', 'navaden', '$k')";
        $result = mysqli_query($link,$query);

        if($result){	
        echo "vsatvljeno v bazo";
        header("Location: prijava.php");
        exit(); // Pomembno je, da uporabimo exit(), da se prekinje nadaljnje izvajanje skripte
    }
    }


}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once 'glava.php';?>
    <div id="obrazec">
    <h1>Vnesite podatke</h1>
    <form action="#" method="POST"> 
        Ime: <input class="vnos" type="text" name="ime" required placeholder="Vnesite ime"><br>
        Priimek: <input class="vnos" type="text" name="priimek" required placeholder="Vnesite priimek"><br>
        Mail: <input class="vnos" type="mail" name="email" required placeholder="Vnesite e-mail"><br> 
        Geslo: <input class="vnos" type="password" name="geslo" required placeholder="Vnesite geslo"><br>
        Telefonska: <input class="vnos" type="tel" name="tel" required placeholder="Vnesite telefonsko številko"><br>
        Naslov: <input class="vnos" type="text" name="naslov" required placeholder="Vnesite naslov"><br>
        Kraj:<select class="vnos" name="posta" required>
		<?php
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" .$row['id'] . "'>" .$row['ime']. "</option>";
        }
        ?>
        </select> <br>

        
        <input type="submit" name="subm" value="Pošlji">
    </form>
    </div>
</body>
</html>