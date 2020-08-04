<?php   
    $configs = include('config.php');
    $csvDelimiter =  $configs['defaultCSVDelimiter'];

    if (session_status() == PHP_SESSION_ACTIVE) {       
        session_unset();   // remove all session variables       
        session_destroy();      // destroy the session     
    }
?>

<!DOCTYPE html>
<html>

    <?php
        include 'head.php';
    ?>
    <body>  
       
        <div class="main">
            <?php   
               include 'navbar.php';
            ?> 
            <br> <br><br>
            <fieldset>
          
                <h2>Yhdistyksen laskujen muodostus</h2>
                <ul>
                    <li>Laskuttajan nimen, tilinumeron, eräpäivän ja laskun viestin syöttäminen</li> 
                    <li>Laskujen muodostus csv-tiedostosta ja syötetyistä tiedoista</li>
                    <li>Laskun hinnan ja lisätiedon syöttäminen tarvittaessa</li>
                    <li>Pdf-laskujen muodostaminen</li>
                    <li>Sähköpostien lähetys, jossa liitteenä lasku</li>
                    <li>Sähköpostien lähetys on käytettävissä, mikäli palvelimen sähköpostiasetukset 
                    on määritetty palvelimen konfiguraatiotiedostossa</li>
                    <li>Asetukset välilehti:
                    <br>
                    - asetustiedoston haku työaseman tiedostojärjestelmästä <br>
                    - asetustietorivin lisääminen ja poisto <br>
                    - asetustiedoston tallennus työaseman tiedostojärjestelmään <br>
                    
                    </li>
                    <li>
                    CSV-tiedostojen erotinmerkki on: <?php echo $csvDelimiter ?>
                    </li>
                    <li>
                    CSV-tiedostojen erotinmerkki asetetaan konfiguraatiotiedostossa. 
                    </li> 
                </ul>  

                <br>
                Versio 1.11 
                <br>
                4.8.2020
           
            </fieldset>

           
        <div>
    </body>
</html>