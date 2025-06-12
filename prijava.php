<?php

require_once 'baza.php';
include_once 'seja.php';

if(isset($_POST['subm'])){  
    $m = mysqli_real_escape_string($link, $_POST['email']);
    $g = mysqli_real_escape_string($link, $_POST['geslo']);

    $h = sha1($g);

    $query = "SELECT * FROM uporabniki WHERE email='$m' AND geslo='$h'";
    $result = mysqli_query($link, $query);

    if($_POST['email'] == 'admin@gmail.com' && $_POST['geslo'] == 'admin'){
        $_SESSION['log'] = TRUE;
        $_SESSION['name'] = 'admin';
        $_SESSION['surname'] = 'admin';
        $_SESSION['log'] = TRUE;
        header("Location: admin.php");
    } else if($result && mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['name'] = $row['ime'];
        $_SESSION['surname'] = $row['priimek'];
        $_SESSION['idu'] = $row['id'];
        $_SESSION['log'] = TRUE;
        header("Location: index.php");
        exit(); // Pomembno je, da uporabimo exit(), da se prekinje nadaljnje izvajanje skripte
    } else {
        echo "Napaka pri prijavi. Preverite uporabniško ime in geslo.";
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>prijava</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include 'glava.php'; ?>
    <div id="obrazec">
    <h1>Prijava</h1>
    <form action="#" method="POST"> 
        Mail: <input class="vnos" type="mail" name="email" required placeholder="Vnesite e-mail"><br> 
        Geslo: <input class="vnos" type="password" name="geslo" required placeholder="Vnesite geslo"><br>
        <input type="submit" name="subm" value="Pošlji">
    </form>
    </div>
    </body>
</html>
