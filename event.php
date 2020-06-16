<?php
    // file upload
    include 'upload.php';

    // define variables and set to empty values
    include 'checkData.php';
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
        </div>      
        <br>
    
        <form id="frm-upload" action="" method="post"
            enctype="multipart/form-data">
                     
            <fieldset class="sidebyside">
                <div class="fsdiv">
                    <legend>Laskuttajan tiedot</legend>             

                    <label for  ="name" class="lbTitle">Laskun lähettäjä:</label>
                    <input type ="text" id="name" name="name" class="txtBox" required value="<?php echo $name;?>">
                    <br>
                    <label for  ="duedate" class="lbTitle">Eräpäivä:</label>
                    <input type ="date" id="duedate" name="duedate" required value="<?php echo $duedate;?>">
                   
                    <label for  ="accountnumber" class="lbTitleMin">Tilinumero:</label>

                    <!-- value of maxlength of iban account is 18 -->
                    <input type ="text" id="accountnumber" name="accountnumber" placeholder="IBAN tilinro"
                        maxlength="18" required value="<?php echo $accountnumber;?>">
                    <br>

                    <label for  ="message" class="lbTitle">Laskun viesti:</label>  
                    <textarea id="message" name="message" rows="2" cols="40"><?php echo $message;?></textarea>
                
                    <label for  ="error" class="lbTitle"></label>
                    <input type ="text" id="errorInput" name="error"  class="txtBox" readonly
                         value="<?php echo $checkDataErr;?>">
                
                   
                </div>
            </fieldset>
        
            <fieldset class="sidebyside">
                <div class="fsdiv">
                    <legend>Valitse asiakastiedosto (csv):</legend>       
                    <br>
                    <input type="file" class="file-input" name="file-input" value="<?php echo $fileinput;?>">
                    <input type="submit" id="btn-submit" name="upload" value="Upload">

                    <br>

                    <label for  ="refnumber" class="lbTitle">Viitenumero:</label>
                    <br>
                    <input type ="text" id="refnumber" name="refnumber" class="txtBox" readonly
                        value="<?php echo $refnumber;?>">
                      
                </div>
  
            </fieldset>
     
        </form>

        <?php if(!empty($response)) { ?>
            <div class="response <?php echo $response["type"]; ?>
                ">
                <?php echo $response["message"]; ?>
            </div>
    
            <?php

                if ($response["type"] == "success") {
                    include 'customerlist.php';
                }                    
            ?>
        <?php }?>
    </body>
</html>
