<?php

    // Start the session
    session_start();

    // file upload
    include 'upload.php';

    // define variables and set to empty values
    include 'checkData.php';

    if (isset($_POST["upload"])) {
      require_once "getReferenceNumber.php";
      $_SESSION["refnumber"] =  $refnumber;
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
    
            <form id="frm-upload" action="" method="post"
                enctype="multipart/form-data">
                        
                <fieldset>
                    <div class="maindiv">
                        <legend>1. Laskuttajan tiedot</legend>             

                        <br>

                        <label for  ="name" class="lbTitle">Laskun lähettäjä:</label>
                        <input type ="text" id="name" name="name" class="txtBox" required value="<?php echo $name;?>">
                        <br>

                        <label for  ="duedate" class="lbTitle">Eräpäivä:</label>
                        <input type ="date" id="duedate" name="duedate" class="txtBox" required value="<?php echo $duedate;?>">
                        <br>

                        <!-- value of maxlength of iban account is 18 -->
                        <label for  ="accountnumber" class="lbTitle">Tilinumero:</label>
                        <input type ="text" id="accountnumber" name="accountnumber" class="txtBox"
                            placeholder="IBAN tilinro" maxlength="18" required value="<?php echo $accountnumber;?>">
                        <br>

                        <label for  ="message" class="lbTitle">Laskun viesti:</label>  
                        <textarea id="message" name="message" rows="2" cols="40"><?php echo $message;?></textarea>
                        <br>

                        <label for  ="refnumber" class="lbTitle">Viitenumero:</label>
                        <input type ="text" id="refnumber" name="refnumber" class="txtBox" readonly
                            value="<?php echo $refnumber;?>">
                        <br>
                        
                        <label for  ="error" class="lbTitle"></label>
                        <input type ="text" id="errorInput" name="error"  class="txtBox" readonly
                            value="<?php echo $checkDataErr;?>">

                    </div>
                </fieldset>
            
                <fieldset>
                    <div>
                        <legend>2. Valitse ja lataa asiakastiedosto (csv):</legend>       
                        <br>
                      
                        <input type="file" class="file-input" name="file-input" value="<?php echo $fileinput;?>">
                        
                        <input type="submit" class="btn-submit" id="upload" name="upload"
                             value="Lataa tiedosto">

                        <?php if(!empty($response)) { ?>
                        <div class="response <?php echo $response["type"]; ?>
                            ">
                        <?php echo $response["message"]; ?>
                    </div>
               
                    <?php }?>
                    
                    </div>
              
                </fieldset>
        
            </form>

            <?php if(!empty($response)) { ?>
              
                <?php      
                    if ($response["type"] == "success") {
                     
                        $_SESSION["name"]          = $_POST['name'];
                        $_SESSION["duedate"]       = $_POST['duedate'];
                        $_SESSION["accountnumber"] = $_POST['accountnumber'];
                        $_SESSION["message"]       = $_POST['message'];
                     
                        echo "Session variables are set:" . $_SESSION["refnumber"] ;

                        include 'customers.php';
                    }                    
                ?>
            <?php }?>

        </div> 
    </body>
</html>
