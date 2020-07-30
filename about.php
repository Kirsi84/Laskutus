
<?php
    include 'filePath.php';
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

                    <li>Oletushakemiston luonti työasemaan niin halutessasi (valitse täppä ensimmäisellä kerralla)</li>                    
                    <li>Asetustietorivin lisääminen ja poisto työaseman
                    asetustiedostoon</li>
                    <li>Asetustiedosto tallennetaan työasemaan oletushakemistoon:
                    <?php
                        echo " " . getDefaultFilepath() . ".";                       
                    ?>
                    </li>

                </ul> 

                <br>
                Versio 1.6 
                <br>
                30.7.2020
           
            </fieldset>

           
        <div>
    </body>
</html>