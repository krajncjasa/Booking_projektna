<?php
/*
include 'baza.php';

// Preverite, ali je datoteka slika
if (isset($_POST["submit"])) {

    $id = $_GET['ida'];

    $target_dir = "uploads/"; // Mapa za shranjevanje slik
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "Datoteka je slika - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Datoteka ni slika.";
        $uploadOk = 0;
    }
    // Preverite, ali je datoteka že obstajala
    if (file_exists($target_file)) {
        echo "Opravičujemo se, datoteka že obstaja.";
        $uploadOk = 0;
    }

    // Omejite velikost datoteke (tukaj omejitev na 5MB)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Opravičujemo se, datoteka je prevelika.";
        $uploadOk = 0;
    }

    // Dovoljeni tipi datotek (jpg, jpeg, png, gif)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Opravičujemo se, samo slike (JPG, JPEG, PNG, GIF) so dovoljene.";
        $uploadOk = 0;
    }

    // Če je vse v redu, poskusite naložiti datoteko
    if ($uploadOk == 0) {
        echo "Opravičujemo se, vaša datoteka ni bila naložena.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "Datoteka " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " je bila naložena.";

            // Shranite pot slike in apartma_id v bazo
            $imagePath = $target_file;
            $imageName = basename($_FILES["fileToUpload"]["name"]);
            $apartma_id = $_POST["apartma_id"]; // Predpostavljamo, da je apartma_id poslan z obrazcem

            // Pripravite SQL poizvedbo za shranjevanje podatkov v bazo
            $sql = "INSERT INTO slike (apartma_id, image_name, image_path) VALUES $id, $imageName, $target_file)";

            // Pripravite in izvedite poizvedbo
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("iss", $apartma_id, $imageName, $imagePath);
                if ($stmt->execute()) {
                    echo "Podatki o sliki so bili shranjeni v bazo.";
                } else {
                    echo "Napaka pri shranjevanju podatkov v bazo.";
                }
                $stmt->close();
            } else {
                echo "Napaka pri pripravi poizvedbe.";
            }
        } else {
            echo "Opravičujemo se, pri nalaganju slike je prišlo do napake.";
        }
    }
}

?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Dodaj sliko apartmaju</h1>
    <form action="#" method="POST">
        <input type="file" name="fileToUpload" required enctype="multipart/form-data"><br>
        <input type="submit" name="dodaj" value="Dodaj sliko">
    </form>
</body>
</html> -->