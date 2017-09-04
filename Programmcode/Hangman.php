<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <!--  <meta http-equiv='refresh' content='10; URL=Hangman.php' /> -->

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
<!-- /////////////////////////////// Spiel Initialisierung pro Seitenaufruf /////////////////////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->

<?php


// Objekte Instanzieren
$Instanz_Begriff = new BEGRIFF();
$Instanz_View = new KEYBOARD();
$Instanz_Galgen = new GALGEN();
$Instanz_WoerterListe = new WOERTERLISTE();
$Instanz_Punktestand = new PUNKTESTAND();
$Instanz_File = new File();

// Session starten
session_start();

// Variablen initialisieren
$SchwierigkeitslevelText = $_SESSION["Index_Index_Level"];

// Schwierigkwitsgrad    1=SEHR LEICHT     /   5=SEHR SCHWER
if ($SchwierigkeitslevelText == "Sehr Leicht") {
    $SchwierigkeitslevelWert = 1;
}
elseif ($SchwierigkeitslevelText == "Leicht") {
    $SchwierigkeitslevelWert = 2;
}
elseif ($SchwierigkeitslevelText == "Mittel") {
    $SchwierigkeitslevelWert = 3;
}
elseif ($SchwierigkeitslevelText == "Schwer") {
    $SchwierigkeitslevelWert = 4;
}
elseif ($SchwierigkeitslevelText == "Sehr Schwer") {
    $SchwierigkeitslevelWert = 5;
}
else {
    echo '<script type="text/javascript" language="Javascript"> alert("Error Hangman.php mit $Schwierigkeitslevel_Text")</script>';
}
?>

<!-- NUR EINMALIGES INIT NACH INEDXSEITE - Sprung von Indexseite -->
<?php
if ( isset($_POST["Index_Start"] ) ) {

    // Punkteliste neu Initialisieren
    $Instanz_Punktestand->Neustart($_SESSION["Index_Index_Name"]);

    // Jokkers initialisieren
    $_SESSION["Hangman_JokerNeuesWort"] = 1;
    $_SESSION["Hangman_JokerZeichenKaufen"] = 5;
    $_SESSION["Hangman_Spielrunde"] = 1;

    // Taste Spiel beenden entrieggeln
    $_SESSION["Hangman_Taste_SpielBeenden"] = false;
}

?>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Spielsteuerung PHP  /////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->


<?php
////////////////////////////////////////////////////// Begriff und Galgen  - Spiel ist aktiv kein GAME OVER/////////////////////////////////////////////////////////////

if (! $Instanz_Galgen->GameOver() ) {

    // Returnwert von Zeichensetzen ist ob TRUE=Vorhanden oder  FALSE=Nichtvorhanden
    // ODER Jokker aktiviert wird - ist jeweils ein korrektes Zeichen gesetzt worden - Dies wird gespeichert
    if ($Instanz_Begriff->Zeichensetzen( $Instanz_View->GetZeichen() ) && !isset($_POST["JokerZeichenKaufen"] ) && !isset($_POST["JokerNeuesWort"]) ) { // || isset($_POST["JokerZeichenKaufen"] ) || isset($_POST["JokerNeuesWort"])
        $Instanz_View->VersuchteZeichenKorrekt( $Instanz_View->GetZeichen() );
    }
    // Zeichen im BEgriff nicht vorhanden
    elseif ( ! $Instanz_Begriff->Zeichensetzen( $Instanz_View->GetZeichen() ) && $Instanz_View->GetZeichen() <> "" )  {
        $Instanz_View->VersuchteZeichenFalsch( $Instanz_View->GetZeichen() );
        // Mit Returnwert wird geschaut ob Spiel GAME OVER ist - Mit PArameter TRUE wird ein Strich gesetzt
        $Game_Over = $Instanz_Galgen->Setzen(true);
    }

// Punkte sammeln nach Level - Level nach Spielrunden
    if ( $Instanz_Begriff->BegriffWurdeErraten() && ! isset($_POST["NächsterBegriff"] ) ) {
        $Instanz_Punktestand->Zaehlen();
    }

// Nächster Begriff laden sobald Spieleer diesen erratenhat
    if ( isset($_POST["NächsterBegriff"]) ) {

        // Neuer Begriff laden
        $Instanz_Begriff->NeuerBegriffLaden($Instanz_Begriff->Zufallsbegriff($Instanz_WoerterListe->WoerterNachLevelsLaden() ) );

        // Initialisierungen für neuen Begriff
        $Instanz_View->Neustart();
        $Instanz_Galgen->Setzen(false, true);

        // Session Spielrunden um eines erhöhen
        $_SESSION["Hangman_Spielrunde"] = $_SESSION["Hangman_Spielrunde"] + 1;
    }
}

////////////////////////////////////////////////////// GAME OVER -Funktioniert nicht mit ELSE, weil sonst Seite zuerst einen Refresh braucht /////////////////////////////////////////////////////////////

if ($Instanz_Galgen->GameOver() || isset($_POST["SpielBeenden"]) ) {

    // Variablen Initialisieren
    $ZwischenspeicherZusatzpunkte = 0;
    $StringToArray = array();

    // Abspeichern des aktuellen BEgtiffes in Liste
    $Instanz_File->Speichern("CSV//GameOverBegriffe.csv", $Instanz_Begriff->BegriffAktuell() );


// Punktestand mit Namen in CSV abspeichern
    //Zusatzpunkte berechenen pro Jokker Wort
    //$ZwischenspeicherZusatzpunkte = 1 * $_SESSION["Hangman_JokerNeuesWort"];

    //Zusatzpunkte berechenen pro Jokker Wort
    //$ZwischenspeicherZusatzpunkte = $ZwischenspeicherZusatzpunkte + (1 * $_SESSION["Hangman_JokerZeichenKaufen"]);

    // Speichern in Liste
    // Pro Schwierigkeitsgrad wir eine eigene CSV Liste erstellt
    // public function GameOver($Zusatzpunkte = 0, $Level = 1, $Filename = 'CSV/Hiscoreliste.csv')


    // Level Sehr leicht = 1
    if ($SchwierigkeitslevelWert == 1 ) {
        $Instanz_Punktestand->GameOver($ZwischenspeicherZusatzpunkte, $SchwierigkeitslevelWert, "CSV/Hiscoreliste_sehr_leicht.csv"  );
    }
    // Level leicht = 2
    elseif ( $SchwierigkeitslevelWert == 2 ) {
        $Instanz_Punktestand->GameOver($ZwischenspeicherZusatzpunkte, $SchwierigkeitslevelWert, "CSV/Hiscoreliste_leicht.csv"  );
    }
    // Level mittel = 3
    elseif ( $SchwierigkeitslevelWert == 3 ) {
        $Instanz_Punktestand->GameOver($ZwischenspeicherZusatzpunkte, $SchwierigkeitslevelWert, "CSV/Hiscoreliste_mittel.csv"  );
    }
    // Level schwer = 4
    elseif ( $SchwierigkeitslevelWert == 4 ) {
        $Instanz_Punktestand->GameOver($ZwischenspeicherZusatzpunkte, $SchwierigkeitslevelWert, "CSV/Hiscoreliste_schwer.csv"  );
    }
    // Level Sehr schwer = 5
    elseif ( $SchwierigkeitslevelWert == 5 ) {
        $Instanz_Punktestand->GameOver($ZwischenspeicherZusatzpunkte, $SchwierigkeitslevelWert, "CSV/Hiscoreliste_sehr_schwer.csv"  );
    }
}


////////////////////////////////////////////////////// Jokers  /////////////////////////////////////////////////////////////

// Joker - Neuer Begriff laden (dieser wird übersprungen
if ( isset($_POST["JokerNeuesWort"]) && ! $Instanz_Galgen->GameOver() ) {
    // Tastensteuerung - Nachdem Taste gedrückt wurde muss diese wieder zurückgesetzt werden (Flankengenerator)

    // Abspeichern des aktuellen Begtiffes in Liste
    $Instanz_File->Speichern("CSV//JokkerNeuesWortBegriffe.csv", $Instanz_Begriff->BegriffAktuell() );

    // Session für Speichern der Anzahl verbleibenden Jokers - Es wird ein Jokker abgezogen
    $_SESSION["Hangman_JokerNeuesWort"] = $_SESSION["Hangman_JokerNeuesWort"] - 1;

    // Für Anzeige verbleibende Joker darf der Wert nicht unter 0 sinken
    if ($_SESSION["Hangman_JokerNeuesWort"] < 0 ) {
        $_SESSION["Hangman_JokerNeuesWort"] = 0;
    }
    // Joker einsetzen - PHP Code
    if ($_SESSION["Hangman_JokerNeuesWort"] >= 0) {
        $Instanz_Begriff->NeuerBegriffLaden($Instanz_Begriff->Zufallsbegriff($Instanz_WoerterListe->WoerterNachLevelsLaden() ) );
        $Instanz_View->Neustart();
        $Instanz_Galgen->Setzen(false, true);
    }
    else {
        // Joker sind für dieses Spiel aufgebraucht
    }
}


// Joker - Ein einzelnes Zeichen verraten und überall setzen (es wird das aphabetisch erste Zeichen das vorkommt verraten)
elseif ( isset($_POST["JokerZeichenKaufen"]) && ! $Instanz_Galgen->GameOver() ) {

    // Variableninitialisierung
    $ZwischenwertZeichen = "";

    // Tastensteuerung - Nachdem Taste gedrückt wurde muss diese wieder zurückgesetzt werden (Flankengenerator)
    //$_POST["JokerZeichenKaufen"] = " ";
    // Einmaliges zusätzliches Neuladen der Seite, damit aktuelle Berechnung durchgeführt wird
    header('Location: Hangman.php');

    // Session für Speichern der Anzahl verbleibenden Jokers - Es wird ein Jokker abgezogen
    $_SESSION["Hangman_JokerZeichenKaufen"] = $_SESSION["Hangman_JokerZeichenKaufen"] - 1;

    // Für Anzeige verbleibende Joker darf der Wert nicht unter 0 sinken
    if ($_SESSION["Hangman_JokerZeichenKaufen"] < 0 ) {
        $_SESSION["Hangman_JokerZeichenKaufen"] = 0;
    }
    // Joker einsetzen - PHP Code
    if ($_SESSION["Hangman_JokerZeichenKaufen"] >= 0) {
        // Zeichen speichern, damit es mehrmals verwendetwerden kann
        $ZwischenwertZeichen = $Instanz_Begriff->ZeichenErkaufen();

        // Zeichen in Begriff + Keyboard verarveiten
        $Instanz_Begriff->Zeichensetzen( $ZwischenwertZeichen );
        $Instanz_View->VersuchteZeichenKorrekt( $ZwischenwertZeichen );
    } else {
        // Joker sind für dieses Spiel aufgebraucht
    }

}

?>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
<!-- /////////////////////////////// Visualisierung HMML Aufbau der Seite  /////////////////////////////////////////////////////////////  -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->


<!-- Definition Spielfeld in verschiedene Sektionen -->
<div class="wrapper">

    <div class="Spielfeld">
        <!--  Galgen  Visualisieren  -->
        <div class="box">
            <?php
            // Anzahl Versuche
            echo '<h1> Restversuche: ' .$Instanz_Galgen->Restversuche() .'</h1>';

            // Galgen
            $Instanz_Galgen->view();
            ?>
        </div>

        <!--  Begriff  Visualisieren  -->
        <div class="box">
            <?php
            // Anzeige der vollen Begiffes bei Game Over - Parameter True
            if ($Instanz_Galgen->GameOver() ) {
                $Instanz_Begriff->view(true);
            }
            // Ansonsten Anzeige der Eratenen Zeichen
            else {
                $Instanz_Begriff->view();
            }
            ?>
        </div>


        <!--  Keyboard  Visualisieren  -->
        <div class="box Keyboard">
            <?php
            // Bei GAME OVER ist Eingabe gesperrt
            if ($Instanz_Galgen->GameOver() ) {
                $Instanz_View->view(false);
            }
            // Bei GAME OVER ist Eingabe gesperrt
            else {
                $Instanz_View->view();
            }
            ?>
        </div>

        <div class="Spielfeld_Buttons box">
        <!--  Taste nächster Begriff Visualisieren sofern dieser erraten wurde -->
        <form action="Hangman.php" method="post">
            <?php
            // Kontrolle ob Begriff erraten wurde
            if ( $Instanz_Begriff->BegriffWurdeErraten() ) {
                echo '<input type="submit" name="NächsterBegriff" id="TasteNächsterBegriff" value="Nächster Begriff"> ';
            }
            ?>
        </form>
        </div>

    </div>

    <div class="Menu">

        <!--   INFOS  -->
        <div class="Kategorie Infos">
            <h2> Spieler Name: </h2>
            <?php echo '<h1>' .$Instanz_Punktestand->Spielername() .'</h1>'?>
            <h2> Aktueller Punktestand: </h2>
            <?php echo '<h1>' .$Instanz_Punktestand->AktuellePunktezahl() .'</h1>'?>
            <h2> Spielrunde: </h2>
            <?php echo '<h1>' .$_SESSION["Hangman_Spielrunde"] .'</h1>'?>
            <h2> Level: </h2>
            <?php echo '<h1>' .$SchwierigkeitslevelText .'</h1>'?>
        </div

        <!--   JOKKERS  -->
        <div class="Kategorie Jokker">

            <h2> Jokers: </h2>

            <form action="Hangman.php" method="post">
            <!--   Bei Game Over Klasse Button auf inaktiv stellen  -->
                <?php
                // Inaktive Eingabe
                if ($Instanz_Galgen->GameOver() || $_SESSION["Hangman_JokerNeuesWort"] <= 0 ) {
                    echo '<input type="submit" name="JokerNeuesWort" id="TasteJokerNeuesWort" value="Neuer Begriff" disabled> ';
                }
                // Aktive Eingabe
                else {
                    echo '<input type="submit" name="JokerNeuesWort" id="TasteJokerNeuesWort" value="Neuer Begriff" > ';
                }
                ?>

                <br>
                <h3> Verbleibende: </h3><?php echo '<h4>' .$_SESSION["Hangman_JokerNeuesWort"] .'</h4>' ?>
                <br>
                <br>

             <!-- Bei Game Over Klasse Button auf inaktiv stellen  -->
                <?php
                // Inaktive Eingabe
                if ($Instanz_Galgen->GameOver() || $_SESSION["Hangman_JokerZeichenKaufen"] <= 0 ) {
                    echo '<input type="submit" name="JokerZeichenKaufen" id="TasteJokerZeichenKaufen" value="Zeichen Kaufen" disabled> ';
                }
                // Aktive Eingabe
                else {
                    echo '<input type="submit" name="JokerZeichenKaufen" id="TasteJokerZeichenKaufen" value="Zeichen Kaufen"> ';
                }
                ?>

                <br>
                <h3> Verbleibende: </h3><?php echo '<h4>' .$_SESSION["Hangman_JokerZeichenKaufen"] .'</h4>' ?>

            </form>
        </div>

        <!--   Spielsteuerung  -->
        <div class="Kategorie Spielsteuerung">

            <h2> Spielsteuerung: </h2>


            <!--   Neues Spiel - Spiel beenden  -->
            <?php
            // Speicherfunktion für TasteSpiel beenden
            if ( isset($_POST["SpielBeenden"]) ) {
                $_SESSION["Hangman_Taste_SpielBeenden"] = true ;
            }

            // Neues Spiel - Erscheint erst bei Game Over oder bei Spiel beenden
            if ( $_SESSION["Hangman_Taste_SpielBeenden"] || $Instanz_Galgen->GameOver() ) {

                echo '<form action="index.php" method="post">';
                echo '<input class="ButtonSpielsteuerung" type="submit" name="SpielNeustarten" id="TasteSpielNeustarten" value="Spiel Neustarten">';
                echo '</form>';
            }
            // Spiel beenden - Dann wir auch der Punktestand gespeichert und auf GameOver gesprungen
            else {
                echo '<form action="Hangman.php" method="post">';
                echo '<input class="ButtonSpielsteuerung" type="submit" name="SpielBeenden" id="TasteSpielBeenden" value="Spiel beenden">';
                echo '</form>';
            }
            ?>

            <!--   Bestenliste anschauen  -->
            <form action="Punkte.php" method="post">
                <input class="ButtonPunktestand" type="submit" name="Punktestand" id="TastePunktestand" value="Punktestand">
            </form>

        </div>

    </div>

    <div class="clearfix"></div>

</div>

</body>
</html>

