<?php



class KEYBOARD
{



/////////////////////// PRIVATE FUNCTIONS //////////////////////////////////////////////////////////

    // Klasse dynamisch bestimmen anhand bereits versuchter Buchstaben
    private function KlasseBestimmen($Zeichen="")
    {
        // Variablendefinition
        $ZeichenRichtig = "";
        $ZeichenFalsch = "";

        if (isset($_SESSION["view_VersuchteZeichenKorrekt_ZeichenRichtig"])) {
            $ZeichenRichtig = $_SESSION["view_VersuchteZeichenKorrekt_ZeichenRichtig"];                                            //Session
        }
        if (isset($_SESSION["view_VersuchteZeichenKorrekt_ZeichenFalsch"])) {
            $ZeichenFalsch = $_SESSION["view_VersuchteZeichenKorrekt_ZeichenFalsch"];                                              //Session
        }

        // Zeichen gesucht und gefunden - grün
        if (strrpos ($ZeichenRichtig, $Zeichen) !== false) {
            $KlassennameTasten = "Richtig";
        }
        // Zeichen gesucht und gefunden - rot
        elseif (strrpos ($ZeichenFalsch, $Zeichen) !== false) {
            $KlassennameTasten = "Falsch";
        }
        else
            $KlassennameTasten = "Neutral";


        return $KlassennameTasten;
    }


// Keyboard eingabe Freigeben oder Sperren entsprechend der Eingabe
private function Keyboardeingabe_Frei ($wahr = true)
{
    if ($wahr) {
        return ; }
    else {
        return ' disabled '; }
}


    

/////////////////////// PUBLIC FUNCTIONS //////////////////////////////////////////////////////////


// Abfrage welche Zeichen wurden bereits versucht wurden - und richtig sind (CSS Farbe grün)
    public function VersuchteZeichenKorrekt($Zeichen="")
    {
        // Speichern
        if ($Zeichen<>"") {
            $ZeichenRichtig = $_SESSION["view_VersuchteZeichenKorrekt_ZeichenRichtig"];                                                                      //Session
            $_SESSION["view_VersuchteZeichenKorrekt_ZeichenRichtig"] =  $ZeichenRichtig  .$Zeichen ."  ";                                                          //Session
        }
        return $_SESSION["view_VersuchteZeichenKorrekt_ZeichenRichtig"];                                                                                     //Session
    }


// Abfrage welche Zeichen wurden bereits versucht wurden - und richtig sind (CSS Farbe grün)
    public function VersuchteZeichenFalsch($Zeichen="")
    {
        // Speichern
        if ($Zeichen<>"") {
            $ZeichenFalsch = $_SESSION["view_VersuchteZeichenKorrekt_ZeichenFalsch"];                                                                        //Session
            $_SESSION["view_VersuchteZeichenKorrekt_ZeichenFalsch"] =  $ZeichenFalsch  .$Zeichen . "  ";
        }
        return $_SESSION["view_VersuchteZeichenKorrekt_ZeichenFalsch"];                                                                                      //Session
    }



// Neustart Programm - alle statischen Werte löschen
    public function Neustart() {
        $_SESSION["view_VersuchteZeichenKorrekt_ZeichenRichtig"] = NULL;                                                                                     //Session
        $_SESSION["view_VersuchteZeichenKorrekt_ZeichenFalsch"] = NULL;                                                                                      //Session
    }


// Abfrage nach aktuellem Zeichen
    public function GetZeichen() {
        $Zwischenspeicher = "";
        if (isset($_GET["Taste"]) ) {
            $Zwischenspeicher = $_GET["Taste"];
        }
        return $Zwischenspeicher;
    }


// Anzeige
    public function view($Tastenfreigabe = true)  // Benutzer darf über Keyboard eine Eingabe machen
    {
        echo
    ///////////////////// Layout CSS //////////////////////////////////////////////////////////////////////
        '<style>
                /*Container fürGanzen Div Block Tastaratur ohne auswirkung auf Tasten  */
                .Container {
                margin: auto;
                width: 600px;  /* wenn widht in Keyboardklasse steht, wird nicht richtig zentriert */
                }
                
                /*Gesamttastaratur Umriss */
                div.Keyboard {
                    background-color: black;
                    height: 150px; /* wenn height in Containerklasse steht, wird nicht richtig zentriert */
                    margin: 0px;
                    text-align: left;
                }
                
                 /*Reihe Einrücken nach rechts und Höhe definieren */
                .Reihe1 {
                    height: 33%;
                    margin-left : 0%;
                    margin-right: 6%;
                }
                
                 /* Höhe definieren */              
                .Reihe2 {
                    height: 33%;
                    margin-left : 3%;
                    margin-right: 3%;
                }
                
                 /* Höhe definieren */
                .Reihe3 {
                    height: 33%;
                    margin-left: 6%;
                    margin-right: 0%;
                }              
        
                /* Tasten Klein für Buchstaben bei Init */
                .Neutral {
                    color: black;
                    background-color: gray;
                    margin: 1%;
                    text-align: center;
                    width: 7%;
                    height: 80%;
                    display: inline-block;
                    font-size: 200%;
                    border-radius: 5px;
                }                            
                
                 /* Tasten Klein für Buchstaben bei Buchstabe gepröft und im Begriff nicht vorhanden*/
                .Falsch {
                    color: black;
                    background-color: red;
                    margin: 1%;
                    text-align: center;
                    width: 7%;
                    height: 80%;
                    display: inline-block;
                    font-size: 200%; 
                    border-radius: 5px;
                }  
                
                 /* Tasten Klein für Buchstaben bei Buchstabe gepröft und im Begriff  vorhanden*/
                .Richtig {
                    color: black;
                    background-color: green;
                    margin: 1%;
                    text-align: center;
                    width: 7%;
                    height: 80%;
                    display: inline-block;
                    font-size: 200%; 
                    border-radius: 5px;
                }  
                </style>';

///////////////////// Layout CSS ENDE //////////////////////////////////////////////////////////////////////

        // Gesamt Keyboard ausgeben mit Eingabefunktion
        echo '<div class="Container">';
        echo '<form method="get">';
            echo '<div class="Keyboard">';
            // Tasten für Eingabe Reihe 1
                echo '<div class="Reihe1">';
                    echo '<input class="'.$this->KlasseBestimmen("q").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="q" value="q">';
                    echo '<input class="'.$this->KlasseBestimmen("w").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="w" value="w">';
                    echo '<input class="'.$this->KlasseBestimmen("e").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="e" value="e">';
                    echo '<input class="'.$this->KlasseBestimmen("r").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="r" value="r">';
                    echo '<input class="'.$this->KlasseBestimmen("t").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="t" value="t">';
                    echo '<input class="'.$this->KlasseBestimmen("z").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="z" value="z">';
                    echo '<input class="'.$this->KlasseBestimmen("u").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="u" value="u">';
                    echo '<input class="'.$this->KlasseBestimmen("i").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="i" value="i">';
                    echo '<input class="'.$this->KlasseBestimmen("o").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="o" value="o">';
                    echo '<input class="'.$this->KlasseBestimmen("p").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="p" value="p">';
                    echo '<input class="'.$this->KlasseBestimmen("ü").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="ü" value="ü">';
                echo '</div>';
            // Tasten für Eingabe Reihe 2
                echo '<div class="Reihe2">';
                    echo '<input class="'.$this->KlasseBestimmen("a").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="a" value="a">';
                    echo '<input class="'.$this->KlasseBestimmen("s").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="s" value="s">';
                    echo '<input class="'.$this->KlasseBestimmen("d").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="d" value="d">';
                    echo '<input class="'.$this->KlasseBestimmen("f").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="f" value="f">';
                    echo '<input class="'.$this->KlasseBestimmen("g").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="g" value="g">';
                    echo '<input class="'.$this->KlasseBestimmen("h").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="h" value="h">';
                    echo '<input class="'.$this->KlasseBestimmen("j").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="j" value="j">';
                    echo '<input class="'.$this->KlasseBestimmen("k").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="k" value="k">';
                    echo '<input class="'.$this->KlasseBestimmen("l").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="l" value="l">';
                    echo '<input class="'.$this->KlasseBestimmen("ö").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="ö" value="ö">';
                    echo '<input class="'.$this->KlasseBestimmen("ä").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="ä" value="ä">';
                echo '</div>';
            // Tasten für Eingabe Reihe 3
                echo '<div class="Reihe3">';
                    echo '<input class="'.$this->KlasseBestimmen("y").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="y" value="y">';
                    echo '<input class="'.$this->KlasseBestimmen("x").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="x" value="x">';
                    echo '<input class="'.$this->KlasseBestimmen("c").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="c" value="c">';
                    echo '<input class="'.$this->KlasseBestimmen("v").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="v" value="v">';
                    echo '<input class="'.$this->KlasseBestimmen("b").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="b" value="b">';
                    echo '<input class="'.$this->KlasseBestimmen("n").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="n" value="n">';
                    echo '<input class="'.$this->KlasseBestimmen("m").'"' .$this->Keyboardeingabe_Frei($Tastenfreigabe) .'type="submit" name="Taste" id="m" value="m">';
                echo '</div>';
            echo '</div>';
        echo '</form>';
        echo '</div>';



    }
}

?>
