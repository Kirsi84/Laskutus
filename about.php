
<?php
    include 'getFilePath.php';
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
                    <li>Laskujen muodostus csv-tiedostosta</li>
                    <li>Laskun hinnan ja lisätiedon syöttäminen tarvittaessa</li>
                    <li>Pdf-laskujen muodostaminen</li>
                    <li>Asetustietorivin lisääminen, tallennus työaseman
                    asetustiedostoon ja poistaminen asetustiedoista</li>
                    <li>Oletushakemiston puuttuessa ohjelma generoi
                    uuden hakemistopolun työasemaan niin halutessasi (valitaan täppä ensimmäisellä kerralla)</li>
                    <li>Asetustiedosto tallennetaan työasemaan oletushakemistoon:
                    <?php
                        echo " " . getDefaultFilepath() . ".";
                    ?>
                    </li>

                </ul> 

                <br>
                Versio 1.0 
                <br>
                18.7.2020
           
            </fieldset>
        <div>
    </body>
</html>