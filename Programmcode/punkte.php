<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">

    <?php include("class_view.php") ?>
    <?php include("class_begriff.php") ?>
    <?php include("class_galgen.php") ?>
    <?php include("class_Woerterliste.php") ?>
    <?php include("class_punktestand.php") ?>
</head>
<body>

<?php
// Objekte Instanzieren
$Instanz_Begriff = new BEGRIFF();
$Instanz_View = new KEYBOARD();
$Instanz_Galgen = new GALGEN();
$Instanz_WoerterListe = new WOERTERLISTE();
$Instanz_Punktestand = new PUNKTESTAND();

// Session starten
session_start();
?>



<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Visualisierung HMML Aufbau der Seite  /////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->


<div class="wrapper">

    <!--   Button zur Rückkehr zum Spiel  -->
    <form action="Hangman.php" method="post">
        <input class="ButtonReturnGame" type="submit" name="ReturnGame" id="TasteReturnGame" value="Zurück">
    </form>


    <!--   Ausgabe der Punktetabellen oder eines Ersatztextes  -->
    <?php
    // Level sehr leicht
    if ($Instanz_Punktestand->AnzeigeBesteSpieler("CSV/Hiscoreliste_sehr_leicht.csv", "Schwierigkeitsgrad sehr leicht") == false )  {
    echo '<h1 class="punktephp_h1"> Schwierigkeitsgrad sehr leicht ist noch Leer </h1>';
    }

    // Level leicht
    if ($Instanz_Punktestand->AnzeigeBesteSpieler("CSV/Hiscoreliste_leicht.csv", "Schwierigkeitsgrad leicht") == false ) {
    echo '<h1 class="punktephp_h1"> Schwierigkeitsgrad leicht ist noch Leer </h1>';
    }

    // Level mittel
    if ($Instanz_Punktestand->AnzeigeBesteSpieler("CSV/Hiscoreliste_mittel.csv", "Schwierigkeitsgrad mittel") == false  ) {
    echo '<h1 class="punktephp_h1"> Schwierigkeitsgrad mittel ist noch Leer </h1>';
    }

    // Level schwer
    if ($Instanz_Punktestand->AnzeigeBesteSpieler("CSV/Hiscoreliste_schwer.csv", "Schwierigkeitsgrad schwer") == false  ) {
    echo '<h1 class="punktephp_h1"> Schwierigkeitsgrad  schwer ist noch Leer </h1>';
    }

    // Level sehr schwer
    if ($Instanz_Punktestand->AnzeigeBesteSpieler("CSV/Hiscoreliste_sehr_schwer.csv", "Schwierigkeitsgrad sehr schwer") == false ) {
    echo '<h1 class="punktephp_h1"> Schwierigkeitsgrad sehr schwer ist noch Leer </h1>';
    }

    ?>

    <br>
    <br>

</div>






</body>
</html>