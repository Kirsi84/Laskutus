<?php
    // Start the session
    session_start();
   
    // define variables and set to empty values
    include 'checkData.php';

    // file upload
    include 'upload.php';

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

                    if (opt.value == 0) {
                        document.getElementById("vendorname").value = "";   
                        document.getElementById("accountnumber").value = ""; 
                    }
                    else {
                        let str = opt.text;   
                        let res = str.split("|");
                        document.getElementById("vendorname").value = res[0].trim();   
                        document.getElementById("accountnumber").value = res[1].trim();    
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
                        <option value=0 selected>Valitse laskun lähettäjä ja tilinumero</option>
                       
                        <?PHP
                            include 'getSettings.php';                              
                           
                            if (isset($vendors)) {
                                $max = count($vendors);
                                for ($ind = 0; $ind <  $max; $ind++) {
                                    
                                    $vendornamesel = $vendors[$ind][1];  
                                    $accountnumbersel =  $vendors[$ind][2];  
                                    $vendordata = $vendornamesel . " | " .  $accountnumbersel;
                                    $id = $vendors[$ind][0];?>
                            
                                    <option value=<?php echo $id ?>><?php echo $vendordata ?></option> 
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

                        <br>                  
                         
                        <!-- value of maxlength of iban account is 18 -->
                        <label for  ="accountnumber" class="label">Tilinumero:</label>
                        <input type ="text" id="accountnumber" name="accountnumber" class="txtBox"
                            placeholder="IBAN tilinro" maxlength="18" minlength=18 required
                            pattern="^[a-zA-Z0-9]*$" value="<?php echo $accountnumber;?>">
                        <br>
                    
                        <label for  ="duedate" class="label">Eräpäivä:</label>
                        <input type ="date" id="duedate" name="duedate" class="txtBox" required value="<?php echo $duedate;?>">
       
                        <br>
 
                        <label for  ="vendormessage" class="label">Laskun viesti:</label>  
                        <textarea id="vendormessage" name="vendormessage" rows="2" cols="40"><?php echo $vendormessage;?></textarea>
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
                    document.getElementById("duedate").value = "";                 
                    document.getElementById("vendormessage").value = ""; 
                    document.getElementById("checkDataErr").value = ""; 

                    "<?php resetSession()?>";                   
                }
            </script>

            <?php if(!empty($response)) { ?>
              
                <?php      
                    if ($response["type"] == "success") {
                      //  $_SESSION["vendordata"]    = $_POST['vendordata'];
                        $_SESSION["vendorname"]    = $_POST['vendorname'];
                        $_SESSION["duedate"]       = $_POST['duedate'];
                        $_SESSION["accountnumber"] = $_POST['accountnumber'];
                        $_SESSION["vendormessage"] = $_POST['vendormessage'];
                      
                        include 'customers.php';
                    }                    
                ?>
            <?php }?>

        </div> 
    </body>
</html>
