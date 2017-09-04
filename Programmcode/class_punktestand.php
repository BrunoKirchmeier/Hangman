
<?php



class PUNKTESTAND
{

/////////////////////// PRIVATE FUNCTIONS //////////////////////////////////////////////////////////


/////////////////////// PUBLIC EIGENSCHAFTEN //////////////////////////////////////////////////////////


    // Filename für Bestenliste
    //private $Filename = 'CSV/Hiscoreliste.csv';


/////////////////////// PUBLIC FUNCTIONS //////////////////////////////////////////////////////////


    // Neues Spiel - Punktezählung beginnt von 0
    public function Neustart($Spielername)
    {
        // Sessionvariable für aktuelle Punkte und Spieler initilalisieren
        $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Spielername"] = $Spielername;
        $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"] = 0;
    }


    // Dem aktuellen Spieler die Punkte dazuaddieren - Mit PArameter kann der FAktor erhöht werden wenn gewünscht
    // Derzeit inaktiv, da level bei Spielbeginn gewählt wird und nicht im laufe des Spieles erhöt wird
    public function Zaehlen($Level = 1)
    {
        // Aktuelle Punktezahl laden
        $AktuellePunkte = $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"];

        // Punkte zusammenzählen anhand des aktuellen Levels

        // Level 1 - Punkte zusammenzählen
        if ($Level == 1 || "Sehr Leicht") {
            $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"] = $AktuellePunkte + 1;
            return $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"];
        } // Level 2 - Punkte zusammenzählen
        elseif ($Level == 2 || "Leicht") {
            $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"] = $AktuellePunkte + 2;
            return $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"];
        } // Level 3 - Punkte zusammenzählen
        elseif ($Level == 3 || "Mittel") {
            $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"] = $AktuellePunkte + 3;
            return $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"];
        } // Level 4 - Punkte zusammenzählen
        elseif ($Level == 4 || "Schwer") {
            $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"] = $AktuellePunkte + 4;
            return $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"];
        } // Level 5 - Punkte zusammenzählen
        elseif ($Level == 5 || "Sehr Schwer") {
            $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"] = $AktuellePunkte + 5;
            return $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"];
        } // ungültige Levels
        else {
            echo '<script type="text/javascript" language="Javascript"> alert("Ungültige Level Eingabe")</script>';
        }
    }


    // Ausgabe des aktuellen Spielernamens
    public function Spielername()
    {
        // Ausgabe des aktuellen Spielers
        return $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Spielername"];
    }


    // Ausgabe der aktuellen Punktezahl
    public function AktuellePunktezahl()
    {
        // Ausgabe der aktuellen Punktezahl
        return $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"];
    }








    // Spiel ist beendet - Es können noch Zusatzpunkte z.B. durch nicht gebrauchte Jokker etc. vergeben werden
    // Die effektiven Punkte werden in ein Multiarray mit maximal 10 Einträgen der Bestenliste gespeichert
    public function GameOver($Zusatzpunkte = 0, $Level = 1, $Filename = 'CSV/Hiscoreliste.csv')
    {
        // Variablendefinition
        $ListenlaengeHiscore = 10;
        $FilePositionSpeichernPunkzezahl = 1000;  // Höher setzen als letzmöglicher Listeneintrag -> Sofern benötigt wird er tiefer gesetzt
        $fileLaden = array(array());
        $fileSpeichern = array(array());

        // Aktuelle Punktezahl und spielername  aus Session holen
        $AktuellerSpieler = $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Spielername"];
        $AktuellePunkte = $_SESSION["Punktestand_Neustart_AktuellePunkte"]["Punkte"] + $Zusatzpunkte;

        // Punkte und Name in Bestenliste speichern. Dafür muss aktuelle Liste geladen werden. Danach werden die Punkte in der Liste
        // nach grösse in der richtigen Position eingesetzt und die anderen aktuellen Einträge verscchoben.
        // Es werden nur 10 Einträgegespeichert, mehrnicht

        // 1. File lesen sofern existent //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        if (file_exists($Filename)) {
            // File öffnen
            $fp = fopen($Filename, "r");
            //Mit Funktion File wird Zeilenweise eingelesen aber mit File get content alles in ein einfaches Array
            $fileLaden = file($Filename);
            // File wieder schliessen
            fclose($fp);

            // File hat pro Zeilejeweils zuerst den Namen, und dann die Punktezahl gespeichert (asl CSV mit Kommaseperator getrennt)
            // Jeweils den Level, Namen und die Punktezahl in ein voneinander trennen und in ein Multyarray speichern

            ////////////////////////////////////////////////////////////////
            // Index 0 = NAME  / Index 1 = PUNKTE  /  Index 2 = LEVEL
            ////////////////////////////////////////////////////////////////
            for ($i = 0; $i < count($fileLaden); $i++) {
                $Datenbank[$i] = mb_split(",", $fileLaden[$i]);
            }

            // Nun die geeignete Stelle suchen im File, wo die aktuellen Punktezahl eingefügt werden soll
            for ($i = count($fileLaden); $i >= 0; $i--) {
                if (isset ($Datenbank[$i][1])) {
                    if ($AktuellePunkte > $Datenbank[$i][1]) {
                        $FilePositionSpeichernPunkzezahl = $i;
                    }
                }
            }

            //  Punkte in Top 10 neu anordnen nach grösse und allenfalls letzten  Weert herauslöschen
            //$Datenbank[$FilePositionSpeichernPunkzezahl][0]  => achtung 1x Durchlauf mehr, da ja ein neuer Datenounkt dazukommen kann
            for ($i = 0; $i < $ListenlaengeHiscore; $i++) {

                // Achtung musste explizite Typumwandlung bei zahl machen,sonst ergab esFehler mit Konvertierung im CSV File auf String
                if ($i < $FilePositionSpeichernPunkzezahl) {
                    // Achtung bei undefinierten Werten eine Vorgabe setzten
                    if (isset($Datenbank[$i][0])) {
                        $fileSpeichern[$i][0] = $Datenbank[$i][0];  //String
                        $fileSpeichern[$i][1] = (int)$Datenbank[$i][1];  // Zahl
                        $fileSpeichern[$i][2] = (int)$Datenbank[$i][2];  // Zahl
                    } else {
                        $fileSpeichern[$i][0] = "Leer";
                        $fileSpeichern[$i][1] = 0;
                        $fileSpeichern[$i][2] = 0;
                    }
                } // Neuer Punktestand wird in abzuspeicherndes Array eingefügt
                elseif ($i == $FilePositionSpeichernPunkzezahl) {
                    // Achtung bei undefinierten Werten eine Vorgabe setzten
                    if (isset($Datenbank[$i][0])) {
                        $fileSpeichern[$i][0] = $AktuellerSpieler;  //String
                        $fileSpeichern[$i][1] = (int)$AktuellePunkte;  // Zahl
                        $fileSpeichern[$i][2] = (int)$Level;  // Zahl
                    } else {
                        $fileSpeichern[$i][0] = "Leer";
                        $fileSpeichern[$i][1] = 0;
                        $fileSpeichern[$i][2] = 0;
                    }
                } // Neuer Punktestand wird in abzuspeicherndes Array eingefügt
                elseif ($i > $FilePositionSpeichernPunkzezahl) {
                    // Achtung bei undefinierten Werten eine Vorgabe setzten
                    if (isset($Datenbank[$i][0])) {
                        $fileSpeichern[$i][0] = $Datenbank[$i - 1][0];  //String
                        $fileSpeichern[$i][1] = (int)$Datenbank[$i - 1][1];  // Zahl
                        $fileSpeichern[$i][2] = (int)$Datenbank[$i - 1][2];  // Zahl
                    } else {
                        $fileSpeichern[$i][0] = "Leer";
                        $fileSpeichern[$i][1] = 0;
                        $fileSpeichern[$i][2] = 0;
                    }
                }
            }
        } // 1. File lesen sofern existent //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        else {
            // Sofern File nicht exisiert, Liste mit vordefonoerten Feldern befüllen
            // Feld 1 mir aktuellen DAten
            $fileSpeichern[0][0] = $AktuellerSpieler;
            $fileSpeichern[0][1] = (int)$AktuellePunkte;
            $fileSpeichern[0][2] = (int)$Level;  // Zahl

            // Feld 1 bis 10 mit statischen DAten
            for ($i = 1; $i < $ListenlaengeHiscore; $i++) {
                $fileSpeichern[$i][0] = "Leer";
                $fileSpeichern[$i][1] = 0;
                $fileSpeichern[$i][2] = 0;
            }
        }


        // Neues Array mit aktuellem Punktestand neu abspeichern

        // CSV File eröffnen und laden
        $fp = fopen($Filename, "w");

        // Daten in CSV File speichern
        foreach ($fileSpeichern as $PunkteNeu) {
            fputcsv($fp, $PunkteNeu);
        }
        // CSV File wieder schliessen
        fclose($fp);
    }


    // Das gespeicherteFile alsMMultiarray rreturnwert oder als Html Ausgabe anzeigen
    public function AnzeigeBesteSpieler($Filename = "CSV\\Hiscoreliste.csv", $TabellennameHTML, $HtmlAusgabe = true)
    {

        ///////////////////// Layout CSS //////////////////////////////////////////////////////////////////////
        echo
        '<style>
                /*H1 überschrift */
                .punkte_h1 {
                    background-color: black;
                    color : white;
                    text-align: center;
                }
                
                .punkte_Table {
                    background-color: gray;
                    color : white;
                    margin: auto;
                    padding: 10px;
                }
                
                .punkte_Table_th {
                    background-color: red;
                    font-size: 20px;
                    padding: 10px;
                }
                
                .punkte_Table_td {
                    font-size: 20px;
                    padding: 0px 10px 10px 10px; /* TOP / RIGTH / BOTTOM / LEFT */
                }
                
                </style>';

///////////////////// Layout CSS ENDE //////////////////////////////////////////////////////////////////////

        // Variablen definierern
        $Datenbank = array(array());

        // Werte aus CSV File in Array laden
        // 1. File lesen sofern existent

        if (file_exists($Filename)) {
            // File öffnen
            $fp = fopen($Filename, "r");
            //Mit Funktion File wird Zeilenweise eingelesen aber mit File get content alles in ein einfaches Array
            $fileLaden = file($Filename);
            // File wieder schliessen
            fclose($fp);

            // File hat pro Zeilejeweils zuerst den Namen, und dann die Punktezahl gespeichert (asl CSV mit Kommaseperator getrennt)
            // Jeweils den Level, Namen und die Punktezahl in ein voneinander trennen und in ein Multyarray speichern

            ////////////////////////////////////////////////////////////////
            // Index 0 = NAME  / Index 1 = PUNKTE  /  Index 2 = LEVEL
            ////////////////////////////////////////////////////////////////
            for ($i = 0; $i < count($fileLaden); $i++) {
                $Datenbank[$i] = mb_split(",", $fileLaden[$i]);
            }
        } // Wenn File nicht vorhanden ist, dann Erfolgt eine Javascripzmeldung
        else {
            //echo '<script type="text/javascript" language="Javascript"> alert("File für Punkteanzeige nicht vorhanden")</script>';
        }

        //print_r($Datenbank);

        // Ausgabe als HTML Elemente
        if ($HtmlAusgabe && isset($fileLaden) ) {

            // Tabellenbeschriftung
            echo '<h1 class="punkte_h1">' . $TabellennameHTML . '</h1>';

            // Tabellenkopf
            echo '<table class="punkte_Table">';
            echo '<tr>';
            echo '<th class="punkte_Table_th"> Rang</th>';
            echo '<th class="punkte_Table_th"> Name</th>';
            echo '<th class="punkte_Table_th"> Punktezahl</th>';
            echo '</tr>';

            // Tabellen Inhalt
            for ($i = 0; $i <= 9; $i++) {
                // Tabellenkörper mit Wertenaus CSV File abfüllen - pro Linie
                // Index 0 = NAME  / Index 1 = PUNKTE  /  Index 2 = LEVEL

                echo '<tr>';
                echo '<td class="punkte_Table_td">' . ($i + 1) . '</td>';
                echo '<td class="punkte_Table_td">' . $Datenbank[$i][0] . '</td>';
                echo '<td class="punkte_Table_td">' . $Datenbank[$i][1] . '</td>';
                echo '</tr>';
            }

            // Tabelle schliessen
            echo '</table>';

        }

        // Ausgabe ober Tabell vorhanden ist oder nicht
        if (isset($fileLaden) ) {
            return true;
        }
        else {
            return false;
        }

    }


}



