<!doctype html>
<html lang="de">
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
    <?php include("class_File.php") ?>
</head>


<body>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Spiel Initialisierung - Spielneustart /////////////////////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

<?php

// Verzeichnis kontrollieren

// Funktionsdefinition
function create_dir($path,$chmod=0777) {
    if(!(is_dir($path) OR is_file($path) OR is_link($path) ))
        return mkdir ($path,$chmod);
    else
        return false;
}

// Aufruf für Unterordner CSV
create_dir("CSV");




// Session starten
session_start();

// Objekte Instanzieren
$Instanz_Begriff = new BEGRIFF();
$Instanz_View = new KEYBOARD();
$Instanz_Galgen = new GALGEN();
$Instanz_WoerterListe = new WOERTERLISTE();
$Instanz_Punktestand = new PUNKTESTAND();
$Instanz_File = new File();

// Sessionvariablen zurücksetzen
$_SESSION["Index_Index_Level"] = NULL;
$_SESSION["Index_Index_Name"] = "";

// Woerterliste in Levels aufbereiten
//$Instanz_WoerterListe->WoerterNachLevelsSortieren();

// Beim Erststart von Session_start müssen die Indexe definiert werden
//$_SESSION["Datenbank_BegriffLaden_IndexGebraucht"] = array(); //////////////////////// Eventuell in Begriff-> Neustart zurücksetzen
$Instanz_Begriff->Neustart($Instanz_WoerterListe->WoerterNachLevelsLaden() );

//$Instanz_Begriff->NeuerBegriffLaden($Instanz_Begriff->Zufallsbegriff($Instanz_WoerterListe->WoerterNachLevelsLaden() ) );
$Instanz_View->Neustart();
$Instanz_Galgen->Setzen(false, true);

?>



<div class="wrapper">

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Spielsteuerung für Index Seite - Spieleinstellungen /////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

    <!-- Hilfs Div zum Einmitten und überlagern der Buttons auf das Spielfeld   -   Wrapper ohne ocavity  -->
    <div class="wrapper_middle">
        <!-- Hilfs Div zum Einmitten und überlagern der Buttons auf das Spielfeld -->
        <div class="wrapper_button">

            <!-- Spielkonfiguration -->
            <form action="index.php" method="post">

            <!-- Schwierigkeitsgrad auswählen -->

            <h1> Level auswählen: </h1>

            <select class="Index_Level" name="Index_Level" size="3">
                <option>Sehr Leicht</option>
                <option>Leicht</option>
                <option>Mittel</option>
                <option>Schwer</option>
                <option>Sehr Schwer</option>
            </select>

            <br>
            <br>

            <!-- Spielername eingeben -->

            <h1> Spielername: </h1>
            <br>
            <br>

            <input class="Index_Name" type="text" name="Index_Name" id="Index_Name" placeholder="Spielername">

            <br>
            <br>
            </form>


            <!-- Spielstart -->
                <!-- Spielstart erst freigeben,wenn alle Eingabenbetätigt wurden -->
                <?php
                if ( isset($_POST["Index_Name"]) && isset($_POST["Index_Level"])    ) {  // && isset($_POST["Index_Level"]  )

                    echo '<form action="Hangman.php" method="post">';
                    echo '<br>';
                    echo '<br>';
                    echo '<input type="submit" name="Index_Start" id="Index_Start" value="Spiel Starten">';
                    echo '</form>';

                    // Eingaben in Sessionvariablen Speichern
                    $_SESSION["Index_Index_Level"] = $_POST["Index_Level"];
                    $_SESSION["Index_Index_Name"] = $_POST["Index_Name"];
                }

                ?>

        </div>




    </div>

</div>
</body>
</html>