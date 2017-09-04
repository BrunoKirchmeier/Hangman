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
<!-- /////////////////////////////// Funktionen /////////////////////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

<?php
?>



<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Spiel Initialisierung - Spielneustart /////////////////////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

<?php

// Verzeichnis kontrollieren

// Funktionsdefinition Pfad erstellen für Unterordner
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

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Spielsteuerung   -  Spieleinstellungen /////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

<?php

// Spielername Validierung
if (isset( $_POST["Index_Name"] )) {
    $Spielername = $_POST["Index_Name"];
}
// alternativwert
else {
    $Spielername = "";
}


// Level Validierung
if (isset($_POST["Index_Level"]) ) {
    $Level = $_POST["Index_Level"];
}
// alternativwert
else {
    $Level = 1 ;
}

?>


<div class="wrapper">

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Visualisierung  -  Spieleinstellungen /////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

    <!-- Hilfs Div zum Einmitten und überlagern der Buttons auf das Spielfeld   -   Wrapper ohne ocavity  -->
    <div class="wrapper_middle">
        <!-- Hilfs Div zum Einmitten und überlagern der Buttons auf das Spielfeld -->
        <div class="wrapper_button">

            <!-- Spielkonfiguration -->
            <form action="index.php" method="post">

            <!-- Schwierigkeitsgrad auswählen  selected="selected"  onclick="SelectBoxSetzen(1)" -->

            <h1> Level auswählen: </h1>

                <?php
                echo '<select class="Index_Level" name="Index_Level" size="3" onchange="this.form.submit()" >' ;
                    echo '<option>Sehr Leicht</option>';
                    echo '<option>Leicht</option>';
                    echo '<option>Mittel</option>';
                    echo '<option>Schwer</option>';
                    echo '<option>Sehr Schwer</option>';
                echo '</select>';
                ?>

            <br>
            <br>

            <!-- Spielername eingeben -->

            <h1> Spielername: </h1>
            <br>
            <br>

                <!-- Spielername in Value zur Validierung speichern -->
                <?php
                    echo '<input class="Index_Name" type="text" name="Index_Name" id="Index_Name" placeholder="Spielername"
                          value="' .$Spielername .'"' .'onchange="this.form.submit()">' ;
                ?>

            <br>
            <br>
            </form>

            <?php
            // Eingaben in Sessionvariablen Speichern

            // Name
            if ( isset($_POST["Index_Name"]) ) {
                $_SESSION["Index_Index_Name"] = $_POST["Index_Name"];
            }

            // Level
            if ( isset($_POST["Index_Level"]) ) {
                $_SESSION["Index_Index_Level"] = $_POST["Index_Level"];
            }
            ?>

            <!-- Spielstart -->
                <!-- Spielstart erst freigeben,wenn alle Eingabenbetätigt wurden -->
                <?php
                if ( isset($_SESSION["Index_Index_Name"]) && ($_SESSION["Index_Index_Name"] <> "") && isset($_SESSION["Index_Index_Level"])    ) {  // if ( isset($_POST["Index_Name"]) && ($_POST["Index_Name"] <> "") && isset($_POST["Index_Level"])

                    echo '<form action="Hangman.php" method="post">';
                    echo '<br>';
                    echo '<br>';
                    echo '<input type="submit" name="Index_Start" id="Index_Start" value="Spiel Starten">';
                    echo '</form>';

                    // Eingaben in Sessionvariablen Speichern
                    //$_SESSION["Index_Index_Level"] = $_POST["Index_Level"];
                    //$_SESSION["Index_Index_Name"] = $_POST["Index_Name"];
                }

                ?>

        </div>




    </div>

</div>
</body>
</html>