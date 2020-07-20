<?php
    //  header('Content-Type: text/html; charset=UTF-8');
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
        if(!empty(isset($_POST["upload"]))) {
            if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {
    ?>

<form action="invoices.php" method="post">
<!-- <form action="email.php" method="post"> -->

    <fieldset>
       
        <legend>3. Laskujen ja yhteenvedon muodostus: hinta- ja lisäviestin syöttö tarvittaessa</legend>      
    
        <label for  ="vendorname" class="label">Laskuttaja:</label>
            <?php echo $vendorname;?>
        <br>
        <label for  ="accountnumber" class="label">Tilinumero:</label>
            <?php echo $accountnumber;?>
        <br>    
        <label for  ="duedate" class="label">Eräpäivä:</label>
            <?php 
            $converted = date("d.m.Y", strtotime($_SESSION['duedate']));            
            echo $converted;
            ?>
        <br>
        <label for  ="vendormessage" class="label">Laskun viesti:</label>
        <textarea id="vendormessage" name="vendormessage" rows="5" cols="40"
            readonly class="readonly"><?php echo $vendormessage;?></textarea>
        <br><br>            

        <label for  ="btn-invoices" class="label"></label>
        <input type="submit" class="btn-submit" id="btn-invoices" name="btn-billbtn-invoices" 
            value="Muodosta laskut">
        
        <br> <br>   

        <div class="container" id ="container">
        <table class="gridtable" id="customers-table">
            <thead>
                <tr class="tableheader">
                    <th>Sukunimi</th>
                    <th>Etunimi</th> 
                    <th>Sähköpostiosoite</th>   

                    <th class="hide-column">Sukunimi</th>
                    <th class="hide-column">Etunimi</th>                   
                    <th class="hide-column">Osoite</th>                   
                    <th class="hide-column">Postinumero</th>                   
                    <th class="hide-column">Postitoimipaikka</th>                    
                    <th class="hide-column">Sähköpostiosoite</th>  

                    <th>Hinta €</th>
                    <th>Lisäviesti laskulle</th>    
                </tr>
            <thead>
            <tbody>
        <?php
            $i = 0;
            while (($row = fgetcsv($fp)) !== false) {

                $class ="";
                if($i==0) {
                    $class = "header";
                }
        ?>             
               
                <tr name="datarow" class="datarow">
                    <td>
                        <?php echo $row[1]; ?>                                   
                    </td>
                    <td>
                        <?php echo $row[0]; ?>                 
                    </td>
                    <td>                    
                        <?php echo $row[5]; ?>             
                    </td>

                    <td class="hide-column">
                        <input type="text" name="lname[]" class="textinput" readonly value="<?php echo $row[1]; ?>"                                   
                    </td>

                    <td class="hide-column">
                        <input type="text" name="fname[]" class="textinput" readonly value="<?php echo $row[0]; ?>"                 
                    </td>

                    <td class="hide-column">
                        <input type="text"  name="address[]" class="textinput" readonly value="<?php echo $row[2]; ?>"                
                   </td>

                    <td class="hide-column">
                        <input type="text" name="postcode[]" class="textinput" readonly value="<?php echo $row[3]; ?>" 
                    </td>

                    <td class="hide-column">                   
                        <input type="text" name="postaldistrict[]" class="textinput" readonly value="<?php echo $row[4]; ?>"               
                    </td>                    
                   
                    <td class="hide-column">                    
                        <input type="text" name="email[]" class="textinput" readonly value="<?php echo $row[5]; ?>"             
                    </td>
                    
                    <td> 
                        <input type="number" step="any" id="price" min="0" name="price[]">
                    </td>

                    <td> 
                        <!-- <textarea id="usermessage" name="usermessage[]" class="textareagrid"></textarea>-->
                        <textarea id="usermessage" name="usermessage[]" rows="4"></textarea> 
                    </td>
                </tr>

        <?php
                $i ++;
            }   // end-while 
          
            fclose($fp);

            if (session_status() == PHP_SESSION_NONE) {
                session_start();              
            }
            $_SESSION["customercount"]  = $i; //number of customers

        ?>
            </tbody>
            </table>

        <?php
            // $response = array("type" => "success", "message" => "CSV is converted to HTML successfully");
            $response = array("type" => "success", "message" => "CSV-tiedoston konvertointi onnistui!");
            } 
            else {
               // $response = array("type" => "error", "message" => "Unable to process CSV");
                $response = array("type" => "error", "message" => "CSV-tiedoston käsittely ei onnistu!");
            }
        ?> 
        </div>
                
        <?php
            // $response = array("type" => "success", "message" => "CSV is converted to HTML successfully");
            $response = array("type" => "success", "message" => "CSV-tiedoston konvertointi onnistui!");
            } 
            else {
               // $response = array("type" => "error", "message" => "Unable to process CSV");
                $response = array("type" => "error", "message" => "CSV-tiedoston käsittely ei onnistu!");
            }
        
        ?>

        <?php if(!empty($response)) { ?>
            <div class="response <?php echo $response["type"]; ?>
                ">
                <?php echo $response["message"]; ?>
            </div>
        <?php } ?>

        </div>
    </fieldset>
</form>
</div>
</body>
</html>