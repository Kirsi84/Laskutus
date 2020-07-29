<?php
    // Start the session
    session_start();

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
            <br><br>

            <form id="frm-upload" action="" class="form-create" method="post" 
                enctype="multipart/form-data">
                        
                <fieldset id="fieldset-first">
                   
                        <legend>1. Laskuttajan tiedot</legend>             
                                       
                        <label for="vendordata" class="label">Valitse:</label>
                        <select id="vendordata" name="vendordata" onchange="updateVendor();">
                        <option value=0 selected>Valitse laskun lähettäjä ja tilinumero</option>
                       
                        <?PHP
                            include 'updateSettings.php';
                                        
                            $settings = getAllSettings();
                            if (count($settings) > 0) {
                                foreach ($settings as $row) {   
                                    $id = $row[0];
                                    $vendornamesel = $row[1];  
                                    $accountnumbersel =  $row[2];  
                                    $vendordata = $vendornamesel . " | " .  $accountnumbersel;
                        ?>
                            
                                    <option value=<?php echo $id ?>><?php echo $vendordata ?></option> 
                                                              
                        <?php 
                                }                               
                            }                           
                        ?>
                        </select>

                        <br>
                       
                        <label for  ="vendorname" class="label">Laskuttaja:</label>
                        <input type ="text" id="vendorname" name="vendorname" class="txtBox"
                            onchange="checkFields()"                          
                            placeholder="Laskun lähettäjä"
                            required value="<?php echo $vendorname;?>">
                        <br>                  
                         
                        <!-- value of maxlength of iban account is 18 -->
                        <label for  ="accountnumber" class="label">Tilinumero:</label>
                        <input type ="text" id="accountnumber" name="accountnumber" class="txtBox"
                            onchange="checkFields()"  
                            placeholder="IBAN tilinro" maxlength="18" minlength=18 required                            
                            pattern="^[a-zA-Z0-9]*$" value="<?php echo $accountnumber;?>">
                        <br>
                    
                        <label for  ="duedate" class="label">Eräpäivä:</label>
                        <input type ="date" id="duedate" name="duedate" min="<?php echo $mindate;?>"
                            class="txtBox"
                            onchange="checkFields()"  
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
                

                  
                </fieldset>               
            
            </form>

            <script>
                
                function checkFields() {
                    let errortext = "";
                    let x = "";                    
                    x = document.getElementById("duedate");
                    if (x.value == "") {
                        errortext = "Eräpäivä on pakollinen!";
                    }

                    x = document.getElementById("accountnumber");                    
                    if (x.value == "") {
                        errortext = "Tilinumero on pakollinen!";
                    }
                    else {
                        if (isValidIBANNumber(x.value) == false) {                       
                            errortext = "Virheellinen IBAN-tilinumero!"; 
                        }
                    }
                    document.getElementById("accountnumber").value   = x.value.trim();

                    x = document.getElementById("vendorname");                    
                    if (x.value.trim() == "") {
                        errortext = "Laskun lähettäjä on pakollinen!"; 
                    }                   
                    document.getElementById("vendorname").value   = x.value.trim(); 

                    document.getElementById("checkDataErr").value = errortext;
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
                    document.getElementById("fieldset-first").style.display = "none"; 
                    document.getElementById("fieldset-second").style.display = "none"; 
                };

                function showFieldset() {
                    document.getElementById("fieldset-first").style.display = "block"; 
                    document.getElementById("fieldset-second").style.display = "block"; 
                    document.getElementById("fieldset-third").style.display = "none"; 
                };

                /*
                * Returns 1 if the IBAN is valid 
                * Returns FALSE if the IBAN's length is not as should be (for CY the IBAN Should be 28 chars long starting with CY )
                * Returns any other number (checksum) when the IBAN is invalid (check digits do not match)
                */
                function isValidIBANNumber(input) {
                    var CODE_LENGTHS = {
                        AD: 24, AE: 23, AT: 20, AZ: 28, BA: 20, BE: 16, BG: 22, BH: 22, BR: 29,
                        CH: 21, CR: 21, CY: 28, CZ: 24, DE: 22, DK: 18, DO: 28, EE: 20, ES: 24,
                        FI: 18, FO: 18, FR: 27, GB: 22, GI: 23, GL: 18, GR: 27, GT: 28, HR: 21,
                        HU: 28, IE: 22, IL: 23, IS: 26, IT: 27, JO: 30, KW: 30, KZ: 20, LB: 28,
                        LI: 21, LT: 20, LU: 20, LV: 21, MC: 27, MD: 24, ME: 22, MK: 19, MR: 27,
                        MT: 31, MU: 30, NL: 18, NO: 15, PK: 24, PL: 28, PS: 29, PT: 25, QA: 29,
                        RO: 24, RS: 22, SA: 24, SE: 24, SI: 19, SK: 24, SM: 27, TN: 24, TR: 26
                    };
                    var iban = String(input).toUpperCase().replace(/[^A-Z0-9]/g, ''), // keep only alphanumeric characters
                            code = iban.match(/^([A-Z]{2})(\d{2})([A-Z\d]+)$/), // match and capture (1) the country code, (2) the check digits, and (3) the rest
                            digits;
                    // check syntax and length
                    if (!code || iban.length !== CODE_LENGTHS[code[1]]) {
                        return false;
                    }
                    // rearrange country code and check digits, and convert chars to ints
                    digits = (code[3] + code[1] + code[2]).replace(/[A-Z]/g, function (letter) {
                        return letter.charCodeAt(0) - 55;
                    });
                    // final check
                    return mod97(digits);
                }
                function mod97(string) {
                    var checksum = string.slice(0, 2), fragment;
                    for (var offset = 2; offset < string.length; offset += 7) {
                        fragment = String(checksum) + string.substring(offset, offset + 7);
                        checksum = parseInt(fragment, 10) % 97;
                    }
                    return checksum;
                }
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
