<div>
    <div id="glava">
        <?php
        if(isset($_SESSION['name']) && $_SESSION['name'] == 'admin'){
            echo '<a><h1 id="naslov">KaoBooking</h1></a>';
        } else{
            echo '<a href="index.php"><h1 id="naslov">KaoBooking</h1></a>';
        }
        include_once 'seja.php';
        include 'baza.php';

        if(isset($_SESSION['name']) && $_SESSION['name'] == 'admin') {
            echo '<a href="odjava.php"><button class="gumbi1">Odjava</button></a>';
            echo '<a href="index.php"><button class="gumbi1">Vnos apartmaja</button></a>';
        }else if(isset($_SESSION['log']) && $_SESSION['log'] === TRUE) {
                echo '<a href="odjava.php"><button class="gumbi1">Odjava</button></a>';
                echo '<a href="vnos_apartmaja.php"><button class="gumbi1">Vnos apartmaja</button></a>';
                echo '<a href="moj_profil.php"><button class="gumbi1">Moj profil</button></a>';
            } else {
                echo '<a href="prijava.php"><button class="gumbi1">Prijava</button></a>';
                echo '<a href="registracija.php"><button class="gumbi1">Registracija</button></a>';
            }
        ?>
    </div>
</div>
<style>
    #glava{
        background-color: blue;
        height: 150px;
    }
    body{
        margin: 0;
        padding: 0;
    }
    #naslov{
        color: white;
        float: left;
        margin: 50px;
    }
    .gumbi1{
        float: right;
        background-color: yellow;
        height: 45px;
        width: 100px;
        border-radius: 20px;
        margin: 50px;
        cursor: pointer;
        color: black;
    }
</style>