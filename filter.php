<div id="filter">
    <h2>izberi filtre</h2>
    <div id="izbira">
        <form action="izpis_apartmajev_vseh.php" method="post">
            <label>Dodatki:</label><br>
            <?php
                require_once 'baza.php';
                $sqlFilter = "SELECT id, ime FROM dodatki";
                $resultFilter = mysqli_query($link, $sqlFilter);
                while ($row = mysqli_fetch_array($resultFilter)) {
                   echo '<input type="checkbox" name="dodatki[]" value="' . $row['id'] . '"'
                    . (isset($_POST['dodatki']) && in_array($row['id'], $_POST['dodatki']) ? ' checked' : '')
                    . '> ' . htmlspecialchars($row['ime']) . "<br>\n";
                }
            ?>


            <label>Cena na noč</label><br>
            Minimalna cena:<input type="number" name="min_cena" value="<?php echo isset($_POST['min_cena']) ? ($_POST['min_cena']) : ''; ?>"><br>
            Maksimalna cena: <input type="number" name="max_cena" value="<?php echo isset($_POST['max_cena']) ? ($_POST['max_cena']) : ''; ?>"><br>
            <input type="submit" name="subm" value="Filtriraj"><br>
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