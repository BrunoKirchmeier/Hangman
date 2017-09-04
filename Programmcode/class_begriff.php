<?php



class BEGRIFF
{


/////////////////////// PRIVATE FUNCTIONS //////////////////////////////////////////////////////////


// unnötige Leerzeichenentfernen
    private function cleanWhitespace($string) {
        //return trim( preg_replace('/\s+/', ' ', $string) );
        
        // In der  folgenden Zeile, wird durch den regulären Ausdruck "[^a-z0-9 ]" und der Funktion "preg_replace", alles aus einem String entfernt,
        // wobei es sich nicht um a-z, A-Z, 0-9 oder das Leerzeichen handelt.
        return  preg_replace ( '/[^a-z0-9-äöüÄÜÖ]/i', '', $string );
    }

/////////////////////// PUBLIC EIGENSCHAFTEN //////////////////////////////////////////////////////////

    private $Begriff = "";
    private $Zeichen = "";







/////////////////////// PUBLIC FUNCTIONS //////////////////////////////////////////////////////////


    // Mmit dieser Funktion kann ein Zeichen erkauf twerden- Wird Sie aufgerufen, so wird ein vorhandenes Zeichen im Begriff gesetzt
    public function BegriffAktuell() {
        // Ausgabe des aktuellen BEgriffes
        return $_SESSION["Begriff_NeuerBegriffLaden_AktuellerBegriff"] ;
    }



        // Mmit dieser Funktion kann ein Zeichen erkauf twerden- Wird Sie aufgerufen, so wird ein vorhandenes Zeichen im Begriff gesetzt
    public function ZeichenErkaufen()
    {

        // Variablen initilisieren
        $ErstesLeeresZeichen = "";


        // Begriffsinformationen aus Sessionvariablen laden
        $ArrayMitWoerterIndexiert = $_SESSION["Begriff_NeuerBegriffLaden_ArrayMitWoerterIndexiert"];                                                                  //Session
        $IndexWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexAnzWoerter"];                                                                                          //Session
        $IndexZeichenProWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexZeichenProWort"];                                                                            //Session         //Session
        $AusgabeBegriff = $_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"];


        // Erstes leere Zeichen suchen
        for ($i = 0; $i < $IndexWort; $i++) {

            // Schleife
            for ($j = 0; $j < $IndexZeichenProWort[$i]; $j++) {

                // LEERE POSITIONEN MIT UNTERLINE BESCHREIBEN
                if (!isset($AusgabeBegriff[$i][$j]) || $AusgabeBegriff[$i][$j] == '_ ') {
                    $ErstesLeeresZeichen = mb_substr($ArrayMitWoerterIndexiert[$i],$j, 1);
                }
            }
        }
        // Erstes gefundenes leeres Zeichen im Begriff setzen
        //$this->Zeichensetzen($ErstesLeeresZeichen);
        return $ErstesLeeresZeichen;
    }



    // Vergleicht denaktuellen Stand mit dem BEgriff und schaut ob er erraten wurde
    public function BegriffWurdeErraten()
    {

        // Begriffsinformationen aus Sessionvariablen laden
        $IndexWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexAnzWoerter"];                                                                                          //Session
        $IndexZeichenProWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexZeichenProWort"];                                                                             //Session
        $AusgabeBegriff = $_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"];
        $AusgabeErratenerString = "";


        // Bereits erratener String für Ausgabe aus Array zusammen setzen
        for ($i = 0; $i < $IndexWort; $i++) {
            // Schleife
            for ($j = 0; $j < $IndexZeichenProWort[$i]; $j++) {
                $AusgabeErratenerString = $AusgabeErratenerString . $AusgabeBegriff[$i][$j];
            }


            if ($_SESSION["Begriff_NeuerBegriffLaden_AktuellerBegriff"] == $AusgabeErratenerString) {
                return true;
            } else {
                return false;
            }
        }
    }

    
    // Ess wird ein Zufallsbegriff aus einem Array von Strings geladen,welcher noch nichtverwendet wurde im laufenden Spiel
    public function Zufallsbegriff($array = array(), $NichtSpeichern = false )
    {

        // Init Varialen
        $WhileVerlassen = false;
        //$Durchgang = count($_SESSION["Datenbank_BegriffLaden_IndexGebraucht"]);
        //$BegriffeBereitsVerwendet = $_SESSION["Datenbank_BegriffLaden_IndexGebraucht"];

        if( isset($_SESSION["Datenbank_BegriffLaden_IndexGebraucht"]) ){
            $Durchgang = count($_SESSION["Datenbank_BegriffLaden_IndexGebraucht"]);
            $BegriffeBereitsVerwendet = $_SESSION["Datenbank_BegriffLaden_IndexGebraucht"];
        }
        else {
            $Durchgang = 0;
            $BegriffeBereitsVerwendet = array();
        }

        $index = 0;


        // Index vergeben
        while ($WhileVerlassen == false) {

            // Init Variablen nach FOR Schlaufen Durchgang
            $BegriffGefunden = false;
            $index = rand(0, count($array) - 1);

            // Schlaufe zum PRüfen ob Begriff bereits einmals verwendet wurde
            for ($i = 0; $i < $Durchgang; $i++) {

                // Begriff wurde in diesem Durchlauf gefunden
                if (mb_strstr($BegriffeBereitsVerwendet[$i], $array[$index])) {
                    $BegriffGefunden = true;
                }
            }
            //echo count($BegriffGefunden);

            // Wenn Begriff NICHT  gefunden wurde, so einen neuen Eintrag in die Session machen
            if ($BegriffGefunden == false ) {
                $WhileVerlassen = true;
                // Nur Speichern sofern nicht deaktiviert
                if ($NichtSpeichern == false){
                    array_push($BegriffeBereitsVerwendet, $array[$index]);
                }
            }

            // Sofern Die Session gleich gross ist wie das Array wurden alle Begriffe einmal errraten - Alles wird wieder zurück gesetzt
            if ( count($BegriffeBereitsVerwendet) >= count($array) ) {
                //Mitteilung an Anwender dass alle eraten wurde
                echo '<script type="text/javascript" language="Javascript"> alert("Alle Begriffe innerhalb eines Spieles wurden erraten")</script>';

                // While verlassen und Session Varaible wieder löschen für Neustart
                $WhileVerlassen = true;
                $_SESSION["Datenbank_BegriffLaden_IndexGebraucht"] = array();
                $BegriffeBereitsVerwendet = array();
            }
        }

        // Session Variable neu abspeichern
        $_SESSION["Datenbank_BegriffLaden_IndexGebraucht"] = $BegriffeBereitsVerwendet;
        // Rückgabewert
        return $array[$index];
    }



// Neustart Programm - alle statischen Werte löschen und neuer Begriff laden
    public function Neustart($Datenbank) {
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$_SESSION["Datenbank_BegriffLaden_IndexGebraucht"] = array(); //////////////////////// Eventuell nicht auskommentieren - wird in Init.php auskommentiert
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $this->NeuerBegriffLaden($this->Zufallsbegriff($Datenbank) );
    }



// Neues Wort laden und Session Variablen entsprechen beschreiben
    public function NeuerBegriffLaden($Begriff="") {

    // Neuer Begriff laden - unnötige Leerzeichen entfernen damit eskeinen Error gibt
        $_SESSION["Begriff_NeuerBegriffLaden_AktuellerBegriff"] = $this->cleanWhitespace($Begriff);                                                                                             //Session
        $this->Begriff = $_SESSION["Begriff_NeuerBegriffLaden_AktuellerBegriff"];                                                                                       //Session

        // Es werden alle seesionsvariablen zurückgesetzt und mit den Daten des neuen begriffes geladen

        // Begriff laden - Indexe lesen - pro Array ein Wort
        $ArrayMitWoerterIndexiert =  mb_split(" ", $this->Begriff); //Begriff in Indexiertes Array verpacken  - pro index ein Wort als STRING

        // Variablen initialisieren
        $ZeichenProWort = array();
        $GrossKleinschrift = array();
        $INITBegriff = array();

        // Sessionvariablen initialisieren
        $_SESSION["Begriff_NeuerBegriffLaden_ArrayMitWoerterIndexiert"] = 0;                                                                                          //Session
        $_SESSION["Begriff_NeuerBegriffLaden_IndexAnzWoerter"] = 0;                                                                                                   //Session
        $_SESSION["Begriff_NeuerBegriffLaden_IndexZeichenProWort"] = array();                                                                                         //Session
        $_SESSION["Begriff_NeuerBegriffLaden_IndexGrossKleinschrift"] = array("");                                                                                    //Session
        $_SESSION["Begriff_Zeichensetzen_PositionenZeichen"] = array("");                                                                                             //Session
        $_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"] = array("");                                                                                                //Session

        // Sessionvariablen beschreiben
        $_SESSION["Begriff_NeuerBegriffLaden_ArrayMitWoerterIndexiert"] = $ArrayMitWoerterIndexiert;                                                                  //Session
        $_SESSION["Begriff_NeuerBegriffLaden_IndexAnzWoerter"] = count($ArrayMitWoerterIndexiert); // Anzahl Worte und Gross-Kleinschreibung erster Buchstabe         //Session

        // Schleife für Zeichen pro Wort und bestimmen ob gross oder Kleinschrift - Arrays werden abgefüllt
        for ($i=0; $i < count($ArrayMitWoerterIndexiert); $i++) {

            // Wortlänge speichern
            $ZeichenProWort[$i] = mb_strlen($ArrayMitWoerterIndexiert[$i]);

        // Speichern ob gross oder kleinschrift beim erten Buchstabe im Wort

            // Kontrolle nach ASCII Tabelle:    Im Bereich von Grossbuchstaben
            if ( ($ArrayMitWoerterIndexiert[$i][0] >= chr(65)) && ($ArrayMitWoerterIndexiert[$i][0] <= chr(90)) )
            {
                    $GrossKleinschrift[$i] = "gross";
            }
            // Kontrolle nach ASCII Tabelle:    Einzelkontrolle der Zeichen  Ä Ö Ü (ACHTUNG!!! Mit  Funktionen mb_ arbeiten, da nicht UTF-8 verschlüsselte
            elseif ( (mb_substr($ArrayMitWoerterIndexiert[$i],0,1) == "Ä") ||
                     (mb_substr($ArrayMitWoerterIndexiert[$i],0,1) == "Ö") ||
                     (mb_substr($ArrayMitWoerterIndexiert[$i],0,1) == "Ü")       )
            {
                    $GrossKleinschrift[$i] = "gross";
            }
            else
                    $GrossKleinschrift[$i] = "klein";
        }

        // Sessionvariablen beschreiben
        $_SESSION["Begriff_NeuerBegriffLaden_IndexZeichenProWort"] = $ZeichenProWort;                                                                                 //Session
        $_SESSION["Begriff_NeuerBegriffLaden_IndexGrossKleinschrift"] = $GrossKleinschrift; // Ist erster Buchstabe Gross oder Klein?? Nomenoder Verb??               //Session

        // INIT: UNNDERLINES SETZEN ZEICHEN SETZEN sofern noch kein Zeichen gesetzt wurde
        for($i=0; $i < count($ArrayMitWoerterIndexiert); $i++) {

            // Schleife
            for ($j = 0; $j < $ZeichenProWort[$i]; $j++) {
                $INITBegriff[$i][$j] = '_ ';
            }
        }

        // Sessionvariablen beschreiben -> Initialisieren bei beginnt sofern noch kein Zeichen gesetzt wurde
        $_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"] = $INITBegriff;

        // Rückgabe begriff wurde neu geladen
        return true;

    }




// Zeichen lesen und im Wort vergleichen
    public function Zeichensetzen($zeichen = "") {

        // Variablen initilisieren
        $PositionenZeichen = array(array());
        $Index = 0;
        $ZeichenVorhandenJaNein = false;


        // Begriffsinformationen aus Sessionvariablen laden
        $ArrayMitWoerterIndexiert = $_SESSION["Begriff_NeuerBegriffLaden_ArrayMitWoerterIndexiert"];                                                                  //Session
        $IndexWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexAnzWoerter"];                                                                                          //Session
        $IndexZeichenProWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexZeichenProWort"];                                                                            //Session
        $IndexGrossKleinschrift = $_SESSION["Begriff_NeuerBegriffLaden_IndexGrossKleinschrift"];                                                                      //Session
        $AusgabeBegriff = $_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"];


        // ZEICHEN SETZEN
        for($i=0; $i < $IndexWort; $i++){

            // Schleife
            for($j=0; $j < $IndexZeichenProWort[$i]; $j++) {

                // LEERE POSITIONEN MIT UNTERLINE BESCHREIBEN
                if (!isset($AusgabeBegriff[$i][$j])) {
                    // UNDERLINES BEI LEEREN ARRAY SETZEN
                    $AusgabeBegriff[$i][$j] = '_ ';
                }

                // ZEICHEN SUCHEN IN VORHABE UND SETZEN IN AUSGABE (VERGLEICH IMMER MIT KLEINBUCHSTABEN DAIMT KLEIN-GROSS EINGABE KEINE ROLLESOIELT)
                if (mb_strtolower($zeichen) == mb_strtolower(mb_substr($ArrayMitWoerterIndexiert[$i], $j, 1))) {
                    // ZEICHEN IM VORGABE STRING SUCHEN
                    $PositionenZeichen[$i][$Index] = $j;
                    $Index++;
                    $ZeichenVorhandenJaNein = true;


                // ZEICHEN IM AUSGABE STRING SETZEN
                    // Zeichen als Grossbuchstabe setzen
                    if ( ($IndexGrossKleinschrift[$i] == "gross") && $j == 0) {
                        $AusgabeBegriff[$i][$j] = mb_strtoupper($zeichen);

                    } // Zeichen als Kleinbuchstabe setzen
                    else
                        $AusgabeBegriff[$i][$j] = mb_strtolower($zeichen);
                }
            }
        }

        // Neue Eintragungen in Session Speichern
        $_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"] = $AusgabeBegriff;
        

        // Rückgabe ob Zeichcen vorhanden ist oder nicht
        if ($ZeichenVorhandenJaNein) {
            return 1;
        }
        else
            return 0;
    }




// Ausgabe Begriff auf Browser
    public function view($Anzeigen = false)
    {
        // Variablen definitionen
        $IndexWort = 0;

        // Begriffsinformationen aus Sessionvariablen laden
        if (isset($_SESSION["Begriff_NeuerBegriffLaden_IndexAnzWoerter"])) {
            $IndexWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexAnzWoerter"];                                                                                          //Session
        }
        if (isset($_SESSION["Begriff_NeuerBegriffLaden_IndexZeichenProWort"])) {
            $IndexZeichenProWort = $_SESSION["Begriff_NeuerBegriffLaden_IndexZeichenProWort"];                                                                             //Session
        }
        if (isset($_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"])) {
            $AusgabeBegriff = $_SESSION["Begriff_Zeichensetzen_AusgabeBegriff"];                                                                                           //Session
        }


///////////////////// Layout CSS //////////////////////////////////////////////////////////////////////
        echo
        '<style>
            
            .Layout {
            font-size: 30px;
            }
            
         </style>';

///////////////////// Layout CSS ENDE //////////////////////////////////////////////////////////////////////


        // Variablen initialisieren
        $AusgabeErratenerString = "";

        // Nur erratene Zeichen anzeigen - nicht den kompletten Begriff
        if ($Anzeigen == false) {

            // Bereits erratener String für Ausgabe aus Array zusammen setzen
            for ($i = 0; $i < $IndexWort; $i++) {
                // Schleife
                for ($j = 0; $j < $IndexZeichenProWort[$i]; $j++) {
                    $AusgabeErratenerString = $AusgabeErratenerString . $AusgabeBegriff[$i][$j];
                }
                $AusgabeErratenerString = $AusgabeErratenerString . '&nbsp &nbsp &nbsp';
            }
            // Ausgabe in HTML
            echo '<div class="Layout">' . $AusgabeErratenerString . '</div>';

        }
        // Den kompletten begriff anzeigen
        else {
            echo '<div class="Layout">' .$this->Begriff .'</div>';
            echo '<div class="Layout">' .$_SESSION["Begriff_NeuerBegriffLaden_AktuellerBegriff"] .'</div>';
        }
        // Ausgabe des aktuellen BEgriffes
        //return $_SESSION["Begriff_NeuerBegriffLaden_AktuellerBegriff"] ;
    }


}

?>