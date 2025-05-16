<?php
/*povezava na strežnik do baze*/
$host="localhost";
$user="root";
$password="";
$database="booking_projektna";

$link= mysqli_connect($host, $user, $password, $database)
        or die("Ne morem do baze");
/*kodiranje znakov*/
mysqli_set_charset($link, "utf8");