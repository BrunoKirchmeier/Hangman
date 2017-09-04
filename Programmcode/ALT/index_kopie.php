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
</head>


<body>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Spiel Initialisierung - Spielneustart /////////////////////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

<?php
// Session starten
session_start();

// Objekte Instanzieren
$Instanz_Begriff = new BEGRIFF();
$Instanz_View = new KEYBOARD();
$Instanz_Galgen = new GALGEN();
$Instanz_WoerterListe = new WOERTERLISTE();
$Instanz_Punktestand = new PUNKTESTAND();



// Beim Erststart von Session_start müssen die Indexe definiert werden
//$_SESSION["Datenbank_BegriffLaden_IndexGebraucht"] = array(); //////////////////////// Eventuell in Begriff-> Neustart zurücksetzen
$Instanz_Begriff->Neustart($Instanz_WoerterListe->WoerterNachLevelsLaden() );
//$Instanz_Begriff->NeuerBegriffLaden($Instanz_Begriff->Zufallsbegriff($Instanz_WoerterListe->WoerterNachLevelsLaden() ) );
$Instanz_View->Neustart();
$Instanz_Galgen->Setzen(false, true);

// Woerterliste in Levels aufbereiten
        //$Instanz_WoerterListe->WoerterNachLevelsSortieren();
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
            <form class="Index_Spielstart" action="index.php" method="post">

                <!-- Schwierigkeitsgrad auswählen -->
                <label>Schwierigkeitslevel wählen:
                    <br>
                    <br>
                    <select name="Index_Level" size="3">
                        <option>Einfach</option>
                        <option>Mittel</option>
                        <option>Schwer</option>
                    </select>
                </label>
                <br>
                <br>

                <!-- Spielername eingeben -->
                <input type="text" name="Index_Name" id="Index_Name" placeholder="Spielername">
                <br>
                <br>

            </form>


            <!-- Spielstart -->
                <!-- Spielstart erst freigeben,wenn alle Eingabenbetätigt wurden -->
                <?php
                if ( isset($_POST["Index_Name"] )  && isset($_POST["Index_Level"]  )  ) {  // && isset($_POST["Index_Level"] )

                    echo '<form action="Hangman.php">';
                    echo '<br>';
                    echo '<br>';
                    echo '<input type="submit" name="Index_Start" id="Index_Start" value="Spiel Starten">';
                    echo '</form>';
                }


                echo $_POST["Index_Name"];
                echo $_POST["Index_Level"];
                ?>
        </div>




    </div>

</div>
</body>
</html>