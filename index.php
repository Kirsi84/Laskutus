<?php

    $configs = include('config.php');
    $csvDelimiter =  $configs['defaultCSVDelimiter'];
    $csvSize =  $configs['defaultCSVSize'];
    $environment =  $configs['environment'];  
    if ($environment == "TEST")  {
        error_reporting(E_ALL); // in test environment show all the errors   
    }
    else {
        error_reporting(0); // in production not showing when zero
    }

    if (session_status() == PHP_SESSION_ACTIVE) {       
        session_unset();   // remove all session variables       
       // session_destroy();      // destroy the session     
    }
    // Start the session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();              
    }

    $mindate = date("Y-m-d");
    
    // define variables and set to empty values
    include 'checkData.php';

    // file upload
    include 'upload.php';    

    // remove all session variables
    function resetSession(){      
       session_unset();       
    }
  
    
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
           
            <br> <br>
            <form id="frm-upload-settings" action="" class="form-create" method="post" 
                enctype="multipart/form-data">
                <fieldset id="fieldset-zero">
                    <label for="file-input-settings" >Valitse ja hae asetustiedosto (.csv):</label>
                    <br><br>
                    <input type="file" class="file-input" id="file-input-settings" name="file-input-settings" >
                    <input type="submit" class="btn-submit" id="upload-settings" name="upload-settings"
                    value="Asetusten haku">
                              
                </fieldset>                  
            </form>

            <form id="frm-upload" action="" class="form-create" method="post" 
                enctype="multipart/form-data">
                        
                <fieldset id="fieldset-first">
                   
                        <legend>1. Laskuttajan tiedot</legend>                                              
                        <br>

                        <label for="vendordata" class="label">Asetus:</label>
                        <select id="vendordata" name="vendordata" onchange="updateVendor();">
                        <option value=0 selected>Valitse laskun lähettäjä ja tilinumero</option>

                        <?php

                            include 'uploadSettings.php';
                                                     
                            if(!empty(isset($_POST["upload-settings"]))) {

                              if ($responseSettings["type"] == "success") {
                              
                                if (($fps = fopen($_FILES["file-input-settings"]["tmp_name"], "r")) !== FALSE) {
                                
                                    $id = 1;
                                   // while (($row = fgetcsv($fps)) !== false) {
                                    while (($row = fgetcsv($fps, $csvSize, $csvDelimiter)) !== false) {    
                                        
                                        $vendornamesel = $row[1];  
                                        $accountnumbersel =  $row[2];  
                                        $vendordata = $vendornamesel . " | " .  $accountnumbersel;
                                        
                                        ?>                                
                                        <option value=<?php echo $id ?>><?php echo $vendordata ?></option>                                                                
                                        <?php 
                                        $id ++;
                                    }   
                                    fclose($fps);  ?>
                                     <script>document.getElementById("fieldset-zero").style.display = "none";</script>
                                <?php   
                                }
                              }                                                     
                            }                                      
                        ?>
                    </select>
                    <br>
                       
                        <label for  ="vendorname" class="label">Laskuttaja:</label>
                        <input type ="text" id="vendorname" name="vendorname" class="txtBox"
                            onchange="checkVendorname()"                          
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
                        <input type ="date" id="duedate" name="duedate" min="<?php echo $mindate;?>"
                            class="txtBox"
                            onchange="checkDuedate()"  
                            required value="<?php echo $duedate;?>">        
                        <br>
 
                        <label for  ="vendormessage" class="label">Laskun viesti:</label>  
                        <textarea id="vendormessage" name="vendormessage" rows="5" cols="40"><?php echo $vendormessage;?></textarea>
                        <br>
                        
                        <label for  ="button-clear" class="label"></label>
                        <input type="button" id="button-clear" onclick="resetForm()"  class="btn-submit" value="Tyhjennä">
                          
                        <br>

                        <label for  ="checkDataErr" class="label"></label>
                        <input type ="text" id="checkDataErr" name="checkDataErr"  class="txtBox" readonly
                            value="<?php echo $checkDataErr;?>">

                        <?php if(!empty($responseSettings)) { ?>
                        <div class="response <?php echo $responseSettings["type"]; ?>
                            ">
                            <?php echo $responseSettings["message"]; ?>
                        </div>               
                        <?php }?>
                   
                </fieldset>
            
                <fieldset id="fieldset-second">
                                 
                        <legend>2. Valitse ja lataa asiakastiedosto (csv):</legend>       

                        <input type="file" class="file-input" id="file-input" name="file-input" onclick="checkFields()">             
                                                
                        <input type="submit" class="btn-submit" id="upload" name="upload"
                             value="Lataa tiedosto">

                        <?php if(!empty($response)) { ?>
                            <div class="response <?php echo $response["type"]; ?>
                                ">
                                <?php echo $response["message"]; ?>
                            </div>               
                        <?php }?>

                        <?php if(!empty($responseSettings)) { ?>
                            <div class="response <?php echo $responseSettings["type"]; ?>
                                ">
                                <?php echo $responseSettings["message"]; ?>
                            </div>               
                        <?php }?>

                </fieldset> 
                <br>  
            </form>

            <script> 
                function checkFields() {                   
                    if (checkVendorname()) {
                        if ( checkAccountnumber()) {
                            if  (checkDuedate()) {
                            }
                        }
                    }                               
                }
                function checkVendorname() {
                    let ret = true;
                    let errortext = "";
                    let x = ""; 
                    x = document.getElementById("vendorname");                    
                    if (x.value.trim() == "") {
                        errortext = "Laskun lähettäjä on pakollinen!";
                        ret = false; 
                    }                   
                    document.getElementById("vendorname").value   = x.value.trim();
                    document.getElementById("checkDataErr").value = errortext;
                    return ret;
                }

                function checkAccountnumber() {
                    let ret = true;
                    let errortext = "";                  
                    let x = ""; 
                    x = document.getElementById("accountnumber");                    
                    if (x.value.trim() == "") {
                        errortext = "Laskun tilinumero on pakollinen!"; 
                        ret = false;
                    }                   
                    document.getElementById("accountnumber").value   = x.value.trim();
                    document.getElementById("checkDataErr").value = errortext;
                    return ret;
                }

                function checkDuedate() {
                    let ret = true;
                    let errortext = "";
                    let x = "";                    
                    x = document.getElementById("duedate");
                    if (x.value == "") {
                        errortext = "Eräpäivä on pakollinen!";
                        ret = false;
                    }
                    document.getElementById("checkDataErr").value = errortext;
                    return ret;
                }

                function resetForm() {               
                    document.getElementById("vendordata").value = 0;  
                    document.getElementById("vendorname").value = "";   
                    document.getElementById("accountnumber").value = ""; 
                    document.getElementById("duedate").value = "";               
                    document.getElementById("vendormessage").value = ""; 
                    document.getElementById("checkDataErr").value = ""; 

                    "<?php resetSession()?>";

                    showFieldset();                   
                }

                function hideFieldset() {
                    document.getElementById("fieldset-zero").style.display = "none"; 
                    document.getElementById("fieldset-first").style.display = "none"; 
                    document.getElementById("fieldset-second").style.display = "none"; 
                };

                function showFieldset() {
                    document.getElementById("fieldset-zero").style.display = "block"; 
                    document.getElementById("fieldset-first").style.display = "block"; 
                    document.getElementById("fieldset-second").style.display = "block"; 
                    document.getElementById("fieldset-third").style.display = "none"; 
                };
                
            </script>

            <?php if(!empty($response)) { ?>
              
                <?php  
                    if ($checkDataErr == "") {                
                        if ($response["type"] == "success") {

                            $_SESSION["vendorname"]    = $_POST['vendorname'];
                            $_SESSION["duedate"]       = $_POST['duedate'];
                            $_SESSION["accountnumber"] = $_POST['accountnumber'];
                            $_SESSION["vendormessage"] = $_POST['vendormessage'];

                            echo '<script type="text/javascript">','hideFieldset();', '</script>'
                            ;
                            include 'customers.php';
                        }  
                }                  
                ?>
            <?php }?>

        </div> 
    </body>
</html>
