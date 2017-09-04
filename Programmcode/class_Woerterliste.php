<?php


class WOERTERLISTE
{


/////////////////////// PRIVATE FUNCTIONS //////////////////////////////////////////////////////////



/////////////////////// PUBLIC EIGENSCHAFTEN //////////////////////////////////////////////////////////


// Konstanten
    private $Level_1 = 60;
    private $Level_2 = 50;
    private $Level_3 = 40;
    private $Level_4 = 30;
    private $Level_5 = 20;
    //private $Filename = 'CSV\WoerterInLevelsGespeichert.csv';


/////////////////////// PUBLIC FUNCTIONS //////////////////////////////////////////////////////////

// Funktion zum evaluieren und zuteilen von Wörten nach Schwierigkeitsgrad in ein CSV welches mit einer anderernFunktion eingelesen wird
    function WoerterNachLevelsLaden ($Filename = "CSV\\WoerterInLevelsGespeichert.csv", $Level = 1) {


// FILE LESEN

        // File öffnen
        $fp = fopen ($Filename,"r");

        //Mit Funktion File wird Zeilenweise eingelesen aber mit File get content alles in ein einfaches Array
        $zwischenspeicher = file ($Filename);

        // File wieder schliessen
        fclose ($fp);


   // Liste nach schwierigkeitsgrad lesen - entsprechende Zeile aus CSV File

        // Wörter aus Liste:            Level 1   einlesen
        if ($Level == 1) {
            $Datenbank = mb_split (",", $zwischenspeicher[1] );
            return $Datenbank;
        }
        // Wörter aus Liste:            Level 2   einlesen
        elseif ($Level == 2) {
            $Datenbank = mb_split (",", $zwischenspeicher[2] );
            return $Datenbank;
        }
        // Wörter aus Liste:            Level 3   einlesen
        elseif ($Level == 3) {
            $Datenbank = mb_split (",", $zwischenspeicher[3] );
            return $Datenbank;
        }
        // Wörter aus Liste:            Level 4   einlesen
        elseif ($Level == 4) {
            $Datenbank = mb_split (",", $zwischenspeicher[4] );
            return $Datenbank;
        }
        // Wörter aus Liste:            Level 5   einlesen
        elseif ($Level == 5) {
            $Datenbank = mb_split (",", $zwischenspeicher[5] );
            return $Datenbank;
        }

    }




// Funktion zum evaluieren und zuteilen von Wörten nach Schwierigkeitsgrad
//  Parameter w heisst File löschen und Neu -parameter a heisst CSV File erweitern
    function WoerterNachLevelsSortieren ($Filename = "CSV\\WoerterInLevelsGespeichert.csv", $sourceName = "Woerter.csv", $FileNeuOderErweitern = 'a') {

     // ausführungszeit desScripts verlängern,damit keinTimeoutkommt
     set_time_limit(300);

    // Init
        $AusgabeArraySortiertNachLevel = array(array());
        $DatenLevel_1 = array();
        $DatenLevel_2 = array();
        $DatenLevel_3 = array();
        $DatenLevel_4 = array();
        $DatenLevel_5 = array();


   // File lesen und in Arrays abfüllen
        //$DatenbankUngefiltert = mb_split ("\n", file_get_contents($sourceName) );
        $DatenbankUngefiltert = file_get_contents($sourceName) ;

   // In der  folgenden Zeile, wird durch den regulären Ausdruck "[^a-z0-9 ]" und der Funktion "preg_replace", alles aus einem String entfernt,
   // wobei es sich nicht um a-z, A-Z, 0-9 oder das Leerzeichen handelt.    mb_detect_encoding($DatenbankUngefiltert, "UTF-8, ASCII" )
        $Daten = mb_split ("\n", mb_convert_encoding($DatenbankUngefiltert, "UTF-8", "ASCII" ) );



   // Jedes Wort durchgehen und Gewichtung für Schwierigkeitsgrad feststellen - Entsprechend wird dieser dem Multiarray zugeteilt
        // Wort laden
        for ( $i=0; $i < count($Daten); $i++) {

            // Variablen für Zwischenspeicher
            $BuchstabenSpeicher = array(); // Variable zum speichern, ob dieser Buchstabe bereits pro Wort einmal gefunden wurde
            $Gewichtung = 0; // Addition der gesamten gewichtung pro Wort

            // Entfernen von unnötigen Zeichen
            $zwischenspeicher = preg_replace ( '/[^a-zA-Z0-9äöüÄÜÖ]/', '',$Daten[$i]);


            // Jedes Zeichen pro Wort durchgehen
                for ($j=0; $j <= mb_strlen($zwischenspeicher); $j++ ) {
                //Wertung gemäss Buchstabengewichtung - sobald ein Buchstabe bereits einmal vorgekommen ist, so wird dieser nicht mehr gewertet
                //Je kleiner die Summe, desto schwierieger das Wort. Jeder Buchstabe der Vorkommt wird mit seiner Gewichtung einmals gezählt

                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("e", $BuchstabenSpeicher) == false ) {
                        // Suche nach           e
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "e" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "e" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 17.4;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("n", $BuchstabenSpeicher) == false ) {
                        // Suche nach           n
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "n" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "n" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 9.78;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("s", $BuchstabenSpeicher) == false ) {
                        // Suche nach           s
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "s" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "s" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 7.7;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("i", $BuchstabenSpeicher) == false ) {
                        // Suche nach           i
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "i" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "i" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 7.55;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("r", $BuchstabenSpeicher) == false ) {
                        // Suche nach           r
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "r" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "r" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 7.0;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("a", $BuchstabenSpeicher) == false ) {
                        // Suche nach           a
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "a" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "a" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 6.51;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("t", $BuchstabenSpeicher) == false ) {
                        // Suche nach           t
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "t" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "t" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 6.15;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("d", $BuchstabenSpeicher) == false ) {
                        // Suche nach           d
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "d" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "d" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 5.08;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("h", $BuchstabenSpeicher) == false ) {
                        // Suche nach           h
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "h" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "h" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 4.76;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("u", $BuchstabenSpeicher) == false ) {
                        // Suche nach           u
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "u" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "u" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 4.35;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("l", $BuchstabenSpeicher) == false ) {
                        // Suche nach           l
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "l" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "l" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 3.44;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("c", $BuchstabenSpeicher) == false ) {
                        // Suche nach           c
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "c" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "c" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 3.06;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("g", $BuchstabenSpeicher) == false ) {
                        // Suche nach           g
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "g" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "g" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 3.01;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("m", $BuchstabenSpeicher) == false ) {
                        // Suche nach           m
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "m" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "m" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 2.53;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("o", $BuchstabenSpeicher) == false ) {
                        // Suche nach           o
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "o" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "o" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 2.51;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("b", $BuchstabenSpeicher) == false ) {
                        // Suche nach           b
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "b" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "b" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 1.89;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("w", $BuchstabenSpeicher) == false ) {
                        // Suche nach           w
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "w" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "w" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 1.89;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("f", $BuchstabenSpeicher) == false ) {
                        // Suche nach           f
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "f" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "f" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 1.66;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("k", $BuchstabenSpeicher) == false ) {
                        // Suche nach           k
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "k" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "k" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 1.21;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("z", $BuchstabenSpeicher) == false ) {
                        // Suche nach           z
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "z" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "z" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 1.13;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("p", $BuchstabenSpeicher) == false ) {
                        // Suche nach           p
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "p" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "p" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 0.79;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("v", $BuchstabenSpeicher) == false ) {
                        // Suche nach           v
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "v" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "v" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 0.67;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("j", $BuchstabenSpeicher) == false ) {
                        // Suche nach           j
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "j" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "j" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 0.27;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("y", $BuchstabenSpeicher) == false ) {
                        // Suche nach           y
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "y" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "y" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 0.04;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("x", $BuchstabenSpeicher) == false ) {
                        // Suche nach           x
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "x" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "x" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 0.03;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("q", $BuchstabenSpeicher) == false ) {
                        // Suche nach           q
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "q" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "q" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 0.02;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("ü", $BuchstabenSpeicher) == false ) {
                        // Suche nach           ü
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "ü" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "ü" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 5;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("ä", $BuchstabenSpeicher) == false ) {
                        // Suche nach           ä
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "ä" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "ä" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 5;
                        }
                    }
                    // Buchstabe wurde im Wort bereits gefunden
                    if ( in_array("ö", $BuchstabenSpeicher) == false ) {
                        // Suche nach           ö
                        if ( mb_strtolower(mb_substr($zwischenspeicher,$j,1)) == "ö" ) {
                            // Damit nur einmal pro Wort gefunden wird, dies abspeichern
                            array_push($BuchstabenSpeicher, "ö" );
                            // Gewichtung zählen
                            $Gewichtung = $Gewichtung + 5;
                        }
                    }
                }


                // Zwischenspeicher codiert zum abspeichern in Ecxel
            $zwischenspeicherCodiertExport =  mb_convert_encoding($zwischenspeicher, "Windows-1252",'UTF-8');




                // Level 5  - schwierigste Variante
                if ( $Gewichtung < $this->Level_5 ) {
                    array_push($DatenLevel_5, $zwischenspeicherCodiertExport);
                }
                // Level 4
                elseif ( $Gewichtung < $this->Level_4 ) {
                    array_push($DatenLevel_4, $zwischenspeicherCodiertExport);
                }
                // Level 3
                elseif ( $Gewichtung < $this->Level_3 ) {
                    array_push($DatenLevel_3, $zwischenspeicherCodiertExport);
                }
                // Level 2
                elseif ( $Gewichtung < $this->Level_2 ) {
                    array_push($DatenLevel_2, $zwischenspeicherCodiertExport);
                }
                // Level 1
                else {
                    array_push($DatenLevel_1, $zwischenspeicherCodiertExport);
                }

            }
            // Multiarray zusammensetzen für CSV FIle

            // Anzahl Elemente    -    LEVEL 1
            $AusgabeArraySortiertNachLevel[0][1] = count($DatenLevel_1);
            // Anzahl Elemente    -    LEVEL 2
            $AusgabeArraySortiertNachLevel[0][2] = count($DatenLevel_2);
            // Anzahl Elemente    -    LEVEL 3
            $AusgabeArraySortiertNachLevel[0][3]= count($DatenLevel_3);
            // Anzahl Elemente    -    LEVEL 4
            $AusgabeArraySortiertNachLevel[0][4]= count($DatenLevel_4);
            // Anzahl Elemente    -    LEVEL 5
            $AusgabeArraySortiertNachLevel[0][5]= count($DatenLevel_5);
            // Begriffe als Array -    LEVEL 1
            $AusgabeArraySortiertNachLevel[1] = $DatenLevel_1;
            // Begriffe als Array -    LEVEL 2
            $AusgabeArraySortiertNachLevel[2] = $DatenLevel_2;
            // Begriffe als Array -    LEVEL 3
            $AusgabeArraySortiertNachLevel[3] = $DatenLevel_3;
            // Begriffe als Array -    LEVEL 4
            $AusgabeArraySortiertNachLevel[4] = $DatenLevel_4;
            // Begriffe als Array -    LEVEL 5
            $AusgabeArraySortiertNachLevel[5] = $DatenLevel_5;


            // CSV File eröffnen und laden
            $fp = fopen($Filename, $FileNeuOderErweitern);
            // Daten in CSV File speichern
            foreach ($AusgabeArraySortiertNachLevel as $Level) {
                fputcsv($fp, $Level);
            }
            // CSVFile wieder schliessen
            fclose($fp);
        }




///////////////////// Layout CSS //////////////////////////////////////////////////////////////////////


///////////////////// Layout CSS ENDE //////////////////////////////////////////////////////////////////////

}

?>