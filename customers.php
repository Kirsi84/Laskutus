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
        ?>
 
<?php

    if(!empty(isset($_POST["upload"]))) {
        if (($fp = fopen($_FILES["file-input"]["tmp_name"], "r")) !== FALSE) {
?>


<form action="invoices.php" method="post">

    <fieldset class="fieldset-create">
       
        <legend>3. Laskujen ja yhteenvedon muodostus: hinta- ja lisäviestin syöttö tarvittaessa</legend>      
        

        <input type="submit" class="btn-submit" id="btn-invoices" name="btn-billbtn-invoices" 
            value="Muodosta laskut">

        
        <br>  <br>

        <div class="container" id ="container">
        <table class="gridtable" id="tableMain">
            <thead>
                <tr class="tableheader">      
                    <th>Sukunimi</th>
                    <th>Etunimi</th> 
                    <th>Osoite</th>
                    <th>Postinumero</th>
                    <th>Postitoimipaikka</th>
                    <th>Sähköpostiosoite</th>      
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
                        <input type="text" name="lname[]" class="textinput" readonly value="<?php echo $row[1]; ?>"                    
                   </td>

                    <td>
                        <input type="text" name="fname[]" class="textinput" readonly value="<?php echo $row[0]; ?>"                 
                    </td>

                    <td>
                        <input type="text" name="address[]" class="textinput" readonly value="<?php echo $row[2]; ?>"                
                   </td>

                    <td>
                        <input type="text" name="postcode[]" class="textinput" readonly value="<?php echo $row[3]; ?>" 
                    </td>

                    <td>                   
                        <input type="text" name="postaldistrict[]" class="textinput" readonly value="<?php echo $row[4]; ?>"               
                    </td> 

                    <td>                    
                        <input type="text" name="email[]" class="textinput" readonly value="<?php echo $row[5]; ?>"             
                    </td>
                    
                    <td> 
                        <input type="number" step="any" id="price" name="price[]">
                    </td>

                    <td> 
                        <!-- <textarea id="usermessage" name="usermessage[]" class="textareagrid"></textarea>-->
                        <textarea id="usermessage" name="usermessage[]"></textarea> 
                    </td>
                </tr>
            <?php
                $i ++;
            }
        
          
            fclose($fp);

            if (session_status() == PHP_SESSION_NONE) {
                session_start();              
            }
            $_SESSION["customercount"]  = $i; //number of customers

            ?>
            </tbody>
            </table>
        </div>

        
        <?php
            $response = array("type" => "success", "message" => "CSV is converted to HTML successfully");
            } else {
                $response = array("type" => "error", "message" => "Unable to process CSV");
            }
        }
        ?>
        </div>
        <?php if(!empty($response)) { ?>
        <div class="response <?php echo $response["type"]; ?>
            ">
            <?php echo $response["message"]; ?>
        </div>
        <?php } ?>
      
        </fieldset>
</form>

</div>

</body>
</html>