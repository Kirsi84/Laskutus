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

      // remove all session variables
    function resetSession(){      
       session_unset();
    }  

      //include "logWriting.php";

?>

<!DOCTYPE html>
<html>

    <?php
        include 'head.php';
    ?>

    <body>  
        <script>
                function updateVendor() {                    
                    let sel = document.getElementById('vendordata');                   
                    let opt = sel.options[sel.selectedIndex]; 
                    // console.log("opt.value: " + opt.value);
                    if (opt.value == 0) {
                        document.getElementById("vendorname").value = "";   
                        document.getElementById("accountnumber").value = ""; 
                    }
                    else {
                        let str = opt.text;   
                        let res = str.split("|");
                        document.getElementById("vendorname").value = res[0];   
                        document.getElementById("accountnumber").value = res[1];    
                    }
                }
        </script>     
   
        <div class="main">
            <?php   
               include 'navbar.php';
            ?>    

            <br><br>

            <form id="frm-upload" action="" class="form-create" method="post" 
                enctype="multipart/form-data">
                        
                <fieldset>                   
                        <legend>1. Laskuttajan tiedot</legend>             
                                             
                        <label for="vendordata" class="label">Valitse:</label>
                        <select id="vendordata" name="vendordata" onchange="updateVendor();">
                        <option value=0 selected>Valitse laskun lähettäjä ja tilinumero</option>"
                        <?PHP
                            include 'getSettings.php';                              
                           
                            if (isset($vendors)) {
                                $max = count($vendors);
                                for ($ind = 0; $ind <  $max; $ind++) {
                                    
                                    $vendorname = $vendors[$ind][1];  
                                    $accountnumber =  $vendors[$ind][2];  
                                    $vendordata = $vendorname . " | " .  $accountnumber;
                                    $id = $vendors[$ind][0];                        ?>
                            
                                    <option value=<?php echo $id ?> >  
                                        <?php echo $vendordata ?>
                                    </option> 
                        <?php 
                                }
                            }
                           
                            ?>
                        </select>

                        <br>
                       
                        <label for  ="vendorname" class="label">Laskuttaja:</label>
                        <input type ="text" id="vendorname" name="vendorname" class="txtBox"                          
                            placeholder="Laskun lähettäjä"
                            required value="<?php echo $vendorname;?>">                     
                         
                        <!-- value of maxlength of iban account is 18 -->
                        <label for  ="accountnumber" class="label">Tilinumero:</label>
                        <input type ="text" id="accountnumber" name="accountnumber" class="txtBox"
                            placeholder="IBAN tilinro" maxlength="18" required value="<?php echo $accountnumber;?>">
                        <br>
                    
                        <label for  ="duedate" class="label">Eräpäivä:</label>
                        <input type ="date" id="duedate" name="duedate" class="txtBox" required value="<?php echo $duedate;?>">
                        <br>
 
                        <label for  ="message" class="label">Laskun viesti:</label>  
                        <textarea id="message" name="message" rows="2" cols="40"><?php echo $message;?></textarea>
                        <br>

                        <label for  ="refnumber" class="label">Viitenumero:</label>
                        <input type ="text" id="refnumber" name="refnumber" class="txtBox-read" readonly
                            value="<?php echo $refnumber;?>">
                        <br>

                        <label for  ="button-clear" class="label"></label>
                        <input type="button" id="button-clear" onclick="resetForm()"  class="btn-submit" value="Tyhjennä">
                          
                        <br>

                        <label for  ="checkDataErr" class="label"></label>
                        <input type ="text" id="checkDataErr" name="checkDataErr"  class="txtBox" readonly
                            value="<?php echo $checkDataErr;?>">

                </fieldset>
            
                <fieldset>
                   
                        <legend>2. Valitse ja lataa asiakastiedosto (csv):</legend>       


                        <input type="file" class="file-input" name="file-input">             
                        <!-- <input type="file" class="file-input" name="file-input" value=" -->
                        <?php
                            // if (isset($fileinput)) {
                            //     echo $fileinput;
                            // }
                            // else {
                            //     $fileinput = "";
                            // }                        
                        ?>
                        <!-- "> -->
                        
                        <input type="submit" class="btn-submit" id="upload" name="upload"
                             value="Lataa tiedosto">

                        <?php if(!empty($response)) { ?>
                        <div class="response <?php echo $response["type"]; ?>
                            ">
                        <?php echo $response["message"]; ?>
                    </div>
               
                    <?php }?>                   
                
                </fieldset>
               
            
            </form>

            <script>
                function resetForm() {               
                    document.getElementById("vendordata").value = 0;  
                    document.getElementById("vendorname").value = "";   
                    document.getElementById("accountnumber").value = ""; 

                    document.getElementById("refnumber").value = ""; 
                    document.getElementById("duedate").value = ""; 
                    document.getElementById("message").value = ""; 
                    document.getElementById("checkDataErr").value = ""; 
                 
                    "<?php resetSession()?>";                   
                }
            </script>

            <?php if(!empty($response)) { ?>
              
                <?php      
                    if ($response["type"] == "success") {
                        $_SESSION["vendordata"]    = $_POST['vendordata'];
                        $_SESSION["vendorname"]    = $_POST['vendorname'];
                        $_SESSION["duedate"]       = $_POST['duedate'];
                        $_SESSION["accountnumber"] = $_POST['accountnumber'];
                        $_SESSION["message"]       = $_POST['message'];
                     
                        log_writing("jees: " . $_POST['vendordata']);
                        if (isset($_SESSION['refnumber']))  {     
                            echo "Session variables are set:" . $_SESSION["refnumber"] ;
                        }

                        include 'customers.php';
                    }                    
                ?>
            <?php }?>

        </div> 
    </body>
</html>
