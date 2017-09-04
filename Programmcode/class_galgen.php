
<?php



class GALGEN
{

// Klasse dynamisch bestimmen anhand bereits versuchter Buchstaben
    public function Setzen($Setzen = false, $NewGame = false)
    {

        // Sessionvariable zum speichern der aktuellen Fehler
        if ($NewGame) {
            $_SESSION["galgen_Setzen"] = 0;
        }

// Anzahl Fähler Zählen
        if ($Setzen) {
            $_SESSION["galgen_Setzen"] = $_SESSION["galgen_Setzen"] + 1;
        }
    }

// Funktion Game Over oder nicht
public function GameOver() {

    if ($_SESSION["galgen_Setzen"] >= 9) {
        return true;
    } else
        return false;
}


// Funktion Game Over oder nicht
    public function Restversuche() {
        return  9 - $_SESSION["galgen_Setzen"];
    }

// Klasse dynamisch bestimmen anhand bereits versuchter Buchstaben
    public function view()
    {

        echo
        '<style> 
                svg { line-grid: ;
                }
        </style>';


// Definition: Strichmänchen -> diese werden mit Ein und Ausblenden angezeigt
        echo
            '<svg width="200" height="200">
                    <!-- Setzen:   Grundlinie -->
                    <line x1="0" y1="100%" x2="100%" y2="100%" stroke="black" stroke-width="3%"></line>
                    
                    <!-- Setzen:   Strich 1 von Rechteck -->
                    <rect class="Strich_1" x="25%" y="87.5%" width="37.5%" height="12.5%" stroke="black" stroke-width="1%"></rect>
                    
                    <!-- Setzen:   Strich 2  Beine -->
                    <line class="Strich_2" x1="43.75%" y1="70%" x2="32.5%" y2="87.5%" stroke="black" stroke-width="1%"></line>
                    <!-- Setzen:   Strich 2 Beine -->
                    <line class="Strich_2" x1="43.75%" y1="70%" x2="55%" y2="87.5%" stroke="black" stroke-width="1%"></line>                
                    
                    <!-- Setzen:   Strich 3  Oberkörper -->  
                    <line class="Strich_3" x1="43.75%" y1="70%" x2="43.75%" y2="50%" stroke="black" stroke-width="1%"></line>
                    
                    <!-- Setzen:   Strich 4 Hände-->
                    <line class="Strich_4" x1="43.75%" y1="50%" x2="35%" y2="57.5%" stroke="black" stroke-width="1%"></line>
                    <!-- Setzen:   Strich 4 Hände-->
                    <line class="Strich_4" x1="43.75%" y1="50%" x2="52.5%" y2="57.5%" stroke="black" stroke-width="1%"></line>

                    <!-- Setzen:   Strich 5  Kopf -->
                    <circle class="Strich_5" cx="43.75%" cy="42.5%" r="7.5%" fill="black" stroke-width="1%"></circle>
                    
                    <!-- Setzen:   Strich 6 Galgenmast  -->
                    <line class="Strich_6" x1="5%" y1="0%" x2="5%" y2="100%" stroke="black" stroke-width="1%"></line>
                    
                    <!-- Setzen:   Strich 7 Galgenbalken quer oben-->
                    <line class="Strich_7" x1="5%" y1="0%" x2="50%" y2="0%" stroke="black" stroke-width="1.25%"></line>
                    
                    <!-- Setzen:   Strich 8 Seil-->
                    <line class="Strich_8" x1="43.75%" y1="0%" x2="43.75%" y2="35%" stroke="black" stroke-width="1%"></line>
                    
                    <!-- Strich 9 ist: Rechteck Klasse Strich_1 wieder unsichtbar machen und Text Game over nstatt anzeige Versuche-->
                    <rect class="Strich_9" x="0%" y="0%" width="100%" height="100%" stroke="white" stroke-width="0.75%" fill="white" opacity="0.8" />
                    <text class="Strich_9" x="50%" y="50%" alignment-baseline="middle" text-anchor="middle" font-size="200%">Game Over!!</text> 
                    '
            . '</svg>';


// Logik Striche einblenden ausblenden gemäss anzahl Fehler

        // Keinen Fehler
        if (isset($_SESSION["galgen_Setzen"])) {
            if ($_SESSION["galgen_Setzen"] == 0) {
                echo
                '<style>
                .Strich_1 {visibility: hidden;}
                .Strich_2 {visibility: hidden;} 
                .Strich_3 {visibility: hidden;}  
                .Strich_4 {visibility: hidden;}  
                .Strich_5 {visibility: hidden;}  
                .Strich_6 {visibility: hidden;}  
                .Strich_7 {visibility: hidden;}  
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Einen Fehler
            elseif ($_SESSION["galgen_Setzen"] == 1) {
                echo
                '<style>
                .Strich_2 {visibility: hidden;} 
                .Strich_3 {visibility: hidden;}  
                .Strich_4 {visibility: hidden;}  
                .Strich_5 {visibility: hidden;}  
                .Strich_6 {visibility: hidden;}  
                .Strich_7 {visibility: hidden;}  
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Zwei Fehler
            elseif ($_SESSION["galgen_Setzen"] == 2) {
                echo
                '<style>
                .Strich_3 {visibility: hidden;}  
                .Strich_4 {visibility: hidden;}  
                .Strich_5 {visibility: hidden;}  
                .Strich_6 {visibility: hidden;}  
                .Strich_7 {visibility: hidden;}  
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Drei Fehler
            elseif ($_SESSION["galgen_Setzen"] == 3) {
                echo
                '<style> 
                .Strich_4 {visibility: hidden;}  
                .Strich_5 {visibility: hidden;}  
                .Strich_6 {visibility: hidden;}  
                .Strich_7 {visibility: hidden;}  
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Vier Fehler
            elseif ($_SESSION["galgen_Setzen"] == 4) {
                echo
                '<style>
                .Strich_5 {visibility: hidden;}  
                .Strich_6 {visibility: hidden;}  
                .Strich_7 {visibility: hidden;}  
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Fünf Fehler
            elseif ($_SESSION["galgen_Setzen"] == 5) {
                echo
                '<style>
                .Strich_6 {visibility: hidden;}  
                .Strich_7 {visibility: hidden;}  
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Sechs Fehler
            elseif ($_SESSION["galgen_Setzen"] == 6) {
                echo
                '<style>
                .Strich_7 {visibility: hidden;}  
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Sieben Fehler
            elseif ($_SESSION["galgen_Setzen"] == 7) {
                echo
                '<style> 
                .Strich_8 {visibility: hidden;}  
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Acht Fehler
            elseif ($_SESSION["galgen_Setzen"] == 8) {
                echo
                '<style> 
                .Strich_9 {visibility: hidden;}  
            </style>';
            } // Neun Fehler
            elseif ($_SESSION["galgen_Setzen"] >= 9) {
                echo
                '<style> 
                .Strich_1 {visibility: hidden;}
            </style>';
            }
        }
    }
}




?>
