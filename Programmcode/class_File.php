<?php


class File
{

////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// PRIVATE FUNCTIONS //////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// PUBLIC EIGENSCHAFTEN //////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


    /////////////////////// File abspeichern //////////////////////////////////////////////////////////
    function Speichern($Filename, $Inhalt, $FileNeuOderErweitern = 'w', $Trennzeichen = "\n") // "\n"
    {
        //  Parameter $FileNeuOderErweitern:      w heisst File löschen und Neu -parameter a heisst CSV File erweitern

        // Endzeichen hinzufügen für Stringteilung
        //$InhaltSpeichern = $Inhalt .";";
        $fileLaden = array();
        $fileLadenDecodoert = array();
        $fileSpeichern = array( array() );
        $InhaltStringDecodoert = array();
        $Index_Speichern = 0;

        // Umwandlung der Eingabein UTF-8 und in Array
        $InhaltStringDecodoert = mb_convert_encoding($Inhalt, "UTF-8", 'auto');


        // File lesen sofern existent //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (file_exists($Filename) ) {

            // File öffnen
            $fp = fopen($Filename, "r");

            // Inhalt aus File laden
            $fileLaden = mb_split($Trennzeichen, file_get_contents($Filename) );

            // File wieder schliessen
            fclose($fp);


            // Array $fileSpeichern aufbereiten für zum Speichern
            // File ladenauf File Speichern schreiben
            for ($i = 0; $i < count($fileLaden); $i++) {

                // Umwandlung für - Multibyte und unnötige Zeichen entfernen
                $fileLadenDecodoert = preg_replace ( '/[^a-z0-9-äöüÄÜÖ]/i', '', mb_convert_encoding($fileLaden[$i], "UTF-8", 'auto') );

                // Wenn Feld aus CSV Geladen leer ist, so wird dies nicht abgespeichert.
                // Direktsprung in nächsten Schlaufengang
                if ( $fileLadenDecodoert == ''  ) {
                    continue;
                }

                // Speichern
                $fileSpeichern[$Index_Speichern][0] = $fileLadenDecodoert;

                // Index erhöhen für abzuspeicherndes File - seperaten Index, damit leere Arrays nicht abgespeichert werden
                $Index_Speichern ++ ;

            }
            // Neuer Inhalt am Schluss anfügen
            $fileSpeichern[count($fileSpeichern)][0] = $InhaltStringDecodoert;

        } // Annsonsten Inhalt auf erste Zeile Speichern
        else {
            $fileSpeichern[0][0] = $InhaltStringDecodoert;
        }


        // File schpeichern //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // CSV File öffnen
        $fp = fopen($Filename, $FileNeuOderErweitern); // $FileNeuOderErweitern

        // Daten in File speichern
        for ($i = 0; $i < count($fileSpeichern) ; $i++) {  // count($fileSpeichern)
            if ( true ) {  // isset( $fileSpeichern[$i]) )
                fputcsv($fp, $fileSpeichern[$i]); // $Trennzeichen
            }
        }

        // File wieder schliessen
        fclose($fp);

    }




}









/*

     function Speichern($Filename, $Inhalt, $FileNeuOderErweitern = 'w', $Trennzeichen = ",")
    {
        //  Parameter $FileNeuOderErweitern:      w heisst File löschen und Neu -parameter a heisst CSV File erweitern

        // Endzeichen hinzufügen für Stringteilung
        //$InhaltSpeichern = $Inhalt .";";
        $fileLaden = array();
        $fileLadenDecodoert = array();
        $fileSpeichern = array(array());
        $InhaltStringToArray = array();

        // Umwandlung der Eingabein UTF-8 und in Array
        $InhaltStringToArray = (array)mb_convert_encoding($Inhalt, "UTF-8", 'auto');


        // File lesen sofern existent //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (file_exists($Filename)) {

            // File öffnen
            $fp = fopen($Filename, "r");

            // Daten laden
            while (($fileLaden = fgetcsv($fp, 10000, $Trennzeichen)) !== FALSE) {
            }

                    echo '<br>';
                    echo ' Frisch csvgeladen';
                    echo '<br>';
                    echo print_r($fileLaden);
                    echo '<br>';
                    echo '<br>';



            // File wieder schliessen
            fclose($fp);

            // Array $fileSpeichern aufbereiten für zum Speichern
            // File ladenauf File Speichern schreiben
            for ($i = 0; $i < count($fileLaden); $i++) {

                // Umwandlung für - Multibyte
                $fileLadenDecodoert = mb_convert_encoding($fileLaden[$i], "UTF-8", 'auto');
                // Speichern
                $fileSpeichern[$i][0] = $fileLadenDecodoert;
            }
            // Neuer Inhalt am Schluss anfügen
            $fileSpeichern[count($fileLaden) + 1] = $InhaltStringToArray;

        } // Annsonsten Inhalt auf erste Zeile Speichern
        else {
            $fileSpeichern[0] = $InhaltStringToArray;
        }


        // File schpeichern //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // CSV File öffnen
        $fp = fopen($Filename, $FileNeuOderErweitern); // $FileNeuOderErweitern

        // Daten in File speichern
        for ($i = 0; $i < count($fileSpeichern); $i++) {
            fputcsv($fp, $fileSpeichern[$i], $Trennzeichen); // fputcsv
        }

                        echo '<br>';
                        echo "laden";
                        echo '<br>';
                        echo count($fileLaden);
                        echo '<br>';
                        echo print_r($fileLaden);
                        echo '<br>';
                        echo '<br>';
                        echo "speichern";
                        echo '<br>';
                        echo count($fileSpeichern);
                        echo '<br>';
                        echo print_r($fileSpeichern);


        // File wieder schliessen
        fclose($fp);

    }








*/










/*


            // Inhalt aus File laden
            $fileLaden = mb_split("\n", file_get_contents($Filename));  // $fileLaden = mb_split("\n", file_get_contents($Filename))

            // File wieder schliessen
            fclose($fp);

            // Array $fileSpeichern aufbereiten für zum Speichern
            // File ladenauf File Speichern schreiben
            for ($i=0; $i < count($fileLaden); $i++)  {

                // Umwandlung für - Multibyte
                $fileLadenDecodoert = mb_convert_encoding($fileLaden[$i], "UTF-8",'auto');
                // Speichern
                $fileSpeichern[$i][0] = $fileLadenDecodoert;
            }
            // Neuer Inhalt am Schluss anfügen
            $fileSpeichern[count($fileSpeichern)] = $InhaltStringToArray ;
        }
        // Annsonsten Inhalt auf erste Zeile Speichern
        else {
            $fileSpeichern[0] = $InhaltStringToArray;
        }


        // File schpeichern //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // CSV File öffnen
        $fp = fopen($Filename, $FileNeuOderErweitern); // $FileNeuOderErweitern

        // Daten in File speichern
        for ($i=0; $i < count ($fileSpeichern); $i++) {
            fputcsv($fp, $fileSpeichern[$i] ) ; // fputcsv
        }

        echo '<br>';
        echo "laden";
        echo '<br>';
        echo count ($fileLaden);
        echo '<br>';
        echo print_r($fileLaden);
        echo '<br>';
        echo '<br>';
        echo "speichern";
        echo '<br>';
        echo count ($fileSpeichern);
        echo '<br>';
        echo print_r($fileSpeichern);



        // File wieder schliessen
        fclose($fp);

    }
}


*/
